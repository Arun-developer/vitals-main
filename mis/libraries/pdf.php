<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF in CodeIgniter applications.
 *
 * @package            CodeIgniter
 * @subpackage        Libraries
 * @category        Libraries
 * @author            CodexWorld
 * @license            https://www.codexworld.com/license/
 * @link            https://www.codexworld.com
 */

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Pdf
{
    public function __construct(){

        // include autoloader (dompdf 3 is installed with Composer; the old 0.8 copy in libraries/dompdf is no longer loaded)
        require_once FCPATH . 'vendor/autoload.php';

        // instantiate and use the dompdf class
        $pdf = new DOMPDF();

        $CI =& get_instance();
        $CI->dompdf = $pdf;

    }
}
?>
