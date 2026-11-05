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
</ul>	
</div>
<?php }  ?>
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
				   <td> <label for="" style="font-weight:bold;">From Month <span class="req_field">*</span></label></td>
				   <td><input type="text" name="getMonth[fromMonth]" id="fromMonth" value="" size="20"  class="monthYear required" /></td>
				</tr>
				<tr style="margin-top:8px;">
				 
					<td> <label for="" style="font-weight:bold;">To Month<span class="req_field">*</span></label></td>
					<td> <input type="text" name="getMonth[toMonth]" id="toMonth" value="" size="20"  class="monthYear required" /></td>
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
 <!--grid 1-->
 <div class="grid1">
 <div style="width:607px;min-height:110px; height:100%; margin-bottom:5px;border: 2px solid #ECECEC;float:left;overflow:scroll;">
				<?php
				
				$header = NULL;
				$data = array();
				$td = '<table id="table1" width="auto" class="girdBOX" cellspacing="3" cellpadding="4">';
				$td .= '<th class="head headLARGE grid5Hei">Metrices</th>';
				
				foreach($monthDetails as $row)
				{
				if($header != $row['progress_date'])
				{	
					$header = $row['progress_date'];
					$headerArray[] = $header;
					$monthName = date('M',mktime(0,0,0,$header));
					$td .= '<th class="head headLARGE grid5Hei"  >'.$monthName.'</th>';
				}
				$data[$row['label']][$row['progress_date']] = $row['answer'];
				}
				foreach($data as $key => $value)
				{
				$td .= '<tr>';
				$td .= '<td >'.$key.'</td>';
				for($i=0;$i<php72_count($headerArray);$i++)
				{
					if(isset($value[$headerArray[$i]]))
					 {	
						$res =  $this->mwglobal_report->green($urlcode,$key);
							if('50000' <= $value[$headerArray[$i]]) {
							$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">'.$value[$headerArray[$i]].'</a></td>';	 
							} else {
							$td .= '<td>'.$value[$headerArray[$i]].'</td>';
							
							}
						
					 }
					 else
					 {
						 $td .= '<td>&nbsp;</td>';
					 }
				}
				$td .= '</tr>';
				}
				$td .= '</table>';
				echo $td;
				?>
	</div>			
 </div>
 <!--End grid 1-->
 <!--grid 2-->
  <div class="grid2">
  
  <div class="boxNotice ">

<?php 	

			    $data = array();
				$td = '<table class="girdBOX" style="width:588px;" cellspacing="3" cellpadding="4">';
				$td .= '<th class="head headLARGE grid5Hei">Exit Criteria</th>';
				$td .= '<th class="head headLARGE grid5Hei">Year</th>'; 
				$td .= '<th class="head headLARGE grid5Hei">Target</th>';
				$td .= '<th class="head headLARGE grid5Hei">Achevied</th>'; 
				
				$td .= '<tr>';
				$td .= '<td style="background-color:#dce7cc;font-weight:bold;border:1px solid #B9CE98;" ><a  href="'.site_url('boardmeeting/view/'.$urlcode.'/4/view').'">'."Board Meeting".'</a></td>';
				if(!empty($exitDetails)) {
				if(php72_count($exitDetails) == '4') { 
					$td .= '<td>'.$exitDetails['0']['exitDate'].'</td>';
					$td .= '<td>'.'4'.'</td>';
					$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">'.$exitDetails.'</a></td>';
				} else {
					$td .= '<td>'.$exitDetails['0']['exitDate'].'</td>';
					$td .= '<td>'.'4'.'</td>';
					$td .= '<td style="color:red;font-weight:bold;"><a style="color:red;font-weight:bold;" href="'.site_url('boardmeeting/view/'.$urlcode.'/4/view').'">'. php72_count($exitDetails) .'</a></td>';
				}
				}
				$td .= '</tr>';
				$td .='<tr>';
				$td .='<td  style="background-color:#dce7cc;font-weight:bold;border:1px solid #B9CE98;" ><a  href="'.site_url('invester/view_list/'.$urlcode).'">'."Raise Investment".'</a></td></tr>';
				
				if(!empty($raiseinvestment))
				{
					foreach($raiseinvestment as $row)
					{
						if($row['amount'] == $row['amount_approved'])
						{
     						$td .= '<tr><td style="color:green;font-weight:bold;"><a href="'.site_url('invester/view_list/'.$urlcode).'">'.$row['amount_approved'].'</a></td>';
						} else {
								$td .= '<tr>';
								$td .= '<td style="background-color:#dce7cc;font-weight:bold;border:1px solid #B9CE98;"></td>';
								$td .= '<td>'.date('Y').'</td>';
								$td .= '<td>'.$row['amount'].'</td>';
								$td .= '<td>'.$row['amount_approved'].'</td>';
								$td .= '</tr>';
						}
					}
				}
				$td .='</tr>';
				$td .= '<tr>';
				$td .= '<td style="background-color:#dce7cc;font-weight:bold;"><a  href="'.site_url('boardmember/view_list/'.$urlcode).'">'."Professional Board".'</a></td>';
				if(php72_count($exitboardDetails) >= '1') { 
					$td .= '<td>'.date('Y').'</td>';
					$td .= '<td>'.'More than 1'.'</td>';
					$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">'.php72_count($exitboardDetails).'(inducted)</a></td>';
				} else {
					$td .= '<td>'.$exitboardDetails['0']['exitDate'].'</td>';
					$td .= '<td>'.'More than 1'.'</td>';
					$td .= '<td style="color:red;font-weight:bold;">'.php72_count($exitboardDetails).'</td>';
				}
				$td .= '</tr>';
				$td .= '<tr>';
				$td .= '</tr>';
				$td .= '</table>';
				echo $td;
	?>
    </div>
  
  </div>
 
 <!--End grid 2-->
 <!--grid 3-->
  <div class="grid3">
   <div class="boxNotice" style="width:580px;" id="hidechart">
   <?php $chartType = @$options['0']['chart_type'];
	if(isset($options))
    {
    if((isset($options['showtype']) == 'general') || $chartType == "general"  || (!empty($urlcode))){ ?>
    <h2>Revenue & Profit (L):&nbsp;&nbsp;<a href="javascript:void(0);" onclick="$('.sourceReport').toggle();"></a>&nbsp;:</h2>
  <div id="generalChart" >Employees: </div>
    
    <?php 
	
	} }
	$chartType = @$options['0']['chart_type'];
	if(isset($options))
    {
    if((isset($options['showtype']) == 'barchart') || $chartType == "barchart" ){ ?>
<div class="boxNotice" >
 <h2>Monthly Chart Report:</h2>
  <div id="generalbarChart" style=" width:566px;" > 
       </div>
 </div>
<?php } }?>
		</div>
  </div> 
 <!--End grid 3-->
