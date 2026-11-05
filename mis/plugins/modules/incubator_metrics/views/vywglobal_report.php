<script type="text/javascript">
    $(document).ready(function(){
	$(".togglePanel").hide();
    $("#frmgetMonth").validate();	
	$("tr:odd").css("background-color","#EEFCE9");
	$("tr:even").css("background-color","white");
	
	$("#expandSlide").click(function () {
			$('.togglePanel').slideToggle("slow");
	});
  });

</script>
<a href="javascript:history.go(-1)" class="button"  style="margin-left:1150px;"> Back</a></br><br>
<div class="box1">
<div class="boxLFT">
<div class="sub">
<h1 style="background-color:#B9CE98;color:black;padding-bottom:5px;font-weight:bold;"><?=$cpagetitle.'-'.$innovation['name_of_enterprise']?></h1>
</div>
</div><br>
<?php if($this->session->userdata('user_type') != 'incubatee') { ?>
<div class="boxRHT">
<ul>
	<li><a href="<?=site_url('incubator_metrics/wglobal_report/configure/'.$urlcode.'/'.$tabKey);?>" class="button fancybox">Configure</a></li>
	<li><a href="<?php echo site_url('master/exit_details_master/view_list/')?>" class="button">Assign Criteria</a></li>
	<li><a href="#" class="button" id="yearslideToggle" >Show Filter</a></li>
</div>
<?php } ?>
</div>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/monthly.css" /> 
<div class="clear"></div>



<!----Tab Start -->
<ul class="menu">
<?php foreach($reportDetails as $tabKey1=> $value) {?>
        <li >
        <a class="<?= ($tabKey1 == $tabKey)?'sel':''?>" href="<?php echo site_url('incubator_metrics/wglobal_report/index/'.$urlcode.'/'.$tabKey1);?>" ><?php echo $value; ?></a>
        </li>
		<?php }?>
		      
 </ul>

 <br>
 
<!--Tab Finish-->
<div id="slidebox"  style="display:none;">
	<form name="frmgetMonth" id="frmgetMonth" action="<?php site_url('incubator_metrics/wglobal_report/monthlyReport/')?>" method="post" >
	    <br>
			<table cellpadding="4" cellspacing="7" class="inline" width="50%">

    <tr>
	   <td> <label for="" style="font-weight:bold;">From Year <span class="req_field">*</span></label></td>
       <td><input type="text" name="year[fromYear]" value="" size="20"  class="Year required" /></td>
    </tr>
	<tr style="margin-top:8px;">
	 
	    <td> <label for="" style="font-weight:bold;">To Year<span class="req_field">*</span></label></td>
        <td> <input type="text" name="year[toYear]" value="" size="20"  class="Year required" /></td>
    </tr>

</table>
		<div class="buttons1" style="margin-left:155px;margin-top:10px;" >
			<button type="submit" class="button" value="Search" name="txtSubmit" onclick="return validateFrom();">Search</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="submit" class="button white" value="Search" name="txtSubmit">Reset</button>
		</div> 
	
	</form>
</div>
    <br>
<div class="mainBODY">
 <div class="maibBODYlft">
 <!--grid 2-->
  <div class="grid2">
  
  <div class="boxNotice ">

<?php 	
			    $data = array();
				$td = '<table class="girdBOX" style="width:588px;" cellspacing="3" cellpadding="4">';
				$td .= '<th class="head headLARGE grid5Hei">Exit Criteria</th>';
				$td .= '<th class="head headLARGE grid5Hei">Year</th>'; 
				$td .= '<th class="head headLARGE grid5Hei">Total In Numbers</th>'; 
				
				$td .= '<tr>';
				$td .= '<td>'."Board Meeting".'</td>';
				if(!empty($exitDetails)) {
				if(count($exitDetails) == '4') { 
					$td .= '<td>'.$exitDetails['0']['exitDate'].'</td>';
					$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">'.$exitDetails.'</a></td>';
				} else {
					$td .= '<td>'.$exitDetails['0']['exitDate'].'</td>';
					$td .= '<td style="color:red;font-weight:bold;">'. count($exitDetails) .'</td>';
				}
				}
				$td .= '</tr>';
				$td .= '<tr>';
				$td .= '<td>'."Professional Board".'</td>';
				if(count($exitboardDetails) >= '1') { 
					$td .= '<td>2012</td>';
					$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">'.$exitboardDetails['0']['count(board_id)'].'(inducted)</a></td>';
				} else {
					$td .= '<td>'.$exitboardDetails['0']['exitDate'].'</td>';
					$td .= '<td style="color:red;font-weight:bold;">'.count($exitboardDetails).'</td>';
				}
				$td .= '</tr>';
				$td .= '<tr>';
				$td .= '<td>'."Fund Utilization".'</td>';
				foreach($fundDispassedDetails as $fundReq){
					$funddisbursed = $fundReq['totalamount'];
				}
				foreach($fundUtilizationDetails as $funduti){
					$fund = $funduti['utilized_amount'];
					$date = $funduti['date'];
				}
				if(($funddisbursed == $fund) && ($funddisbursed != '')) { 
					$td .= '<td>'.$date.'</td>';
					$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">Totally Fund Utilized</a></td>';
				} else {
					$td .= '<td>'.$date.'</td>';
					$td .= '<td style="color:red;font-weight:bold;">Fund Not Totally Utilized</td>';
				}
				$td .= '</tr>';
				$td .= '</table>';
				echo $td;
	?>
    <?php
				$header = NULL;
				$data = array();
				$td = '<table id="table1" style="width:588px;" class="girdBOX" width="auto" cellspacing="3" cellpadding="4">';
				$td .= '<th class="head headLARGE grid5Hei">Metrices</th>';
			   foreach($monthDetails as $row)
			   {
				   if($header != $row['progress_date'])
				   {
						   $header = $row['progress_date'];
						   $headerArray[] = $header;
						   $td .= '<th class="head headLARGE">'.$header.'</th>';
				   }
				   $data[$row['label']][$row['progress_date']] = !empty($row['answer']);
			   }
			 foreach($data as $key => $value)
			{
				   $td .= '<tr>';
				   $td .= '<td>'.$key.'</td>';
				   for($i=0;$i<count($headerArray);$i++)
				   {
						   if(isset($value[$headerArray[$i]]))
							{ 
								$res =  $this->mwglobal_report->green($urlcode,$key);
								  if(isset($res['answer']) == $value[$headerArray[$i]])
									  {
									   $td .= '<td style="color:green"><a href="repayment/index/"'.$urlcode.'">'.$value[$headerArray[$i]].'</td>';
									  }
								  else
									  {
									  $td .= '<td>'.$value[$headerArray[$i]].'</td>';
									  }
							}
							
				   }
				   $td .= '</tr>';
			}
			$td .= '</table>';
			echo $td; ?>
