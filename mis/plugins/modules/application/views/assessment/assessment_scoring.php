<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $innovation['name_of_enterprise'] . ' - Assessment Scoring', 'page_table' => 'datatable', 'module' => 'leave_summary')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'pre_assitant', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <!-- <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back</a></span> -->
                        <h4><?= $innovation['name_of_enterprise']; ?></h4>
                    </div>
                </div>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/application/assessment_scoring/' . $application_id; ?>">Assessment Scoring</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/assessment_summary/' . $application_id; ?>">Assessment Summary</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--                <div class="tab-slider--navform">
                                    <ul class="tab-slider--tabsform">
                                        <li class="tab-slider--triggerform active"><a  href="<?php echo base_url() . 'index.php/application/assign_incharge/' . $application_id; ?>">Assign Incharge</a></li>
                                        <li class="tab-slider--triggerform"><a  href="<?php echo base_url() . 'index.php/application/close_application/' . $application_id; ?>">Close/Bank</a></li>
                                    </ul>
                                </div>-->

                                <div class="inputplan-structureall plan-structure-new vital_windowScroll">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <form name="asset_form" id="asset_form" action="<?php echo site_url('application/store_assesst'); ?>" method="post" autocomplete="off">
                                                <table class="table table-hover dt-responsive" id="scoring_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Area</th>
                                                            <th>Enterprise Score <span style="cursor:pointer;" title="0-No, 1-Low, 2-Medium, 3-High">(i)</span></th>
                                                            <th width="20%">N/A</th>
                                                            <th width="15%">Scoring Guidelines</th>
                                                            <th width="10%"></th>
                                                            <th width="10%"></th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        /* ----- Unserializing the assesst details ----- */
                                                        if (isset($assesst)) {
                                                            $area_id = unserialize($assesst[0]['area_id']);
                                                            $score = unserialize($assesst[0]['score']);
                                                            $rational = unserialize($assesst[0]['rational']);
                                                            $risk = unserialize($assesst[0]['risk']);
                                                        }
                                                        $count_area = count($area);
                                        // $i=1;
                                                        foreach ($area as $area) {
                                                            $i = isset($i) && $i != '' ? $i : 1;
                                                            ?>
                                                            <tr class="parent">
                                                                <td class='firstDiv' id="row<?php echo $area['id']; ?>"><strong><?php
																		if($innovation['program'] =='27' && $area['Name'] =='Social impact'){
																			echo 'Impact';
																			
																		}else{
																			echo $area['Name'];
																		} 
														
																	//echo $area['Name'];
																 ?></strong></td>
                                                                <td>
                                                                    <input type="text" class="pre-input score area" style="width:70px" name="score[<?php echo $area['id']; ?>]" id="score_<?php echo $area['id']; ?>"  value="<?php
                                                                    if (isset($score[$area['id']])) {
                                                                        echo $score[$area['id']];
                                                                        } else {
                                                                            echo '';
                                                                        }
                                                                        ?>" />
                                                                        <input type="hidden" name="area_count" id="area_count" value="<?php echo $count_area; ?>">
                                                                        <input type="hidden" name="area_id[]" id="area" value="<?php echo $area['id']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $sub_category1 = $this->Massessment->getSubCategory($area['id'],$innovation['program']);

                                                                        if (isset($sub_assesst)) {
                                                                            foreach ($sub_assesst as $sub) {
                                                                                if ($area['id'] == $sub['area_id']) {
                                                                                    $category_id1 = unserialize($sub['sub_category']);
                                                                                    $sub_score = unserialize($sub['sub_score']);
                                                                                }
                                                                            }
                                                                        }
                                                                        $area_subscore = '';
                                                                        foreach ($sub_category1 as $sub) {
                                                                            if (isset($category_id1) && in_array($sub['id'], $category_id1)) {
                                                                                $key = array_search($sub['id'], $category_id1);
                                                                                if ($sub_score[$key] == '-1') {
                                                                                    $area_subscore = $sub_score[$key];
                                                                                }
                                                                            }
                                                                        }

                                                                        /* customize */
                                                                        $sub_cate = $this->Massessment->getSubCategory($area['id'],$innovation['program']);
                                                                        $sub_count1 = count($sub_cate);

                                                                        if (isset($sub_assesst)) {
                                                                            foreach ($sub_assesst as $subs) {
                                                                                if ($area['id'] == $subs['area_id']) {
                                                                                    $cate_id = unserialize($subs['sub_category']);
                                                                                    $add_score = unserialize($subs['add_score']);
                                                                                }
                                                                            }
                                                                        }

                                                                        $check_addscore = 0;
                                                                        if (isset($cate_id) && in_array($sub_cate[0]['id'], $cate_id)) {
                                                                            $key1 = array_search($sub_cate[0]['id'], $cate_id);
                                                                            $subscore1 = $sub_score[$key1];
                                                                            $addscore1 = $add_score[$key1];
                                                                        }

                                                                        foreach ($add_score as $key => $value) {
                                                                            if ($value != '') {
                                                                                $check_addscore += count($value);
                                                                            }
                                                                        }

                                                    // $checked = ($area_subscore == '-1') ? "checked" : "";
                                                    // echo $display1 = ($area_subscore != '-1') ? "style='display:none'" : "";
                                                                        $checked = ($sub_count1 == $check_addscore) ? "checked" : "";
                                                                        $display1 = ($sub_count1 != $check_addscore) ? "style='display:none'" : "";
                                                                        /* end customize */
                                                                        ?>
                                                                        <div class="assessment_CheckBox">
                                                                            <input <?php echo $disabled; ?> type="checkbox" onclick="checkAll('<?php echo $area['id']; ?>')" <?php echo $checked ?> name="checkall[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="checkall<?php echo $area['id']; ?>_<?php echo $i; ?>" value="<?php echo $area['id']; ?>_<?php echo $i; ?>" class="pre-input checkbox allCheck_<?php echo $area['id']; ?>"/>
                                                                            <!-- <select <?php echo $disabled; ?> class="form-control select_box reasonall<?php echo $area['id']; ?>_<?php echo $i; ?>" name="reason[<?php echo $area['id']; ?>_<?php echo $i; ?>]" onchange="chooseReason('<?php echo $area['id']; ?>', this.value);" id="reasonall<?php echo $area['id']; ?>_<?php echo $i; ?>" <?php echo $display1; ?>>
                                                                                <option value="">--Select Reason--</option>
                                                                                <?php
                                                                                foreach ($reasons as $re) {
                                                                                    $selectsd = ($addscore1 == $re['id']) ? "selected" : "";
                                                                                    $selectbox_id = $re['id'];
                                                                                    echo "<option " . $selectsd . " value=" . $re['id'] . ">" . $re['name'] . "</option>";
                                                                                }
                                                                                ?>
                                                                            </select> -->
                                                                        </div>
                                                                        <label class="error droperror_<?php echo $area['id']; ?>" style="display:none" name="reasonerror<?php echo $area['id']; ?>_<?php echo $i; ?>" id="reasonerrorall<?php echo $area['id']; ?>_<?php echo $i; ?>"></label>
                                                                    </td>
                                                                    <?php if ($innovation['program'] == '3') { ?>
                                                                        <!-- Fetching db comments for values between 0 and 3 for pitch application -->
                                                                        <td><?php echo nl2br($area['no']); ?></td>
                                                                        <td><?php echo nl2br($area['low']); ?></td>
                                                                        <td><?php echo nl2br($area['medium']); ?></td>
                                                                        <td><?php echo nl2br($area['high']); ?></td>
                                                                    <?php } else { ?>
                                                                        <!-- Fetching db comments for values between 0 and 3 for incubation application -->
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    <?php } ?>
                                                                </tr>
                                                                <?php
                                                                $sub_category = $this->Massessment->getSubCategory($area['id'],$innovation['program']);
                                                                $sub_count = count($sub_category);
                                                                $i = 0;
                                                                if (isset($sub_assesst)) {
                                                                    foreach ($sub_assesst as $sub) {
                                                                        if ($area['id'] == $sub['area_id']) {
                                                                            $category_id = unserialize($sub['sub_category']);
                                                                            $sub_score = unserialize($sub['sub_score']);
                                                                            $add_score = unserialize($sub['add_score']);
                                                                        }
                                                                    }
                                                                }
                                                                foreach ($sub_category as $sub) {
                                                                    if (isset($category_id) && in_array($sub['id'], $category_id)) {
                                                                        $key = array_search($sub['id'], $category_id);
                                                                        $subscore = $sub_score[$key];
                                                                        $addscore = $add_score[$key];
                                                                    }
                                                                    $i++;
                                                                    ?>
                                                                    <tr class="child-row<?php echo $area['id']; ?> in-child" style="display:none;">
                                                                        <td><?php 
																		
																		if($innovation['program'] =='27' && $sub['category']=='Impact type'){
																			echo 'Environmental impact';
																			
																		}else{
																			echo $sub['category'];
																		}
																		#echo $sub['category'];

																		?></td>
                                                                        <td>
                                                                            <input type="text" class="pre-input area" style="width:70px" name="sub[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="sub<?php echo $area['id']; ?>_<?php echo $i; ?>" value="<?php
                                                                            if (isset($subscore) && $subscore != '-1') {
                                                                                echo $subscore;
                                                                                } else {
                                                                                    echo "";
                                                                                }
                                                                                ?>" <?php if ($subscore == '-1') echo "readonly"; ?> <?php echo $readonly; ?> />
                                                                                <input type="hidden" name="sub_count[<?php echo $area['id']; ?>]" id="sub_count" value="<?php echo $sub_count; ?>">
                                                                                <input  type="hidden" name="category_id[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="category_id<?php echo $area['id']; ?>_<?php echo $i; ?>" value="<?php echo $sub['id']; ?>">
                                                                                <input type="hidden" name="area" id="area_id" value="<?php echo $area['id']; ?>">
                                                                                <br/><label class="error" style="display:none" name="suberror<?php echo $area['id']; ?>_<?php echo $i; ?>" id="suberror<?php echo $area['id']; ?>_<?php echo $i; ?>"></label>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $checked = ($subscore == '-1') ? "checked" : "";
                                                                                $display1 = ($subscore != '-1') ? "style='display:none'" : "";
                                                                                ?>
                                                                                <input <?php echo $disabled; ?> type="checkbox" onclick="individualBox('<?php echo $area['id']; ?>', '<?php echo $i; ?>')" <?php echo $checked ?> name="check[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="check<?php echo $area['id']; ?>_<?php echo $i; ?>" value="<?php echo $area['id']; ?>_<?php echo $i; ?>" class="pre-input checkbox selCheck_<?php echo $area['id']; ?>"/>
                                                                                <!-- <select <?php echo $disabled; ?> class="form-control select_box dropCheck_<?php echo $area['id']; ?> reason<?php echo $area['id']; ?>_<?php echo $i; ?>" name="reason[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="reason<?php echo $area['id']; ?>_<?php echo $i; ?>" <?php echo $display1; ?>>
                                                                                    <option value="">--Select Reason--</option>
                                                                                    <?php
                                                                                    foreach ($reasons as $re) {
                                                                                        $selectsd = ($addscore == $re['id']) ? "selected" : "";
                                                                                        echo "<option " . $selectsd . " value=" . $re['id'] . ">" . $re['name'] . "</option>";
                                                                                    }
                                                                                    ?>
                                                                                </select> -->
                                                                                <br>
                                                                                <label class="error droperror_<?php echo $area['id']; ?>" style="display:none" name="reasonerror<?php echo $area['id']; ?>_<?php echo $i; ?>" id="reasonerror<?php echo $area['id']; ?>_<?php echo $i; ?>"></label>
                                                                            </td>
                                                                            <td><?php echo '0: '. $sub['no']; ?></td>
                                                                            <td><?php echo '1: '. $sub['low']; ?></td>
                                                                            <td><?php echo '2: '. $sub['medium']; ?></td>
                                                                            <td><?php echo '3: '. $sub['high']; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <tr class="child-row<?php echo $area['id']; ?> in-child" style="background: none repeat scroll 0 0 #E7F9CF; display:none;">
                                                                        <td><strong>Rationale</strong></td>
                                                                        <td><textarea class="pre-input" cols="30"  rows="3" name="rational[<?php echo $area['id']; ?>]" id="rational_<?php echo $area['id']; ?>" <?php echo $readonly; ?> ><?php
                                                                        if (isset($rational[$area['id']])) {
                                                                            echo $rational[$area['id']];
                                                                        } else {
                                                                            echo '';
                                                                        }
                                                                        ?></textarea></td>
                                                                        <td><strong>Risk</strong></td>
                                                                        <td><textarea class="pre-input" cols="30" rows="3" name="risk[<?php echo $area['id']; ?>]" id="risk_<?php echo $area['id']; ?>" <?php echo $readonly; ?>><?php
                                                                        if (isset($risk[$area['id']])) {
                                                                            echo $risk[$area['id']];
                                                                        } else {
                                                                            echo '';
                                                                        }
                                                                        ?></textarea></td>
                                                                        <td>&nbsp;</td>
                                                                        <td>&nbsp;</td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                <?php } ?>

                                                                <tr class="parent" id="rowtotal">
                                                                    <td><strong>Total</strong></td>
                                                                    <td>
                                                                        <input type="text" class="pre-input" style="width:70px" name="total_score" id="total_score" value="<?php
                                                                        if (isset($assesst[0]['total_score'])) {
                                                                            echo $assesst[0]['total_score'];
                                                                            } else {
                                                                                echo "";
                                                                            }
                                                                            ?>" readonly=""/>
                                                                            <input type="hidden" name="innovation_id" id="innovation_id" value="<?php echo $this->uri->segment('3'); ?>">
                                                                            <input type="hidden" name="assesst_id" id="assesst_id" value="<?php
                                                                            if (isset($assesst[0]['id'])) {
                                                                                echo $assesst[0]['id'];
                                                                                } else {
                                                                                    echo "";
                                                                                }
                                                                                ?>">
                                                                            </td>
                                                                            <td><strong>Total %</strong></td>
                                                                            <td>
                                                                                <input type="text" class="pre-input" style="width:70px" name="total_per" id="total_per" value="<?php
                                                                                if (isset($assesst[0]['total_per'])) {
                                                                                    echo $assesst[0]['total_per'];
                                                                                    } else {
                                                                                        echo "";
                                                                                    }
                                                                                    ?>" readonly=""/>
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="5"><textarea class="text-area-comment" rows="4" cols="100" name="comment" id="comment" placeholder="Comments" ><?php
                                                                                if (isset($assesst[0]['comment'])) {
                                                                                    echo $assesst[0]['comment'];
                                                                                } else {
                                                                                    echo "";
                                                                                }
                                                                                ?></textarea></td>
                                                                                <td colspan="2">
                                                <!--                                                <div class="dataTables_paginate paging_two_button" id="table1_paginate">
                                                                                                    <a role="button" tabindex="0" class="button save" id="save" aria-controls="table1" <?php echo $display; ?>>Save</a>
                                                                                                    <a href="<?php echo site_url('application/assessment_summary/' . $application_id); ?>" role="button" tabindex="0" class="button next" id="table1_next" aria-controls="table1">Next</a>
                                                                                                </div>-->
                                                                                            </td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </form>
                                                                            <div class="asseSummary_btns">
                                                                                <ul class="option-tab">
                                                                                    <li><a class="btn vital_yellow_btn save" id="save" href="javascript:void(0);" <?php echo $display; ?>>Save</a></li>
                                                                                    <li><a class="btn vital_yellow_btn next" id="submit" href="<?php echo site_url('application/assessment_summary/' . $application_id); ?>">Next</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </main>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal" id="scoringModal" tabindex="-1" role="dialog" data-backdrop="static">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">

                                                </div>
                                            </div>
                                        </div>

                                        <style>
                                            .inputplan-structureall{
                                                border-top:none;
                                            }
                                        </style>

                                        <?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable', 'multi_select' => 'multiselect')); ?>
<!-- <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.bootstrap.min.css">
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script> -->

    <script type="text/javascript">
        $(document).ready(function () {
            $('#scoring_table').DataTable({
                "bAutoWidth": false,
                "paging": false,
                "ordering": false,
                "searching": false,
                "info": false,
                "scrollX": false,
            // "fixedColumns": {
            //     leftColumns:2
            // },
        });
        });

        function export_xl() {
            var htmltable = document.getElementById('export_table');
            var html = htmltable.outerHTML;
            window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
        }

        $(document).ready(function () {
            setTotal();
            $('.select_box').change(function () {
                if ($(this).val() != '') {
                    $(this).siblings(".error").text('');
                }
            });

            $('.checkbox').change(function () {
				
                $('.score').keyup(function () {
                    var this_value = $(this).val();
                    if (this_value > 3) {
                        alert("You can't add greater than three");
                        $(this).val('');
                        var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                        $('.child-' + parent_html).each(function () {
                            var input_value = $(this).find(".pre-input").attr("type");
                            if (input_value == 'text') {
                                $(this).find(".pre-input").val('');
                            }
                        });
                    } else {
                        var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                        $('.child-' + parent_html).each(function () {
                            var input_value = $(this).find(".pre-input").attr("type");
                            if (input_value == 'text') {
                                $(this).find(".pre-input").val(this_value);
                            }
                        });
                    }
                });
                var select = '#reason' + $(this).val();
                var input = '#sub' + $(this).val();
                var reas = '#reasonerror' + $(this).val();
                $(select).toggle(this.checked);
                if ($(this).is(':checked')) { console.log('1');
                    var allid = $(this).attr('id');
                    if (allid == 'checkall' + $(this).val()) {
                        var checkallid = '#checkall' + $(this).val();
                        var reasonallid = '#reasonall' + $(this).val();
                        $(checkallid).prop('checked', true);
                        $(reasonallid).css('display', 'block');
                    }
                    var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                    $(this).parent().parent().find(".score").attr("readonly", "readonly");
                    $('.child-' + parent_html).each(function () {
                        var input_value = $(this).find(".pre-input").attr("type");
                        if (input_value == 'text') {
                            $(this).find(".pre-input").val('');
                            $(this).find(".pre-input").attr("readonly", "readonly");
                            $(this).find(".pre-input").prop('checked', true);
                        }
                    });
                } else { console.log('2');
                    var allid = $(this).attr('id');
                    if (allid == 'checkall' + $(this).val()) {
                        var checkallid = '#checkall' + $(this).val();
                        var reasonallid = '#reasonall' + $(this).val();
                        $(checkallid).prop('checked', false);
                        $(reasonallid).css('display', 'none');
                    }
                    var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                    $(this).parent().parent().find(".score").removeAttr("readonly");
                    $('.child-' + parent_html).each(function () {
                        var input_value = $(this).find(".pre-input").attr("type");
                        if (input_value == 'text') {
                            $(this).find(".pre-input").removeAttr("readonly");
                            $(this).find(".pre-input").prop('checked', false);
                        }
                    });
                }
                $('.area').keyup();
            });

            $('.score').keyup(function () {
                var this_value = $(this).val();
                if (this_value > 3) {
                    alert("You can't add greater than three");
                    $(this).val('');
                    var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                    $('.child-' + parent_html).each(function () {
                        var input_value = $(this).find(".pre-input").attr("type");
                        if (input_value == 'text') {
                            $(this).find(".pre-input").val('');
                        }
                    });
                } else {
                    var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                    $('.child-' + parent_html).each(function () {
                        var input_value = $(this).find(".pre-input").attr("type");
                        if (input_value == 'text') {
                            $(this).find(".pre-input").val(this_value);
                        }
                    });
                }
            });

            $("#assessor_employee").multiselect();
            var original = $('#asset_form').serialize();
            $(function () {
                $('.firstDiv').click(function () {
                    $('tr.parent').css("cursor", "pointer")
                    .attr("title", "Click to expand/collapse")
                    .siblings('.child-' + this.id).toggle('300');
                });
                $('tr.in-child')
                .css("cursor", "pointer")
                .attr("title", "Click to expand/collapse")
                .click(function () {
                    $(this).siblings('.child-' + this.id).toggle();
                });
            });

            $(".area").keyup(function () {
                var area_id = $(this).siblings("#area_id").val();
                var sub_count = $(this).siblings("#sub_count").val();
                var sub = 0;
                var count_sub = empty_count = 0;
                for (var i = 1; i <= sub_count; i++) {
                    if ($("#sub" + area_id + '_' + i).val() != '' && !$.isNumeric($("#sub" + area_id + '_' + i).val())) {
                        $("#sub" + area_id + '_' + i).focus();
                        var len = $("#sub" + area_id + '_' + i).val().length;
                        var str = $("#sub" + area_id + '_' + i).val().substring(0, len - 1);
                        $("#sub" + area_id + '_' + i).val(str);
                    } else {
                        if (parseInt($("#sub" + area_id + '_' + i).val()) > 3) {
                            $("#sub" + area_id + '_' + i).focus();
                            $("#suberror" + area_id + '_' + i).html("Enter number between 0 to 3").show().css('color', 'red');
                        } else {
                            if ($("#sub" + area_id + '_' + i).val() != '') {
                                var val = $("#sub" + area_id + '_' + i).val();
                                sub = parseFloat(sub) + parseFloat(val);
                            }
                        if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                            count_sub = parseInt(count_sub) + 1;
                        else
                            empty_count = empty_count + 1;
                        $("#suberror" + area_id + '_' + i).html("");
                    }
                }
            }

            var avg = '';
            if (sub == 0 && sub_count != empty_count)
                avg = 0;
            if (sub != 0 && count_sub != 0)
                avg = (sub / count_sub)
            if (avg % 1)
                avg = avg.toFixed(2);
            $("#score_" + area_id).val(avg);
            var total = 0;
            $('.score').each(function () {
                var val = ($(this).val() != '') ? $(this).val() : 0;
                total = parseFloat(total) + parseFloat(val);
            });

            var count_sub = 0;
            var sub_val = 0;
            var pre_area = 0;
            $('.area').each(function () {
                var area_id = $(this).siblings("#area_id").val();
                if (pre_area != area_id) {
                    var sub_count1 = $(this).siblings("#sub_count").val();
                    for (var i = 1; i <= sub_count1; i++) {
                        if ($("#sub" + area_id + '_' + i).val() != '') {
                            sub_val = parseFloat($("#sub" + area_id + '_' + i).val()) + sub_val;
                        }
                        if ($("#sub" + area_id + '_' + i).val() != '')
                            count_sub = parseInt(count_sub) + 1;
                    }
                }
                pre_area = area_id;
            });

            total = (total != 'NaN') ? total : '';
            if (total != '')
                total = total.toFixed(2);
            if (total != '') {
                $("#total_score").val(total);
            } else {
                $("#total_score").val('0');
            }

            var tot_count1 = parseInt(count_sub) * 3;
            total_per = 0;
            total_per = (sub_val / tot_count1) * 100;
            total_per = total_per.toFixed(2);
            if (total_per != '') {
                if (isNaN(total_per)) {
                    $("#total_per").val('0');
                } else {
                    $("#total_per").val(total_per);
                }
            }
        });

            $("#total_score, #total_per").focus(function () {
                var total = 0;
                $('.score').each(function () {
                    var val = ($(this).val() != '') ? $(this).val() : 0;
                    total = parseFloat(total) + parseFloat(val);
                });
                total = (total != 'NaN') ? total : '';
                if (total != '' && total != 'NaN') {
                    total = total.toFixed(2);
                    $("#total_score").val(total);
                }

                var count_sub = 0;
                var sub_val = 0;
                var pre_area = 0;
                $('.area').each(function () {
                    var area_id = $(this).siblings("#area_id").val();
                    if (pre_area != area_id) {
                        var sub_count1 = $(this).siblings("#sub_count").val();
                        for (var i = 1; i <= sub_count1; i++) {
                            if ($("#sub" + area_id + '_' + i).val() != '') {
                                sub_val = parseFloat($("#sub" + area_id + '_' + i).val()) + sub_val;
                            }
                        if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                            count_sub = parseInt(count_sub) + 1;
                    }
                }
                pre_area = area_id;
            });
                var tot_count1 = parseInt(count_sub) * 3;
                total_per = 0;
                total_per = (sub_val / tot_count1) * 100;
                total_per = total_per.toFixed(2);
                if (total_per != '')
                    $("#total_per").val(total_per);
            });

            $(".save").click(function () {
                $('.area').each(function () {
                    var area_id = $(this).siblings("#area_id").val();
                    var sub_count = $(this).siblings("#sub_count").val();
                    var sub = count_sub = empty_count = 0;
                    for (var i = 1; i <= sub_count; i++) {
                        if ($('#checkall' + area_id + '_' + i).is(':checked')) {
                            if ($("#reasonall" + area_id + '_' + i).val() == '') {
                                $("#reasonerrorall" + area_id + '_' + i).html("Please select a reason").show().css('color', 'red');
                                location.href = "#reasonall" + area_id + '_' + i;
                            } else {
                                $("#reasonerrorall" + area_id + '_' + i).html("");
                            }
                        }
                        if ($("#check" + area_id + '_' + i).is(':checked')) {
                            if ($("#reason" + area_id + '_' + i).val() == '') {
                                $("#reasonerror" + area_id + '_' + i).html("Please select a reason").show().css('color', 'red');
                                location.href = "#reason" + area_id + '_' + i;
                            } else {
                                $("#reasonerror" + area_id + '_' + i).html("");
                            }
                        } else {
                            if ($("#sub" + area_id + '_' + i).val() != '' && !$.isNumeric($("#sub" + area_id + '_' + i).val())) {
                                $("#sub" + area_id + '_' + i).focus();
                                var len = $("#sub" + area_id + '_' + i).val().length;
                                var str = $("#sub" + area_id + '_' + i).val().substring(0, len - 1);
                                $("#sub" + area_id + '_' + i).val(str);
                            } else {
                                if (parseInt($("#sub" + area_id + '_' + i).val()) > 3) {
                                    $("#sub" + area_id + '_' + i).focus();
                                    $("#suberror" + area_id + '_' + i).html("Enter number between 0 to 3").show().css('color', 'red');
                                } else {
                                    var val = ($("#sub" + area_id + '_' + i).val() != '') ? $("#sub" + area_id + '_' + i).val() : 0;
                                    sub = parseFloat(sub) + parseFloat(val);
                                if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                                    count_sub = parseInt(count_sub) + 1;
                                else
                                    empty_count = empty_count + 1;
                                $("#suberror" + area_id + '_' + i).html("");
                            }
                        }
                    }
                }
            });
                var tot_in = $("input:visible").length;
                var empty = 0;
                $("input:visible").each(function () {
                    if ($(this).val() == '')
                        empty = empty + 1;
                });
                if (empty == tot_in)
                    alert("Enter Enterprise Score to submit");
                else {
                    var errorval = 0;
                    var total = 0;
                    $('.score').each(function () {
                        var val = ($(this).val() != '') ? $(this).val() : 0;
                        total = parseFloat(total) + parseFloat(val);
                    });
                    total = (total != 'NaN') ? total : '';
                    if (total != '' && total != 'NaN')
                        $("#total_score").val(total);
                    var count_sub = 0;
                    var sub_val = 0;
                    var pre_area = 0;
                    $('.area').each(function () {
                        var area_id = $(this).siblings("#area_id").val();
                        if (pre_area != area_id) {
                            var sub_count1 = $(this).siblings("#sub_count").val();
                            for (var i = 1; i <= sub_count1; i++)
                            {
                                if ($("#sub" + area_id + '_' + i).val() != '')
                                {
                                    sub_val = parseFloat($("#sub" + area_id + '_' + i).val()) + sub_val;
                                }
                            if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                                count_sub = parseInt(count_sub) + 1;
                        }
                    }
                    pre_area = area_id;
                });
                    var tot_count1 = parseInt(count_sub) * 3;
                    total_per = 0;
                    total_per = (sub_val / tot_count1) * 100;
                    total_per = total_per.toFixed(2);
                    if (total_per != '')
                        $("#total_per").val(total_per);
                    $('.error').each(function () {
                        if ($('.error').text() != '')
                            errorval = errorval + 1;
                    });
                    if (errorval == 0) {
                        $("#asset_form").submit();
                    }
                }
            });
});

function chooseReason(id, select) {
    $('.dropCheck_' + id).val(select);
    if (select != '') {
        $('.droperror_' + id).text("");
    }
}

function checkAll(id) {
    var box_name = $('.allCheck_' + id);
    if (box_name.is(':checked')) {
        $('.selCheck_' + id).attr('checked');
        $('.dropCheck_' + id).css('display', 'block');
    } else {
        $('.selCheck_' + id).removeAttr('checked');
        $('.dropCheck_' + id).css('display', 'none');
        $('.droperror_' + id).css('display', 'none');
    }
}

function individualBox(area, id) {
    var box_name = $('#check' + area + '_' + id);
    if (box_name.is(':checked')) {
        $('.reason' + area + '_' + id).css('display', 'block');
    } else {
        $('.reason' + area + '_' + id).css('display', 'none');
    }
}

$(document).on('keyup', '.area', function () {
    setTotal();
});

function setTotal() {
    var scoreVal = '';
    $(".area").each(function () {
        var assign_score = $(this).val();
        if (assign_score != 'NaN' && assign_score != '')
            scoreVal += parseFloat(assign_score);
    });
    if (scoreVal == '') {
        $("#total_score").val('');
    }
}

$(".score").on("input", function (evt) {
    var self = $(this);
    self.val(self.val().replace(/[^0-9.]/g, ''));
});

$(document).ready(function () { 
    var program = "<?php echo $innovation['program']; ?>";
    var selectbox_id = "<?php echo $selectbox_id; ?>";
    var stage = "<?php echo $innovation['stage']; ?>";
    var pitch_deal_id = "<?php echo $innovation['id']; ?>";
	  console.log(stage);
    if (stage != '8') {
        $(".area").each(function () {
            $(".score").attr("readonly", "readonly");
            $(".pre-input").attr("readonly", "readonly");
            $(".checkbox").attr("disabled", true);
        });
    }

    if (program == '3' && pitch_deal_id != '16036' && pitch_deal_id != '14253') {
        $('#check8_4, #check9_1, #check10_1').prop('checked', true);
        $('#check8_4, #check9_1, #check10_1').attr("disabled", true);
        $('#check8_4, #check9_1, #check10_1').each(function () {
            if ($(this).is(':checked')) {
                var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                $(this).parent().parent().find(".select_box").css({display: "inline-block"});
                $(this).parent().parent().find(".select_box").val(selectbox_id);
                $(this).parent().parent().find(".select_box").attr("disabled", true);
                $(this).parent().parent().find(".score").attr("readonly", "readonly");
                $('.child-' + parent_html).each(function () {
                    var input_value = $(this).find(".pre-input").attr("type");
                    if (input_value == 'text') {
                        $(this).find(".pre-input").val('');
                        $(this).find(".pre-input").attr("readonly", "readonly");
                    }
                });
            }
        });
    }
});

</script>

</body>
</html>