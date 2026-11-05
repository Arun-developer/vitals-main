<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * Weekly Global Report Page
 *
 * @ControllerName     wglobal_report.php
 * @Author             Sanjoy Dey
 * @Created Date       09-11-2011
 * @Modified Date      06-02-2012
 * @Modified By        Sanjoy Dey
 * @Last Modified By
 * @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
 * @version            CodeIgniter_2.0.3
 * @link               http://www.codeigniter.com
 * @since              File available since Release 2.0.3
 * @Warning            Any change in this file may cause abnormal behaviour of application.
 *
 */

class Wglobal_report extends CI_Controller
{

    //Constructor Function
    public function __construct()
    {

        parent::__construct();
        $this->Mauth->isLoggedCheck(); //Check user logged in or not
        $this->items_perpage = '15';
        $this->load->model('mwglobal_report');
        $this->load->model('master/mprogress_master');
        $this->load->model('scouting/Minnovation');
        $this->load->model('seedfunding/Mseedfunding');

    }
    //Main function to create tab
    public function index($innovation, $frequency = null, $yearly = null, $monthly = null, $quarterly = null, $weekly = null)
    {

        $data['innovation'] = $innovation;
        $data['frequency'] = array('Monthly' => 2, 'Quarterly' => 3, 'Yearly' => 4);
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['portfolioinnovation'] = $this->mwglobal_report->getportfolio();
        if ($frequency == null) {
            $frequency = $data['frequency']['Monthly'];
        }
        $data['defaultfrequency'] = $frequency;
        if ($frequency != '4') {
            if ($yearly == null) {
                $yearly = date('Y');
            }
            $data['defaultyearly'] = $yearly;
            if ($monthly == null) {
                $monthly = date('m');
            }
            $data['defaultmonthly'] = $monthly;
            if ($quarterly == null) {
                $quarterly = $data['quarterly'][0];
            }
            $data['defaultquarterly'] = $quarterly;
            if ($weekly == null) {
                $weekly = $data['weekly'][0];
            }
            $data['defaultweekly'] = $weekly;
        }
        if ($frequency == '4') {

            for ($i = 0; $i < count($data['yearly']); $i++) {
                $data['yearanswer'][$i] = $this->mwglobal_report->getseedfunding_report($innovation, $data['yearly'][$i]);
                $data['yearboard'][$i] = $this->mwglobal_report->getboard_service($innovation, $data['yearly'][$i]);
                $data['yearraise'][$i] = $this->mwglobal_report->getraiseinvestment($innovation, $data['yearly'][$i]);
                $data['yearfellow'][$i] = $this->mwglobal_report->getfellow_service($innovation, $data['yearly'][$i]);
                $data['yearmedia'][$i] = $this->mwglobal_report->getmentordetails($innovation, $data['yearly'][$i]);
                $data['yearmeeting'][$i] = $this->mwglobal_report->getmeeting_service($innovation, $data['yearly'][$i]);
                $data['yearrevenue'][$i] = $this->mwglobal_report->getrevenue($innovation, $data['yearly'][$i]);
            }

        }
        if ($frequency == '3') {
            for ($i = 0; $i < count($data['quarterly']); $i++) {
                $data['quarteranswer'][$i] = $this->mwglobal_report->getqseedfunding_report($innovation, $data['quarterly'][$i], $yearly);
                $data['quarterboard'][$i] = $this->mwglobal_report->getqboard_service($innovation, $data['quarterly'][$i], $yearly);
                $data['quarterraise'][$i] = $this->mwglobal_report->getqraiseinvestment($innovation, $yearly, $data['quarterly'][$i]);
                $data['quarterfellow'][$i] = $this->mwglobal_report->getqfellow_service($innovation, $data['quarterly'][$i], $yearly);
                $data['quartermedia'][$i] = $this->mwglobal_report->getqmentordetails($innovation, $data['quarterly'][$i], $yearly);
                $data['quartermeeting'][$i] = $this->mwglobal_report->getqmeeting_service($innovation, $data['quarterly'][$i], $yearly);
                $data['quarterrevenue'][$i] = $this->mwglobal_report->getqrevenue($innovation, $data['quarterly'][$i], $yearly);
            }
        }
        if ($frequency == '2') {
            for ($i = 0; $i < count($data['monthly']); $i++) {
                $data['monthanswer'][$i] = $this->mwglobal_report->getmseedfunding_report($innovation, $data['monthly'][$i], $yearly);
                $data['monthboard'][$i] = $this->mwglobal_report->getmboard_service($innovation, $data['monthly'][$i], $yearly);
                $data['monthraise'][$i] = $this->mwglobal_report->getmraiseinvestment($innovation, $yearly, $data['monthly'][$i]);
                $data['monthfellow'][$i] = $this->mwglobal_report->getmfellow_service($innovation, $data['monthly'][$i], $yearly);
                $data['monthmedia'][$i] = $this->mwglobal_report->getmmentordetails($innovation, $data['monthly'][$i], $yearly);
                $data['monthmeeting'][$i] = $this->mwglobal_report->getmmeeting_service($innovation, $data['monthly'][$i], $yearly);
                $data['monthrevenue'][$i] = $this->mwglobal_report->getmrevenue($innovation, $data['monthly'][$i], $yearly);
            }
        }

        $data['company'] = $this->Minnovation->getInnovation($innovation);
        $data['name_of_enterprise'] = $data['company']['name_of_enterprise'];
        $data['cpage'] = "global_report";
        $data['left_box'] = array('incubation', 'innovation_tab');
        $data['cpagetitle'] = "Incubation Progress";
        $this->load->view('../dashboard_template', $data);

    }

