	<html>
	<head>
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
	    <h3 align="center"> Progress Report</h3>
	    <table class="gtable" width="100%">
	        <thead>
	            <tr class="tablehead" style="background:#66CC99;" bgcolor="#B9CE98;">
	                <td style="background:#efefef;color:#B9CE98;color:darkgrey;">Parameter</td>
	                <td> </td>
	                <td style="background:#efefef;color:#B9CE98;color:darkgrey;">Year - <?php echo "<b>".$year."</b>"; ?>
	                </td>
	            </tr>
	        </thead>
	        <tbody id="activitiesTable">
	            <?php 
		        $i=0;
                $j=1;
         if(count($progressList))
         {
                $key1 = 0;  
                $na="";
					$rowtype = 'odd';
                 foreach($progressList as $row):
                
                  $na_new = $row['mastertype'];
              if($na_new != $na)
              {
                   $na = $na_new;
                   $key1 = 0;
                       ?>
	            <tr>
	                <td colspan="3">
	                    <h2 style="color: #1C94C4;border:1px solid #B9CE98;"> <?=$row['mastertype']?></h2>
	                </td>
	            </tr>
	            <?php } ?>
	            <tr class="<?php echo $rowtype;?>">
	                <td align="left" valign="middle" width="45%"><?=$row['label']?></td>
	                <td> </td>
	                <td align="left" valign="middle" width="55%"><?=$row['answer']?></td>
	            </tr>
	            <?php 
			endforeach;
			$rowtype = "even";
			?>
	            <tr class="<?php echo $rowtype;?>">
	                <td align="left" valign="middle" width="45%" style="background:#efefef;color:#333;">&nbsp;</td>
	                <td> </td>
	                <td align="left" valign="middle" width="55%" style="background:#efefef;color:#333;">&nbsp;</td>
	            </tr>
	            <tr style="color:grey;">
	                <td colspan="3" align="center"> <?php echo "All right Reserved.  Powered By Villgro"; ?></td>
	            </tr>
	            <?php
	}
	else
	{ ?>
	            <tr>
	                <td colspan='7' align='center'>No Matching Records found!</td>
	            </tr>
	            <?php
	} ?>

	        </tbody>
	    </table>
	    <hr>
	</body>

	</html>