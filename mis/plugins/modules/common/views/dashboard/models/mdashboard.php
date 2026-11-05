<?php
class Mdashboard extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
        $this->load->model('master/Mmaster_settings');
    }
    public function getservice()
    {
        $query = "SELECT title FROM program_service_offering";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getsourcewise($year = null)
    {
        $data = array();
        $query = "SELECT count(IP.id) as total,MS.master_name from innovation_pool as IP JOIN source_master as SM ON(IP.source = SM.id) JOIN master_settings as MS ON(SM.source_type = MS.id) where MS.master_type = 'Source Type' and extract(YEAR from IP.created_date) = '" . $year . "' GROUP BY IP.source";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getemployeewise($year = null)
    {
        $data = array();
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = AA.associate_employee) as emp_name", false);
        $this->db->select("count(IP.id) as total");
        $this->db->join('innovation_pool IP', 'IP.id = AA.innovation', 'left');
        $this->db->where('(extract(YEAR from IP.created_date))=', $year);
        $this->db->group_by('AA.associate_employee');
        $query = $this->db->get('assign_associate AA');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return array_reverse($data);
    }
    public function getemployeename($employee)
    {
        $data = array();
        $query = "select emp_firstname from villtest_hris.hs_hr_employee where emp_number IN('" . implode("','", $employee) . "')";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;

    }
    public function getserviceoffering($year = null)
    {
        $data = array();
        $query = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_4,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_5,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_6,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total6,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_7,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total7,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_8,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total8,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_9,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total9,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_10,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total10
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) where extract(YEAR FROM IP.created_date) = '" . $year . "' GROUP BY EXTRACT(YEAR FROM IP.created_date)";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getincubation()
    {
        $query = "SELECT name_of_enterprise,id FROM innovation_pool";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function sourcesearchireport($source)
    {
        $data = array();
        $query = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_0,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total0,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_1,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total1,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_2,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total2,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_3,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total3,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_4,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_5,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_6,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total6
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) where IP.NAME_OF_ENTERPRISE = '" . $source . "' GROUP BY EXTRACT(YEAR FROM IP.created_date)";
        $result = $this->db->query($query);
        return $result->result_array();

    }
    public function employeesearchireport($employee)
    {
        $query = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,IP.name_of_enterprise,HE.emp_firstname,HE.emp_number,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_0,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total0,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_1,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total1,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_2,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total2,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_3,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total3,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_4,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_5,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_6,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total6
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) LEFT OUTER JOIN assign_associate as AA ON
                                AA.innovation = IP.id LEFT OUTER JOIN villtest_hris.hs_hr_employee as HE ON
                                HE.emp_number = AA.associate_employee
                                 WHERE HE.emp_firstname = '" . $employee . "' GROUP BY IP.stage,IP.source ORDER BY EXTRACT(YEAR FROM IP.created_date) DESC";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function sectorsearchireport($sector)
    {
        $query = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,IP.name_of_enterprise,S.answer,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_0,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total0,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_1,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total1,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_2,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total2,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_3,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total3,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_4,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_5,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_6,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total6
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) LEFT OUTER JOIN screening as S ON (IP.id = S.innovation) WHERE S.answer = '" . $sector . "' GROUP BY IP.stage,EXTRACT(YEAR FROM IP.created_date)";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getincubationservice()
    {
        $data = array();
        $query = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_4,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_5,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_6,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total6,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_7,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total7,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_8,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total8,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_9,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total9,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_10,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total10
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) where extract(YEAR FROM IP.created_date) = '2012' GROUP BY EXTRACT(YEAR FROM IP.created_date)";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;

    }
    public function getstagewise($year = null)
    {
        $data = array();
        $query = "SELECT count(id) as value,stage,EXTRACT(YEAR FROM created_date) as year from innovation_pool GROUP BY stage,EXTRACT(YEAR FROM created_date)";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function getmetrics()
    {
        $query = "SELECT label from progress_master where type='metrices'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getsalesreportbyyear()
    {
        $query = "SELECT DISTINCT EXTRACT( YEAR FROM P.start_date ) AS YEAR
                    FROM progress AS P
                    JOIN innovation_pool AS IP ON ( P.innovation = IP.id )
                    WHERE P.field =  '251'
                    ORDER BY 1
                    LIMIT 0 , 30";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getsalesreport()
    {
        $data = array();
        $query = "SELECT C.YEAR, C.NAME_OF_ENTERPRISE, D.TOTAL FROM
(
SELECT A.YEAR, B.NAME_OF_ENTERPRISE FROM
( SELECT DISTINCT EXTRACT( YEAR FROM P.start_date ) AS YEAR FROM progress AS P JOIN innovation_pool AS IP ON ( P.innovation = IP.id ) WHERE P.field =  '251' ) A,
( SELECT DISTINCT IP.name_of_enterprise FROM progress AS P JOIN innovation_pool AS IP ON ( P.innovation = IP.id ) WHERE P.field =  '251' ) B
) C
LEFT OUTER JOIN
(
SELECT sum(P.answer) as total,EXTRACT(YEAR FROM P.start_date) as year,IP.name_of_enterprise from progress as P JOIN innovation_pool as IP ON (P.innovation = IP.id) where P.field='251' GROUP BY  P.innovation,EXTRACT(YEAR FROM P.start_date) order by year, name_of_enterprise
) D ON C.YEAR = D.YEAR AND C.NAME_OF_ENTERPRISE = D.NAME_OF_ENTERPRISE
ORDER BY C.NAME_OF_ENTERPRISE, C.YEAR ";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getprogress_report()
    {
        $query = "SELECT IP.name_of_enterprise,sum(P.answer) as total,EXTRACT(YEAR FROM IP.created_date) as year from progress as P JOIN innovation_pool as IP ON(P.innovation = IP.id) where P.field='251'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getstagereportbyyear()
    {
        $data = array();
        $query = "SELECT count(id),stage from innovatio_pool ORDER BY EXTRACT(YEAR FROM created_date) GROUP BY start_date";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getsource()
    {
        $data = array();
        $query = "SELECT master_name from master_settings where master_type = 'Source Type'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getemployee()
    {
        $data = array();
        $query = "SELECT emp_firstname as emp_name,emp_number from hs_hr_employee LIMIT 0,5";
        $result = $this->hris->query($query);
        return $result->result_array();
    }
    public function getproduct()
    {
        $data = array();
        $query = "SELECT answer from screening where field = 78";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getsector()
    {
        $data = array();
        $query = "SELECT value as answer from screening_master where id = 80";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = unserialize($row['answer']);
        }
        return $data;
    }
    public function scoutingyearreport($year = null)
    {
        $data = array();
        $query = "SELECT count(id) as value,stage,EXTRACT(QUARTER FROM created_date) as quarter,EXTRACT(YEAR FROM created_date) as year from innovation_pool GROUP BY stage,EXTRACT(YEAR FROM created_date)";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function scoutingmonthreport()
    {
        $data = array();
        $query = "SELECT count(id) as value,stage,EXTRACT(MONTH FROM created_date) as month,EXTRACT(QUARTER FROM created_date) as quarter,EXTRACT(YEAR FROM created_date) as year from innovation_pool GROUP BY stage,EXTRACT(YEAR FROM created_date)";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    public function employeesearchreport($employee)
    {
        $query = "SELECT CONCAT(HE.emp_firstname,HE.emp_lastname) as year,HE.emp_number,count(IP.id) as value,IP.stage FROM
                                innovation_pool as IP LEFT OUTER JOIN assign_associate as AA ON
                                AA.innovation = IP.id
                                LEFT OUTER JOIN villtest_hris.hs_hr_employee as HE ON
                                HE.emp_number = AA.associate_employee
                                 WHERE HE.emp_firstname like '%" . $employee . "%'";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function sectorsearchreport($sector)
    {
        $query = "SELECT IP.name_of_enterprise,S.answer,EXTRACT(YEAR FROM IP.created_date) as year,IP.stage,count(IP.id) as value from innovation_pool as IP LEFT OUTER JOIN screening as S ON(IP.id = S.innovation) JOIN screening_master as SM ON(S.field = SM.id) WHERE SM.id = '80' and  S.answer IN('" . implode("','", $sector) . "') GROUP BY IP.stage,EXTRACT(YEAR FROM IP.created_date)";
        $result = $this->db->query($query);
        return $result->result_array();

    }
    public function sourceyearreport($source)
    {
        $query = "SELECT MS.master_name as year,count(IP.id) as value,IP.stage FROM master_settings as MS LEFT OUTER JOIN source_master as SM ON
  SM.source_type = MS.id  LEFT OUTER JOIN innovation_pool as IP ON SM.id = IP.source WHERE MS.master_type = 'Source Type' and MS.master_name IN ('" . $source . "')";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function sourcecompare($source = null, $employee = null, $sector = null)
    {
        $source = array_pop($source);
        $employee = array_pop($employee);
        $sector = array_pop($sector);
        if ($source['0'] == "" && $employee['0'] == "" && $sector['0'] == "") {

            $query = "SELECT count(id) as value,stage,EXTRACT(YEAR FROM created_date) as year from innovation_pool GROUP BY stage,EXTRACT(YEAR FROM created_date)";
            $result = $this->db->query($query);
            return $result->result_array();
        } elseif ($employee['0'] == "" && $source['0'] != "" && $sector['0'] == "") {
            $query1 = "SELECT MS.master_name,count(IP.id) as VALUE,IP.stage,EXTRACT(YEAR FROM IP.created_date) as year FROM
  master_settings as MS LEFT OUTER JOIN source_master as SM ON
  SM.source_type = MS.id  LEFT OUTER JOIN innovation_pool as IP ON SM.id = IP.source WHERE  MS.master_type = 'Source Type' and MS.master_name IN('" . implode("','", $source) . "') GROUP BY IP.stage,IP.source ORDER BY EXTRACT(YEAR FROM IP.created_date) DESC";
            $result1 = $this->db->query($query1);
            return $result1->result_array();
        } elseif ($employee['0'] == "" && $source['0'] == "" && $sector['0'] != "") {
            $query1 = "SELECT IP.name_of_enterprise,S.answer,EXTRACT(YEAR FROM IP.created_date) as year,IP.stage,count(IP.id) as VALUE from innovation_pool as IP LEFT OUTER JOIN screening as S ON(IP.id = S.innovation) WHERE S.answer IN('" . implode("','", $sector) . "') GROUP BY IP.stage,EXTRACT(YEAR FROM IP.created_date)";
            $result1 = $this->db->query($query1);

            return $result1->result_array();
        } elseif ($source['0'] == "" && $employee['0'] != "" && $sector['0'] == "") {

            $query2 = "SELECT HE.emp_firstname,HE.emp_number,count(IP.id) as VALUE,IP.stage,EXTRACT(YEAR FROM IP.created_date) as year FROM
                                innovation_pool as IP LEFT OUTER JOIN assign_associate as AA ON
                                AA.innovation = IP.id
                                LEFT OUTER JOIN villtest_hris.hs_hr_employee as HE ON
                                HE.emp_number = AA.associate_employee
                                 WHERE HE.emp_number IN('" . implode("','", $employee) . "') GROUP BY IP.stage,IP.source ORDER BY EXTRACT(YEAR FROM IP.created_date) DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        } elseif ($source['0'] != "" && $employee['0'] != "" && $sector['0'] == "") {
            $query3 = "SELECT MS.master_name,HE.emp_firstname,HE.emp_number,count(IP.id) as VALUE,IP.stage,EXTRACT(YEAR FROM IP.created_date) as year FROM  master_settings as MS LEFT OUTER JOIN source_master as SM ON SM.source_type = MS.id  LEFT OUTER JOIN innovation_pool as IP ON  SM.id = IP.source LEFT OUTER JOIN assign_associate as AA ON  AA.innovation = IP.id LEFT OUTER JOIN villtest_hris.hs_hr_employee as HE ON HE.emp_number = AA.associate_employee WHERE HE.emp_number IN('" . implode("','", $employee) . "') and MS.master_type = 'Source Type' and MS.master_name IN('" . implode("','", $source) . "') GROUP BY IP.stage,IP.source ORDER BY EXTRACT(YEAR FROM IP.created_date) DESC";
            $result3 = $this->db->query($query3);
            return $result3->result_array();
        } elseif ($source['0'] != "" && $employee['0'] == "" && $sector['0'] != "") {
            $dbquery = "SELECT MS.master_name,IP.name_of_enterprise,S.answer,EXTRACT(YEAR FROM IP.created_date) as year,IP.stage,count(IP.id) as VALUE from innovation_pool as IP LEFT OUTER JOIN screening as S ON(IP.id = S.innovation) LEFT OUTER JOIN source_master as SM ON (SM.id= IP.source) LEFT OUTER JOIN master_settings as MS ON(MS.id = SM.source_type) WHERE S.answer IN('" . implode("','", $sector) . "') and MS.master_type = 'Source Type' and MS.master_name IN('" . implode("','", $source) . "') GROUP BY IP.stage,EXTRACT(YEAR FROM IP.created_date)";
            $result4 = $this->db->query($dbquery);
            return $result4->result_array();
        }

    }
    public function incubationcompare($service = null, $employee = null, $sector = null)
    {
        $service = array_pop($service);
        $employee = array_pop($employee);
        $sector = array_pop($sector);
        if ($service['0'] == "" && $employee['0'] == "" && $sector['0'] == "") {

            $query = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_0,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total0,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_1,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total1,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_2,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total2,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_3,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total3,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_4,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_5,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_6,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total6
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) GROUP BY EXTRACT(YEAR FROM IP.created_date)";
            $result = $this->db->query($query);
            return $result->result_array();
        } elseif ($employee['0'] == "" && $service['0'] != "" && $sector['0'] == "") {
            $query1 = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,IP.name_of_enterprise,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_0,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total0,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_1,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total1,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_2,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total2,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_3,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total3,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_4,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_5,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_6,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total6
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation)  WHERE IP.name_of_enterprise IN ('" . implode("','", $service) . "')  GROUP BY EXTRACT(YEAR FROM IP.created_date)";
            $result1 = $this->db->query($query1);
            return $result1->result_array();
        } elseif ($employee['0'] == "" && $service['0'] == "" && $sector['0'] != "") {
            $query1 = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,IP.name_of_enterprise,S.answer,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_0,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total0,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_1,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total1,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_2,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total2,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_3,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total3,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_4,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_5,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_6,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total6
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) LEFT OUTER JOIN screening as S ON (IP.id = S.innovation) WHERE S.answer IN('" . implode("','", $sector) . "') GROUP BY IP.stage,EXTRACT(YEAR FROM IP.created_date)";
            $result1 = $this->db->query($query1);

            return $result1->result_array();
        } elseif ($service['0'] == "" && $employee['0'] != "" && $sector['0'] == "") {

            $query2 = "SELECT EXTRACT(YEAR FROM IP.created_date) as year,IP.name_of_enterprise,HE.emp_firstname,HE.emp_number,
(SELECT TITLE FROM program_service_offering WHERE ID = 4) AS title_0,
SUM(CASE WHEN FIND_IN_SET(4,IA.services) THEN 1 ELSE 0 END) AS total0,
(SELECT TITLE FROM program_service_offering WHERE ID = 5) AS title_1,
SUM(CASE WHEN FIND_IN_SET(5,IA.services) THEN 1 ELSE 0 END) AS total1,
(SELECT TITLE FROM program_service_offering WHERE ID = 6) AS title_2,
SUM(CASE WHEN FIND_IN_SET(6,IA.services) THEN 1 ELSE 0 END) AS total2,
(SELECT TITLE FROM program_service_offering WHERE ID = 7) AS title_3,
SUM(CASE WHEN FIND_IN_SET(7,IA.services) THEN 1 ELSE 0 END) AS total3,
(SELECT TITLE FROM program_service_offering WHERE ID = 8) AS title_4,
SUM(CASE WHEN FIND_IN_SET(8,IA.services) THEN 1 ELSE 0 END) AS total4,
(SELECT TITLE FROM program_service_offering WHERE ID = 9) AS title_5,
SUM(CASE WHEN FIND_IN_SET(9,IA.services) THEN 1 ELSE 0 END) AS total5,
(SELECT TITLE FROM program_service_offering WHERE ID = 10) AS title_6,
SUM(CASE WHEN FIND_IN_SET(10,IA.services) THEN 1 ELSE 0 END) AS total6
FROM innovation_services as IA JOIN innovation_pool as IP ON(IP.id = IA.innovation) LEFT OUTER JOIN assign_associate as AA ON
                                AA.innovation = IP.id LEFT OUTER JOIN villtest_hris.hs_hr_employee as HE ON
                                HE.emp_number = AA.associate_employee
                                 WHERE HE.emp_number IN('" . implode("','", $employee) . "') GROUP BY IP.stage,IP.source ORDER BY EXTRACT(YEAR FROM IP.created_date) DESC";
            $result2 = $this->db->query($query2);
            return $result2->result_array();
        } elseif ($service['0'] != "" && $employee['0'] != "" && $sector['0'] == "") {
            $query3 = "SELECT MS.master_name,HE.emp_firstname,HE.emp_number,count(IP.id) as VALUE,IP.stage,EXTRACT(YEAR FROM IP.created_date) as year FROM  master_settings as MS LEFT OUTER JOIN source_master as SM ON SM.source_type = MS.id  LEFT OUTER JOIN innovation_pool as IP ON  SM.id = IP.source LEFT OUTER JOIN assign_associate as AA ON  AA.innovation = IP.id LEFT OUTER JOIN villtest_hris.hs_hr_employee as HE ON HE.emp_number = AA.associate_employee WHERE HE.emp_number IN('" . implode("','", $employee) . "') and MS.master_type = 'Source Type' and MS.master_name IN('" . implode("','", $service) . "') GROUP BY IP.stage,IP.source ORDER BY EXTRACT(YEAR FROM IP.created_date) DESC";
            $result3 = $this->db->query($query3);
            return $result3->result_array();
        } elseif ($service['0'] != "" && $employee['0'] == "" && $sector['0'] != "") {
            $dbquery = "SELECT MS.master_name,IP.name_of_enterprise,S.answer,EXTRACT(YEAR FROM IP.created_date) as year,IP.stage,count(IP.id) as VALUE from innovation_pool as IP LEFT OUTER JOIN screening as S ON(IP.id = S.innovation) LEFT OUTER JOIN source_master as SM ON (SM.id= IP.source) LEFT OUTER JOIN master_settings as MS ON(MS.id = SM.source_type) WHERE S.answer IN('" . implode("','", $sector) . "') and MS.master_type = 'Source Type' and MS.master_name IN('" . implode("','", $service) . "') GROUP BY IP.stage,EXTRACT(YEAR FROM IP.created_date)";
            $result4 = $this->db->query($dbquery);
            return $result4->result_array();
        }

    }
    public function getemployeequality($employee)
    {
        $data = array();
        $employee = array_pop($employee);
        $this->db->select('created_by');
        $this->db->select("(select CONCAT_WS(' ',emp_firstname,emp_lastname) from  " . $this->hris->database . ".hs_hr_employee where emp_number = IP.created_by) as created_emp", false);
        $this->db->where('source !=', '0');
        $this->db->where_in('created_by', $employee);
        $this->db->group_by('created_by');
        $query = $this->db->get('innovation_pool IP');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['report'] = $this->getSourceWiseReport($row['created_by']);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function gettimetakenreport()
    {
        $query = "SELECT IP.*,EXTRACT(YEAR FROM IP.created_date)as year,IP.name_of_enterprise,DATEDIFF(entry_date,IP.created_date) as new_entry,DATEDIFF(lead_date,entry_date) as entry_lead,DATEDIFF(shortlist_date,lead_date) as screening_date  FROM  innovation_pool as IP  ORDER BY IP.id ";
        $result = $this->db->query($query);
        return $result->result_array();
    }
    public function getprogresscompare($metrics)
    {
        $query = "SELECT sum(P.answer) as total,IP.name_of_enterprise,EXTRACT(YEAR FROM IP.created_date) as year from innovation_pool as IP JOIN progress as P ON (IP.id = P.innovation) JOIN progress_master as PM ON(P.field = PM.id) where PM.label IN('" . implode("','", $metrics) . "') GROUP BY P.innovation";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getSourceWiseReport($employee = '', $type = '')
    {

        $source = array();

        if ($employee == '' && $type == '') {

            $sourceTypeList = $this->Mmaster_settings->getMasterSetting('Source Type');
            foreach ($sourceTypeList as $st):

                $s = array();

                $s['id'] = $this->Msource->getSourceByType($st['id']);
                $s['master_name'] = $st['master_name'];
                $s['source_name'] = $st['master_name'];
                $source[] = $s;

            endforeach;
        } else {

            $source = $this->Msource->getSourceList();
        }

        $totalInnovation = $this->getCountOnly();
        $records = array();

        if ($employee == '') {

            $direct = array('id' => '0', 'name' => 'Direct Applications', 'source_name' => 'Direct Applications', 'master_name' => 'Direct Applications');
            array_push($source, $direct);
        }

        foreach ($source as $row2):
            //show($row2);
            $data = array();

            $new = $this->getCountOnly(array('stage' => '0', 'source' => $row2['id'], 'employee' => $employee));
            $entry = $this->getCountOnly(array('stage' => '1', 'source' => $row2['id'], 'employee' => $employee));
            $lead = $this->getCountOnly(array('stage' => '2', 'source' => $row2['id'], 'employee' => $employee));
            $shortlist = $this->getCountOnly(array('stage' => '3', 'source' => $row2['id'], 'employee' => $employee));
            $screening = $this->getCountOnly(array('stage' => '4', 'source' => $row2['id'], 'employee' => $employee));
            $incubation = $this->getCountOnly(array('stage' => '5', 'source' => $row2['id'], 'employee' => $employee));
            $total_new = $data['total_new'] = $new + $entry + $lead;
            $total_entry = $data['total_entry'] = $entry + $lead;
            $total_lead = $data['total_lead'] = $lead;
            $screening = $data['total_screening'] = $screening;
            $incubation = $data['total_incubation'] = $incubation;

            @$data['convertion_new_entry'] = round(($total_entry / $total_new) * 100, 2);
            @$data['convertion_entry_lead'] = round(($total_lead / $total_entry) * 100, 2);
            @$data['innovation_percent'] = round(($total_new / $totalInnovation) * 100, 2);
            @$data['screening_percentage'] = round(($screening / $totalInnovation) * 100, 2);
            @$data['incubation_percentage'] = round(($incubation / $totalInnovation) * 100, 2);

            $data['name'] = $row2['master_name'];
            $data['source_name'] = $row2['source_name'];
            $data['source_type'] = $row2['master_name'];

            $records[] = $data;

        endforeach;
        //show($records);
        return $records;
    }
    public function getCountOnly($options = array())
    {

        $data = array();

        $this->db->select('count(*) as total');

        if (!empty($options['source']) || @$options['source'] == '0') {

            $this->db->where_in('source', $options['source']);
        } elseif (isset($options['source'])) {

            $options['source'] = (count($options['source'])) ? $options['source'] : '4564065348593407589345734534587346584365783457';
            $this->db->where('source', $options['source']);
        }

        if (!empty($options['stage']) || @$options['stage'] == '0') {
            $this->db->where('stage', $options['stage']);
        }

        if (!empty($options['employee']) || @$options['employee'] == '0') {
            $this->db->where_in('created_by', $options['employee']);
        }

        $query = $this->db->get('innovation_pool');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;
            }
        }

        $query->free_result();

        return $data['0']['total'];
    }
    public function getsectorwisereport($sector)
    {
        $query = "SELECT S.answer as VALUE,EXTRACT(YEAR FROM IP.created_date) as year,SUM( IF( IP.stage =  '0', 1, 0 ) ) as `total_new`,SUM( IF( IP.stage =  '1', 1, 0 ) ) as `total_entry`,SUM( IF( IP.stage =  '2', 1, 0 ) ) as `total_lead`,SUM( IF( IP.stage =  '3', 1, 0 ) ) as `total_shortlist`,SUM( IF( IP.stage =  '4', 1, 0 ) ) as `total_screening`,SUM( IF( IP.stage =  '5', 1, 0 ) ) as `total_incubation` from innovation_pool as IP JOIN screening as S ON(S.innovation = IP.id) JOIN screening_master as SM ON(S.field = SM.id) where SM.id = 80 and S.answer IN ('" . implode("','", $sector) . "') GROUP BY EXTRACT(YEAR FROM IP.created_date)";
        $result = $this->db->query($query);
        return $result->result_array();
    }

}
