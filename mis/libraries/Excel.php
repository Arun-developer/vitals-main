<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// PHPExcel 1.7.7 does not run on PHP 8. The PHPExcel classes now come from a compatibility layer on top of
// PhpSpreadsheet (vendor/, see composer.json); the old copy in third_party/PHPExcel is no longer loaded.
require_once APPPATH."/third_party/PHPExcel_Compat.php";
//require_once APPPATH."/third_party/PHPExcel/IOFactory.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() { 
        parent::__construct(); 
    } 
}
?>