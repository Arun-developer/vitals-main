<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
<?php if(isset($filename)) { ?>
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
          <li><a href="<?=site_url('dashboard/dashboard/scouting_report')?>">Quantity</a></li>
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
           <form name="myform" method="post" action="<?=site_url('dashboard/dashboard/progresscompare')?>"/>
        <ul>
        <li><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
</table></li>
        <li><h1>Top Fives<span>Current Year 2012</span></h1> </li>

        </ul>
        <ul>
            <?php foreach($metrics as $row):
			?>
        <li><input name="metrics[]" type="checkbox"  value="<?=$row['label'];?>" <?php echo ($row['label'] == $_POST['metrics'])? 'checked':''?> /><?=$row['label'];?></li>
        <?php endforeach;?>
        </ul>
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
        </table>
        </div>


       <?php } ?>
<div class="table_section ">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="table_BG"><table id="tabl" width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr style="background:#4D4D4B;color:#fff;">
        <td class="table_HEADER" >&nbsp;</td>
        <?php foreach($yearly as $key=>$value):?>
        <td width="10%" class="table_HEADER" style="color:#fff;"><?=$value;?></td>
        <?php endforeach; ?>
      </tr>
      <?php for($i=0;$i<count($progresscompare);$i++)
      {
        ?>
      <tr>
          <td  class="table_down"><?=$progresscompare[$i]['name_of_enterprise'];?></td>
          <?php foreach($yearly as $key=>$value){?>

                <?php if($progresscompare[$i]['year']==$value)
                { ?>

                <td class="table_down"><?=$progresscompare[$i]['total'];?></td>
          <?php }  else
          {?>
                <td class="table_down">0</td>

          <?php } } ?>
           </tr>
      <?php }?>

    </table></td>
  </tr>
</table>
</div>
<div class="report_chart" >
               <div class="report_chart_INNER"><div id="timeConvertionChart" ></div></div>

              </div>
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
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/progresschar.xml");
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
                /* call the php that has the php array which is json_encoded */

    </script>