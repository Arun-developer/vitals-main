<?php
/**
*
* Weekly Global Report Page
*
* @ControllerName     pdfexport.php
* @Author                   Sanjoy Dey
* @Created Date        10-02-2012
* @Modified Date      06-02-2012
* @Modified By        Sanjoy Dey
* @Last Modified By   
* @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011
* @version            CodeIgniter_2.0.3
* @link               http://www.codeigniter.com
* @since              File available since Release 2.0.3
* @Warning            Any change in this file may cause abnormal behaviour of application.
*
*/
 if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pdfexport {

    public   function exportMeAsPDF($htmView)  {
                 
                $this->load->library('mpdf51/mpdf');
                $this->mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
                $this->mpdf->WriteHTML($htmView,2);
                $this->mpdf->Output('mpdf.pdf','I');

        }
    
}   