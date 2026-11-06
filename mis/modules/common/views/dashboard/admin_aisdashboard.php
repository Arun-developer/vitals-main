<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/template/css/monthly.css" />
<div align="right"><a href="#" class="button" id="yearslideToggle" >Show Filter</a></div>
<div id="slidebox"  style="display:none;">
    <form name="frmgetMonth" id="frmgetMonth" action="<?php site_url('common/dashboard/admin_dashboard') ?>" method="post" >
        <br>
        <table cellpadding="4" cellspacing="7" class="inline" width="50%">
            <tr>
                <td><label for="" style="font-weight:bold;">From Year <span class="req_field">*</span></label></td>
                <td><input type="text" name="fromYear" value="" size="20"  class="Year required" /></td>
            </tr>
            <tr style="margin-top:8px;">
                <td><label for="" style="font-weight:bold;">To Year<span class="req_field">*</span></label></td>
                <td><input type="text" name="toYear" value="" size="20"  class="Year required" /></td>
            </tr>
        </table>
        <div class="buttons1" style="margin-left:155px;margin-top:10px;" >
            <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="reset" class="button white" value="Search" name="txtreset">Reset</button>
        </div>
    </form>
</div>
<h1><?php echo $cpagetitle; ?></h1>
<div class="mainBODY" >
    <div class="maibBODYlft"  >
        <!--End grid 1-->
        <!--grid 2-->
        <div class="grid2">
            <h2>Seed Funding</h2>
            <div class="sourceReport">
                <table width="100%" class="girdBOX" cellspacing="3" cellpadding="4">
                    <thead>
                        <tr>
                            <th class="head headLARGE">Name of Incubatee</th>
                            <th class="head headLARGE">Total Fund Disbursed</th>
                            <th class="head headLARGE">Total Fund Approved</th>
                            <th class="head headLARGE">Total Fund Utilized</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (php72_count($allfunddisbursed)) {
                            $i = 'odd';
                            foreach ($allfunddisbursed as $row):
                                $i = ($i == 'odd') ? 'even' : 'odd';
                                ?>
                                <tr class="<?= $i ?>">
                                    <td><a href="<?php echo site_url('incubator_metrics/wglobal_report/index/' . $row['id'] . '/2') ?>">
                                            <?= $row['name_of_enterprise'] ?>
                                        </a></td>
                                    <td><?= $row['amount'] ?></td>
                                    <td><?= $row['approved_amount'] ?></td>
                                    <td><?= $row['fund_utilized'] ?></td>
                                </tr>
                                <?php
                                $total += $row['amount'];
                                $total_approved += $row['approved_amount'];
                                $total_utilized += $row['fund_utilized'];
                            endforeach;
                            ?>
                            <tr>
                                <td>Total :</td>
                                <td style="font-weight:bold;"><?= $total; ?></td>
                                <td style="font-weight:bold;"><?= $total_approved; ?></td>
                                <td style="font-weight:bold;"><?= $total_utilized; ?></td>
                            </tr>
                            <?php
                        }
                        else {
                            ?>
                            <tr class="odd">
                                <td colspan="10" align="center">No Records</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="grid3">
            <h2>Mentor:</h2>
            <table width="100%" class="girdBOX" cellspacing="3" cellpadding="4">
                <thead>
                    <tr>
                        <th class="head headLARGE">Name of Incubatee</th>
                        <th class="head headLARGE">Company</th>
                        <th class="head headLARGE">Total Time spend(In Hours)</th>
                        <th class="head headLARGE">Value (INR)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (php72_count(php72_cmp($mentordetails) != 0)) {
                        foreach ($mentordetails as $row):
                            ?>
                            <tr>
                                <td><?= $row['name_of_enterprise'] ?></td>
                                <td><?= $row['company'] ?></td>
                                <td><?= $row['mentorhours'] ?></td>
                                <td><?= $row['mentormoney'] ?></td>
                            </tr>
                            <?php
                        endforeach;
                    }
                    else {
                        ?>
                        <tr class="odd">
                            <td colspan="10" align="center">No Records</td>
                        </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
        <div class="grid8">
            <div class="boxNotice fr" style="width:613px; margin-top:10px;">
<?php
$header = NULL;
$td = '<table id="table1" class="girdBOX" width="100%" class="gtable" cellspacing="3" cellpadding="4">';
$td .= '<th class="head headLARGE">Amout</th>';
$td .= '<th class="head headLARGE">Reqeusted Date</th>';
$td .= '<th class="head headLARGE">Innovation</th>';
$this->load->model('common/Mincubation_reports');
foreach ($seedfunding_report as $row) {
    $td.="<tr>";
    $td.="<td>" . $row['amount'] . "</td>";
    $td.="<td>" . $row['date'] . "</td>";
    $td.="<td>" . $row['name_of_enterprise'] . "</td>";
    $td.="<td></td>";
    $td.="</tr>";
}
$td .= '</table>';
echo $td;
?>
            </div>
        </div>
        <div class="grid9">
            <div class="boxNotice fr" style="width:613px; margin-top:10px;"> </div>
        </div>
        <div class="grid1">
            <div class="boxNotice" style="width:613px;">
<?php
$header = NULL;
$td = '<table id="table1" width="100%" class="girdBOX"  cellspacing="3" cellpadding="4">';
$td .= '<th class="head headLARGE">Participant Type</th>';
$td .= '<th class="head headLARGE">Participant Name</th>';
$td .= '<th class="head headLARGE">Participant Status</th>';
$td .= '<th class="head headLARGE">Organization</th>';

foreach ($training_report as $row) {
    $td.="<tr>";
    $td.="<td>" . $row['participant_type'] . "</td>";
    $td.="<td>" . $row['participant_name'] . "</td>";
    $td.="<td>" . $row['participant_status'] . "</td>";
    $td.="<td>" . $row['participant_organization'] . "</td>";
    $td.="<td></td>";
    $td.="</tr>";
}
$td .= '</table>';
echo $td;
?>
            </div>
        </div>
    </div>
    <div class="maibBODYRHT" >
        <!-- Grid 4-->
        <div class="grid4 ">
            <h2>Repayment:</h2>
            <table width="100%" class="girdBOX" cellspacing="3" cellpadding="4">
                <thead>
                    <tr>
                        <th class="head headLARGE">Name of Incubatee</th>
                        <th class="head headLARGE">Total Repayment amount</th>
                    </tr>
                </thead>
                <tbody>
<?php
if (php72_count($allrepayment)) {
    $i = 'odd';
    foreach ($allrepayment as $row):
        $i = ($i == 'odd') ? 'even' : 'odd';
        ?>
                            <tr class="<?= $i ?>">
                                <td><a href="<?php echo site_url('incubator_metrics/wglobal_report/index/' . $row['id'] . '/2') ?>">
                            <?= $row['name_of_enterprise'] ?>
                                    </a></td>
                                <td><?= $row['amount'] ?></td>
                            </tr>
                                        <?php endforeach; ?>
                        <tr>
                            <td>Total :</td>
                        <?php foreach ($repayment as $row): ?>
                                <td><?= $row['total']; ?></td>
                        <?php endforeach; ?>
                        </tr>
                            <?php
                        }
                        else {
                            ?>
                        <tr class="odd">
                            <td colspan="10" align="center">No Records</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- END Grid 4-->
        <!-- Grid 5-->
        <div class="grid5">
            <h2>Incubation Services:</h2>
<?php
$td = '<table width="100%" style="cellspacing:3px; cellpadding:4px;" class="girdBOX"  >';
$td .= '<th  style="padding:5px;" class="head headLARGE">Service Offerings</th>';
$td .= '<th class="head headLARGE ">Total</th>';
$td .= '<th class="head headLARGE ">Accpet</th>';
$td .= '<th class="head headLARGE ">Reject</th>';

$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;'>" . "Media" . "</td>";
$td.="</tr>";
foreach ($mediaDetails as $media) {
    $td.="<tr>";
    $td.="<td>" . $media['name_of_enterprise'] . "</td>";
    $td.="<td>" . $media['total'] . "</td>";
    $td.="<td>" . $media['accept'] . "</td>";
    $td.="<td>" . $media['reject'] . "</td>";
    $td.="</tr>";
}


$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;'>" . "Board Formation" . "</td>";
$td.="</tr>";
//show($boardDetails);
foreach ($boardDetails as $board) {

    $td.="<tr>";
    $td.="<td>" . $board['name_of_enterprise'] . "</td>";
    $td.="<td>" . $board['total'] . "</td>";
    $td.="<td>" . $board['accept'] . "</td>";
    $td.="<td>" . $board['reject'] . "</td>";
    $td.="</tr>";
}

$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;'>" . "Fellow	" . "</td>";
$td.="</tr>";
$td.="<tr>";
foreach ($felowDetails as $felow) {

    $td.="<tr>";
    $td.="<td>" . $felow['name_of_enterprise'] . "</td>";
    $td.="<td>" . $felow['total'] . "</td>";
    $td.="<td>" . $felow['accept'] . "</td>";
    $td.="<td>" . $felow['reject'] . "</td>";
    $td.="</tr>";
}
$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;'>" . "Raise Investment" . "</td>";
$td.="</tr>";
foreach ($investerDetails as $invester) {

    $td.="<tr>";
    $td.="<td>" . $invester['name_of_enterprise'] . "</td>";
    $td.="<td>" . $invester['total'] . "</td>";
    $td.="<td>" . $invester['accept'] . "</td>";
    $td.="<td>" . $invester['reject'] . "</td>";
    $td.="</tr>";
}
$td.="<tr>";
$td.="<td colspan='4' style='background-color:#dce7cc;border:1px solid #B9CE98;'>" . "Access To Naukri " . "</td>";
$td.="</tr>";
$td.="<tr>";
foreach ($applicantDetails as $applicant) {

    $td.="<tr>";
    $td.="<td>" . $applicant['name_of_enterprise'] . "</td>";
    $td.="<td>" . $applicant['total'] . "</td>";
    $td.="<td>" . $applicant['accept'] . "</td>";
    $td.="<td>" . $applicant['reject'] . "</td>";
    $td.="</tr>";
}
$td .= '</table>';
echo $td;
?>
        </div>
        <!-- END Grid5-->
        <div class="grid6">
            <div class="boxNotice fr" style="width:583px;">
                <h2>Exit Innovations</h2>
            <?php
            $header = NULL;
            $td = '<table id="table1" class="girdBOX" width="100%" class="gtable" cellspacing="3" cellpadding="4">';
            $td .= '<th class="head headLARGE">Amout</th>';
            $td .= '<th class="head headLARGE">Stage</th>';
            $td .= '<th class="head headLARGE">Innovation</th>';
            $td .= '<th class="head headLARGE">Date</th>';
            foreach ($allrepayment as $row) {
                $td.="<tr>";
                $td.="<td>" . $row['amount'] . "</td>";
                $td.="<td>" . $row['stage'] . "</td>";
                $td.="<td>" . $row['name_of_enterprise'] . "</td>";
                $td.="<td>" . $row['from_date'] . "</td>";
                $td.="</tr>";
            }
            $td .= '</table>';
            echo $td;
            ?>
            </div>
        </div>
        <div class="grid7">
                <?php
                $td = '<table class="girdBOX" style="width:588px;" cellspacing="3" cellpadding="4">';
                $td .= '<th class="head headLARGE grid5Hei">Exit Criteria</th>';
                $td .= '<th class="head headLARGE grid5Hei">Year</th>';
                $td .= '<th class="head headLARGE grid5Hei">Target</th>';
                $td .= '<th class="head headLARGE grid5Hei">Achevied</th>';

                $td .= '<tr>';
                $td .= '<td style="background-color:#dce7cc;border:1px solid #B9CE98;">' . "Board Meeting" . '</a></td>';
                $td .= '</tr>';
                if (!empty($exitDetails)) {
                    if (php72_count($exitDetails) == '4') {
                        foreach ($exitDetails as $row)
                            $td .= '<tr>';
                        $td .= '<td>' . $row['name_of_enterprise'] . '</td>';
                        $td .= '<td>' . $row['exitDate'] . '</td>';
                        $td .= '<td>' . '4' . '</td>';
                        $td .= '<td style="color:green;font-weight:bold;">' . $exitDetails . '</a></td>';
                        $td .= '</tr>';
                    } else {
                        $td .= '<tr>';
                        $td .= '<td>' . $row['name_of_enterprise'] . '</td>';
                        $td .= '<td>' . $row['exitDate'] . '</td>';
                        $td .= '<td>' . '4' . '</td>';
                        $td .= '<td style="color:red;font-weight:bold;">' . php72_count($exitDetails) . '</td>';
                        $td .= '</tr>';
                    }
                }

                $td .='<tr>';
                $td .='<td style="background-color:#dce7cc;border:1px solid #B9CE98;">' . "Raise Investment" . '</a></td></tr>';
                if (!empty($raiseinvestment)) {
                    foreach ($raiseinvestment as $row) {
                        if ($row['amount'] == $row['amount_approved']) {
                            $td .= '<td style="color:green;font-weight:bold;">' . $row['amount_approved'] . '</a></td>';
                        }
                        $td .= '<tr>';
                        $td .= '<td>' . $row['name_of_enterprise'] . '</td>';
                        $td .= '<td>' . date('Y') . '</td>';
                        $td .= '<td>' . $row['amount'] . '</td>';
                        $td .= '<td>' . $row['amount_approved'] . '</td>';
                    }
                }
                $td .='</tr>';
                $td .= '<tr>';

                $td .= '</tr>';
                $td .= '</table>';


                echo $td;
                ?>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>source/template/css/monthly.css" />
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    #slidebox	{
        padding:8px;
        margin:16px;
        border:1px solid #808080;
        height:133px;
    }
    .mainBODY{
        display: inline-block;
        height: 100%;
        min-height: 200px;
        width: 100%;
    }
    .maibBODYlft, .maibBODYRHT{ width:49%; height:100%; min-height:400px; float:left; }
    .maibBODYRHT{float:right;}
    .grid5{}
    .grid5 td, .grid4 td, .grid6 td, .grid7 td, .grid2 td{ padding:5px;}
    .grid5Hei{ height:25px;}

</style>
<script language="JavaScript" src="<?= base_url() ?>source/charts/FusionCharts.js"></script>
<script type="text/javascript">
    var chart = new FusionCharts("<?= base_url() ?>source/charts/Column3D.swf", "ChartId", "500", "250", "0", "0");
    chart.setXMLUrl("<?= base_url() ?>source/charts/data/funddisbursed.xml");
    chart.render("sourceWiseChart");
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".togglePanel").hide();
        $("#frmgetMonth").validate();
        $("tr:odd").css("background-color", "#EEFCE9");
        $("tr:even").css("background-color", "white");

        $("#expandSlide").click(function () {
            $('.togglePanel').slideToggle("slow");
        });
    });

</script>
<script type="text/javascript">
    var chart = new FusionCharts("<?= base_url() ?>source/charts/ScrollLine2D.swf", "ChartId", "467", "300", "0", "0");
    chart.setXMLUrl("<?= base_url() ?>source/charts/data/monthlyReport.xml");
    chart.render("generalChart");

    $(document).ready(function () {

        $(function () {
            $(".Year").datepicker({
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy',
                onClose: function (dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year));
                }
            });

            $("#yearslideToggle").click(function () {
                $('#slidebox').slideToggle("slow");

            });
        });

    });
</script>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    #slidebox	{
        padding:8px;
        margin:16px;
        border:1px solid #808080;
        height:123px;
    }

</style>
