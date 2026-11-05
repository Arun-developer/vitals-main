<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Villgro</title>
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
<style>
#navbar {
	margin: 0;
	padding: 10px;
	height: 1em; }
#navbar li {
	list-style: none;
	float: left; }
#navbar li a {
	display: block;
	padding: 3px 8px;
	background-color: #d9e8a5;
	color: #565855;
	text-decoration: none; }
	#navbar li ul {
	display: none;
	width: 10em; /* Width to help Opera out */
	background-color: #d9e8a5;}
	#navbar li:hover ul {
	display: block;
	position: absolute;
	margin: 0;
	padding: 0; }
#navbar li:hover li {
	float: none; }
#navbar li:hover li a {
	background-color: #d9e8a5;
	border-bottom: 1px solid #fff;
	color: #000; }
#navbar li li a:hover {
	background-color: #d8dec6; }


</style>
<script type="text/javascript">
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".msg_body").hide();
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
		$(this).next(".msg_body").slideToggle(600);
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
       <div class="header_report_LFT"></div>
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
            <ul>
                <li><a href="<?=site_url('dashboard/dashboard/scouting_report')?>" class="sel">Scouting &amp; Screening</a></li>
            <li><a href="<?=site_url('dashboard/dashboard/incubation_report')?>">Incubation</a></li>
            <li><a href="<?=site_url('dashboard/dashboard/progress_report')?>">Progress</a></li>
            </ul>
           </div>
         <div class="report_tabmenu2">
          <div class="report_tabmenu23">
          <ul id="navbar">
          <li><a href="<?=site_url('dashboard/dashboard/scoutingquality')?>">Quality </a></li>
          <li><a href="<?=site_url('dashboard/dashboard/scouting_report')?>">Quantity</a></li>
	<!-- ... and so on ... -->
</ul>

<script type="text/javascript">

$(document).ready(function(){
$("#exportID").click(function() {
 var datas = $.ajax({
				type: "POST",
				async: false,
				url: "<?php echo site_url('dashboard/dashboard/sourcecompare/ex');?>",
				data: {'isajax':true},
				success: function(datas)
				{
					
                }
		      });
			  
			  });
});

</script>

          </div>

         </div>

        </div>

          </div>
          <!--end header tab menu-->
       <!--LEFT-->

       <div class="main_Content_Inner_LFT">
       <div class="report_sideline">
       <div class="main_menu">
           <form name="myform" method="post" action="<?=site_url('dashboard/dashboard/sourcecompare')?>"/>
        <ul>
        <li><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
</table></li>
        <li><h1>Top Fives<span>Current Year 2012</span></h1> </li>

        </ul>

        <div class="menu_list2">
        <h2 class="msg_head">Source Wise Innovations</h2>
        <div class="msg_body">
        <ul>
            <?php foreach($source as $row):?>
        <li><span><input name="source[]" type="checkbox"  value="<?=$row['master_name'];?>" /></span><?=$row['master_name'];?></li>
        <?php endforeach;?>
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
            <?php $sector = array_pop($sector);for($i=0;$i<php72_count($sector);$i++){?>
        <li><span><input name="sector[]" type="checkbox" value="<?=trim($sector[$i]);?>"/></span><?=$sector[$i];?></li>
        <?php };?>
        </ul>
        </div>
        </div>
        
        <div class="report_compare_butt"><a href="javascript:void(0)" onclick="document.myform.submit()">Compare</a></div>
       </div>
           </form>
       </div>
</div>

       <!--END LEFT-->

       <!--Right-->
       <div class="main_Content_Inner_RHT">
        <div class="main_rht_full ">
        <h1>Dashboard </h1>
        <div class="selectBAR">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="12%">Source Wise</td>
    <td width="2%" >&nbsp;</td>
    <td width="14%">Employee Wise </td>
    <td width="1%">&nbsp;</td>
    <td width="13%">Frequency</td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td><select  name="select5" id="select5" style="width:130px;" onchange="sourceselected(this.value);">
            <?php foreach($source as $rw):?>
            <option value="<?=$rw['master_name']?>"><?=$rw['master_name'];?></option>
            <?php endforeach;?>
    </select></td>
    <td>&nbsp;</td>
    <td><select name="select4" id="select4" style="width:130px;" onchange="employeeselected(this.value);">
            <?php foreach($employee as $ew):?>
            <option value="<?=$ew['emp_name']?>"><?=$ew['emp_name'];?></option>
            <?php endforeach;?>
    </select></td>
    <td>&nbsp;</td>
    <td><select name="select3" id="select3" style="width:130px;" onchange="frequencyselected(this.value)">
	<option value="">-select-</option>
            <option value="<?=site_url('dashboard/dashboard/scoutingquarterreport')?>">Quarterly</option>
            <option value="<?=site_url('dashboard/dashboard/scoutingmonthreport')?>">Monthly</option>
            <option value="<?=site_url('dashboard/dashboard/scouting_report')?>">Yearly</option>
    </select></td>
    <td>&nbsp;</td>
    <td><select name="select2" id="select2" style="width:130px;" onchange="sectorselected(this.value)">
            <?php for($i=0;$i<4;$i++){ ?>
            <option value="<?=$sector[$i]?>"><?=$sector[$i];?></option>
            <?php } ?>
    </select></td>
    <td>&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="30%" class="report_apply_butt"><a href="#">Apply</a></td>
  </tr>
