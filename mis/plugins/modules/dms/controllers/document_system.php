<?php
class Document_system extends CI_Controller
{public function __construct()
    {parent::__construct();
    $this->Mauth->isLoggedCheck();
    $this->load->model('Mdms');
}
    public function index()
    {
        if (isset($_POST["login"]) && isset($_POST["password"])) {

            // Necessary to make "connection" with the glueCode
            define("AJXP_EXEC", true);
            $glueCode = $_SERVER['DOCUMENT_ROOT'] . "/ajaxplorer/plugins/auth.remote/glueCode.php";
            $secret = "my_secret_key";

            // Initialize the "parameters holder"
            global $AJXP_GLUE_GLOBALS;
            $AJXP_GLUE_GLOBALS = array();
            $AJXP_GLUE_GLOBALS["secret"] = $secret;
            $AJXP_GLUE_GLOBALS["plugInAction"] = "login";
            $AJXP_GLUE_GLOBALS["autoCreate"] = true;
            // NOTE THE md5() call on the password field.
            $AJXP_GLUE_GLOBALS["login"] = array("name" => $_POST["login"], "password" => md5($_POST["password"]));
            // NOW call glueCode!
            include $glueCode;

        }
        $data['cpagetitle'] = "Document Management System";
        $data['cpage'] = "document_system_view";
        $this->load->view('../template_ajax', $data);
    }
    public function logoutdms()
    {
        define('AJXP_EXEC', true);
        require $_SERVER['DOCUMENT_ROOT'] . "ajaxplorer/core/classes/class.AuthService.php";
        $objAuthService = new AuthService();
        $objAuthService->disconnect();
    }
    public function createuser()
    {
        include $glueCode;
    }
    public function searchDocsByKey()
    {
        if (isset($_POST['search_word'])) {
            $userid = $this->session->userdata('user_id');
            $key = $_POST['search_word'];
            $keywordornot = $this->input->post('keywordornot');
            $searchtype = $this->input->post('searchtype');
            $docdetails = array();
            $per_page = 5;
            $path = @$_POST['urlpath'];
            $replacedpath = str_replace("../", "", $path);
            $newpath = str_replace("/", "\\\\", $replacedpath);
            $path = "\\\\\\\\" . $_SERVER['HTTP_HOST'] . "\\\\public_html\\\\" . $newpath;
            $this->Mdms->hasKeyword($userid, $key, $path, $keywordornot, $searchtype);
            $counter = 0;
            if (isset($_POST['counter'])) {$counter = $_POST['counter'] - 1;}
            if ($key != "") {
                $docdetails = $this->chkkeyword($key, $userid, $counter);
            }
            if (!empty($docdetails)) {
                echo "<span style='color:#999999;float:left;margin-bottom:5px;'>About " . count($docdetails) . " Results</span><br>";
            }
            if (empty($docdetails)) {
                echo "<span style='color:#999999;float:left;margin-bottom:5px;'>No results found </span><br>";
                exit;
            }
            foreach ($docdetails as $row) {
                echo "<ul>";
                echo "<li><a href='" . $row['filepath'] . "'>" . $row['file_name'] . "</a>";
                echo "<ul style='color:lightgrey'>";
                echo "<li>" . $row['before_keyword'] . " -- " . $row['after_keyword'] . "</li>";
                echo "</ul>";
                echo "</li>";
                echo "</ul>";
            }
            echo "<div id='paging_button' align='center'>";
            echo "<ul id='pageulID'>";
            $count = count($docdetails);
            $pages = ceil($count / $per_page);
            for ($i = 1; $i <= $pages; $i++) {
                echo "<li class='page' id='" . $i . "'>" . $i . "</li>";
            }
            echo "</ul>";
            echo "</div>";
            exit;
        }
        $userid = $this->session->userdata("user_id");
        $data['docList'] = $this->Mdms->getSearchedDocsByUSERID($userid);
        $data['left_box'] = array('ajax_left_box');
        $data['cpagetitle'] = "Document Search";
        $data['cpage'] = "document_search";
        $this->load->view('../template_ajax', $data);
    }
    public function chkkeyword($key, $userid, $counter, $loop = 0)
    {
        $docdetails = $this->Mdms->getKEYWordList($key, $userid, $counter);
        if (empty($docdetails) && $loop != 6) {
            sleep(2);
            ++$loop;
            $this->chkkeyword($key, $userid, $counter, $loop);
        } else {
            return $docdetails;
        }

    }
    public function getkeywords()
    {
        $docdetails = $this->Mdms->getLastId('USR003', 'necessary');
        print_r($docdetails);
        exit;
        $data['cpagetitle'] = "Document Search";
        $data['cpage'] = "document_search";
        $this->load->view('../template', $data);
    }
    public function searchedKeyWord()
    {
        $userid = $this->session->userdata('user_id');
        $data['docList'] = $this->Mdms->getSearchedDocsByUSERID($userid);
        $data['getkeyresult'] = $this->Mdms->getkeyresults($userid);
        if (isset($_POST['submit'])) {
            $pattern = $_POST['pattern'] . '*';
            $path = $_POST['path'];
            $format = $_POST['format'];
            $flags = 0;
            $data['aryResults'] = $this->rglob($pattern, $flags, $path);
        }
        $data['left_box'] = array('ajax_left_box');
        $data['cpagetitle'] = "Searched Documents";
        $data['cpage'] = "search_history";
        $this->load->view('../template_ajax', $data);
    }
    public function gettotalkeyword($keyword = "", $keyId = "")
    {
        $userid = $this->session->userdata('user_id');
        $data['totalkeywordList'] = $this->Mdms->gekeywordresultsBykeyword($userid, $keyword);
        if ($keyId != "") {
            $this->Mdms->deleteKeywordBYID($keyId);
            $this->session->set_flashdata('successMsg', 'Searched keyword Successfully Deleted');
            redirect("dms/document_system/searchedKeyWord");
        }
        $data['cpagetitle'] = "Searched Documents";
        $data['cpage'] = "keyword_search";
        $this->load->view('../template_ajax', $data);
    }
    public function searchapi()
    {
        $startTime = microtime(true); // Get passed args
        $pattern = $_POST['pattern'] . '*';
        $path = $_POST['path'];
        $format = $_POST['format'];
        $flags = 0;
        $data['aryResults'] = $this->rglob($pattern, $flags, $path);
        $data['cpage'] = 'searchresults';
        $this->load->view('../template', $data);

    }
    public function rglob($pattern = '*', $flags = 0, $path = '')
    {
        $paths = glob($path . '*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT);
        $files = glob($path . $pattern, $flags);
        foreach ($paths as $path) {
            $files = array_merge($files, $this->rglob($pattern, $flags, $path));

        }
        return $files;
    }
    public function email()
    {
        $config = array('protocol' => 'smtp',
            'smtp_host' => 'localhost',
            'smtp_port' => 25,
            'smtp_user' => 'mis@mis.villgroapps.org',
            'smtp_pass' => 'misvillg',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
        );
        $to = array('b.arvind@quadrupleindia.com', 'sridhar.j@quadrupleindia.com');
        $this->load->library('email', $config);
        $this->email->from('mis@mis.villgroapps.org');
        $this->email->to($to);
        $this->email->subject('testing email');
        $this->email->message('hi this is a test email');
        if ($this->email->send()) {
            echo "mail sent successfully";
        } else {
            echo $this->email->print_debugger();
        }
    }
}
