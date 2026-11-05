<?php

	$currentTab = $this->uri->segment('1'); 
	$id =$innovation['id'];?>
	<div class="boxed menu">
	<h2>Incubation Progress Menu</h2>
	<section>
	<ul> 
    	  <li><a href="<?=site_url('assign_incubation/assign_incubation/assign_checklist/'.$innovation['id']);?>">Assign Metrics Incubation</a></li>
         <li><a href="<?=site_url('reports/progress_report/index/');?>">Incubation Progress Report</a></li>
	</ul>
	</section></div>
	



