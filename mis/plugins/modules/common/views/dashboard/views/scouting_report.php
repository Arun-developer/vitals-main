<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
<?php if(isset($filename)) { ?>
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
<?php } ?>

    <script src="<?=base_url();?>source/template/js/json.htmTable.js" type="text/javascript"></script>
    <script src="<?=base_url();?>source/template/js/json.debug.js" type="text/javascript"></script>
</head>
<body>
<div id="show">
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
         <?php  if(@$filename =="") { ?>

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
          <li><a href="<?=site_url('dashboard/dashboard/sourcecompare')?>">Quantity</a></li>
	<li><a href="<?php echo site_url('dashboard/scouting_report/ex'); ?>">Export</a>
	</li>
	<!-- ... and so on ... -->
</ul>

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
            <?php for($i=0;$i<4;$i++){?>
        <li><span><input name="sector[]" type="checkbox" value="<?=$sector[0][$i];?>" /></span><?=$sector[0][$i];?></li>
        <?php };?>
        </ul>
        </div>
        </div>
        <div class="report_compare_butt"><a href="javascript:void(0)" onclick="document.myform.submit()">Compare</a></div>
       </div>
           </form>
       </div>
</div>
<?php  } ?>
       <!--END LEFT-->

       <!--Right-->
       <div class="main_Content_Inner_RHT">
        <div class="main_rht_full ">
        <h1>Dashboard </h1>
        <?php if(isset($filename) == "") { ?>
        <div class="selectBAR">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="12%">Source Wise</td>
    <td width="2%" >&nbsp;</td>
    <td width="14%">Employee Wise </td>
    <td width="1%">&nbsp;</td>
    <td width="13%">Frequency</td>
    <td width="1%">&nbsp;</td>
    <td width="12%">Sector </td>
    <td width="1%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><select  name="select5" id="select5" style="width:130px;" onchange="sourceselected(this.value);">
            <option value="">-select-</option>
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
			<option value="">-select-</option>
            <?php for($i=0;$i<4;$i++){ ?>
            <option value="<?=$sector[0][$i]?>"><?=$sector[0][$i];?></option>
            <?php } ?>
    </select></td>
    <td>&nbsp;</td>
    <td width="2%">&nbsp;</td>

  </tr>
</table>
        </div>


       <?php } ?>
 <div>

          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td class="table_BG"><div id="DynamicGrid" ></div>
      </td>
  </tr>
          </table>
 </div>

<div class="table_section ">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="table_BG">
         <table id="tabl" class="gtable" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr style="background:#4D4D4B;color:#fff;">
        <td class="table_HEADER" >&nbsp;</td>
        <?php foreach($stage as $key=>$value):?>
        <td width="10%" class="table_HEADER" style="color:#fff;"><?=$value;?></td>
        <?php endforeach; ?>
      </tr>
      <?php for($i=0;$i<count($scoutingyear);$i++)
      {
        ?>
      <tr>
	  <?php if(count($yearly) == 7) {
	  	 ?>
          <td  class="table_down"><?=$yearly[$i];?></td>
		  <?php } else {?>
		  	 <td class="table-down"><?=$yearly;?></td>
		  <?php } ?>
          <?php foreach($stage as $key=>$value){?>
		  

                <?php if($stage[$scoutingyear[$i]['stage']]==$value)
                { ?>

                <td class="table_down"><?=$scoutingyear[$i]['value'];?></td>
          <?php }  else
          {?>
                <td class="table_down">0</td>

          <?php } } ?>
           </tr>
      <?php }?>

    </table>
	</td>
  </tr>
</table>

        </div>
 <div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>

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

</div>
</body>
</html>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "500", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/sourcefunnel.xml");
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
</script>