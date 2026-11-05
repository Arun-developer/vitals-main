<?php

/**

*

* Pdf Export Helper Page

*

* @ControllerName     pdfexport_helper.php

* @Author                     Sanjoy Dey

* @Created Date         10-02-2012

* @Modified Date      15-02-2012

* @Modified By        Sanjoy Dey

* @Last Modified By   

* @copyright          Quadruple Business Service Pvt. Ltd. Copyright(c) 2011

* @version            CodeIgniter_2.0.3

* @link               http://www.codeigniter.com

* @since              File available since Release 2.0.3

* @Warning            Any change in this file may cause abnormal behaviour of application.

*

*/

if ( ! function_exists('exportMeAsMPDF'))

{

            function exportMeAsMPDF($htmView,$fileName) {



                        $CI =& get_instance();

                        $CI->load->library('mpdf51/mpdf');

                        $CI->mpdf->AliasNbPages('[pagetotal]');

                        $CI->mpdf->SetHTMLHeader('{PAGENO}/{nb}', '1',true);

                        $CI->mpdf->SetDisplayMode('fullpage');

                        $CI->mpdf->pagenumPrefix = 'Page number ';

                        $CI->mpdf->pagenumSuffix = ' - ';

                        $CI->mpdf->nbpgPrefix = ' out of ';

                        $CI->mpdf->nbpgSuffix = ' pages';

                        $CI->mpdf->SetHeader('{PAGENO}{nbpg}');

                        $CI->mpdf = new mPDF('', 'A4', 0, '', 12, 12, 10, 10, 5, 5);

                        $style = base_url().'source/template/css/stylesheet.css';

                        $stylesheet = file_get_contents( $style);

                        $CI->mpdf->WriteHTML($stylesheet,1);                        

                        $CI->mpdf->WriteHTML($htmView,2);                        

                        $CI->mpdf->Output('mpdf.pdf','I');

            }

}

if ( ! function_exists('exportMeAsDOMPDF'))

{

         function exportMeAsDOMPDF($htmView,$fileName) {



                    $CI =& get_instance();

                    $CI->load->helper(array('dompdf', 'file'));

                    $CI->load->helper('file'); 

                    $pdfName = $fileName;

                    $pdfData = pdf_create($htmView, $pdfName);

                    write_file('Progress Repost', $pdfData);    

        }

}







?>