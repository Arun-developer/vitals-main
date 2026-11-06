<?php
$master_menu = $this->uri->segment(3);
$page_list = $this->uri->segment(4);
if ($page_list == 'rolist') {
    $section = 'rolist';
    $page_heading = 'Approve As RO';
} else if ($page_list == 'phlist') {
    $section = 'phlist';
    $page_heading = 'Approve As PH';
} else if ($page_list == 'ceolist') {
    $section = 'ceolist';
    $page_heading = 'Approve As CEO';
} else if ($master_menu == 'all_pending') {
    $section = $page_list;
    $page_heading = 'My Pending Notes';
} else if ($master_menu == 'all_approval') {
    $section = $page_list;
    $page_heading = 'All My Approval Notes - ' . ucfirst($page_list);
}


$this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => $page_heading, 'page_table' => 'datatable'));
?>
<style>
    .multiselect-container li.active a {
        background-color: #ffffff;
    }
    .multiselect-container.dropdown-menu>.active>a, .multiselect-container.dropdown-menu>.active>a:focus, .multiselect-container.dropdown-menu>.active>a:hover {
        background-color: #ffffff;
    }
    .multiselect-container li.active a label.checkbox {
        width: 178px;
        background: #ffffff;
    }
</style>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php

				$this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'approval_note')); 
                
                $finance_status = '';
                $sess_empid = $this->session->userdata('emp_number');
                $finance_user_count = financeuser_count($sess_empid);
                $fin_user = 0;
                if (php72_cmp($finance_user_count) == 1) {
                  $fin_user = 1;
              }
              
              ?>
          </div>
      </div>
      <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
        <main class="page-content">
            <div class="row dataconfig d_v_d_c">
                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                    <h4><?php echo $page_heading; ?></h4>
                </div>
            </div>

            <div class="plan-structure-vital vital_windowScroll">
                <?php //if ($section == 'rolist' || $section == 'phlist') { ?>
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <!--<li class="tab-slider--triggerform <?php if ($section == 'rolist' && $page_list != 'ceolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/pending/rolist'; ?>">Approve as RO <?php echo isset($an_rocount) && php72_cmp($an_rocount) != 0 ? '(' . $an_rocount . ')' : ''; ?></a></li>-->
                                <li class="tab-slider--triggerform <?php if ($master_menu == 'all_pending' && $page_list != 'ceolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/all_pending'; ?>">My Pending Notes <?php echo isset($an_rocount) && php72_cmp($an_rocount) != 0 ? '(' . $an_rocount . ')' : ''; ?></a></li>
                                <li class="tab-slider--triggerform <?php if ($master_menu == 'all_approval' && $page_list != 'ceolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/confirmed'; ?>">All My Approval Notes</a></li>
                                <?php if ($ph_Usercount == '1') { ?>
                                    <li class="tab-slider--triggerform <?php if ($section == 'phlist' && $page_list != 'ceolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/pending/phlist'; ?>">Approve as PH<?php echo isset($an_phcount) && php72_cmp($an_phcount) != 0 ? '(' . $an_phcount . ')' : ''; ?></a></li>
                                <?php } ?>
								<li class="tab-slider--triggerform <?php if ($section == 'rolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/pending/rolist'; ?>">RO Approve <?php echo isset($rocount) && php72_cmp($rocount) != 0 ? '(' . $rocount . ')' : ''; ?></a></li>
                                <li class="tab-slider--triggerform <?php if ($master_menu == 'approved') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/approved/approvedList'; ?>">Approved List <?php //echo isset($rocount) && $rocount != 0 ? '(' . $rocount . ')' : ''; ?></a></li>
                                
								<?php /* if ($ceo_status != '') { ?>
                                    <li class="tab-slider--triggerform <?php if ($page_list == 'ceolist') echo "active"; ?>"><a  href="<?php echo base_url() . 'index.php/approval/approval_note/all_pending/ceolist'; ?>">Approve As CEO <?php echo isset($pending_ceo_count) && $pending_ceo_count != 0 ? '(' . $pending_ceo_count . ')' : ''; ?></a></li>
                                <?php } */ ?>

                            </ul>
                        </div>
                    </div>

                    <?php if ($master_menu == 'all_approval') { ?>
                        <div class="display-hide" id="navLoad">
                            <div class="newCLickTabs">
                                <div>
                                    <?php $type = $this->uri->segment(4); ?>
                                    <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                        <li role="presentation" class="<?php if ($type == 'confirmed') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/confirmed'; ?>">Confirmed Notes</a></li>
                                        <li role="presentation" class="<?php if ($type == 'cancelled') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/cancelled'; ?>">Cancelled Notes</a></li>
                                        <li role="presentation" class="<?php if ($type == 'defered') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/defered'; ?>">Deferred Notes</a></li>
                                        <li role="presentation" class="<?php if ($type == 'closed') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/closed'; ?>" >Closed Notes</a></li>
                                        <li role="presentation" class="<?php if ($type == 'draft') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/approval_note/all_approval/draft'; ?>" >Draft Notes</a></li>
                                        <?php if($fin_user==0){ ?>

                                            <li role="presentation" class="<?php if ($type == 'archive') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/archive/'; ?>" >Archive</a></li>
                                            
                                            
                                            <!--<li role="presentation" class="<?php if ($type == 'action_history') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/approval/action_history'; ?>" >Action History</a></li>-->
                                            
                                        <?php }  ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="<?php echo base_url() . 'index.php/approval/export_an'; ?>"  class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Approval Number</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="approval_no" name="approval_no" class="form-control searchEnter" >
                                                    </div>

                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group">Programme</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control" id="program_name" name="program_name">
                                                            <option value=''>--Select--</option>
                                                            <?php foreach ($program_list as $program) { ?>
                                                                <option value='<?= $program['programme_id']; ?>'><?= $program['programme']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                <input type="hidden"  name="list_type" value="<?php echo $list_type ?>" >
                                                <input type="hidden"  name="currentTab" value="<?php echo $this->uri->segment(3); ?>" >
                                                <input type="hidden"  name="section" value="<?php echo $section; ?>" >

                                                <?php if ($page_list == 'phlist') { ?>
                                                    <li class="mob_fulfill">
                                                        <label class="form-group">Status</label>
                                                        <div class="form-group mar-bt8  wdt_180">
                                                            <select class="form-control wdt_180 employeeInput select-ajax edit_cls" id="multiselect"  multiple="multiple" id="status" name="status[]">
                                                                    <?php //, 'draft' => 'Draft'
                                                                    $status_list = array(
                                                                        'pending' => 'Pending', 'confirmed' => 'Confirmed',
                                                                        'cancelled' => 'Cancelled', 'defered' => 'Defered',
                                                                        'closed' => 'Closed'
                                                                    );
                                                                    ?>
                                                                    <?php foreach ($status_list as $key => $val) { ?>
                                                                        <option value='<?php echo $key; ?>'><?php echo $val; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </li>
                                                    <?php } ?>

                                                    <li class="mob_fulfill" id="message_id">
                                                        <label class="form-group" >Purpose</label>
                                                        <div class="form-group has-search-right mar-bt8 wdt_180">
                                                            <input type="text" id="purpose" name="purpose"  class="form-control searchEnter" placeholder="Search">
                                                        </div>
                                                        <div id="author_err"></div>
                                                    </li>
                                                    <li><a name="search_btn" id="search_btn" type="submit" class="vital_yellow_btn">Search</a></li>
                                                    <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                                                    <li><a id="export_summary" class="master_aduser summaryEdit"><span><i class="fas fa-download"></i></span> Export</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
                                                <ul class="vitals-links"></ul>
                                            </div>
                                        </form>

                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                    <thead>
                                                        <tr>
                                                            <th>Approval Note</th>
                                                            <th>Employee</th>
                                                            <th>Date</th>
                                                            <!-- <th width="10%">To(RO)</th> -->
                                                            <?php if ($master_menu == 'all_pending') { ?>
                                                                <th>Pending with</th>
                                                            <?php } ?>
                                                            <th>Programme</th>
                                                            <th>Purpose</th>
                                                            <!-- <th width="5%">Details</th> -->
                                                            <th>Status</th>
                                                            <?php /* if ($master_menu != 'all_approval') { ?>
                                                          <th width="5%">Pending With</th>
                                                      <?php } */ ?>
                                                      <?php if ($master_menu == 'all_approval') { ?>
                                                        <th>Action</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" name="delete_ids" id="delete_ids" />
                            </div>
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

<div class="modal" id="actionmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Internal note cannot be submitted at this time as the grant(Ford - 012019-062020) has been put on-hold/closed. Please check with the donor and finance teams.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="request_id" name="request_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close" >Ok</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect','page_name' => 'datatable')); ?>

<script type="text/javascript">

    $('.searchEnter').keypress(function (e) {
        if (e.which == 13) {
            filter_check();
        }
    });
    
    $(document).ready(function () {

       $('#multiselect, #accessibleTo').multiselect({
        buttonWidth: '100%',
        includeSelectAllOption: true,
        nonSelectedText: 'Select an Option'
    });

       $(document).on('click', '#export_summary', function () {
        $("#filter_job").submit();
    });


       $(document).on('click', '.show_error_msg', function () {
        $('#actionmodal').modal('show');
    });

        /* $(document).on('change', '#status', function () {reset_search
         var current_val = $(this).val();
         var url = '<?php echo base_url(); ?>/index.php/approval/approval_note/'+current_val+'/phlist';
         if(current_val =='archive'){
         var url = '<?php echo base_url(); ?>/index.php/approval/'+current_val+'/phlist';
         }else if(current_val =='action_history'){
         var url = '<?php echo base_url(); ?>/index.php/approval/'+current_val+'/phlist';
         }
         window.location.href = url;
     }); */

     $(document).on('click', '#cancel_request', function () {
        var request_id = $("#request_id").val();
        var ajax_url = "<?php echo base_url(); ?>index.php/book/ajax_book_request";
        if (request_id != '') {
            $('#actionmodal').modal('hide');
            $.ajax({
                url: ajax_url,
                type: "POST",
                data: {"request_id": request_id},
                dataType: "json",
                cache: false,
                success: function (res) {
                    location.reload();
                }
            });
        }
        return false;
    });

     $('#author').keypress(function (e) {
        if (e.which == 13) {
            filter_check();
            return false;
        }
    });

     master_trigger();
 });

    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    $(document).on('click', '#reset_search', function () {
        $('#purpose').val('');
        $('#approval_no').val('');
        $('#program_name').val('');
        $('#status').val('');
		// $('#multiselect').multiselect('deselectAll', false);
        $('#multiselect').val('pending');
        $('.multiselect-selected-text').text('Select an Option');

        master_trigger();
    });

    function filter_check() {
        var filter_err = 0;
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');


        var master_id = $('#master_id').val();
        var book_name = $('#book_name').val();
        var author = $('#author').val();

        if (master_id == '') {
            filter_err = 1;
            $("#category_err").html('<label class="error" id="txt_error">Select category</label>');
        }
        if (filter_err > 0) {
            return false;
        } else {
            master_trigger();
        }
    }

    function master_trigger() {
        var approval_no = $('#approval_no').val();
        var purpose = $('#purpose').val();
        var program_name = $('#program_name').val();
        var status = $('#multiselect').val();
        if(status == null) {
            status = 'pending';
        }

        var current_tab = '<?php echo $this->uri->segment(4); ?>';
		 var current_tab2 = '<?php echo $this->uri->segment(3); ?>';
        sort_title = 7;
        if (current_tab == 'confirmed' || current_tab == 'draft' || current_tab == "closed" || current_tab == "cancelled" || current_tab == "defered") {
            sort_title = 6;
        } else if (current_tab == 'phlist') {
            sort_title = 5;
        } else if (current_tab == 'rolist') {
            sort_title = 6;
        }
	
		if(current_tab2 =='pending' && current_tab==''){
			  sort_title = 6; 
		}
		

        $('#master_table').DataTable({
            "scrollX": true,
            "initComplete": function (settings, json) {
                $('.dataTables_scrollBody thead tr').css({visibility: 'collapse'});
            },
            "bProcessing": true,
            "bSortable": true,
            "destroy": true,
            "bDestroy": true,
            "paging": true,
            //"ordering": true,
            "responsive": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 20,
            "scrollY": '333px',
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/approval/DTapproval_note",
                "type": "POST",
                "data": {
                    "approval_no": approval_no,
                    "purpose": purpose,
                    "program_name": program_name,
                    "section": '<?php echo $section; ?>',
                    "currentTab": '<?php echo $this->uri->segment(3); ?>',
                    "status": status,
                    "list_type": '<?php echo $list_type; ?>',
                }
            },
            'columnDefs': [{
                'orderable': false,
                'targets': [sort_title]
            }],
            "order": [2, 'desc'],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('#master_table tbody').on('click', 'tr', function (e) {
                    /* if (!$(e.target).is("input")) {
                     var edited_id = $(":checkbox:eq(0)", this).val();
                     var slug = $(this).closest('tr').find('td:eq(6) input').val();
                     //var slug = $('#master_edit_id_' + edited_id).val();
                     $(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/approval/approval_note_details/' + slug);
                     window.location = $(this).attr('href');
                     return false;
                 } */
             });
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#master_table').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.master_check_all').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }
            },
        });
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>

</body>
</html>
