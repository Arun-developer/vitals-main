<?php

class Mmedia extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLimitRecords($options = array())
    {
        $data = array();
        if ($options['innovationid'] != '') {
            $this->db->where('innovation', $options['innovationid']);
        }
        $query = $this->db->get('request_media');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getmediamaster()
    {
        $data1 = array();
        $query = $this->db->get('media_master');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data1[] = $row;

            }
        }
        $query->free_result();
        return $data1;
    }

    public function changestatus($id)
    {
        $query = "UPDATE request_media SET status = 'closed' WHERE id = '" . $id . "'";
        $result = $this->db->query($query);
        return $result;
    }

    public function _search($options = array())
    {
        $searchArray = array();
        $where = null;
        if (!empty($options['vendor_name'])) {
            $searchArray[] = "vendor_name like '%" . $options['vendor_name'] . "%'";
        }

        if (!empty($options['contact_person'])) {
            $searchArray[] = "contact_person like '%" . $options['contact_person'] . "%'";
        }

        if (count($searchArray)) {
            $where = implode(' and ', $searchArray);
        }

        return $where;
    }
    public function getmediaDetails($id = null)
    {
        $data = array();
        $this->db->where('id', $id);
        $query = $this->db->get('request_media');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getmediaList($innovation)
    {
        $data = array();
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('media_details');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function insertmedia_detail($options = array())
    {
        $data2 = array(
            'media_id' => $options['id'],
            'innovation' => $options['innovationid'],
            'title' => $options['title'],
            'topic' => $options['topic'],
            'publish_date' => $options['publish_date'],
            'media_name' => $options['media_name'],
            'journalist_name' => $options['journalist_name'],
            'media_type' => $options['media_type'],
            'article' => $options['filename'],
            'interview_happened' => $options['interview'],
            'description' => $options['description']);
        $result = $this->db->insert('media_details', $data2);
        return $result;

    }
    public function insertdirect_media($options = array())
    {
        $data2 = array(

            'innovation' => $options['innovation'],
            'title' => $options['title'],
            'topic' => $options['topic'],
            'publish_date' => $options['publish_date'],
            'media_name' => $options['media_name'],
            'journalist_name' => $options['journalist_name'],
            'media_type' => $options['media_type'],
            'article' => $options['filename'],
            'interview_happened' => $options['interview'],
            'description' => $options['description']);
        $result = $this->db->insert('media_details', $data2);
        return $result;

    }
    public function insert($options = array())
    {
        $data = array(
            'innovation' => $options['innovationid'],
            'title' => $options['title'],
            'topic' => $options['topic'],
            'requested_on' => $options['requested_on'],
            'media_name' => $options['media_name'],
            'Document' => $options['filename'],
            'description' => $options['description']);

        $result = $this->db->insert('request_media', $data);
        return $result;
    }
    public function update($options = array())
    {
        $dataup = array(
            'innovation' => $options['innovationid'],
            'title' => $options['title'],
            'topic' => $options['topic'],
            'requested_on' => $options['requested_on'],
            'media_name' => $options['media_name'],
            'Document' => $options['filename'],
            'description' => $options['description']);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_media', $dataup);
        return $result;
    }
    public function delete($id)
    {
        $data = array();
        $this->db->where('id', $id);
        $this->db->delete('request_media', $data);
        return true;
    }

    public function updateliststatus($options = array())
    {

        if ($options['decision'] == '1') {
            $status = "closed";
        } else {
            $status = "Inprogress";
        }
        $dataup = array('decision' => $options['decision'], 'status' => $status);
        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('request_media', $dataup);
        return $result;
    }

    public function getProgramstageandProgramservice($title)
    {
        $data = array();
        $this->db->select("PS.id,PS.program_service_offering");
        $this->db->join('program_service_offering PSO', 'PSO.id =PS.program_service_offering', 'left');
        $this->db->where("PSO.title", $title);
        $query = $this->db->get('program_stage PS');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data[0];
    }
    public function insertinformation($options = array())
    {
        $data = array(
            'incubatee_information' => $options['comments'],

        );
        $this->db->where('media_id', $options['id']);
        $this->db->where('innovation', $options['innovationid']);
        $result = $this->db->update('media_details', $data);
        return $result;
    }

}
