<?php
#
# Model Class -  hs_quad_master_settings
#

class Mreports extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getReportList($report_type)
    {
        $data = array();
        $this->db->where('report_type', $report_type);
        $query = $this->db->get('master_report');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insert($options = array())
    {
        $data = array('report_type' => $options['report_type'],
            'report_name' => $options['report_name'],
            'report_data' => serialize($options['report_data']));
        $result = $this->db->insert('master_report', $data);
        return $result;
    }
    public function update($options = array())
    {
        $data = array('report_type' => $options['report_type'],
            'report_name' => $options['report_name'],
            'report_data' => serialize($options['report_data']));
        $this->db->where('id', $options['id']);
        $result = $this->db->update('master_report', $data);
        return $result;
    }

    /**
     * Function : delete method is used for delete records by changing status to -1.
     *
     * @param int $vendor_id
     *
     */

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('master_report');
        return true;
    }

    /**
     * Function : changeStatus method is used for Make active inactive.
     * $options - values
     *     staus
     *    vendor_id
     *
     * @param array $options
     *
     */

    public function changeStatus($options = array())
    {
        $data = array('status' => $options['status']);
        $this->db->where('id', $options['id']);
        $this->db->update('master_report', $data);
        return true;
    }

    /**
     * Function : getAllCount method is used for get count records from  vendors.
     * $options - values
     *     orderby
     *    ordertype
     *    vendorName
     *    contactPerson
     *
     * @param array $options
     *
     */
    public function getAllCount($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);
        $this->db->select("count(*) as total");

        if ($whereQuery != null) {
            $query = $this->db->get_where('master_report', $whereQuery);
        } else {
            $query = $this->db->get('master_report');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data['0']['total'];
    }

    /**
     * Function : getLimitRecords method is used for get Limit records from  vendors.
     *
     * @param array $options
     *
     */

    public function getLimitRecords($options = array())
    {
        $data = array();
        $whereQuery = $this->_search($options);
        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['orderby']);
        }

        if (!empty($whereQuery)) {
            $query = $this->db->get_where('master_report', $whereQuery);
        } else {
            $query = $this->db->get('master_report');
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    /**
     * Function : _search method is used for generate Search query .
     *
     * @param array $options
     *
     */

    public function _search($options = array())
    {
        $searchArray = array();
        $where = null;
        if (!empty($options['report_name'])) {
            $searchArray[] = "report_name like '%" . $options['report_name'] . "%'";
        }

        if (!empty($options['report_type'])) {
            $searchArray[] = "report_type = '" . $options['report_type'] . "'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }

    /**
     * Function : getVendorInfo method is used for get vendor details .
     *
     * @param int $vendor_id
     *
     */

    public function getReportsInfo($id)
    {
        $data = array();
        $this->db->where("id", $id);
        $query = $this->db->get('master_report');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row["report_data"] = unserialize($row["report_data"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getReportsByType($type)
    {
        $data = array();
        $this->db->where("report_type", $type);
        $query = $this->db->get('master_report');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row["report_data"] = unserialize($row["report_data"]);
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getReportTypes()
    {
        $data = array('innovation' => 'Innovation',
            'source' => 'Source');
        return $data;
    }
    public function getReportFields($type = '')
    {
        if ($type == '') {
            return array();
        }

        $data['innovation'] = array('id' => 'Id',
            'innovation_id' => 'Innovation Id',
            'source_type' => 'Source Type',
            'source_name' => 'Source',
            'instance_name' => 'Instance',
            'name_of_entrepreneur' => 'Name of Promoter',
            'phone_no' => 'Phone No',
            'mobile_no' => 'Mobile No',
            'email_id' => 'Email Id',
            'address_line1' => 'Address Line1',
            'address_line2' => 'Address Line2',
            'city' => 'City',
            'district' => 'District',
            'state' => 'State',
            'country' => 'Country',
            'pincode' => 'Pincode',
            'name_of_enterprise' => 'Name of Enterprise',
            'website' => 'Website',
            'summary_of_business' => 'Summary of Eusiness',
            'entreprise_years' => 'Entreprise Years',
            'business_plan' => 'Business Plan',
            'reference' => 'Reference',
            'no_of_incharge' => 'No. Of Incharge',
            'associate_emp_name' => 'Person Incharge',
            'enrty_date#date' => 'Entry Date',
            'lead_date#date' => 'Lead Date',
            'new_entry' => 'New to Entry',
            'entry_lead' => 'Entry to Lead',
            'incubation_cycle_title' => 'Incubation Cycle',
            'created_date#date' => 'Applied Date',
            'created_emp' => 'Applied By',
            'modified_emp' => 'Last Modified By',
            'modified_date#date' => 'Modified Date',
            'stage' => 'Stage',
            'status' => 'Status',
            'comments' => 'Comments',
            'reasons_title' => 'Reasons',
        );
        $data['source'] = array('id' => 'Id',
            'master_name' => 'Source Type',
            'source_name' => 'Source Name',
            'designation' => 'Designation',
            'address' => 'Address',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'email' => 'E-Mail',
            'fax' => 'Fax',
            'frequency' => 'Frequency',
            'date#date' => 'Date',
            'alert_title' => 'Alert',
            'link' => 'Link',
            'username' => 'Username',
            'password' => 'Password',
            'pagecontent' => 'Pagecontent',
            'description' => 'Description',
            'created_date#date' => 'Created Date',
            'created_by' => 'Created By',
            'modified_date#date' => 'Modified Date',
            'modified_by' => 'Modified By');
        return $data[$type];
    }

}
