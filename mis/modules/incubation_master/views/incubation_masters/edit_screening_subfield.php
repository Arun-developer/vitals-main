<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Villgro MIS</title>
    </head>

    <body>
        <?php
        $this->load->view('incubation_masters/header.php', array('page' => 'incubation_progress'));
        ?>
        <div class="vi-dashboard-vital onboardtabmenu wdt-100">
            <div class="container-fluid">
                <?php
                $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
                $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
                if ($successMsg != '') {
                    ?>
                    <div class="position-absolute d-flex flex-column p-4 toastPlace">
                        <div id="toast-container" aria-live="polite" aria-atomic="true">
                            <div id="toast-wrapper">
                                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                    <div class="toast-header bg-success text-white">
                                        <strong class="mr-auto"><?= $successMsg; ?></strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true" class="text-white">×</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                if ($errorMsg != '') {
                    ?>
                    <div class="position-absolute d-flex flex-column p-4 toastPlace">
                        <div id="toast-container" aria-live="polite" aria-atomic="true">
                            <div id="toast-wrapper">
                                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                    <div class="toast-header bg-danger text-white">
                                        <strong class="mr-auto"><?= $errorMsg; ?></strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true" class="text-white">×</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="display-hide deleteMsg">
                    <div class="position-absolute d-flex flex-column p-4 toastPlace">
                        <div id="toast-container" aria-live="polite" aria-atomic="true">
                            <div id="toast-wrapper">
                                <div class="toast deletetoast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                    <div class="toast-header bg-success text-white">
                                        <strong class="mr-auto">Record(s) deleted successfully</strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true" class="text-white">×</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('incubation_masters/master_sidemenu.php', array('page' => 'incubation_progress')); ?>
                            </div>
                            <div class="footer-link">
                                <p>copyright &copy; mis.villgroapps.org</p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">
                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                                        <span><a href="<?php echo base_url() . 'index.php/incubation_master/screening_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                        <h4>Edit Sub Field</h4>
                                    </div>
                                    <div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
                                        <ul class="vitals-links">
                                            <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                                        </ul>
                                    </div>

                                </div>

                                <div class="plan-structure-vital vital_windowScroll">
                                    <div class="tab-slider--container tab-content">
                                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                            <main class="page-content">
                                                <form method="post" name="insertEdit_screeningSub" id="insertEdit_screeningSub" action="<?php echo base_url() . 'index.php/incubation_master/insertEdit_screeningSub'; ?>" class="form" novalidate autocomplete="off">
                                                    <input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>" >
                                                    <input type="hidden" name="pid" value="<?php echo $this->uri->segment(4); ?>" >
                                                    <input type="hidden" name="criteria" value="<?php echo $criteria; ?>" >
                                                    <div class="inputplan-structureall plan-structure-new ">

                                                        <div class="row leaveLabel">
                                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                                <div class="form-group">
                                                                    <label>Parent Value<span>*</span></label>
                                                                    <select disabled name="parent_value" id="parent_value" class="form-control edit_cls">
                                                                        <option value="">--Select--</option>
                                                                        <?php foreach ($get_parent_value as $list) { ?>
                                                                            <option <?php
                                                                            if (isset($get_subfields->parent_value) && $get_subfields->parent_value != '') {
                                                                                if ($get_subfields->parent_value == $list) {
                                                                                    echo "selected";
                                                                                }
                                                                            }
                                                                            ?>  value="<?php echo $list; ?>" ><?php echo $list; ?></option>
                                                                            <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Label <span>*</span></label>
                                                                    <input disabled value="<?php
                                                                    if (isset($get_subfields->label) && $get_subfields->label != '') {
                                                                        echo $get_subfields->label;
                                                                    }
                                                                    ?>" name="label" id="label" class="form-control edit_cls" type="text" placeholder="">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Input Type<span>*</span></label>
                                                                    <select name="input_type" id="input_type" disabled class="form-control edit_cls">
                                                                        <option value="" >--Select--</option>
                                                                        <option <?php
                                                                        if (isset($get_subfields->input_type) && $get_subfields->input_type != '') {
                                                                            if ($get_subfields->input_type == 'Text') {
                                                                                echo "selected";
                                                                            }
                                                                        }
                                                                        ?> value="Text" >Text</option>
                                                                        <option <?php
                                                                        if (isset($get_subfields->input_type) && $get_subfields->input_type != '') {
                                                                            if ($get_subfields->input_type == 'Textarea') {
                                                                                echo "selected";
                                                                            }
                                                                        }
                                                                        ?> value="Textarea" >Textarea</option>
                                                                        <option <?php
                                                                        if (isset($get_subfields->input_type) && $get_subfields->input_type != '') {
                                                                            if ($get_subfields->input_type == 'Listbox') {
                                                                                echo "selected";
                                                                            }
                                                                        }
                                                                        ?> value="Listbox">Listbox</option>
                                                                        <option <?php
                                                                        if (isset($get_subfields->input_type) && $get_subfields->input_type != '') {
                                                                            if ($get_subfields->input_type == 'Radio') {
                                                                                echo "selected";
                                                                            }
                                                                        }
                                                                        ?> value="Radio">Radio</option>
                                                                        <option <?php
                                                                        if (isset($get_subfields->input_type) && $get_subfields->input_type != '') {
                                                                            if ($get_subfields->input_type == 'Checkbox') {
                                                                                echo "selected";
                                                                            }
                                                                        }
                                                                        ?> value="Checkbox" >Checkbox</option>
                                                                        <option <?php
                                                                        if (isset($get_subfields->input_type) && $get_subfields->input_type != '') {
                                                                            if ($get_subfields->input_type == 'File') {
                                                                                echo "selected";
                                                                            }
                                                                        }
                                                                        ?> value="File" >File</option>
                                                                        <option <?php
                                                                        if (isset($get_subfields->input_type) && $get_subfields->input_type != '') {
                                                                            if ($get_subfields->input_type == 'Group') {
                                                                                echo "selected";
                                                                            }
                                                                        }
                                                                        ?> value="Group" >Group</option>

                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Status<span>*</span></label>
                                                                    <select name="status" id="status"  disabled class="form-control edit_cls">
                                                                        <option value="">--Select--</option>
                                                                        <option <?php if ($get_subfields->status == 1) echo"selected"; ?> value="1" >Approved</option>
                                                                        <option <?php if ($get_subfields->status == 0) echo"selected"; ?> value="0">Disapproved </option></select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Required <span>*</span></label>
                                                                    <input type="radio" <?php
                                                                    if (isset($get_subfields->required) && $get_subfields->required != '') {
                                                                        if ($get_subfields->required == 'yes') {
                                                                            echo "checked";
                                                                        }
                                                                    }
                                                                    ?> value="yes" name="required">Yes
                                                                    <input type="radio" <?php
                                                                    if (isset($get_subfields->required) && $get_subfields->required != '') {
                                                                        if ($get_subfields->required == 'no') {
                                                                            echo "checked";
                                                                        }
                                                                    }
                                                                    ?> value="no"style="margin-left: 20px;" name="required">No
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Class<span>*</span></label>
                                                                    <input name="class" value="<?php
                                                                    if (isset($get_subfields->class) && $get_subfields->class != '') {
                                                                        echo $get_subfields->class;
                                                                    }
                                                                    ?>" id="class" disabled class="form-control edit_cls" type="text" placeholder="">
                                                                </div>
                                                                <?php
                                                                $value_lists = array();
                                                                $add_val_style = 'display:none;';
                                                                if ($get_subfields->input_type == 'Radio' || $get_subfields->input_type == 'Listbox' || $get_subfields->input_type == 'Checkbox') {
                                                                    $add_val_style = 'display:block;';
                                                                    $value_lists = unserialize($get_subfields->value);
                                                                }
                                                                ?>

                                                                <?php
                                                                if (count($value_lists) > 0) {
                                                                    $i = 0;
                                                                    foreach ($value_lists as $lits) {
                                                                        ?>
                                                                        <div id="add_value"  style="<?php echo $add_val_style; ?>" class="form-group value_cls_div">
                                                                            <?php if ($i == 0) { ?><label>Values<span>*</span></label> <?php } ?>
                                                                            <input value="<?php echo $lits; ?>" name="value[]"  style="width: 80%;display: initial;" disabled class="form-control edit_cls value_cls" type="text" placeholder="">
                                                                            <?php if ($i == 0) { ?><a href="<?= base_url() . 'index.php/master/visitors_log/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a><?php } else { ?>
                                                                                <a href="javascript:void(0)" class="master_deluser clr_red" id="delLocation"><i class="fas fa-trash-alt"></i>Remove</a>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                } else {
                                                                    ?>

                                                                    <div style="display:none;" class="form-group add_value value_cls_div">
                                                                        <label>Values<span>*</span></label>
                                                                        <input  name="value[]"  style="width: 80%;display: initial;" disabled class="form-control edit_cls value_cls" type="text" placeholder="">
                                                                        <a href="<?= base_url() . 'index.php/master/visitors_log/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a>
                                                                    </div>

                                                                <?php } ?>

                                                                <div id="append_value" class="form-group"></div>

                                                            </div>

                                                        </div>
                                                        <input type="hidden" id="edit_status">
                                                        <div id="submit_btn_cls" style="display:none;" >
                                                            <ul class="vitals-links">
                                                                <li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100"></input></li>
                                                                <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                            </ul>
                                                        </div>

                                                        <div class="table_configcontentnew pad-bt0">
                                                            <div class="tabpanel-title">
                                                                <div class="row">
                                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                                    </div>
                                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                                        <ul class="milestone-links">
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </main>
                                        </div>
                                    </div>
                                </div>


                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">

            $('#insertEdit_screeningSub').validate({
                rules: {
                    parent_value: {
                        required: true
                    },
                    label: {
                        required: true
                    },
                    input_type: {
                        required: true
                    },
                    class: {
                        required: true
                    },
                    "value[]": {
                        required: true
                    },
                    "status": {
                        required: true
                    },
                },
                messages: {
                    parent_value: "Select paraent Value",
                    label: "Enter Label",
                    input_type: "Enter Input Type",
                    class: "Enter Class",
                    'value[]': "Enter Value",
                    status: "Select Status"
                }
            });

            $(".edt_btnVital").on("click", function (evt) {
                $("#append_value").append('<div  class="form-group append_value"><input name="value[]" style="width: 80%;display: initial;"  class="form-control value_cls" type="text" placeholder=""> <a href="javascript:void(0)" class="master_deluser clr_red" id="delLocation"><i class="fas fa-trash-alt"></i>Remove</a></div>');
                return false;
            });

            $(document).on('change', '#input_type', function () {
                input_type = $(this).val();
                $("#add_value").css('display', 'none');
                if (input_type == 'Listbox' || input_type == 'Radio' || input_type == 'Checkbox') {
                    $("#add_value").css('display', 'block');
                } else {
                    $(".value_cls").val('');
                    $(".append_value").remove();
                    //$(".value_cls").closest('div').remove();
                }
            });

            $(document).on('click', '.summaryEdit', function () {

                $("#edit_status").val("1");
                $(".edit_cls").attr("disabled", false);
                $(".multiselect").attr("disabled", false);
                $("#submit_btn_cls").css("display", "block");
                $(".edit").addClass("activeTabs");
            });


            $(document).ready(function () {
                $('.nav-tabs').scrollingTabs({
                    enableSwiping: true
                }).on('ready.scrtabs', function () {
                    $('.tab-content').show();
                });
                $('#navLoad').removeClass('display-hide');
                $('.vital_windowScroll').css({
                    'height': (($(window).height()) - 190) + 'px'
                });
                $('.toast').toast('show');
                setTimeout(function () {
                    $('.success').addClass('display-hide');
                }, 3000);
                $(document).on('click', '.master_deluser', function () {
                    $(this).closest('div').remove();
                });
            });

            $(document).on('click', '#submit_btn', function (e) {
                if (!$("#insertEdit_screeningSub").valid()) {
                    e.preventDefault();
                } else {
                    $('#insertEdit_screeningSub').submit();
                }
            });


        </script>

        <script>
            // Window Height
            // ---------------------------------------
            $(document).ready(function () {
                $('.vital_windowScroll').css({
                    'height': (($(window).height()) - 190) + 'px'
                });

                $('#multiselect, #accessibleTo').multiselect({
                    buttonWidth: '100%',
                    includeSelectAllOption: true,
                    nonSelectedText: 'Select an Option'
                });
            });
            function getSelectedValues() {
                var selectedVal = $("#multiselect, #accessibleTo").val();
                for (var i = 0; i < selectedVal.length; i++) {
                    if (window.CP.shouldStopExecution(0))
                        break;

                    function innerFunc(i) {
                        setTimeout(function () {
                            location.href = selectedVal[i];
                        }, i * 2000);
                    }
                    innerFunc(i);
                }
                window.CP.exitedLoop(0);
            }
        </script>

    </body>

</html>