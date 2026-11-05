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
$incubationteam = array('USR032','USR039');
$topmanagement = array('USR011','USR033','USR012','USR043','USR097','USR086');
$consultant = array('USR098','USR096');
$middlemanagement = array('USR071','USR093','USR030');

?>


<div class="villgro-breadcrumb clearfix">
<div class="row">
<div class="col-md-12 col-12">

<ul>
       <?php  if($this->uri->segment('1') == 'dms' && $this->uri->segment('2') == 'document_system')
    { ?>
    <li> <a href="<?=site_url('login/icon_menu');?>">Home <i class="fa fa-angle-double-right"></i></a></li><li> <a href="<?=site_url('login/resources');?>">Resources <i class="fa fa-angle-double-right"></i></a></li><li> <a href="#" class="active">Document Managment System </a></li>
    <?php }
    ?>
    </ul>


    </div>
</div>
</div>


</div>



<section id="content">
	<section class="container_12 clearfix">
        	<article id="<?php echo $cpage;?>">
           	 <?php  $this->load->view('../message'); ?>
                
			 <?php  $this->load->view($cpage); ?>
            </article>
	</section>
</section>
<?php $this->load->view('../footer'); ?>
</body>
</html>