<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="<?=base_url();?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
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

    <script src="<?=base_url();?>source/template/js/json.htmTable.js" type="text/javascript"></script>
    <script src="<?=base_url();?>source/template/js/json.debug.js" type="text/javascript"></script>
</head>
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
       <!--header tab menu-->
          <div class="report_tabmenu">
          <!--left-->
          <div class="report_tabmenu_LFT"></div>

          <div class="report_tabmenu_RHT">
           <div class="report_tabmenu">
            <ul>
                <li><a href="<?=site_url('dashboard/dashboard/scouting_report')?>" >Scouting &amp; Screening</a></li>
            <li><a href="<?=site_url('dashboard/dashboard/incubation_report')?>" class="sel">Incubation</a></li>
            <li><a href="<?=site_url('dashboard/dashboard/progress_report')?>">Progress</a></li>
            </ul>
           </div>
         <div class="report_tabmenu2">
          <div class="report_tabmenu23">
          <ul id="navbar">
            <li><a href="<?=site_url('dashboard/dashboard/scoutingquality')?>">Quality </a></li>
            <li><a href="<?=site_url('dashboard/dashboard/incubation_report')?>">Quantity</a></li>
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
           <form name="myform" method="post" action="<?=site_url('dashboard/dashboard/incubationcompare')?>">
        <ul>
        <li><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
</table></li>
        <li><h1>Top Fives<span>Current Year 2012</span></h1> </li>

        </ul>

        <div class="menu_list2">
        <h2 class="msg_head">Source Wise Innovations</h2>
        <div class="msg_body">
        <ul>
            <?php foreach($incubation as $row):?>
        <li><span><input name="service[]" type="checkbox"  value="<?=$row['name_of_enterprise'];?>" /></span><?=$row['name_of_enterprise'];?></li>
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
            <?php $sector = array_pop($sector);for($i=0;$i<count($sector);$i++){?>
        <li><span><input name="sector[]" type="checkbox" value="<?=trim($sector[$i]);?>"/></span><?=$sector[$i];?></li>
        <?php };?>
        </ul>
        </div>
        </div>
        <div class="report_compare_butt"><a href="javascript:void(0)" onclick="document.myform.submit()">Compare</a></div>
       </div>
           </form>
       </div>
</div>

       <!--END LEFT-->

       <!--Right-->
       <div class="main_Content_Inner_RHT">
        <div class="main_rht_full ">
        <h1>Dashboard </h1>
        <div class="selectBAR">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
    <td width="30%" class="report_apply_butt"><a href="#">Apply</a></td>
  </tr>
</table>
        </div>
 <?php if((!empty($serviceselected)) AND (empty($employeeselected)) AND (empty($sectorselected))){ //print_r($sourcecompare);?>
<div class="table_section ">
<table width="100%" class="gtable" cellspacing="1" cellpadding="0">
      <tr >
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php
        foreach($service as $row):?>
        <td colspan="1" width="13%"><?=$row['title'];?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($serviceselected); for($i=0;$i<count($service);$i++){    ?>
                <td rowspan ="<?=count($selected)+1?>" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<count($selected);$k++){
                ?>
       <tr>
        <td  width="13%" class="table_down"><?=@$selected[$k];?></td>
        <?php  foreach($service as $row){?>

                <?php if(($row['title'] == $sourcecompare[$i]['title_'.$i]) && $sourcecompare[$i]['name_of_enterprise'] == $selected[$k])
                { ?>

        <td class="table_down"><?=$sourcecompare[$i]['total'.$i];?></td>
        <?php } else{?>
        <td class="table_down">0</td>
        <?php }
            }
        } ?>
      </tr>
            <?php } ?></tr>
          </table></div>
      <?php }  ?>
