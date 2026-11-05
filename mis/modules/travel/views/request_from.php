<?php
$this->load->view('vitals_header.php', array('main_menu' => 'travellist', 'page_title' => 'Travel Request Form', 'module' => 'travel_accom'));
?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'travellist')); ?>
        </div>

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
                        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
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

        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content pad-hr15">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Travel Request Form</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <form method="post" id="travelrequest_form" name="travelrequest_form" action="<?php echo base_url() . 'index.php/travel/approval_form'; ?>" class="form" novalidate autocomplete="off">
                        <div style="height: 20px;"></div>
                        <div class="table_configcontentnew pad-bt0">
                            <div class="tabpanel-title">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                        <ul class="milestone-links">
                                            <li class="brd-left-onboard">
                                                <a><i></i>&nbsp;Person's Details</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                        <ul class="milestone-links">
                                            <li class="brd-left-onboard">
                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                            <table id="travel_request_form" class="table table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th width="18px" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
                                        <th width="35%">Person's Names</th>
                                        <th width="20%">Age</th>
                                        <th width="20%">Sex</th>
                                        <th width="20%">Mobile No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd row_cls_0">
                                        <td class="sorting_1" tabindex="0">
                                            <!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
                                        </td>
                                        <td id="set_user_type_0">
                                            <select class="form-control user_name set_username_0" data-attr="count_0" name="name[]">
                                                <option value="">--Select--</option>
                                                <?php foreach ($userList as $list) { ?>
                                                    <option value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
                                                <?php } ?>
                                                <option value="other">Other</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control commonAlphaNum age_0" type="text" value="" name="age[]">
                                        </td>
                                        <td>
                                            <select class="form-control gender_0" name="sex[]">
                                                <option value="">--Select--</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control commonAlphaNum mobile_0" type="text" value="" name="mobile[]">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="delete_ids" id="delete_ids" />
                        <br>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <h4 style="font-size: 17px;padding: 0px 0px 0px;margin: 0;letter-spacing: 0.5px;">Journey type</h4>
                                <ul class="vitals-links">

                                    <li class="mob_fulfill">
                                        <label style="font-size: 12px !important;"></label>
                                        <div class="form-group has-search-right mar-bt8 wdt_100">
                                            <input type="radio" name="journey_type" onclick="showJourny('one')" value="one" checked="checked" style="margin-right: 10px;">One Way
                                        </div>
                                    </li>
                                    <li class="mob_fulfill">
                                        <label style="font-size: 12px !important;"></label>
                                        <div class="form-group has-search-right mar-bt8 wdt_100">
                                            <input type="radio" name="journey_type" value="round" onclick="showJourny('round')" style="margin-right: 10px;">Round Trip
                                        </div>
                                    </li>
                                    <li class="mob_fulfill">
                                        <label style="font-size: 12px !important;"></label>
                                        <div class="form-group has-search-right mar-bt8 wdt_180">
                                            <input type="radio" name="journey_type" onclick="showJourny('multiple')" value="multiple" style="margin-right: 10px;">Multiple
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="multiple_from" style="display:none;" >
                            <div class="table_configcontentnew pad-bt0">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                            <ul class="milestone-links">
                                                <li class="brd-left-onboard">
                                                    <a><i></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                            <ul class="milestone-links">
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="multiform_addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                <table id="multiple_request_form" class="table table-hover dt-responsive">
                                    <thead>
                                        <tr>
                                            <th width="18px" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
                                            <th width="15%">Date of Travel</th>
                                            <th width="15%">Location From</th>
                                            <th width="15%">Destination To</th>
                                            <th width="15%">Start Time</th>
                                            <th width="15%">End Time</th>
                                            <th width="15%">Travel Mode</th>
                                            <th width="15%">Any Preferred Train/Flight</th>
                                            <th width="15%">Date of Accommodation</th>
                                            <th width="15%">Date of Accommodation To</th>
                                            <th width="15%">Location Preference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="sorting_1" tabindex="0"></td>
                                        <td>
                                            <input placeholder="dd-mm-yy" class="form-control edit_cls date_of_travel dof" name="date_of_travel[]" >
                                        </td>
                                        <td>
                                            <input class="form-control edit_cls"  id="destination_from" name="destination_from[]">
                                        </td>
                                        <td>
                                            <input class="form-control edit_cls" id="destination_to" name="destination_to[]">
                                        </td>
                                        <td>
                                            <select name="travel_time_start[]" placeholder="dd-mm-yyyy" id="travel_time_start" class="form-control edit_cls">
                                                <option value="">--Select--</option>
                                                <?php
                                                $attr_time = '';
                                                for ($am = 1; $am <= 12; $am++) {
                                                    if ($am > 9) {
                                                        $attr_time = $am . ':00';
                                                    } else {
                                                        $attr_time = '0' . $am . ':00';
                                                    }
                                                    ?>
                                                    <option data-attr="<?php echo $attr_time . ' AM'; ?>" value="<?= $am; ?>AM"><?= $am; ?> AM</option>
                                                    <?php
                                                }
                                                $attr_time_pm = '';
                                                for ($e = 1; $e <= 12; $e++) {
                                                    if ($e > 9) {
                                                        $attr_time_pm = $e . ':00';
                                                    } else {
                                                        $attr_time_pm = '0' . $e . ':00';
                                                    }
                                                    ?>
                                                    <option data-attr="<?php echo $attr_time_pm . ' PM'; ?>" value="<?= $e; ?>PM"><?= $e; ?> PM</option>
                                                <?php } ?>
                                            </select>
                                        </td><td>
                                            <select name="travel_time_end[]"  placeholder="dd-mm-yyyy" id="travel_time_end" class="form-control edit_cls">
                                                <option value="">--Select--</option>
                                                <?php
                                                $end_attr_time = '';
                                                for ($am = 1; $am <= 12; $am++) {
                                                    if ($am > 9) {
                                                        $end_attr_time = $am . ':00';
                                                    } else {
                                                        $end_attr_time = '0' . $am . ':00';
                                                    }
                                                    ?>
                                                    <option data-attr="<?php echo $end_attr_time . ' AM';
                                                    ; ?>" value="<?= $am; ?>AM"><?= $am; ?> AM</option>
                                                    <?php
                                                }
                                                $end_attr_time_pm = '';
                                                for ($e = 1; $e <= 12; $e++) {
                                                    if ($e > 9) {
                                                        $end_attr_time_pm = $e . ':00';
                                                    } else {
                                                        $end_attr_time_pm = '0' . $e . ':00';
                                                    }
                                                    ?>
                                                    <option data-attr="<?php echo $end_attr_time_pm . ' PM'; ?>" value="<?= $e; ?>PM"><?= $e; ?> PM</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="travel_mode[]"  id="travel_mode" class="form-control edit_cls">
                                                <option value="">--Select--</option>
                                                <?php foreach ($traveMode as $list) { ?>
                                                    <option value="<?php echo $list['master_id']; ?>"><?php echo $list['master_name']; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control commonAlphaNum" type="text" value="" name="preferred_train_flight[]">

                                        </td><td>
                                            <input class="form-control datepicker" type="text" value="" placeholder="dd-mm-yy" name="date_of_accomodation[]">

                                        </td>
                                        <td>
                                            <input type="text" class="form-control datepicker"  placeholder="dd-mm-yy" name="date_of_accomodation_to[]" >
                                        </td>
                                        <td>
                                            <input class="form-control commonAlphaNum" type="text" value="" name="location_preference[]">
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                            <div id="submit_btn_cls">
                                <ul class="vitals-links">
                                    <li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100" value="Save">

                                    </li>
                                    <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                </ul>
                            </div>
                        </div>

                        <hr>
                        <main class="page-content other_travel_form">
                            <div class="row leaveLabel">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Date of Travel<span>*</span></label>
                                        <input  type="text" name="date_of_travel[]" class="form-control edit_cls date_of_travel dof" placeholder="dd-mm-yyyy">
                                    </div>
                                    <div class="form-group">
                                        <label>Location From<span>*</span></label>
                                        <input class="form-control edit_cls"  id="destination_from" name="destination_from[]">
                                    </div>
                                    <div class="form-group">
                                        <label>Destination To<span>*</span></label>
                                        <input class="form-control edit_cls"  id="destination_to" name="destination_to[]">
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-6">
                                            <div class="form-group">
                                                <label>Start Time<small class="text-danger"></small></label>
                                                <div class="mar-bt8  wdt_200">
                                                    <select name="travel_time_start[]" data-attr-end-id= "endtime_err_1" data-attr-err-id= "starttime_err_1" id="travel_time_start" class="starttime_1 start_time_cls form-control edit_cls">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        $attr_time1 = '';
                                                        for ($am = 1; $am <= 12; $am++) {
                                                            if ($am > 9) {
                                                                $attr_time1 = $am . ':00';
                                                            } else {
                                                                $attr_time1 = '0' . $am . ':00';
                                                            }
                                                            ?>
                                                            <option data-attr="<?php echo $attr_time1 . ' AM'; ?>" data-attr-type="am" value="<?= $am; ?>AM"><?= $am; ?> AM</option>
                                                            <?php
                                                        }
                                                        $attr_time_pm1 = '';
                                                        for ($e = 1; $e <= 12; $e++) {
                                                            if ($e > 9) {
                                                                $attr_time_pm1 = $e . ':00';
                                                            } else {
                                                                $attr_time_pm1 = '0' . $e . ':00';
                                                            }
                                                            ?>
                                                            <option data-attr="<?php echo $attr_time_pm1 . ' PM'; ?>" data-attr-type="pm" value="<?= $e; ?>PM"><?= $e; ?> PM</option>
                                                        <?php } ?>
                                                    </select>
                                                    <div id="starttime_err_1"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-6">
                                            <div class="form-group">
                                                <label>End Time<small class="text-danger"></small></label>
                                                <div class="mar-bt8  wdt_200">
                                                    <select data-attr-start-id= "starttime_err_1" data-attr-err-id= "endtime_err_1" name="travel_time_end[]"  id="travel_time_end" class="endtime_1 end_time_cls form-control edit_cls">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        $attr_time_end1 = '';
                                                        for ($am = 1; $am <= 12; $am++) {
                                                            if ($am > 9) {
                                                                $attr_time_end1 = $am . ':00';
                                                            } else {
                                                                $attr_time_end1 = '0' . $am . ':00';
                                                            }
                                                            ?>
                                                            <option data-attr="<?php echo $attr_time_end1 . ' AM'; ?>" data-attr-type="am" value="<?= $am; ?>AM"><?= $am; ?> AM</option>
                                                            <?php
                                                        }
                                                        $attr_time_end_pm1 = '';
                                                        for ($e = 1; $e <= 12; $e++) {
                                                            if ($e > 9) {
                                                                $attr_time_end_pm1 = $e . ':00';
                                                            } else {
                                                                $attr_time_end_pm1 = '0' . $e . ':00';
                                                            }
                                                            ?>
                                                            <option data-attr="<?php echo $attr_time_end_pm1 . ' PM'; ?>" data-attr-type="pm" value="<?= $e; ?>PM"><?= $e; ?> PM</option>
                                                        <?php } ?>
                                                    </select>
                                                    <div id="endtime_err_1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Travel Mode<span>*</span></label>
                                        <select name="travel_mode[]"  id="travel_mode" class="form-control edit_cls">
                                            <option value="">--Select--</option>
                                            <?php foreach ($traveMode as $list) { ?>
                                                <option value="<?php echo $list['master_id']; ?>"><?php echo $list['master_name']; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Any Preferred Train/Flight</label>
                                        <input class="form-control edit_cls"  id="preferred_train_flight" name="preferred_train_flight[]">
                                    </div>
                                    <div class="form-group">
                                        <label>Accommodation Details</label>
                                        <input type="radio" name="accomodation[]" class="accomodation_cls" value="yes"> Yes
                                        <input type="radio" name="accomodation[]" checked class="accomodation_cls" value="no"> No
                                    </div>
                                    <div id="accommodation_status" style="display:none;">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-6">
                                                <div class="form-group">
                                                    <label>Date of Accommodation From</label>
                                                    <div class="position-relative">
                                                        <div class="form-group mar-bt8  wdt_140">
                                                            <input  type="text" id="date_from"  placeholder="dd-mm-yyyy" name="date_of_accomodation[]" class="form-control edit_cls" placeholder="dd-mm-yyyy">
                                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-6">
                                                <div class="form-group">
                                                    <label>Date of Accommodation To</label>
                                                    <div class="position-relative">
                                                        <div class="form-group mar-bt8  wdt_140">
                                                            <input  type="text" id="date_to" name="date_of_accomodation_to[]"  placeholder="dd-mm-yyyy" class="form-control edit_cls" placeholder="dd-mm-yyyy">
                                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Location Preference<span></span></label>
                                            <input class="form-control edit_cls" id="location_preference" name="location_preference[]">
                                        </div>
                                    </div>

                                    <div id="form_type" style="display:none;">
                                        <div class="form-group">
                                            <label>Date of Return<small class="text-danger">*</small></label>
                                            <input class="form-control edit_cls" id="date_of_return" name="date_of_return[]">
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-6">
                                                <div class="form-group">
                                                    <label>Return Start Time</label>
                                                    <div class="mar-bt8  wdt_200">
                                                        <select  data-attr-end-id= "r_endtime_err_1" data-attr-err-id= "r_starttime_err_1" name="travel_time_start_return[]" id="travel_time_start_return" class="return_start_time_cls form-control edit_cls">
                                                            <option value="">--Select--</option>

                                                            <?php
                                                            $Rattr_time1 = '';
                                                            for ($am = 1; $am <= 12; $am++) {
                                                                if ($am > 9) {
                                                                    $Rattr_time1 = $am . ':00';
                                                                } else {
                                                                    $Rattr_time1 = '0' . $am . ':00';
                                                                }
                                                                ?>
                                                                <option data-attr="<?php echo $Rattr_time1 . ' AM'; ?>" value="<?= $am; ?>AM"><?= $am; ?> AM</option>
                                                                <?php
                                                            }
                                                            $Rattr_time_pm1 = '';
                                                            for ($e = 1; $e <= 12; $e++) {
                                                                if ($e > 9) {
                                                                    $Rattr_time_pm1 = $e . ':00';
                                                                } else {
                                                                    $Rattr_time_pm1 = '0' . $e . ':00';
                                                                }
                                                                ?>
                                                                <option data-attr="<?php echo $Rattr_time_pm1 . ' PM'; ?>" value="<?= $e; ?>PM"><?= $e; ?> PM</option>
                                                            <?php } ?>
                                                        </select>
                                                        <div id="r_starttime_err_1"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-6">
                                                <div class="form-group">
                                                    <label>Return End Time<small class="text-danger">*</small></label>
                                                    <div class="mar-bt8  wdt_200">
                                                        <select data-attr-start-id= "r_starttime_err_1" data-attr-err-id= "r_endtime_err_1"  name="travel_time_end_return[]" id="travel_time_end_return" class="form-control edit_cls return_end_time_cls">
                                                            <option value="">--Select--</option>
                                                            <?php
                                                            $Rattr_end_time1 = '';
                                                            for ($am = 1; $am <= 12; $am++) {
                                                                if ($am > 9) {
                                                                    $Rattr_end_time1 = $am . ':00';
                                                                } else {
                                                                    $Rattr_end_time1 = '0' . $am . ':00';
                                                                }
                                                                ?>
                                                                <option data-attr="<?php echo $Rattr_end_time1 . ' AM'; ?>"  value="<?= $am; ?>AM"><?= $am; ?>AM</option>
                                                                <?php
                                                            }
                                                            $Rattr_end_pm_time1 = '';
                                                            for ($e = 1; $e <= 12; $e++) {
                                                                if ($e > 9) {
                                                                    $Rattr_end_pm_time1 = $e . ':00';
                                                                } else {
                                                                    $Rattr_end_pm_time1 = '0' . $e . ':00';
                                                                }
                                                                ?>
                                                                <option data-attr="<?php echo $Rattr_end_pm_time1 . ' PM'; ?>" value="<?= $e; ?>PM"><?= $e; ?>PM</option>
                                                            <?php } ?>
                                                        </select>
                                                        <div id="r_endtime_err_1"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Travel Mode for Return<small class="text-danger">*</small></label>
                                            <select name="travel_mode_return[]" id="travel_mode_return" class="form-control edit_cls">
                                                <option value="">--Select--</option>
                                                <?php foreach ($traveMode as $list) { ?>
                                                    <option value="<?php echo $list['master_id']; ?>"><?php echo $list['master_name']; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Any preferred Train/Flight For Return</label>
                                            <input class="form-control edit_cls" id="preferred_train_flight_return" name="preferred_train_flight_return[]">
                                        </div>
                                    </div>

                                    <div id="submit_btn_cls">
                                        <ul class="vitals-links">
                                            <li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100" value="Next"></li>
                                            <li><a href="<?php echo base_url(); ?>index.php/traveladmin/requestlist/pending" class="wdt_100 vital_bordered_btn">Back</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </form>
                </div>

            </main>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about to delete <span id="delCount"></span> selected row, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<script type="text/javascript">


    $('#travelrequest_form').validate({
        rules: {
            "name[]": "required",
            "date_of_travel[]": "required",
            "destination_from[]": "required",
            "destination_to[]": "required",
            "travel_mode[]": "required",
            "travel_mode_return[]": "required",
            "date_of_return[]": "required",
        },
        messages: {
            "name[]": "Select person",
            "date_of_travel[]": "Select date",
            "destination_from[]": "Enter location",
            "destination_to[]": "Enter destination",
            "travel_mode[]": "Enter travel mode",
            "travel_mode_return[]": "Select travel mode",
            "date_of_return[]": "Enter Date Return",
        }
    });


    err_count = 0;
    $(document).on('change', '.start_time_cls', function (e) {
        date_err = err_type = 0;
        var appent_err_end_id = $(this).attr('data-attr-end-id');
        var appent_err_id = $(this).attr('data-attr-err-id');
        var current_time = $('option:selected', this).attr('data-attr');
        var current_time_out = $(".end_time_cls").find('option:selected').attr('data-attr');
        var currentdate = new Date();
        var current_date = currentdate.getDate();
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var current_month = currentdate.getMonth();
        var current_month = months[current_month];
        var current_year = currentdate.getFullYear();

        var date1 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time);
        var date2 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time_out);

        $("#" + appent_err_id).html('');
        $("#" + appent_err_end_id).html('');
        if (current_time != '' && current_time_out != '') {
            if (date1 > date2) {
                date_err = 1;
                err_type = 1;
                $("#" + appent_err_id).html('<label for="log_date" class="error">Enter valid Time</label>');
            }
        }
    });
    $(document).on('change', '.end_time_cls', function (e) {
        var appent_err_start_id = $(this).attr('data-attr-start-id');
        var appent_err_id = $(this).attr('data-attr-err-id');
        date_err = err_type = 0;
        var current_time = $('option:selected', this).attr('data-attr');
        var current_time_in = $(".start_time_cls").find('option:selected').attr('data-attr');
        var currentdate = new Date();
        var current_date = currentdate.getDate();

        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var current_month = currentdate.getMonth();
        var current_month = months[current_month];

        var current_year = currentdate.getFullYear();
        var date1 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time);
        var date2 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time_in);
        $("#" + appent_err_id).html('');
        $("#" + appent_err_start_id).html('');
        if (current_time != '' && current_time_in != '') {
            if (date1 < date2) {
                date_err = 1;
                err_type = 2;
                $("#" + appent_err_id).html('<label for="log_date" class="error">Enter valid Time</label>');
            }
        }
    });



    $(document).on('change', '.return_start_time_cls', function (e) {
        date_err = err_type = 0;
        var appent_err_end_id = $(this).attr('data-attr-end-id');
        var appent_err_id = $(this).attr('data-attr-err-id');
        var current_time = $('option:selected', this).attr('data-attr');
        var current_time_out = $(".return_end_time_cls").find('option:selected').attr('data-attr');
        var currentdate = new Date();
        var current_date = currentdate.getDate();
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var current_month = currentdate.getMonth();
        var current_month = months[current_month];
        var current_year = currentdate.getFullYear();

        var date1 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time);
        var date2 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time_out);

        $("#" + appent_err_id).html('');
        $("#" + appent_err_end_id).html('');
        if (current_time != '' && current_time_out != '') {
            if (date1 > date2) {
                date_err = 1;
                err_type = 1;
                $("#" + appent_err_id).html('<label for="log_date" class="error">Enter valid Time</label>');
            }
        }
    });
    $(document).on('change', '.return_end_time_cls', function (e) {
        date_err = err_type = 0;

        var appent_err_start_id = $(this).attr('data-attr-start-id');
        var appent_err_id = $(this).attr('data-attr-err-id');

        var current_time = $('option:selected', this).attr('data-attr');
        var current_time_in = $(".return_start_time_cls").find('option:selected').attr('data-attr');
        var currentdate = new Date();
        var current_date = currentdate.getDate();

        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var current_month = currentdate.getMonth();
        var current_month = months[current_month];

        var current_year = currentdate.getFullYear();
        var date1 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time);
        var date2 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time_in);
        $("#" + appent_err_id).html('');
        $("#" + appent_err_start_id).html('');

        if (current_time != '' && current_time_in != '') {
            if (date1 < date2) {
                alert();
                date_err = 1;
                err_type = 2;
                $("#" + appent_err_id).html('<label for="log_date" class="error">Enter valid Time</label>');
            }
        }

    });


    $(document).on('click', '#submit_btn', function (e) {
        console.log(err_count);
        $("#travelrequest_form").valid();
        if ($("#travelrequest_form").valid() == true && err_type == 0) {
            $("#travelrequest_form").submit()
        }
        return false;
    });

    function removeRow(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }

    function removeRow_mf(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }

    $(document).ready(function () {
                                                    //$('.datepicker').datepicker({changeMonth: true, changeYear: true, dateFormat: "dd-mm-yy"});
                                                    //$('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop() + 170);

                                                    var journey_type = $("input[name=journey_type]").val();
                                                    $("#multiple_request_form :input").prop("disabled", false);
                                                    if (journey_type == 'one') {
                                                        $("#multiple_request_form :input").prop("disabled", true);
                                                        $("#form_type :input").prop("disabled", true);
                                                    }
                                                });

    function showJourny(value) {
        err_type = 0;
        $("#multiple_request_form :input").prop("disabled", false);
        $(".other_travel_form :input").prop("disabled", false);
        $("#form_type :input").prop("disabled", false);
        $(".edit_cls ").val('');
        $(".hasDatepicker").val('');
        $(".multiple_from").css('display', 'none');
        $(".other_travel_form").css('display', 'none');
        if (value == 'round') {
            $("#multiple_request_form :input").prop("disabled", true);
            $(".other_travel_form").css('display', 'block');
            $("#form_type").css('display', 'block');
        } else if (value == 'one') {
            $("#multiple_request_form :input").prop("disabled", true);
            $("#form_type :input").prop("disabled", true);
            $(".other_travel_form").css('display', 'block');
            $("#form_type").css('display', 'none');

        } else if (value == 'multiple') {
            $(".other_travel_form :input").prop("disabled", true);
            $("#form_type :input").prop("disabled", true);
            $(".multiple_from").css('display', 'block');
            $(".other_travel_form").css('display', 'none');
            $('.datepicker').datepicker({changeMonth: true, changeYear: true, dateFormat: "dd-mm-yy"});
        }
    }

    $(document).on('click', '.accomodation_cls', function () {
        var current_val = $(this).val();
        $("#accommodation_status").css('display', 'none');
        if (current_val == 'yes') {
            $("#accommodation_status").css('display', 'block');
        }
    });

    $(document).on('click', '.summaryEdit', function () {
        $("#edit_status").val("1");
        $(".edit_cls").attr("disabled", false);
        $(".multiselect").attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
    });

                                                //dof


                                                $('#date_of_return').datepicker({
                                                    dateFormat: "dd-mm-yy",
                                                    minDate: 'today'
                                                });

                                                $('.date_of_travel').datepicker({
                                                    dateFormat: "dd-mm-yy",
                                                    minDate: 'today',
                                                    onSelect: function (startDate) {
                                                        $('#date_from').datepicker('option', 'minDate', startDate);
                                                        $('#date_from').datepicker('option', 'minDate', startDate);

                                                    }
                                                });

                                                $('#date_from').datepicker({
                                                    dateFormat: "dd-mm-yy",
                                                    onSelect: function (startDate) {
                                                        $('#date_to').datepicker('option', 'minDate', startDate);
                                                    }
                                                });

                                                $('#date_to').datepicker({
                                                    dateFormat: "dd-mm-yy",
                                                    onSelect: function (startDate) {
                                                        $('#date_from').datepicker('option', 'maxDate', startDate);
                                                    }
                                                });



                                                $(document).on('change', '.user_name', function () {
                                                    var current_attr = $(this).attr('data-attr');
                                                    var user_id = $(this).val();
                                                    var attr_res = current_attr.substring(6);
                                                    $(".age_" + attr_res).val('');
                                                    $(".age_" + attr_res).val('');
                                                    $(".age_" + attr_res).val('');

                                                    if (user_id != '' && user_id != 'other') {
                                                        var id = $('#delete_ids').val();
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url(); ?>index.php/travel/ajax_get_user",
                                                            data: {
                                                                user_id: user_id,
                                                                current_attr: current_attr,
                                                            },
                                                            dataType: 'json',
                                                            success: function (resp) {
                                                                if (resp.response == 1) {
                                                                    var age = resp.data.age;
                                                                    var attr_val = resp.data.attr_val;
                                                                    var gender = resp.data.gender;
                                                                    var mobile_number = resp.data.mobile_number;

                                                                    if (attr_val != '') {
                                                                        $(".age_" + attr_val).val(age);
                                                                        $(".gender_" + attr_val).val(gender);
                                                                        $(".mobile_" + attr_val).val(mobile_number);
                                                                    }
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                        $(".age_" + attr_res).val('');
                                                        $(".age_" + attr_res).val('');
                                                        $(".age_" + attr_res).val('');
                                                        $(".set_username_" + attr_res).css('display', 'none');
                                                        var other_user = '<input class="form-control commonAlphaNum age_0" type="text" value="" name="name[]">';
                                                        $("#set_user_type_" + attr_res).html(other_user);
                                                    }
                                                });

                                                $(document).on('click', '#deleteRecord', function () {
                                                    var common_ids = [];
                                                    $(".master_check").each(function (index) {
                                                        if ($(this).is(":checked")) {
                                                            var attr_val = $(this).attr('data-attr');
                                                            $('.row_cls_' + attr_val).remove();
                                                        }
                                                        $('.deleteMsg').removeClass('display-hide');
                                                    });
                                                    $('#deletemodal').modal('hide');
                                                    var no_data_append = '<tr class="odd no_data" style="text-align: center;"><td valign="top" colspan="5" class="dataTables_empty none-pointer">No data available in table</td></tr>';
                                                    if ($('input:checkbox.master_check:checked').length == 0) {
                                                        $("#travel_request_form tbody").append(no_data_append);
                                                    } else {
                                                        $(".no_data").remove();
                                                    }
                                                });

                                                $(document).on('click', '.master_check', function () {
                                                    if (!$(this).is(":checked")) {
                                                        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                                                        $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", true);
                                                    } else {
                                                        $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
                                                        $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
                                                    }
                                                    if ($('input:checkbox.master_check').length > 0) {
                                                        if ($('input:checkbox.master_check').length != $('input:checkbox.master_check:checked').length) {
                                                            console.log('1');
                                                            $('.master_check_all').prop('checked', false);
                                                            $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
                                                        } else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {
                                                            console.log('2');
                                                            $('.master_check_all').prop('checked', true);
                                                        }
                                                    }
                                                    if ($('input:checkbox.master_check:checked').length == 0) {
                                                        console.log('3');
                                                        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                                                    }
                                                });

                                                $(document).on('click', '.master_check_all', function () {
                                                    if (!$(this).is(":checked")) {
                                                        $('.master_check').prop('checked', false);
                                                        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                                                        $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", true);

                                                    } else {
                                                        $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
                                                        $('.master_check').prop('checked', true);
                                                        $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
                                                    }
                                                    $(".new_field").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);

                                                    if ($(".new_field").length > 0) {
                                                        $("#save_btn").removeClass("opacity5 none-pointer");
                                                    }
                                                });

                                                $(document).on('click', '.new_field', function () {
                                                    $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
                                                    $("#save_btn").removeClass("opacity5 none-pointer");
                                                });

                                                $(document).on('click', '#multiform_addMore', function () {
                                                    var option_am = '';
                                                    for (ia = 1; ia <= 12; ia++) {
                                                        option_am += '<option value="1">' + ia + 'AM' + '</option>';
                                                    }
                                                    var option_pm = ''
                                                    for (ip = 1; ip <= 12; ip++) {
                                                        option_pm += '<option value="1">' + ip + 'PM' + '</option>';
                                                    }

                                                    $(".dataTables_empty").css('display', 'none');
                                                    var i, travel_request_count;
                                                    i = travel_request_count = $('#multiple_request_form tr').length + 1;
                                                    var data = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow_mf(' + i + ');" aria-hidden = "true" ></i></td>';
                                                    data += '<td><input placeholder="dd-mm-yy"  class="form-control datepicker commonAlphaNum age_' + travel_request_count + '" type="text" value="" name="date_of_travel[]" placeholder="dd-mm-yy" ></td>';
                                                    data += '<td><input class="form-control commonAlphaNum age_' + travel_request_count + '" type="text" value="" name="destination_from[]" ></td>';
                                                    data += '<td><input class="form-control commonAlphaNum age_' + travel_request_count + '" type="text" value="" name="destination_to[]" ></td>';
                                                    data += '<td><select  class="form-control gender_' + travel_request_count + '" name="date_of_accomodation_to[]"><option value="">--Select--</option>' + option_am + '' + option_pm + '</select></td>';
                                                    data += '<td><select class="form-control gender_' + travel_request_count + '" name="date_of_accomodation_to[]"><option value="">--Select--</option>' + option_am + '' + option_pm + '</select></td>';
                                                    data += '<td id="set_user_type_' + travel_request_count + '" ><select class="form-control travel_mode_' + travel_request_count + '" data-attr="count_' + travel_request_count + '" name="travel_mode[]" ></select></td>';
                                                    data += '<td id="set_user_type_' + travel_request_count + '" ><input class="form-control commonAlphaNum age_' + travel_request_count + '" type="text" value="" name="preferred_train_flight[]" ></td>';
                                                    data += '<td><input placeholder="dd-mm-yy"  class="form-control datepicker commonAlphaNum age_' + travel_request_count + '" type="text" value="" name="date_of_accomodation[]" ></td><td><input type="text" placeholder="dd-mm-yy"  class="form-control datepicker gender_' + travel_request_count + '" name="date_of_accomodation_to[]"></input></td><td><input class="form-control commonAlphaNum mobile_' + travel_request_count + '" type="text" value="" name="location_preference[]"></td></tr>';
                                                    $("#multiple_request_form tbody").prepend(data);
                                                    $("#save_btn").removeClass("opacity5 none-pointer");
                                                    $('.datepicker').datepicker({changeMonth: true, changeYear: true, dateFormat: "dd-mm-yy"});

                                                    $.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url(); ?>index.php/travel/get_travel_mode",
                                                        dataType: 'json',
                                                        async: false,
                                                        success: function (resp) {
                                                            $(".travel_mode_" + travel_request_count).html(resp.response);
                                                        }
                                                    });
                                                });

