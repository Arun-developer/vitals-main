<h1><?=$cpagetitle?></h1>
<?php 
$nullLink = "javascript:void(0);";
$form_name = 'monthly_report';
?>
<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#search_form").validate();
	});
</script>
<form id="search_form" action="<?=site_url('common/report/new_report/')?>" method="post" name="<?=$form_name?>" class="searchForm">
<input type="hidden"  name="ordertype" value="<?=$ordertype?>"  />
<input type="hidden"  name="orderby" value="<?=$orderby?>"  />
<input type="hidden"  name="export" value=""  />
<div class="searchBox" style=" <?=(!empty($_POST['created_date']))?'':'display:none;'?>" >
<div align="right"><p>The fields which marked as <span style="color:red";>*</span> is Mandatory</p></div>
<dl class="inline">
            <dt><label for="created_date">Date Applied<span style="color:red";>*</span></label></dt>
            <dd>
                <?php 
				$created_date = isset($_REQUEST['created_date'])?$_REQUEST['created_date']:'';
				$created_date_to = isset($_REQUEST['created_date_to'])?$_REQUEST['created_date_to']:'';
				?>
				<input type="text" name="created_date" value="<?=$created_date?>" class="input-text required" id="fromdate" />&nbsp;-&nbsp;
				<input type="text" name="created_date_to" value="<?=$created_date_to?>" class="input-text required" id="todate"/>
            </dd>
</dl>
<div class="buttons">
    <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
    <button type="reset" class="button white">Reset</button>
</div>
</div>
</form>
<ul class="option-tab">
<li><a href="<?=$nullLink?>" class="button toggleSearch">Show Search</a></li>
<li></li>

</ul><br />
<br />

	<table class="gtable sortable">
	<thead>
		<tr>
			<th><a href="<?=$nullLink?>" class="sortlink">Reports</a></th>
			<th><a href="<?=$nullLink?>" class="sortlink">No. of Applications</a></th>
			</tr>
		
	</thead>
	<tbody>
			<tr>
            	<td>New Application Direct</td>
                
				<td><a href="<?=site_url('common/report/innovations_report/'.str_replace('/','-',$created_date).'/'.str_replace('/','-',$created_date_to));?>" ><?=$direct_Application;?></a></td>
			</tr>
			<tr>
            	<td>New Application - Identified By</td>
				<td><a href="<?=site_url('common/report/innovations_report_identifiedBy/'.str_replace('/','-',$created_date).'/'.str_replace('/','-',$created_date_to));?>" ><?=$identified_by;?></a></td>
			</tr>
			<tr>
            	<td>Entry - Follow Up</td>
				<td><a href="<?=site_url('common/report/innovations_report_followUp/'.str_replace('/','-',$created_date).'/'.str_replace('/','-',$created_date_to));?>" ><?=$followups;?></a></td>
			</tr>
        <tr>
            	<td>Entry - Decision Pending</td>
				<td><a href="<?=site_url('common/report/innovations_report_DecisionPending/'.str_replace('/','-',$created_date).'/'.str_replace('/','-',$created_date_to));?>" ><?=$decision_pending;?></a></td>
		</tr>

		<tr>
            	<td>Entry - Closed</td>
				<td><a href="<?=site_url('common/report/innovations_report_entryclosed/'.str_replace('/','-',$created_date).'/'.str_replace('/','-',$created_date_to));?>" ><?=$entry_closed;?></a></td>
		</tr>

		<tr>
            	<td>Total No of Deals</td>
				<td><a href="<?=site_url('common/report/innovations_report_totaldeals/'.str_replace('/','-',$created_date).'/'.str_replace('/','-',$created_date_to));?>" ><?=$total_deals;?></a></td>
		</tr>
		
	</tbody>
	</table>
	<!-- Paging style -->