</div>
  
  </div>
 
 <!--End grid 2-->
 <!--grid 3-->
  <div class="grid3">
   <div class="boxNotice" style="width:580px;">
    <h2>Revenue & Profit (L):&nbsp;&nbsp;<a href="javascript:void(0);" onclick="$('.sourceReport').toggle();"></a>&nbsp;:</h2>
  <div id="generalChart" >Employees: </div>
    
    <?php if(isset($options))
    {
    if($options['showtype'] == 'barchart'){ ?>

    
<div class="boxNotice" >
 <h2>Monthly Chart Report:</h2>
  <div id="generalbarChart" style=" width:588px;" > 
       </div>
 </div>
<?php } }?>
		</div>
  </div> 
 <!--End grid 3-->
 
 </div>
 <!--End Left -->
 <div class="maibBODYRHT">
 
<!-- Grid 4--> 
 <div class="grid4 ">
 <div class="boxNotice fr" style="width:583px;">
		<table width="100%" class="girdBOX" > 
			<th class="head headLARGE grid5Hei">Service</th>
			<th class="head headLARGE grid5Hei">Fund Disbursed</th>
			<th class="head headLARGE grid5Hei">Fund Utilized</th>
			
			<tr> 
				 <td >Seed Funding </td>
				 <?php 	
				 foreach($fundDispassedDetails as $fundReq) {  ?>
		 
		           <td><?php echo $fundReq['totalamount']; ?></td>
			    <?php	} 
				  foreach($fundUtilizationDetails as $fundUtilized) {  ?>
					<td> <?php echo $fundUtilized['utilized_amount']; ?> </td>  
		        <?php } ?>
				 <td> </td>
			</tr>
		</table>
</div>
 </div> 
<!-- End Grid 4--> 
<!--Grid 5-->
  <div class="grid5">
    <div class="boxNotice fr">
<?php 
		
                $td = '<table width="100%" style="width:583px; cellspacing:3px; cellpadding:4px;" class="girdBOX"  >';
               
                $td .= '<th  style="padding:5px;" class="head headLARGE">Service Offerings</th>';
				$td .= '<th class="head headLARGE grid5Hei">Total</th>';
				$td .= '<th class="head headLARGE grid5Hei">Accpet</th>';
				$td .= '<th class="head headLARGE grid5Hei">Reject</th>';
				
				$td.="<tr>";	
				$td.="<td >"."Media"."</td>";	
				foreach($mediaDetails as $media) { 
					$td.="<td>".$media['count(id)']."</td>";
				}
				$td.="</tr>"; 
				
				$td.="<tr>";	
				$td.="<td >"."Board Formation"."</td>";	
				foreach($boardDetails as $board) { 
				
					$td.="<td>".$board['request_status']."</td>";
				}
				$td.="<td > </td>";	
				$td.="</tr>"; 
				
				$td.="<tr>";	
				$td.="<td >"."Fellow	"."</td>";	
				foreach($felowDetails as $felow) { 
				
					$td.="<td>".$felow['count(id)']."</td>";
				}
				
				
					
				$td.="</tr>"; 
				
				$td.="<tr>";	
				$td.="<td >"."Raise Investment"."</td>";	
				foreach($investerDetails as $invester) { 
				
					$td.="<td>".$invester['status']."</td>";
				}
				
				$td.="<td ></td>";
				$td.="</tr>";
				$td .= '</table>';
                echo $td;

