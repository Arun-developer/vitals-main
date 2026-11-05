<?php
#
# Model Class -  hs_quad_master_settings
#

class Mmeeting extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insertMeeting($options = array())
    {
        $data = array('activity' => $options['activity'],
            'meeting_date' => date2mysql($options['meeting_date']),
            'subject' => $options['subject'],
            'location' => $options['location'],
            'start_datetime' => $options['start_datetime'],
            'end_datetime' => $options['end_datetime'],
            'comments_discussions' => $options['comments_discussions'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $this->db->insert('meeting_manager', $data);
        $id = $this->db->insert_id();
        $this->insertAganda($id, $options);
        $this->insertActionItems($id, $options);
        $this->insertActionItems($id, $options);
        return $id;
    }
    public function updateMeeting($options = array())
    {
        $id = $this->input->post('meeting_id');
        $data = array('meeting_date' => date2mysql($options['meeting_date']),
            'subject' => $options['subject'],
            'location' => $options['location'],
            'start_datetime' => $options['start_datetime'],
            'end_datetime' => $options['end_datetime'],
            'comments_discussions' => $options['comments_discussions'],
            'created_date' => date($this->config->item('mysqlDate')),
            'created_by' => $this->session->userdata('emp_number'));
        $this->db->where('id', $id);
        $this->db->update('meeting_manager', $data);

        $this->db->where('meeting_id', $id);
        $this->db->delete('meeting_agenda');
        $this->db->where('meeting_id', $id);
        $this->db->delete('meeting_action_items');
        $this->db->where('meeting_id', $id);
        $this->db->delete('meeting_attendees');

        $this->insertAganda($id, $options);
        $this->insertActionItems($id, $options);
        $this->insertAttendeesItems($id, $options);
        return $id;
    }
    public function insertAganda($id, $options)
    {
        foreach ($options['agenda_subject'] as $key => $value):
            $data = array('meeting_id' => $id,
                'subject' => $options['agenda_subject'][$key],
                'description' => $options['agenda_description'][$key],
                'owner' => $options['owner'][$key],
                'outcome' => $options['outcome'][$key]);
            if (count(array_filter($data)) > 1) {
                $this->db->insert('meeting_agenda', $data);
            }

        endforeach;
    }
    public function insertActionItems($id, $options)
    {
        foreach ($options['action_subject'] as $key => $value):
            $data = array('meeting_id' => $id,
                'subject' => $options['action_subject'][$key],
                'description' => $options['action_description'][$key],
                'assigned_to' => $options['assigned_to'][$key],
                'due_date' => date2mysql($options['due_date'][$key]),
                'priority' => $options['priority'][$key],
                'status' => $options['status'][$key],
                'comments' => $options['commented_on'][$key],
            );
            if (count(array_filter($data)) > 1) {
                $this->db->insert('meeting_action_items', $data);
            }

        endforeach;
    }
    public function insertAttendeesItems($id, $options)
    {
        foreach ($options['employee'] as $key => $value):
            $data = array('meeting_id' => $id,
                'employee' => $options['employee'][$key],
                'attendence' => $options['attendence'][$key],
                'response' => $options['response'][$key]);
            if (count(array_filter($data)) > 1) {
                $this->db->insert('meeting_attendees', $data);
            }

        endforeach;
    }
    public function getMeetingDetails($activity)
    {
        $data = array();
        $this->db->where('activity', $activity);
        $query = $this->db->get('meeting_manager');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getAgendaList($meeting)
    {
        $data = array();
        $this->db->where('meeting_id', $meeting);
        $query = $this->db->get('meeting_agenda');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getActionList($meeting)
    {
        $data = array();
        $this->db->where('meeting_id', $meeting);
        $query = $this->db->get('meeting_action_items');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }
    public function getAttendeesList($meeting)
    {
        $data = array();
        $this->db->where('meeting_id', $meeting);
        $query = $this->db->get('meeting_attendees');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
