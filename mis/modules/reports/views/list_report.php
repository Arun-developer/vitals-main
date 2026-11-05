<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>KRA Report</title>
</head>

<body>
    <h1>KRA Reports</h1>
    <ul class="tabs">
    <?php foreach($yearly as $row5)
	{
    ?>
        <li class="<?=($defaultyear == $row5)?'selected':'';?>"><a
                href="<?=site_url('reports/kra_report/view_report/'.$row5.'/'.$defaultmonth);?>"><?=$row5;?></a></li>
        <?php } ?>
    </ul>

    <ul class="tabs">
        <?php foreach($monthly as $row6)
		{
			?>
        <li class="<?=($defaultmonth == $row6)?'selected':'';?>"><a
                href="<?=site_url('reports/kra_report/list_report/'.$this->uri->segment('4').'/'.$defaultyear.'/'.$row6);?>"><?= date("F", mktime(0, 0, 0, $row6, 1, 2000));?></a>
        </li>
        <?php }  ?>
    </ul>

    <form method="post" action="<?=site_url('reports/kra_report/add_report')?>">

        <input type="hidden" name="month" value="<?=$defaultmonth;?>" />

        <input type="hidden" name="year" value="<?=$defaultyear;?>" />

        <div style="height: 600px;overflow:scroll">

            <table class="gtable sorttable">

                <thead>

                    <tr>

                        <th>KRA</th>

                        <th>KPI</th>

                        <th>Target</th>

                        <th>Achieved</th>

                    </tr>

                </thead>

                <tbody id="activitiesTable">

                    <?php  

    	  if(count($report_list))

          {

		  foreach($report_list as $row)

		  {

                     ?>

                    <tr>

                        <td align="left" valign="middle"> <?=$row['kra'];?></td>

                        <td align="left" valign="middle"><?=$row['kpi'];?></td>

                        <td><?=$row['target'];?></td>

                        <td><?=$row['achieved'];?></td>

                        <?php 

		  }		

            ?>

                    </tr>

                    <?php

	  }

	else

	{ ?>

                    <tr>

                        <td colspan='7' align='center'>No Records found!</td>

                    </tr>

                    <?

	} ?>

                </tbody>

            </table>

            <br />

            <div align="center">

            </div>

    </form>

</body>

</html>