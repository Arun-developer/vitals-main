<script type="text/javascript">
    $(document).ready(function(){
    $("#frmQuarter").validate();
  });

</script>
<h1><?php echo $cpagetitle; ?></h1>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/monthly.css" /> 
<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.js"></script>
<div class="clear"></div>
<a href="javascript:history.go(-1)" class="button"  style="margin-left:1150px;"> Back</a></br><br>
<div class="box1">
<div class="boxLFT">
<div class="sub">
<h1 style="background-color:#B9CE98;color:black;padding-bottom:5px;font-weight:bold;"><?=$cpagetitle?></h1>
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
<?php } ?>
</div>


<!----Tab Start -->
<ul class="menu">
<?php foreach($reportDetails as $tabKey1=> $value) {?>
        <li >
        <a class="<?= ($tabKey1 == $tabKey)?'sel':''?>" href="<?php echo site_url('incubator_metrics/wglobal_report/index/'.$urlcode.'/'.$tabKey1);?>" ><?php echo $value; ?></a>
        </li>
		<?php }?>
		      
 </ul>
<!--Tab Finish-->
</br>
</br>
  
 
<form name="frmgetQuarter" id="frmQuarter" action="<?php site_url('incubator_metrics/wglobal_report/quarterlyReport/')?>" method="post" >

<div id="slideTogglebox" style="display:none;"><br>
<table cellspacing="4" cellpadding="4" border="0" width="50%" >

        <tr>
            <td style="font-weight:bold;color:#454545;">Select Period :</td>
            <td>
            <select name="list[quaterDetails]" class="required" id="frmQuarter">
                            <option value="">Select</option>
                            <?php foreach($quaterlyDetails as $key=>$value){ ?>
                            <option value="<?=$key?>" ><?=$value?></option>
                            <?php }?>
            </select>
            </td>
            <td style="font-weight:bold;color:#454545;">Year :</td>
            <td>
            <select name="list[yearDetails]" style="width:110px;" class="required" id="toQUarter">
                                <option value="">Select</option>
                                <?php $flag='0';?>
                                <?php for($i=2000; $i<=2050; $i++) { 
                                        $flag++;
                        ?> 
                                <option value="<?=$i?>" ><?=$i?></option>		
                        <?php } ?>
             </select>
           </td>
        </tr>
         <tr>
        
        <td> <label><span style="color:red" id="error_msg"></span></label></td>
        <td></td>
    </tr>
	

</table>
	<div class="buttons1" style="margin-left:115px;margin-top:17px;" >
	   <button type="submit" class="button" value="Search" name="txtSubmit" >Search</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <button type="reset" class="button white" value="Search" name="txtSubmit">Reset</button>
	</div> 
	
</div>
    

</form>

