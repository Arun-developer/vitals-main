<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url(); ?>/source/custom_js/jquery-1.3.2.min.js"></script>

</head>
    <div id="show">
        
<body>
    <h1><?=$cpagetitle;?>-<?=$name_of_enterprise;?></h1>
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
						<li><select name="Select" style="width:200px;" onchange="changeyear(this.value);">
							   <?php foreach($yearly as $key=>$value):?>
								<option value="<?=$value?>" <?=($value == $defaultyearly)?'selected':'';?>><?=$value;?></option>
								<?php endforeach;?>
							</select></li>
						</ul>
						
					   </div>
					  </div>
			   <!--END LEFT-->
			   <!--Right-->
                           <div id="sample" style="display:none">
                               <table>
                                   <thead>
                                       <tr>
                                           <td>Total Fund Disbursed</td>
                                           <td>Total Fund Approved</td>
                                           <td>Total Fund Utilized</td>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <?php foreach($seedfunding_report as $row):?>
                                       <tr>
                                           <td><?=$row['amount'];?></td>
                                           <td><?=$row['approved_amount'];?></td>
                                           <td><?=$row['fund_utilized'];?></td>
                                       </tr>
                                       <?php endforeach;?>
                                   </tbody>
                               </table>
                           </div>
				 <div class="main_Content_Inner_RHT">
						<div class="main_rht_full ">
					<h1>Dashboard </h1>
					   <div class="main_rht_full2">
							 <!--1-->
								 <div class="chart_box1 chart_box1_gap">
								 <h2>Seed Funding Report</h2>
								 <div class="chart_box1_inner">
									 <div id="employeeChart"></div>
                                                                         <div class="chart_inner_text_link">
								 <a href="<?php echo site_url('incubator_metrics/wglobal_report/viewsfreport/'.$urlcode.'/'.$defaultyearly)?>" class="fancybox">View Report</a>
                                                                         </div>
                                                                         </div>
								 </div>
								 <!--end1-->
								<!--2-->
								 <div class="chart_box1 chart_box1_gap">
									 <h2>Fund Utilization Report</h2>
									 <div class="chart_box1_inner">
										  <div id="employeeareawise" > 
										  </div>
										 <div class="chart_inner_text_link">
											<a href="<?=site_url('incubator_metrics/wglobal_report/viewmediareport/'.$urlcode.'/'.$defaultyearly)?>" class="fancybox">View Report</a> 
										</div>
									 </div>
								 </div> 
							    <!--end-->   
							   	<!--3-->
								 <div class="chart_box1 chart_box1_last"  style="margin-right: 3%;clear:both;">
										 <h2>Board Meeting Report</h2>
										  <div class="chart_box1_inner">
											 <div id="projectchart"> </div>
										   <div class="chart_inner_text_link"><a href="<?=site_url('incubator_metrics/wglobal_report/viewboardmeetingreport/'.$urlcode.'/'.$defaultyearly)?>" 
										   class="fancybox" >View Report</a></div>
										 </div>
										
								 </div>
								<!--end1-->
								
								 <div class="chart_box1 chart_box1_gap"  style="">
									 <h2>Progress Report</h2>
									 <div class="chart_box1_inner">
										  <div id="employeeprojectwise" > 
										  </div>
										 <div class="chart_inner_text_link">
											<a href="<?=site_url('incubator_metrics/wglobal_report/progressreport/'.$urlcode.'/'.$defaultyearly)?>" class="fancybox">View Report</a> 
										</div>
									 </div>
								 </div>
	
								 
					 <div>
					 
					 </div>
					 <!--end1-->
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
    <script type="text/javascript">
     function changeyear(val)
    {
        var year = val;
        var id = <?php echo $urlcode;?>;
        var datas = $.ajax({	
				type: "POST",
				url: "<?php echo site_url('incubator_metrics/wglobal_report/yearsearch');?>",
				data: {'year':year,'id':id,'isajax':true},
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
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/seedfunding_report.xml");		   
		   chart.render("employeeChart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/board_report.xml");		   
		   chart.render("leavetypechart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/fellow_report.xml");		   
		   chart.render("areaChart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "420", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/media_report.xml");		   
		   chart.render("employeeareawise");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/meeting_report.xml");		   
		   chart.render("projectchart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Line.swf", "ChartId", "420", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/progress_report.xml");		   
		   chart.render("employeeprojectwise");
</script>

</html>
