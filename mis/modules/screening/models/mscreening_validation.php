<?php
class Mscreening_validation extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hris = $this->load->database('hris', true);
    }
    public function insertValidation($form = array())
    {
        foreach ($form['all'] as $key => $value):
            $data = array('criteria' => $form['criteria'],
                'innovation' => $form['innovation'],
                'validation' => $value,
                'done' => (php72_in_array($value, $form['validation'])) ? '1' : '0',
                'comments' => $form['comments'][$key]);

            if ($this->checkDuplicateValidation($form['innovation'], $form['criteria'], $value)) {
                $this->db->insert('screening_validation', $data);
            } else {
                $this->db->where('criteria', $form['criteria']);
                $this->db->where('innovation', $form['innovation']);
                $this->db->where('validation', $value);
                $this->db->update('screening_validation', $data);
            }
        endforeach;
    }
    public function checkDuplicateValidation($innovation, $criteria, $validation)
    {
        $this->db->where('criteria', $criteria);
        $this->db->where('innovation', $innovation);
        $this->db->where('validation', $validation);
        $result = $this->db->get('screening_validation');
        if ($result->num_rows() > 0) {
            return false;
        }
        return true;
    }
    public function getScreeningValidation($innovation, $criteria)
    {
        $data = array();
        $this->db->select('SV.id as vid,SV.comments,SV.done,MV.validation,MV.criteria,MV.id');
        $this->db->where('MV.criteria', $criteria);
        $this->db->join('screening_validation SV', 'SV.validation = MV.id and SV.innovation = "' . $innovation . '"', 'left');
        $query = $this->db->get('means_validation MV');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

}
