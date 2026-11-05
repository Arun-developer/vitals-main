<?php

class Rejection extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Memail');
    }

    public function index() {
        if ($this->input->post('ImportFile')) {
            $ext = explode('.', $_FILES["close_file"]["name"]);

            if (!in_array($ext[1], array('xlsx', 'xls', 'csv'))) {
                $this->session->set_flashdata('errorMsg', 'Import Excel file');
                redirect('close/rejection');
            }

            $this->load->library('excel');

            $csv = "uploads/csv";
            if (!is_dir($csv)) {
                mkdir($csv);
            }

            $move_to = "$csv/" . $_FILES["close_file"]["name"];

            if (file_exists($move_to)) {
                unlink($move_to);
                move_uploaded_file($_FILES["close_file"]["tmp_name"], $move_to);
            } else {
                move_uploaded_file($_FILES["close_file"]["tmp_name"], $move_to);
            }

            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

            $objReader->setReadDataOnly(true);

            $objPHPExcel = $objReader->load($move_to);

            $objPHPExcel->setActiveSheetIndex(0);

            $sheet = $objPHPExcel->getActiveSheet();

            $highestColumn = $sheet->getHighestDataColumn(); // get max column value (E)

            $rowCount = 1;
            $count = 0;
            for ($column = 'A'; $column <= $highestColumn; $column++) {
                $column_name[$count] = $sheet->GetCell($column . $rowCount)->getValue();
                $count++;
            }

            // check for excel upload document format
            if ($column_name[0] != 'INV' || $column_name[1] != 'Name' || $column_name[2] != 'Status' || $column_name[3] != 'Reason' || $column_name[4] != 'Comments' ||
                    $column_name[5] != 'Send Rejection Email') {
                echo 'error in format';
                exit;
                redirect('close/rejection');
            }
            $sql = 'CREATE TABLE tbl_temp_close(';
            for ($a = 0; $a < $count; $a++) {

                $column_name[$a] = trim(preg_replace('/\s*\([^)]*\)/', '', $column_name[$a]));
                $column_name[$a] = str_replace(" ", "_", $column_name[$a]);
                $sql .= $column_name[$a] . ' VARCHAR(150), ';
            }

            $sql = substr($sql, 0, strlen($sql) - 2);
            $sql .= ',update_status VARCHAR(15),';
            $sql .= 'error_msg VARCHAR(500),';
            $sql .= ')';
            echo "<table border=\"1\"><th>InnovationId</th><th>Name</th><th>Status</th><th>Reason</th><th>Comments</th><th>Send Rejection Mail</th><th>Update Status</th><th>Error Message</th>";
            $success = 0;
            $j = 0; //for jump from first loop
            foreach ($sheet->getRowIterator() as $row) {
                $row->getRowIndex();

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $i = 0;
                foreach ($cellIterator as $cell) {
                    if ($j) { // jump from header
                        // Collect the data of the row:
                        $cell->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);
                        $data[$i] = $cell->getCalculatedValue();
                    }
                    $i++;
                }
                if ($j) { // jump from header
                    $err_msg = '';
                    $error = 0;
                    $this->db->select("IP.email_id,IP.id,DATE_FORMAT(IP.created_date,'%d-%m-%Y') as created_date,IP.name_of_entrepreneur", false);
                    $this->db->select("DATE_FORMAT(IFNULL(IFNULL(pitch_user.submitted_date, INV.submitted_date),EIR.date_submitted), '%d-%m-%Y') AS Submitted_Date");
                    $this->db->join('inv_user INV', 'INV.inv_no = IP.innovation_id', 'left');
                    $this->db->join('pitch_user', 'pitch_user.inno_id = IP.innovation_id', 'left');
                    $this->db->join('eir_user EIR', 'EIR.innovation_no = IP.innovation_id', 'left');
                    $this->db->where('innovation_id', $data[0]);
                    $query = $this->db->get('innovation_pool IP');
                    if ($query->num_rows() > 0) {

                        $details = $query->result_array();
                        $innovation_no = $details[0]['id'];
                        $to_mail = $details[0]['email_id'];
                        $this->db->where('status', '1');
                        $this->db->where('master_type', 'Reject Reasons');
                        $this->db->where('master_name', $data[3]);
                        $this->db->select('id');
                        $reason_id = $this->db->get('master_settings');

                        if ($reason_id->num_rows() > 0) {
                            $res = $reason_id->result_array();
                            $res_id = $res[0]['id'];
                            //updation takes place
                            $array = array('status' => '3', 'comments' => $data[4], 'reasons' => $res_id);
                            $this->db->where('innovation_id', $data[0]);
                            $this->db->update('innovation_pool', $array);
                            //mail action takes place
                            $this->db->where('messagetype', 'Rejection');
                            $template = $this->db->get('master_mailtemplate');
                            if ($data[5] == 'Yes') {
                                if ($template->num_rows() > 0) {
                                    $template1 = $template->result_array();

                                    $mail_template = $template1[0]['messagebody'];
                                    $org = array('#name_of_entrepreneur#', '#applied_date#');
                                    $replace = array($details[0]['name_of_entrepreneur'], $details[0]['Submitted_Date']);
                                    $messageBody = str_replace($org, $replace, $mail_template);

                                    $body = $this->imgUrl($messageBody);
                                    $datas = array('innovation' => $innovation_no,
                                        'from' => 'villgro.org',
                                        'to' => $to_mail,
                                        'mail_type' => 'Rejection',
                                        'sent_date' => date('Y-m-d'), //date($this->config->item('mysqlDate')),
                                        'subject' => 'Thank You for Contacting Villgro',
                                        'body' => $body,
                                        'send_by' => '',
                                    );
                                    $result = $this->db->insert('innovation_mail_history', $datas);

                                    $this->Memail->send('villgro.org', $to_mail, 'Thank You for Contacting Villgro', $body);
                                }
                            }
                        } else {
                            $error = 1;
                            $err_msg .= 'Unidentified reason. ';
                        }
                    } else {
                        $error = 1;
                        $err_msg .= 'Innovation Id is not valid. ';
                    }
                    //construct of table

                    if ($error) {
                        echo "<tr>";
                        echo "<td>" . $data[0] . "</td><td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td><td>" . $data[4] . "</td><td>" . $data[5] . "</td>";
                        echo "<td><b>Failed</b></td><td>" . $err_msg . "</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                        echo "<td>" . $data[0] . "</td><td>" . $data[1] . "</td><td>" . $data[2] . "</td><td>" . $data[3] . "</td><td>" . $data[4] . "</td><td>" . $data[5] . "</td>";
                        echo "<td>Success</td><td>-</td>";
                        echo "</tr>";
                    }
                }

                $j++;
            }
            echo "</table>";
        }
        $this->load->view('closeForm');
    }

    public function imgUrl($source) {
        $imgLink = '/S*src\s*=\s*[\""\']?([^\""\']*)/i';
        preg_match_all($imgLink, $source, $matches);
        $matchVal = array_filter($matches);
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
