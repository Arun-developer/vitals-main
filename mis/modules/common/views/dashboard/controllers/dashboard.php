<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';
        $this->load->model('Mdashboard');
        $this->load->model('scouting/Minnovation');
        $this->load->model('common/Minnovation_reports');
    }
    public function index($year = null)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y');
        $data['defaultyearly'] = $year;
        $data['sourcewise'] = $this->Mdashboard->getsourcewise($year);
        $data['employeewise'] = $this->Mdashboard->getemployeewise($year);
        $this->employeechart($data['employeewise']);
        $data['serviceoffering'] = array_pop($this->Mdashboard->getserviceoffering($year));
        $this->serviceofferingchart($data['serviceoffering']);
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['stagewise'] = $this->Mdashboard->getstagewise();
        $this->sourcechart($data['stagewise']);
        $years = $this->Mdashboard->getsalesreportbyyear();
        $salesreport = $this->Mdashboard->getsalesreport();
        $this->saleschart($salesreport, $years);
        $data['cpage'] = 'dashboard';
        $data['cpagetitle'] = 'Dashboard';
        $this->load->view('../dashboard_template', $data);
    }

    public function yearsearch()
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = $_POST['year'];
        $data['defaultyearly'] = $year;
        $data['sourcewise'] = $this->Mdashboard->getsourcewise($year);
        $data['employeewise'] = $this->Mdashboard->getemployeewise($year);
        $this->employeechart($data['employeewise']);
        $data['serviceoffering'] = array_pop($this->Mdashboard->getserviceoffering($year));
        $this->serviceofferingchart($data['serviceoffering']);
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['stagewise'] = $this->Mdashboard->getstagewise();
        $this->sourcechart($data['stagewise']);
        $years = $this->Mdashboard->getsalesreportbyyear();
        $salesreport = $this->Mdashboard->getsalesreport();
        $this->saleschart($salesreport, $years);
        $data['cpage'] = 'dashboard';
        $data['cpagetitle'] = 'Dashboard';
        $this->load->view('../template_plain', $data);

    }
    public function viewstagewise($year)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['stagewise'] = $this->Mdashboard->getstagewise();
        $data['cpage'] = 'viewstagewise';
        $data['cpagetitle'] = 'Stage Wise';
        $this->load->view('../template_plain', $data);
    }
    public function viewemployeewise($year = null)
    {
        $data['year'] = $year;
        $data['employeewise'] = $this->Mdashboard->getemployeewise($year);
        $data['cpage'] = 'viewemployeewise';
        $data['cpagetitle'] = 'Employee Wise';
        $this->load->view('../template_plain', $data);
    }
    public function viewservicewise($year = null)
    {
        $data['year'] = $year;
        $data['serviceoffering'] = array_pop($this->Mdashboard->getserviceoffering($year));
        $data['cpage'] = 'viewservicewise';
        $data['cpagetitle'] = 'Service Wise';
        $this->load->view('../template_plain', $data);
    }
    public function viewsaleswise($year = null)
    {
        $data['years'] = $this->Mdashboard->getsalesreportbyyear();
        $data['salesreport'] = $this->Mdashboard->getsalesreport();
        $data['cpage'] = 'viewsaleswise';
        $data['cpagetitle'] = 'Service Wise';
        $this->load->view('../template_plain', $data);
    }
    public function sourcechart($stagewise = array())
    {

        $chart = '<chart bgcolor="#fbfbfb" caption="Stage Wise Analysis" subcaption="Overall" showPercentValues="1" decimals="1" baseFontSize="11">';
        foreach ($stagewise as $row):

            $chart .= '<set label="' . $row['stage'] . '" value="' . $row['value'] . '"/>';
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
        $fh = fopen("source/charts/data/sourcefunnel.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);

    }
    public function employeechart($employeewise = array())
    {
        $chart = '<chart bgcolor="#fbfbfb" caption="Employee Wise Analysis" subcaption="Overall" showPercentValues="1" decimals="1" baseFontSize="11">';
        foreach ($employeewise as $row):
            $chart .= '<set label="' . $row['emp_name'] . '" value="' . $row['total'] . '"/>';
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
        $fh = fopen("source/charts/data/employeebar.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function qualitychart($employeewise = array())
    {
        $chart = '<chart caption="Production Forecast" yAxisName="Units" bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">
                    <categories>';
        $chart .= '<category label="New"/>';
        $chart .= '<category label="Entry"/>';
        $chart .= '<category label="Lead"/>';
        $chart .= '<category label="Due-Diligence"/>';
        $chart .= '<category label="Incubation"/>';
        $chart .= '</categories>';
        $i = 1;
        foreach ($employeewise as $row):
            if ($i == 1) {
                $chart .= '<dataset seriesName="' . $row['source_type'] . '">';
            }
            $chart .= '<set value="' . $row['total_new'] . '"/>';
            $chart .= '<set value="' . $row['total_entry'] . '"/>';
            $chart .= '<set value="' . $row['total_lead'] . '"/>';
            $chart .= '<set value="' . $row['total_screening'] . '"/>';
            $chart .= '<set value="' . $row['total_incubation'] . '"/>';
            $i++;
            if ($i > php72_count($year)) {
                $i = 1;
                $chart .= '</dataset>';
            }

        endforeach;
        $chart .= '</chart>';
        $fh = fopen("source/charts/data/quality.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function employeequalitychart($employeewise = array())
    {
        $chart = '<chart caption="Production Forecast" yAxisName="Units" bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">
                    <categories>';
        $chart .= '<category label="New"/>';
        $chart .= '<category label="Entry"/>';
        $chart .= '<category label="Lead"/>';
        $chart .= '<category label="Due-Diligence"/>';
        $chart .= '<category label="Incubation"/>';
        $chart .= '</categories>';
        $i = 1;
        foreach ($employeewise as $row):
            if ($i == 1) {
                $chart .= '<dataset seriesName="' . $row['name'] . '">';
            }
            $chart .= '<set value="' . $row['total_new'] . '"/>';
            $chart .= '<set value="' . $row['total_entry'] . '"/>';
            $chart .= '<set value="' . $row['total_lead'] . '"/>';
            $chart .= '<set value="' . $row['total_screening'] . '"/>';
            $chart .= '<set value="' . $row['incubation_precentage'] . '"/>';
            $i++;
            if ($i > php72_count($year)) {
                $i = 1;
                $chart .= '</dataset>';
            }
        endforeach;
        $chart .= '</chart>';
        $fh = fopen("source/charts/data/empquality.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function employeecomparechart($employeewise = array())
    {
        $chart = '<chart bgcolor="#fbfbfb" caption="Employee Wise Analysis" subcaption="Overall" showPercentValues="1" decimals="1" baseFontSize="11">';
        foreach ($employeewise as $row):
            $chart .= '<set label="' . $row['emp_firstname'] . '" value="' . $row['VALUE'] . '"/>';
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
        $fh = fopen("source/charts/data/employeecomparebar.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function serviceofferingchart($serviceoffering = array())
    {

        $chart = '<chart bgcolor="#fbfbfb" caption="" subcaption="" showPercentValues="1" decimals="1" baseFontSize="11">';
        for ($i = 4; $i <= 10; $i++) {
            $chart .= '<set label="' . $serviceoffering['title_' . $i] . '" value="' . $serviceoffering['total' . $i] . '"/>';
        }
        $chart .= '<styles>
                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/servicepie.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function servicechart($serviceoffering = array())
    {
        $chart = '<chart bgcolor="#fbfbfb" caption="" subcaption="" showPercentValues="1" decimals="1" baseFontSize="11">';
        $i = 0;
        foreach ($serviceoffering as $row) {
            $chart .= '<set label="' . $row['title_' . $i] . '" value="' . $row['total' . $i] . '"/>';
            $i++;
        }

        $chart .= '<styles>
                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/service.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function saleschart($salesreport = array(), $year)
    {
        $chart = '<chart caption="Production Forecast" yAxisName="Units" bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">
                    <categories>';
        foreach ($year as $rw):
            $chart .= '<category label="' . $rw['YEAR'] . '"/>';
        endforeach;
        $chart .= '</categories>';
        $i = 1;
        foreach ($salesreport as $row):
            if ($i == 1) {
                $chart .= '<dataset seriesName="' . $row['NAME_OF_ENTERPRISE'] . '">';
            }
            $chart .= '<set value="' . $row['TOTAL'] . '"/>';
            $i++;
            if ($i > php72_count($year)) {
                $i = 1;
                $chart .= '</dataset>';
            }

        endforeach;
        $chart .= '</chart>';
        $fh = fopen("source/charts/data/salesreport.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function sourcesearchreport()
    {
        $data['source'] = $this->Mdashboard->getsource();
        $data['yearly'] = $_POST['source'];
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['scoutingyear'] = $this->Mdashboard->sourceyearreport($_POST['source']);
        $this->sourcechart($data['scoutingyear']);
        $data['cpage'] = 'scouting_report';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../template_plain', $data);
    }
    public function employeesearchreport()
    {
        $data['source'] = $this->Mdashboard->getsource();
        $data['yearly'] = $_POST['employee'];
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['scoutingyear'] = $this->Mdashboard->employeesearchreport($_POST['employee']);
        $this->sourcechart($data['scoutingyear']);
        $data['cpage'] = 'scouting_report';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../template_plain', $data);
    }
    public function sectorsearchreport()
    {
        $data['source'] = $this->Mdashboard->getsource();
        $yearly = array();
        $yearly = $_POST['sector'];
        $data['yearly'] = $yearly;
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['scoutingyear'] = $this->Mdashboard->sectorsearchreport($_POST['sector']);
        $this->sourcechart($data['scoutingyear']);
        $data['cpage'] = 'scouting_report';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../template_plain', $data);
    }
    public function scouting_report($year = null)
    {
        $data['source'] = $this->Mdashboard->getsource();
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['scoutingyear'] = $this->Mdashboard->scoutingyearreport($year);
        $this->sourcechart($data['scoutingyear']);
        if ($this->uri->segment("3") == "ex") {

            $data['cpagetitle'] = " ";
            $data['pageTitle'] = "Scouting Report";
            $data['filename'] = "Scouting_Report";
            $data['htmView'] = $this->load->view('scouting_report', $data, true);
            $templateView = $this->load->view('../template_export', $data, true);
            exportMeAsMPDF($templateView, $data['filename']);
        }
        $data['cpage'] = 'scouting_report';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function scoutingquarterreport()
    {
        $data['source'] = $this->Mdashboard->getsource();
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['scoutingyear'] = $this->Mdashboard->scoutingyearreport($year);
        $this->sourcechart($data['scoutingyear']);
        $data['cpage'] = 'scouting_quarterreport';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function scoutingmonthreport()
    {
        $data['source'] = $this->Mdashboard->getsource();
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['scoutingyear'] = $this->Mdashboard->scoutingmonthreport();
        $this->sourcechart($data['scoutingyear']);
        $data['cpage'] = 'scouting_monthreport';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function sourcecompare()
    {
        $source = array();
        $employee = array();
        $sector = array();
        if (isset($_POST['source'])) {
            $source[] = $_POST['source'];
        }
        $data['sourceselected'] = $source;
        if (isset($_POST['employee'])) {
            $employee[] = $_POST['employee'];
        }
        $data['employeeselected'] = $employee;
        if (isset($_POST['sector'])) {
            $sector[] = $_POST['sector'];
        }
        $data['sectorselected'] = $sector;
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['source'] = $this->Mdashboard->getsource();
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['sourcecompare'] = $this->Mdashboard->sourcecompare($source, $employee, $sector);
        $this->employeecomparechart($data['sourcecompare']);
        if ($data['employeeselected'] != "") {
            if ($this->input->post('isajax') == 'true') {
                $data['employeeselected'] = $employee;
                $data['sourceselected'] = "";
                $data['sectorselected'] = "";
                $data['cpagetitle'] = " ";
                $data['pageTitle'] = "Source Compare Report";
                $data['filename'] = "Source_Compare_Report";
                $data['htmView'] = $this->load->view('source_compare', $data, true);
                $templateView = $this->load->view('../template_export', $data, true);
                exportMeAsMPDF($templateView, $data['filename']);
            }
        }
        $data['cpage'] = 'source_compare';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function scoutingquality()
    {
        if (isset($_POST['employee'])) {
            $employee = $_POST['employee'];
        } else {
            $employee = array();
        }
        if (isset($_POST['sector'])) {
            $sector = $_POST['sector'];
        } else {
            $sector = array();
        }
        $data['employeeselected'] = $employee;
        $data['sectorselected'] = $sector;
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['source'] = $this->Mdashboard->getsource();
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['sourceWiseReport'] = $this->Minnovation_reports->getSourceWiseReport('', 'Expand');
        $this->qualitychart($data['sourceWiseReport']);
        $data['employeeWiseReport'] = $this->Mdashboard->getemployeequality($employee);
        $this->employeequalitychart($data['employeeWiseReport']);
        $data['sectorWiseReport'] = $this->Mdashboard->getsectorwisereport($sector);
        $data['timetakenreport'] = $this->Mdashboard->gettimetakenreport();

        if ($this->uri->segment("3") == "ex") {
            if (isset($_POST['employee'])) {
                $employee = $_POST['employee'];
            } else {
                $employee = array();
            }

            $data['employeeselected'] = $employee;
            $data['cpagetitle'] = " ";
            $data['pageTitle'] = "Source Quality Report";
            $data['filename'] = "Source_Quality_Report";
            $data['htmView'] = $this->load->view('scoutingquality', $data, true);
            $templateView = $this->load->view('../template_export', $data, true);
            exportMeAsMPDF($templateView, $data['filename']);
        }

        $data['cpage'] = 'scoutingquality';
        $data['cpagetitle'] = 'Quality Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function sourcesearchireport()
    {
        $data['service'] = $this->Mdashboard->getservice();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['incubation'] = $this->Mdashboard->getincubation();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['yearly'] = $_POST['source'];
        $data['incubationservice'] = $this->Mdashboard->sourcesearchireport($_POST['source']);
        $this->servicechart($data['incubationservice']);
        $data['cpage'] = 'incubation_report';
        $data['cpagetitle'] = 'Incubation Report';
        $this->load->view('../template_plain', $data);
    }
    public function employeesearchireport()
    {
        $data['service'] = $this->Mdashboard->getservice();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['incubation'] = $this->Mdashboard->getincubation();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['yearly'] = $_POST['employee'];
        $data['incubationservice'] = $this->Mdashboard->employeesearchireport($_POST['employee']);
        $this->servicechart($data['incubationservice']);
        $data['cpage'] = 'incubation_report';
        $data['cpagetitle'] = 'Incubation Report';
        $this->load->view('../template_plain', $data);
    }
    public function sectorsearchireport()
    {
        $data['service'] = $this->Mdashboard->getservice();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['incubation'] = $this->Mdashboard->getincubation();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['yearly'] = $_POST['sector'];
        $data['incubationservice'] = $this->Mdashboard->sectorsearchireport($_POST['sector']);
        $this->servicechart($data['incubationservice']);
        $data['cpage'] = 'incubation_report';
        $data['cpagetitle'] = 'Incubation Report';
        $this->load->view('../template_plain', $data);
    }
    public function incubation_report($year = null)
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['incubation'] = $this->Mdashboard->getincubation();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['service'] = $this->Mdashboard->getservice();
        $data['incubationservice'] = $this->Mdashboard->incubationcompare();
        $this->servicechart($data['incubationservice']);
        if ($this->uri->segment("3") == "ex") {

            $data['cpagetitle'] = " ";
            $data['pageTitle'] = "Incubation Report";
            $data['filename'] = "Incubation_Report";
            $data['htmView'] = $this->load->view('incubation_report', $data, true);
            $templateView = $this->load->view('../template_export', $data, true);
            exportMeAsMPDF($templateView, $data['filename']);
        }

        $data['cpage'] = 'incubation_report';
        $data['cpagetitle'] = 'Scouting and Screening Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function incubationcompare()
    {
        if (isset($_POST['employee'])) {
            $employee[] = $_POST['employee'];
        }
        if (isset($_POST['service'])) {
            $service[] = $_POST['service'];
        }
        if (isset($_POST['sector'])) {
            $sector[] = $_POST['sector'];
        }

        $data['sectorselected'] = $sector;
        $data['serviceselected'] = $service;
        $data['employeeselected'] = $employee;
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['service'] = $this->Mdashboard->getservice();
        $data['incubation'] = $this->Mdashboard->getincubation();
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['sourcecompare'] = $this->Mdashboard->incubationcompare($service, $employee, $sector);
        $data['cpage'] = 'incubationcompare';
        $data['cpagetitle'] = 'Incubation Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function timetakenreport()
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['source'] = $this->Mdashboard->getsource();
        $data['employee'] = $this->Mdashboard->getemployee();
        $data['sector'] = $this->Mdashboard->getsector();
        $data['product'] = $this->Mdashboard->getproduct();
        $data['stage'] = $this->Minnovation->getInnvationStage();
        $data['innovationList'] = $this->Mdashboard->gettimetakenreport();

        if ($this->uri->segment("3") == "ex") {

            $data['cpagetitle'] = " ";
            $data['pageTitle'] = "Scouting Time ";
            $data['filename'] = "Scoutingtimequality";
            $data['htmView'] = $this->load->view('scoutingtimequality', $data, true);
            $templateView = $this->load->view('../template_export', $data, true);
            exportMeAsMPDF($templateView, $data['filename']);
        }

        $data['cpage'] = 'scoutingtimequality';
        $data['cpagetitle'] = 'Quality Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function progress_report()
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['metrics'] = $this->Mdashboard->getmetrics();
        $data['sales_report'] = $this->Mdashboard->getsalesreport();
        $data['cpage'] = 'progress_report';
        $data['cpagetitle'] = 'Incubation Progress Report';
        $this->load->view('../dashboard_template', $data);
    }
    public function progresscompare()
    {
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        if (isset($_POST['metrics'])) {
            $metrics = $_POST['metrics'];
        }
        $data['metricsselected'] = $_POST['metrics'];
        $data['metrics'] = $this->Mdashboard->getmetrics();
        $data['progresscompare'] = $this->Mdashboard->getprogresscompare($metrics);
        $this->progresschart($data['progresscompare']);
        $data['cpage'] = 'progresscompare';
        $data['cpagetitle'] = 'Incubation Progress';
        $this->load->view('../dashboard_template', $data);
    }
    public function progresschart($employeewise = array())
    {
        $chart = '<chart bgcolor="#fbfbfb" caption="Employee Wise Analysis" subcaption="Overall" showPercentValues="1" decimals="1" baseFontSize="11">';
        foreach ($employeewise as $row):
            $chart .= '<set label="' . $row['name_of_enterprise'] . '" value="' . $row['total'] . '"/>';
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
        $fh = fopen("source/charts/data/progresschar.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }

}
