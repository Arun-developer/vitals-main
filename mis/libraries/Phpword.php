<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// PhpWord is installed with Composer (phpoffice/phpword in /composer.json); the old copy in third_party/PhpWord (0.14.0) is no longer loaded.
require_once FCPATH . 'vendor/autoload.php';
use PhpOffice\PhpWord\Settings;
Settings::loadConfig();

class Phpword {

}