<br>
<br>
<div class="mainBODY">
 <div class="maibBODYlft">
 <!--grid 1-->
 <div class="grid1" style="width:580px;">
 <div style="width:607px;min-height:110px; height:10%; margin-bottom:5px;border: 2px solid #ECECEC;float:left;">
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
  <!--End grid 1-->
 <!--grid 2-->
  <div class="grid2">
  
  <div class="boxNotice " style="width:580px;">
  <?php 	

  
			    $data = array();
				$td = '<table class="girdBOX" style="width:588px;" cellspacing="3" cellpadding="4">';
				$td .= '<th class="head headLARGE grid5Hei">Exit Criteria</th>';
				$td .= '<th class="head headLARGE grid5Hei">Year</th>'; 
				$td .= '<th class="head headLARGE grid5Hei">Total In Numbers</th>'; 
				
				$td .= '<tr>';
				$td .= '<td>'."Board Meeting".'</td>';
				if(!empty($exitDetails)) {
				if(php72_count($exitDetails) == '4') { 
					$td .= '<td>'.$exitDetails['0']['exitDate'].'</td>';
					$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">'.$exitDetails.'</a></td>';
				} else {
					$td .= '<td>'.$exitDetails['0']['exitDate'].'</td>';
					$td .= '<td style="color:red;font-weight:bold;">'. php72_count($exitDetails) .'</td>';
				}
				}
				$td .= '</tr>';
				$td .= '<tr>';
				$td .= '<td>'."Professional Board".'</td>';
				if(php72_count($exitboardDetails) >= '1') { 
					$td .= '<td>2012</td>';
					$td .= '<td style="color:green;font-weight:bold;"><a href="'.site_url('repayment/index/'.$urlcode).'">'.$exitboardDetails['0']['count(board_id)'].'(inducted)</a></td>';
				} else {
					$td .= '<td>'.$exitboardDetails['0']['exitDate'].'</td>';
					$td .= '<td style="color:red;font-weight:bold;">'.php72_count($exitboardDetails).'</td>';
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
  
  </div>
  </div>
   <!--End grid 2-->
 <!--grid 3-->

 <!--End grid 3-->
<!--  --> 
 
 </div>
 <!--End Left -->
 <div class="maibBODYRHT">
 
<!-- Grid 4--> 
 <div class="grid4 ">
 <div class="boxNotice fr" style="width:583px;">
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
 
 <!-- End Grid 4--> 
<!--Grid 5-->
  <div class="grid5">
   <div class="boxNotice" style="width:580px;">
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
 
	
	
	
<!--End Grid 5-->

<!--Grid 6-->
  <div class="grid6">
  
<div class="boxNotice fr" style="width:583px;">
 <?php
	$header = NULL;
                $td = '<table id="table1" width="100%" class="girdBOX" cellspacing="3" cellpadding="4">';
                $td .= '<th class="head headLARGE grid6Hei">  </th>';
                $td .= '<th class="head headLARGE grid5Hei">Actual</th>';
                $td .= '<th class="head headLARGE grid5Hei">Target</th>';
                
                $td.="<tr>";
                $td.="<td style='font-weight:bold;'>"."Seed Funding"."</td>";
                foreach($getFundReqDetails as $fundReq) {  
	                $td.="<td>".$fundReq."</td>";  
                }
                foreach($getFundUtilizationDetails as $fund)
                {  
				 $td.="<td>".$fund['amount']."</td>"; 
                }
                $td.="</tr>";
                $td.="<tr>";				
                $td.="<td style='font-weight:bold;'>"."Mentoring"."</td>";				
                $td.="<td>".$mentorDetails['actual']."</td>";
				$td.="<td>".$mentorDetails['target']."</td>";
                $td.="</tr>";
                 
                 
                 $td.="<tr>";
                 $td.="<td style='font-weight:bold;'>"."Go-To-Market"."</td>";
                foreach($getmediaDetails as $row)
				{
                $td.="<td>".$row['count(RM.id)']."</td>";  
                $td.="<td>".$row['count(MD.media_id)']."</td>";  
                }
                 $td.="</tr>";
                 
                $td.="<tr>";
                $td.="<td style='font-weight:bold;'>"."Talent"."</td>";
                foreach($getapplicantDetails as $row)
				{ 
                $td.="<td>".$row['count(RA.id)']."</td>";  
                $td.="<td>".$row['count(AA.id)']."</td>";  
				}
                 $td.="</tr>";
                $td.="<tr>";
                $td.="<td style='font-weight:bold;'>"."Networking"."</td>";
                $td.="<td>".$getPartnerDetails['actual']."</td>";  
                $td.="<td>".$getPartnerDetails['target']."</td>";  
                $td.="</tr>";
                
                $td .= '</table>';
                echo $td;
?>


</div>
 
 
 </div>
  </div>
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
#slideTogglebox{
		padding:8px;
		margin:16px;
		border:1px solid #808080;
		height:103px;
		color:white;
	}
	
.mainBODY{ width:100%;  height:100%; }
		.maibBODYlft, .maibBODYRHT{ width:49%; height:100%; min-height:400px; float:left; }
		.maibBODYRHT{  float:right;}
		.grid5{}
		.grid5 td, .grid4 td, .grid6 td, .grid7 td, .grid2 td{ padding:5px;}
		.grid5Hei{ height:25px;}
</style>

 <script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
 <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/ScrollLine2D.swf", "ChartId", "467", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/monthlyReport.xml");		   
		   chart.render("generalChart");
                  
		  $(document).ready(function() {
			  $("#slideToggle").click(function () {
			     $('slideTogglebox').show();				  
				  $('#slideTogglebox').slideToggle();
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