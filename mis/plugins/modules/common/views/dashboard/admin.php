<h1><?php echo $cpagetitle; ?>-<?=$year;?></h1>
<div>
<form name="search" action="<?=site_url('common/dashboard/admin/')?>" method="post">
<label for="year">SELECT YEAR:</label>
<select name="year">
<?php 
foreach($yearly as $key=>$value):?>
<option value="<?=$value?>" <?=($value == $year)?'selected':'';?>><?=$value?></option>
<?php
endforeach;
?>
</select>
<input type="submit" name="search" class="button" value="search"/>
</form>
</div>
<div class="clear"></div>
<div class="boxNotice">
 <h2> Pending Approvals:</h2>
  <ul>
    <li> New applications awaiting approval: <a href="<?=site_url('scouting/innovation_pool/new');?>" ><strong><?=$newInnovations ?></strong></a></li>
    <li>Entries awaiting approval : <a href="<?=site_url('scouting/innovation_pool/entry_pending');?>" ><strong><?=$entryPendingInnovations?></strong></a></li>
  </ul>
</div>
<div class="boxNotice fr">
 <h2>Stage-wise Report:</h2>
  <div id="generalChart" align="center">
      </div>
 </div>

<div class="boxNotice">
  <h2>Time Conversion:&nbsp;(&nbsp;<a href="javascript:void(0);" onclick="$('.timeReport').toggle();">View Details</a>&nbsp;):</h2>
  <div id="timeConvertionChart" align="center">
      </div>
	  <div class="detail timeReport"  style="display:none; width:100%; overflow:scroll;">
	<table class="gtable detailtable">
	<thead>
		<tr>
			<th>Stage</th>
			<th>Avg Time</th>
            <th>Max Time</th>
			<th>Min Time</th>
		</tr>
	</thead>
	<tbody>
    <?php
	if(count($new_entry_avg)){
		$i='odd';
		?>
			<tr class="<?=$i?>">
			<td>New - Entry </td>
			<td><?=$new_entry_avg['avgtime']?></td>
			<td><?=$new_entry_avg['maxtime']?></td>
			<td><?=$new_entry_avg['mintime']?></td>
			</tr>
			<tr>
			<td>Entry - Lead</td>
            <td><?=$entry_lead_avg['avgtime']?></td>
            <td><?=$entry_lead_avg['maxtime']?></td>
            <td><?=$entry_lead_avg['mintime']?></td>
			</tr>
			<tr>
			<td>Lead - Diligence</td>
            <td><?=$lead_deligence_avg['avgtime']?></td>
            <td><?=$lead_deligence_avg['maxtime']?></td>
            <td><?=$lead_deligence_avg['mintime']?></td>
			</tr>
			<tr>
			<td>Incubation</td>
            <td><?=abs($incubation_avg['avgtime']);?></td>
            <td><?=abs($incubation_avg['maxtime']);?></td>
            <td><?=abs($incubation_avg['mintime']);?></td>
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
 </div>
  </div>

<div class="boxNotice fr">
  <h2>Source-wise report:&nbsp;(&nbsp;<a href="javascript:void(0);" onclick="$('.sourceReport').toggle();">View Details</a>&nbsp;):</h2>
  <div id="sourceWiseChart" align="center">
        </div>
 <div class="detail sourceReport"  style="display:none; width:100%; overflow:scroll;">
	<table class="gtable detailtable">
	<thead>
		<tr>
			<th>Source Type</th>
            <th>New</th>
			<th>%</th>
            <th>Entry</th>
            <th>Convertion %</th>
            <th>Lead </th>
            <th>Conversion %</th>
		</tr>
	</thead>
	<tbody>
    <?php
	if(count($sourceWiseReport)){
		$i='odd';
		foreach($sourceWiseReport as $row):
		$i = ($i=='odd')?'even':'odd';
		?>
			<tr class="<?=$i?>">
				<td><?=$row['name']?></td>
				<td><?=$row['total_new']?></td>
                <td><?=$row['innovation_percent']?>%</td>
                <td><?=$row['total_entry']?></td>
                <td><?=$row['convertion_new_entry']?>%</td>
                <td><?=$row['total_lead']?></td>
                <td><?=$row['convertion_entry_lead']?>%</td>
			</tr>
		<?php
		endforeach;
	}
	else
	{
	?>
    <tr class="odd"><td colspan="10" align="center">No Records</td></tr>
	<?php } ?>

	</tbody>
	</table>
 </div>
</div>
<div class="boxNotice">
  <h2>Stage Conversion Report:</h2>
  <div id="statgeToStageChart" align="center">
        Stage Conversion Report </div>
  </div>
<div class="boxNotice">
  <h2>Resource Completion Report:&nbsp;(&nbsp;<a href="javascript:void(0);" onclick="$('.resourceReport').toggle();">View Details</a>&nbsp;):</h2>
  <div id="resourceComplted" align="center">
       </div>
	   <div class="detail resourceReport"  style="display:none; width:100%; overflow:scroll;">
	<table class="gtable detailtable">
	<thead>
		<tr>
			<th>Employee Name</th>
            <th>Assigned</th>
			<th>Completed</th>
            <th>pending</th>
            <th>Lead </th>
            <th>Entry</th>
		</tr>
	</thead>
	<tbody>
    <?php
	if(count($resourceCompleteReport)){
		$i='odd';
		foreach($resourceCompleteReport as $row):
		$i = ($i=='odd')?'even':'odd';
		?>
			<tr class="<?=$i?>">
				<td><?=$row['emp_name']?></td>
				<td><?=$row['assigned']?></td>
                <td><?=$row['completed']?>%</td>
                <td><?=$row['pending']?></td>
                <td><?=$row['lead']?>%</td>
                <td><?=$row['entry']?></td>
			</tr>
		<?php
		endforeach;
	}
	else
	{
	?>
    <tr class="odd"><td colspan="10" align="center">No Records</td></tr>
	<?php } ?>

	</tbody>
	</table>
 </div>
  </div>

<div class="boxNotice fr">
  <h2>Resource Conversion Report :</h2>

   <div id="resourceConversion" align="center">
        </div>
  </div>
<style type="text/css">
.boxNotice
{
  background: none repeat scroll 0 0 #fff;
  border: 1px solid #ECECEC;;
  color: #000000;
  font-size: 12px;
  line-height: 14px;
  padding: 10px;
  width:47%;
  margin-left:2px;
  margin-bottom:10px;
  float:left;
}

.boxNotice li
{
	list-style:none;
	margin:5px 0px;
	padding:7px;
}
.hf
{
	width:45%;
}
.fr
{
	float:right;
}
div.code {
  background: none repeat scroll 0 0 #F5F8FA;
  border: 2px solid #D7E8F0;
  color: #000000;
  font-family: "Courier New",Courier,monospace;
  font-size: 12px;
  line-height: 14px;
  padding: 10px;
}
article
{
	float:left;
}
.boxNotice h2 {
        margin-bottom:10px;
}
</style>

 <script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>      <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSBar3D.swf", "ChartId", "400", "600", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/sourceWise.xml");
		   chart.render("sourceWiseChart");
		</script>

<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSBar3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/timeConvertion.xml");
		   chart.render("timeConvertionChart");
		</script>

<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>      <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/generalChart.xml");
		   chart.render("generalChart");
		</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>      <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/stageToStageChart.xml");
		   chart.render("statgeToStageChart");
		</script>

         <script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>      <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSBar3D.swf", "ChartId", "400", "<?=$resourceCount*75?>", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/resourceComplted.xml");
		   chart.render("resourceComplted");
		</script>
        <script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>      <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSBar3D.swf", "ChartId", "400", "<?=$resourceCount*75?>", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/resourceConversion.xml");
		   chart.render("resourceConversion");
		</script>