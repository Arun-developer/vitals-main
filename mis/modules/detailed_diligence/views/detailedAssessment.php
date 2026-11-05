<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Villgro</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <!-- Rejection mail triggering on close action -->
    <?php
    $innovationID = $innovation['id'];
    $formAction = site_url('common/mail/form/' . $innovationID);
    ?>

    <div style="display:none;">
        <div align="center" id="mail_trigger" style="width:420px; height:180px;" >

            <h1 class="text-left reduce_space">Mail Confirmation</h1>
            <div>
                <p class="mailTriggerHead">Would you like to send the rejection email to the entrepreneur?</p>
                <p class="mailTrigger">Click OK to be redirected to the mailing section.</p>
                <p class="mailTrigger">Click Cancel to manually perform this operation later.</p>
                <div style="margin-top:20px;">
                    <a onclick="document.getElementById('templateForm').submit();" class="button triggerBtn">Ok</a>
                    <a onclick="$.fancybox.close()" class="button triggerBtn" id="mailTriggerCancel">Cancel</a>
                </div>
            </div>

        </div>
    </div>

    <a id="close_mail" class="fancybox button" href="#mail_trigger" style="display:none;"></a>


    <form name="templateForm" enctype="multipart/form-data" action="<?= $formAction ?>" method="post" id="templateForm" class="uniform" >
        <input type="hidden" name="innovation" value="<?= $innovation['id'] ?>"  />
        <input type="hidden" name="mail_type" value="Rejection"  />
    </form>


    <script>
        $(window).on('load', function () {
            var close_action = "<?php echo $this->session->userdata('close_action'); ?>";
            if (close_action == 'yes') {
                $("#close_mail").trigger('click');
            }
        });
    </script>
    <?php echo $this->session->unset_userdata('close_action'); ?>

    <body>

        <?php
        $suc_msg = $this->session->userdata['detail_sucmsg'];
        ?>

        <div id="form_employeelist" style="display:none;">
            <div align="center" id="form_container" style="height:400px;" >

                <form action="<?php echo site_url('scouting/onlyAssignIncharge'); ?>" id="assign" method="post">

                    <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1"  name="associate_employee[]">
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                            <option value="<?= $row['emp_number'] ?>" ><?= $row['emp_name'] ?></option>
                        <?php }
                        ?>
                    </select>
                    <input type="hidden" name="dilegence" id="dilegence" value="1" />
                    <input type="hidden" name="innovations" id="innovations" />
                    <input type="hidden" name="form_name" id="form_name" value="dilegence" />
                    <br/><br/>
                    <div >
                        <input type="submit" name="txtSubmit" class="button" id="txtsub" value="Submit"/>
                    </div>
                </form>
            </div>
        </div>





        <div style="display:none;">
            <div align="center" id="status_log" style="width:800px; height:400px;" >

                <h1 class="text-left reduce_space">Application Status Log - Deals </h1>

                <table style="width:100%" id="table1" class="gtable sortable">
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
                                    <td style="padding:5px;"><?php echo $row['assigned_incharge']; ?></td>
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

        <div style="display:none;">
            <div align="center" id="version_list" style="width:800px; height:400px;" >

                <h1 class="text-left reduce_space">Version List</h1>

                <table style="width:100%" id="table1" class="gtable sortable">
                    <thead style="border-bottom: 2px solid #ccc;">
                        <tr>
                            <th style="padding:5px;text-align: left;">Version</th>
                            <th style="padding:5px;text-align: left;">Created By</th>
                            <th style="padding:5px;text-align: left;">Date</th>
                            <th style="padding:5px;text-align: left;">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (php72_count($version_log) > 0) {
                            foreach ($version_log as $row) {
                                $created_date = date('d-m-Y h:i', strtotime($row['created_at']));
                                ?>
                                <tr>
                                    <td style="padding:5px;"><?php echo $row['version']; ?></td>
                                    <td style="padding:5px;"><?php echo $row['added_name']; ?></td>
                                    <td style="padding:5px;"><?php echo $created_date; ?></td>
                                    <td style="padding:5px;"><a href="<?= site_url('detailed_diligence/export_assessment/' . $inv_id . '/' . $row['version']); ?>">Download</a></td>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" align="center" style="padding:10px;font-size: 14px;font-weight: bold;">No version found.!</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="container">
            <?php
            if (isset($suc_msg) && $suc_msg != '') {
                ?>
                <p class="succ-msg"><i class="fa fa-check" aria-hidden="true">  <?= $suc_msg; ?></i></p>
                <?php
            }
            $this->session->unset_userdata('detail_sucmsg');
            ?>
            <div style="clear:both"></div>
            <div class="nav-enterpriseDetails">
                <ul class="inv-detail-status">
                    <li title="<?php echo ucfirst($innovation['name_of_enterprise']); ?>"><strong>Incubatee Name</strong>:&nbsp;
                        <?php
                        if (isset($innovation['name_of_enterprise']) && $innovation['name_of_enterprise'] != '') {
                            if (strlen($innovation['name_of_enterprise']) > 30) {
                                echo substr($innovation['name_of_enterprise'], 0, 30) . '...';
                            } else {
                                echo $innovation['name_of_enterprise'];
                            }
                        } else {
                            echo '-';
                        }
                        ?>


                    </li>
                    <li><strong>INV ID</strong>:&nbsp;<?php echo $inv_id_format; ?></li>
                    <li>
                        <form>
                            <strong>Assigned To</strong>:&nbsp;<?php echo isset($assign_to) && $assign_to != '' ? $assign_to : '-N/A-'; ?>
                        </form>
                    </li>
                </ul>
                <ul class="inv-detail-status">
                    <?php
                    $deal_sector = isset($sector[0]['sector']) && $sector[0]['sector'] != '' ? $sector[0]['sector'] : '-N/A-';
                    ?>
                    <li><strong>Sector</strong>:&nbsp;<?php echo $deal_sector; ?></li>
                    <li><strong>Stage</strong>:&nbsp;<?php echo $stage_name; ?></li>
                    <li>
                        <form id="form1">
                            <strong>Action</strong>:&nbsp;
                            <select onchange="changeAction(this.value);" id="action_value">
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
                                    ?>>Financial Negotiation</option>
                                        <?php } ?>
                            </select>
                            <span><a id="save_action" href="<?= site_url('scouting/action/close/' . $innovationID); ?>" class="fancybox button">Save</a></span>
                        </form>
                    </li>
                </ul>
                <ul class="inv-detail-status">
                    <li title="<?php echo $subsector; ?>"><strong><?php echo $subsec_title; ?></strong>:&nbsp;
                        <?php
                        if (isset($subsector) && $subsector != '') {
                            if (strlen($subsector) > 30) {
                                echo substr($subsector, 0, 30) . '...';
                            } else {
                                echo $subsector;
                            }
                        } else {
                            echo '-N/A-';
                        }
                        ?>
                    </li>
                    <li><strong>Status</strong>:&nbsp;<?php echo $status_name; ?></li>
                    <li>
                        <a id="logStatusModal" class="fancybox button" href="#status_log" style="cursor:pointer;">Application Status Log</a>&nbsp;
                        <span><a id="assign_incharge" href="#form_container" class="fancybox button">Assign User</a></span>
                    </li>
                </ul>
            </div>
            <div class="addmore-btn">
                <span><a href="<?= site_url('detailed_diligence/export_ppt/' . $inv_id); ?>" id="ppt_export" class="button"><span class="btn-icon"><i class="fa fa-download" aria-hidden="true"></i></span>Export as PPT</a></span>
                <span><a href="<?= site_url('detailed_diligence/export_assessment/' . $inv_id); ?>" id="dd_export" class="button"><span class="btn-icon"><i class="fa fa-download" aria-hidden="true"></i></span>Export as Word</a></span>
                <span><a href="#version_list" style="cursor:pointer;" class="fancybox button" id="history_ver">Version History</a></span>
                <span><a id="save_version" onclick="saveForm('save_version');" style="cursor:pointer;" class="button">Save as new version</a></span>
                <span><a id="save_exist" onclick="saveForm('save_exist');" style="cursor:pointer;" class="button">Save</a></span>

            </div>

            <div class="detailassessment enterpriseDetails-tab">
                <div class="tab">
                    <div class="left-sticky">
                        <button class="tablinks" onclick="openCity(event, 'one')" id="defaultOpen">Background/ Description</button>
                        <button class="tablinks" onclick="openCity(event, 'two')">Current Situation/ Next Steps</button>
                        <button class="tablinks" onclick="openCity(event, 'three')">Investment Structure and Returns</button>
                        <button class="tablinks" onclick="openCity(event, 'four')">Investment Thesis</button>
                        <button class="tablinks" onclick="openCity(event, 'five')">Business Model</button>
                        <button class="tablinks" onclick="openCity(event, 'six')">Launch and scaling strategy of the company</button>
                        <button class="tablinks" onclick="openCity(event, 'seven')" >Social Impact</button>
                        <button class="tablinks" onclick="openCity(event, 'eight')">Exit Options</button>
                        <button class="tablinks" onclick="openCity(event, 'nine')">Existing investors and strategic partners</button>
                        <button class="tablinks" onclick="openCity(event, 'ten')" >Exit Options </button>
                        <button class="tablinks" onclick="openCity(event, 'eleven')">Summary of other key Agreements </button>
                        <button class="tablinks" onclick="openCity(event, 'twelve')">Sector summary and key Drivers</button>
                        <button class="tablinks" onclick="openCity(event, 'thirteen')" >SWOT </button>
                        <button class="tablinks" onclick="openCity(event, 'fourteen')">Key Transaction Terms</button>
                        <button class="tablinks" onclick="openCity(event, 'fivteen')">Risks and Mitigations </button>
                        <button class="tablinks" onclick="openCity(event, 'sixteen')">Timing & Next Steps</button>
                        <button class="tablinks" onclick="openCity(event, 'seventeen')">Villgro Team</button>
                        <button class="tablinks" onclick="openCity(event, 'eighteen')">IC Decision</button>
                    </div>
                </div>

                <div id="one" class="tabcontent">
                    <div class="assess-desc">
                        <label>Background/ Description</label>
                        <?php
                        $desc_n = str_replace('\n', "\n", $get_diligence[0]['description']);
                        $desc_r = str_replace('\r', "\n", $desc_n);
                        $desc_show = str_replace("\\", "", $desc_r);
                        ?>
                        <textarea name="txtdescription" id="txtdescription" rows="3" cols="50"><?= $desc_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="two" class="tabcontent">
                    <div class="assess-desc">
                        <label>Current Situation/ Next Steps</label>
                        <?php
                        $current_n = str_replace('\n', "\n", $get_diligence[0]['current_situation']);
                        $current_r = str_replace('\r', "\n", $current_n);
                        $current_show = str_replace("\\", "", $current_r);
                        ?>
                        <textarea name="txtcurrent_situation" id="txtcurrent_situation" rows="3" cols="50"><?= $current_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="three" class="tabcontent">
                    <div class="assess-desc">
                        <label>Pre-money Valuation</label>
                        <?php
                        $money_n = str_replace('\n', "\n", $get_diligence[0]['pre_money']);
                        $money_r = str_replace('\r', "\n", $money_n);
                        $money_show = str_replace("\\", "", $money_r);
                        ?>
                        <textarea name="txtpre_money" id="txtpre_money" rows="3" cols="50"><?= $money_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Investment Amount</label>
                        <?php
                        $invest_n = str_replace('\n', "\n", $get_diligence[0]['investment']);
                        $invest_r = str_replace('\r', "\n", $invest_n);
                        $invest_show = str_replace("\\", "", $invest_r);
                        ?>
                        <textarea name="txtinvestment" id="txtinvestment" rows="3" cols="50"><?= $invest_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Round size</label>
                        <?php
                        $round_n = str_replace('\n', "\n", $get_diligence[0]['round_size']);
                        $round_r = str_replace('\r', "\n", $round_n);
                        $round_show = str_replace("\\", "", $round_r);
                        ?>
                        <textarea name="txtround_size" id="txtround_size" rows="3" cols="50"><?= $round_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Post-Money Valuation</label>
                        <?php
                        $post_n = str_replace('\n', "\n", $get_diligence[0]['post_money']);
                        $post_r = str_replace('\r', "\n", $post_n);
                        $post_show = str_replace("\\", "", $post_r);
                        ?>
                        <textarea name="txtpost_money" id="txtpost_money" rows="3" cols="50"><?= $post_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Number of Shares</label>
                        <input type="text" name="txtnmbr_share" id="txtnmbr_share" value="<?= $get_diligence[0]['number_of_shares']; ?>" />
                    </div>
                    <div class="assess-desc">
                        <label>Cap-table</label>
                        <?php
                        $cap_n = str_replace('\n', "\n", $get_diligence[0]['cap_table']);
                        $cap_r = str_replace('\r', "\n", $cap_n);
                        $cap_show = str_replace("\\", "", $cap_r);
                        ?>
                        <textarea name="txtcap_table" id="txtcap_table" rows="3" cols="50"><?= $cap_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Valuation Methodology</label>
                        <?php
                        $method_n = str_replace('\n', "\n", $get_diligence[0]['valuation']);
                        $method_r = str_replace('\r', "\n", $method_n);
                        $method_show = str_replace("\\", "", $method_r);
                        ?>
                        <textarea name="txtvaluation_method" id="txtvaluation_method" rows="3" cols="50"><?= $method_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Governance – Board Structure</label>
                        <?php
                        $govern_n = str_replace('\n', "\n", $get_diligence[0]['governance']);
                        $govern_r = str_replace('\r', "\n", $govern_n);
                        $govern_show = str_replace("\\", "", $govern_r);
                        ?>
                        <textarea name="txtgovernance" id="txtgovernance" rows="3" cols="50"><?= $govern_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="four" class="tabcontent">
                    <div class="assess-desc">
                        <label>Why do we like this team?</label>
                        <?php
                        $team_n = str_replace('\n', "\n", $get_diligence[0]['team_like']);
                        $team_r = str_replace('\r', "\n", $team_n);
                        $team_show = str_replace("\\", "", $team_r);
                        ?>
                        <textarea name="txtlike_team" id="txtlike_team" rows="3" cols="50"><?= $team_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Problem Solution Fit</label>
                        <?php
                        $solution_n = str_replace('\n', "\n", $get_diligence[0]['solution_fit']);
                        $solution_r = str_replace('\r', "\n", $solution_n);
                        $solution_show = str_replace("\\", "", $solution_r);
                        ?>
                        <textarea name="txtsolution_fit" id="txtsolution_fit" rows="3" cols="50"><?= $solution_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Product Market Fit</label>
                        <?php
                        $market_n = str_replace('\n', "\n", $get_diligence[0]['market_fit']);
                        $market_r = str_replace('\r', "\n", $market_n);
                        $market_show = str_replace("\\", "", $market_r);
                        ?>
                        <textarea name="txtmarket_fit" id="txtmarket_fit" rows="3" cols="50"><?= $market_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Impact Potential</label>
                        <?php
                        $impact_n = str_replace('\n', "\n", $get_diligence[0]['impact_potential']);
                        $impact_r = str_replace('\r', "\n", $impact_n);
                        $impact_show = str_replace("\\", "", $impact_r);
                        ?>
                        <textarea name="txtimpact_potential" id="txtimpact_potential" rows="3" cols="50"><?= $impact_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Mandate Fit</label>
                        <?php
                        $mandate_n = str_replace('\n', "\n", $get_diligence[0]['mandate_fit']);
                        $mandate_r = str_replace('\r', "\n", $mandate_n);
                        $mandate_show = str_replace("\\", "", $mandate_r);
                        ?>
                        <textarea name="txtmandate_fit" id="txtmandate_fit" rows="3" cols="50"><?= $mandate_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Current Status of the Company, Achievements with our proposed funding</label>
                        <?php
                        $propose_n = str_replace('\n', "\n", $get_diligence[0]['proposed_funding']);
                        $propose_r = str_replace('\r', "\n", $propose_n);
                        $propose_show = str_replace("\\", "", $propose_r);
                        ?>
                        <textarea name="txtproposed_funding" id="txtproposed_funding" rows="3" cols="50"><?= $propose_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Return Expectations</label>
                        <?php
                        $return_n = str_replace('\n', "\n", $get_diligence[0]['return_expectations']);
                        $return_r = str_replace('\r', "\n", $return_n);
                        $return_show = str_replace("\\", "", $return_r);
                        ?>
                        <textarea name="txtreturn_expectations" id="txtreturn_expectations" rows="3" cols="50"><?= $return_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Downstream Investor’s view</label>
                        <?php
                        $down_n = str_replace('\n', "\n", $get_diligence[0]['downstream']);
                        $down_r = str_replace('\r', "\n", $down_n);
                        $down_show = str_replace("\\", "", $down_r);
                        ?>
                        <textarea name="txtdownstream" id="txtdownstream" rows="3" cols="50"><?= $down_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="five" class="tabcontent">
                    <div class="assess-desc">
                        <label>Pain points</label>
                        <?php
                        $pain_n = str_replace('\n', "\n", $get_diligence[0]['pain_points']);
                        $pain_r = str_replace('\r', "\n", $pain_n);
                        $pain_show = str_replace("\\", "", $pain_r);
                        ?>
                        <textarea name="txtpain_point" id="txtpain_point" rows="3" cols="50"><?= $pain_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Value proposition</label>
                        <?php
                        $position_n = str_replace('\n', "\n", $get_diligence[0]['value_proposition']);
                        $position_r = str_replace('\r', "\n", $position_n);
                        $position_show = str_replace("\\", "", $position_r);
                        ?>
                        <textarea name="txtvalue_proposition" id="txtvalue_proposition" rows="3" cols="50"><?= $position_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Customer Segment</label>
                        <?php
                        $segment_n = str_replace('\n', "\n", $get_diligence[0]['customer_segment']);
                        $segment_r = str_replace('\r', "\n", $segment_n);
                        $segment_show = str_replace("\\", "", $segment_r);
                        ?>
                        <textarea name="txtcustomer_segment" id="txtcustomer_segment" rows="3" cols="50"><?= $segment_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Product Portfolio</label>
                        <?php
                        $portfolio_n = str_replace('\n', "\n", $get_diligence[0]['product_portfolio']);
                        $portfolio_r = str_replace('\r', "\n", $portfolio_n);
                        $portfolio_show = str_replace("\\", "", $portfolio_r);
                        ?>
                        <textarea name="txtproduct_portfolio" id="txtproduct_portfolio" rows="3" cols="50"><?= $portfolio_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Customer Channels</label>
                        <?php
                        $channel_n = str_replace('\n', "\n", $get_diligence[0]['customer_channels']);
                        $channel_r = str_replace('\r', "\n", $channel_n);
                        $channel_show = str_replace("\\", "", $channel_r);
                        ?>
                        <textarea name="txtcustomer_channels" id="txtcustomer_channels" rows="3" cols="50"><?= $channel_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Revenue Model</label>
                        <?php
                        $revenue_n = str_replace('\n', "\n", $get_diligence[0]['revenue_model']);
                        $revenue_r = str_replace('\r', "\n", $revenue_n);
                        $revenue_show = str_replace("\\", "", $revenue_r);
                        ?>
                        <textarea name="txtrevenue_model" id="txtrevenue_model" rows="3" cols="50"><?= $revenue_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Key Risks and Challenges</label>
                        <?php
                        $key_n = str_replace('\n', "\n", $get_diligence[0]['key_risks']);
                        $key_r = str_replace('\r', "\n", $key_n);
                        $key_show = str_replace("\\", "", $key_r);
                        ?>
                        <textarea name="txtkey_risks" id="txtkey_risks" rows="3" cols="50"><?= $key_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="six" class="tabcontent">
                    <div class="assess-desc">
                        <label>Entry point</label>
                        <?php
                        $entry_n = str_replace('\n', "\n", $get_diligence[0]['entry_point']);
                        $entry_r = str_replace('\r', "\n", $entry_n);
                        $entry_show = str_replace("\\", "", $entry_r);
                        ?>
                        <textarea name="txtentry_point" id="txtentry_point" rows="3" cols="50"><?= $entry_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Market Sizing (Only government schools)</label>
                        <?php
                        $school_n = str_replace('\n', "\n", $get_diligence[0]['market_sizing']);
                        $school_r = str_replace('\r', "\n", $school_n);
                        $school_show = str_replace("\\", "", $school_r);
                        ?>
                        <textarea name="txtmarket_sizing" id="txtmarket_sizing" rows="3" cols="50"><?= $school_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>How will the company grow? (Different products/ customer segment/ channel/ geography)</label>
                        <?php
                        $grow_n = str_replace('\n', "\n", $get_diligence[0]['company_grow']);
                        $grow_r = str_replace('\r', "\n", $grow_n);
                        $grow_show = str_replace("\\", "", $grow_r);
                        ?>
                        <textarea name="txtcompany_grow" id="txtcompany_grow" rows="3" cols="50"><?= $grow_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Which lever is being deployed?</label>
                        <?php
                        $lever_n = str_replace('\n', "\n", $get_diligence[0]['lever_deployed']);
                        $lever_r = str_replace('\r', "\n", $lever_n);
                        $lever_show = str_replace("\\", "", $lever_r);
                        ?>
                        <textarea name="txtlever_deployed" id="txtlever_deployed" rows="3" cols="50"><?= $lever_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Exit point</label>
                        <?php
                        $exit_n = str_replace('\n', "\n", $get_diligence[0]['exit_point']);
                        $exit_r = str_replace('\r', "\n", $exit_n);
                        $exit_show = str_replace("\\", "", $exit_r);
                        ?>
                        <textarea name="txtexit_point" id="txtexit_point" rows="3" cols="50"><?= $exit_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="seven" class="tabcontent">
                    <div class="assess-desc">
                        <label>Problem</label>
                        <?php
                        $problem_n = str_replace('\n', "\n", $get_diligence[0]['problem']);
                        $problem_r = str_replace('\r', "\n", $problem_n);
                        $problem_show = str_replace("\\", "", $problem_r);
                        ?>
                        <textarea name="txtproblem" id="txtproblem" rows="3" cols="50"><?= $problem_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Theory of Change</label>
                        <?php
                        $theory_n = str_replace('\n', "\n", $get_diligence[0]['theory_of_change']);
                        $theory_r = str_replace('\r', "\n", $theory_n);
                        $theory_show = str_replace("\\", "", $theory_r);
                        ?>
                        <textarea name="txttheory_change" id="txttheory_change" rows="3" cols="50"><?= $theory_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Current impact, if any</label>
                        <?php
                        $cimpact_n = str_replace('\n', "\n", $get_diligence[0]['current_impact']);
                        $cimpact_r = str_replace('\r', "\n", $cimpact_n);
                        $cimpact_show = str_replace("\\", "", $cimpact_r);
                        ?>
                        <textarea name="txtcurrent_impact" id="txtcurrent_impact" rows="3" cols="50"><?= $cimpact_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Target impact</label>
                        <?php
                        $timpact_n = str_replace('\n', "\n", $get_diligence[0]['target_impact']);
                        $timpact_r = str_replace('\r', "\n", $timpact_n);
                        $timpact_show = str_replace("\\", "", $timpact_r);
                        ?>
                        <textarea name="txttarget_impact" id="txttarget_impact" rows="3" cols="50"><?= $timpact_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Social Impact Metrics</label>
                        <?php
                        $simpact_n = str_replace('\n', "\n", $get_diligence[0]['social_impact']);
                        $simpact_r = str_replace('\r', "\n", $simpact_n);
                        $simpact_show = str_replace("\\", "", $simpact_r);
                        ?>
                        <textarea name="txtsocial_impact" id="txtsocial_impact" rows="3" cols="50"><?= $simpact_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="eight" class="tabcontent">
                    <div class="assess-desc">
                        <label>Discuss options as per SHA</label>
                        <?php
                        $discuss_n = str_replace('\n', "\n", $get_diligence[0]['discuss_options']);
                        $discuss_r = str_replace('\r', "\n", $discuss_n);
                        $discuss_show = str_replace("\\", "", $discuss_r);
                        ?>
                        <textarea name="txtdiscuss_options" id="txtdiscuss_options" rows="3" cols="50"><?= $discuss_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="nine" class="tabcontent">
                    <div class="assess-desc">
                        <label>Include structure and terms agreed with earlier investors</label>
                        <?php
                        $terms_n = str_replace('\n', "\n", $get_diligence[0]['structure_terms_agreed']);
                        $terms_r = str_replace('\r', "\n", $terms_n);
                        $terms_show = str_replace("\\", "", $terms_r);
                        ?>
                        <textarea name="txtstructure_terms" id="txtstructure_terms" rows="3" cols="50"><?= $terms_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="ten" class="tabcontent">
                    <div class="assess-desc">
                        <label>Exit Options</label>
                        <?php
                        $option_n = str_replace('\n', "\n", $get_diligence[0]['exit_options']);
                        $option_r = str_replace('\r', "\n", $option_n);
                        $option_show = str_replace("\\", "", $option_r);
                        ?>
                        <textarea name="txtexit_options" id="txtexit_options" rows="3" cols="50"><?= $option_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="eleven" class="tabcontent">
                    <div class="assess-desc">
                        <label>Summary of other key Agreements</label>
                        <?php
                        $agreement_n = str_replace('\n', "\n", $get_diligence[0]['other_key_agreements']);
                        $agreement_r = str_replace('\r', "\n", $agreement_n);
                        $agreement_show = str_replace("\\", "", $agreement_r);
                        ?>
                        <textarea name="txtother_key" id="txtother_key" rows="3" cols="50"><?= $agreement_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="twelve" class="tabcontent">
                    <div class="assess-desc">
                        <label>Sector summary and key Drivers</label>
                        <?php
                        $sector_n = str_replace('\n', "\n", $get_diligence[0]['sector_summary']);
                        $sector_r = str_replace('\r', "\n", $sector_n);
                        $sector_show = str_replace("\\", "", $sector_r);
                        ?>
                        <textarea name="txtsector_summary" id="txtsector_summary" rows="3" cols="50"><?= $sector_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="thirteen" class="tabcontent">
                    <div class="assess-desc">
                        <label>SWOT</label>
                        <?php
                        $swot_n = str_replace('\n', "\n", $get_diligence[0]['swot']);
                        $swot_r = str_replace('\r', "\n", $swot_n);
                        $swot_show = str_replace("\\", "", $swot_r);
                        ?>
                        <textarea name="txtswot" id="txtswot" rows="3" cols="50"><?= $swot_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="fourteen" class="tabcontent">
                    <div class="assess-desc">
                        <label>Key Transaction Terms</label>
                        <?php
                        $transac_n = str_replace('\n', "\n", $get_diligence[0]['key_transaction']);
                        $transac_r = str_replace('\r', "\n", $transac_n);
                        $transac_show = str_replace("\\", "", $transac_r);
                        ?>
                        <textarea name="txtkey_transaction" id="txtkey_transaction" rows="3" cols="50"><?= $transac_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="fivteen" class="tabcontent">
                    <div class="assess-desc">
                        <label>Risks and Mitigations</label>
                        <?php
                        $risk_n = str_replace('\n', "\n", $get_diligence[0]['risks_mitigations']);
                        $risk_r = str_replace('\r', "\n", $risk_n);
                        $risk_show = str_replace("\\", "", $risk_r);
                        ?>
                        <textarea name="txtrisks_mitigations" id="txtrisks_mitigations" rows="3" cols="50"><?= $risk_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="sixteen" class="tabcontent">
                    <div class="assess-desc">
                        <label>Tranche suggestions for funding</label>
                        <?php
                        $tranche_n = str_replace('\n', "\n", $get_diligence[0]['tranche_suggestions']);
                        $tranche_r = str_replace('\r', "\n", $tranche_n);
                        $tranche_show = str_replace("\\", "", $tranche_r);
                        ?>
                        <textarea name="txttranche_suggestions" id="txttranche_suggestions" rows="3" cols="50"><?= $tranche_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="seventeen" class="tabcontent">
                    <div class="assess-desc">
                        <label>Villgro Team</label>
                        <?php
                        $villgro_n = str_replace('\n', "\n", $get_diligence[0]['villgro_team']);
                        $villgro_r = str_replace('\r', "\n", $villgro_n);
                        $villgro_show = str_replace("\\", "", $villgro_r);
                        ?>
                        <textarea name="txtvillgro_team" id="txtvillgro_team" rows="3" cols="50"><?= $villgro_show; ?></textarea>
                    </div>
                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div id="eighteen" class="tabcontent">
                    <div class="assess-desc">
                        <label>IC Inputs</label>
                        <?php
                        $input_n = str_replace('\n', "\n", $get_diligence[0]['ic_inputs']);
                        $input_r = str_replace('\r', "\n", $input_n);
                        $input_show = str_replace("\\", "", $input_r);
                        ?>
                        <textarea name="txtic_inputs" id="txtic_inputs" rows="3" cols="50"><?= $input_show; ?></textarea>
                    </div>
                    <div class="assess-desc">
                        <label>Summary of thoughts – opportunities and things to watch</label>
                        <textarea name="txtthoughts_opportunities" id="txtthoughts_opportunities" rows="3" cols="50"><?= str_replace('\r\n  ', "\n", $get_diligence[0]['thoughts_opportunities']); ?></textarea>
                    </div>

                    <div class="addmore-btn text-center">
                        <div style="clear:both"></div>
                        <span><a id="save_action" href="javascript:"  class="AddMore-btn">Edit</a></span> <span><a id="save_action" href="javascript:"  class="Darkedit-btn">Save</a></span>
                        <div style="clear:both"></div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
            <div style="height:40px;"></div>
        </div>


        <form name="save_assessment" id="save_assessment" method="post" action="<?php echo base_url(); ?>index.php/detailed_diligence/save_detailed_assessment">
            <input type="hidden" name="id" id="id" value="<?= $id; ?>" />
            <input type="hidden" name="inv_id" id="inv_id" value="<?= $inv_id; ?>" />
            <input type="hidden" name="version" id="version" value="<?= $get_diligence[0]['version']; ?>" />
            <input type="hidden" name="description" id="description" value="" />
            <input type="hidden" name="current_situation" id="current_situation" value="" />
            <input type="hidden" name="pre_money" id="pre_money" value="" />
            <input type="hidden" name="investment" id="investment" value="" />
            <input type="hidden" name="round_size" id="round_size" value="" />
            <input type="hidden" name="post_money" id="post_money" value="">
                <input type="hidden" name="number_of_shares" id="number_of_shares" value="" />
                <input type="hidden" name="cap_table" id="cap_table" value="" />
                <input type="hidden" name="valuation_method" id="valuation_method" value="" />
                <input type="hidden" name="governance" id="governance" value="" />
                <input type="hidden" name="like_team" id="like_team" value="" />
                <input type="hidden" name="solution_fit" id="solution_fit" value="" />
                <input type="hidden" name="market_fit" id="market_fit" value="" />
                <input type="hidden" name="impact_potential" id="impact_potential" value="" />
                <input type="hidden" name="mandate_fit" id="mandate_fit" value="" />
                <input type="hidden" name="proposed_funding" id="proposed_funding" value="" />
                <input type="hidden" name="return_expectations" id="return_expectations" value="" />
                <input type="hidden" name="downstream" id="downstream" value="" />
                <input type="hidden" name="pain_points" id="pain_points" value="" />
                <input type="hidden" name="value_proposition" id="value_proposition" value="" />
                <input type="hidden" name="customer_segment" id="customer_segment" value="" />
                <input type="hidden" name="product_portfolio" id="product_portfolio" value="" />
                <input type="hidden" name="customer_channels" id="customer_channels" value="" />
                <input type="hidden" name="revenue_model" id="revenue_model" value="" />
                <input type="hidden" name="key_risks" id="key_risks" value="" />
                <input type="hidden" name="entry_point" id="entry_point" value="" />
                <input type="hidden" name="market_sizing" id="market_sizing" value="" />
                <input type="hidden" name="company_grow" id="company_grow" value="" />
                <input type="hidden" name="lever_deployed" id="lever_deployed" value="" />
                <input type="hidden" name="exit_point" id="exit_point" value="" />
                <input type="hidden" name="problem" id="problem" value="" />
                <input type="hidden" name="theory_change" id="theory_change" value="" />
                <input type="hidden" name="current_impact" id="current_impact" value="" />
                <input type="hidden" name="target_impact" id="target_impact" value="" />
                <input type="hidden" name="social_impact" id="social_impact" value="" />
                <input type="hidden" name="discuss_options" id="discuss_options" value="" />
                <input type="hidden" name="structure_terms" id="structure_terms" value="" />
                <input type="hidden" name="exit_options" id="exit_options" value="" />
                <input type="hidden" name="other_key" id="other_key" value="" />
                <input type="hidden" name="sector_summary" id="sector_summary" value="" />
                <input type="hidden" name="swot" id="swot" value="" />
                <input type="hidden" name="key_transaction" id="key_transaction" value="" />
                <input type="hidden" name="risks_mitigations" id="risks_mitigations" value="" />
                <input type="hidden" name="tranche_suggestions" id="tranche_suggestions" value="" />
                <input type="hidden" name="villgro_team" id="villgro_team" value="" />
                <input type="hidden" name="ic_inputs" id="ic_inputs" value="" />
                <input type="hidden" name="thoughts_opportunities" id="thoughts_opportunities" value="" />
                <input type="hidden" name="save_type" id="save_type" value="" />
        </form>

        <div style="display:none;">
            <div id="dateModal" class="global_search" align="center" style="width:500px;">
                <h1 class="text-left reduce_space">Select start date of <span id='eic_title'></span></h1>
                <div class="modal-body">
                    <br/>
                    <label>Choose date : </label>
                    <input type="text" name="status_change_date" id="status_change_date" style="padding: 5px;" value="<?= $eic_date; ?>" />
                </div>
                <br/>
                <input type="button" value="Submit" id='dateSubmit' class="button" />
            </div>
        </div>

        <script type="text/javascript">

            $(document).ready(function () {
                setTimeout(function () {
                    $('.succ-msg').hide();
                }, 5000);
            });

            function saveForm(saveVal) {
                var desc = $('#txtdescription').val();
                $('#description').val(desc);

                var situation = $('#txtcurrent_situation').val();
                $('#current_situation').val(situation);

                var money = $('#txtpre_money').val();
                $('#pre_money').val(money);

                var invest = $('#txtinvestment').val();
                $('#investment').val(invest);

                var round = $('#txtround_size').val();
                $('#round_size').val(round);

                var post_money = $('#txtpost_money').val();
                $('#post_money').val(post_money);

                var share = $('#txtnmbr_share').val();
                $('#number_of_shares').val(share);

                var cap = $('#txtcap_table').val();
                $('#cap_table').val(cap);

                var valuation = $('#txtvaluation_method').val();
                $('#valuation_method').val(valuation);

                var governance = $('#txtgovernance').val();
                $('#governance').val(governance);

                var team = $('#txtlike_team').val();
                $('#like_team').val(team);

                var solution = $('#txtsolution_fit').val();
                $('#solution_fit').val(solution);

                var market_fit = $('#txtmarket_fit').val();
                $('#market_fit').val(market_fit);

                var potential = $('#txtimpact_potential').val();
                $('#impact_potential').val(potential);

                var mandate = $('#txtmandate_fit').val();
                $('#mandate_fit').val(mandate);

                var funding = $('#txtproposed_funding').val();
                $('#proposed_funding').val(funding);

                var expectation = $('#txtreturn_expectations').val();
                $('#return_expectations').val(expectation);

                var downstream = $('#txtdownstream').val();
                $('#downstream').val(downstream);

                var pain = $('#txtpain_point').val();
                $('#pain_points').val(pain);

                var proposition = $('#txtvalue_proposition').val();
                $('#value_proposition').val(proposition);

                var segment = $('#txtcustomer_segment').val();
                $('#customer_segment').val(segment);

                var portfolio = $('#txtproduct_portfolio').val();
                $('#product_portfolio').val(portfolio);

                var channels = $('#txtcustomer_channels').val();
                $('#customer_channels').val(channels);

                var revenue = $('#txtrevenue_model').val();
                $('#revenue_model').val(revenue);

                var risks = $('#txtkey_risks').val();
                $('#key_risks').val(risks);

                var entry = $('#txtentry_point').val();
                $('#entry_point').val(entry);

                var market_sizing = $('#txtmarket_sizing').val();
                $('#market_sizing').val(market_sizing);

                var grow = $('#txtcompany_grow').val();
                $('#company_grow').val(grow);

                var lever = $('#txtlever_deployed').val();
                $('#lever_deployed').val(lever);

                var exit_point = $('#txtexit_point').val();
                $('#exit_point').val(exit_point);

                var problem = $('#txtproblem').val();
                $('#problem').val(problem);

                var theory = $('#txttheory_change').val();
                $('#theory_change').val(theory);

                var current_impact = $('#txtcurrent_impact').val();
                $('#current_impact').val(current_impact);

                var target_impact = $('#txttarget_impact').val();
                $('#target_impact').val(target_impact);

                var social_impact = $('#txtsocial_impact').val();
                $('#social_impact').val(social_impact);

                var discuss_options = $('#txtdiscuss_options').val();
                $('#discuss_options').val(discuss_options);

                var structure_terms = $('#txtstructure_terms').val();
                $('#structure_terms').val(structure_terms);

                var exit_options = $('#txtexit_options').val();
                $('#exit_options').val(exit_options);

                var other_key = $('#txtother_key').val();
                $('#other_key').val(other_key);

                var sector_summary = $('#txtsector_summary').val();
                $('#sector_summary').val(sector_summary);

                var swot = $('#txtswot').val();
                $('#swot').val(swot);

                var transaction = $('#txtkey_transaction').val();
                $('#key_transaction').val(transaction);

                var mitigations = $('#txtrisks_mitigations').val();
                $('#risks_mitigations').val(mitigations);

                var tranche = $('#txttranche_suggestions').val();
                $('#tranche_suggestions').val(tranche);

                var villgro = $('#txtvillgro_team').val();
                $('#villgro_team').val(villgro);

                var ic_inputs = $('#txtic_inputs').val();
                $('#ic_inputs').val(ic_inputs);

                var thoughts = $('#txtthoughts_opportunities').val();
                $('#thoughts_opportunities').val(thoughts);

                $('#save_type').val(saveVal);

                if (saveVal == 'save_version') {
                    var app = confirm("Are you sure to save as a new version?");
                    if (app == true) {
                        $('#save_assessment').submit();
                    }
                } else if (saveVal == 'save_exist') {
                    $('#save_assessment').submit();
                }

            }

            $(document).on('keyup', 'textarea', function () {
                if (this.value.match(/[^a-zA-Z0-9\n., "():&'\-/ ]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
                }
            });
        </script>

        <style>
            .triggerBtn{
                font-size:14px;
            }
            .mailTrigger {
                font-size: 14px;
                text-align:left;
                margin-bottom:0px;
            }
            .mailTriggerHead{
                font-size: 14px;
                text-align:left;
                margin-bottom:10px;
                font-weight:600;
            }
            .text-center{text-align:center !important; width: 100%;}
            .succ-msg{
                font-size: 14px;
                color: green;
                text-align: center;
                font-weight: 600;
                background-color: #E9F1D1;
                padding: 5px 0px;
                border-radius: 7px;
                margin-top: 20px;
            }
            .nav-enterpriseDetails{
                background-color: #ffffff;
                padding: 15px 15px 10px 15px;
                display: flex;
                width: 97%;
                margin: 10px 0;
                box-shadow: 0px 1px 20px rgba(0,0,0,0.09);
                border-radius: 4px;
                margin-top:30px;
            }
            ul.inv-detail-status {
                width: 33.333%;
                float: left;
                display: block;
            }
            ul.inv-detail-status li{
                padding: 8px 0px;
                border-bottom: 1px solid #ccc;
            }
            ul.inv-detail-status li:last-child{
                border-bottom: none;
                display:flex;
                align-items: center;
                height:35px;
            }
            ul.inv-detail-status li strong {
                width: 32%;
                display: inline-block;
            }
            ul.inv-detail-status li form {
                width: 100%;
            }
            .enterpriseDetails-tab{
                padding:20px 0px;
            }
            .detailassessment table tr th{
                background-color: #d1deab;
                color: #000;
                text-align: center;
                padding: 10px 5px;
                border-right: 1px solid #5d7d00;
                border-bottom: 2px solid #5f8d4a;
                vertical-align: middle;
            }
            .btn-icon{
                font-size: 15px ;
                padding-right: 10px;
            }
            .yellow-color{
                background-color: #fdd22c !important;
                color: #333 !important;
            }
            .left-sticky {
                height: 585px;
                overflow: scroll;
                overflow-x: hidden;
            }
            .detailassessment table tr th:last-child{
                border-right: 1px solid #b4cc71;
            }
            .detailassessment table tr td{
                padding: 10px 5px;
                border: 1px solid #ccc;
            }
            .tabcontent .assess-desc{
                display: block !important;
            }
            .tabcontent .assess-desc label {
                display: block !important;
                font-size: 13px;
                font-weight: 600;
                color: #000;
                padding: 10px 1px 6px 4px;
            }
            .tabcontent .assess-desc textarea, .tabcontent .assess-desc input {
                width: 98%;
                margin: 0px 0px 0px 0px;
                color: #666;
                line-height: 20px;
                text-align: left;
                letter-spacing: 0.2px;
                font-size: 13px;
                background: #fff;
                border-bottom: 1px solid #8eb37d;
                width: 100%;
                border-left: none;
                border-top: none;
                border-right: none;
                border-radius: 0px;
            }
            .heading-address{
                padding: 10px 0;
                text-align: center;
                display: block;
                color:#60615f;
            }
            .bg-gray{
                background-color: #eee;
            }
            .addmore-btn{
                display: block !important;
                padding: 20px 0px;
                text-align:right;
            }
            .addmore-btn-2{
                display: block !important;
                padding: 20px 0px;
                text-align:right;
            }
            a:hover{
                color: #333 !important;
            }
            /* Style the tab */
            .tab {
                float: left;
                border: 1px solid #5e864c;
                background-color: #8eb37d;
                width: 25%;
                min-height: 330px;
            }

            /* Style the buttons inside the tab */
            .tab button {
                display: block;
                background-color: #8eb17f;
                color: #fdfdfd;
                padding: 16px 16px;
                width: 100%;
                border: none;
                outline: none;
                text-align: left;
                cursor: pointer;
                transition: 0.3s;
                font-size: 14px;
                border-bottom: 1px solid #5e864c;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #5e864c;
            }

            /* Create an active/current "tab button" class */
            .tab button.active {
                background-color: #5e864c;
                position: relative;
            }
            .tab button.active:after{
                content: '';
                position: absolute;
                right: -2px;
                top: 18px;
                width: 0;
                height: 0;
                border-top: 10px solid transparent;
                border-bottom: 10px solid transparent;
                border-right: 10px solid #fff;
                clear: both;
            }

            /* Style the tab content */
            .tabcontent {
                float: left;
                padding: 15px 13px   ;
                width: 72%;
                border-left: none;
                background: #ffffff;
                height:555px;
                overflow: scroll;
                overflow-x:hidden;
                border: 1px solid #5e864c;
                position: relative;
            }

            .save-btn {
                background: #5e864c !important;
                padding: 9px 16px;
                font-size: 13px;
                color: #fff;
                border-radius: 30px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                margin-right: 10px;
            }
            .AddMore-btn {
                background: #ee992b !important;
                padding: 7px 10px;
                font-size: 13px;
                color: #fff;
                border-radius: 1px;
                margin: 0px 10px 0px 0px ;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                display: none;
            }
            .Edit-btn {
                background: #ee992b;
                padding: 8px 20px;
                font-size: 13px;
                color: #fff;
                border-radius: 30px;
                margin: 0px 10px 0px 0px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
            }
            .Darkedit-btn {
                background: #36c6ad;
                padding: 7px 26px;
                font-size: 13px;
                color: #fff;
                border-radius: 30px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                display: none;
            }
            .Darkedit-btn-2 {
                background: #36c6ad;
                padding: 6px 26px;
                font-size: 13px;
                color: #fff;
                border-radius: 30px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
            }
            .position_Abs{
                position: absolute;
                bottom:30px;
                left:50%;
            }
            .button:hover{
                color:#fff !important;
            }
        </style>

        <script type="text/javascript">
            function openCity(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }

            document.getElementById("defaultOpen").click();

            $(document).ready(function () {
                var isAdmin = "<?php echo $this->session->userdata('isAdmin'); ?>";
                var isPartner = "<?php echo $this->session->userdata('partner_id'); ?>";
                var isAssociate = "<?php echo $innovation['isAssociate']; ?>";
                if ((isAssociate != '1' && isAdmin != 'Yes') || isPartner == '') {
                    $(".container :input:not(.tablinks)").attr("disabled", true);
                    $('.container a:not(:.uploadFiles, #logStatusModal, #master_docs)').css('pointer-events', 'none');
                }

                var action_val = $('#action_value').val();
                changeAction(action_val);

                $("#status_change_date").datepicker({dateFormat: 'dd-mm-yy'});
                var date = $('#status_change_date').val();
                if (date == '01-01-1970' || date == '') {
                    $("#status_change_date").datepicker("setDate", new Date());
                }
            });

            $(document).on('click', '#assign_incharge', function () {
                Populate();
            });

            function Populate() {
                var invID = "<?php echo $id; ?>";
                $('#innovations').val(invID);
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/scouting/getassemployee",
                    data: {id: invID},
                    dataType: 'json',
                    success: function (msg) {
                        var arr = msg;
                        for (var prop in arr) {
                            $('#associate_employee option').map(function () {
                                if (arr[prop]['associate_employee'] == $(this).val()) {
                                    $(this).attr("selected", 'selected');
                                }
                            });
                        }
                    },
                });
            }

            $(document).on('change', '#action_value', function () {
                var txt = $(this).val();
                changeAction(txt);
            });

            function changeAction(txt) {
                if (txt == 2) {
                    $('#eic_title').html('EIC accept');
                } else if (txt == 3) {
                    $('#eic_title').html('EIC reject');
                }
                if (txt == 4) {
                    $('#eic_title').html('financial negotiations');
                }

                if (txt == 2 || txt == 3 || txt == 4) {
                    $("#save_action").attr("href", "#dateModal");
                } else {
                    $("#save_action").attr("href", "<?= site_url('scouting/action/close/' . $innovationID); ?>");
                }
            }

            $(document).on('click', '#dateSubmit', function () {
                var action_value = $('#action_value').val();
                var new_date = $('#status_change_date').val();
                var invID = "<?php echo $innovation['id']; ?>";
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/scouting/eir_action",
                    data: {id: invID, action: action_value, action_date: new_date},
                    dataType: 'json',
                    success: function (msg) {
                        location.reload(true);
                    },
                });
                $.fancybox.cancel();
            });

            $(document).on('keyup', 'textarea', function () {
                if (this.value.match(/[^a-zA-Z0-9\n., "():&\-/ ]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&\-/]/g, '');
                }

                wordcount = this.value.trim().split(" ");
                if (this.value.trim() == "")
                    wordcountlength = 0;
                else
                    wordcountlength = wordcount.length;
                if (wordcountlength > 250) {
                    resultArray = wordcount.slice(0, 250);
                    this.value = resultArray.join(" ");
                    return false;
                }
            });

            $(document).on('keyup', '#txtnmbr_share', function () {
                if (this.value.match(/[^0-9.%]/g)) {
                    this.value = this.value.replace(/[^0-9.%]/g, '');
                }
            });

        </script>

    </body>
</html>

