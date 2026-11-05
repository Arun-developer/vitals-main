<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $cpagetitle;?></title>
<meta charset="utf-8">
<?php
$this->load->view('../includes');
?>
</head>
<body class="fluid">
<?php
$incubationteam = array('USR032','USR039','USR106','USR115','USR080');
$topmanagement = array('USR011','USR033','USR012','USR043','USR097','USR086');
$middlemanagement = array('USR071','USR093','USR030');
$consultant = array('USR098','USR096');
$this->load->view('../header');

if($this->session->userdata('user_type') == 'incubatee')
	$this->load->view('../incubatee_menu');
else if(in_array($this->session->userdata('user_id'),$incubationteam))
	$this->load->view('../menu_incubation');
else if(in_array($this->session->userdata('user_id'),$topmanagement))
	$this->load->view('../menu_top');	
else if(in_array($this->session->userdata('user_id'),$consultant))
	$this->load->view('../menu_consultant');	
else if(in_array($this->session->userdata('user_id'),$middlemanagement))
	$this->load->view('../menu_admn');	
else
	$this->load->view('../menu');
?>
<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
                    <div >
           	 <?php  $this->load->view('../message'); ?>
			 <?php  $this->load->view($cpage); ?>

		</section>
		<?php $this->load->view('../left'); ?>
	</section>
</section>
<?php $this->load->view('../footer'); ?>
</div>
</div>
</body>
</html>