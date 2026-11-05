<script type="text/javascript">
    $(document).ready(function () {
        $("#validateMonth").click(function () {
            var monthID = $("#monthID").val();
            if (monthID == "") {
                alert("Please Chose Month to export !!");
                return false;
            } else {
                return true;
            }
        });
        $("#quaterExportID").click(function () {
            var quarterID = $("#quarterID").val();
            if (quarterID == "") {
                alert("Please Chose Month to export !!");
                return false;
            } else {
                return true;
            }
        });

        $("#togglePanel").hide();
        $('td.edit').click(function () {
            $('.ajax').html($('.ajax input').val());
            $('.ajax').removeClass('ajax');
            $(this).addClass('ajax');
            $(this).html('<input class="editbox" size="' + $(this).text().length + '" type="text" value="' +
                    $(this).text() + '">');
            $('.editbox').focus();
        });
        $('td.edit').keydown(function (event) {
            var arr = $(this).attr('class').split(" ");
            if (event.which == 13) {
                var val = $('.ajax input').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('incubationprogress/update') ?>",
                    data: {
                        'value': val,
                        'rownum': arr['5'],
                        'field': arr['4'],
                        'year': arr['2'],
                        'frequency': arr['1'],
                        'months': arr['3'],
                        'type': arr['6'],
                        'innovation': arr['7']
                    },
                    success: function (data) {
                        $('.ajax').html($('.ajax input').val());
                        $('.ajax').removeClass('ajax');
                    }
                });
            }
        });
        $('.editbox').live('blur', function () {
            $('.ajax').html($('.ajax input').val());
            $('.ajax').removeClass('ajax');
        });

        $("#expandSlide").click(function () {

            $('.togglePanel').slideToggle("slow");
        });

    });

    function monthchange(val) {
        document.monthchangeform.submit();
    }
</script>
<style>
    /* ---- Table ---- */
    table {
        border-collapse: collapse;
        margin-bottom: 15px;
        width: 90%;
    }

    table td,
    table th {
        padding: 3px;
        border: 1px solid #ccc;
        border-width: 0 1px 1px 0;
        font-size: 11px;
        color: #FFFFFF;
    }

    thead th {
        background: #6aa74f;
        color: #FFFFFF;
    }

    thead th[colspan],
    thead th[rowspan] {
        background: #6aa74f;
        color: #FFFFFF;
    }

    tbody th,
    tfoot th {
        text-align: left;
        background: #6aa74f;
    }

    tbody td,
    tfoot td {
        text-align: center;
        color: #000000;

    }

    tfoot th {
        background: #b0cc7f;
    }

    tfoot td {
        background: #d7e1c5;
        font-weight: bold;
    }

    tbody tr.odd td {
        background: #bcd9e1;
    }
</style>
<h1>Incubation Progress - [<?php echo $name_of_enterprise; ?>]</h1>
<ul class="tabs">
    <li class="selected"><a href="<?= site_url('reports/progress_report/form/' . $innovation) ?>">IRIS Metrics Value</a>
    </li>
    <li><a href="<?= site_url('reports/progress_report/activityreport/' . $innovation) ?>">Subjective</a></li>
