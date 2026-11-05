<html>

<head>

    <title>Activity Report</title>
    <style type="text/css">
    body {
        font-family: Helvetica, Arial, sans-serif;
        color: #333;
        font-size: 10px;
    }

    th {
        background:
            -moz-linear-gradient(#FFFFFF, #EFEFEF) repeat scroll 0 0 transparent;
    }

    .even {
        background:
            -moz-linear-gradient(#FFFFFF, #EFEFEF) repeat scroll 0 0 transparent;
    }

    .odd {
        background-color: #f7f7f7;
    }

    body {
        font-family: Helvetica, Arial, sans-serif;
        color: #333;
        font-size: 10px;
    }

    .pdf-page {
        height: 100%;
        margin: 40px -13px -20px -10px;
        padding: 30px;
    }

    .pdf-page p {
        width: 100%;
        margin: 0 0 20px 0;
    }

    .accordion h3 {
        padding: 2px 8px;
        font-size: 14px;
        margin-bottom: 2px;
        cursor: pointer;
        font-weight: bold;
        color: #555;
        background: #eee
    }
    </style>
    <style>
    .pdf-page {
        height: 100%;
    }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        $("tr:odd").css("background-color", "#EEFCE9");
        $("tr:even").css("background-color", "white");
    });
    </script>
</head>

<body>
    <table>
        <tr>
            <td> <img src="<?php echo base_url();?>source/template/images/logo.gif" alt="Profile Photo" height="86"
                    width="80" /></td>
        </tr>
    </table>
    <div class="pdf-page">
        <div id="show" name="show">
            <?php $frequency = array(1=>'weekly',2=>'monthly',3=>'quarterly',4=>'yearly');?>
            <div>
                <table width="100%">
                    <tbody id="activitiesTable">
                        <?php  
		  $i=0;
		  $j=1;
	  if(count($activityList))
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
                                <h2 style="color: #1C94C4;border:1px solid #B9CE98;"><?php echo $row['mastertype'];?>
                                </h2>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr width="50%">
                            <td align="left" valign="middle" bgcolor="#B9CE98;"
                                style=" border:1px solid #cccccc; background:#66CC99;" colspan="2">
                                <?=$activityList[$i]['label']?></td>
                            <?php $months =  date("M", mktime(0, 0, 0,$row['start_date'] , 1, 2000));?>
                            <td align="left" valign="middle" width="80px" bgcolor="#B9CE98;"
                                style="border-top:1px solid #cccccc; background:#B9CE98;">
                                <?=$months?>-<?=$activityList[$i]['end_date']?></td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle">
                                <p><b>Villgro Response</b></p>
                            </td>
                            <td>
                                <div><?=$row['villgro_answer'];?></div> &nbsp; <i
                                    style="font-size:12px;font-weight:bold;color:grey;">--
                                    <?=$row['villgro_answerby'];?></i>
                                <div><?=$row['manager_answer'];?></div> &nbsp; <i
                                    style="font-size:12px;font-weight:bold;color:grey;">--
                                    <?=$row['manager_answerby'];?></i>
                            </td>
                            <td align="left" style="border-bottom:1px solid #CCCCCC;" rowspan="2" valign="middle"><a
                                    href="<?=base_url().'uploads/'.$row['document'][0]?>"><?=$row['document'][0];?></a>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" style="border-bottom:1px solid #CCCCCC;">
                                <p><b>Incubatee Response</b></p>
                            </td>
                            <td style="border-bottom:1px solid #CCCCCC;">
                                <div><?=$row['answer'];?></div> - &nbsp; <i
                                    style="font-size:11px;"><?=$row['answerby'];?></i>
                            </td>
                        </tr>
                        <?php $i++;$j++;
		  }		
			?>
                        <?php
	  }
	else
	{ ?>
                        <tr>
                            <td colspan='2' align='center' style="color:red;">No Matching Records found!</td>
                        </tr>
                        <?php
	} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>