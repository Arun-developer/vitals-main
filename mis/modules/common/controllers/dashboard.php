<?php
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->model('scouting/Minnovation');
        $this->load->model('scouting/Mincharge');
        $this->load->model('common/Minnovation_reports');
        $this->load->model('common/Mincubation_reports');
        $this->load->model('dashboard/Mdashboard');
    }
    public function index()
    {
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            redirect('login/icon_menu');
        } else {
            redirect('login/icon_menu');
        }
    }
    public function admin_dashboard()
    {

        if (isset($_POST['txtSubmit'])) {
            $from = $_POST['fromYear'];
            $to = $_POST['toYear'];
            $data['funddisbursed'] = $this->Mincubation_reports->getfunddisbursed($from, $to);
            $data['allfunddisbursed'] = $this->Mincubation_reports->getallfunddisbursed($from, $to);
            $this->funddisbursed($data['allfunddisbursed']);
            $data['fundutilized'] = $this->Mincubation_reports->getfundutilized($from, $to);
            $data['raiseinvestment'] = $this->Mincubation_reports->getraiseinvestment($from, $to);
            $data['allfundutilized'] = $this->Mincubation_reports->getallfundutilized($from, $to);
            $data['mentordetails'] = $this->Mincubation_reports->getmentordetails($from, $to);
            $data['repayment'] = $this->Mincubation_reports->getrepayment($from, $to);
            $data['allrepayment'] = $this->Mincubation_reports->getallrepayment($from, $to);
            $data['progress'] = $this->Mincubation_reports->getprogress($from, $to);
            $data['felowDetails'] = $this->Mincubation_reports->getfellowdetails($from, $to);
            $data['training_report'] = $this->Mincubation_reports->gettrainingDetailss($from, $to);
            $data['mediaDetails'] = $this->Mincubation_reports->getmediaDetails($from, $to);
            $data['boardDetails'] = $this->Mincubation_reports->getBoardDetails($from, $to);
            $data['investerDetails'] = $this->Mincubation_reports->getinvesterDetails($from, $to);
            $data['seedfunding_report'] = $this->Mincubation_reports->getFundUTDetails($from, $to);
            $data['exitDetails'] = $this->Mincubation_reports->getExitCriteria();
            $year = date('Y');
            $data['serviceoffering'] = array_pop($this->Mdashboard->getserviceoffering($year));
            $this->serviceofferingchart($data['serviceoffering']);
        } else {

            $data['funddisbursed'] = $this->Mincubation_reports->getfunddisbursed();
            $data['allfunddisbursed'] = $this->Mincubation_reports->getallfunddisbursed();
            $this->funddisbursed($data['allfunddisbursed']);
            $data['fundutilized'] = $this->Mincubation_reports->getfundutilized();
            $data['raiseinvestment'] = $this->Mincubation_reports->getraiseinvestment();
            $data['seedfunding_report'] = $this->Mincubation_reports->getFundUTDetails();
            $data['training_report'] = $this->Mincubation_reports->gettrainingDetailss();
            $data['mentordetails'] = $this->Mincubation_reports->getmentordetails();
            $data['exitDetails'] = $this->Mincubation_reports->getExitCriteria();
            $data['exitboardDetails'] = $this->Mincubation_reports->getExitboard();
            $data['allfundutilized'] = $this->Mincubation_reports->getallfundutilized();
            $data['repayment'] = $this->Mincubation_reports->getrepayment();
            $data['allrepayment'] = $this->Mincubation_reports->getallrepayment();
            $data['felowDetails'] = $this->Mincubation_reports->getfellowdetails();
            $data['mediaDetails'] = $this->Mincubation_reports->getmediaDetails();
            $data['boardDetails'] = $this->Mincubation_reports->getBoardDetails();
            $data['investerDetails'] = $this->Mincubation_reports->getinvesterDetails();
            $data['progress'] = $this->Mincubation_reports->getprogress();
            $year = date('Y');
            $data['serviceoffering'] = array_pop($this->Mdashboard->getserviceoffering($year));
            $this->serviceofferingchart($data['serviceoffering']);
            $years = $this->Mdashboard->getsalesreportbyyear();
            $salesreport = $this->Mdashboard->getsalesreport();
            $this->saleschart($salesreport, $years);
            $this->getFundingReport($data['allfunddisbursed']);
            $this->getRepaymentReport($data['allrepayment'], $data['repayment']);
            $this->getMentorReport($data['mentordetails']);
            $this->getexitDetailsReport($data['allrepayment']);
        }

        $data['cpagetitle'] = "Incubation Report";
        $data['cpage'] = "dashboard/dashboard";
        $this->load->view('../dashboard_template', $data);
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
            if ($i > count($year)) {
                $i = 1;
                $chart .= '</dataset>';
            }

        endforeach;
        $chart .= '</chart>';
        $fh = fopen("source/charts/data/salesreport.xml", "w");
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

    public function getFundingReport($fundingReportDetails)
    {

        $chart = '<chart caption="Seed Funding" yAxisName="Amount in Rs." bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">
	                <categories>';
        foreach ($fundingReportDetails as $rw):
            $chart .= '<category label="' . $rw['name_of_enterprise'] . '"/>';
        endforeach;
        $chart .= '</categories>';
        $chart .= '<dataset seriesName="Fund Utilizd">';
        foreach ($fundingReportDetails as $row):
            $chart .= '<set value="' . $row['fund_utilized'] . '"/>';
        endforeach;
        $chart .= "</dataset>";
        $chart .= '<dataset seriesName="Amount">';
        foreach ($fundingReportDetails as $row):
            $chart .= '<set value="' . $row['amount'] . '"/>';
        endforeach;
        $chart .= "</dataset>";
        $chart .= '<dataset seriesName="Approved Amount">';
        foreach ($fundingReportDetails as $row):
            $chart .= '<set value="' . $row['approved_amount'] . '"/>';
        endforeach;
        $chart .= '</dataset></chart>';

        $fh = fopen("source/charts/data/seedfunding.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);

    }
    public function getseedFundingReportByChart()
    {

        $data['allfunddisbursed'] = $this->Mincubation_reports->getallfunddisbursed();
        $data['seedfunding_report'] = $this->Mincubation_reports->getFundUTDetails();
        $data['cpagetitle'] = "Seedfunding Report";
        $data['cpage'] = "dashboard/seedfunding_report";
        $this->load->view('../template_plain', $data);

    }

    public function getRepaymentDetailsReport()
    {

        $data['repayment'] = $this->Mincubation_reports->getrepayment();
        $data['allrepayment'] = $this->Mincubation_reports->getallrepayment();
        $data['cpagetitle'] = "Repayment Report";
        $data['cpage'] = "dashboard/repayment_report";
        $this->load->view('../template_plain', $data);
    }
    public function getMentorDetailsReport()
    {

        $data['mentordetails'] = $this->Mincubation_reports->getmentordetails();
        $data['cpagetitle'] = "Repayment Report";
        $data['cpage'] = "dashboard/mentor_report";
        $this->load->view('../template_plain', $data);
    }
    public function getexitDetailReport()
    {

        $data['allrepayment'] = $this->Mincubation_reports->getallrepayment();
        $data['exitDetails'] = $this->Mincubation_reports->getExitCriteria();
        $data['exitboardDetails'] = $this->Mincubation_reports->getExitboard();
        $data['cpagetitle'] = "Exit Innovations Report";
        $data['cpage'] = "dashboard/exit_report";
        $this->load->view('../template_plain', $data);
    }

    public function getRepaymentReport($repaymentDetails, $repayment)
    {

        $chart = '<chart caption="Repayment" yAxisName="Amount" bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">
	                <categories>';
        foreach ($repaymentDetails as $rw):
            $chart .= '<category label="' . $rw['name_of_enterprise'] . '"/>';
        endforeach;
        $chart .= '</categories>';
        $chart .= '<dataset seriesName="Amount">';
        foreach ($repaymentDetails as $row):
            $chart .= '<set value="' . $row['amount'] . '"/>';
        endforeach;
        $chart .= "</dataset>";
        $chart .= '<dataset seriesName="Total Amount ">';
        foreach ($repayment as $rowPay):
            $chart .= '<set value="' . $rowPay['total'] . '"/>';
        endforeach;
        $chart .= '</dataset></chart>';

        $fh = fopen("source/charts/data/repayment.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }

    public function getMentorReport($mentorDetail)
    {

        $chart = '<chart caption="Mentoring Report" yAxisName="Amount" bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">
	                <categories>';
        foreach ($mentorDetail as $rw):
            $chart .= '<category label="' . $rw['name_of_enterprise'] . '"/>';
        endforeach;
        $chart .= '</categories>';

        $chart .= '<dataset seriesName="Company">';
        foreach ($mentorDetail as $row):
            $chart .= '<set value="' . $row['company'] . '"/>';
        endforeach;
        $chart .= "</dataset>";
        $chart .= '<dataset seriesName="Total Time Spend">';
        foreach ($mentorDetail as $row):
            $chart .= '<set value="' . $row['mentorhours'] . '"/>';
        endforeach;
        $chart .= "</dataset>";
        $chart .= '<dataset seriesName="Amount">';
        foreach ($mentorDetail as $row):
            $chart .= '<set value="' . $row['mentormoney'] . '"/>';
        endforeach;
        $chart .= '</dataset></chart>';

        $fh = fopen("source/charts/data/mentor.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);

    }

    public function getexitDetailsReport($exitDetail)
    {

        $chart = '<chart caption="Exit Details Report" yAxisName="Amount" bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">
	                <categories>';
        foreach ($exitDetail as $rw):
            $chart .= '<category label="' . $rw['name_of_enterprise'] . '"/>';
        endforeach;
        $chart .= '</categories>';

        $chart .= '<dataset seriesName="Amout">';
        foreach ($exitDetail as $row):
            $chart .= '<set value="' . $row['amount'] . '"/>';
        endforeach;
        $chart .= "</dataset>";
        $chart .= '<dataset seriesName="Stage">';
        foreach ($exitDetail as $row):
            $chart .= '<set value="' . $row['stage'] . '"/>';
        endforeach;
        $chart .= "</dataset>";
        $chart .= '<dataset seriesName="From Date">';
        foreach ($exitDetail as $row):
            $chart .= '<set value="' . $row['from_date'] . '"/>';
        endforeach;
        $chart .= '</dataset></chart>';

        $fh = fopen("source/charts/data/exitdetails.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);

    }

    public function funddisbursed($allfunddisbursed)
    {
        $generalCharts = "<chart caption='Revenue & Profit(L)' subCaption='Monthly Incubetee Report' numberPrefix='' sformatNumberScale='1' sNumberPrefix='' syncAxisLimits='0.5' rotateValues='1' showSum='0'>
                                                    ";
        $label = $answer = '';
        foreach ($allfunddisbursed as $row) {
            $generalCharts .= "<set label='" . $row['name_of_enterprise'] . "' value='" . $row['amount'] . "' />";
        }
        $generalCharts .= "</chart>";
        $fcreateXml = fopen("source/charts/data/funddisbursed.xml", "w");
        fwrite($fcreateXml, $generalCharts);
        fclose($fcreateXml);

    }

    public function admin()
    {
        //stage ,pending

        if (isset($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = date('Y');
        }
        $data['year'] = $year;
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['newInnovations'] = $this->Minnovation_reports->getInnovationCount('0', ' ', $year);
        $data['entryPendingInnovations'] = $this->Minnovation_reports->getInnovationCount('1', 'pending', $year);
        $data['resourceUsage'] = $this->Minnovation_reports->getListInnovationByStatus('1');
        $data['cpagetitle'] = "Admin Dashboard";
        //source chart
        $data['sourceWiseReport'] = $this->Minnovation_reports->getSourceWiseReport($year);
        $this->sourceWise($data['sourceWiseReport']);
        $data['new_entry_avg'] = $this->Minnovation_reports->getConvertionAvgTime('1', $year);
        $data['entry_lead_avg'] = $this->Minnovation_reports->getConvertionAvgTime('2', $year);
        $data['lead_deligence_avg'] = $this->Minnovation_reports->getConvertionAvgTime('4', $year);
        $data['incubation_avg'] = $this->Minnovation_reports->getConvertionAvgTime('5', $year);
        $this->timeChart($new_entry_avg, $entry_lead_avg, $lead_deligence_avg, $incubation_avg);
        $data['newInnovationsCurrent'] = $this->Minnovation_reports->getInnovationCountPeriod('', '', $year);
        $data['leadInnovations'] = $this->Minnovation_reports->getInnovationCountPeriod('2', $year);
        $data['entryInnovations'] = $data['leadInnovations'] + $this->Minnovation_reports->getInnovationCountPeriod('1', $year);

        $data['scrreeningInnovation'] = $this->Minnovation_reports->getInnovationCountPeriod('4', $year);
        $data['incubationInnovation'] = $this->Minnovation_reports->getInnovationCountPeriod('5', $year);
        $data['closeInnovationsCurrent'] = $this->Minnovation_reports->getInnovationCountPeriod('5', 'status', $year);
        $this->generalReport($year);
        $data['resourceCompleteReport'] = $this->Minnovation_reports->getInchargeCompleted($year);
        $data['resourceCount'] = $this->resourceCompletion($data['resourceCompleteReport']);
        $data['notification_Details'] = $this->getStageDetails();
        $username = $this->session->userdata('user_name');
        $data['latestUpdates'] = $this->Minnovation_reports->getlatestUpdates($username);
        $data['left_box'] = array('ajax_left_box');
        $data['cpage'] = "dashboard/admin";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function user()
    {
        $innovation = $this->Mincharge->getAssociateInnovation($this->session->userdata('emp_number'));
        $options['associate'] = (count($innovation)) ? $innovation : array('');
        $username = $this->session->userdata('user_name');
        $data['latestUpdates'] = $this->Minnovation_reports->getlatestUpdates($username);
        $notification_Details = $this->getStageDetails();
        $data['notification_Details'] = $notification_Details;
        $data['entryInnovations'] = $this->Minnovation_reports->getInnovationUserCount($options, '1');
        $data['leadInnovations'] = $this->Minnovation_reports->getInnovationUserCount($options, '2');
        $data['activeInnovations'] = count(array_filter($innovation));
        $data['notification_Details'] = $this->getStageDetails();
        $data['left_box'] = array('ajax_left_box');
        $data['cpagetitle'] = "Dashboard";
        $data['cpage'] = "dashboard/user";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function getnotifications()
    {
        $notification_Details = $this->getStageDetails();
        $data['notification_Details'] = $notification_Details;
        $data['cpage'] = 'notifications_view';
        $data['cpagetitle'] = 'Notifications';
        $data['left_box'] = array('ajax_left_box');
        $this->load->view('../template', $data);
    }

    public function getStageDetails()
    {

        $value = $this->session->userdata('emp_number');
        $val = $this->session->userdata('user_name');

        if ($value == "") {
            if ($val == "Admin") {
                $value = '0';
                $data = $this->Minnovation_reports->getNotificationDetails($value);
            }
        } else {

            $data = $this->Minnovation_reports->getNotificationDetails($value);

        }
        return $data;

    }
    public function mail($emp_number)
    {
        $data['mails'] = $this->Mincubation_reports->getemployeemail($emp_number);
        $data['cpage'] = 'dashboard/employeemail';
        $data['left_box'] = array('ajax_left_box');
        $data['cpagetitle'] = 'Employee`s Mail';
        $this->load->view('../template', $data);
    }
    public function mailform($sendby, $to)
    {
        if (isset($_POST['txtSubmit'])) {
            $this->Mincubation_reports->insertreply($_POST);
            $data['successMsg'] = "Mail Sent Successfully";
            redirect('dashboard/mail');
        }
        if (urldecode($sendby) == 'admin@villgro.org') {
            $data['tomail'] = $sendby;
            print_r($data['tomail']);
        } else {
            $response = array_pop($this->Mincubation_reports->getmail($sendby));
            $data['tomail'] = array_pop($response);
        }
        $data['from'] = $to;
        $data['notification_Details'] = $this->getStageDetails();
        $data['left_box'] = array('ajax_left_box');
        $data['cpage'] = 'dashboard/mailform';
        $data['cpagetitle'] = 'Mail Form';
        $this->load->view('../template', $data);
    }
    public function discussion()
    {
        $username = $this->session->userdata('user_name');
        $data['latestUpdates'] = $this->Minnovation_reports->getlatestUpdates($username);
        $data['left_box'] = array('ajax_left_box');
        $data['cpage'] = 'common/dashboard/vdiscussion';
        $data['cpagetitle'] = "Discussion Board";
        $this->load->view('../template', $data);
    }

    public function resourceCompletion($resourceComplete)
    {

        //show($resourceComplete);
        $resourceChat = "<chart palette='2' caption='' showLabels='1' showvalues='0' decimals='3' numberPrefix='' clustered='0' exeTime='1.5' showPlotBorder='0' zGapPlot='30' zDepth='90' divLineEffect='emboss' startAngX='10' endAngX='18'>";

        $emp_name = $assigned = $completed = $incubation = $screening = $pending = $entry = $lead = '';
        foreach ($resourceComplete as $row):
            $emp_name .= "<category label='" . $row['emp_name'] . "' />";
            $assigned .= "<set value='" . $row['assigned'] . "' />";
            $completed .= "<set value='" . $row['completed'] . "' />";
            $incubation .= "<set value='" . $row['incubation'] . "' />";
            $screening .= "<set value='" . $row['screening'] . "' />";
            $pending .= "<set value='" . $row['pending'] . "' />";
            $entry .= "<set value='" . $row['entry'] . "' />";
            $lead .= "<set value='" . $row['lead'] . "' />";
        endforeach;

        $resourceChat .= "<categories>" . $emp_name . "</categories>
							<dataset seriesName='Assigned'  showValues='0'>" . $assigned . "</dataset>
							<dataset seriesName='Completed'  showValues='0'>" . $completed . "</dataset>
							<dataset seriesName='Follow-Ups'  showValues='0'>" . $pending . "</dataset>
							<dataset seriesName='Detailed-diligence'  showValues='0'>" . $screening . "</dataset>
							<dataset seriesName='Incubation'  showValues='0'>" . $incubation . "</dataset>

							<styles>
							<definition>
							<style name='captionFont' type='font' size='15' />
							</definition>
							<application>
							<apply toObject='caption' styles='captionfont' />
							</application>
							</styles>
							</chart>";

        $fh = fopen("source/charts/data/resourceComplted.xml", "w");
        fwrite($fh, $resourceChat);
        fclose($fh);
        $resourceChat = "";
        $resourceChat = "<chart palette='2' caption='' showLabels='1' showvalues='0' decimals='3' numberPrefix='' clustered='0' exeTime='1.5' showPlotBorder='0' zGapPlot='30' zDepth='90' divLineEffect='emboss' startAngX='10' endAngX='18' startAngY='-10' endAngY='-40'>";

        $emp_name = $assigned = $entry = $lead = $screening = $incubation = '';
        //show($resourceComplete);
        foreach ($resourceComplete as $row):
            $emp_name .= "<category label='" . $row['emp_name'] . "' />";
            $assigned .= "<set value='" . $row['assigned'] . "' />";
            $entry .= "<set value='" . $row['entry'] . "' />";
            $lead .= "<set value='" . $row['lead'] . "' />";
            $screening .= "<set value='" . $row['screening'] . "' />";
            $incubation .= "<set value='" . $row['incubation'] . "' />";
        endforeach;

        $resourceChat .= "<categories>" . $emp_name . "</categories>
							<dataset seriesName='Assigned'  showValues='0'>" . $assigned . "</dataset>
							<dataset seriesName='Entry'  showValues='0'>" . $entry . "</dataset>
							<dataset seriesName='Lead'  showValues='0'>" . $lead . "</dataset>
							<dataset seriesName='Detailed-diligence'  showValues='0'>" . $screening . "</dataset>
							<dataset seriesName='Incubation'  showValues='0'>" . $incubation . "</dataset>
							<styles>
							<definition>
							<style name='captionFont' type='font' size='15' />
							</definition>
							<application>
							<apply toObject='caption' styles='captionfont' />
							</application>
							</styles>
							</chart>";

        $fh = fopen("source/charts/data/resourceConversion.xml", "w");
        fwrite($fh, $resourceChat);
        fclose($fh);

        return count($resourceComplete);
    }
    public function generalReport($year)
    {
        $data['newInnovationsCurrent'] = $this->Minnovation_reports->getInnovationCountPeriod('', ' ', $year);
        $data['leadInnovations'] = $this->Minnovation_reports->getInnovationCountPeriod('2', ' ', $year);
        $data['entryInnovations'] = $data['leadInnovations'] + $this->Minnovation_reports->getInnovationCountPeriod('1', ' ', $year);

        $data['scrreeningInnovation'] = $this->Minnovation_reports->getInnovationCountPeriod('4', ' ', $year);
        $data['incubationInnovation'] = $this->Minnovation_reports->getInnovationCountPeriod('5', ' ', $year);
        $data['closeInnovationsCurrent'] = $this->Minnovation_reports->getInnovationCountPeriod('5', 'status', $year);
        $generalChart = "<chart caption='' xAxisName='Stages' yAxisName='No. Of Innovation' showValues='0' decimals='0' formatNumberScale='0' palette='4'>
		<set label='New' value='" . $data['newInnovationsCurrent'] . "' />
		<set label='Entry' value='" . $data['entryInnovations'] . "' />
		<set label='Lead' value='" . $data['leadInnovations'] . "' />
		<set label='Detailed-diligence' value='" . $data['scrreeningInnovation'] . "' />
		<set label='Incubation' value='" . $data['incubationInnovation'] . "' />
		<set label='Closed' value='" . $data['closeInnovationsCurrent'] . "' />

		<trendlines>
		<line startValue='750' displayValue='Average' color='009900' valueOnRight='1' />
		</trendlines>
		</chart>";
        $fh3 = fopen("source/charts/data/generalChart.xml", "w");
        fwrite($fh3, $generalChart);
        fclose($fh3);

        $data['new_entry'] = ($data['entryInnovations'] / $data['newInnovationsCurrent']) * 100;
        $data['enter_lead'] = ($data['leadInnovations'] / $data['entryInnovations']) * 100;
        $data['detailed_diligence'] = ($data['scrreeningInnovation'] / $data['leadInnovations']) * 100;
        $data['incubation'] = ($data['incubationInnovation'] / $data['scrreeningInnovation']) * 100;

        $stageToStageChart = "<chart caption='' xAxisName='Stages' yAxisName='percentage %' showValues='0' decimals='0' formatNumberScale='0' palette='4'>
		<set label='New to Entry' value='" . $data['new_entry'] . "' />
		<set label='Entry to Lead' value='" . $data['enter_lead'] . "' />
		<set label='Lead to Detailed diligence' value='" . $data['detailed_deligence'] . "' />
		<set label='Detailed diligence to Incubation' value='" . $data['incubation'] . "' />
		<trendlines>
		<line startValue='750' displayValue='Average' color='009900' valueOnRight='1' />
		</trendlines>
		</chart>";
        $fh4 = fopen("source/charts/data/stageToStageChart.xml", "w");
        fwrite($fh4, $stageToStageChart);
        fclose($fh4);
    }
    public function timeChart($new_entry_avg, $entry_lead_avg, $lead_deligence_avg, $incubation_avg)
    {
        //time chart
        $timeChart = "<chart palette='2' caption='' showLabels='1' showvalues='0' decimals='0' numberPrefix=''>
			<categories>
			<category label='New - Entry' />
			<category label='Entry - Lead' />
			<category label='Lead - Detailed-diligence' />
			<category label='Detailed diligence - Incubation' />
			</categories>
			<dataset seriesName='Max(Days)' color='AFD8F8' showValues='0'>
			<set value='" . abs($new_entry_avg['maxtime']) . "' />
			<set value='" . abs($entry_lead_avg['maxtime']) . "' />
			<set value='" . abs($lead_deligence_avg['maxtime']) . "' />
			<set value='" . abs($incubation_avg['maxtime']) . "' />

			</dataset>
			<dataset seriesName='Avg(Days)' color='F6BD0F' showValues='0'>
			<set value='" . abs($new_entry_avg['avgtime']) . "' />
			<set value='" . abs($entry_lead_avg['avgtime']) . "' />
			<set value='" . abs($lead_deligence_avg['avgtime']) . "' />
			<set value='" . abs($incubation_avg['maxtime']) . "' />

			</dataset>
			<dataset seriesName='Min(Days)' color='8BBA00' showValues='0'>
			<set value='" . abs($new_entry_avg['mintime']) . "' />
			<set value='" . abs($entry_lead_avg['mintime']) . "' />
			<set value='" . abs($lead_deligence_avg['mintime']) . "' />
			<set value='" . abs($incubation_avg['maxtime']) . "' />

			</dataset>
			</chart>";
        $fh1 = fopen("source/charts/data/timeConvertion.xml", "w");
        fwrite($fh1, $timeChart);
        fclose($fh1);
    }
    public function sourceWise($sourceWiseReport)
    {
        //show($sourceWiseReport);
        $categoryContent = $newContent = $enteryContent = $leadContent = $incubationContent = $screeningContent = " ";
        $sourceChat = "<chart palette='2' caption='' showLabels='1' showvalues='0' decimals='3' numberPrefix='' clustered='0' exeTime='1.5' showPlotBorder='0' zGapPlot='30' zDepth='90' divLineEffect='emboss' startAngX='10' endAngX='18' startAngY='-10' endAngY='-40'>";
        foreach ($sourceWiseReport as $row):
            $categoryContent .= "<category label='" . $row['name'] . "' />";
            $newContent .= "<set value='" . $row['total_new'] . "' />";
            $enteryContent .= "<set value='" . $row['total_entry'] . "' />";
            $leadContent .= "<set value='" . $row['total_lead'] . "' />";
            $screeningContent .= "<set value='" . $row['total_screening'] . "' />";
            $incubationContent .= "<set value='" . $row['total_incubation'] . "' />";
        endforeach;

        $sourceChat .= "<categories>" . $categoryContent . "</categories>
				<dataset seriesName='New' color='8BBA00' showValues='0'>
				" . $newContent . "
				</dataset>
				<dataset seriesName='Entry' color='F6BD0F' showValues='0'>
				" . $enteryContent . "
				</dataset>

				<dataset seriesName='Lead' color='AFD8F8' showValues='0'>
				" . $leadContent . "
				</dataset>
				<dataset seriesName='Detailed-diligence' color='AFD8F8' showValues='0'>
				" . $screeningContent . "
				</dataset>
				<dataset seriesName='Incubation' color='AFD8F6' showValues='0'>
				" . $incubationContent . "
				</dataset>
				<styles>
				<definition>
				<style name='captionFont' type='font' size='15' />
				</definition>
				<application>
				<apply toObject='caption' styles='captionfont' />
				</application>
				</styles>
				</chart>";
        $fh = fopen("source/charts/data/sourceWise.xml", "w");
        fwrite($fh, $sourceChat);
        fclose($fh);
    }

}
