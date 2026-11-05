<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Installment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Minstallment');
        $this->load->model('scouting/Minnovation');
        $this->items_perpage = '15';
    }
    public function view_list($innovation)
    {
        $data['innovation'] = $innovation;
        $options = array();
        if (isset($_POST['txtSubmit'])) {
            if (isset($_POST['id'])) {
                $this->Minstallment->insert($_POST, $innovation);
                $this->session->set_flashdata('successMsg', 'Installment saved Successfully');
            }
            redirect('seedfunding/activities/view_list/' . $innovation);
        }
        #Loading View and data
        $data['installmentList'] = $this->Minstallment->getInstallmentList($innovation);
        $data['cpagetitle'] = "Installments";
        $data['cpage'] = "listInstallment";
        $this->load->view('../template_plain', $data);
    }

    #delete budget head
    public function delete()
    {
        $installmentId = $this->input->post('installmentId');
        $result = $this->Minstallment->delete($installmentId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }
}
