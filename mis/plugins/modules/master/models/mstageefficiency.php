<?php
class Mstageefficiency extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getStageDate()
    {
        return array("New" => 'created_date', "Entry" => 'entry_date', "Lead" => 'lead_date', "Shortlisted" => 'shortlist_date', "Leads for Due-Diligence" => '', "Incubation" => '');
    }

    public function getStageEfficient()
    {
        $data = array();
        $query = $this->db->get('stagefficiency');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }
    public function getMaxDays()
    {
        $data = array();
        $query = $this->db->get('stagefficiency');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['0'] = $row['new'];
                $row['1'] = $row['entry'];
                $row['2'] = $row['lead'];
                $row['3'] = $row['shortlisted'];
                $row['4'] = $row['due_diligence'];
                $row['5'] = $row['incubation'];
                $data[] = $row;
            }
        }
        return $data;
    }
    public function updateEfficiency($form = array())
    {
        $data = array('new' => $form['new'],
            'entry' => $form['entry'],
            'lead' => $form['lead'],
            'shortlisted' => $form['shortlisted'],
            'due_diligence' => $form['due_diligence'],
            'incubation' => $form['incubation'],
        );
        $this->db->where('id', '1');
        $this->db->update('stagefficiency', $data);
        return true;
    }

}
