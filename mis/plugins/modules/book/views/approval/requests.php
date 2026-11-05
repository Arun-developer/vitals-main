<?php 
$master_menu = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Book Request - ' . ucfirst($request_type), 'page_table' => 'datatable'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'booklist')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Book Request - <?= ucfirst($request_type); ?></h4>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                    <li role="presentation" class="<?php if ($request_type == 'pending') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/book/approval/requests/pending'; ?>">Pending Requests</a></li>
                                    <li role="presentation" class="<?php if ($request_type == 'confirmed') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/book/approval/requests/confirmed'; ?>">Approved Requests</a></li>
                                    <li role="presentation" class="<?php if ($request_type == 'returned') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/book/approval/requests/returned'; ?>">Returned Books</a></li>
                                    <li role="presentation" class="<?php if ($request_type == 'cancelled') echo "active"; ?>"><a href="<?php echo base_url() . 'index.php/book/approval/requests/cancelled'; ?>" >Disapproved Requests</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="filter_job" action="" class="pad-lt15px " method="POST" autocomplete="off">
                                        <div class="col-xl-11 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
                                            <ul class="vitals-links leaveLabel">
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Category</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180"  name="master_id" id="master_id">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($categoryList as $list) { ?>
                                                                <option value="<?php echo $list['master_id']; ?>"><?php echo $list['master_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="category_err" ></div>
                                                </li>

                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Books Name</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="book_name"  name="book_name" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div id="book_name_err" ></div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Author</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="author"  name="author" class="form-control" placeholder="Search">
                                                    </div>
                                                    <div id="book_name_err" ></div>
                                                </li>
                                                <?php
                                                $date_title = 'Request ';
                                                if ($this->uri->segment(4) == 'pending') {
                                                    $date_title = 'Request';
                                                } else if ($this->uri->segment(4) == 'confirmed') {
                                                    $date_title = 'Confirmed';
                                                } else if ($this->uri->segment(4) == 'returned') {
                                                    $date_title = 'Returned';
                                                } else if ($this->uri->segment(4) == 'cancelled') {
                                                    $date_title = 'Cancelled';
                                                }
                                                ?>
                                                <li class="mob_fulfill">
                                                    <label class="form-group"><?php echo $date_title; ?> From Date</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <input type="text" id="date_from" name="date_from" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                    <div id="date_from_err"></div>
                                                </li>
                                                <li class="mob_fulfill" id="message_id" >
                                                    <label class="form-group"><?php echo $date_title; ?> To Date</label>
                                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                                        <input type="text" id="date_to" name="date_to" class="form-control" placeholder="dd-mm-yyyy">
                                                    </div>
                                                    <div id="date_to_err" ></div>
                                                </li>
                                                <li class="mob_fulfill">
                                                    <label class="form-group" >Employee</label>
                                                    <div class="form-group mar-bt8  wdt_180">
                                                        <select class="form-control wdt_180"  name="employee_id" id="employee_id">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($userList as $list) { ?>
                                                                <option value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div id="category_err" ></div>
                                                </li>
                                                <li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>

                                                <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
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
                                                        <th width="10%">Request Id</th>
                                                        <th width="10%">Category</th>
                                                        <th width="10%">Employee</th>
                                                        <th width="5%">Book Number</th>
                                                        <th width="10%">Book Name</th>
                                                        <th width="10%">Author</th>
                                                        

                                                        <?php if ($request_type == 'pending') { ?>
                                                            <th width="5%">Requested Date</th>
                                                        <?php } ?>
                                                        <?php if ($request_type == 'confirmed') { ?>
                                                            <th width="5%">Issue Date</th>
                                                        <?php } ?>


                                                        <?php if ($request_type == 'cancelled' || $request_type == 'returned') { ?>
                                                            <th width="5%">Cancelled Date</th>
                                                        <?php } ?>
                                                        <?php if ($request_type == 'confirmed' || $request_type == 'returned') { ?>
                                                            <th width="10%">Expected Return Date</th>
                                                            <th width="10%">No Of Renewals</th>
                                                            <th width="10%">Renewal Date</th>
                                                        <?php } ?>
                                                        <?php if ($request_type == 'returned') { ?>
                                                            <th width="10%">Returned Date</th>
                                                        <?php } ?>
                                                        <th width="10%">Status</th>
                                                        <th width="5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
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




<!--
<div class="modal" id="return_confirmedmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4 id="set_return_title" >Library Booking - Return Book</h4>
                        </div>
                        <form id="send_approval_book" name="send_approval_book" action="<?php echo base_url() . 'index.php/book/approval/returnbook'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                            <input type="hidden" name="return_id" id="rb_return_id">
                            <table width="100%" cellspacing="5" cellpadding="5">
                                <tbody>
                                    <tr>
                                        <td style="width: 150px;"><strong>Request Id :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input readonly type="text" id="rb_approval_name"  name="name" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><strong>Return Date :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input type="text" id="rb_issue_date"  name="issue_date" class="form-control" placeholder="dd-mm-yyyy">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <input type="hidden" id="rb_return_book_id" name="return_book_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="send_return">Ok</button>
            </div>
        </div>
    </div>
</div> -->



<div class="modal" id="del_actionmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4 id="del_set_title" >Are you sure want to delete?</h4>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="del_book_id" name="book_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="del_send_approval">Ok</button>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="disapprove_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
		 <form id="dissapprove_book" name="dissapprove_book" action="<?php echo base_url() . 'index.php/book/approval/cancel'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4 id="del_set_title" >Are you sure want to disapprove ?</h4>
                        </div>
                    </div>
                </div>
            </div>
			 <input type="hidden" id="dissapprove_request_id" name="dissapprove_request_id">
			</form>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="disapprove_ok">Ok</button>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="approve_book_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4 id="set_return_title" >Library Bookings - Return Book</h4>
                        </div>
                        <form id="approve_book_form" name="approve_book_form" action="<?php echo base_url() . 'index.php/book/approval/approve_book'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                            <input type="hidden" name="return_id" id="rb_return_id">
                            <table width="100%" cellspacing="5" cellpadding="5">
                                <tbody>
                                    <tr>
                                        <td style="width: 150px;"><strong>Request Id :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input readonly type="text" id="approve_request_id"  name="approve_request_id" class="form-control">
                                        </td>
                                    </tr>
									<input type="hidden" name="book_id" id="approve_book_id"  >
                                    <tr>
                                        <td style="width: 150px;"><strong>Return Date :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input type="text" id="approve_issue_date"  name="approve_issue_date" class="form-control" placeholder="dd-mm-yyyy">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <input type="hidden" id="rb_return_book_id" name="return_book_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="approve_book_ok">Ok</button>
            </div>
        </div>
    </div>
</div>




<div class="modal" id="renew_book_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4 id="set_return_title" >Renew Request by Employee</h4>
                        </div>
                        <form id="renew_books" name="renew_books" action="<?php echo base_url() . 'index.php/book/approval/renew'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
                            <input type="hidden" name="return_id" id="rb_return_id">
                            <table width="100%" cellspacing="5" cellpadding="5">
                                <tbody>
                                    
									<input type="hidden" name="renew_request_id" id="renew_request_id"  >
                                    <tr>
                                        <td style="width: 150px;"><strong>Renew Request Date</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input type="text" id="renew_date"  name="renew_date" class="form-control" placeholder="dd-mm-yyyy">
                                        </td>
                                    </tr>
									<tr>
                                        <td style="width: 150px;"><strong>Renew Request Status:</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input readonly type="text" id="renews_req_status"  name="renews_req_status" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <input type="hidden" id="rb_return_book_id" name="return_book_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="renew_books_ok">Ok</button>
                <button type="button" class="btn btn-success" id="renew_books_ok">Ok</button>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="returnmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4 id="set_return_title" >Library Booking - Approval</h4>
                        </div>
                        <form id="send_approval_book" name="send_approval_book" action="<?php echo base_url() . 'index.php/book/approval/return_book'; ?>" class="pad-lt15px " method="POST" autocomplete="off">

                           
                            <table width="100%" cellspacing="5" cellpadding="5">
                                <tbody>
                                    <tr>
									 <input type="hidden" name="return_book_id" id="return_book_id">
                                        <td style="width: 150px;"><strong>Request Id :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input readonly type="text" id="return_req_id"  name="return_req_id" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 150px;"><strong>Issue Date :</strong></td>
                                        <td style="text-align: left;word-break: break-word;" >
                                            <input type="text" id="issue_date"  name="issue_date" class="form-control" placeholder="dd-mm-yyyy">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="send_return">Ok</button>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="actionmodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
				 <form id="delete_request_book" name="delete_request_book" action="<?php echo base_url() . 'index.php/book/approval/delete_request'; ?>" class="pad-lt15px " method="POST" autocomplete="off">
					<div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
							<input type="hidden" name="delete_request_id" id="delete_request_id"  >
                        <div class="col-10">
                            <h4 id="set_title" ></h4>
                        </div>
                    </div>
					</form>
                </div>
            </div>
            <input type="hidden" id="book_id" name="book_id">
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="delete_request_ok">Ok</button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#issue_date').datepicker({
            dateFormat: "dd-mm-yy"
        });
		
		
        $(document).on('click', '.return_cls', function () {
            var return_book_id = $(this).attr('data-attr-bid');
            var return_id = $(this).attr('data-attr-id');
			/* alert(return_book_id);
			alert(return_id); */
			 $('#return_req_id').val(return_id);
            var type = '<?php echo $this->uri->segment(4); ?>';
           
                $('#return_book_id').val(return_book_id);
                $('#approval_name').val(return_id);
                $('#return_id').val(return_id);
               
            
            $('#returnmodal').modal('show');
        });

        $(document).on('click', '.renews_cls', function () {
            var book_id = $(this).attr('data-attr-bid');
            var approve_book_id = $(this).attr('data-attr-id');
            var status = $(this).attr('data-attr-status');
			$("#renews_req_status").val(status);
			$("#renew_request_id").val(approve_book_id);
			$('#renew_book_model').modal('show');
            
        });
		$(document).on('click', '#renew_books_ok', function () {
            $("#renew_books").submit();
            
        });
		
		
		
		$(document).on('click', '.approve_cls', function () {
            var book_id = $(this).attr('data-attr-bid');
            var approve_book_id = $(this).attr('data-attr-id');
			$("#approve_request_id").val(approve_book_id);
			$("#approve_book_id").val(book_id);
			$('#approve_book_model').modal('show');
            
        });
		$(document).on('click', '#approve_book_ok', function () { 
            $("#approve_book_form").submit();
            
        });
		
		
		$(document).on('click', '.dissapprove_cls', function () {
            var approve_book_id = $(this).attr('data-attr-id');
			$("#dissapprove_request_id").val(approve_book_id);
			$('#disapprove_model').modal('show');
            
        });
		$(document).on('click', '#disapprove_ok', function () {
            $("#dissapprove_book").submit();
            
        });
		
		$(document).on('click', '.renew_cls', function () {
            var book_id = $(this).attr('data-attr-id');
            var type = '<?php echo $this->uri->segment(4); ?>';
            $('#del_book_id').val(book_id);
            $('#del_actionmodal').modal('show');
        });

        $(document).on('click', '.delete_cls', function () {
            $('#set_title').html('');
            var book_id = $(this).attr('data-attr-bid');
            var type = '<?php echo $this->uri->segment(4); ?>';
             var delete_request_id = $(this).attr('data-attr-id');
                $('#book_id').val(book_id);
                $('#delete_request_id').val(delete_request_id);
                $('#set_title').html('Are you sure want to delete ?');
            
            $('#actionmodal').modal('show');
        });//delete_request_book


        $(document).on('click', '#delete_request_ok', function () {
			$("#delete_request_book").submit();
		});	
			
			$(document).on('click', '.return_book_cls', function () {
            var return_book_id = $(this).attr('data-attr-bid');
            var return_id = $(this).attr('data-attr-id');
            var type = '<?php echo $this->uri->segment(4); ?>';
            if (type == 'confirmed') {
                $('#rb_return_book_id').val(return_id);
                $('#rb_approval_name').val(return_book_id);
            }
            $('#return_confirmedmodal').modal('show');
        });
		
		$(document).on('click', '.return_book_cls', function () {
            var return_book_id = $(this).attr('data-attr-bid');
            var return_id = $(this).attr('data-attr-id');
            var type = '<?php echo $this->uri->segment(4); ?>';
            if (type == 'confirmed') {
                $('#rb_return_book_id').val(return_id);
                $('#rb_approval_name').val(return_book_id);
            }
            $('#return_confirmedmodal').modal('show');
        });
		
		
        $(document).on('click', '#send_return', function () {
            $("#send_approval_book").submit();
        });

        $(document).on('click', '#send_approval', function () {
            var ajax_url = "<?php echo base_url(); ?>index.php/book/approval/cancel";
            var book_id = $('#book_id').val();
            var type = '<?php echo $this->uri->segment(4); ?>';
            $.ajax({
                url: ajax_url,
                type: "POST",
                data: {"book_id": book_id, "type": type},
                dataType: "json",
                cache: false,
                success: function (res) {
                    location.reload();
                }
            });
        });

        $('#author').keypress(function (e) {
            if (e.which == 13) {
                //Category Mandatory field remove.
       // filter_check();
       master_trigger();
                return false;
            }
        });

        $('#approve_issue_date').datepicker({
            dateFormat: "dd-mm-yy",
        }); $('#renew_date').datepicker({
            dateFormat: "dd-mm-yy",
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

        master_trigger();
    });

    $(document).on('click', '#search_btn', function () {
        //Category Mandatory field remove.
       // filter_check();
       master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $("#category_err").html('');
        $("#book_name_err").html('');
        $("#author_err").html('');
        $('#master_id').val('');
        $('#book_name').val('');
        $('#author').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#employee_id').val('');
        master_trigger();
    });

    $(document).on('click', '#cancel_request', function () {
        var request_id = $("#request_id").val();
        var ajax_url = '';
        var type = '<?php echo $master_menu; ?>';
        if (type == 'pending') {
            var ajax_url = "<?php echo base_url(); ?>index.php/book/ajax_request";
        } else if (type == 'confirmed') {
            var ajax_url = "<?php echo base_url(); ?>index.php/book/ajax_renew";
        }
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
        var request_type = '<?php echo $request_type; ?>';
        var sort = '';
        if (request_type == 'pending') {
            sort = [2, 7];
        } else if (request_type == 'cancelled') {
            sort = [2, 8];
        } else if (request_type == 'confirmed') {
            sort = [2, 11];
        } else if (request_type == 'returned') {
            sort = [2, 12];
        }
        var master_id = $('#master_id').val();
        var book_name = $('#book_name').val();
        var author = $('#author').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var employee_id = $('#employee_id').val();

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
            // "ordering": true,
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
                "url": "<?php echo base_url(); ?>index.php/book/approval/DTbook_request",
                "type": "POST",
                "data": {
                    "master_id": master_id,
                    "book_name": book_name,
                    "author": author,
                    "date_from": date_from,
                    "date_to": date_to,
                    "request_type": request_type,
                    "employee_id": employee_id
                }
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                /* $('#master_table').on('click', '.action_cls', function (e) {
                 if (!$(e.target).is("input")) {
                 var id =  $(this).attr('data-attr');
                 if(id != ''){
                 $('#actionmodal').modal('show');
                 $('#request_id').val(id);
                 }
                 return false;
                 }
                 return false;
                 }); */
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
            'columnDefs': [{
                    'orderable': false,
                    'targets': sort
                }],
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