<?php if((empty($serviceselected)) AND (!empty($employeeselected)) AND (empty($sectorselected))){ //print_r($sourcecompare);?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="1" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php
		$this->load->model('dashboard/Mdashboard'); 
		
        foreach($service as $row):?>
        <td colspan="1" width="13%"><?=$row['title'];?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($employeeselected); 
		$selected = $this->Mdashboard->getemployeename($selected);
		 for($i=0;$i<count($service);$i++){    ?>
                <td rowspan ="<?=count($selected)+1?>" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<count($selected);$k++){
                ?>
       <tr>
        <td  width="13%" class="table_down"><?=$selected[$k]['emp_firstname'];?></td>
        <?php  foreach($service as $rw){ ?>

                <?php if(($sourcecompare[$i]['title_'.$i] == $rw['title']) && ($sourcecompare[$i]['emp_number'] == $selected[$k]))
                { ?>

        <td class="table_down"><?=$sourcecompare[$i]['total'.$i];?></td>
        <?php } else{?>
        <td class="table_down">0</td>
        <?php } $j++;
            }
        } ?>
      </tr>
            <?php } ?></tr>
          </table></td>
  </tr>
</table></div>
      <?php } ?>
    <?php
    if((empty($serviceselected)) AND (empty($employeeselected)) AND (!empty($sectorselected))){
       ?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="1" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php
        foreach($service as $row):?>
        <td colspan="1" width="13%"><?=$row['title'];?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php  $selected = array_pop($sectorselected); for($i=0;$i<count($service);$i++){    ?>
                <td rowspan ="<?=count($selected)+1?>" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<count($selected);$k++){
                ?>
       <tr>
        <td  width="13%" class="table_down"><?=$selected[$k];?></td>
        <?php for($j=0;$j<count($service);$j++) { ?>

                <?php if(($sourcecompare[$i]['title_'.$j] == $service[$j]['title']))
                { ?>
           <td class="table_down"><?=$sourcecompare[$i]['total'.$j];?></td>
        <?php } else{?>
        <td class="table_down">0</td>
        <?php }
            }
        } ?>
      </tr>
            <?php } ?></tr>
          </table></td>
  </tr>
</table></div>
      <?php } ?>


<?php if((!empty($serviceselected)) AND (!empty($employeeselected)) AND (empty($sectorselected))){?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr>
          <td class="table_down" width="14%"></td>
       <td align="left" colspan="8">
           <table style="width:100%">
               <tr>
                   <td class="table_down" >&nbsp;</td>
                   <td>
                       <table align="right"><tr><td class="table_down"></td>
                               <td>
                                   <table  align="right" style="width:100%">
                           <tr>
                               <td>&nbsp;</td>
                              <?php
                                foreach($stage as $key=>$value):?>
                                <td style="cellpadding:3%"><?=$value;?></td>
                                <?php endforeach;?>
                           </tr></table>
                               </td></tr><tr><td></td></tr>
                       </table>
                   </td>
               </tr>
           </table>
       </td>
      </tr>

        <?php $j=0; $selected = array_pop($employeeselected); $sselected = array_pop($serviceselected); for($i=0;$i<count($stage);$i++){    ?>
               <tr><td width="14%" class="table_down"><?=$yearly[$i];?></td><td  colspan="8"><table style="width:100%">
              <?php  for($k=0;$k<count($selected);$k++){
                ?>

       <tr>
       <td class="table_down"><?=$sourcecompare[$k]['emp_firstname'];?></td>
       <td>
           <table  style="width:100%">
       <?php for($l=0;$l<count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]==$value) && ($sourcecompare[$i]['emp_number'] == @$selected[$k]) && ($sourcecompare[$i]['master_name'] == @$sselected[$k]))
       { ?>
       <td style="width:12%" class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td  style="width:12%" class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td></tr>
         <?php } ?>
      </table></td></tr>
            <?php } ?>

         </td></table>
  </tr>
</table></div>
      <?php } ?>
