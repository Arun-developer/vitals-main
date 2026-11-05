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
$this->load->view('../header'); 

if($this->session->userdata('user_type') == 'incubatee')
	$this->load->view('../incubatee_menu');
else
	$this->load->view('../menu');
?>
    <section id="content">
        <section class="container_12 clearfix">
            <article id="<?php echo $cpage;?>">
                <?php  $this->load->view('../message'); ?>
                <?php  $this->load->view($cpage); ?>
            </article>
            <?php $this->load->view('../left'); ?>
        </section>
    </section>
    <?php $this->load->view('../footer'); ?>
</body>

</html>