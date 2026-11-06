<?php
$independent_shortlist = $this->session->userdata('independent_shortlist');
$role_id = $this->session->userdata('role_id');
?>

<div class="row dataconfig d_v_d_c">
    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
        <!-- <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back </a></span> -->
        <h4><?php
        if ($lang_code == 'hi') {
            echo $enterprise_name_hi;
        } else {
            echo $enterprise_name;
        }
        ?></h4>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
        <ul class="vitals-links">
            <?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || php72_in_array($this->session->userdata('emp_number'), $assign_incharge_id)) { ?>
                <?php if ($program == '0' || $program == '11') { ?>
                    <li class="edit"><a href="javascript:void(0);" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="plan-structure-vital vital_windowScroll dealsFixedHeader">
    <div class="row dataconfig d_v_s_L">
        <div class="col-xl-5 col-lg-5 col-md-5 col-12 pad-none">
            <ul class="vitals-links">
                <li>Stage: <b><?= $stage; ?></b></li>
                <li>Status: <b><?= $status; ?></b></li>
            </ul>
            <?php if ($role_id != '4') { ?>
                <br>
                <ul class="vitals-links">
                    <li>Assigned To: <b><?= $incharge; ?></b></li>
                </ul>
            <?php } ?>
        </div>
        <?php if ($application_id != '') { ?>
            <div class="col-xl-7 col-lg-7 col-md-7 col-12 pad-none text-right">
                <ul class="vitals-links">
                    <li><a href="javascript:void(0)" class="edt_btnVital" onclick="showLog();"><span><i class="far fa-file-alt"></i></span> Application Status Log</a></li>
                    <li><a href="javascript:void(0)" class="edt_btnVital" onclick="attachmentDownload('<?= $application_id; ?>', '<?= $program; ?>', '<?= $doc1; ?>', '<?= $doc2; ?>', '<?= $doc3; ?>');"><span><i class="fas fa-download"></i></span> Export</a></li>
                    <!--<li><a href="javascript:void(0)" class="edt_btnVital"><span><i class="far fa-times-circle"></i></span> Close Deal</a></li>-->
                    <li><a href="javascript:void(0)" class="edt_btnVital" onclick="showComments();"><span><i class="far fa-comment"></i></span> Shortlist / Comments</a></li>
                    <?php if ($program == '3' && $lang_code == 'hi' && $this->uri->segment(4) == '') { ?>
                        <li><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id . '/hi'; ?>" class="edt_btnVital"><span><i class="far fa-file-alt"></i></span> Hindi</a></li>
                    <?php } else if ($program == '3' && $this->uri->segment(4) == 'hi') { ?>
                        <li><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>" class="edt_btnVital"><span><i class="far fa-file-alt"></i></span> English</a></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
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
                                    <option value="<?= $row['emp_number']; ?>"><?= $row['emp_name']; ?></option>
                                <?php }
                                ?>
                            </select>
                        <?php } else { ?>
                            <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                                <?php
                                foreach ($usersList as $row) {
                                    ?>
                                    <option value="<?= $row['emp_number']; ?>"><?= $row['emp_name']; ?></option>
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

    <div class="modal" id="logComments" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content data_congifpopup">
                <div class="modal-header text-center">
                    <h5 class="modal-title">
                        <span class="text-success"><i class="far fa-file-alt"></i></span> Comments Log
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body onboarding-permission text-center vitalMasterDataTbl">
                    <?php if ($independent_shortlist == '1' && $role_id == '4') { ?>
                        <form name="comment_form" id="comment_form" method="post" action="<?php echo base_url() . 'index.php/application/save_comments'; ?>" autocomplete="off" enctype="multipart/form-data" novalidate="novalidate">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                    <div class="form-group textleft">
                                        <label>Status<span>*</span></label>
                                        <select name="comment_status"  id="comment_status" class="form-control">
                                            <option value="">--Select Status--</option>
                                            <option value="12">Open</option>
                                            <option value="3">Closed</option>
                                            <option value="2">On Hold</option>
                                            <option value="25">Shortlisted</option>
                                            <option value="26">Selected</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="application_type" id="application_type" value="1" />
                                <input type="hidden" name="application_id" value="<?php echo $application_id; ?>">

                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                    <div class="form-group textleft">
                                        <label>Comments<span>*</span></label>
                                        <textarea class="form-control" name="comment" id="comment" placeholder="Enter comments"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label> <span>  </span></label>
                                        <li style="list-style-type:none;" ><a class="vital_yellow_btn wdt_100" id="submit_form">Save</a></li>
                                    </div>
                                </div>
                            </div>
                        </form>

                    <?php } ?>

                    <table style="width:100%" id="table1" class="gtable dataTable sortable">
                        <thead style="border-bottom: 2px solid #ccc;">
                            <tr>
                                <th style="padding:5px;text-align: center;">Date</th>
                                <th style="padding:5px;text-align: center;">Added By</th>
                                <th style="padding:5px;text-align: center;">Comments</th>
                                <th style="padding:5px;text-align: center;">Status</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $status_array = array('12' => 'Open', '3' => 'Closed', '2' => 'On Hold', '25' => 'Shortlisted', '26' => 'Selected');
                            if (php72_cmp($this->session->userdata('independent_shortlist')) == 1 && php72_cmp($this->session->userdata('role_id')) == 4) {
                                $emp_comment = $this->session->userdata['emp_number'];
                            } else {
                                $emp_comment = '';
                            }
                            $shortlist_comment = $this->Minnovation->getShortlistComments($application_id, $emp_comment);

                            if (php72_count($shortlist_comment) > 0) {
                                foreach ($shortlist_comment as $row) {
                                    $date = date('d-m-Y', strtotime($row['created_date']));
                                    $created_by = $row['created_by'];
                                    $comments = $row['comments'];
                                    $userArr = $this->Mapplication->getEmpFirstName($created_by);

                                    $application_status = $status_array[$row['application_status']];
                                    $username = $userArr[0]['emp_first_name'];
                                    ?>

                                    <tr>
                                        <td style="padding:5px;"><?php echo $date; ?></td>
                                        <td style="padding:5px;"><?php echo $username; ?></td>
                                        <td  width="60%" style="padding:5px;text-align: center !important;" class="table-td-align"><?php echo $comments; ?></td>
                                        <td style="padding:5px;"><?php echo $application_status; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4" style=" text-align: center;">No Record Found</td>
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
                        <li><strong>Action</strong> :</li>
                        <li>
                            <select name="changeStatus" class="form-control" id="changeStatus">
                                <?php if ($app_stage == '7') { ?>
                                    <option value="1">Approve for PA/RD</option>
                                <?php } ?>
                                <option value="24">Open-Banked</option>
                                <option value="3">Close</option>
                            </select>
                        </li>
                        <li> <button type="button" id="save_action" class="btn vital_green_btn">Save</button></li>
                    </ul>
                </div>
            </div>

        </div>
        <?php
    } else if ($innovation['status'] == '3') {
        if ($this->session->userdata('role_id') != '4' && php72_cmp($this->session->userdata('independent_shortlist')) != 1) {
            $empName = $this->Sector_model->getEmployeeNameByID($innovation['modified_by']);
            $cmnts = isset($innovation['comments']) && $innovation['comments'] != '' ? $innovation['comments'] : '-N/A-';
            ?>
            <div class="inv-detail-status">
                <div class="row">
                    <div class="col-12">
                        <ul class="text-left vitals-links">
                            <li>Reason: <b><?php echo $innovationDetails[0]['reasons_title']; ?></b></li>
                            <li title='<?php echo $cmnts; ?>'>Comments: <b><?php echo mb_strimwidth($cmnts, 0, 75, '...'); ?></b></li>
                            <li>Closed By: <b><?php echo $empName['emp_name']; ?></b></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>

    <div class="modal" id="actionModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo site_url('application/assignInchargeInView'); ?>" id="assign" method="post">
                    <div class="modal-header">
                        <div class="text-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="text-center">
                            <h5 class="modal-title text-center">
                                Please select user who will do the Preliminary Assessment scoring on this deal from the list below
                            </h5>
                        </div>
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

                    <div class="asseSummary_btns">
                        <input type="reset" value="Reset" name="txtReset" class="vital_bordered_btn wdt_100" />
                        <input type="submit" value="Submit" class="vital_yellow_btn wdt_100" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .inv-detail-status{
        padding: 15px 0 10px;
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
</style>
