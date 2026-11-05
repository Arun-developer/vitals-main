<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />

</head>
    <div id="show">

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
       <!--LEFT-->
       <div class="main_Content_Inner_LFT">
       <div class="main_menu">
        <ul>
            <b>SELECT YEAR:</b>
        <li><select name="Select" style="width:200px;" onchange="changeyear(this.value)">
               <?php foreach($yearly as $key=>$value):?>
                <option value="<?=$value?>" <?=($value == $defaultyearly)?'selected':'';?>><?=$value;?></option>
                <?php endforeach;?>
            </select></li>
        <li><h1>Top Fives<span>Current Year 2012</span></h1> </li>

        </ul>
        <div class="menu_list1">
        <h2><a href="<?=site_url('dashboard/dashboard/scouting_report');?>" style="color:#B9DB3C !important">Source Wise Innovations</a></h2>
        <ul id="source">
        <?php foreach($sourcewise as $sw): ?>
            <li><?=$sw['master_name'];?> - <?=$sw['total'];?></li>
        <?php endforeach;?>
        </ul>
        </div>
		<div class="menu_list1">
        <h2><a href="<?=site_url('dashboard/dashboard/incubation_report');?>" style="color:#B9DB3C !important">Service Offering</a></h2>
        <ul id="service">
        <?php for($i=4;$i<=10;$i++){?>
            <li><?=$serviceoffering['title_'.$i];?> - <?=$serviceoffering['total'.$i];?></li>
            <?php } ?>
        </ul>
        </div>
        <div class="menu_list1">
        <h2>Employee's Wise</h2>
        <ul id="employee">
        <?php foreach($employeewise as $ew): ?>
            <li><?=$ew['emp_name'];?> - <?=$ew['total'];?></li>
        <?php endforeach;?>
        </ul>
        </div>
        
       </div>

</div>
       <!--END LEFT-->

       <!--Right-->
       <div class="main_Content_Inner_RHT">
        <div class="main_rht_full ">
        <h1>Dashboard </h1>
         <div class="main_rht_full2">
         <!--1-->
		  <div class="chart_box1  chart_box1_gap"">
         <h2>Service Offering Wise</h2>
         <div class="chart_box1_inner">
          <div id="serviceChart"></div>
         <div class="chart_inner_text"><a href="<?=site_url('dashboard/dashboard/viewservicewise/'.$defaultyearly)?>" class="fancybox">View Report</a></div>
         </div>
         </div>
		 
         <!--end1-->

                  <!--1-->
          <div class="chart_box1 chart_box1_gap">
         <h2>Employee Wise</h2>
         <div class="chart_box1_inner">
             <div id="employeeChart"></div>
         <div class="chart_inner_text"><a href="<?=site_url('dashboard/dashboard/viewemployeewise/'.$defaultyearly)?>" class="fancybox"> View Report</a></div>
         </div>
         </div>
		 
         <!--end1-->
                  <!--2-->
         <div class="chart_box1 chart_box1_gap">
         <h2>Stage Wise</h2>
         <div class="chart_box1_inner">
          <div id="timeConvertionChart" > </div>
         <div class="chart_inner_text"><a href="<?=site_url('dashboard/dashboard/viewstagewise/'.$defaultyearly)?>" class="fancybox">View Report</a></div>
         </div>
         </div>
                
         <!--end1-->
                  <!--3-->
        <div class="chart_box1 chart_box1_last">
         <h2>Sales Report</h2>
         <div class="chart_box1_inner">
             <div id="salesChart"> </div>
         <div class="chart_inner_text"><!--<a href="">View Report</a>--></div>
         </div>
         </div>
         <!--end1-->
            <!--4-->
         <div></div>
         <!--end1-->
         </div>
<div class="table_HEADing"><h3>Stage Wise<span>View Chart</span></h3></div>


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
      <?php for($i=0;$i<php72_count($stagewise);$i++)
      {
        ?>
      <tr>
	  <?php if(php72_count($yearly) == 7) {
	  	 ?>
          <td  class="table_down"><?=$yearly[$i];?></td>
		  <?php } else {?>
		  	 <td class="table-down"><?=$yearly;?></td>
		  <?php } ?>
          <?php foreach($stage as $key=>$value){?>
		  

                <?php if($stage[$stagewise[$i]['stage']]==$value)
                { ?>

                <td class="table_down"><?=$stagewise[$i]['value'];?></td>
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
        </div>
</html>

<style type="text/css">
       .gtable tbody  tr:hover td {
            background: none !important;
        }

        .tableheadBCk, .tableheadBCk:hover {
                background:#4D4D4B !important;
                color:#fff !important;
                font-weight:bold !important;
        }

</style>
<script type="text/javascript">
     function changeyear(val)
    {
        var year = val;
        var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('dashboard/dashboard/yearsearch');?>",
				data: {'year':year,'isajax':true},
				success: function(datas)
				{
					$("#dashboard").css('border','none');
					$('#show').html(datas);
                }
		      });
    }

    </script>
<script type="text/javascript" src="<?=base_url()?>source/fancybox/jquery.fancybox-1.3.4.js"></script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Doughnut2D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/sourcefunnel.xml");
		   chart.render("timeConvertionChart");
		</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/employeebar.xml");
		   chart.render("employeeChart");
		</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Pareto3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/servicepie.xml");
		   chart.render("serviceChart");
		</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSColumn3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/salesreport.xml");
		   chart.render("salesChart");
		</script>