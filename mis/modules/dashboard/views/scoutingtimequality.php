<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <link href="<?= base_url(); ?>source/template/css/report_style.css" rel="stylesheet" type="text/css" />
        <style>

        </style>
        <script type="text/javascript">
            $(document).ready(function () {
                //hide the all of the element with class msg_body
                $(".msg_body").hide();
                //toggle the componenet with class msg_body
                $(".msg_head").click(function () {
                    $(this).next(".msg_body").slideToggle(600);
                });
                $.getJSON('<?= site_url('dashboard/dashboard/sourcecompare') ?>', function (data) {
                    /* data will hold the php array as a javascript object */
                    var json = $.parseJSON(data);
                    $('.table_section').hide();
                    $('#DynamicGrid').append(CreateTableView(json.source, "tabl", true)).fadeIn();
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
    </head>
    <body>

        <div class="header_report">
            <div class="header_report_LFT">

            </div>
            <div class="header_report_RHT"></div>
        </div>
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
                                    <?php if (@$filename == "") { ?>
                                        <div class="report_tabmenu">
                                            <ul>
                                                <li><a href="<?= site_url('dashboard/dashboard/scouting_report') ?>" class="sel">Scouting &amp; Screening</a></li>
                                                <li><a href="<?= site_url('dashboard/dashboard/incubation_report') ?>">Incubation</a></li>
                                                <li><a href="<?= site_url('dashboard/dashboard/progress_report') ?>">Progress</a></li>
                                            </ul>
                                        </div>
                                    <?php } ?>

                                    <div class="report_tabmenu2">
                                        <?php if (@$filename == "") { ?>
                                            <div class="report_tabmenu23">
                                                <ul id="navbar">
                                                    <li><a href="<?= site_url('dashboard/dashboard/scoutingquality') ?>">Quality </a></li>
                                                    <li><a href="<?= site_url('dashboard/dashboard/scouting_report') ?>">Quantity</a></li>
                                                    <li><a href="<?php echo site_url("dashboard/timetakenreport/ex"); ?>">Export</a></li>
                                                    <!-- ... and so on ... -->
                                                </ul>

                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!--end header tab menu-->
                        <!--LEFT-->
                        <?php if (@$filename == "") { ?>
                            <div class="main_Content_Inner_LFT">
                                <div class="report_sideline">
                                    <div class="main_menu">
                                        <form name="myform" method="post" action="<?= site_url('dashboard/dashboard/scoutingquality') ?>">
                                            <ul>
                                                <li><table width="100%" border="0" cellspacing="0" cellpadding="0">

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
                                                        <?php for ($i = 0; php72_cmp($i) < 4; $i++) { ?>
                                                            <li><span><input name="sector[]" type="checkbox" value="<?= $sector[0][$i]; ?>" /></span><?= $sector[0][$i]; ?></li>
                                                        <?php }; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="menu_list2">

                                                <div class="menu_list2">
                                                    <h2 class="msg_head">
                                                        <span class="msg_head" style="color:#B1D727 !Important;"> <a href="<?= site_url('dashboard/dashboard/timetakenreport') ?>">Time Taken</a></span>
                                                    </h2>
                                                </div>
                                                <div class="report_compare_butt"><a href="javascript:void(0)" onclick="document.myform.submit()">Compare</a></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--END LEFT-->

                        <!--Right-->
                        <div class="main_Content_Inner_RHT">
                            <div class="main_rht_full ">
                                <?php if (@$filename == "") { ?>
                                    <h1>Dashboard </h1>

                                    <div class="selectBAR">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="12%">Source Wise</td>
                                                <td width="2%" >&nbsp;</td>
                                                <td width="14%">Employee Wise </td>
                                                <td width="1%">&nbsp;</td>
                                                <td width="1%">&nbsp;</td>
                                                <td width="12%">Sector </td>
                                                <td width="1%">&nbsp;</td>
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
                                                <td>&nbsp;</td>
                                                <td><select name="select2" id="select2" style="width:130px;">
                                                        <?php for ($i = 0; php72_cmp($i) < 4; $i++) { ?>
                                                            <option value="<?= $sector[0][$i] ?>"><?= $sector[0][$i]; ?></option>
                                                        <?php } ?>
                                                    </select></td>
                                                <td>&nbsp;</td>
                                                <td width="2%">&nbsp;</td>
                                                <td width="30%" class="report_apply_butt"><a href="#">Apply</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="table_section ">

                            <table class="gtable">
                                <thead>
                                    <tr>

                                        <th><a href="" field="name_of_enterprise" class="sortlink">Name of the Incubatee</a></th>
                                        <th><a href="" field="created_date" class="sortlink">Date Applied</a></th>
                                        <th><a href="" field="entry_date" class="sortlink">Date Of Entry</a></th>
                                        <th><a href="" field="created_date" class="">Time Taken(New - Entry)</a></th>
                                        <th><a href="" field="created_date" class="">Date Of Lead</a></th>
                                        <th><a href="" field="entry_lead" class="sortlink">Time Taken(Entry - Lead)</a></th>
                                        <th><a href="" field="created_date" class="">Date Of Detailed Deligence</a></th>
                                        <th><a href="" field="entry_lead" class="sortlink">Time Taken(Lead - Detailed Deligence)</a></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    //show($innovationList);
                                    if (php72_count($innovationList)) {
                                        $i = 'odd';
                                        foreach ($innovationList as $row):
                                            $i = ($i == 'odd') ? 'even' : 'odd';
                                            ?>
                                            <tr class="<?= $i ?>">
                                                <td class="table_down"><?= $row['name_of_enterprise'] ?></td>
                                                <td class="table_down"><?= mysql2date($row['created_date']) ?></td>
                                                <td class="table_down"><?= mysql2date($row['entry_date']) ?></td>
                                                <td class="table_down"><?= $row['new_entry'] ?></td>
                                                <td class="table_down"><?= mysql2date($row['lead_date']) ?></td>
                                                <td class="table_down"><?= $row['entry_lead'] ?></td>
                                                <td class="table_down"><?= $row['shortlist_date'] ?></td>
                                                <td class="table_down"><?= $row['screening_date'] ?></td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    }
                                    else {
                                        ?>
                                        <tr class="odd"><td colspan="10" align="center">No Records</td></tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <!--END right-->
                    </div>

                </div>
            </div>
        </div>
        <!--End main body-->




    </body>
</html>
<script type="text/javascript">
    function sourcechecked()
    {
        var allVals = [];
        $('input[name=source]:checked').each(function () {
            allVals.push($(this).val());
        });
        var datas = $.ajax({
            type: "POST",
            url: "<?php echo site_url('dashboard/dashboard/sourcecompare'); ?>",
            data: {'source': allVals, 'isajax': true},
            dataType: 'json',
            success: function (datas) {
                var json = $.parseJSON(datas);
                $(json).each(function () {
                    row = $('#tabl').append('<tr>');
                    $(row).append('<td>').html(json.cell1.value);
                });
            }
        });
    }

    /* call the php that has the php array which is json_encoded */

</script>