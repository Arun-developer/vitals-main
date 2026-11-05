<h1><?=$cpagetitle?></h1>
<?php 
$nullLink = "javascript:void(0);";
$form_name = 'monthly_report';
?>
<form id="<?=$form_name?>" action="<?=site_url('common/report/monthly_report/')?>" method="post" name="<?=$form_name?>" class="searchForm">
<input type="hidden"  name="ordertype" value="<?=$ordertype?>"  />
<input type="hidden"  name="orderby" value="<?=$orderby?>"  />
<input type="hidden"  name="export" value=""  />
<div class="searchBox" style=" <?=(!empty($_POST['created_date']))?'':'display:none;'?>" >
<dl class="inline">
            <dt><label for="created_date">Date Applied</label></dt>
            <dd>
                <?php 
				$created_date = isset($_REQUEST['created_date'])?$_REQUEST['created_date']:'';
				$created_date_to = isset($_REQUEST['created_date_to'])?$_REQUEST['created_date_to']:'';
				?>
				<input type="text" name="created_date" value="<?=$created_date?>" class="input-text" id="fromdate" />&nbsp;-&nbsp;
				<input type="text" name="created_date_to" value="<?=$created_date_to?>" class="input-text" id="todate"/>
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
			<th><a href="<?=$nullLink?>" field="created_date" class="sortlink">Month/Year</a></th>
			<th><a href="<?=$nullLink?>" field="total" class="sortlink">No. of New Applications</a></th>
			</tr>
		
	</thead>
	<tbody>
    <?php
	$total = array();
	if(count($monthlyReport)){
		foreach($monthlyReport as $row):
		$total[] = $row['total'];
		?>
			<tr>
            	<td><?=$row['date'];?></td>
				<td><a href="<?=site_url('scouting/innovation_pool');?>" ><?=$row['total']?></a></td>
				</tr>
		<?php 
		endforeach;
		?>
        <tr>
            	<td><strong>Total</strong></td>
				<td><?=array_sum($total);?></td>
		</tr>
        <?php
	}
	else
	{
	?>
    <tr class="odd"><td colspan="10" align="center">No Records</td></tr>
	<?php } ?>
		
	</tbody>
	</table>
	<!-- Paging style -->