<!--  --> 
 
 </div>
 <!--End Left -->
 <div class="maibBODYRHT">
 
<!-- Grid 4--> 
 <div class="grid4 ">
 <div class="boxNotice fr" style="width:583px;" >
		<table width="100%" class="girdBOX" > 
			<th class="head headLARGE grid5Hei">Service</th>
			<th class="head headLARGE grid5Hei">Fund Disbursed</th>
			<th class="head headLARGE grid5Hei">Fund Utilized</th>
			<th class="head headLARGE grid5Hei">Total Fund</th>
			
			<tr> 
				 <td style='background-color:#dce7cc;border:1px solid #B9CE98;'>Seed Funding </td>
			
				<?php foreach($fundapproved as $funda){
					?>
				<td><?php echo $funda['amt_required'];?></td>	
				<?php } 
				  foreach($fundUtilizationDetails as $fundUtilized) {  ?>
					<td> <?php echo $fundUtilized['utilized_amount']; ?> </td>  
		        <?php }  foreach($fundDispassedDetails as $fundReq) {  ?>
		 
		           <td><?php echo $fundReq['totalamount']; ?></td>
			    <?php	} ?>
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
				$td .= '<th class="head headLARGE grid5Hei" >Total</th>';
				$td .= '<th class="head headLARGE grid5Hei">Accpet</th>';
				$td .= '<th class="head headLARGE grid5Hei">Reject</th>';
				
				$td.="<tr>";	
				$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Media"."</td>";	
				foreach($mediaDetails as $media) { 
					$td.="<td>".$media['count(id)']."</td>";
				}
				$td.="</tr>"; 
				
				$td.="<tr>";	
				$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Board Formation"."</td>";	
				foreach($boardDetails as $board) { 
				
					$td.="<td>".$board['request_status']."</td>";
				}
				$td.="<td > </td>";	
				$td.="</tr>"; 
				
				$td.="<tr>";	
				$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Fellow	"."</td>";	
				foreach($felowDetails as $felow) { 
				
					$td.="<td>".$felow['count(id)']."</td>";
				}
				
				
					
				$td.="</tr>"; 
				
				$td.="<tr>";	
				$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Raise Investment"."</td>";	
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
                $td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Mentoring"."</td>";				
                $td.="<td>".$mentorDetails['actual']."</td>";
				$td.="<td>".$mentorDetails['target']."</td>";
                $td.="</tr>";
				
                 $td.="<tr>";			 
                 $td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Go-To-Market"."</td>";
                foreach($getmonthlymediaDetails as $row)
				{
                $td.="<td>".$row['count(RM.id)']."</td>";  
                $td.="<td>".$row['count(MD.media_id)']."</td>";  
				}
                 $td.="</tr>";
                $td.="<tr>";
                $td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Talent"."</td>";
                foreach($getmonthlyapplicantDetails as $row)
				{
                
                $td.="<td>".$row['count(RA.id)']."</td>";  
                $td.="<td>".$row['count(AA.id)']."</td>";  
				}
                 $td.="</tr>";
                $td.="<tr>";
                $td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;'>"."Networking"."</td>";
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
  	
					<div class="grid7">
						<h2>Mentor:</h2>
						<table width="100%" class="girdBOX" cellspacing="3" cellpadding="4">
						<thead>
						<tr>
						<th class="head headLARGE">Company</th>
						<th class="head headLARGE">Total Hours of Working</th>
						<th class="head headLARGE">Total Money</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if(php72_count($mentordetails!=0)){
						foreach($mentordetails as $row):
						?>
						<tr>
						<td style="background-color:#dce7cc;border:1px solid #B9CE98;"><?=$row['company']?></td>
						<td><?=$row['mentorhours']?></td>
						<td><?=$row['mentormoney']?></td>
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
				$(".monthYear").datepicker({
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					dateFormat: 'MM yy',
					
					onClose: function(dateText, inst) { 
						
						var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
						var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
												
						$(this).datepicker('setDate', new Date(year, month, 1));
					}
				});
				
			});
			$("#yearslideToggle").click(function () {
				$('#slidebox').slideToggle("slow");
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