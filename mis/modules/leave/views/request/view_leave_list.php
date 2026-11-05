<?php ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Villgro MIS</title>
    </head>

    <body>
        <div class="fixed-headervi">
            <?php $this->load->view('header.php'); ?>
        </div>
        <div class="vi-dashboard-vital onboardtabmenu wdt-100">
            <div class="container-fluid">
                <div class="Vital-Newmenu">
                    <div class="row">
                        <div class="col">
                            <ul>
                                <li><a href=""><i class="fas fa-home"></i> Home</a></li>
                                <li><a href=""><i class="fas fa-tag"></i> Deals</a></li>
                                <li class="active"><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                                <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                                <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                                <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                                <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                                <?php
                                if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
                                    ?>
                                    <li ><a href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('request/request_sidemenu.php', array('page' => 'leave')); ?>
                            </div>
                            <div class="footer-link">
                                <p>copyright &copy; mis.villgroapps.org</p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">

                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                        <span><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                        <h4> Leave Request for Anika Pandey</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right pad-none">

                                    </div>
                                </div>
                                <div class="plan-structure-vital vital_windowScroll">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                            <table class="table table-hover dt-responsive" id="approve_leave_list_table">
                                                <thead>
                                                    <tr>
                                                        <!-- <th></th> -->
                                                        <th >Date</th>
                                                        <th >Applied Date</th>
                                                        <th>Employee Name</th>
                                                        <th>No. of Days</th>
                                                        <th>Leave Type</th>
                                                        <th>Status</th>
                                                        <th>Comments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($leaves_list as $list) {
                                                        $pending_select = $approve_select = $taken_select = $reject_select = $cancel_select = '';
                                                        if ($list['leave_status'] == 0) {
                                                            $status = 'Pending approval';
                                                            $pending_select = 'selected';
                                                        } else if ($list['leave_status'] == 1) {
                                                            $status = 'Approved';
                                                            $approve_select = 'selected';
                                                        } else if ($list['leave_status'] == 2) {
                                                            $status = 'Taken';
                                                            $taken_select = 'selected';
                                                        } else if ($list['leave_status'] == 3) {
                                                            $status = 'Rejected';
                                                            $reject_select = 'selected';
                                                        } else if ($list['leave_status'] == 4) {
                                                            $status = 'Cancelled';
                                                            $cancel_select = 'selected';
                                                        }

                                                        $status_text = $status;
                                                        $commentstext = $list['leave_comments'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo date('d/M/Y', strtotime($list['leave_startdate'])) . '-' . date('d/M/Y', strtotime($list['leave_enddate'])) ?></td>
                                                            <td><?php echo date('d-M-Y', strtotime($list['leave_applied_date'])) ?></td>
                                                            <td><?php echo $list['emp_firstname'] . ' ' . $list['emp_lastname'] ?></td>
                                                            <td><?php echo $list['leave_length_days'] ?></td>
                                                            <td><?php echo $list['leave_type_name'] ?></td>
                                                            <?php
                                                            if (isset($page) && $page == 'leavelist') {
                                                                ?>
                                                                <td><?= $status_text; ?></td>
                                                                <td><?= $commentstext; ?></td>
                                                            <?php } else { ?>
                                                                <td><select  class="form-control" name="approve_status_<?php echo $list['id'] ?>" id="approve_status_<?php echo $list['id'] ?>" onchange="save_approval(<?php echo $list['id'] ?>)"><option value="3" <?php echo $reject_select; ?>>Rejected </option>
                                                                        <option value="4" <?php echo$cancel_select; ?>>Cancelled </option>
                                                                        <option value="0" <?php echo $pending_select; ?>>Pending Approval</option>
                                                                        <option value="1" <?php echo $approve_select; ?>>Approved </option>
                                                                        <option value="2" <?php echo $taken_select; ?>>Taken</option></select></td>

                                                                <td><input class='form-control wdt_100' type='text' name="approve_comments_<?php echo $list['id'] ?>" id="approve_comments_<?php echo $list['id'] ?>" value=" <?php echo $list['leave_comments']; ?>"></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <input type="text" name="edited_leaves[]" id="edited_leaves" />
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-12 col-sm-4  col-md-4 text-right">
                                            <div class="text-right saveLinkView ">
                                                <br>
                                                <ul class="vitals-links ">
                                                    <li><a href="javascript:void(0)" onclick="submit_approval();" class="vital_yellow_btn">Save</a></li>
                                                    <li><a href="#" class="vital_bordered_btn">Reset</a></li>
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
    </body>

    <script>
        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 190) + 'px'});
        });

        $('#approve_leave_list_table').DataTable();

        function save_approval(leave_id) {
            var leave_arr = $('#edited_leaves').val();
            var arr = leave_arr.split(',');

// arr.push(leave_id);
// for(var i=0; i<arr.length; i++){
//     if(leave_id.indexOf(arr[i]) == -1){
//         larr.push(arr[i]);
//     }
// }
// console.log(larr);
            var idx = $.inArray(leave_id, arr);
            if (idx === -1) {
                arr.push(leave_id)
                arr.join(',')
                $('#edited_leaves').val(arr);
            }

        }

        function submit_approval() {

            var larr = [];
            var leave_arr = $('#edited_leaves').val();
            var arr = leave_arr.split(',');
            for (var i = 0; i < arr.length; i++) {
                if (larr.indexOf(arr[i]) == -1) {
                    larr.push(arr[i]);
                }
            }

            for (var j = 0; j < larr.length; j++) {
                var status = $('#approve_status_' + larr[j]).val();
                var comments = $('#approve_comments_' + larr[j]).val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/leave/leave_approve",
                    data: {
                        status: status,
                        comments: comments,
                        leave_id: larr[j],
                    },
                    dataType: 'json',
                    success: function (msg) {
                        location.reload();
                    }
                });
            }

        }
    </script>

</html>