<h1><?php echo $cpagetitle; ?></h1>
<div class="clear"></div>
<div class="boxNotice">
 <h2> Pending Approvals:</h2>
  <ul>
    <li> New applications awaiting approval: <a href="<?=site_url('scouting/innovation_pool/new');?>" ><strong><?=$newInnovations?></strong></a></li>
    <li>Entries awaiting approval : <a href="<?=site_url('scouting/innovation_pool/entry_pending');?>" ><strong><?=$entryPendingInnovations?></strong></a></li>
  </ul>
</div>

<div class="boxNotice fr">
 <h2>Stage-wise Report:</h2>
  <div id="generalChart" align="center"> 
       Stage-wise Report </div>
 </div>

<div class="boxNotice">
  <h2>Time Conversion:</h2>
  <div id="timeConvertionChart" align="center"> 
        Time Conversion </div>
  </div>
   
<div class="boxNotice fr">
  <h2>Source-wise report:&nbsp;(&nbsp;<a href="javascript:void(0);" onclick="$('.sourceReport').toggle();">View Details</a>&nbsp;):</h2>
  <div id="sourceWiseChart" align="center"> 
        Source-wise report: </div>
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
            <th>Convertion %</th>
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
  <h2>Resource-Wise Report:</h2>
  <div id="resourceComplted" align="center"> 
       Resource Completion Report </div>
  </div>
  
<div class="boxNotice fr">
  <h2>Resource-Wise Report:</h2>
 
   <div id="resourceConversion" align="center"> 
       Resource Convertion Report </div>
  </div>
<style type="text/css">
.boxNotice
{
  background: none repeat scroll 0 0 #fff;
  border: 2px solid #ECECEC;;
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