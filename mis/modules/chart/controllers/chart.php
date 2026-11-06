<?php

class Chart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Mauth->isLoggedCheck();
        $this->load->helper('url');
        $this->load->model('Chart_model');
        $this->load->model('master/Sector_model');
        $this->load->model('assessment/Massessment');
        $this->load->model('scouting/Minnovation');
    }

    /*
     * Main Function for Employee Login Which verifies the Given Username and Password with the Database
     * Get the User details and saved it in the Session Variable
     * Redirect to the Main Menu Page.
     */

    public function dashboardPieChart() {
        $program = $this->input->post("program");
        $partner_id = $this->session->userdata('partner_id');

        $start_date = $this->input->post("from_date");
        $end_date = $this->input->post("to_date");
        $start_date = !empty($start_date) ? $start_date . ' 00:00:00' : '';
        $end_date = !empty($end_date) ? $end_date . ' 23:59:59' : '';

        $sub_start_date = $this->input->post("sub_from_date");
        $sub_end_date = $this->input->post("sub_to_date");
        $sub_start_date = !empty($sub_start_date) ? $sub_start_date : '';
        $sub_end_date = !empty($sub_end_date) ? $sub_end_date : '';

        if ($program == 'Incubation') {
            if ($partner_id == '10') {
                $data['sector_details'] = $this->Sector_model->getPitchSectors();
                $data['details'] = $this->Chart_model->getStageSectorCount_Pitch($start_date, $end_date, $sub_start_date, $sub_end_date);
                $data['sector_count'] = $this->Chart_model->getPitchSector($start_date, $end_date, $sub_start_date, $sub_end_date);
                foreach ($data['sector_count'] as $key => $value) {
                    $get_sectorName = unserialize($value['sector']);
                    $data['sector_count'][$key]['sector_name'] = $get_sectorName[0];
                }

                $donorIds = array();
                $count = array();
                $masters = $this->Massessment->getDonorFit($partner_id);
                $data['donor_count'] = $this->Chart_model->getPitchDonor($start_date, $end_date, $sub_start_date, $sub_end_date);
                foreach ($data['donor_count'] as $key => $value) {
                    $donorIds[$key] = explode(",", $data['donor_count'][$key]['donor_fit']);
                    for ($i = 0; $i < php72_count($masters); $i++) {
                        if (php72_in_array($masters[$i]['id'], $donorIds[$key])) {
                            $count[$i] = $count[$i] + $data['donor_count'][$key]['count'];
                            $data['donors'][$i]['donor'] = $masters[$i]['id'];
                            $data['donors'][$i]['count'] = $count[$i];
                        }
                    }
                }

                foreach ($data['donors'] as $key => $value) {
                    $donor_name = $this->Sector_model->getDonorNameByID($value['donor']);
                    $data['donors'][$key]['donor_name'] = $donor_name;
                }

//                $data['city'] = $this->Chart_model->getCity();
//                $data['count'] = $this->Chart_model->getCityCount($start_date, $end_date, $sub_start_date, $sub_end_date);
            } else {
                $data['sector_details'] = $this->Sector_model->getIncSectors();
                $data['details'] = $this->Chart_model->getStageSectorCount($start_date, $end_date, $sub_start_date, $sub_end_date);
                $data['sector_count'] = $this->Chart_model->getSectorCount($start_date, $end_date, $sub_start_date, $sub_end_date);

                foreach ($data['sector_count'] as $key => $value) {
                    $sector_name = $this->Sector_model->getSectorNameByID($value['ent_sector']);
                    $data['sector_count'][$key]['sector_name'] = $sector_name;
                }

                $donorIds = array();
                $count = array();
                $masters = $this->Massessment->getDonorFit($partner_id);
                $data['donor_count'] = $this->Chart_model->getDonor($start_date, $end_date, $sub_start_date, $sub_end_date);
                foreach ($data['donor_count'] as $key => $value) {
                    $donorIds[$key] = explode(",", $data['donor_count'][$key]['donor_fit']);
                    for ($i = 0; $i < php72_count($masters); $i++) {
                        if (php72_in_array($masters[$i]['id'], $donorIds[$key])) {
                            $count[$i] = $count[$i] + $data['donor_count'][$key]['count'];
                            $data['donors'][$i]['donor'] = $masters[$i]['id'];
                            $data['donors'][$i]['count'] = $count[$i];
                        }
                    }
                }

                foreach ($data['donors'] as $key => $value) {
                    $donor_name = $this->Sector_model->getDonorNameByID($value['donor']);
                    $data['donors'][$key]['donor_name'] = $donor_name;
                }
            }
        } else if ($program == 'Pitch') {
            if ($partner_id != '10') {
                $data['sector_details'] = $this->Sector_model->getPitchSectors();
                $data['details'] = $this->Chart_model->getStageSectorCount_Pitch($start_date, $end_date, $sub_start_date, $sub_end_date);
                $data['sector_count'] = $this->Chart_model->getPitchSector($start_date, $end_date, $sub_start_date, $sub_end_date);

                foreach ($data['sector_count'] as $key => $value) {
                    $get_sectorName = unserialize($value['sector']);
                    $data['sector_count'][$key]['sector_name'] = $get_sectorName[0];
                }

                $donorIds = array();
                $count = array();
                $masters = $this->Massessment->getDonorFit($partner_id);
                $data['donor_count'] = $this->Chart_model->getPitchDonor($start_date, $end_date, $sub_start_date, $sub_end_date);
                foreach ($data['donor_count'] as $key => $value) {
                    $donorIds[$key] = explode(",", $data['donor_count'][$key]['donor_fit']);
                    for ($i = 0; $i < php72_count($masters); $i++) {
                        if (php72_in_array($masters[$i]['id'], $donorIds[$key])) {
                            $count[$i] = $count[$i] + $data['donor_count'][$key]['count'];
                            $data['donors'][$i]['donor'] = $masters[$i]['id'];
                            $data['donors'][$i]['count'] = $count[$i];
                        }
                    }
                }

                foreach ($data['donors'] as $key => $value) {
                    $donor_name = $this->Sector_model->getDonorNameByID($value['donor']);
                    $data['donors'][$key]['donor_name'] = $donor_name;
                }

                $data['city'] = $this->Chart_model->getCity();
                $data['count'] = $this->Chart_model->getCityCount($start_date, $end_date, $sub_start_date, $sub_end_date);
            }
        }

        // Chart based on city
        $data['healthcare'] = array();
        $data['agri_business'] = array();
        $data['others'] = array();
        $data['education'] = array();
        $data['clean_tech'] = array();
        $data['energy'] = array();
        $data['skill_dev'] = array();

        $data['agriculture_fish'] = $data['textile'] = $data['dairy'] = $data['fishery'] = array();

        foreach ($data['count'] as $key => $value) {
            // $sector_name = $this->Sector_model->getSectorNameByID($value['sector']);
            $get_sectorName = unserialize($value['sector']);
            $data['count'][$key]['sector_name'] = $get_sectorName[0];

            if ($data['count'][$key]['sector_name'] == 'Healthcare') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['healthcare'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Agri-business') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['agri_business'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Others') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['others'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Education') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['education'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'CleanTech') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['clean_tech'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Energy') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['energy'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Skill Development') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['skill_dev'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Agriculture & Fish') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['agriculture_fish'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Fishery') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['fishery'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Textile') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['textile'][$sector] = $values;
            }
            if ($data['count'][$key]['sector_name'] == 'Dairy') {
                $values = $data['count'][$key];
                $sector = $data['count'][$key]['city'];
                $data['dairy'][$sector] = $values;
            }
        }

        foreach ($data['city'] as $key => $value) {
            $city_name = $value['city'];
            if (php72_array_key_exists($city_name, $data['healthcare'])) {

            } else {
                $data['healthcare'][$city_name]['sector_name'] = 'healthcare';
                $data['healthcare'][$city_name]['city'] = $city_name;
                $data['healthcare'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['agri_business'])) {

            } else {
                $data['agri_business'][$city_name]['sector_name'] = 'agri-business';
                $data['agri_business'][$city_name]['city'] = $city_name;
                $data['agri_business'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['others'])) {

            } else {
                $data['others'][$city_name]['sector_name'] = 'others';
                $data['others'][$city_name]['city'] = $city_name;
                $data['others'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['education'])) {

            } else {
                $data['education'][$city_name]['sector_name'] = 'education';
                $data['education'][$city_name]['city'] = $city_name;
                $data['education'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['clean_tech'])) {

            } else {
                $data['clean_tech'][$city_name]['sector_name'] = 'clean_tech';
                $data['clean_tech'][$city_name]['city'] = $city_name;
                $data['clean_tech'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['energy'])) {

            } else {
                $data['energy'][$city_name]['sector_name'] = 'energy';
                $data['energy'][$city_name]['city'] = $city_name;
                $data['energy'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['skill_dev'])) {

            } else {
                $data['skill_dev'][$city_name]['sector_name'] = 'skill_dev';
                $data['skill_dev'][$city_name]['city'] = $city_name;
                $data['skill_dev'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['agriculture_fish'])) {

            } else {
                $data['agriculture_fish'][$city_name]['sector_name'] = 'agriculture_fish';
                $data['agriculture_fish'][$city_name]['city'] = $city_name;
                $data['agriculture_fish'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['fishery'])) {

            } else {
                $data['fishery'][$city_name]['sector_name'] = 'fishery';
                $data['fishery'][$city_name]['city'] = $city_name;
                $data['fishery'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['textile'])) {

            } else {
                $data['textile'][$city_name]['sector_name'] = 'textile';
                $data['textile'][$city_name]['city'] = $city_name;
                $data['textile'][$city_name]['all_count'] = 0;
            }
            if (php72_array_key_exists($city_name, $data['dairy'])) {

            } else {
                $data['dairy'][$city_name]['sector_name'] = 'dairy';
                $data['dairy'][$city_name]['city'] = $city_name;
                $data['dairy'][$city_name]['all_count'] = 0;
            }
        }
        ksort($data['healthcare']);
        ksort($data['agri_business']);
        ksort($data['others']);
        ksort($data['education']);
        ksort($data['clean_tech']);
        ksort($data['energy']);
        ksort($data['skill_dev']);
        ksort($data['agriculture_fish']);
        ksort($data['fishery']);
        ksort($data['textile']);
        ksort($data['dairy']);

        // Chart based on stage/status
        $data['applicationStage'] = array();
        $data['PA_RD_stage'] = array();
        foreach ($data['details'] as $key => $value) {
            $stage = $this->Minnovation->getInnvationStage();
            $stage_text = $stage[$data['details'][$key]['stage']];
            $data['details'][$key]['stage'] = $stage_text;

            $status = $this->Minnovation->getInnvationStatus();
            $status_text = $status[$data['details'][$key]['status']];
            $data['details'][$key]['status'] = $status_text;
            if ($data['details'][$key]['stage'] == 'Application') {
                $sector = $data['details'][$key]['sector'];
                $values = $data['details'][$key];
                $data['applicationStage'][$sector] = $values;
            }
            if ($data['details'][$key]['stage'] == 'PA/RD') {
                $sector = $data['details'][$key]['sector'];
                $values = $data['details'][$key];
                $data['PA_RD_stage'][$sector] = $values;
            }
        }

        foreach ($data['sector_details'] as $key => $value) {
            $id = $value['id'];
            if (php72_array_key_exists($id, $data['applicationStage'])) {

            } else {
                $data['applicationStage'][$id]['status'] = '';
                $data['applicationStage'][$id]['sector'] = $id;
                $data['applicationStage'][$id]['all_count'] = 0;
                $data['applicationStage'][$id]['Open_count'] = 0;
                $data['applicationStage'][$id]['Close_count'] = 0;
                $data['applicationStage'][$id]['stage'] = 'Application';
            }
            if (php72_array_key_exists($id, $data['PA_RD_stage'])) {

            } else {
                $data['PA_RD_stage'][$id]['status'] = '';
                $data['PA_RD_stage'][$id]['sector'] = $id;
                $data['PA_RD_stage'][$id]['all_count'] = 0;
                $data['PA_RD_stage'][$id]['Open_count'] = 0;
                $data['PA_RD_stage'][$id]['Close_count'] = 0;
                $data['PA_RD_stage'][$id]['stage'] = 'PA/RD';
            }
        }
        ksort($data['applicationStage']);
        ksort($data['PA_RD_stage']);

        $data['cpagetitle'] = "Dashboard";
        $data['cpage'] = "pie_chart";
        if ($program != '') {
            $body = $this->load->view('../dashboard_app_chart', $data);
            echo $body;
        } else {
            $this->load->view('../template', $data);
        }
    }

    //Get total number of assign incharges for incubation/pitch applications
    public function getDataTableValues() {
        $program = $this->input->post("program");
        $stage = $this->input->post("stage");
        $partner_id = $this->session->userdata('partner_id');

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $start_date = !empty($from_date) ? $from_date . ' 00:00:00' : '';
        $end_date = !empty($to_date) ? $to_date . ' 23:59:59' : '';

        $sub_start_date = $this->input->post("sub_from_date");
        $sub_end_date = $this->input->post("sub_to_date");
        $sub_start_date = !empty($sub_start_date) ? $sub_start_date : '';
        $sub_end_date = !empty($sub_end_date) ? $sub_end_date : '';
        $all_records = array();
        if ($program == 'Incubation') {
            if ($partner_id == '10') {
                $all_records = $this->Chart_model->getInchargeStatus_Pitch($start_date, $end_date, $sub_start_date, $sub_end_date, $stage);
            } else {
                $all_records = $this->Chart_model->getInchargeStatus($start_date, $end_date, $sub_start_date, $sub_end_date, $stage);
            }
        } else {
            if ($partner_id != '10') {
                $all_records = $this->Chart_model->getInchargeStatus_Pitch($start_date, $end_date, $sub_start_date, $sub_end_date, $stage);
            }
        }
        foreach ($all_records as $key => $value) {
            $emp_name = $this->Sector_model->getEmployeeNameByID($value['Emp_id']);
            $all_records[$key]['emp_name'] = $emp_name['emp_name'];
        }
        $openTotal = 0;
        $closeTotal = 0;
        $overallTotal = 0;
        foreach ($all_records as $r) {
            $total = $r['Open_count'] + $r['Close_count'] + $r['Open_IIC'] + $r['Close_IIC'];

            $openTotal += $r['Open_count'];
            $closeTotal += $r['Close_count'];
            $openIIC += $r['Open_IIC'];
            $closeIIC += $r['Close_IIC'];
            $overallTotal += $total;

            if ($r['emp_name'] != '' && php72_cmp($total) > 0) {
                $records[] = array(
                    $r['emp_name'],
                    $r['Open_count'],
                    $r['Close_count'],
                    $r['Open_IIC'],
                    $r['Close_IIC'],
                    $total,
                );
            }
        }
        $records[] = array(
            'Total',
            $openTotal,
            $closeTotal,
            $openIIC,
            $closeIIC,
            $overallTotal,
        );
        $output = array("data" => $records);
        echo json_encode($output);
    }

}
