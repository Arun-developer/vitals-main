<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
<style>



</style>
<script type="text/javascript">
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".msg_body").hide();
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
		$(this).next(".msg_body").slideToggle(600);
	});
        $.getJSON('<?=site_url('dashboard/dashboard/sourcecompare')?>',function(data) {
                        /* data will hold the php array as a javascript object */
                        var json = $.parseJSON(data);
                        $('.table_section').hide();
                        $('#DynamicGrid').append(CreateTableView(json.source, "tabl", true)).fadeIn();

                });

});
</script>
<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
</script>

    <script src="<?=base_url();?>source/template/js/json.htmTable.js" type="text/javascript"></script>
    <script src="<?=base_url();?>source/template/js/json.debug.js" type="text/javascript"></script>
</head>
<body>

   <div class="header_report">
       <div class="header_report_LFT">

          </div>
       <div class="header_report_RHT"></div>
   </div>
   <div>
   <!--main body-->
    <div class="main_report">
     <div class="main_report1">
     <div class="main_down_report">
       <div class="main_down_Content">
       <div class="main_Content_Inner">
       <!--header tab menu-->
          <div class="report_tabmenu">
          <!--left-->
          <div class="report_tabmenu_LFT"></div>

          <div class="report_tabmenu_RHT">

           <div class="report_tabmenu">
               <?php if(@$filename =="") { ?>
            <ul>
                <li><a href="<?=site_url('dashboard/dashboard/scouting_report')?>" class="sel">Scouting &amp; Screening</a></li>
            <li><a href="<?=site_url('dashboard/dashboard/incubation_report')?>">Incubation</a></li>
            <li><a href="<?=site_url('dashboard/dashboard/progress_report')?>">Progress</a></li>
            </ul>
                        <?php } ?>
           </div>

         <div class="report_tabmenu2">
             <?php  if(@$filename =="") { ?>
          <div class="report_tabmenu23">
          <ul id="navbar">
          <li><a href="<?=site_url('dashboard/dashboard/scoutingquality')?>">Quality </a></li>
          <li><a href="<?=site_url('dashboard/dashboard/scouting_report')?>">Quantity</a></li>
	<li><a href="<?php echo site_url("dashboard/scoutingquality/ex"); ?>">Export</a>
	</li>
	<!-- ... and so on ... -->
</ul>

          </div>
             <?php } ?>

         </div>

        </div>

          </div>
          <!--end header tab menu-->
       <!--LEFT-->