<?php if((!empty($serviceselected)) && (empty($employeeselected)) && (!empty($sectorselected))){ echo "ji";?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr>
          <td class="table_down" width="14%"></td>
       <td align="left" colspan="8">
           <table style="width:100%">
               <tr>
                   <td class="table_down" >&nbsp;</td>
                   <td>
                       <table align="right"><tr><td class="table_down"></td>
                               <td>
                                   <table  align="right" style="width:100%">
                           <tr>
                               <td>&nbsp;</td>
                              <?php
                                foreach($stage as $key=>$value):?>
                                <td style="cellpadding:3%"><?=$value;?></td>
                                <?php endforeach;?>
                           </tr></table>
                               </td></tr><tr><td></td></tr>
                       </table>
                   </td>
               </tr>
           </table>
       </td>
      </tr>

        <?php $j=0; $selected = array_pop($sectorselected); $sselected = array_pop($serviceselected); for($i=0;$i<count($stage);$i++){    ?>
               <tr>  <td width="14%" class="table_down"><?=$yearly[$i];?></td><td  colspan="8"><table style="width:100%">
              <?php  for($k=0;$k<count($selected);$k++){
                ?>

       <tr>
       <td class="table_down"><?=$selected[$k];?></td>
       <td>
           <table  style="width:100%">
       <?php for($l=0;$l<count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]==$value) && ($sourcecompare[$i]['answer'] == @$selected[$k]) && ($sourcecompare[$i]['master_name'] == @$sselected[$k]))
       { ?>
       <td style="width:12%" class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td  style="width:12%" class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td></tr>
         <?php } ?>
      </table></td></tr>
            <?php } ?>

         </td></table>
  </tr>
</table></div>
      <?php } ?>
<?php if((empty($serviceselected)) && (!empty($employeeselected)) && (!empty($sectorselected))){ echo "ji";?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr style="background:#4D4D4B;color:#fff;">
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php 
        foreach($stage as $key=>$value):?>
        <td><?=$value;?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($employeeselected); $sselected = array_pop($serviceselected); for($i=0;$i<count($stage);$i++){    ?>
                <td rowspan ="3" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<count($selected);$k++){
                ?>
       <tr>
       <td class="table_down"><?=$sourcecompare[$k]['emp_firstname'];?></td>
       <td colspan="7">
           <table>
       <?php for($l=0;$l<count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]==$value) && ($sourcecompare[$i]['emp_number'] == @$selected[$k]) && ($sourcecompare[$i]['master_name'] == @$sselected[$k]))
       { ?>
       <td class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td  class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td>
         <?php } ?>
      </tr>
            <?php } ?></tr>

          </table></td>
  </tr>
</table>
    </div>
      <?php } ?>
    <?php if((!empty($serviceselected)) && (! empty($employeeselected)) && (!empty($sectorselected))){ echo "ji";?>
<div class="table_section ">

          <table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr >
    <td class=""><table width="100%" class="gtable" cellspacing="0" cellpadding="0">
      <tr>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
       <td  >&nbsp;</td>
        <?php 
        foreach($stage as $key=>$value):?>
        <td><?=$value;?></td>
        <?php endforeach;?>
      </tr>
            <tr>
        <?php $j=0; $selected = array_pop($employeeselected); $sselected = array_pop($serviceselected); for($i=0;$i<count($stage);$i++){    ?>
                <td rowspan ="3" width="14%" class="table_down"><?=$yearly[$i];?></td>
              <?php  for($k=0;$k<count($selected);$k++){
                ?>
       <tr>
       <td class="table_down"><?=$sourcecompare[$k]['emp_firstname'];?></td>
       <td colspan="7">
           <table>
       <?php for($l=0;$l<count($sselected);$l++) { ?>
       <tr><td><?=@$sselected[$l];?></td>
       <?php foreach($stage as $key=>$value){?>
       <?php if(($stage[$sourcecompare[$i]['stage']]==$value) && ($sourcecompare[$i]['emp_number'] == @$selected[$k]) && ($sourcecompare[$i]['master_name'] == @$sselected[$k]))
       { ?>
       <td class="table_down"><?=$sourcecompare[$i]['VALUE'];?></td>
        <?php } else{?>
        <td  class="table_down">0</td>
        <?php }
            }?></tr><?php } ?></table></td>
         <?php } ?>
      </tr>
            <?php } ?></tr>

          </table></td>
  </tr>
</table>
    </div>
      <?php } ?>



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
</html>
<script type="text/javascript">
   function sourceselected(val)
   {
       var source = val;
       var datas = $.ajax({
				type: "POST",
				url: "<?php echo site_url('dashboard/dashboard/sourcesearchireport');?>",
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
				url: "<?php echo site_url('dashboard/dashboard/employeesearchireport');?>",
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
						url:"<?php echo site_url('dashboard/dashboard/sectorsearchireport');?>",
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

                /* call the php that has the php array which is json_encoded */

    </script>