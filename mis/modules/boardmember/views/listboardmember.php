<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();
?>
<h1><?=$cpagetitle.'-'.$innovation['name_of_enterprise']?></h1>
<br />
<ul class="option-tab" style="margin-top:0px;">
 	<?php if($isincubAuth) 
	    {?>

   <?php  } ?>
        <li>
		     <a href="<?=site_url('boardmeeting/view/'.$innovationid.'/edit/edit');?>"  class="button">Schedule Boardmeeting</a></li>
        <li>		
			<a href="<?=site_url('boardmeeting/view_list/'.$innovationid.'/view/view');?>"  class="button">View Boardmeeting</a></li>
 	</ul>  
<br /><br/>
<!--start table-content  -->


	<!-- Paging style -->
	 