<?php  if(@$filename =="") { ?>
       <div class="main_Content_Inner_LFT">
       <div class="report_sideline">
       <div class="main_menu">
           <form name="myform" method="post" action="<?=site_url('dashboard/dashboard/scoutingquality')?>">
        <ul>
        <li><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
</table></li>
        <li><h1>Top Fives<span>Current Year 2012</span></h1> </li>

        </ul>

        <div class="menu_list2">
        <h2 class="msg_head"><a href="" style="color:#B9DB3C !important">Source Wise Innovations</a></h2>
        <div class="msg_body">
        <ul>
        </ul>
        </div>
        </div>
        <div class="menu_list2">
        <h2 class="msg_head">Employee Wise</h2>
        <div class="msg_body">
        <ul>
            <?php foreach($employee as $eow):?>
         <li><span><input name="employee[]" type="checkbox" value="<?=$eow['emp_number'];?>" /></span><?=$eow['emp_name'];?></li>
        <?php endforeach;?>
        </ul>
        </div>
        </div>
        <div class="menu_list2">
        <h2 class="msg_head">Sector</h2>
        <div class="msg_body">
        <ul>
            <?php for($i=0;$i<4;$i++){?>
        <li><span><input name="sector[]" type="checkbox" value="<?=$sector[0][$i];?>" /></span><?=$sector[0][$i];?></li>
        <?php };?>
        </ul>
        </div>
        </div>
        <div class="menu_list2">
            <a href="<?=site_url('dashboard/dashboard/timetakenreport')?>">Time Taken</a>
        </div>
        <div class="report_compare_butt"><a href="javascript:void(0)" onclick="document.myform.submit()">Compare</a></div>
       </div>
           </form>
       </div>
</div>
<?php } ?>
       <!--END LEFT-->

       <!--Right-->
       <div class="main_Content_Inner_RHT">
        <div class="main_rht_full ">
        <h1>Dashboard </h1>
        <?php  if(@$filename =="") { ?>
        <div class="selectBAR">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="12%">Source Wise</td>
    <td width="2%" >&nbsp;</td>
    <td width="14%">Employee Wise </td>
    <td width="1%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td width="12%">Sector </td>
    <td width="1%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><select  name="select5" id="select5" style="width:130px;">
            <?php foreach($source as $rw):?>
            <option value="<?=$rw['master_name']?>"><?=$rw['master_name'];?></option>
            <?php endforeach;?>
    </select></td>
    <td>&nbsp;</td>
    <td><select name="select4" id="select4" style="width:130px;">
            <?php foreach($employee as $ew):?>
            <option value="<?=$ew['emp_name']?>"><?=$ew['emp_name'];?></option>
            <?php endforeach;?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><select name="select2" id="select2" style="width:130px;">
            <?php for($i=0;$i<4;$i++){ ?>
            <option value="<?=$sector[0][$i]?>"><?=$sector[0][$i];?></option>
            <?php } ?>
    </select></td>
    <td>&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="30%" class="report_apply_butt"><a href="#">Apply</a></td>
  </tr>
</table>
        </div>

 <?php
 }

 if(count($employeeselected) != 0){

     ?>
<div class="table_section ">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="table_BG"><table id="tabl" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td class="table_HEADER">Employee</td>
        <td class="table_HEADER">Source Type</td>
        <td class="table_HEADER">New</td>
           <td class="table_HEADER">Entry</td>
            <td class="table_HEADER">Conversion %</td>
             <td class="table_HEADER">Lead </td>
            <td class="table_HEADER">Conversion %</td>
        	<td class="table_HEADER">Detailed Deligence</td>
            <td class="table_HEADER"> Conversion %</td>
			<td class="table_HEADER">Incubation</td>
            <td class="table_HEADER">Conversion %</td>
      </tr>
     <?php foreach($employeeWiseReport as $row):
		$i = ($i=='odd')?'even':'odd';
		?>
			<tr class="<?=$i?>">
            	<td class="table_down" rowspan="<?=count($row['report'])+1?>"><?=$row['created_emp']?></td>
				</tr>
                <?php foreach($row['report'] as $value): ?>
                <tr class="<?=$i?>">
                <td class="table_down"><?=$value['source_type']?></td>
		<td class="table_down"><?=$value['total_new']?></td>
                <td class="table_down"><?=$value['total_entry']?></td>
                <td class="table_down"><?=$value['convertion_new_entry']?>%</td>
                <td class="table_down"><?=$value['total_lead']?></td>
                 <td class="table_down"><?=$value['convertion_entry_lead']?>%</td>
		<td class="table_down"><?=$value['total_screening']?></td>
                 <td class="table_down"><?=$value['screening_percentage']?>%</td>
		<td class="table_down"><?=$value['total_incubation']?></td>
                 <td class="table_down"><?=$value['incubation_percentage']?>%</td>
                </tr>
                 <?php endforeach; ?>
		<?php
		endforeach;?>
    </table></td>
  </tr>
</table>

              <div class="report_chart">
               <div class="report_chart_INNER"><div id="employeequalityChart"></div></div>

              </div>
          </div>

        <?php } else  if(count($sectorselected) != 0){
     ?>
<div class="table_section ">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="table_BG"><table id="tabl" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr style="background:#4D4D4B;color:#fff;">
	  <td class="table_HEADER" style="color:#fff;">Year</a></td>
        <td class="table_HEADER" style="color:#fff;">Sector</a></td>
        <td class="table_HEADER" style="color:#fff;">New</a></td>
	<td class="table_HEADER" style="color:#fff;">%</a></td>
           <td class="table_HEADER" style="color:#fff;">Entry</a></td>
            <td class="table_HEADER" style="color:#fff;" >Conversion %</a></td>
             <td class="table_HEADER" style="color:#fff;">Lead </a></td>
            <td class="table_HEADER" style="color:#fff;">Conversion %</a></td>
        	<td class="table_HEADER" style="color:#fff;">Detailed Deligence</a></td>
            <td class="table_HEADER" style="color:#fff;"> Conversion %</a></td>
			<td class="table_HEADER" style="color:#fff;">Incubation</a></td>
            <td class="table_HEADER" style="color:#fff;">Conversion %</a></td>
      </tr>
     <?php  foreach($sectorWiseReport as $row):
		$i = ($i=='odd')?'even':'odd';
		$totalInnovation = count($sectorWiseReport);
		@$row['convertion_new_entry'] = round(($row['total_entry'] / $row['total_new']) * 100, 2);
        @$row['convertion_entry_lead'] = round(($row['total_lead'] / $row['total_entry'] ) * 100, 2);
        @$row['innovation_percent'] = round(($row['total_new'] / $totalInnovation) * 100, 2);
        @$row['screening_percentage'] = round(($row['total_screening'] / $totalInnovation) * 100, 2);
        @$row['incubation_percentage'] = round(($row['total_incubation']	/ $totalInnovation) * 100, 2);

		?>
		<tr width="13%">
				<td class="table_down"><?=$row['year']?></td>
            	<td class="table_down"><?=$row['answer']?></td>
		<td class="table_down"><?=$row['total_new']?></td>
                <td class="table_down"><?=$row['innovation_percent']?>%</td>
                <td class="table_down"><?=$row['total_entry']?></td>
                <td class="table_down"><?=$row['convertion_new_entry']?>%</td>
                <td class="table_down"><?=$row['total_lead']?></td>
                 <td class="table_down"><?=$row['convertion_entry_lead']?>%</td>
		 <td class="table_down"><?=$row['total_screening']?></td>
                  <td class="table_down"><?=$row['screening_percentage']?>%</td>
		 <td class="table_down"><?=$row['total_incubation']?></td>
                 <td class="table_down"><?=$row['incubation_percentage']?>%</td>
				</tr>
		<?php
		endforeach;?>
    </table></td>
  </tr>
</table>

              <div class="report_chart">
               <div class="report_chart_INNER"></div>

              </div>
          </div>
        <?php } 
		else {
            ?>
<div class="table_section ">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="table_BG"><table id="tabl" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr style="background:#4D4D4B;color:#fff;">
        <td class="table_HEADER" style="color:#fff;">Source Type</a></td>
        <td class="table_HEADER" style="color:#fff;">New</a></td>
	<td class="table_HEADER" style="color:#fff;">%</a></td>
           <td class="table_HEADER" style="color:#fff;">Entry</a></td>
            <td class="table_HEADER" style="color:#fff;" >Conversion %</a></td>
             <td class="table_HEADER" style="color:#fff;">Lead </a></td>
            <td class="table_HEADER" style="color:#fff;">Conversion %</a></td>
        	<td class="table_HEADER" style="color:#fff;">Detailed Deligence</a></td>
            <td class="table_HEADER" style="color:#fff;"> Conversion %</a></td>
			<td class="table_HEADER" style="color:#fff;">Incubation</a></td>
            <td class="table_HEADER" style="color:#fff;">Conversion %</a></td>
      </tr>
     <?php foreach($sourceWiseReport as $row):
		$i = ($i=='odd')?'even':'odd';
		?>
		<tr width="13%">
            	<td class="table_down"><?=$row['source_type']?></td>
		<td class="table_down"><?=$row['total_new']?></td>
                <td class="table_down"><?=$row['innovation_percent']?>%</td>
                <td class="table_down"><?=$row['total_entry']?></td>
                <td class="table_down"><?=$row['convertion_new_entry']?>%</td>
                <td class="table_down"><?=$row['total_lead']?></td>
                 <td class="table_down"><?=$row['convertion_entry_lead']?>%</td>
		 <td class="table_down"><?=$row['total_screening']?></td>
                  <td class="table_down"><?=$row['screening_percentage']?>%</td>
		 <td class="table_down"><?=$row['total_incubation']?></td>
                 <td class="table_down"><?=$row['incubation_percentage']?>%</td>
				</tr>
		<?php
		endforeach;?>
    </table></td>
  </tr>
</table>

              <div class="report_chart">
               <div class="report_chart_INNER"><div id="employeeChart"></div></div>
				
              </div>
          </div>



        <?php } ?>
        </div>


       </div>
       <!--END right-->
       </div>

       </div>

     </div>
     </div>
    </div>
  <!--End main body-->

   </div>


</body>
</html>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSColumn3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/quality.xml");
		   chart.render("employeeChart");
		</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSColumn3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/quality.xml");
		   chart.render("employeequalityChart");
		</script>		
<script type="text/javascript">
   function sourcechecked()
   {
        var allVals = [];
     $('input[name=source]:checked').each(function() {
       allVals.push($(this).val());
     });
    var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('dashboard/dashboard/sourcecompare');?>",
				data: {'source':allVals,'isajax':true},
				dataType:'json',
				success: function(datas) {
                                  var json = $.parseJSON(datas);
                                  $(json).each(function(){
                                     row = $('#tabl').append('<tr>') ;
                                     $(row).append('<td>').html(json.cell1.value);
                                  });
				}
			});
  }

                /* call the php that has the php array which is json_encoded */

    </script>