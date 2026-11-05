<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <script type="text/javascript">
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
    </script>
    <style>
    .ui-datepicker-calendar {
        display: none;
    }
    </style>
</head>

<body>
    <?php $this->load->model('incubation_report/mincubation_report');?>
    <div align="right"><a href=javascript:history.go(-1) class="button">Back</a></div>
    <div id="slidebox">
        <form name="frmgetMonth" id="frmgetMonth" action="<?php site_url('reports/incubation_report/index')?>"
            method="post">
            <br>
            <table class="inline">

                <tr>
                    <td><label for="" style="font-weight:bold;">Select Month:<span class="req_field">*</span></label>
                        <?php $month = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "Novemeber", "December");
	      $date = (!isset($_POST['month']))?date('F'):$_POST['month'];
	      $year = (!isset($_POST['year']))?date('Y'):$_POST['year']; 
              ?>
                        <select name='month'>
                            <?php 
		foreach($month as $key=>$value)
		{?>
                            <option value="<?=$value?>" <?=($date == $value)?"selected":""?>><?=$value;?></option>
                            <?php } ?>
                        </select></td>
                    <td>
                        <label for="year" style="font-weight:bold;">Select Year:<span class="req_field">*</span></label>
                        <select name="year">
                            <option value="<?=date('Y')-3;?>" <?=($year == date('Y')-3)?"selected":""?>>
                                <?=date('Y')-3;?></option>
                            <option value="<?=date('Y')-2;?>" <?=($year == date('Y')-2)?"selected":""?>>
                                <?=date('Y')-2;?></option>
                            <option value="<?=date('Y')-1;?>" <?=($year == date('Y')-1)?"selected":""?>>
                                <?=date('Y')-1;?></option>
                            <option value="<?=date('Y');?>" <?=($year == date('Y'))?"selected":""?>><?=date('Y');?>
                            </option>
                            <option value="<?=date('Y')+1;?>" <?=($year == date('Y')+1)?"selected":""?>>
                                <?=date('Y')+1;?></option>
                            <option value="<?=date('Y')+2;?>" <?=($year == date('Y')+2)?"selected":""?>>
                                <?=date('Y')+2;?></option>
                            <option value="<?=date('Y')+3;?>" <?=($year == date('Y')+3)?"selected":""?>>
                                <?=date('Y')+3;?></option>
                        </select>
                    </td>
                </tr>


            </table>
            <div class="buttons1" style="margin-left:350px;margin-top:-2px;">
                <button type="submit" class="button" value="Search" name="txtSubmit">View</button>
                <button type="reset" class="button white" value="Search" name="txtreset">Reset</button>
            </div>

        </form>
    </div><br />
    <div style="height: 600px;overflow:scroll">
        <table class="gtable sorttable">
            <thead>
                <tr>

                    <th width="100">Goal</th>
                    <th width="100">Milestone</th>
                    <th width="300">Target</th>
                    <th width="200">Achieved</th>
                    <th width="100">Budget</th>
                    <th widt="100">Line Item</th>
                    <th width="200">Fund Utilized</th>
                    <th width="300">Next Target</th>
                </tr>
            </thead>
            <tbody>
                <?php if(php72_count($monthreport))
	{
		foreach($monthreport as $row):
	?>
                <tr>

                    <td align="left" valign="middle"><?=$row['goal']?></td>
                    <td align="left" valign="middle"><?=$row['milestone']?></td>
                    <td align="left" valign="middle"><?=$row['target']?></td>
                    <td align="left" valign="middle"><?=$row['achieved']?></td>
                    <td align="left" valign="middle"><?=$row['budget']?></td>
                    <td align="left" valign="middle"><?=$this->mincubation_report->getlineitemname($row['lineitem'])?>
                    </td>
                    <td align="left" valign="middle"><?=formatnumber($row['fund_utilized'])?></td>
                    <td align="left" valign="middle"><?=$row['next_target']?></td>
                </tr>
                <?php 
	endforeach;
	}?>
            </tbody>
        </table>
    </div>
</body>

</html>