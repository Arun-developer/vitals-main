<script type='text/javascript' src="<?=base_url();?>source/template/js/flexcroll.js"></script>
<link href="<?=base_url();?>source/template/css/tutorsty.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url();?>source/template/css/flexcrollstyles.css" rel="stylesheet" type="text/css" />

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
							<h2>Leaves</h2>
							
									<ul id="source">
									<?php foreach($topLeave as $row): ?>
										<li><a href="javascript:;" from="<?php echo $defaultyearly; ?>"  empid="<?php echo $row['emp_number'] ;?>" >
											 <?=$row['emp_name'];?> - <?=$row['totalleave'];?></a>
										</li>
									<?php endforeach;?>
									</ul>
							</div>
						
							<div class="menu_list1">
							 <div id='mycustomscroll' class='flexcroll'>  
								<h2>Area</h2>
									<ul id="employee">
								
									<?php foreach($areaReport as $ew): ?>
										<li>
										  <a href="javascript:;" from="<?php echo $defaultyearly; ?>"  areaid="<?php echo $ew['areaid'] ;?>" ><?=$ew['area_name'];?> - <?=ceil($ew['total']);?></a>
										</li>
									<?php endforeach;?>
									</ul>
								 </div>	
									
							</div>
							
							<div class="menu_list1">
							  <div id='mycustomscroll' class='flexcroll'>  
								<h2>Project</h2>
									<ul id="employee">
								
									<?php foreach($projectReport as $ew): ?>
										<li>
										  <a href="javascript:;" from="<?php echo $defaultyearly; ?>"  projectid="<?php echo $ew['project_id'] ;?>" ><?=$ew['work_name'];?> - <?=ceil($ew['total']);?></a>
										</li>
									<?php endforeach;?>
									</ul>
								  </div>	
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
								 <div class="chart_box1 chart_box1_gap">
								 <h2>Employee Leave</h2>
								 <div class="chart_box1_inner">
									 <div id="employeeChart"></div>
								 
								 <div class="chart_inner_text_link"><a href="<?=site_url('dashboard/hrisdashboard/viewleavewisereport/'.$defaultyearly)?>" class="fancybox">View Report</a></div>
								 </div>
								 </div>
								 <!--end1-->
								 <!--2-->
										  
										  
								 <div class="chart_box1">
										 <h2>Leave Type</h2>
										 <div class="chart_box1_inner">
										  <div id="leavetypechart"></div>
										 <div class="chart_inner_text_link"><a href="<?=site_url('dashboard/hrisdashboard/viewleavetypewisereport/'.$defaultyearly.'/'.$empid)?>" class="fancybox">View Report</a></div>
										 </div>
									</div>
										
								 <!--end2-->
								 <!--3-->
								 <div class="chart_box1 chart_box1_last" style="margin-right: 3%;">
										 <h2>Area Wise</h2>
										 <div class="chart_box1_inner">
											 <div id="areaChart"> </div>
										 <div class="chart_inner_text_link"><a href="<?=site_url('dashboard/hrisdashboard/viewareawisereport/'.$defaultyearly)?>" class="fancybox">View Report</a></div>
										 </div>
								 </div>
								 
								 <!--end-->
								<!--4-->
								 <div class="chart_box1 chart_box1_gap">
									 <h2>Employee Wise(Area)</h2>
									 <div class="chart_box1_inner">
										  <div id="employeeareawise" > 
										  </div>
										 <div class="chart_inner_text_link">
											<a href="<?=site_url('dashboard/hrisdashboard/viewareaemployeewisereport/'.$defaultyearly.'/'.$areaid)?>" class="fancybox">View Report</a> 
										</div>
									 </div>
								 </div> 
							    <!--end-->   
							   	<!--5-->
								 <div class="chart_box1 chart_box1_last"  style="margin-right: 3%;clear:both;">
										 <h2>Project Wise</h2>
										  <div class="chart_box1_inner">
											 <div id="projectchart"> </div>
										   <div class="chart_inner_text_link"><a href="<?=site_url('dashboard/hrisdashboard/viewprojectwisereport/'.$defaultyearly)?>" 
										   class="fancybox" >View Report</a></div>
										 </div>
										
								 </div>
								<!--end1-->
								
								 <div class="chart_box1 chart_box1_gap"  style="">
									 <h2>Employee Wise(Project)</h2>
									 <div class="chart_box1_inner">
										  <div id="employeeprojectwise" > 
										  </div>
										 <div class="chart_inner_text_link">
											<a href="<?=site_url('dashboard/hrisdashboard/viewprojectemployeewisereport/'.$defaultyearly.'/'.$projectid)?>" class="fancybox">View Report</a> 
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
      $('a','#show').live('click',function()
   {
      
		 var year = $(this).attr('from');
		 var empid = $(this).attr('empid');
		 var areaid=$(this).attr('areaid');
		 var projectid=$(this).attr('projectid');
		 var textname= $(this).text().split('-')[0];
		   var form_data = {
					year:year,
					empid:empid,
					areaid:areaid,
					projectid:projectid,
					textname:textname,
					ajax: '4'
				}; 
				
				
		var datas=	$.ajax({

					url: '<?php echo site_url('dashboard/hrisdashboard/yearsearch');?>',
					type: 'POST',
					data: form_data,
					datatype:'json',
					success: function(msg)
					{
		            
				    
                      var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "420", "300", "0", "0");
		              chart.setXMLUrl("<?=base_url()?>source/charts/data/emptypeleavetypebar.xml");		   
		              chart.render("leavetypechart");
					
				  
				     var chart = new FusionCharts("<?=base_url()?>source/charts/Line.swf", "ChartId", "400", "300", "0", "0");
		 		     chart.setXMLUrl("<?=base_url()?>source/charts/data/areaemployeewisebar.xml");		   
		  			 chart.render("employeeareawise");
				
					  
			
				     var chart = new FusionCharts("<?=base_url()?>source/charts/Line.swf", "ChartId", "420", "300", "0", "0");
				     chart.setXMLUrl("<?=base_url()?>source/charts/data/projectemployeewisebar.xml");		   
				     chart.render("employeeprojectwise");
	 
					}
			}); 
  });

     function changeyear(val)
    {
        var year = val;
        var datas = $.ajax({	
				type: "POST",
				url: "<?php echo site_url('dashboard/hrisdashboard/yearsearch');?>",
				data: {'year':year,'isajax':true},
				success: function(datas) 
				{ 
					$("#dashboard").css('border','none');
					$('#show').html(datas);
					
			
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Line.swf", "ChartId", "420", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/areaemployeewisebar.xml");		   
		   chart.render("employeeareawise");
		   
		    var chart = new FusionCharts("<?=base_url()?>source/charts/Line.swf", "ChartId", "420", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/projectemployeewisebar.xml");		   
		   chart.render("employeeprojectwise");
		   

                }
		      });
    }
    
    </script>
<script type="text/javascript" src="<?=base_url()?>source/fancybox/jquery.fancybox-1.3.4.js"></script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>

<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/employeeleavebar.xml");		   
		   chart.render("employeeChart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/emptypeleavetypebar.xml");		   
		   chart.render("leavetypechart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/areawisebar.xml");		   
		   chart.render("areaChart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Line.swf", "ChartId", "420", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/areaemployeewisebar.xml");		   
		   chart.render("employeeareawise");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Column3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/projectwisebar.xml");		   
		   chart.render("projectchart");
</script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Line.swf", "ChartId", "420", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/projectemployeewisebar.xml");		   
		   chart.render("employeeprojectwise");
</script>