    // Yearly Repost Function to display Yearly Report in Dashboard
    public function dashboard($id, $year = null)
    {

        $data['urlcode'] = $id;
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = date('Y');
        $data['defaultyearly'] = $year;
        $data['innovation'] = $this->Minnovation->getInnovation($data['urlcode']);
        $data['name_of_enterprise'] = $data['innovation']['name_of_enterprise'];
        $data['seedfunding_report'] = $this->mwglobal_report->getseedfunding_report($data['urlcode'], $year);
        $this->seedfundingchart($data['seedfunding_report']);
        $data['board_report'] = $this->mwglobal_report->getboard_service($data['urlcode'], $year);
        $this->board_chart($data['board_report']);
        $data['fellow_report'] = $this->mwglobal_report->getfellow_service($data['urlcode'], $year);
        $this->fellow_chart($data['fellow_report']);
        $data['fundutilized_details'] = $this->mwglobal_report->getfundutilized_details($data['urlcode'], $year);
        $this->media_chart($data['fundutilized_details']);
        $data['meeting_report'] = $this->mwglobal_report->getmeeting_service($data['urlcode'], $year);
        $this->meeting_chart($data['meeting_report']);
        $data['progress_report'] = $this->mwglobal_report->getprogress_report($data['urlcode'], $year);
        $this->progress_chart($data['progress_report']);
        $data['cpagetitle'] = "Incubatee Progress Report";
        $data['cpage'] = "vassign_task";
        $this->load->view('../dashboard_template', $data); //Load Template View

    }
    public function yearsearch($id)
    {
        $data['urlcode'] = $_POST['id'];
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $year = $_POST['year'];
        $data['defaultyearly'] = $year;
        $data['seedfunding_report'] = $this->mwglobal_report->getseedfunding_report($data['urlcode'], $year);
        $this->seedfundingchart($data['seedfunding_report']);
        $data['board_report'] = $this->mwglobal_report->getboard_service($data['urlcode'], $year);
        $this->board_chart($data['board_report']);
        $data['fellow_report'] = $this->mwglobal_report->getfellow_service($data['urlcode'], $year);
        $this->fellow_chart($data['fellow_report']);
        $data['fundutilized_details'] = $this->mwglobal_report->getfundutilized_details($data['urlcode'], $year);
        $this->media_chart($data['fundutilized_details']);
        $data['meeting_report'] = $this->mwglobal_report->getmeeting_service($data['urlcode'], $year);
        $this->meeting_chart($data['meeting_report']);
        $data['cpage'] = 'vassign_task';
        $data['cpagetitle'] = 'Dashboard';
        $this->load->view('../template_plain', $data);

    }
    public function seedfundingchart($seedfunding)
    {
        $chart = '<chart bgcolor="#fbfbfb" yAxisName="Amount in Rs." caption="" subcaption="" showPercentValues="1" decimals="1" baseFontSize="11">';
        $chart .= '<set label="Fund Approved" value="' . $seedfunding[0]['amount'] . '"/>';
        $chart .= '<set label="Fund Disbursed" value="' . $seedfunding[0]['approved_amount'] . '"/>';
        $chart .= '<set label="Fund Utilized" value="' . $seedfunding[0]['fund_utilized'] . '"/>';
        $chart .= '<styles>
                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/seedfunding_report.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function board_chart($board_report)
    {
        $chart = '<chart bgcolor="#fbfbfb" yAxisName="Amount in Rs." caption="" subcaption="" showPercentValues="1" decimals="1" baseFontSize="11">';
        $chart .= '<set label="total" value="' . $board_report[0]['total'] . '"/>';
        $chart .= '<set label="accept" value="' . $board_report[0]['accept'] . '"/>';
        $chart .= '<set label="reject" value="' . $board_report[0]['reject'] . '"/>';
        $chart .= '<styles>
                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';

        $fh = fopen("source/charts/data/board_report.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function fellow_chart($board_report)
    {
        $chart = '<chart bgcolor="#fbfbfb" caption="" subcaption="" showPercentValues="1" decimals="1" baseFontSize="11">';
        $chart .= '<set label="total" value="' . $board_report[0]['total'] . '"/>';
        $chart .= '<set label="accept" value="' . $board_report[0]['accept'] . '"/>';
        $chart .= '<set label="reject" value="' . $board_report[0]['reject'] . '"/>';
        $chart .= '<styles>
                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/fellow_report.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function media_chart($board_report)
    {
        $chart = '<chart caption="Seed Funding - Fund Utilized" yAxisName="Amount in Rs." bgColor="F7F7F7, E9E9E9" numVDivLines="10" divLineAlpha="30" labelPadding="10" yAxisValuesPadding="10" showValues="1" rotateValues="1" valuePosition="auto">';
        foreach ($board_report as $row):
            $chart .= '<set label="' . $row['budget'] . '" value="' . $row['fund_utilized'] . '"/>';
        endforeach;
        $chart .= '</chart>';
        $fh = fopen("source/charts/data/media_report.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function meeting_chart($board_report)
    {
        $chart = '<chart bgcolor="#fbfbfb" caption="" subcaption="" showPercentValues="1" decimals="1" baseFontSize="11">';
        $chart .= '<set label="total" value="' . $board_report[0]['id'] . '"/>';
        $chart .= '<styles>
                              <definition>
                              <style type="font" name="captionFont" size="15"/>
                              </definition>
                              <application>
                              <apply toObject="CAPTION" styles="captionFont"/>
                              </application>
                              </styles>
                              </chart>';
        $fh = fopen("source/charts/data/meeting_report.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function progress_chart($board_report)
    {
        $chart = '<chart bgcolor="#fbfbfb" caption="" subcaption="" showPercentValues="1" decimals="1" baseFontSize="11">';
        foreach ($board_report as $row):
            $chart .= '<set label="' . $row['year'] . '" value="' . $row['answer'] . '"/>';
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
        $fh = fopen("source/charts/data/progress_report.xml", "w");
        fwrite($fh, $chart);
        fclose($fh);
    }
    public function viewsfreport($id, $year)
    {
        $data['seedfunding_report'] = $this->mwglobal_report->getseedfunding_report($id, $year);
        $data['cpage'] = 'sf_report';
        $data['cpagetitle'] = 'Seedfunding Report';
        $this->load->view('../template_plain', $data);
    }
    public function viewboardreport($id, $year)
    {
        $data['board_report'] = $this->mwglobal_report->getboard_service($id, $year);
        $data['cpage'] = 'board_report';
        $data['cpagetitle'] = 'Seedfunding Report';
        $this->load->view('../template_plain', $data);
    }
    public function viewmediareport($id, $year)
    {
        $data['media_report'] = $this->mwglobal_report->getfundutilized_details($id, $year);
        $data['cpage'] = 'media_report';
        $data['cpagetitle'] = 'Seedfunding Report';
        $this->load->view('../template_plain', $data);
    }
    public function viewfellowreport($id, $year)
    {
        $data['fellow_report'] = $this->mwglobal_report->getfellow_service($id, $year);
        $data['cpage'] = 'fellow_report';
        $data['cpagetitle'] = 'Seedfunding Report';
        $this->load->view('../template_plain', $data);
    }
    public function progressreport($id, $year)
    {
        $data['progress_report'] = $this->mwglobal_report->getprogress_report($id, $year);
        $data['cpage'] = 'progress_report';
        $data['cpagetitle'] = 'Seedfunding Report';
        $this->load->view('../template_plain', $data);
    }
    public function viewboardmeetingreport($id, $year)
    {
        $data['quarterly'] = array('1', '2', '3', '4');
        $data['year'] = $year;
        $data['innovation'] = $id;
        for ($i = 0; $i < count($data['quarterly']); $i++) {
            $data['quartermeeting'][$i] = $this->mwglobal_report->getqmeeting_service($id, $data['quarterly'][$i], $year);
        }
        $data['cpage'] = 'meeting_report';
        $data['cpagetitle'] = 'Meeting Report';
        $this->load->view('../template_plain', $data);
    }
    public function changestatus($innovation)
    {
        redirect('exit_details/exitdetails/gradingDetails');
    }
}
