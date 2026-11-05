<div class="row dataconfig d_v_d_c">
    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
        <!-- <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back </a></span> -->
        <h4><?php echo $enterprise_name . ' - ' . $title; ?></h4>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
        <ul class="vitals-links">
            <li><a href="javascript:void(0)" class="edt_btnVital" onclick="showLog();"><span><i class="far fa-file-alt"></i></span> Application Status Log</a></li>
            <!--<li><a href="javascript:void(0)" class="edt_btnVital" id="assign_incharge"><span><i class="fas fa-user-check"></i></span> Assign User</a></li>-->
            <?php if ($title == 'Detailed Assessment') { ?>
                <li><a href="<?php echo base_url() . 'index.php/detailed_diligence/export_ppt/INV' . $application_id; ?>" class="edt_btnVital"><span><i class="fa fa-download" aria-hidden="true"></i></span> Export as PPT</a></li>
                <li><a href="<?php echo base_url() . 'index.php/application/export_assessment/INV' . $application_id; ?>" class="edt_btnVital"><span><i class="fa fa-download" aria-hidden="true"></i></span> Export as Word</a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="tab-slider--container tab-content">
    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
        <main class="page-content">
            <div class="dealsFixedHeader">
                <div class="row d_v_s_L">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <ul class="vitals-links">
                            <?php $inc_name = strlen($enterprise_name) > 15 ? substr($enterprise_name, 0, 15) . "..." : $enterprise_name; ?>
                            <li>Incubatee name: <b><?= $inc_name; ?></b></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <ul class="vitals-links">
                            <li>Inv ID: <b><?= $inv_id; ?></b></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <ul class="vitals-links">
                            <li>Sector: <b><?= $sector; ?></b></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <ul class="vitals-links">
                            <?php $sub_sector_name = strlen($sub_sector) > 15 ? substr($sub_sector, 0, 15) . "..." : $sub_sector; ?>
                            <li title="<?= $sub_sector; ?>">Sub Sector: <b><?= $sub_sector_name; ?></b></li>
                        </ul>
                    </div>
                </div>
                <div class="row d_v_s_L">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <ul class="vitals-links">
                            <li>Stage: <b><?= $stage; ?></b></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <ul class="vitals-links">
                            <li>Assigned To: <b><?= $assign_to; ?></b></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                        <ul class="vitals-links">
                            <li>Status: <b><?= $status; ?></b></li>
                        </ul>
                    </div>
                    <!--                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 ">
                                            <ul class="vitals-links">
                                                <li>Action: <b>close <a href=""><i class="fas fa-pencil-alt">_</i></a></b></li>
                                            </ul>
                                        </div>-->
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade newdealmodal" id="form_employeelist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="assign" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $associate_employee = isset($_REQUEST["associate_employee"]) ? $_REQUEST["associate_employee"] : array();

                    if ($_POST['branch_name'] != '') {
                        $userSetup1 = $this->Mmaster->getUserSetup_branch($_POST['branch_name']);
                        if ($userSetup1['abi'] != '') {
                            $usersList_incharge = $this->Muser->getUsersList($userSetup1['abi']);
                        }
                        ?>
                        <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">

                            <?php
                            foreach ($usersList_incharge as $row) {
                                ?>
                                <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                            <?php }
                            ?>
                        </select>
                    <?php } else { ?>
                        <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                            <?php
                            foreach ($usersList as $row) {
                                ?>
                                <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                            <?php }
                            ?>
                        </select>
                    <?php } ?>
                    <input type="hidden" name="innovations" id="innovation_id" />
                </div>
                <div class="modal-footer">
                    <i class="fa fa-spinner fa-spin hidden_cls" id='showSpinner'></i>&nbsp;
                    <input type="button" name="txtSubmit" class="btn btn-success" value="Submit" id="txtsub" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="logModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title">
                    <span class="text-success"><i class="far fa-file-alt"></i></span> Application Status Log - Deals
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body onboarding-permission text-center vitalMasterDataTbl">
                <table style="width:100%" id="table1" class="gtable dataTable sortable">
                    <thead style="border-bottom: 2px solid #ccc;">
                        <tr>
                            <th style="padding:5px;text-align: left;">Date</th>
                            <th style="padding:5px;text-align: left;">Time</th>
                            <th style="padding:5px;text-align: left;">Assigned Incharge</th>
                            <th style="padding:5px;text-align: left;">Updated By</th>
                            <th style="padding:5px;text-align: left;">Deal Stage</th>
                            <th style="padding:5px;text-align: left;">Deal Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($log_details as $row) {
                            $date = date('d-m-Y', strtotime($row['modified_date']));
                            $time = date('h:i A', strtotime($row['modified_date']));

                            $stage = $this->Minnovation->getInnvationStage();
                            $status = $this->Minnovation->getInnvationStatus();
                            $status_text = $status[$row['status']];
                            $stage_text = $stage[$row['stage']];
                            ?>

                            <tr>
                                <?php
                                if ($row['reason'] != '') {
                                    ?>
                                    <td colspan="6" style="padding:5px;text-align:center;font-weight:bold;"><?php echo $row['reason']; ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td style="padding:5px;"><?php echo $date; ?></td>
                                    <td style="padding:5px;"><?php echo $time; ?></td>
                                    <td style="padding:5px;" title="<?php echo $row['assigned_incharge']; ?>"><?php echo strlen($row['assigned_incharge']) > 15 ? substr($row['assigned_incharge'], 0, 15) . ".." : $row['assigned_incharge']; ?></td>
                                    <td style="padding:5px;"><?php
                                        if ($row['modified_by_user'])
                                            echo $row['modified_by_user'];
                                        else
                                            echo 'Admin';
                                        ?></td>
                                    <td style="padding:5px;"><?php echo $stage_text; ?></td>
                                    <td style="padding:5px;"><?php echo $status_text; ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if ($innovation['status'] != '3' && $innovation['isAssociate']) { ?>
    <div class="inv-detail-status">
        <div class="row">
            <div class="col-12">
                <ul>
    <!--                    <li><strong>Action</strong> :</li>
                    <li>
                        <select name="changeStatus" class="form-control" id="changeStatus">
                    <?php if ($app_stage == '7') { ?>
                                                                                                                                                                                                                <option value="1">Approve for PA/RD</option>
                    <?php } ?>
                            <option value="24">Open-Banked</option>
                            <option value="3">Close</option>
                        </select>
                    </li>
                    <li> <button type="button" id="save_action" class="btn vital_green_btn">Save</button></li>-->
                    <form>
                        <li><strong>Action</strong> :</li>
                        <li><select id="action_value" class="form-control">
                                <option value="1">Close</option>
                                <option value="2" <?php
                                if ($innovation['status'] == '17') {
                                    echo 'selected';
                                }
                                ?>>EIC Approve</option>
                                <option value="3" <?php
                                if ($innovation['status'] == '18') {
                                    echo 'selected';
                                }
                                ?>>EIC Reject</option>
                                        <?php if ($innovation['status'] == '17' || $innovation['status'] == '20') { ?>
                                    <option value="4" <?php
                                    if ($innovation['status'] == '20') {
                                        echo 'selected';
                                    }
                                    ?>>Final Negotiation</option>
                                        <?php } ?>
                            </select></li>
                        <li><button type="button" id="save_action" class="btn vital_green_btn">Save</button></li>
                    </form>
                </ul>
            </div>
        </div>
    </div>
    <?php
} else if ($innovation['status'] == '3') {
    $empName = $this->Sector_model->getEmployeeNameByID($innovation['modified_by']);
    $cmnts = isset($innovation['comments']) && $innovation['comments'] != '' ? $innovation['comments'] : '-N/A-';
    ?>
    <div class="inv-detail-status">
        <div class="row">
            <div class="col-12">
                <ul class="text-left">
                    <li><strong>Reason</strong> : <?php echo $innovationDetails[0]['reasons_title']; ?></li>
                    <li title='<?php echo $cmnts; ?>'><strong>Comments</strong> : <?php echo mb_strimwidth($cmnts, 0, 75, '...'); ?>
                    </li>
                    <li><strong>Closed By</strong> : <?php echo $empName['emp_name']; ?></li>
                </ul>
            </div>
        </div>
    </div>

<?php } ?>

<div class="modal" id="actionModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('scouting/assignInchargeInView'); ?>" id="assign" method="post">
                <div class="modal-header">
                    <h5 class="modal-title text-center">
                        Please select user who will do the Preliminary Assessment scoring on this deal from the list below
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                            style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                                <?php
                                foreach ($usersList as $row) {
                                    ?>
                            <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                        <?php }
                        ?>
                    </select>
                    <input type="hidden" name="innovations" id="innovations" />
                    <br /><br />
                    <div>
                        <input type="submit" class="button" value="Submit" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="commentModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100">Close/Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="actionForm" id="actionForm" action="<?php echo base_url() . 'index.php/application/saveAction/' . $application_id; ?>" method="post">
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>Status <span>*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 col-md-8">
                            <div class="form-group">
                                <select style="pointer-events: none !important;"  name="status" id="act_status" class="form-control required">
                                    <option value="">-Select-</option>
                                    <option value="24">Open-Banked</option>
                                    <option value="3">Close</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>Reasons <span>*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 col-md-8">
                            <div class="form-group">
                                <select name="reasons" id="act_reasons" class="form-control required">
                                    <option value="">-Select-</option>
                                    <?php foreach ($reasonsList as $row): ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['master_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>Comments <span>*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 col-md-8">
                            <div class="form-group">
                                <textarea name="comments" id="act_comments" class="form-control input-text required" cols="30" rows="5" placeholder="Enter comments"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <input type="reset" value="Reset" name="txtReset" class="vital_bordered_btn wdt_100" />
                        <input type="submit" value="Submit" class="vital_yellow_btn wdt_100" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="EICdateField" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100">Select <span id='eic_title'></span> Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="EICactionForm" id="EICactionForm" action="" method="post" autocomplete="off">
                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label>Choose date <span>*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8 col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="status_change_date" id="status_change_date" placeholder="dd-mm-yyyy" value="<?= $eic_date; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="buttons">
                        <input type="submit" id="dateSubmit" value="Submit" class="vital_yellow_btn wdt_100" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

<style type="text/css">
    .inv-detail-status{
        padding: 0px 0 10px;
    }
    .inv-detail-status ul{
        list-style: none;
        padding-left: 10px;
        text-align: right;
        margin-bottom: 0;
    }
    .inv-detail-status ul li{
        display: inline-block;
        padding: 0 5px;
    }
    .vital_green_btn{
        padding: 4px 30px !important;
        margin:0;
    }
    .dealsFixedHeader .row:first-child{
        padding-bottom: 15px;
    }
    .tab-slider--body{
        margin-bottom: 0;
    }
</style>

<script type="text/javascript">

    $(document).ready(function () {
        $("#status_change_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy'
        });

        var date = $('#status_change_date').val();
        if (date == '01-01-1970' || date == '') {
            $("#status_change_date").datepicker("setDate", new Date());
        }
    });

    function showLog() {
        $('#logModal').modal('show');
    }

    function comment_populate() {
        var action = $('#changeStatus').val();
        $('#act_status').val(action);
    }

    $('#actionForm').validate({
        rules: {
            "status": "required",
            "reasons": "required",
            "comments": "required",
        },
        messages: {
            "status": "Select status",
            "reasons": "Select reasons",
            "comments": "Enter comments"
        }
    });

    $('#EICactionForm').validate({
        rules: {
            "status_change_date": "required"
        },
        messages: {
            "status_change_date": "Select date"
        }
    });

    $('#save_action').on('click', function () {
        var action_val = $('#action_value').val();
        changeAction(action_val);
    });

    function changeAction(txt) {
        if (txt == 2) {
            $('#eic_title').html('EIC Approved');
        } else if (txt == 3) {
            $('#eic_title').html('EIC Reject');
        } else if (txt == 4) {
            $('#eic_title').html('Final Negotiation');
        }

        if (txt == 2 || txt == 3 || txt == 4) {
            $('#EICdateField').modal('show');
        } else {
            $('#commentModal').modal('show');
            comment_populate();
        }
    }

    $(document).on('click', '#dateSubmit', function () {
        if ($('#EICactionForm').valid()) {
            var action_value = $('#action_value').val();
            var new_date = $('#status_change_date').val();
            var invID = "<?php echo $innovation['id']; ?>";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/scouting/eir_action",
                data: {id: invID, action: action_value, action_date: new_date},
                dataType: 'json',
                success: function (msg) {
                    location.reload();
                },
            });
        }
    });

</script>