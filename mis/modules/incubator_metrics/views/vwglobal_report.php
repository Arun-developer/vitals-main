<?php $this->load->model('mwglobal_report'); ?>
<script type="text/javascript">
    $(document).ready(function(){
    $("#frmgetWeek").validate();
  });
</script>
<script type="text/javascript">
$(document).ready( function() {
    var startDate;
    var endDate;	
	var selectCurrentWeek = function() {
		 setTimeout(function(){
            var s = $('#ui-datepicker-div').find('.ui-datepicker-current-day a').addClass('ui-state-active');
		}, 1);
	}	
	$('.ajxWDatePicker').find('.ui-datepicker-current-day a').addClass('ui-state-active');        
	$(".ajxDate").datepicker({
		showButtonPanel: true,
        showWeek: true,
		onClose: function(dateText, inst) { 
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();                        
        },         
          onSelect: function(dateText, inst) {
				if($(this).hasClass('ajxWDatePicker'))
				{
					var date = $(this).datepicker('getDate');
					startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
					endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
					var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
					var sDate = $.datepicker.formatDate( dateFormat, startDate, inst.settings);
					var eDate = $.datepicker.formatDate(dateFormat, endDate, inst.settings);
					$('#fromDatepicker').val(sDate);
                    $('#toDatepicker').val(eDate);
				}
			},
			 beforeShow: function(){
				if($(this).hasClass('ajxWDatePicker'))
				 	selectCurrentWeek();
			 },
			 beforeShowDay: function(date) {
				var cssClass = '';
				if(date >= startDate && date <= endDate){
					cssClass = 'ui-datepicker-current-day';
				}
				return [true, cssClass];
	         },
		    onChangeMonthYear: function(year, month, inst) {
        	    selectCurrentWeek();
	        }
	});
		
		$('#ui-datepicker-div .ui-datepicker-calendar tr').live('mousemove', function() {
                    $(this).find('td a').addClass('ui-state-hover');
		});
		$('#ui-datepicker-div .ui-datepicker-calendar tr').live('mouseleave', function() {
                    $(this).find('td a').removeClass('ui-state-hover');
		});
  });



</script>
<h1><?php echo $cpagetitle; ?></h1>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/dashboard.css" /> 
<div class="clear"></div>
<h2 style="color:#2984c3;" align="center"> Weekly Global Report</h2>
<div class="assignTask" align="right">
<a href="<?=site_url('incubator_metrics/wglobal_report/configure/'.$urlcode.'/'.$tabKey);?>" class="button fancybox">Configure</a> 
<a href="<?php echo site_url('incubator_metrics/wglobal_report/taskList/'.$urlcode.'/')?>" class="button">Assign Task</a> 
 <button type="button" class="button" id="weekslideToggle" > Show Filter </button>
</div>

<!----Tab Start -->
<ul class="tabs">
<?php foreach($reportDetails as $tabKey1=> $value) {?>
        <li class="<?= ($tabKey1 == $tabKey)?'selected':''?>">
        <a href="<?php echo site_url('incubator_metrics/wglobal_report/index/'.$urlcode.'/'.$tabKey1);?>" ><?php echo $value;?></a>
        </li>
		<?php }?>
		      
 </ul>
<!--Tab Finish-->
</br>

<form name="frmgetWeek" id="frmgetWeek" action="<?php site_url('incubator_metrics/wglobal_report/weekReport/')?>" method="post" >
<div id="slidebox"   style="display:none;">
<table cellspacing="4" cellpadding="4" border="0" width="50%" >

        <tr>
            <td> <label for="" style="font-weight:bold;">From Week <span class="req_field">*</span></label></td>
            <td>  <input type="text" name="getWeek[fromWeek]" value="" size="20" id="fromDatepicker" class="ajxWDatePicker ajxDate required" /></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <br/>
        <tr style="margin-top:18px;">
            <td> <label for="" style="font-weight:bold;">To Week<span class="req_field">*</span></label></td>
            <td> <input type="text" name="getWeek[toWeek]" size="20"  id="toDatepicker" class="uiDatePicker required"  /></td>
        </tr>
</table>
	<div class="buttons1" style="margin-left:155px;margin-top:10px;" >
	   <button type="submit" class="button" value="Search" name="txtSubmit" >Search</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <button type="submit" class="button white" value="Search" name="txtSubmit">Reset</button>
	</div> 
    </div>
</form>

<br>
<div style="margin-left:770px;margin-top:10px;">


 </div>
 
 <br>
 
