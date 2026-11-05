<?php
#
# Model Class -  hs_quad_master_settings
#

class Mmeeting extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mmaster');
        $this->load->model('common/Minnovation_mail');
    }

    public function getBoardList($innovationid)
    {
        $data = array();
        $this->db->select("BD.*");
        $this->db->join('board_member BM', 'BM.first_name = BD.members', 'left');
        $this->db->join('assign_associate AA', 'AA.innovation = BD.innovation', 'left');
        $this->db->where('BD.innovation', $innovationid);
        $query = $this->db->get('board_details BD');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertMeeting($options = array())
    {

        $data = array(
            'innovation' => $options['innovationid'],
            'subject' => $options['subject'],
            'location' => $options['location'],
            'start_datetime' => $options['start_datetime'],
            'end_datetime' => $options['end_datetime'],
            'comments_discussions' => $options['comments_discussions'],
            'created_date' => date($this->config->item('mysqlDate')),
            'filedoc' => $options['file'],
            'filedoc2' => $options['file2'],
            'created_by' => $this->session->userdata('emp_number'));
        $this->db->insert('boardmeeting_manager', $data);
        $id = $this->db->insert_id();
        $this->insertboardActionItems($id, $options);
        $this->insertboardAttendeesItems($id, $options);

        $this->Minnovation_mail->sendmeetingEmail($id, $options);
        return $id;
    }

    public function updateMeeting($options = array())
    {

        $id = $this->input->post('meeting_id');
        if (isset($options)) {
            $data = array('subject' => $options['subject'],
                'location' => $options['location'],
                'start_datetime' => $options['start_datetime'],
                'end_datetime' => $options['end_datetime'],
                'comments_discussions' => $options['comments_discussions'],
                'status' => $options['status'],
                'created_date' => date($this->config->item('mysqlDate')),
                'filedoc' => $options['file'],
                'filedoc2' => $options['file2'],
                'created_by' => $this->session->userdata('emp_number'));
            $this->db->where('id', $id);
            $this->db->update('boardmeeting_manager', $data);
        }

        $this->db->where('meeting_id', $id);
        $this->db->delete('boardmeeting_action_items');
        $this->insertboardActionItems($id, $options);
        $this->updateboardAttendeesItems($id, $options);
        return $id;
    }

    public function findOrganizer($id)
    {
        $data = array();
        $this->db->where('meeting_id', $id);
        $this->db->where('attendence', 'Organizer');
        $query = $this->db->get('boardmeeting_attendees');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function insertboardActionItems($id, $options)
    {
        if (isset($options['action_subject'])) {
            foreach ($options['action_subject'] as $key => $value):
                $data = array('meeting_id' => $id,
                    'subject' => $options['action_subject'][$key],
                    'description' => $options['action_description'][$key],
                    'assigned_to' => $options['assigned_to'][$key],
                    'due_date' => date2mysql($options['due_date'][$key]),
                    'priority' => $options['priority'][$key],
                    'status' => $options['action_status'][$key],
                    'comments' => date2mysql($options['commented_on'][$key]),
                );
                if (count(array_filter($data)) > 1) {
                    $this->db->insert('boardmeeting_action_items', $data);
                }

            endforeach;
        }
    }
    public function updateboardAttendeesItems($id, $options)
    {
        $documents = implode(',', $options['files'][2]);
        if (isset($options['response'])) {
            foreach ($options['response'] as $key => $value):
                if (!empty($options['files'][1]) || !empty($options['files'][0]) || !empty($documents)) {
                    $data = array('meeting_id' => $id,
                        'employee' => $options['employee'][$key],
                        'attendence' => $options['attendence'][$key],
                        'email' => $options['email'][$key],
                        'agenda' => $options['files'][0],
                        'boardmeeting_note' => $options['files'][1],
                        'supporting_document' => $documents,
                        'response' => $options['response'][$key]);
                } else {
                    $data = array('meeting_id' => $id,
                        'employee' => $options['employee'][$key],
                        'attendence' => $options['attendence'][$key],
                        'email' => $options['email'][$key],
                        'response' => $options['response'][$key]);
                }
                $this->db->where('meeting_id', $id);
                $this->db->update('boardmeeting_attendees', $data);
            endforeach;
        }
    }
    public function insertboardAttendeesItems($id, $options)
    {
        $documents = implode(',', $options['files'][2]);
        if (isset($options['response'])) {
            foreach ($options['response'] as $key => $value):
                $data = array('meeting_id' => $id,
                    'employee' => $options['employee'][$key],
                    'attendence' => $options['attendence'][$key],
                    'email' => $options['email'][$key],
                    'agenda' => $options['files'][0],
                    'boardmeeting_note' => $options['files'][1],
                    'supporting_document' => $documents,
                    'response' => $options['response'][$key]);
                if (count(array_filter($data)) > 1) {
                    $this->db->insert('boardmeeting_attendees', $data);
                }

            endforeach;
        }
    }

    public function updateResponse($id, $options)
    {
        foreach ($options['employee'] as $key => $value):
            $data = array('meeting_id' => $id,
                'employee' => $options['employee'][$key],
                'attendence' => $options['attendence'][$key],
                'email' => $options['email'][$key],
                'agenda' => $options['files'][0],
                'boardmeeting_note' => $options['files1'][1],
                'supporting_document' => $options['files2'][2],
                'response' => $options['response'][$key]);

            $this->db->where('meeting_id', $id);
            $this->db->where('employee', $options['employee'][$key]);
            $result = $this->db->update('boardmeeting_attendees', $data);

        endforeach;

        return $result;
    }

    public function getMeetingDetails($innovationid)
    {
        $data = array();
        $this->db->where('innovation', $innovationid);
        $query = $this->db->get('boardmeeting_manager');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getMeetingDetailstotal($innovationid, $id)
    {
        $data = array();
        $this->db->where('innovation', $innovationid);
        $this->db->where('id', $id);
        $query = $this->db->get('boardmeeting_manager');

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
        $query = $this->db->get('boardmeeting_agenda');
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
        $query = $this->db->get('boardmeeting_action_items');
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
        $this->db->order_by('employee');
        $query = $this->db->get('boardmeeting_attendees');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

    public function getUsersList($innovation)
    {
        $getheads = array_pop($this->getceocio());
        $data = array();
        $this->db->select('associate_employee');
        $this->db->where('innovation', $innovation);
        $query = $this->db->get('assign_associate');
        $data = $query->row_array();
        $empids = array_merge($getheads, $data);
        $result = $this->getUsers($empids);
        return $result;
    }
    public function getceocio()
    {
        $this->db->select('ceo');
        $this->db->select('cio');
        $query = $this->db->get('user_setup');
        return $query->result_array();

    }
    
    public function getUsers($emp_id = null) {
        $data = array();
        if ($emp_id != null) {
            if (is_array($emp_id)) {
                $this->db->where_in('id', $emp_id);
            } else {
                $this->db->where('id', $emp_id);
            }
        }

        $this->db->where('emp_type', '3');
        $query = $this->db->get('hr_user_profile');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        $query->free_result();
        return $data;
    }

}