</table>
        </div>
 <?php if((!empty($sourceselected)) AND (empty($employeeselected)) AND (empty($sectorselected))){ //print_r($sourcecompare);?>
<div class="table_section ">
<table width="100%" class="gtable" cellspacing="1" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php 
        foreach($stage as $key=>$value):?>
        <td colspan="1" width="13%"><?=$value;?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($sourceselected); for($i=0;$i<php72_count($stage);$i++){    ?>
                <td rowspan ="<?=php72_count($selected)+1?>" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<php72_count($selected);$k++){
                ?>
       <tr>
        <td  width="13%" class="table_down"><?=@$selected[$k];?></td>
        <?php  foreach($sourcecompare as $row){?>

                <?php if(($row['year'] == @$yearly[$i]))
                { ?>

        <td class="table_down"><?=$row['VALUE'];?></td>
        <?php } else{?>
        <td class="table_down">0</td>
        <?php }
            }
        } ?>
      </tr>
            <?php } ?></tr>
          </table></div>
		  <div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>
              </div>
       </div>
      <?php }  ?>
<?php if((empty($sourceselected)) AND (!empty($employeeselected)) AND (empty($sectorselected))){ //print_r($sourcecompare);?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="1" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php 
        foreach($stage as $key=>$value):?>
        <td colspan="1" width="13%"><?=$value;?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($employeeselected); for($i=0;$i<php72_count($stage);$i++){    ?>
                <td rowspan ="<?=php72_count($selected)+1?>" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<php72_count($selected);$k++){
                ?>
       <tr>
        <td  width="13%" class="table_down"><?=$sourcecompare[$k]['emp_firstname'];?></td>
        <?php  foreach($stage as $key=>$value){?>

                <?php if(($sourcecompare[$i]['year'] == $yearly[$i]) || (($sourcecompare[$i]['emp_number'] == @$selected[$k]) && ($stage[$sourcecompare[$i]['stage']]==$value)))
                { ?>

        <td class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td class="table_down">0</td>
        <?php }
            }
        } ?>
      </tr>
            <?php } ?></tr>
          </table></td>
  </tr>
</table></div>
<div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>
              </div>
       </div>
      <?php } ?>
    <?php
    if((empty($sourceselected)) AND (empty($employeeselected)) AND (!empty($sectorselected))){
       ?>
<div class="table_section ">

          <table width="100%"  class="gtable"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="1" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php
        foreach($stage as $key=>$value):?>
        <td colspan="1" width="13%"><?=$value;?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($sectorselected); for($i=0;$i<php72_count($stage);$i++){    ?>
                <td rowspan ="<?=php72_count($selected)+1?>" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<php72_count($selected);$k++){
                ?>
       <tr>
        <td  width="13%" class="table_down"><?=$selected[$k];?></td>
        <?php  foreach($stage as $key=>$value){?>

                <?php if(($stage[$sourcecompare[$i]['stage']]==$value) || ($sourcecompare[$i]['answer'] == @$selected[$k]))
                { ?>

        <td class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td class="table_down">0</td>
        <?php }
            }
        } ?>
      </tr>
            <?php } ?></tr>
          </table></td>
  </tr>
</table></div>
<div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>
              </div>
       </div>
      <?php } ?>

<?php
if((!empty($sourceselected)) AND (!empty($employeeselected)) AND (empty($sectorselected))){?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr>
          <td class="table_down" width="14%"></td>
       <td align="left" colspan="8">
           <table style="width:100%">
               <tr>
                   <td class="table_down" >&nbsp;</td>
                   <td>
                       <table align="right"><tr><td class="table_down"></td>
                               <td>
                                   <table  align="right" style="width:100%">
                           <tr>
                               <td>&nbsp;</td>
                              <?php
                                foreach($stage as $key=>$value):?>
                                <td style="cellpadding:3%"><?=$value;?></td>
                                <?php endforeach;?>
                           </tr></table>
                               </td></tr><tr><td></td></tr>
                       </table>
                   </td>
               </tr>
           </table>
       </td>
      </tr>

        <?php $j=0; $selected = array_pop($employeeselected); $sselected = array_pop($sourceselected); for($i=0;$i<php72_count($stage);$i++){    ?>
               <tr>  <td width="14%" class="table_down"><?=$yearly[$i];?></td><td  colspan="8"><table style="width:100%">
              <?php  for($k=0;$k<php72_count($selected);$k++){
                ?>

       <tr>
       <td class="table_down"><?=$sourcecompare[$k]['emp_firstname'];?></td>
       <td>
           <table  style="width:100%">
       <?php for($l=0;$l<php72_count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]==$value) && ($sourcecompare[$i]['emp_number'] == @$selected[$k]) && ($sourcecompare[$i]['master_name'] == @$sselected[$k]))
       { ?>
       <td style="width:12%" class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td  style="width:12%" class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td></tr>
         <?php } ?>
      </table></td></tr>
            <?php } ?>

         </td></table>
  </tr>
