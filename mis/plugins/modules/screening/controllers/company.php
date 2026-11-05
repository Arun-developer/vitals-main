<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class company extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mcompany');
        $this->load->model('scouting/Minnovation');
    }

    public function board_details($innovation)
    {
        $data['innovation'] = $innovation;
        $options = array();
        if (isset($_POST['id'])) {
            $this->Mcompany->insertBoard($_POST, $innovation);
            $this->session->set_flashdata('successMsg', 'Board Details saved Successfully');
            redirect('company/view_boarddetails/' . $innovation);
        }
        #Loading View and data
        $data['boardList'] = $this->Mcompany->getBoardList($innovation);
        $data['cpagetitle'] = "Board Details";
        $data['cpage'] = "listBoard";
        $this->load->view('../template', $data);
    }

    public function view_boarddetails()
    {

        $data['innovation'] = $innovation;
        #Loading View and data
        $data['boardList'] = $this->Mcompany->getBoardList($innovation);
        $data['cpagetitle'] = "Board Details";
        $data['cpage'] = "company_view";
        $this->load->view('../template', $data);

    }
    #delete company head
    public function delete_board()
    {
        $companyId = $this->input->post('boardId');
        $result = $this->Mcompany->deleteBoard($companyId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }

    public function investment($innovation)
    {
        $data['innovation'] = $innovation;
        $options = array();
        if (isset($_POST['id'])) {

            $this->Mcompany->insertInvestment($_POST, $innovation);
            $this->session->set_flashdata('successMsg', 'Investment Details saved Successfully');
            redirect('company/view_investdetails/' . $innovation);
        }
        #Loading View and data
        $data['natureSource'] = $this->Mmaster_settings->getMasterSetting('Nature Source');
        $data['investmentList'] = $this->Mcompany->getInvestmentList($innovation);
        $data['cpagetitle'] = "Investment Details";
        $data['cpage'] = "listInvestment";
        $this->load->view('../template', $data);
    }

    public function view_investdetails($innovation)
    {
        #Loading View and data
        $data['natureSource'] = $this->Mmaster_settings->getMasterSetting('Nature Source');
        $data['investmentList'] = $this->Mcompany->getInvestmentList($innovation);
        $data['innovation'] = $innovation;
        $data['cpagetitle'] = "Investment Details";
        $data['cpage'] = "company_view";
        $this->load->view('../template', $data);

    }
    #delete company head
    public function delete_investment()
    {
        $companyId = $this->input->post('investmentId');
        $result = $this->Mcompany->deleteInvestment($companyId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }

    public function financial_details($innovation)
    {
        $data['innovation'] = $innovation;
        $options = array();
        if (isset($_POST['id'])) {
            $this->Mcompany->insertFinancial($_POST, $innovation);
            $this->session->set_flashdata('successMsg', 'Investment Details saved Successfully');
            redirect('company/view_financial/' . $innovation);
        }
        #Loading View and data
        $data['financialList'] = $this->Mcompany->getFinancialList($innovation);
        $data['cpagetitle'] = "Financial Details";
        $data['cpage'] = "listFinancial";
        $this->load->view('../template', $data);
    }

    public function view_financial($innovation)
    {
        $data['innovation'] = $innovation;
        $data['financialList'] = $this->Mcompany->getFinancialList($innovation);
        $data['cpagetitle'] = "Financial Details";
        $data['cpage'] = "company_view";
        $this->load->view('../template', $data);

    }

    #delete company head
    public function delete_financial()
    {
        $companyId = $this->input->post('financialId');
        $result = $this->Mcompany->deleteFinancial($companyId);
        if (!empty($result)) {
            echo mysqlError($result);
        } else {
            echo 'success';
        }

    }
}