</ul>
<br />
<div id="tabid" class="tabset_content">
    <?php
    if ($defaultfrequency != '4') {
        ?>
        <ul class="tabs">
            <?php
            foreach ($yearly as $row5) {
                ?>
                <li class="<?= ($defaultyearly == $row5) ? 'selected' : ''; ?>"><a
                        href="<?= site_url('reports/progress_report/form/' . $innovation . '/' . $defaultms . '/' . $defaultsubms . '/' . $defaulttype . '/' . (($defaulttype == "metrices") ? $defaultsubcategory . '/' : 'NULL' . '/') . $defaultfrequency . '/' . $row5) ?>"><?= $row5; ?></a>
                </li>
            <?php } ?>
        </ul>
        <?php
        if ($defaultfrequency == '1') {
            ?>
            <ul class="tabs">
                <?php
                foreach ($monthly as $row6) {
                    ?>
                    <li class="<?= ($defaultmonthly == $row6) ? 'selected' : ''; ?>"><a
                            href="<?= site_url('reports/progress_report/form/' . $innovation . '/' . $defaultms . '/' . $defaultsubms . '/' . $defaulttype . '/' . (($defaulttype == "metrices") ? $defaultsubcategory . '/' : 'NULL' . '/') . $defaultfrequency . '/' . $defaultyearly . '/' . $row6) ?>"><?= date("M", mktime(0, 0, 0, $row6, 1, 2000)); ?></a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <a href="#" id="expandSlide" style="margin-left:862px;" title="Export Progress Details"><span
                style="color:green;font-weight:bold;"> [+]</span></a>

        <div class="togglePanel" style="display:none;">
            <h3>Export As Report </h3>
            <form id="monthFrmID" method="post" name="frmMonth"
                  action="<?= site_url('reports/progress_report/pdfExport/' . $innovation); ?>">
                <input type="hidden" name="innovation" id="innovationID" value="<?= $innovation ?>" />
                <input type="hidden" name="defaultYear" id="ajaxreturn" value="<?php echo $defaultyearly; ?>" />

                <table>
                    <tr>
                        <td style="font-weight:bold;"> Select Month</td>
                        <td>

                            <select name="month" id="monthID">
                                <option value="">--Select--</option>
                                <?php foreach ($monthly as $rowmonth) { ?>
                                    <option value="<?php echo $rowmonth; ?>">
                                        <?= date("M", mktime(0, 0, 0, $rowmonth, 1, 2000)); ?></option>
                                    <?php } ?>
                            </select>

                        </td>
                        <td>
                            <div align="right"><input type="submit" id="validateMonth" value="Export" class="button"></div>
                        </td>
                    </tr>

                </table>

            </form>
            <form id="quarterFrmID" method="post" name="frmQuarter"
                  action="<?= site_url('reports/progress_report/pdfQuarterExport/' . $innovation); ?>">
                <input type="hidden" name="innovation" id="innovationID" value="<?= $innovation ?>" />
                <input type="hidden" name="defaultYear" id="ajaxreturn" value="<?php echo $defaultyearly; ?>" />
                <?php
                $listQuarter = array(
                    '1' => "1st Quarter",
                    '2' => "2nd Quarter",
                    '3' => "3rd Quarter",
                    '4' => "4th Quarter"
                );
                ?>
                <table>
                    <tr>
                        <td style="font-weight:bold;"> Select Quarter</td>
                        <td>
                            <select name="quarter" id="quarterID">
                                <option value="">--Select--</option>
                                <?php foreach ($listQuarter as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"> <?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td colspan="2">
                            <div align="right"><input type="submit" value="Export" id="quaterExportID" class="button"></div>
                        </td>
                    </tr>
                </table>
            </form>
            <form id="monthFrmID" method="post" name="frmMonth"
                  action="<?= site_url('reports/progress_report/pdfYearExport/' . $innovation); ?>">
                <input type="hidden" name="innovation" id="innovationID" value="<?= $innovation ?>" />
                <input type="hidden" name="defaultYear" id="ajaxreturn" value="<?php echo $defaultyearly; ?>" />
                <table>
                    <tr>
                        <td style="font-weight:bold;">Year Report </td>
                        <td>
                            <span
                                style="margin-left: 34px;margin-right: 9px;font-weight:bold;"><?php echo $defaultyearly; ?>
                            </span>

                        </td>
                        <td>
                            <div align="right"><input type="submit" value="Export" class="button"></div>
                        </td>
                    </tr>

                </table>
            </form>
        </div>



        <ul class="sliderTab">
            <?php
            foreach ($mastertype as $row) {
                ?>

                <li class="<?= ($defaultms == $row['master_type']) ? 'selected' : ''; ?>" id="accordion">
                    <a href="<?= site_url('reports/progress_report/form/' . $innovation . '/' . ($row['master_type'])) ?>"
                       id="masterID_<?php echo str_replace(" ", "_", $row['master_type']); ?>">
                        <h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab"
                            aria-expanded="true" aria-selected="true" tabindex="0"
                            style="color: #1C94C4;font-weight:bold;font-size:16px !important;">
                            <span class="<?php if ($defaultms == $row['master_type']) {
            echo "ui-icon ui-icon-circle-arrow-s";
        } else {
            echo "ui-icon ui-icon-circle-arrow-e";
        }
        ?>"></span><?= $row['master_type'] ?>
                        </h3>
                    </a>

                    <ul>
                        <li style="border:1px solid grey;"
                            class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active"
                            style="height: 127px; overflow: auto; display: block; padding-top: 11px; padding-bottom: 11px;"
                            role="tabpanel">
                                <?php
                                if ($defaultfrequency == '2' && $row['master_type'] == $defaultms) {
                                    if ($defaulttype == 'metrices') {
                                        ?>
                                    <table id="travel" style="width:845px;background-color:white;" cellspacing="3" cellpadding="4">
                                        <tr scope="row">
                                            <th>Label</th>
                                            <?php foreach ($monthly as $months):
                                                if ($defaulttype == 'activity') {
                                                    ?>
                                                    <th scope="rowgroup" colspan="2"><?php echo date("M", mktime(0, 0, 0, $months, 1, 2000)); ?>
                                                    </th><?php } else {
                                                    ?>
                                                    <th><?php echo date("M", mktime(0, 0, 0, $months, 1, 2000)); ?>
                                                    </th>
                                            <?php } endforeach;
                                        ?>

                                        </tr>
                                        <?php
                                        $j = 0;
                                        for ($i = 0; $i < php72_count($monthreport); $i++) {
                                            echo '<tr scope="row">';
                                            if ($defaulttype == 'metrices') {
                                                echo '<th>' . $monthreport[$i]['label'] . '</th>';
                                            } else {
                                                echo '<th><a class="fancybox" style="color:white" href="' . site_url("reports/progress_report/form/" . $defaultyearly . '/' . $defaultmonthly . '/' . $monthreport[$i]['id'] . '/' . $defaulttype . '/' . $innovation) . '">' . $monthreport[$i]['label'] . '</a></th>';
                                            }
                                            $monthcount = 0;
                                            foreach ($monthly as $months) {
                                                switch ($monthcount) {
                                                    case 0:

                                                        if (is_array($monthanswerreport0)) {
                                                            if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport0[$i]['criteria'] . ' ' . $monthanswerreport0[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport0[$i]['answer'] . '</td>';
                                                            } else {
                                                                echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport0[$i]['criteria'] . ' ' . $monthanswerreport0[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport0[$i]['answer'] . '</td>';
                                                            }

                                                            if ($defaulttype == 'activity') {
                                                                if ($monthanswerreport0[$i]['document'] == '') {
                                                                    ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport0[$i]['criteria'] . '/' . $monthanswerreport0[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                        <?php
                                        } else {
                                            echo '<td width="20px">' . substr($monthanswerreport0[$i]['document'], 14, -3) . '</td>';
                                        }
                                    }
                                }
                                break;

                            case 1:
                                if (is_array($monthanswerreport1)) {

                                    if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                        echo '<td width="20px" class=" ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport1[$i]['criteria'] . ' ' . $monthanswerreport1[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport1[$i]['answer'] . '</td>';
                                    } else {
                                        echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport0[$i]['criteria'] . ' ' . $monthanswerreport1[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport1[$i]['answer'] . '</td>';
                                    }
                                    if ($defaulttype == 'activity') {
                                        if ($monthanswerreport1[$i]['document'] == '') {
                                            ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport1[$i]['criteria'] . '/' . $monthanswerreport1[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport1[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;
                                                        case 2:
                                                            if (is_array($monthanswerreport2)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport2[$i]['criteria'] . ' ' . $monthanswerreport2[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport2[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport2[$i]['criteria'] . ' ' . $monthanswerreport2[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport2[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport2[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport2[$i]['criteria'] . '/' . $monthanswerreport2[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport2[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;
                                                        case 3:
                                                            if (is_array($monthanswerreport3)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport3[$i]['criteria'] . ' ' . $monthanswerreport3[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport3[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport3[$i]['criteria'] . ' ' . $monthanswerreport3[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport3[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport3[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport3[$i]['criteria'] . '/' . $monthanswerreport3[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport3[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;

                                                        case 4:
                                                            if (is_array($monthanswerreport4)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport4[$i]['criteria'] . ' ' . $monthanswerreport4[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport4[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport4[$i]['criteria'] . ' ' . $monthanswerreport4[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport4[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport4[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport4[$i]['criteria'] . '/' . $monthanswerreport4[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport4[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;
                                                        case 5:
                                                            if (is_array($monthanswerreport5)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport5[$i]['criteria'] . ' ' . $monthanswerreport5[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport5[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport5[$i]['criteria'] . ' ' . $monthanswerreport5[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport5[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport5[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport5[$i]['criteria'] . '/' . $monthanswerreport5[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                        <?php
                                        } else {
                                            echo '<td width="20px">' . substr($monthanswerreport5[$i]['document'], 14, -3) . '</td>';
                                        }
                                    }
                                }
                                break;

                            case 6:
                                if (is_array($monthanswerreport6)) {
                                    if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                        echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport6[$i]['criteria'] . ' ' . $monthanswerreport6[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport6[$i]['answer'] . '</td>';
                                    } else {
                                        echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport6[$i]['criteria'] . ' ' . $monthanswerreport6[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport6[$i]['answer'] . '</td>';
                                    }

                                    if ($defaulttype == 'activity') {
                                        if ($monthanswerreport6[$i]['document'] == '') {
                                            ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport6[$i]['criteria'] . '/' . $monthanswerreport6[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                        <?php
                                        } else {
                                            echo '<td width="20px">' . substr($monthanswerreport6[$i]['document'], 14, -3) . '</td>';
                                        }
                                    }
                                }
                                break;

                            case 7:
                                if (is_array($monthanswerreport7)) {
                                    if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                        echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport7[$i]['criteria'] . ' ' . $monthanswerreport7[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport7[$i]['answer'] . '</td>';
                                    } else {
                                        echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport7[$i]['criteria'] . ' ' . $monthanswerreport7[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport7[$i]['answer'] . '</td>';
                                    }

                                    if ($defaulttype == 'activity') {
                                        if ($monthanswerreport7[$i]['document'] == '') {
                                            ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport7[$i]['criteria'] . '/' . $monthanswerreport7[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport7[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;
                                                        case 8:
                                                            if (is_array($monthanswerreport8)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport8[$i]['criteria'] . ' ' . $monthanswerreport8[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport8[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport8[$i]['criteria'] . ' ' . $monthanswerreport8[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport8[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport8[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport8[$i]['criteria'] . '/' . $monthanswerreport8[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport8[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;
                                                        case 9:
                                                            if (is_array($monthanswerreport9)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport9[$i]['criteria'] . ' ' . $monthanswerreport9[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport9[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport9[$i]['criteria'] . ' ' . $monthanswerreport9[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport9[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport9[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport9[$i]['criteria'] . '/' . $monthanswerreport9[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport9[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;
                                                        case 10:
                                                            if (is_array($monthanswerreport10)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport10[$i]['criteria'] . ' ' . $monthanswerreport10[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport10[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport10[$i]['criteria'] . ' ' . $monthanswerreport10[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport10[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport10[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport10[$i]['criteria'] . '/' . $monthanswerreport10[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                                                    <?php
                                                                    } else {
                                                                        echo '<td width="20px">' . substr($monthanswerreport10[$i]['document'], 14, -3) . '</td>';
                                                                    }
                                                                }
                                                            }
                                                            break;
                                                        case 11:
                                                            if (is_array($monthanswerreport11)) {
                                                                if ($defaultsubcategory != 'Ratios Concepts and Calculations') {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport11[$i]['criteria'] . ' ' . $monthanswerreport11[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport11[$i]['answer'] . '</td>';
                                                                } else {
                                                                    echo '<td width="20px" class=" 2 ' . $defaultyearly . ' ' . $months . ' ' . $monthanswerreport11[$i]['criteria'] . ' ' . $monthanswerreport11[$i]['id'] . ' ' . $defaulttype . ' ' . $innovation . '">' . $monthanswerreport11[$i]['answer'] . '</td>';
                                                                }

                                                                if ($defaulttype == 'activity') {
                                                                    if ($monthanswerreport11[$i]['document'] == '') {
                                                                        ?>
                                                                    <td><a id="site-title" class="fancybox"
                                                                           href="<?= site_url('incubationprogress/fileupload/' . $innovation . '/' . $defaultyearly . '/' . $defaulttype . '/' . $months . '/' . $monthanswerreport11[$i]['criteria'] . '/' . $monthanswerreport11[$i]['id']); ?>"><img
                                                                                src="<?php echo base_url(); ?>source/template/images/Doc_icon.png" width="15px"
                                                                                height="15px"
                                                                                onmouseover="this.src = '<?php echo base_url(); ?>source/template/images/Doc_icon.png';"
                                                                                title="File upload"></a></td>
                                        <?php
                                        } else {
                                            echo '<td width="20px">' . substr($monthanswerreport11[$i]['document'], 14, -3) . '</td>';
                                        }
                                    }
                                }
                                break;
                        }
                        $monthcount++;
                    }
                    $total = 0;

                    $total += $monthanswerreport0[$i]['answer'] + $monthanswerreport1[$i]['answer'] + $monthanswerreport2[$i]['answer'] + $monthanswerreport3[$i]['answer'] + $monthanswerreport4[$i]['answer'] + $monthanswerreport5[$i]['answer'] + $monthanswerreport6[$i]['answer'] + $monthanswerreport7[$i]['answer'] + $monthanswerreport8[$i]['answer'] + $monthanswerreport9[$i]['answer'] + $monthanswerreport10[$i]['answer'] + $monthanswerreport11[$i]['answer'] + @$monthanswerreport12[$i]['answer'];
                    $j++;
                    echo '</tr>';
                    echo '<tr><td>Total </td> <td colspan="12" style="font-weight:bold;color:green;">' . $total . '</td></tr>';
                }
                ?>
                                    </table>
                                        <?php }
                                    }
                                    ?>
                        </li>
                    </ul>
                </li>
                                    <?php }
                                ?>
        </ul>
<?php } ?>
<?php
if ($defaultfrequency == '4') {
    ?>
        <table id="travel" width="auto" cellspacing="3" cellpadding="4">
            <tr>
                <th>Label</th>
                                <?php foreach ($yearly as $years):
                                    ?>
                    <th colspan="2"><?php echo $years; ?></th>
                                <?php endforeach;
                                ?>
            </tr>
                                <?php
                                for ($i = 0; $i < php72_count($yearreport); $i++) {
                                    echo '<tr>';
                                    echo '<td>' . $yearreport[$i]['label'] . '</td>';
                                    $yearcount = 0;
                                    foreach ($yearly as $years) {
                                        switch ($yearcount) {
                                            case 0:
                                                if (is_array($yearanswerreport0))
                                                    echo '<td class=" 4 ' . $years . '  ' . $yearanswerreport0[$i]['criteria'] . ' ' . $yearanswerreport1[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport0[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport0[$i]['criteria'] . '/' . $yearanswerreport0[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport0[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport0[$i]['document'] . '</a></td>';
                                                break;
                                            case 1:
                                                if (is_array($yearanswerreport1))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport1[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport1[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport1[$i]['criteria'] . '/' . $yearanswerreport1[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport2[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport1[$i]['document'] . '</a></td>';
                                                break;
                                            case 2:
                                                if (is_array($yearanswerreport2))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport2[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport2[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport2[$i]['criteria'] . '/' . $yearanswerreport2[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport2[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport2[$i]['document'] . '</a></td>';
                                                break;
                                            case 3:
                                                if (is_array($yearanswerreport3))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport3[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport3[$i]['answer'] . '</td>';
                                                echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport3[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport3[$i]['answer'] . '</td>';
                                                break;
                                            case 4:
                                                if (is_array($yearanswerreport4))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport4[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport4[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport4[$i]['criteria'] . '/' . $yearanswerreport4[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport4[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport4[$i]['document'] . '</a></td>';
                                                break;
                                            case 5:
                                                if (is_array($yearanswerreport5))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport5[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport5[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport5[$i]['criteria'] . '/' . $yearanswerreport5[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport5[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport5[$i]['document'] . '</a></td>';
                                                break;
                                            case 6:
                                                if (is_array($yearanswerreport6))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport6[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport6[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport6[$i]['criteria'] . '/' . $yearanswerreport6[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport6[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport6[$i]['document'] . '</a></td>';
                                                break;
                                            case 7:
                                                if (is_array($yearanswerreport7))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport7[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport7[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport7[$i]['criteria'] . '/' . $yearanswerreport7[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport7[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport7[$i]['document'] . '</a></td>';
                                                break;
                                            case 8:
                                                if (is_array($yearanswerreport8))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport8[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport8[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport8[$i]['criteria'] . '/' . $yearanswerreport8[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport8[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport8[$i]['document'] . '</a></td>';
                                                break;
                                            case 9:
                                                if (is_array($yearanswerreport9))
                                                    echo '<td class=" 4 ' . $years . ' 0 ' . $yearanswerreport1[$i]['criteria'] . ' ' . $yearanswerreport9[$i]['id'] . ' ' . $defaulttype . '">' . $yearanswerreport9[$i]['answer'] . '</td>';
                                                echo '<td class="browse"><a class="fancybox" href="' . site_url("incubationprogress/fileupload/" . $years . '/' . $yearanswerreport9[$i]['criteria'] . '/' . $yearanswerreport9[$i]['id'] . '/' . $defaulttype) . '">' . $yearanswerreport9[$i]['document'] == ' ' ? 'File Upload' : $yearanswerreport9[$i]['document'] . '</a></td>';
                                                break;
                                        }
                                        $yearcount++;
                                    }
                                    echo '</tr>';
                                }
                                ?>
        </table>
        <?php } ?>
        <?php
        if ($defaultfrequency == '3') {
            ?>
        <table id="travel" width="auto" class="gtable" cellspacing="3" cellpadding="4">
            <tr>
                <th>Label</th>
            <?php foreach ($quarterly as $quarters):
                ?>
                    <th><?php echo $quarters; ?></th>
            <?php endforeach;
            ?>
            </tr>
            <?php
            for ($i = 0; $i < php72_count($quarterlyreport); $i++) {
                echo '<tr>';
                echo '<td>' . $quarterlyreport[$i]['label'] . '</td>';
                $quartercount = 0;
                foreach ($quarterly as $quarters) {
                    switch ($quartercount) {
                        case 0:
                            if (is_array($quarterreport0))
                                echo '<td class="">' . $quarterreport0[$i]['answer'] . '</td>';
                            break;
                        case 1:
                            if (is_array($quarterreport1))
                                echo '<td  class="">' . $quarterreport1[$i]['answer'] . '</td>';
                            break;
                        case 2:
                            if (is_array($quarterreport2))
                                echo '<td  class="">' . $quarterreport2[$i]['answer'] . '</td>';
                            break;
                        case 3:
                            if (is_array($quarterreport3))
                                echo '<td  class="">' . $quarterreport3[$i]['answer'] . '</td>';
                            break;
                    }
                    $quartercount++;
                }
                echo '</tr>';
            }
            ?>
        </table>
        <?php } ?>

        <?php
        if ($defaultfrequency == '1') {
            ?>
        <table id="table1" width="auto" class="gtable" cellspacing="3" cellpadding="4">
            <tr>
                <th>Label</th>
            <?php foreach ($weekly as $weeks):
                ?>
                    <th><?php echo $weeks; ?></th>
            <?php endforeach;
            ?>
            </tr>
            <?php
            for ($i = 0; $i < php72_count($weekreport); $i++) {
                echo '<tr>';
                echo '<td>' . $weekreport[$i]['label'] . '</td>';
                $weekcount = 0;
                foreach ($weekly as $weeks) {
                    switch ($weekcount) {
                        case 0:
                            if (is_array($weekanswerreport0))
                                echo '<td class="">' . $weekanswerreport0[$i]['answer'] . '</td>';
                            echo '<td>Hello</td>';
                            break;
                        case 1:
                            if (is_array($weekanswerreport1))
                                echo '<td  class="">' . $weekanswerreport1[$i]['answer'] . '</td>';
                            break;
                        case 2:
                            if (is_array($weekanswerreport2))
                                echo '<td  class="">' . $weekanswerreport2[$i]['answer'] . '</td>';
                            break;
                        case 3:
                            if (is_array($weekanswerreport3))
                                echo '<td  class="">' . $weekanswerreport3[$i]['answer'] . '</td>';
                            break;
                        case 4:
                            if (is_array($weekanswerreport4))
                                echo '<td  class="">' . $weekanswerreport4[$i]['answer'] . '</td>';
                            break;
                        case 5:
                            if (is_array($weekanswerreport5))
                                echo '<td  class="">' . $weekanswerreport5[$i]['answer'] . '</td>';
                            break;
                    }
                    $weekcount++;
                }
                echo '</tr>';
            }
            ?>
        </table>
        <?php } ?>
</div>