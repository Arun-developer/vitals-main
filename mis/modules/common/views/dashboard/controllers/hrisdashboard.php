<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Hrisdashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';
        $this->load->model('Mhrisdashboard');
        $this->load->model('scouting/Minnovation');
        $this->load->model('common/Minnovation_reports');
        error_reporting(0);
    }

    public function index($year = null)
    {

        /*** For showing current year ***/
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y') - 1;
        $data['defaultyearly'] = $year;

        /***** Top Five Employes taking Leave **/
        $topLeave = $data['topLeave'] = $this->Mhrisdashboard->gettotalEmployeeLeave($year);
        $data['empid'] = $empid = $topLeave[0]['emp_number'];
        $toparearecord = $this->Mhrisdashboard->getareareport($year);
        $data['areaid'] = $areaid = $toparearecord[0]['areaid'];
        $topprojectrecord = $this->Mhrisdashboard->getprojectreport($year);
        $data['projectid'] = $projectid = $topprojectrecord[0]['project_id'];

        /**** End ***/
        /***** Top  Leave taken by employee **/
        $data['typeLeave'] = $this->Mhrisdashboard->getemployeeLeaveType($year, $empid);
        $data['areaReport'] = $this->Mhrisdashboard->getareareport($year);
        $data['projectReport'] = $this->Mhrisdashboard->getprojectreport($year);
        $data['areaemployeehour'] = $this->Mhrisdashboard->getareaEmployeeHour($year, $areaid);
        $data['projectemployeehour'] = $this->Mhrisdashboard->getprojectEmployeeHour($year, $projectid);

        /**** End ***/

        /**** Chart ****/
        $posttextname = "";
        $this->employeeleavechart($data['topLeave']);
        $this->emptypeleavechart($data['typeLeave'], $posttextname);
        $this->areawisechart($data['areaReport'], $posttextname);
        $this->areaemployeewisechart($data['areaemployeehour']);
        $this->projectchart($data['projectReport']);
        $this->projectemployeechart($data['projectemployeehour']);
        /*** End ***/
        /***** Pop up report ***/

        /***** End ****/

        $data['cpage'] = 'hrisdashboard';
        $data['cpagetitle'] = 'Hris Dashboard';
        $this->load->view('../dashboard_template', $data);
    }

    public function yearsearch($year = null)
    {

        /*** For showing current year ***/
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = $_REQUEST['year'];
        /***** Top Five Employes taking Leave **/
        $data['topLeave'] = $this->Mhrisdashboard->gettotalEmployeeLeave($year);
        /**** End ***/
        if ($_POST['textname'] != '') {
            $posttextname = $_POST['textname'];

        }

        if ($_POST['empid'] != '') {
            $empid = $_POST['empid'];
        } else {
            $topLeave = $data['topLeave'] = $this->Mhrisdashboard->gettotalEmployeeLeave($year);
            $empid = $topLeave[0]['emp_number'];
            $posttextname = "";
        }

        if ($_POST['areaid'] != '') {
            $areaid = $_REQUEST['areaid'];
        } else {
            $toparearecord = $this->Mhrisdashboard->getareareport($year);
            $areaid = $toparearecord[0]['areaid'];
            $posttextname = "";
        }

        if ($_POST['projectid'] != '') {
            $projectid = $_REQUEST['projectid'];
        } else {
            $topprojectrecord = $this->Mhrisdashboard->getprojectreport($year);
            $projectid = $topprojectrecord[0]['project_id'];
            $posttextname = "";
        }

        $data['defaultyearly'] = $year;

        /***** Top  Leave taken by employee **/
        $data['typeLeave'] = $this->Mhrisdashboard->getemployeeLeaveType($year, $empid);
        $data['areaReport'] = $this->Mhrisdashboard->getareareport($year);
        $data['projectReport'] = $this->Mhrisdashboard->getprojectreport($year);

        $data['areaemployeehour'] = $this->Mhrisdashboard->getareaEmployeeHour($year, $areaid);

        $data['projectemployeehour'] = $this->Mhrisdashboard->getprojectEmployeeHour($year, $projectid);

        /**** End ***/

        /**** Chart ****/
        $this->employeeleavechart($data['topLeave']);

        $this->emptypeleavechart($data['typeLeave'], $posttextname);
        $this->areawisechart($data['areaReport']);
        $this->areaemployeewisechart($data['areaemployeehour'], $posttextname);
        $this->projectchart($data['projectReport']);
        $this->projectemployeechart($data['projectemployeehour'], $posttextname);
        /*** End ***/

        $data['cpage'] = 'hrisdashboard';
        $data['cpagetitle'] = 'Hris Dashboard';
        $this->load->view('../template_plain', $data);
    }

    public function employeeleavechart($employeewise = array())
    {

        $chart = '<chart bgcolor="#fbfbfb" caption="Employee Total Leave Analysis" subcaption="Overall" showPercentValues="1" decimals="1" baseFontSize="11">';
        foreach ($employeewise as $row):
            $chart .= '<set label="' . $row['emp_name'] . '" value="' . $row['totalleave'] . '"/>';
        endforeach;
        $chart .= '<styles>

                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/employeeleavebar.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }

    public function emptypeleavechart($employeewise = array(), $employee)
    {

        if ($employee != '') {
            $emp = $employee;
        } else {
            $emp = $employeewise[0]['emp_name'];
        }
        $chart = '<chart bgcolor="#fbfbfb" caption="' . $emp . ' Leave  Types" showPercentValues="1" decimals="1" baseFontSize="11">';
        foreach ($employeewise as $row):
            $chart .= '<set label="' . $row['leave_type_name'] . '" value="' . $row['totalleave'] . '"/>';
        endforeach;
        $chart .= '<styles>

						  <definition>
						  <style type="font" name="captionFont" size="15"/>
						  </definition>
						  <application>
						  <apply toObject="CAPTION" styles="captionFont"/>
						  </application>
						  </styles>
						  </chart>';
        $fh = fopen("source/charts/data/emptypeleavetypebar.xml", "w");

        fwrite($fh, $chart);
        fclose($fh);
    }

    public function areawisechart($area = array())
    {

        $year = '2012';

        $chart = '<chart bgcolor="#fbfbfb" caption="Area Wise" yAxisName="Hours" subcaption="Overall" showPercentValues="1" decimals="1" baseFontSize="11">';

        foreach ($area as $row):
            $chart .= '<set label="' . $row['area_name'] . '" value="' . $row['total'] . '"/>';
        endforeach;
        $chart .= '<styles>

                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/areawisebar.xml", "w");

        fwrite($fh, $chart);
        fclose($fh);
    }

    public function areaemployeewisechart($areaEmp = array(), $area)
    {
        if ($area != '') {
            $areaname = $area;
        } else {
            $areaname = $areaEmp[0]['area_name'];
        }

        $year = '2012';

        $chart = '<chart bgcolor="#fbfbfb" caption="Employee Wise(' . $areaname . ')" yAxisName="Hours"  showPercentValues="1" decimals="1" baseFontSize="11">';

        foreach ($areaEmp as $row):
            $chart .= '<set label="' . $row['emp_firstname'] . '" value="' . ceil($row['total']) . '"/>';
        endforeach;
        $chart .= '<styles>

                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/areaemployeewisebar.xml", "w");

        fwrite($fh, $chart);
        fclose($fh);
    }

    public function projectchart($project = array())
    {

        $year = '2012';

        $chart = '<chart bgcolor="#fbfbfb" caption="Project Wise" yAxisName="Hours" subcaption="Overall" showPercentValues="1" decimals="1" baseFontSize="11">';

        foreach ($project as $row):
            $chart .= '<set label="' . $row['work_name'] . '" value="' . ceil($row['total']) . '"/>';
        endforeach;
        $chart .= '<styles>

                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/projectwisebar.xml", "w");

        fwrite($fh, $chart);
        fclose($fh);
    }

    public function projectemployeechart($projectEmp = array(), $projectname)
    {

        if ($projectname != '') {
            $project = $projectname;
        } else {
            $project = $projectEmp[0]['work_name'];
        }

        $year = '2012';

        $chart = '<chart bgcolor="#fbfbfb" caption="Employee Wise(' . $project . ')" yAxisName="Hours" showPercentValues="1" decimals="1" baseFontSize="11">';

        foreach ($projectEmp as $row):
            $chart .= '<set label="' . $row['emp_firstname'] . '" value="' . ceil($row['total']) . '"/>';
        endforeach;
        $chart .= '<styles>

                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/projectemployeewisebar.xml", "w");

        fwrite($fh, $chart);
        fclose($fh);
    }

    public function viewleavewisereport($year)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y') - 1;
        $data['defaultyearly'] = $year;
        $data['leaveList'] = $this->Mhrisdashboard->gettotalEmployeeLeave($year);

        $data['cpage'] = 'viewleavewise';
        $data['cpagetitle'] = 'Employee Leave';
        $this->load->view('../template_plain', $data);
    }

    public function viewleavetypewisereport($year, $empid)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y') - 1;
        $data['defaultyearly'] = $year;
        $data['typeLeave'] = $this->Mhrisdashboard->getemployeeLeaveType($year, $empid);

        $data['cpage'] = 'viewleavetypewise';
        $data['cpagetitle'] = 'Leave Type';
        $this->load->view('../template_plain', $data);
    }

    public function viewareawisereport($year)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y') - 1;
        $data['defaultyearly'] = $year;
        $data['areaReport'] = $this->Mhrisdashboard->getareareport($year);
        $data['cpage'] = 'viewareawise';
        $data['cpagetitle'] = 'Area Wise';
        $this->load->view('../template_plain', $data);
    }

    public function viewareaemployeewisereport($year, $areaid)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y') - 1;
        $data['defaultyearly'] = $year;
        $data['areaemployee'] = $this->Mhrisdashboard->getareaEmployeeHour($year, $areaid);
        $data['cpage'] = 'viewareaemployeewise';
        $data['cpagetitle'] = 'Area Wise';
        $this->load->view('../template_plain', $data);
    }

    public function viewprojectwisereport($year)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y') - 1;
        $data['defaultyearly'] = $year;
        $data['projectReport'] = $this->Mhrisdashboard->getprojectreport($year);

        $data['cpage'] = 'viewprojectwise';
        $data['cpagetitle'] = 'Project Wise';
        $this->load->view('../template_plain', $data);
    }

    public function viewprojectemployeewisereport($year, $projectid)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y') - 1;
        $data['defaultyearly'] = $year;
        $data['projectemp'] = $this->Mhrisdashboard->getprojectEmployeeHour($year, $projectid);

        $data['cpage'] = 'viewprojectemployeewise';
        $data['cpagetitle'] = 'Employee Wise';
        $this->load->view('../template_plain', $data);
    }

}
