<html>

    <head>
        <style type="text/css">
            body {
                font-family: Helvetica, Arial, sans-serif;
                color: #333;
                font-size: 10px;
            }

            th {
                background: -moz-linear-gradient(#FFFFFF, #EFEFEF) repeat scroll 0 0 transparent;
            }

            .even {
                background: -moz-linear-gradient(#FFFFFF, #EFEFEF) repeat scroll 0 0 transparent;
            }

            .odd {
                background-color: #f7f7f7;

            }


            ul.tabs {
                font-size: 12px;
                line-height: 14px;
                font-weight: bold;
                border-bottom: 1px solid #666666;
                padding: 4px 0
            }

            .tabs li {
                display: inline;


            }

            .tabs a {

                padding: 3px 10px;
                color: #888;
                outline: 0
            }

            .tabs a:hover {
                color: #555;
                background: #eee
            }

            .tabs .selected a {
                color: #fff;

            }

            .tabcontent {
                padding: 10px 0
            }

            #settings .tabcontent {
                padding-top: 25px
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

            .tabs a,
            .accordion h3 {
                background: -webkit-gradient(linear, 0 0, 0 bottom, from(#eee), to(#e4e4e4));
                background: -moz-linear-gradient(#eee, #e4e4e4);
                background: linear-gradient(#eee, #e4e4e4);
                -pie-background: linear-gradient(#eee, #e4e4e4)
            }

            .tabs .selected a,
            div.accordion h3.active {
                background: -webkit-gradient(linear, 0 0, 0 bottom, from(#74ad5a), to(#6aa74f));
                background: -moz-linear-gradient(#74ad5a, #6aa74f);
                background: linear-gradient(#74ad5a, #6aa74f);
                -pie-background: linear-gradient(#74ad5a, #6aa74f)
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
        </style>

    </head>

    <body>

        <table>
            <tr>
                <td> <img src="<?php echo base_url(); ?>source/template/images/logo.gif" alt="Profile Photo" height="86"
                          width="80" /></td>
            </tr>
        </table>
        <h3 align="center"> Progress Report</h3>
        <table class="gtable" width="100%">
            <thead>
                <tr class="tablehead" style="background:#66CC99;" bgcolor="#B9CE98;">
                    <td style="background:#efefef;color:#B9CE98;color:darkgrey;">Parameter</td>
                    <td> </td>
                    <td style="background:#efefef;color:#B9CE98;color:darkgrey;">Month - <?php
                        if ($month == '1') {
                            $monthName = "January";
                        }
                        if ($month == '2') {
                            $monthName = "February";
                        }
                        if ($month == '3') {
                            $monthName = "March";
                        }
                        if ($month == '4') {
                            $monthName = "April";
                        }
                        if ($month == '5') {
                            $monthName = "May";
                        }
                        if ($month == '6') {
                            $monthName = "June";
                        }
                        if ($month == '7') {
                            $monthName = "July";
                        }
                        if ($month == '8') {
                            $monthName = "August";
                        }
                        if ($month == '9') {
                            $monthName = "September";
                        }
                        if ($month == '10') {
                            $monthName = "October";
                        }
                        if ($month == '11') {
                            $monthName = "November";
                        }
                        if ($month == '12') {
                            $monthName = "December";
                        }
                        echo $monthName . "-" . $year;
                        ?> </td>
                </tr>
            </thead>
            <tbody id="activitiesTable">
                <?php
                $i = 0;
                $j = 1;

                if (count($progressList)) {
                    $key1 = 0;
                    $na = "";
                    $rowtype = 'odd';
                    foreach ($progressList as $row):

                        $na_new = $row['mastertype'];
                        if ($na_new != $na) {
                            $na = $na_new;
                            $key1 = 0;
                            ?>
                            <tr>
                                <td colspan="3">
                                    <h2 style="color: #1C94C4;border:1px solid #B9CE98;"> <?php
                                        if ($row['mastertype'] == "Financial Performance") {
                                            echo $row['mastertype'] . "<span style='color:Black;margin-left:240px;'>-INR</span>";
                                        } else {
                                            echo $row['mastertype'];
                                        }
                                        ?></h2>
                                </td>

                            </tr>
                        <?php } ?>
                        <tr class="<?php echo $rowtype; ?>">
                            <td align="left" valign="middle" width="45%"><?php echo $row['label'];
                        ?></td>
                            <td> </td>
                            <td align="left" valign="middle" width="55%"><?php echo $row['answer']; ?></td>
                        </tr>
                        <?php
                    endforeach;
                    $rowtype = "even";
                    ?>
                    <tr class="<?php echo $rowtype; ?>">
                        <td align="left" valign="middle" width="45%" style="background:#efefef;color:#333;">&nbsp;</td>
                        <td> </td>
                        <td align="left" valign="middle" width="55%" style="background:#efefef;color:#333;">&nbsp;</td>
                    </tr>
                    <tr style="color:grey;">
                        <td colspan="3" align="center"> <?php echo "All right Reserved.  Powered By Villgro"; ?></td>
                    </tr>
                    <?php
                } else {
                    ?>
                    <tr>
                        <td colspan='7' align='center'>No Matching Records found!</td>
                    </tr>
                <?php }
                ?>

            </tbody>
        </table>
        <hr>
    </body>

</html>