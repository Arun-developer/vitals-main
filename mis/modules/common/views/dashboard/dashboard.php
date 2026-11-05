<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function() {
	function details(fn) {
		return function() {
			var r = $(this).closest("tbody").find("tr.detailsRow")[fn]();
			$("tr.detailsRow").not(r).hide();
		};
	};
	$(".detailsRow").hide();
	$detailsButtons = $(".detailsButton").click(details('toggle'));
	$detailsButtons.closest("tr").find("input").click(details('show'));
});
</script>
</head>
    <div id="show">
<body>
   <div>
   <!--main body-->
    <div class="main_report">
     <div class="main_report1">
     <div class="main_down_report">
       <div class="main_down_Content">
       <div class="main_Content_Inner">

       <!--Right-->
       <div class="main_Content_Inner_RHT">
        <div class="main_rht_full ">
        <h1>Dashboard </h1>
         <div class="main_rht_full2">
         <!--1-->
		  <div class="chart_box1  chart_box1_gap"">
         <h2>Seed Funding</h2>
         <div class="chart_box1_inner">
                <div id="seedFundingChart" align="center"></div>
                <div class="chart_inner_text"></div>
         </div>
         </div>

              <div class="chart_box1 chart_box1_gap">
         <h2>Exited Incubatees</h2>
         <div class="chart_box1_inner">
          <div id="exitDetailsID" > </div>
         <div class="chart_inner_text"></div>
         </div>
         </div>
                  <!--3-->
				  <br/>
                  <div class="table_section ">
                        <?php
$td = '<table width="100%" style="cellspacing:3px; cellpadding:4px;" id="mytable" class="gtable"  >';
$td .= '<th  style="background:#4D4D4B;padding:5px;color:#fff;">Service Offerings</th>';

$td.="<tr>";
$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Seed Funding"."</span></td>";
$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Fund Approved(in Rs.)"."</span></td>";
$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Fund Disbursed(in Rs.)"."</span></td>";
$td.="<td style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Fund Utilized(in Rs.)"."</span></td>";
$td.="</tr>";
foreach($allfunddisbursed as $media) {
	$td.="<tr class='detailsRow'>";
	$td.="<td><a href='".site_url('incubator_metrics/wglobal_report/index/'.$media['id'].'/4/')."'>".$media['name_of_enterprise']."</a></td>";
	$td.="<td>".$media['amount']."</td>";
	$td.="<td>".$media['approved_amount']."</td>";
	$td.="<td>".$media['fund_utilized']."</td>";
	$td.="</tr>";
}

$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Board Formation"."</span></td>";
$td.="</tr>";
//show($boardDetails);
foreach($boardDetails as $board) {

	$td.="<tr class='detailsRow'>";
	$td.="<td><a href='".site_url('incubator_metrics/wglobal_report/index/2/')."'>".$board['name_of_enterprise']."</a></td>";
	$td.="<td>".$board['total']."</td>";
	$td.="<td>".$board['accept']."</td>";
	$td.="<td>".$board['reject']."</td>";
	$td.="</tr>";
}

$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Fellow	"."</span></td>";
$td.="</tr>";
$td.="<tr>";
foreach($felowDetails as $felow) {

	$td.="<tr class='detailsRow'>";
	$td.="<td><a href='".base_url()."index.php/incubator_metrics/wglobal_report/index/314/4'>".$felow['name_of_enterprise']."</a></td>";
	$td.="<td>".$felow['applicant_name']."</td>";
	if($felow['status'] == '1'){
		$td.="<td>Accepted</td>";	
	}
	else
	{
		$td."<td>Rejected</td>";
	}
	$td.="<td></td>";
	$td.="</tr>";
}
$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Raise Investment"."</span></td>";
$td.="</tr>";
foreach($investerDetails as $invester) {

	$td.="<tr class='detailsRow'>";
	$td.="<td><a href='".base_url()."index.php/incubator_metrics/wglobal_report/index/314/4'>".$invester['name_of_enterprise']."</a></td>";
	$td.="<td>".$invester['first_name']."</td>";
	$td.="<td>".$invester['amount_approved']."</td>";
	if($invester['status'] == '1')
	{
		$td.="<td>Approved</td>";	
	}
	else
	{
		$td.="<td>Rejected</td>";
	}
	$td.="</tr>";
}
$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;font-weight:bold;'><span class='detailsButton'>"."Mentor "."</span></td>";
$td.="</tr>";
$td.="<tr>";
foreach($mentordetails as $applicant) {

	$td.="<tr class='detailsRow'>";
	$td.="<td><a href='".base_url()."index.php/incubator_metrics/wglobal_report/index/314/4'>".$applicant['name_of_enterprise']."</a></td>";
	$td.="<td>".$applicant['company']."</td>";
	$td.="<td>".$applicant['money']."</td>";
	$td.="<td>".$applicant['hours']."</td>";
	$td.="</tr>";
}
$td .= '</table>';
echo $td;

?>


                  </div>
         <!--end1-->
                           <!--4-->
         <div></div>
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
        .main_Content_Inner_RHT {

                width:100% !important;
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
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSColumn3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/seedfunding.xml");
		   chart.render("seedFundingChart");
</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSColumn3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/salesreport.xml");
		   chart.render("repaymentChart");
		</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/Pareto3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/servicepie.xml");
		   chart.render("mentorID");
		</script>
<script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSColumn3D.swf", "ChartId", "385", "350", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/exitdetails.xml");
		   chart.render("exitDetailsID");
		</script>