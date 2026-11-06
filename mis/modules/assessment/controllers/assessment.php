<?php

class Assessment extends CI_Controller {
    /* This function is a constructor for the class Assessment here it is used to load the model master/Mmaster,Massessment,scouting/Minnovation,activities/Mactivities */

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Calcutta");
        $this->Mauth->isLoggedCheck();
        $this->load->model('master/Mmaster');
        $this->load->model('master/Sector_model');
        $this->load->model('Massessment');
        $this->load->model('scouting/Minnovation');
        $this->load->model('scouting/Mincharge');
        $this->load->model('activities/Mactivities');
        $this->load->model('login/Mdiligence');
        $this->load->model('login/Muser');
        $this->items_perpage = '15';
    }

    public function index() {
        echo "PAGE NOT FOUND";
    }

    /* This function is used to view the assessment criteria based on the innvoation */

    public function view_list($id = '') {
        $count = $this->Massessment->check_innovation($id);
        if ($count == '0') {
            $this->view_assesst($id);
        } else {
            $data = array();
            $assessDetails = array();
            $data['innovation'] = $this->Minnovation->getInnovation($id);
            $data['assigned_incharge'] = $assigned_incharge = $this->Mincharge->getAssociateId($id);
            $data['assessmentCriteria'] = $this->Massessment->getCriteria();
            $this->load->model('master/Mgrade');
            $data['gradesMasterList'] = $this->Mgrade->getGradeListByStage('5');
            $data['criteria'] = $this->Mmaster->getMasterSettings('Grading Category');
            foreach ($data['criteria'] as $row) {
                $assessDetails[$row['id']] = $this->Massessment->getAssessDetails($id, $row['id']);
            }

            if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
                $data['exist'] = $this->Massessment->checkassessexist($id, $this->session->userdata('emp_number'));
                if (php72_cmp($data['exist']) == 0 || $data['exist'] == '') {
                    $no_assigned = php72_count($assigned_incharge);
                    if ($no_assigned > 1) {
                        foreach ($assigned_incharge as $incharge) {
                            $assign_exist = $this->Massessment->checkassessexist($id, $incharge);
                            if (php72_cmp($assign_exist) != 0) {
                                $assigned_incharge[0] = $incharge;
                                break;
                            }
                        }
                    }
                    foreach ($data['criteria'] as $row) {
                        $assessDetails[$row['id']] = $this->Massessment->getAssessDetails($id, $row['id'], $ass_id = null, $assigned_incharge[0]);
                    }
                }
            }
            $data['files'] = $this->Massessment->getfiles($id);
            $data['assessDetails'] = $assessDetails;
            $data['cpagetitle'] = "Assessment";
            if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || php72_in_array($this->session->userdata('emp_number'), $assigned_incharge)) {
                $data['cpage'] = "assessment/assessment";
            } else {
                redirect('grading/view/' . $id);
            }

            $data['left_box'] = array('innovation_tab');
            $data['custom_js'] = array();

            $this->load->vars($data);
            $this->load->view('../template');
        }
    }

    /** function view_assesst
     * param - innovation id
     * loads the new preliminary assessment form
     */
    public function view_assesst($id, $option = null) {
        $data = array();
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['assigned_incharge'] = $assigned_incharge = $this->Mincharge->getActiveIncharge($id);
        $data['area'] = $area = $this->Massessment->getArea($data['innovation']['partner_id']);

        $this->load->model('master/Mmaster');
        $userSetup = $this->Mmaster->getUserSetup_branch($this->session->userdata('partner_id'));
        $data['emplist'] = $this->Muser->getUsersList($userSetup['abi'], $this->session->userdata('partner_id'));
        $data['assessors'] = $assessor = $this->Massessment->getAssessors($id);
        $data['inno_status'] = $this->Massessment->getInnoStatus($id);
        $data['reasons'] = $this->Massessment->getReasons('', $data['innovation']['partner_id']);
        $status = unserialize($assessor[0]['status']);
        $employee = unserialize($assessor[0]['assessor_id']);
        $assessor_emp = array();
        $i = 0;
        foreach ($status as $stat) {
            if (php72_cmp($stat) == 1) {
                if (!empty($employee)) {
                    $assessor_emp[] = $employee[$i];
                }
            }
            $i++;
        }

        $data['assesst_exist'] = $exist = $this->Massessment->assesstExist($id, $this->session->userdata('emp_number'));
        if ($exist) {
            /* -----Retrieving assesst records if exist----- */
            $data['assesst'] = $assesst = $this->Massessment->getAssesst($id, $this->session->userdata('emp_number'));
            $data['sub_assesst'] = $sub_assesst = $this->Massessment->getSubAssesst($data['assesst'][0]['id']);
        }
        $data['cpagetitle'] = "Assessment";

        /* -----Checking assign incharge for an innovation----- */
        if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) || in_array($this->session->userdata('emp_number'), $assessor_emp)) {
            $data['cpage'] = "assessment/assesst_form";
        } else {
            redirect('assessment/assess_summary/' . $id);
        }
        if ($option == 'export') {
            $this->load->library('Excel');
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()->setCreator("Villgro")
            ->setLastModifiedBy("Villgro")
            ->setTitle("Preliminary Assessment")
            ->setSubject("Preliminary Assessment")
            ->setDescription("Preliminary Assessment")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Preliminary Assessment");

            $objPHPExcel->setActiveSheetIndex(0);
            $styleuser = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '6C2C2C'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $stylepres = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '6C2C2C'),
                    'size' => 10,
                    'name' => 'Times New Roman',
                ));
            $stylepres1 = array(
                'font' => array(
                    'bold' => true,
                    'background-color' => array('rgb' => '05C62C'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $dataStyle = array('alignment' => array('wrap' => true, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
        );
            $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '1', 'Area');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '1', 'Enterprise Score');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', '1', 'NA');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('3', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', '1', 'No - 0');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('4', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', '1', 'Low - 1');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('5', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', '1', 'Medium - 2');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('6', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', '1', 'High - 3');
            $col = 0;
            $row = 1;

            if (isset($assesst)) {
                $area_id = unserialize($assesst[0]['area_id']);
                $score = unserialize($assesst[0]['score']);
                $rational = unserialize($assesst[0]['rational']);
                $risk = unserialize($assesst[0]['risk']);
            }

            $count_area = php72_count($area);
            foreach ($area as $area) {

                $col = 0;
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($stylepres);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $area['Name']);
                $col++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($stylepres);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $score[$area['id']]);

                $sub_category = $this->Massessment->getSubCategory($area['id']);
                $sub_count = php72_count($sub_category);
                $i = 0;
                if (isset($sub_assesst)) {
                    foreach ($sub_assesst as $sub) {

                        if ($area['id'] == $sub['area_id']) {
                            $category_id = unserialize($sub['sub_category']);
                            $sub_score = unserialize($sub['sub_score']);
                            $add_score = unserialize($sub['add_score']);
                        }
                    }
                }
                foreach ($sub_category as $sub) {
                    $addscore = '';
                    if (isset($category_id) && php72_in_array($sub['id'], $category_id)) {
                        $key = php72_array_search($sub['id'], $category_id);
                        $subscore = $sub_score[$key];
                        $addscore = $add_score[$key];
                    }
                    $i++;
                    $col = 0;
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['category']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $subscore = ($subscore != '-1') ? $subscore : "";
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $subscore);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    if (isset($addscore) && $addscore != '') {
                        $reason = $this->Massessment->getReasons($addscore, $data['innovation']['partner_id']);
                        $result = $reason[0]['name'];
                    } else {
                        $result = "";
                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['no']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['low']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['medium']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['high']);
                }
                $row++;
                $col = 0;
                $cols = 'A';
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'A8F9A2'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Rationale");
                $col = $col + 1;

                $col1 = ++$cols . $row;
                $col2 = ++$cols . $row;
                $mer = $col1 . ':' . $col2;
                $objPHPExcel->getActiveSheet()->mergeCells($mer);
                $objPHPExcel->getActiveSheet()->getStyle($mer)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'DFFFDC'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rational[$area['id']]);
                $col = $col + 2;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'A8F9A2'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Risk");
                $col = $col + 1;
                ++$cols;
                $col1 = ++$cols . $row;
                ++$cols;
                $col2 = ++$cols . $row;
                $mer = $col1 . ':' . $col2;
                $objPHPExcel->getActiveSheet()->mergeCells($mer);
                $objPHPExcel->getActiveSheet()->getStyle($mer)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'DFFFDC'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $risk[$area['id']]);
                $row++;
            }

            $col = 0;
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
            $col++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCF3FF'),
                ),
            ));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $assesst[0]['total_score']);
            $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL %");
            $col++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCF3FF'),
                ),
            ));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $assesst[0]['total_per']);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Preliminary Assessment.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');

            exit;
        }
        $data['log_details'] = $this->Mincharge->getStatusLog($id);

        $empName = array();
        $modified_employer = array();

        foreach ($data['log_details'] as $key => $value) {
            $employees = explode(",", $data['log_details'][$key]['assigned_user']);
            foreach ($employees as $k => $val) {
                $empName = $this->Sector_model->getEmployeeNameByID($employees[$k]);
                $employees[$k] = $empName['emp_name'];
            }
            $data['log_details'][$key]['assigned_incharge'] = implode(", ", $employees);
            $modified_employer = $this->Sector_model->getEmployeeNameByID($data['log_details'][$key]['modified_by']);
            $data['log_details'][$key]['modified_by_user'] = $modified_employer['emp_name'];
        }
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function view_assesst_detail($emp_id, $id, $option = null, $view = null) {
        $data = array();
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['area'] = $area = $this->Massessment->getArea($data['innovation']['partner_id']);

        $data['assesst'] = $assesst = $this->Massessment->getAssesst($id, $emp_id);
        $data['sub_assesst'] = $sub_assesst = $this->Massessment->getSubAssesst($data['assesst'][0]['id']);

        $data['cpagetitle'] = "Assessment Detail";
        $data['cpage'] = "assessment/assess_view";

        if ($option == 'export') {
            $this->load->library('Excel');
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()->setCreator("Villgro")
            ->setLastModifiedBy("Villgro")
            ->setTitle("Preliminary Assessment")
            ->setSubject("Preliminary Assessment")
            ->setDescription("Preliminary Assessment")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Preliminary Assessment");

            $objPHPExcel->setActiveSheetIndex(0);
            $styleuser = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '6C2C2C'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $stylepres = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '6C2C2C'),
                    'size' => 10,
                    'name' => 'Times New Roman',
                ));
            $stylepres1 = array(
                'font' => array(
                    'bold' => true,
                    'background-color' => array('rgb' => '05C62C'),
                    'size' => 11,
                    'name' => 'Times New Roman',
                ));
            $dataStyle = array('alignment' => array('wrap' => true, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP),
        );
            $objPHPExcel->getActiveSheet()->getStyle('A1:F' . $objPHPExcel->getActiveSheet()->getHighestRow())
            ->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('0', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0', '1', 'Area');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('1', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1', '1', 'Enterprise Score');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('2', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', '1', 'NA');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('3', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3', '1', 'No - 0');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('4', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4', '1', 'Low - 1');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('5', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5', '1', 'Medium - 2');
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow('6', '1')->applyFromArray($styleuser);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6', '1', 'High - 3');
            $col = 0;
            $row = 1;

            if (isset($assesst)) {
                $area_id = unserialize($assesst[0]['area_id']);
                $score = unserialize($assesst[0]['score']);
                $rational = unserialize($assesst[0]['rational']);
                $risk = unserialize($assesst[0]['risk']);
            }

            $count_area = php72_count($area);
            foreach ($area as $area) {

                $col = 0;
                $row++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($stylepres);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $area['Name']);
                $col++;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($stylepres);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $score[$area['id']]);

                $sub_category = $this->Massessment->getSubCategory($area['id']);
                $sub_count = php72_count($sub_category);
                $i = 0;

                if (isset($sub_assesst)) {
                    foreach ($sub_assesst as $sub) {
                        if ($area['id'] == $sub['area_id']) {
                            $category_id = unserialize($sub['sub_category']);
                            $sub_score = unserialize($sub['sub_score']);
                            $add_score = unserialize($sub['add_score']);
                        }
                    }
                }
                foreach ($sub_category as $sub) {
                    $addscore = '';
                    if (isset($category_id) && php72_in_array($sub['id'], $category_id)) {
                        $key = php72_array_search($sub['id'], $category_id);
                        $subscore = $sub_score[$key];
                        $addscore = $add_score[$key];
                    }
                    $i++;
                    $col = 0;
                    $row++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['category']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $subscore = ($subscore != '-1') ? $subscore : "";
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $subscore);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    if (isset($addscore) && $addscore != '') {
                        $reason = $this->Massessment->getReasons($addscore, $data['innovation']['partner_id']);
                        $result = $reason[0]['name'];
                    } else {
                        $result = "";
                    }
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $result);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['no']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['low']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['medium']);
                    $col++;
                    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray($dataStyle);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sub['high']);
                }
                $row++;
                $col = 0;
                $cols = 'A';
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'A8F9A2'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Rationale");
                $col = $col + 1;

                $col1 = ++$cols . $row;
                $col2 = ++$cols . $row;
                $mer = $col1 . ':' . $col2;
                $objPHPExcel->getActiveSheet()->mergeCells($mer);
                $objPHPExcel->getActiveSheet()->getStyle($mer)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'DFFFDC'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $rational[$area['id']]);
                $col = $col + 2;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'A8F9A2'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Risk");
                $col = $col + 1;
                ++$cols;
                $col1 = ++$cols . $row;
                ++$cols;
                $col2 = ++$cols . $row;
                $mer = $col1 . ':' . $col2;
                $objPHPExcel->getActiveSheet()->mergeCells($mer);
                $objPHPExcel->getActiveSheet()->getStyle($mer)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'DFFFDC'),
                    ),
                ));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $risk[$area['id']]);
                $row++;
            }

            $col = 0;
            $row++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
            $col++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCF3FF'),
                ),
            ));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $assesst[0]['total_score']);
            $col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL %");
            $col++;
            $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($col, $row)->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'CCF3FF'),
                ),
            ));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $assesst[0]['total_per']);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Preliminary Assessment.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();
            $objWriter->save('php://output');

            exit;
        }

        $this->load->vars($data);
        if ($view == '1') {
            $this->load->view('assessment/assess_view');
        } else {
            $this->load->view('../template');
        }
    }

    public function store_assesst() {

        $check_main = $check_individual = 0;
        foreach ($_POST['checkall'] as $check) {
            $check_main += php72_count($check);
        }
        foreach ($_POST['check'] as $check) {
            $check_individual += php72_count($check);
        }

        $rationale_string = preg_replace('/[^A-Za-z0-9\n\r\s\_ .,\/\@$%&*():;\'"?-]/', '', $_POST['rational']);
        $risk_string = preg_replace('/[^A-Za-z0-9\n\r\s\_ .,\/\@$%&*():;\'"?-]/', '', $_POST['risk']);

        $area_id = serialize($_POST['area_id']);
        $score = serialize($_POST['score']);
        $rational = serialize($rationale_string);
        $risk = serialize($risk_string);
        $table = "assest_detail";

        if ($_POST['total_score'] != '' || php72_cmp($check_main) > 0 || $check_individual > 0) {
            $score_enter = '1';
        } else {
            $score_enter = '0';
        }

        if ($_POST['assesst_id'] == "") {
            $data = array(
                "innovation_id" => $_POST['innovation_id'],
                "area_id" => $area_id,
                "score" => $score,
                "total_score" => $_POST['total_score'],
                "total_per" => $_POST['total_per'],
                "comment" => $_POST['comment'],
                "rational" => $rational,
                "risk" => $risk,
                "assesst_by" => $this->session->userdata('emp_number'),
                "assesst_date" => date("Y-m-d H:i:s"),
                "score_entered" => $score_enter
            );

            $assesst_id = $this->Massessment->insert_assesst($table, $data);
            $assigned_incharge = $this->Mincharge->getAssociateId($_POST['innovation_id']);
        } else {
            $data = array(
                "area_id" => $area_id,
                "score" => $score,
                "total_score" => $_POST['total_score'],
                "total_per" => $_POST['total_per'],
                "comment" => $_POST['comment'],
                "rational" => $rational,
                "risk" => $risk,
                "modified_by" => $this->session->userdata('emp_number'),
                "modified_date" => date("Y-m-d H:i:s"),
                "score_entered" => $score_enter
            );

            $where = array("innovation_id" => $_POST['innovation_id'], "id" => $_POST['assesst_id'], "assesst_by" => $this->session->userdata('emp_number'));
            $updated_rows = $this->Massessment->update_assesst($table, $data, $where);
            $msg = "Details Updated Successfully";
        }

        foreach ($_POST['area_id'] as $area) {
            $count = $_POST['sub_count'][$area];
            $sub_score[$area] = array();
            $sub_id[$area] = array();
            $add_score[$area] = array();
            for ($i = 1; $i <= $count; $i++) {
                if (isset($_POST['check'][$area . '_' . $i])) {
                    array_push($sub_id[$area], $_POST['category_id'][$area . '_' . $i]);
                    array_push($sub_score[$area], '-1');
                    array_push($add_score[$area], $_POST['reason'][$area . '_' . $i]);
                } else {

                    array_push($sub_id[$area], $_POST['category_id'][$area . '_' . $i]);
                    array_push($sub_score[$area], $_POST['sub'][$area . '_' . $i]);
                    array_push($add_score[$area], '');
                }
            }
            $table1 = "assesst_sub_cat_detail";
            if ($_POST['assesst_id'] == "") {
                $data1 = array(
                    "area_id" => $area,
                    "sub_category" => serialize($sub_id[$area]),
                    "sub_score" => serialize($sub_score[$area]),
                    "add_score" => serialize($add_score[$area]),
                    "assesst_detail_id" => $assesst_id,
                );
                $subcat_id = $this->Massessment->insert_assesst($table1, $data1);
            } else {
                $data1 = array(
                    "sub_category" => serialize($sub_id[$area]),
                    "sub_score" => serialize($sub_score[$area]),
                    "add_score" => serialize($add_score[$area]),
                );

                $where1 = array('area_id' => $area, "assesst_detail_id" => $_POST['assesst_id']);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
            }
        }
        $this->session->set_flashdata('successMsg', $msg);
        redirect('assessment/view_list/' . $_POST['innovation_id']);
    }

    public function assign_assessor() {
        $assessor = $this->Massessment->getAssessors($_POST['innovations']);

        $status = array();
        foreach ($_POST['assessor_employee'] as $emp) {
            $status[] = '1';
        }
        $employee = $_POST['assessor_employee'];
        $emp = serialize($employee);
        $status = serialize($status);

        $data = array(
            'innovation_id' => $_POST['innovations'],
            'assessor_id' => $emp,
            'status' => $status,
            'assigned_by' => $this->session->userdata('emp_number'),
            'assigned_date' => date("Y-m-d H:i:s"),
        );
        $table = 'assesst_assessors';
        if ($assessor) {
            $where = array('innovation_id' => $_POST['innovations']);
            $updated_rows = $this->Massessment->update_assesst($table, $data, $where);
        } else {
            $assign_id = $this->Massessment->insert_assesst($table, $data);
        }
        $msg = "Assessors Added Successfully";
        $this->session->set_flashdata('successMsg', $msg);
        redirect('assessment/view_list/' . $_POST['innovations']);
    }

    public function change_assessor_status($emp_id, $option, $inno_id) {
        $assessor = $this->Massessment->getAssessors($inno_id);
        $status = unserialize($assessor[0]['status']);
        $employee = unserialize($assessor[0]['assessor_id']);
        $assessor_emp = array();
        $i = 0;
        foreach ($status as $stat) {
            $assessor_emp[] = $employee[$i];
            $i++;
        }
        if ($emp_id != '') {
            $key = array_search($emp_id, $assessor_emp);
            $status[$key] = $option;
            $ser_status = serialize($status);
            $table = 'assesst_assessors';
            $data = array('status' => $ser_status);
            $where = array('innovation_id' => $inno_id);
            $updated_rows = $this->Massessment->update_assesst($table, $data, $where);
            $msg = "Assessors Status Updated Successfully";
        }
        $this->session->set_flashdata('successMsg', $msg);
        redirect('assessment/view_list/' . $inno_id);
    }

    public function assess_summary($id, $option = null) {
        $data['log_details'] = $this->Mincharge->getStatusLog($id);
        $data['iic_log_detail'] = $this->Mincharge->getIICLogDate($id);
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        $data['get_score'] = $this->Massessment->checkScoreAssesst($id);

        $empName = array();
        $modified_employer = array();

        foreach ($data['log_details'] as $key => $value) {
            $employees = explode(",", $data['log_details'][$key]['assigned_user']);
            foreach ($employees as $k => $val) {
                $empName = $this->Sector_model->getEmployeeNameByID($employees[$k]);
                $employees[$k] = $empName['emp_name'];
            }
            $data['log_details'][$key]['assigned_incharge'] = implode(", ", $employees);
            $modified_employer = $this->Sector_model->getEmployeeNameByID($data['log_details'][$key]['modified_by']);
            $data['log_details'][$key]['modified_by_user'] = $modified_employer['emp_name'];
        }

        $data['area'] = $this->Massessment->getArea($data['innovation']['partner_id']);
        $data['assigned_incharge'] = $assigned_incharge = $this->Mincharge->getAssociateId($id);
        $data['active_incharge'] = $active_incharge = $this->Mincharge->getActiveIncharge($id);
        $data['inno_status'] = $this->Massessment->getInnoStatus($id);
        $innovation = $this->Minnovation->getInnovation($id);
        // $data['donor_fit'] = $this->Massessment->getDonorFit($innovation['partner_id']);
        $cio_emp_id = $this->Mmaster->getEmpIdBySetUP('cio', $this->session->userdata('partner_id'));
        $data['cio_emp_num'] = $cio_emp_id[0]['cio'];

        $deals_donor = '';
        $data['feed_back_exist'] = $this->Massessment->feedbackCheck($id);
        if ($data['feed_back_exist']) {
            $data['feed_back'] = $this->Massessment->getFeedback($id);
            $deals_donor = $data['feed_back'][0]['donor_fit'];
        }
        if (!empty($assigned_incharge) && php72_in_array($this->session->userdata('emp_number'), $assigned_incharge)) {
            $data['assesst'] = $this->Massessment->getAssesst($id, $this->session->userdata('emp_number'));
        }

        $app_stage = $innovation['stage'];
        $app_status = $innovation['status'];

        $active_donor_fit = $existing_donor = $sortArray = array();
        $active_donor_fit = $this->Massessment->getDonorFit($innovation['partner_id']);
        if (($app_stage == '12' && $app_status == '12') || $app_status == '13' || $app_status == '17' || $app_status == '18' || $app_status == '20') {
            $existing_donor = $this->Massessment->getExistDonorFit($deals_donor);
        }

        $d_fitList = php72_array_merge($active_donor_fit, $existing_donor);
        foreach ($d_fitList as $fit) {
            foreach ($fit as $key => $value) {
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        }

        $orderby = "name";

        array_multisort($sortArray[$orderby], SORT_ASC, $d_fitList);
        $data['donor_fit'] = $d_fitList;

        $data['assessor'] = $this->Massessment->getAssessors($id);
        $this->load->model('master/Mmaster_settings');
        $data['reasonsList'] = $this->Mmaster_settings->getMasterSetting('Reject Reasons', $innovation['partner_id']);

        $data['cpagetitle'] = $innovation['name_of_enterprise'];
        $data['cpage'] = "assessment/assess_summary";
        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function store_summary() {
        $this->load->library('upload');
        $stage_data = array(
            'enterprise_stage' => (isset($_POST['stage'])) ? $_POST['stage'] : '',
        );
        $user_where = array('id' => $_POST['innovation_id']);
        $table = "innovation_pool";
        $this->Minnovation->pitch_update($table, $stage_data, $user_where);

        $partner_id = $this->session->userdata('partner_id');
        $assigned_incharge = $this->Mincharge->getAssociateId($_POST['innovation_id']);
        $innovation = $this->Minnovation->getInnovation($_POST['innovation_id']);
        $cio_emp_id = $this->Mmaster->getEmpIdBySetUP('cio', $this->session->userdata('partner_id'));
        $don_fit1 = explode(',', $_POST['donor_fit1']);
        $donor_fit = (isset($_POST['donor_fit'])) ? php72_implode(',', $_POST['donor_fit']) : $_POST['donor_fit1'];
        $fund_recom = array();
        $fund_approved = array();
        $don_fit = !empty($_POST['donor_fit']) ? $_POST['donor_fit'] : $don_fit1;
        if (isset($don_fit)) {
            foreach ($don_fit as $donor) {
                $fund_recom[] = ($_POST['fund_recom'][$donor] != '') ? $donor . '_' . $_POST['fund_recom'][$donor] : '0';
                $fund_approved[] = ($_POST['fund_approved'][$donor] != '') ? $donor . '_' . $_POST['fund_approved'][$donor] : '0';
            }
        }

        $time = date("H:i:s");
        $get_iic_date = $_POST['iic_date'] . ' ' . $time;
        $create_iic_log = date("Y-m-d H:i:s", strtotime($get_iic_date));

        $recom_fund = (!empty($fund_recom)) ? implode(',', $fund_recom) : '';
        $approved_fund = (!empty($fund_approved)) ? implode(',', $fund_approved) : '';
        $lis = (isset($_POST['LIS'])) ? $_POST['LIS'] : $_POST['LIS1'];

        if ($_POST['donor_fit'] == '') {
            $donor_up = $_POST['donor_fit'];
        } else {
            $donor_up = $donor_fit;
        }

        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_upload_path() . 'uploads/assessment';
        $user_doc_path = $iic_doc_path = '';

        if ($_FILES["user_doc"]["name"] != "") {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

            $file_name = explode('.', $_FILES["user_doc"]["name"]);
            $file_ext = end(explode('.', $_FILES["user_doc"]["name"]));
            $sliced = array_slice($file_name, 0, -1);
            $string = implode(" ", $sliced);
            $change_first = str_replace('.', '-', $string);

            $newfilename = preg_replace('/[^A-Za-z0-9\_.]/', '-', $change_first);
            $change_name = str_replace(' ', '-', $newfilename . '.' . $file_ext);
            $config['file_name'] = date('Ymdhis') . '_user_' . str_replace('_', '-', $change_name);

            $this->upload->initialize($config);

            $_FILES['user_doc_upload']['name'] = $_FILES['user_doc']['name'];
            $_FILES['user_doc_upload']['tmp_name'] = $_FILES['user_doc']['tmp_name'];
            $_FILES['user_doc_upload']['size'] = $_FILES['user_doc']['size'];
            $_FILES['user_doc_upload']['type'] = $_FILES['user_doc']['type'];
            $_FILES['user_doc_upload']['error'] = $_FILES['user_doc']['error'];

            if (!$this->upload->do_upload('user_doc_upload')) {
                $upload_error = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $user_doc_path = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['user_doc_old'])) {
            $user_doc_path = $_POST['user_doc_old'];
        }

        if ($_FILES["iic_doc"]["name"] != "") {
            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';

            $file_name = explode('.', $_FILES["iic_doc"]["name"]);
            $file_ext = end(explode('.', $_FILES["iic_doc"]["name"]));
            $sliced = array_slice($file_name, 0, -1);
            $string = implode(" ", $sliced);
            $change_first = str_replace('.', '-', $string);

            $newfilename = preg_replace('/[^A-Za-z0-9\_.]/', '-', $change_first);
            $change_name = str_replace(' ', '-', $newfilename . '.' . $file_ext);
            $config['file_name'] = date('Ymdhis') . '_iic_' . str_replace('_', '-', $change_name);

            $this->upload->initialize($config);

            $_FILES['iic_doc_upload']['name'] = $_FILES['iic_doc']['name'];
            $_FILES['iic_doc_upload']['tmp_name'] = $_FILES['iic_doc']['tmp_name'];
            $_FILES['iic_doc_upload']['size'] = $_FILES['iic_doc']['size'];
            $_FILES['iic_doc_upload']['type'] = $_FILES['iic_doc']['type'];
            $_FILES['iic_doc_upload']['error'] = $_FILES['iic_doc']['error'];

            if (!$this->upload->do_upload('iic_doc_upload')) {
                $upload_error = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $iic_doc_path = $upload_data['file_name'];
            }
            unset($config);
        } else if (isset($_POST['iic_doc_old'])) {
            $iic_doc_path = $_POST['iic_doc_old'];
        }

        $data = array(
            "feed_back" => (isset($_POST['comments'])) ? $_POST['comments'] : '',
            "result" => (isset($_POST['recomment'])) ? $_POST['recomment'] : '',
            "reject_reason" => (isset($_POST['reason'])) ? $_POST['reason'] : '',
            "LIS" => $lis,
            "donor_fit" => $donor_up,
            "fund_recom" => $recom_fund,
            "fund_approved" => $approved_fund,
            "innovation_id" => $_POST['innovation_id'],
            'user_document' => $this->db->escape_str($user_doc_path),
            'iic_document' => $this->db->escape_str($iic_doc_path)
        );

        if (isset($_POST['internal_status'])) {
            $data['internal_status'] = $_POST['internal_status'];
            $data['internal_comment'] = (isset($_POST['internal_comment'])) ? $_POST['internal_comment'] : '';
            $data['internal_date'] = $create_iic_log;
        }
        if ($this->session->userdata('emp_number') == $cio_emp_id[0]['cio']) {
            $score = serialize($_POST['score']);
            $rational = serialize($_POST['rational']);
            $risk = serialize($_POST['risk']);
            $data["score"] = (isset($_POST['total_score'])) ? $_POST['total_score'] : '';
            $data["per_score"] = (isset($_POST['total_per_cio'])) ? $_POST['total_per_cio'] : '';
            $data["area_score"] = $score;
            $data["rational"] = $rational;
            $data["risk"] = $risk;
            $data["cio_status"] = (isset($_POST['cio_status'])) ? $_POST['cio_status'] : '';
            $data["cio_comment"] = (isset($_POST['cio_comment'])) ? $_POST['cio_comment'] : '';
        }
        $table = "grading_feedback";

        if ($_POST['recomment'] != '' && $_POST['accept_reject'] == '1') {
            $data['userstatus_date'] = date("Y-m-d H:i:s");

            $ids = $_POST['innovation_id'];
            $employees = $this->Sector_model->getEmpId($ids);
            $emp_Ids = php72_array_map(function ($emp_Ids) {
                return $emp_Ids['associate_employee'];
            }, $employees);
            $employees_id = rtrim(implode(',', $emp_Ids), ',');

            $log_data = array(
                'innovation_id' => $_POST['innovation_id'],
                'stage' => $innovation['stage'],
                'assigned_user' => $employees_id,
                'modified_by' => $this->session->userdata('emp_number'),
                'modified_date' => date('Y-m-d H:i:s'),
            );

            /* -----User Accept/Reject------ */
            if ($_POST['recomment'] == 'Accept') {
                $log_data['status'] = 15;
            } else if ($_POST['recomment'] == 'Reject') {
                $this->session->set_userdata('close_action', 'yes');
                $log_data['status'] = 16;
                $data1 = array('status' => '3',
                    'close_status' => $innovation['status'],
                    "comments" => (isset($_POST['comments'])) ? $_POST['comments'] : '',
                    "reasons" => (isset($_POST['reason'])) ? $_POST['reason'] : '',
                    'reopen_status' => 0);
                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
            }

            $table_log = "application_status_log";
            $result = $this->Minnovation->pitch_insert($table_log, $log_data);
        }

        if ($_POST['feed_back_id'] == '') {
            $data['created_date'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->session->userdata('emp_number');
            $assign_id = $this->Massessment->insert_assesst($table, $data);
//            $msg = "Assessment Grading Added Successfully";
            $msg = "Deal submitted for IIC review";
        } else {
            $data['modified_date'] = date("Y-m-d H:i:s");
            $data['modified_by'] = $this->session->userdata('emp_number');

            $where = array('id' => $_POST['feed_back_id'], 'innovation_id' => $_POST['innovation_id']);
            $assign_id = $this->Massessment->update_assesst($table, $data, $where);
//            $msg = "Assessment Grading Updated Successfully";
            $msg = "Deal submitted for IIC review";
        }

        /* -----Internal IC Accept/Reject------ */
        if ($_POST['form_type'] == 'submit') {
            if ($_POST['internal_status'] == 'Accept' || $_POST['cio_status'] == 'Accept') {
                $ids = $_POST['innovation_id'];

                $invID = 'INV' . $ids;
                $innv_pool = $this->Mdiligence->get_data('innovation_pool', $invID);
                $mem_data = array();
                if (php72_cmp($innv_pool[0]['program']) == 0) {
                    $mem_data = $this->Mdiligence->getManageIncub($invID);
                } else if (php72_cmp($innv_pool[0]['program']) == 3 || php72_cmp($innv_pool[0]['program']) == 4) {
                    $mem_data = $this->Mdiligence->getManagePitch($invID);
                }

                foreach ($mem_data as $team) {
                    if ($team['name'] != '') {
                        $m_team['name'] = isset($team['name']) && $team['name'] != '' ? $team['name'] : '';
                        $m_team['mobile'] = isset($team['mobile']) && $team['mobile'] != '' ? $team['mobile'] : '';
                        $m_team['email'] = isset($team['email']) && $team['email'] != '' ? $team['email'] : '';
                        $m_team['design'] = isset($team['desg']) && $team['desg'] != '' ? $team['desg'] : '';
                        $m_team['created_date'] = date('Y-m-d H:i:s');
                        $m_team['innovation_id'] = $invID;
                        $table = "management_team";
                        $result = $this->Minnovation->pitch_insert($table, $m_team);
                    }
                }

                $employees = $this->Sector_model->getEmpId($ids);

                $emp_Ids = php72_array_map(function ($emp_Ids) {
                    return $emp_Ids['associate_employee'];
                }, $employees);
                $employees_id = rtrim(implode(',', $emp_Ids), ',');

                $log_data = array(
                    'innovation_id' => $_POST['innovation_id'],
                    'stage' => 9,
                    'status' => 13,
                    'assigned_user' => $employees_id,
                    'modified_by' => $this->session->userdata('emp_number'),
                    'modified_date' => $create_iic_log,
                );

                $table_log = "application_status_log";
                $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                $status = '13';
                $stage = '9';

                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $data1 = array('status' => $status, 'stage' => $stage);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
            } else if ($_POST['internal_status'] == 'Reject' || $_POST['cio_status'] == 'Reject') {
                $this->session->set_userdata('close_action', 'yes');
                $ids = $_POST['innovation_id'];
                $employees = $this->Sector_model->getEmpId($ids);

                $emp_Ids = php72_array_map(function ($emp_Ids) {
                    return $emp_Ids['associate_employee'];
                }, $employees);
                $employees_id = rtrim(implode(',', $emp_Ids), ',');

                $log_data = array(
                    'innovation_id' => $_POST['innovation_id'],
                    'stage' => 8,
                    'status' => 14,
                    'assigned_user' => $employees_id,
                    'modified_by' => $this->session->userdata('emp_number'),
                    'modified_date' => $create_iic_log,
                );

                $table_log = "application_status_log";
                $result = $this->Minnovation->pitch_insert($table_log, $log_data);

                $status = '14';
                $stage = '8';

                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $data1 = array('status' => $status, 'stage' => $stage);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);

                $table1 = 'innovation_pool';
                $where1 = array('id' => $_POST['innovation_id']);
                $data1 = array('status' => $status);
                $updated_rows = $this->Massessment->update_assesst($table1, $data1, $where1);
                //////////////////// Rejection mail sending process///////////////////////
                $this->db->select("email_id,id,created_date,name_of_entrepreneur");
                $this->db->where('id', $_POST['innovation_id']);
                $query = $this->db->get('innovation_pool');
                $details = $query->result_array();
                $innovation_no = $details[0]['id'];
                $to_mail = $details[0]['email_id'];
                $date = $details[0]['created_date'];
                $createDate = new DateTime($date);
                $strip = $createDate->format('Y-m-d');
                $this->db->where('messagetype', 'Rejection');
                $this->db->where('partner_id', $partner_id);
                $template = $this->db->get('master_mailtemplate');
                if ($template->num_rows() > 0) {
                    $template1 = $template->result_array();
                    $mail_template = $template1[0]['messagebody'];
                    $org = array('#name_of_entrepreneur#', '#applied_date#');
                    $replace = array($details[0]['name_of_entrepreneur'], $strip);
                    $messageBody = str_replace($org, $replace, $mail_template);
                    if (php72_cmp($partner_id) == 1) {
                        $body = $this->imgUrl($messageBody);
                    } else {
                        $body = $messageBody;
                    }
                }
                //////////////////// Rejection mail sending process ends /////////////////
            }
        }
        $this->session->set_flashdata('successMsg', $msg);
        redirect('assessment/assess_summary/' . $_POST['innovation_id']);
    }

    public function getscore() {
        $emp_id = $_POST['id'];
        $innovation = $_POST['innov'];
        $feedback = $this->Massessment->getAssesst($innovation, $emp_id);
        $area = unserialize($feedback[0]['area_id']);
        $output['area'] = $area;
        $score = unserialize($feedback[0]['score']);
        foreach ($area as $are) {
            $output[$are] = $score[$are];
        }
        $output['total_score'] = $feedback[0]['total_score'];
        $output['total_per'] = $feedback[0]['total_per'];
        echo json_encode($output);
    }

    /* This function is used to view the details of the assessment done for the particular innovation */

    public function view_details($id, $criteria = '', $asses_id = '') {
        $data['innovation'] = $this->Minnovation->getInnovation($id);
        if ($criteria != '') {
            $data['criteria'] = $this->Mmaster->getMasterSettingsDetails($criteria);
        } else {
            $data['criteria'] = $this->Mmaster->getMasterSettings('Grading Category');
        }

        $this->load->model('grading/Mgrading');
        $data['gradingDetails'] = $this->Mgrading->getGradingDetailsbyinnovation($id);
        $data['cpagetitle'] = "Assessment Details";
        $data['cpage'] = "assessment/view_assess_details";
        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function form($id, $criteria, $asses_id = '') {
        $data['criteria'] = $criteria;
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);
        $this->load->model('master/Mgrade');
        $data['gradesMasterList'] = $this->Mgrade->getGradeListByStage('5');
        $data['upload_error'] = array();
        if ($this->input->post('txtSubmit') != '') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('description', 'Description', 'required');
            if ($this->form_validation->run() != false) {
                $_POST['documents'] = $_FILES['documents']['name'];
                if ($_FILES['documents']['name'] != '') {
                    $config['upload_path'] = './uploads/assessment';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|doc';
                    $config['file_name'] = $_FILES['documents']['name'];
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('documents')) {
                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $upload_data = $this->upload->data();
                        $_POST['documents'] = $upload_data['file_name'];
                    }
                }
                if ($_POST['id'] == '') {
                    $this->Massessment->insert($id, $criteria, $_POST);
                    $this->Massessment->insertgrading($id, $criteria, $_POST);
                    $this->session->set_flashdata('successMsg', 'Details added Successfully!');
                } else {
                    if ($_POST['documents'] != '') {
                        unlink('uploads/assessment/' . $_POST['olddocument']);
                    } else {
                        $_POST['documents'] = $_POST['olddocument'];
                    }

                    $this->Massessment->update($_POST);
                    $this->session->set_flashdata('successMsg', 'Details added Successfully!');
                }
                redirect('assessment/view_details/' . $id . '/' . $criteria);
            } else {
                $data['errorMsg'] = "Validation Error! Please Check it!";
            }
        }

        //edit option
        $data['assessInfo'] = array();
        $data['cpagetitle'] = "Assessment - Add Details";
        if ($asses_id != '') {
            $data['assessInfo'] = $this->Massessment->getAssessDetails($id, $criteria, $asses_id);
            $data['gradevalue'] = $this->Massessment->getAssessGradeDetails($id, $criteria, $asses_id); //adding grade value

            $data['cpagetitle'] = "Assessment - Edit Details";
        }
        $data['cpage'] = "assessment/form";

        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function delete_details($id, $criteria, $asses_id) {
        if ($asses_id != '') {
            $data['assessDetails'] = $this->Massessment->getAssessDetails($id, $criteria, $asses_id);
            $this->Massessment->deleteDetails($asses_id);
            $this->Massessment->deletegrade($id, $criteria);
            @unlink('uploads/assessment/' . $assessDetails['0']['documents']);
            $this->session->set_flashdata('successMsg', 'Record Deleted Successfully!');
        }
        redirect('assessment/view_details/' . $id);
    }

    #adding comments

    public function add_comments($id, $criteria, $asses_id = '', $option = '') {
        if ($this->input->post('txtSubmit') != '') {
            $this->Massessment->insertComments($asses_id, $_POST);
            #comments mail
            $this->load->model('common/Minnovation_mail');
            $this->session->set_flashdata('successMsg', 'Details added Successfully!');
            if ($option == '') {
                redirect('assessment/view_details/' . $id . '/' . $criteria);
            } else {
                redirect('assessment/view_details/' . $id);
            }
        }
    }

    public function delete_comments($id, $criteria, $comment_id = '') {
        if ($comment_id != '') {
            $this->Massessment->deleteComments($comment_id);
            $this->session->set_flashdata('successMsg', 'Record Deleted Successfully!');
        }
        redirect('assessment/view_details/' . $id);
    }

    public function next_grading($id) {
        $activity = $this->Mactivities->getActivityForGrading($id);

        if (php72_count($activity)) {
            redirect('grading/view/' . $this->uri->segment('3'));
        } else {
            $form['program_stage'] = '5';
            $form['activity_type'] = '29';
            $form['activity_description'] = 'Assessment Greading';
            $form['start_date'] = date("m/d/Y");
            $form['end_date'] = '';
            $id = $this->Mactivities->insert($id, $form);
            redirect('grading/view/' . $this->uri->segment('3'));
        }
    }

    public function create_document($id, $criteria = '', $asses_id = '') {
        $data['innovationInfo'] = $innovationInfo = $this->Minnovation->getInnovation($id);
        $data['assessDetails'] = $this->Massessment->getAssessDetails($id, $criteria, $asses_id);
        $data['cpage'] = 'assessment/create_document';
        $data['cpagetitle'] = "Assessment";
        $this->load->vars($data);
        $word = $this->load->view('../template_plain');
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Assessment_" . str_replace(' ', '-', $innovationInfo['name_of_enterprise']) . "_" . str_replace(' ', '-', $innovationInfo['name_of_entrepreneur']) . ".doc");
        echo $word;
    }

    public function formwizard($id, $asses_id = '', $cri) {
        $data['innovation'] = $innovation = $this->Minnovation->getInnovation($id);
        $data['cri'] = $cri;
        $this->load->model('master/Mgrade');
        $data['gradesMasterList'] = $this->Mgrade->getGradeListByStage('5');
        $data['upload_error'] = array();
        if (!empty($_POST)) {
            foreach ($_FILES['documents']['name'] as $key => $value):
                if ($_FILES['documents']['name'] != '') {

                    $filename = $_FILES['documents']['name'][$key];
                    $_FILES['ty']['name'] = $_FILES['documents']['name'][$key];
                    $_FILES['ty']['tmp_name'] = $_FILES['documents']['tmp_name'][$key];
                    $_FILES['ty']['size'] = $_FILES['documents']['size'][$key];
                    $_FILES['ty']['error'] = $_FILES['documents']['error'][$key];
                    $_FILES['ty']['type'] = $_FILES['documents']['type'][$key];

                    $config['upload_path'] = './uploads/assessment';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = date('YmdHis') . $filename;
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('ty')) {
                        $data['upload_error'] = $this->upload->display_errors();
                    } else {
                        $upload_data = $this->upload->data();
                        $_POST['files'][$key] = $upload_data['file_name'];
                    }
                }
                unset($config);

            endforeach;
            $this->Massessment->insertFormWizard($id, $_POST);
            $this->Massessment->insertgradingFormWizard($id, $_POST);
            $this->Massessment->insertUpFiles($id, $_POST);
            $this->session->set_flashdata('successMsg', 'Details added Successfully!');
            redirect('assessment/view_list/' . $id);
        }
        $data['cpagetitle'] = "Assessment Form";
        $data['cpage'] = "assessment/form_wizard";

        $data['left_box'] = array('innovation_tab');
        $data['custom_js'] = array();

        $this->load->vars($data);
        $this->load->view('../template');
    }

    public function linkdoc($id) {
        $data['linkdoc'] = $this->Massessment->getlinkdoc($id);
        $data['cpage'] = 'listmedia';
        $data['cpagetitle'] = "Assessment Link and Document";
        $this->load->vars($data);
        $this->load->view('../template_plain');
    }

    public function imgUrl($source) {
        $imgLink = '/S*src\s*=\s*[\""\']?([^\""\']*)/i';
        preg_match_all($imgLink, $source, $matches);
        $matchVal = php72_array_filter($matches);
        $count = count($matchVal);
        if ($count != 0) {
            $imageArray = $matchVal['1'];
            foreach ($imageArray as $key => $img):
                $imgArray[] = $img;
                $imgFullPath[] = base_url() . str_replace('../', '', $img);

            endforeach;
            $source = str_replace($imgArray, $imgFullPath, $source);
        } //count the array elements

        return $source;
    }

}