</table></div>
<div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>
              </div>
       </div>
      <?php } ?>
<?php if((!empty($sourceselected)) && (empty($employeeselected)) && (!empty($sectorselected))){ ?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr>
          <td class="table_down" width="14%"></td>
            <td align="left" colspan="8">
           <table style="width:100%">
               <tr>
                   <td class="table_down" >&nbsp;</td>
                   <td>
                       <table align="right"><tr><td class="table_down"></td>
                               <td>
                                   <table  align="right" style="width:100%">
                           <tr>
                               <td>&nbsp;</td>
                              <?php
                                foreach($stage as $key=>$value):?>
                                <td style="cellpadding:3%"><?=$value;?></td>
                                <?php endforeach;?>
                           </tr></table>
                               </td></tr><tr><td></td></tr>
                       </table>
                   </td>
               </tr>
           </table>
       </td>
      </tr>

        <?php $j=0; $selected = array_pop($sectorselected); $sselected = array_pop($sourceselected); for($i=0;$i<php72_count($stage);$i++){    ?>
               <tr>  <td width="14%" class="table_down"><?=$yearly[$i];?></td><td  colspan="8"><table style="width:100%">
              <?php  for($k=0;$k<php72_count($selected);$k++){
                ?>

       <tr>
       <td class="table_down"><?=$selected[$k];?></td>
       <td>
           <table  style="width:100%">
       <?php for($l=0;$l<php72_count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]== $value) && ($sourcecompare[$i]['year'] == 2011))
       {  ?>
       <td style="width:12%" class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php  } else{?>
        <td  style="width:12%" class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td></tr>
         <?php } ?>
      </table></td></tr>
            <?php } ?>

         </td></table>
  </tr>
</table></div>
<div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>

              </div>
       </div>
      <?php } ?>
<?php if((empty($sourceselected)) && (!empty($employeeselected)) && (!empty($sectorselected))){ echo "ji";?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php 
        foreach($stage as $key=>$value):?>
        <td><?=$value;?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($employeeselected); $sselected = array_pop($sourceselected); for($i=0;$i<php72_count($stage);$i++){    ?>
                <td rowspan ="3" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<php72_count($selected);$k++){
                ?>
       <tr>
       <td class="table_down"><?=$sourcecompare[$k]['emp_firstname'];?></td>
       <td colspan="7">
           <table>
       <?php for($l=0;$l<php72_count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]==$value) && ($sourcecompare[$i]['emp_number'] == @$selected[$k]) && ($sourcecompare[$i]['master_name'] == @$sselected[$k]))
       { ?>
       <td class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td  class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td>
         <?php } ?>
      </tr>
            <?php } ?></tr>

          </table></td>
  </tr>
</table>
    </div>
	<div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>

              </div>
       </div>
      <?php } ?>
    <?php if((!empty($sourceselected)) && (! empty($employeeselected)) && (!empty($sectorselected))){ ?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php 
        foreach($stage as $key=>$value):?>
        <td><?=$value;?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($employeeselected); $sselected = array_pop($sourceselected); for($i=0;$i<php72_count($stage);$i++){    ?>
                <td rowspan ="3" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<php72_count($selected);$k++){
                ?>
       <tr>
       <td class="table_down"><?=$sourcecompare[$k]['emp_firstname'];?></td>
       <td colspan="7">
           <table>
       <?php for($l=0;$l<php72_count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]==$value) && ($sourcecompare[$i]['emp_number'] == @$selected[$k]) && ($sourcecompare[$i]['master_name'] == @$sselected[$k]))
       { ?>
       <td class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td  class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td>
         <?php } ?>
      </tr>
            <?php } ?></tr>

          </table></td>
  </tr>
</table>
    </div>
	<div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>

              </div>
       </div>
      <?php } ?>



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
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Pareto3D.swf", "ChartId", "500", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/employeecomparebar.xml");
		   chart.render("timeConvertionChart");
		</script>
<script type="text/javascript">
   function sourceselected(val)
   {
       var source = val;
       var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('dashboard/dashboard/sourcesearchreport');?>",
				data: {'source':source,'isajax':true},
				success: function(datas)
				{
					$("#dashboard").css('border','none');
					$('#show').html(datas);
                }
		      });
   }
   function employeeselected(val)
   {
       var employee = val;
       var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('dashboard/dashboard/employeesearchreport');?>",
				data: {'employee':employee,'isajax':true},
				success: function(datas)
				{
					$("#dashboard").css('border','none');
					$('#show').html(datas);
                }
		      });
   }
   function sectorselected(val)
   {
   	  var sector = val;
	  var datas = $.ajax({
	  					type:"POST",
						url:"<?php echo site_url('dashboard/dashboard/sectorsearchreport');?>",
						data:{'sector':sector,'isajax':true},
						success:function(datas)
						{
							$("#dashboard").css('border','none');
							$("#show").html(datas);
						}
					});
   }
function frequencyselected(val)
   {
       var frequency = val;
       document.location.href = frequency;
   }
                /* call the php that has the php array which is json_encoded */

    </script>