<div style="overflow:scroll;">
                     <?php
					 					 
                        $header = NULL;
						$data = array();
                        $td = '<table id="table1" width="auto" class="gtable" cellspacing="3" cellpadding="4">';
                        $td .= '<th class="tablehead">Metrices</th>';
    					$tmp = array ();
						
	                    if(php72_cmp($weekDetails) > 0 ) {
                        foreach($weekDetails as $key=> $row)
                        {  
							$row['progress_date'] = $row['start_date']."  ".$row['end_date'];
                             if (!in_array($row['progress_date'],$tmp)) 
							 {
								    array_push($tmp,$row['progress_date']);  
                                    $header = $row['progress_date'];
                                    $headerArray[] = $header;
                                    $td .= '<th class="tablehead">'.$header.'</th>';
                            }
                            $data[$row['label']][$row['progress_date']] = $row['answer'];
                        }
                        foreach($data as $key => $value)
                        {
                            $td .= '<tr>';
                            $td .= '<td>'.$key.'</td>';
                                for($i=0;$i<php72_count($headerArray);$i++)
                                {
                                          if(isset($value[$headerArray[$i]]))
                                         {
                                           
										  $res =  $this->mwglobal_report->green($urlcode,$key);
										  if($res['answer'] == $value[$headerArray[$i]] && $res['label'] == $key)
											  {
											   $td .= '<td style="color:green"><a href="'.site_url('repayment/index/'.$urlcode).'">'.$value[$headerArray[$i]].'</a></td>';
											  }
										  else
											  {
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
                        } else { echo "No Records Found!!";}
		   ?>
 
</div>



<div class="boxNotice fr" style="width:380px;">
 <?php
    
     $header = NULL;
                $td = '<table id="table1" width="100%" class="gtable" cellspacing="3" cellpadding="4">';
                $td .= '<th class="tablehead">  </th>';
                $td .= '<th class="tablehead">Actual</th>';
                $td .= '<th class="tablehead">Target</th>';
                
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
                $td.="<td>".$weekmentorDetails['actual']."</td>";
				$td.="<td>".$weekmentorDetails['target']."</td>";
                $td.="</tr>";
                 
                 
                 $td.="<tr>";
                 $td.="<td style='font-weight:bold;'>"."Go-To-Market"."</td>";
                foreach($getweeklymediaDetails as $row)
				{
                $td.="<td>".$row['count(RM.id)']."</td>";  
                $td.="<td>".$row['count(MD.media_id)']."</td>";  
				}
                 $td.="</tr>";
				
                $td.="<tr>";
                $td.="<td style='font-weight:bold;'>"."Talent"."</td>";
                foreach($getweeklyapplicantDetails as $row)
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


<div class="boxNotice">
    <h2>Revenue & Profit (L):&nbsp;&nbsp;<a href="javascript:void(0);" onclick="$('.sourceReport').toggle();"></a>&nbsp;:</h2>
  <div id="generalChart" align="center"> 
        Employees: </div>
    <?php if(isset($options))
    {
    if($options['showtype'] == 'barchart'){ ?>

    
<div class="boxNotice fr">
 <h2>Yearly Chart Report:</h2>
  <div id="generalbarChart" align="center"> 
       </div>
 </div>
<?php } }?>
		</div>
 <div class="detail sourceReport"  style="display:none; width:100%; overflow:scroll;">
	<table class="gtable detailtable">
	<thead>
		<tr>
			<th>Source Type</th>
            <th>New</th>
			<th>%</th>
            <th>Entry</th>
            <th>Convertion %</th>
             <th>Lead </th>
            <th>Convertion %</th>
		</tr>
		
	</thead>
	</table>
 </div>
  
  </div>

  <div class="boxNotice fr" style="width:380px;" >

			<?php
			$header = NULL;
			$td = '<table id="table1" width="100%" class="gtable" cellspacing="3" cellpadding="4">';
			$td .= '<th class="tablehead">Account Manager</th>';
			$td .= '<th class="tablehead">Actual</th>';
			$td .= '<th class="tablehead">Target</th>';
			foreach($accManager as $row)
			{ 
			$td.="<tr>";
			$td.="<td>".$row['label']."</td>";  
			$td.="<td>".$row['actual']."</td>";  
			$td.="<td>".date('M',mktime(0,0,0,$row['month'])).' '.$row['year']."</td>";
			$td.="<td></td>";
			$td.="</tr>";
			}
			$td .= '</table>';
			echo $td;
			?>


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
#slidebox	{
			padding:8px;
			margin:16px;
			border:1px solid #808080;
			height:123px;
		
		
		}
</style>

 <script language="JavaScript" src="<?=base_url()?>source/charts/FusionCharts.js"></script>
 <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/ScrollLine2D.swf", "ChartId", "467", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/weeklyReport.xml");		   
		   chart.render("generalChart");
		   
		   $(function() {
		            
				$( ".uiDatePicker" ).datepicker({
					showWeek: true,
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					firstDay: 1,
					onSelect: function(selDate, inst){
						var splitDate = selDate.split('/');
						var monthFix = splitDate[1]-1;
						// Fix month before sending to date function inorder to get proper date
						alert(getWeek(splitDate[2], monthFix,splitDate[0]));
					}
					
				});
							
				
				function getWeek(year,month,day) {
				
					var when = new Date(year,month,day);
					var newYear = new Date(year,0,1);
					var offset = 7 + 1 - newYear.getDay();
					if (offset == 8) offset = 1;
					var daynum = ((Date.UTC(year,when.getMonth(),when.getDate(),0,0,0) - Date.UTC(year,0,1,0,0,0)) /1000/60/60/24) + 1;
					var weeknum = Math.floor((daynum-offset+7)/7);
					if (weeknum == 0) {
						year--;
						var prevNewYear = new Date(year,0,1);
						var prevOffset = 7 + 1 - prevNewYear.getDay();
						if (prevOffset == 2 || prevOffset == 8) weeknum = 53; else weeknum = 52;
					}
					return weeknum;
				}
				
				$("#weekslideToggle").click(function () {
				  $('#slidebox').slideToggle("slow");
				
				});

				$( ".uiDatePicker" ).datepicker({
					showWeek: true,
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					firstDay: 1
				});
				$(".uiDatePicker").datepicker({ beforeShowDay: $.datepicker.noWeekends });
				
				
			});
		
 </script>
 <script type="text/javascript">
		   var chart = new FusionCharts("<?=base_url()?>source/charts/MSBar3D.swf", "ChartId", "400", "300", "0", "0");
		   chart.setXMLUrl("<?=base_url()?>source/charts/data/weeklybarchart.xml");		   
		   chart.render("generalbarChart");
		</script>