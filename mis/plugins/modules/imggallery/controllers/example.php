<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Example extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }
    // Call this method first by visiting http://SITE_URL/example/request_dropbox
    public function request_dropbox()
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';

        $this->load->library('dropbox', $params);
        $data = $this->dropbox->get_request_token(site_url("/imggallery/example/access_dropbox"));
        $this->session->set_userdata('token_secret', $data['token_secret']);
        redirect($data['redirect']);
    }
    //This method should not be called directly, it will be called after
    //the user approves your application and dropbox redirects to it
    public function access_dropbox()
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';

        $this->load->library('dropbox', $params);

        $oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));

        $this->session->set_userdata('oauth_token', $oauth['oauth_token']);
        $this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
        redirect('/imggallery/example/get_folder');
    }
    //Once your application is approved you can proceed to load the library
    //with the access token data stored in the session. If you see your account
    //information printed out then you have successfully authenticated with
    //dropbox and can use the library to interact with your account.
    public function test_dropbox()
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));

        $this->load->library('dropbox', $params);

        $dbobj = $this->dropbox->account();

        print_r($dbobj);
    }
    public function get_dropbox($path)
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));

        $this->load->library('dropbox', $params);

        $dbobj = $this->dropbox->get('C:\wamp\www\john' . $path, '/Photos/' . $path);
        print_r($dbobj);
    }
    public function get_folder($path = null)
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));

        $this->load->library('dropbox', $params);
        $path1 = $this->uri->segment('5');
        $path2 = $this->uri->segment('6');
        if ($path1 == "") {
            $path1 = null;
            $path2 = null;
        }
        $dbobj = $this->dropbox->metadata('/Photos/' . urldecode($path) . '/' . urldecode($path1) . '/' . urldecode($path2));
        $data = array();
        $data['folder'] = $dbobj;
        $data['cpage'] = 'video';
        $data['cpagetitle'] = 'Dropbox Api';
        $this->load->view('../dashboard_template', $data);

    }
    public function get_link($path2 = null)
    {

        $path = $this->uri->segment('4');
        $path1 = $this->uri->segment('5');
        $path2 = $this->uri->segment('6');
        $path3 = $this->uri->segment('7');
        if ($path1 == '') {
            $path1 = null;
            $path2 = null;
            $path3 = null;
        }
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));
        $this->load->library('dropbox', $params);
        $dbobj = $this->dropbox->media('Photos/' . urldecode($path) . '/' . urldecode($path1) . '/' . urldecode($path2) . '/' . urldecode($path3));
        $data = array();
        $data['folder'] = $dbobj;
        $data['cpage'] = 'images';
        $data['cpagetitle'] = 'Dropbox';
        $this->load->view('../dashboard_template', $data);

    }
    public function get_videolink($path2 = null)
    {

        $path = $this->uri->segment('4');
        $path1 = $this->uri->segment('5');
        $path2 = $this->uri->segment('6');
        $path3 = $this->uri->segment('7');
        if ($path1 == '') {
            $path1 = null;
            $path2 = null;
            $path3 = null;
        }
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));
        $this->load->library('dropbox', $params);
        $dbobj = $this->dropbox->media('Photos/' . urldecode($path) . '/' . urldecode($path1) . '/' . urldecode($path2) . '/' . urldecode($path3));
        $data = array();
        $data['folder'] = $dbobj;
        $data['cpage'] = 'addvideo';
        $data['cpagetitle'] = 'Dropbox Video';
        $this->load->view('../dashboard_template', $data);

    }
    public function searchkeyword()
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));
        $this->load->library('dropbox', $params);
        $path = $this->uri->segment('4');
        if ($path == "") {
            $path = null;
        }
        $word = $this->input->post('q');
        $dbobj = $this->dropbox->search('/Photos/' . $path, $word);
        print_r($dbobj);
    }
    public function fileupload()
    {
        $data['path'] = 'Photos/' . join("/", array_slice(explode("/", $_GET['path']), 6));
        if ($data['path'] == "") {
            $data['path'] = '/Photos';
        }
        $data['cpagetitle'] = 'File Upload';
        $data['cpage'] = 'fileupload';
        $this->load->view('../template_plain', $data);
    }
    public function upload()
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));
        $this->load->library('dropbox', $params);
        $path = $_POST['path'] . '/';
        $filepath = base_url() . 'uploads/Under_the_Mango_Tree_Private_Limited-Screening_details.doc';
        $dbobj = $this->dropbox->add($path, $filepath);
        print_r($dbobj);
    }
    public function createfolder()
    {
        $data['cpagetitle'] = "Create a New Folder";
        $path = 'Photos/' . join("/", array_slice(explode("/", $_GET['path']), 6));
        if ($path == "") {
            $path = 'Photos';
        }
        $data['path'] = $path;
        $data['cpage'] = 'newfolder';

        $this->load->view('../template_plain', $data);
    }
    public function add_newfolder()
    {
        $params['key'] = 'jangtx44b52jv1r';
        $params['secret'] = '04uc56czbyhnerc';
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));
        $this->load->library('dropbox', $params);
        $path = $_POST['path'] . '/' . $_POST['folder_name'];
        if ($path == "") {
            $path = null;
        }
        $dbobj = $this->dropbox->create_folder($path);
        $this->session->set_flashdata('successMsg', 'Folder Created Successfully');
        redirect('imggallery/example/get_folder');
        print_r($dbobj);
    }

}

/* End of file example.php */
/* Location: ./application/controllers/welcome.php */
