<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
				$this->load->view('export_inc_pdf');

        // Get output html
        $html = $this->output->get_output();

        // Load pdf library
        $this->load->library('pdf');

        // Load HTML content
        $this->dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $this->dompdf->render();

        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>1));
	}

	function connectmail() {

		$dns = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
		$email = "sanjoy.dey@quadrupleindia.com";
		$password = "";

		$open = imap_open($dns,$email,$password ) or die("Cannot open stream ".imap_last_error());
		if ($open) {
			echo "You have ".imap_num_msg($open). " messages in your inbox\n\r";

			for($i=1; $i <= 100; $i++) {

				$header = imap_header($open,$i);
				echo "<br>";
				echo $header->Subject." (".$header->Date.")";
			}
		echo "\n\r";
		$msg = imap_fetchbody($open,1,"","FT_PEEK");

		echo $msg;
		imap_close($open);
		}
		else {

		echo "False";

		}

	}
	function info()
	{
		phpinfo();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