$(document).on('click', '#addMore', function () {
    $(".dataTables_empty").css('display', 'none');
    var i, travel_request_count;
    i = travel_request_count = $('#travel_request_form tr').length + 1;
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_user_type_' + travel_request_count + '" ><select class="form-control user_name set_username_' + travel_request_count + '" data-attr="count_' + travel_request_count + '" name="name[]" ></select></td>';
    datas += '<td><input class="form-control commonAlphaNum age_' + travel_request_count + '" type="text" value="" name="age[]" ></td><td><select class="form-control gender_' + travel_request_count + '" name="sex[]"><option value="">--Select--</option><option value="1">Male</option><option value="2">Female</option></select></td><td><input class="form-control commonAlphaNum mobile_' + travel_request_count + '" type="text" value="" name="mobile[]"></td></tr>';
    $("#travel_request_form tbody").prepend(datas);
    $("#save_btn").removeClass("opacity5 none-pointer");

    var response_data = '';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/travel/ajax_get_user_list",
        dataType: 'json',
        async: false,
        success: function (resp) {
            $(".set_username_" + travel_request_count).html(resp.response);
        }
    });
});

$(document).on('click', '#delUser', function () {
    $('#delCount').val('');
    var sel_item = $(".master_check:checkbox:checked").length;
    $('#delCount').html(sel_item);
    if (sel_item > 0)
        $('#deletemodal').modal('show');
});

function submit_fields() {
    $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
    $('#insertEditDocument_type').submit();
}

$(document).on('input', '.commonAlphaNum', function () {
    if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
        this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
    }
});

</script>

<style type="text/css">
    .dataTables_scrollBody {
        margin-top: -15px;
    }
</style>

</body>
</html>