?>
</div>
  
  </div>


<!--End Grid 5-->

<!--Grid 6-->
  <div class="grid6">
  
<div class="boxNotice fr" style="width:583px;">
    <?php	  
                $td = '<table width="100%" class="girdBOX">';
                $td .= '<th class="head headLARGE grid5Hei"></th>';
                $td .= '<th class="head headLARGE grid5Hei">Actual</th>';
                $td .= '<th class="head headLARGE grid5Hei">Target</th>';
								
                $td.="<tr>";				
                $td.="<td>"."Mentoring"."</td>";				
                $td.="<td>".$mentorDetails['actual']."</td>";
				$td.="<td>".$mentorDetails['target']."</td>";
                $td.="</tr>";
				
                 $td.="<tr>";			 
                 $td.="<td >"."Go-To-Market"."</td>";
                foreach($getmonthlymediaDetails as $row)
				{
                $td.="<td>".$row['count(RM.id)']."</td>";  
                $td.="<td>".$row['count(MD.media_id)']."</td>";  
				}
                 $td.="</tr>";
                $td.="<tr>";
                $td.="<td >"."Talent"."</td>";
                foreach($getmonthlyapplicantDetails as $row)
				{
                
                $td.="<td>".$row['count(RA.id)']."</td>";  
                $td.="<td>".$row['count(AA.id)']."</td>";  
				}
                 $td.="</tr>";
                $td.="<tr>";
                $td.="<td >"."Networking"."</td>";
                $td.="<td>".$getPartnerDetails['actual']."</td>";  
                $td.="<td>".$getPartnerDetails['target']."</td>";  
                $td.="</tr>";
                
                $td .= '</table>';
                echo $td;
?>    
 </div>
  
  </div>
<!--End Grid 6-->

<!--Grid 7-->

			<?php
			$header = NULL;
			$td = '<table width="100%" cellspacing="3" cellpadding="4" style="width:588px;">';
			$td .= '<th class="head headLARGE grid5Hei">Account Manager</th>';
			$td .= '<th class="head headLARGE grid5Hei">Actual</th>';
			$td .= '<th class="head headLARGE grid5Hei">Target</th>';

			foreach($accManager as $row)
			{ 
			$td.="<tr>";
			$td.="<td >".$row['label']."</td>";  
			$td.="<td>".$row['actual']."</td>";  
			$td.="<td>".date('M',mktime(0,0,0,$row['month'])).' '.$row['month']."</td>";
			$td.="<td></td>";
			$td.="</tr>";
			}
			$td .= '</table>';
			echo $td;
			?>


			</div>
  
  </div>-->
<!--End Grid 7-->

 </div>
 		



 <div class="detail sourceReport"  style="display:none; width:100%; overflow:scroll;">
	<table class="detailtable">
	<thead>
		<tr>
			<th class="head headLARGE">Source Type</th>
            <th class="head headLARGE">New</th>
			<th class="head headLARGE">%</th>
            <th class="head headLARGE">Entry</th>
            <th class="head headLARGE">Convertion %</th>
             <th class="head headLARGE">Lead </th>
            <th class="head headLARGE">Convertion %</th>
		</tr>
		
	</thead>
	</table>
 </div>
  
  </div>
  
 </div>
 
 
 </div>
<style type="text/css">
#dshboardPanel {
	width:1000px;
	height:auto;
	
}
.boxNotice
{
  background: none repeat scroll 0 0 #fff;
  border: 2px solid #ECECEC;;
  color: #000000;
  font-size: 12px;
  line-height: 14px;
  padding: 10px;
  width:auto;
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

 <script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
 <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/ScrollLine2D.swf", "ChartId", "467", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/monthlyReport.xml");		   
		   chart.render("generalChart");
	    
		 $(document).ready( function() {
		
			 $(function() {
				$( ".Year" ).datepicker({
					
					changeYear: true,
					showButtonPanel: true,
					dateFormat: 'yy',
					
					onClose: function(dateText, inst) { 
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
						$(this).datepicker('setDate', new Date(year));
					}
            				});
                                        
                         $("#yearslideToggle").click(function () {
				  $('#slidebox').slideToggle("slow");
				
				});
		  });                   
				
			});
 </script>
  <style>
		.ui-datepicker-calendar {
			display: none;
			}
		#slidebox	{
			padding:8px;
			margin:16px;
			border:1px solid #808080;
			height:133px;		
		}
		.mainBODY{ width:100%;  height:100%; }
		.maibBODYlft, .maibBODYRHT{ width:49%; height:100%; min-height:400px; float:left; }
		.maibBODYRHT{  float:right;}
		.grid5{}
		.grid5 td, .grid4 td, .grid6 td, .grid7 td, .grid2 td{ padding:5px;}
		.grid5Hei{ height:25px;}
		
		</style>
                
                <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSBar3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/monthbarchart.xml");		   
		   chart.render("generalbarChart");
		</script>