<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Villgro</title>
        <link href="<?= base_url(); ?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
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

        <script src="<?= base_url(); ?>source/template/js/json.htmTable.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>source/template/js/json.debug.js" type="text/javascript"></script>

        <script type="text/javascript">
            function sourcechecked()
            {
                var allVals = [];
                $('input[name=source]:checked').each(function() {
                    allVals.push($(this).val());
                });
                var datas = $.ajax({	
                    type: "POST",
                    url: "<?php echo site_url('dashboard/dashboard/sourcecompare'); ?>",
                    data: {'source':allVals,'isajax':true},
                    dataType:'json',
                    success: function(datas) {
                        var json = $.parseJSON(datas);
                        $(json).each(function(){
                            row = $('#tabl').append('<tr>') ;
                            $(row).append('<td>').html(json.cell1.value);
                            $(row).append('</td>');
                            $(row).append('</tr>');
                        });
                    }
                });
            }
 
            /* call the php that has the php array which is json_encoded */

        </script>
    </head>
    <body>

        <div class="header_report">
            <div class="header_report_LFT"><img src="<?= base_url(); ?>source/template/images/logo_report.png" /></div>
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
                                                <li><a href="<?= site_url('dashboard/dashboard/scouting_report') ?>" class="sel">Scouting &amp; Screening</a></li>
                                                <li><a href="<?= site_url('dashboard/dashboard/incubation_report') ?>">Incubation</a></li>
                                                <li><a href="<?= site_url('dashboard/dashboard/progress_report') ?>">Progress</a></li>
                                            </ul>
                                        </div>
                                        <div class="report_tabmenu2">
                                            <div class="report_tabmenu23">
                                                <ul id="navbar"> 
                                                    <li><a href="<?= site_url('dashboard/dashboard/scoutingquality') ?>">Quality </a></li>
                                                    <li><a href="<?= site_url('dashboard/dashboard/scouting_report') ?>">Quantity</a></li>
                                                    <li><a href="#">Export <img src="report_export_arrow.gif" border="0px"/></a><ul>
                                                            <li><a href="#">Pdf</a></li>
                                                            <li><a href="#">Excel</a></li>
                                                        </ul>

                                                    </li>
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
                                            <form name="myform" method="post" action="<?= site_url('dashboard/dashboard/sourcecompare') ?>" >
                                                <ul>
                                                    <li><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td colspan="4"  class="menu_list2"><h2>Period</h2></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="16%" class="table_down">From</td>
                                                                <td width="30%"><select name="select6" id="select6" style="width:60px;">
                                                                        <option>Year</option>
                                                                    </select></td>
                                                                <td width="10%" class="table_down">To</td>
                                                                <td width="44%" height="30"><select name="select7" id="select7" style="width:60px;">
                                                                        <option>Year</option>
                                                                    </select></td>
                                                            </tr>
                                                        </table></li>
                                                    <li><h1>Top Fives<span>Current Year 2012</span></h1> </li>

                                                </ul>

                                                <div class="menu_list2">
                                                    <h2 class="msg_head">Source Wise Innovations</h2>
                                                    <div class="msg_body">
                                                        <ul>
                                                            <?php foreach ($source as $row): ?>
                                                                <li><span><input name="source[]" type="checkbox"  value="<?= $row['master_name']; ?>" /></span><?= $row['master_name']; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="menu_list2">
                                                    <h2 class="msg_head">Employee Wise</h2>
                                                    <div class="msg_body">
                                                        <ul>
                                                            <?php foreach ($employee as $eow): ?>
                                                                <li><span><input name="employee[]" type="checkbox" value="<?= $eow['emp_number']; ?>" /></span><?= $eow['emp_name']; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="menu_list2">
                                                    <h2 class="msg_head">Sector</h2>
                                                    <div class="msg_body">
                                                        <ul>
                                                            <?php
                                                            for ($i = 0; $i < 4; $i++) {
                                                                ?>
                                                                <li><span><input name="sector[]" type="checkbox" value="<?= $sector[0][$i]; ?>" /></span><?= $sector[0][$i]; ?></li>
                                                            <?php }; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="menu_list2">
                                                    <h2 class="msg_head">Product</h2>
                                                    <div class="msg_body">
                                                        <ul>
                                                            <?php foreach ($product as $pow): ?>
                                                                <li><span><input name="product[]" type="checkbox" value="<?= $pow['answer']; ?>" /></span><?= $pow['answer']; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="menu_list2">
                                                    <h2 class="msg_head">Time</h2>
                                                    <div class="msg_body">
                                                        <ul>
                                                            <li><span><input name="" type="checkbox" value="" /></span>Referral - 20</li>
                                                            <li><span><input name="" type="checkbox" value="" /></span>Web Search - 10</li>
                                                            <li><span><input name="" type="checkbox" value="" /></span>Referral - 20</li>
                                                            <li><span><input name="" type="checkbox" value="" /></span>Web Search - 10</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="report_compare_butt"><a href="javascript:void(0)" onclick="document.myform.submit()">Compare</a></div>
                                            </form>
                                        </div>
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
                                                    <td width="12%">Source Wise</td>
                                                    <td width="2%" >&nbsp;</td>
                                                    <td width="14%">Employee Wise </td>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="13%">Wise Services </td>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="12%">Sector </td>
                                                    <td width="1%">&nbsp;</td>
                                                    <td width="12%"> Product </td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><select  name="select5" id="select5" style="width:130px;">
                                                            <?php foreach ($source as $rw): ?>
                                                                <option value="<?= $rw['master_name'] ?>"><?= $rw['master_name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select></td>
                                                    <td>&nbsp;</td>
                                                    <td><select name="select4" id="select4" style="width:130px;">
                                                            <?php foreach ($employee as $ew): ?>
                                                                <option value="<?= $ew['emp_name'] ?>"><?= $ew['emp_name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select></td>
                                                    <td>&nbsp;</td>
                                                    <td><select name="select3" id="select3" style="width:130px;">
                                                        </select></td>
                                                    <td>&nbsp;</td>
                                                    <td><select name="select2" id="select2" style="width:130px;">
                                                            <?php
                                                            for ($i = 0; $i < 4; $i++) {
                                                                ?>
                                                                <option value="<?= $sector[0][$i] ?>"><?= $sector[0][$i]; ?></option>
                                                            <?php } ?>
                                                        </select></td>
                                                    <td>&nbsp;</td>
                                                    <td><select name="select" id="select" style="width:130px;">
                                                            <?php foreach ($product as $pw): ?>
                                                                <option value="<?= $pw['answer'] ?>"><?= $pw['answer']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select></td>
                                                    <td width="2%">&nbsp;</td>
                                                    <td width="30%" class="report_apply_butt"><a href="#">Apply</a></td>
                                                </tr>
                                            </table>
                                        </div>
                                            <div class="table_section ">

                                                <table width="100%" class="gtable" cellspacing="1" cellpadding="0">
                                                    <tr>
                                                        <td  >&nbsp;</td>
                                                        <td  >&nbsp;</td>
                                                        <?php foreach ($stage as $key => $value): ?>
                                                            <td colspan="1" width="13%"><?= $value; ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>

                                                    <?php
                                                    $empselectedcount = array_pop($employeeselected);
                                                    $sectorselectedcount = array_pop($sourceselected);
                                                    $sourceselectedcount = array_pop($sourceselected);

                                                    $rowspancount = max($empselectedcount, $sectorselectedcount, $sourceselectedcount);

                                                    for ($yearvalue = 0; $yearvalue < php72_count($yearly); $yearvalue) {
                                                        ?>
                                                        <tr>
                                                            <td rowspan ="2" width="14%" class="table_down"><?= $yearly[$i]; ?>
                                                            </td>
                                                            
                                                                <?php
                                                                for ($k = 0; $k < $rowspancount; $k++) {
                                                                    if (php72_cmp($empselectedcount) > 0) {
                                                                        ?>
                                                                        <td ><?= $employeeselected[$k]; ?></td>
                                                                    <?php } if (php72_cmp($sectorselectedcount) > 0) { ?>
                                                                        <td><?= $sectorselected[$k]; ?></td>
                                                                    <?php } if (php72_cmp($sourceselectedcount) > 0) { ?>
                                                                        <td><?= $sourceselected[$k]; ?></td>
                                                                    <?php
                                                                    }
                                                                    foreach ($stage as $key => $value) {
                                                                        if (($stage[$sourcecompare[$i]['stage']] == $value) && ($sourcecompare[$i]['master_name'] == @$selected[$k])) {
                                                                            ?>
                                                                            <td class="table_down"><?= $sourcecompare[$i]['VALUE']; ?></td>
                                                                        <?php } else { ?>
                                                                            <td class="table_down">0</td>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
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
        </div>

    </body>
</html>
