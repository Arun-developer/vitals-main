<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <script>
    $(document).ready(function() {
        $(function() {
            $(".monthYear").datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',

                onClose: function(dateText, inst) {

                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected")
                .val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });

        });
        $("#yearslideToggle").click(function() {
            $('#slidebox').slideToggle("slow");
        });
    });

    function monthchange(val) {
        var mystring = val;
        var mysplit = mystring.split("~");
        var datas = $.ajax({
            type: "POST",
            url: "<?php echo site_url('reports/progress_report/usersearch');?>" + "/" + mysplit[1],
            data: {
                'users': mysplit[0],
                'isajax': true
            },
            success: function(datas) {
                $('#show').html(datas);
            }
        });
    }
    </script>

</head>

<body>
    <div id="show" name="show">
        <h1><?=$cpagetitle.'-'.$name_of_enterprise?></h1>
        <div align="right"><a href=javascript:history.go(-1) class="button">Back</a>
            <input type="button" class="button" id="yearslideToggle" value="Show Filter" style="width:100px;"></div>
        <div id="slidebox" style="display:none;">
            <form name="frmgetMonth" id="frmgetMonth"
                action="<?php site_url('reports/progress_report/activityreport/'.$innovation)?>" method="post">
                <br>
                <table cellpadding="4" cellspacing="7" class="inline" width="50%">

                    <tr>
                        <td> <label for="" style="font-weight:bold;">From Month <span class="req_field">*</span></label>
                        </td>
                        <td><input type="text" name="getMonth[fromMonth]" id="fromMonth" value="" size="20"
                                class="monthYear required" /></td>
                    </tr>
                    <tr style="margin-top:8px;">

                        <td> <label for="" style="font-weight:bold;">To Month<span class="req_field">*</span></label>
                        </td>
                        <td> <input type="text" name="getMonth[toMonth]" id="toMonth" value="" size="20"
                                class="monthYear required" /></td>
                    </tr>

                </table>
                <div class="buttons1" style="margin-left:155px;margin-top:10px;">
                    <button type="submit" class="button" value="Search" name="txtSubmit"
                        onclick="return validateFrom();">Search</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="button white" value="Search" name="txtSubmit">Reset</button>
                </div>

            </form>
        </div>
        </br>
        </br>
        <ul class="tabs">
            <li><a href="<?=site_url('reports/progress_report/form/'.$innovation)?>">IRIS Metrics Value</a></li>
            <li class="selected"><a
                    href="<?=site_url('reports/progress_report/activityreport/'.$innovation)?>">Subjective</a></li>
        </ul>
        <div style="margin:10px;margin-left:126px;">
            <table>
                <tr>
                    <td><label style="font-weight:bold;">Select User : &nbsp;&nbsp;</label></td>
                    <td>
                        <select name="users" onchange="monthchange(this.value);">
                            <option value="">--Select--</option>
                            <?php foreach($userslist as $row):?>
                            <option value="<?=$row['emp_number'].'~'.$innovation?>"><?=$row['emp_name']?>
                            </option><?php endforeach;?>
                        </select>
                    </td>
                    <td><label style="font-weight:bold;">Select Year : &nbsp;&nbsp;</label></td>
                    <td>
                        <form name="yearform"
                            action="<?=site_url('reports/progress_report/exportactivity/'.$innovation)?>" method="post">
                            <select name="year">
                                <option value=" ">--Select-- </option>
                                <option value="<?=date('Y')-3;?>"><?=date('Y')-3;?></option>
                                <option value="<?=date('Y')-2;?>"><?=date('Y')-2;?></option>
                                <option value="<?=date('Y')-1;?>"><?=date('Y')-1;?></option>
                                <option value="<?=date('Y');?>"><?=date('Y');?></option>
                                <option value="<?=date('Y')+1;?>"><?=date('Y')+1;?></option>
                                <option value="<?=date('Y')+2;?>"><?=date('Y')+2;?></option>
                                <option value="<?=date('Y')+3;?>"><?=date('Y')+3;?></option>
                            </select>
                    <td><input type="submit" name="txtSubmit" class="button" value="export"></td>
                    </form>
                    </td>
                </tr>
            </table>
        </div>
        <?php $frequency = array(1=>'weekly',2=>'monthly',3=>'quarterly',4=>'yearly');?>
        <div>
            <table style="overflow-y:auto; margin-left:126px;">
                <tbody id="activitiesTable">
                    <?php  
		  $i=0;
		  $j=1;
	  if(php72_count($activityList))
	  {
		 $key1 = 0;  
		 $na="";
		  foreach($activityList as $row)
		  {
		   $na_new = $row['mastertype'];
	       if($na_new != $na)
	       {
		    $na = $na_new;
		    $key1 = 0;
			?>
                    <tr>
                        <td colspan="3">
                            <h2><?php echo $row['mastertype'];?></h2>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr width="50%">
                        <td align="left" valign="middle" style=" border:1px solid #cccccc; background:#B9CE98;"
                            colspan="2"><?=$activityList[$i]['label']?></td>
                        <?php $months =  date("M", mktime(0, 0, 0,$row['start_date'] , 1, 2000));?>
                        <td align="left" valign="middle" width="80px"
                            style="border-top:1px solid #cccccc; background:#B9CE98;">
                            <?=$months?>-<?=$activityList[$i]['end_date']?></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle">
                            <p><b>Villgro Response</b></p>
                        </td>
                        <td style="padding-left:150px">
                            <div><?=$row['villgro_answer'];?></div> &nbsp; <i
                                style="margin-left:534px;font-size:12px;font-weight:bold;color:grey;">--
                                <?=$row['villgro_answerby'];?></i>
                            <div><?=$row['manager_answer'];?></div> &nbsp; <i
                                style="margin-left:534px;font-size:12px;font-weight:bold;color:grey;">--
                                <?=$row['manager_answerby'];?></i>
                        </td>
                        <td align="left" style="border-bottom:1px solid #CCCCCC;" rowspan="2" valign="middle"><a
                                href="<?=base_url().'uploads/'.$row['document'][0]?>"><?=$row['document'][0];?></a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" style="border-bottom:1px solid #CCCCCC;">
                            <p><b>Incubatee Response</b></p>
                        </td>
                        <td style="border-bottom:1px solid #CCCCCC;padding-left:150px">
                            <div><?=$row['answer'];?></div> - &nbsp; <i
                                style="font-size:11px;"><?=$row['answerby'];?></i>
                        </td>
                    </tr>

                    <tr>
                        <?php if($this->session->userdata('user_type') == 'ceo'){
						?>
                        <td align="left" valign="middle"><a
                                href="<?=site_url('incubationprogress/doneactivity/'.$row['field'].'/'.$innovation.'/'.$row['start_date'])?>"
                                class="button">Accept</a></td>
                        <td align="left" valign="middle"><a href="#" class="button">Reject</a></td>
                        <?php } ?>
                    </tr>
                    <?php $i++;$j++;
		  }		
			?>
                    <?php
	  }
	else
	{ ?>
                    <tr>
                        <td colspan='7' align='center' style="color:red;">No Matching Records found!</td>
                    </tr>
                    <?php
	} ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>