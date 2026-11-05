<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Leave - Apply Leave')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'leave', 'supervisor' => $chk_sup, 'approval_count' => $approval_count)); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Apply For Leave</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                    <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>">New Leave Request</a></li>
                                <?php } ?>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/leave/leave_summary'; ?>">Leave Allocation</a></li>
                                <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                    <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/leave/leave_list'; ?>">Leave Requests</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="plan-structure-vital">
                                    <main class="page-content">
                                        <div class="inputplan-structureall plan-structure-new">
                                            <form method="post" id="applyleaveForm" action="<?php echo base_url() . 'index.php/leave/addApplyleave'; ?>" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <?php
                                                        $quota_list = array();
                                                        if (count($leave_quotas) > 0) {

                                                            foreach ($leave_quotas as $quotas) {
                                                                if ($quotas['no_restrictions'] == 1) {
                                                                    $quota_list[$quotas['leave_type_id']] = $quotas['leave_type_name'];
                                                                } else {
                                                                    $remaining = ($quotas['no_of_days_allotted'] + $quotas['leave_brought_forward']) - $quotas['leave_taken'];
                                                                    if ($remaining > 0 && $quotas['leave_type_name']!="Work From Home") {
                                                                        $quota_list[$quotas['leave_type_id']] = $quotas['leave_type_name'];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                        <div class="form-group">
                                                            <label>Leave Type <small class="text-danger">*</small></label>
                                                            <select class="form-control" name="leave_type" id="leave_type" required="" onchange="Leavetype(this)">
                                                                <option value="">Select Leave Type</option>
                                                                <?php
                                                                if (count($quota_list) > 0) {
                                                                    foreach ($quota_list as $qlist => $qval) {
                                                                        ?>
                                                                        <option value="<?= $qlist; ?>"><?= $qval; ?></option>
                                                                        <?php
                                                                    }
                                                                     if(count($leave_quotaswfh)>0){
                                                                        ?>
                                                                         <option value="<?= $leave_quotaswfh[0]['leave_type_id']; ?>"><?= $leave_quotaswfh[0]['leave_type_name']; ?></option>

                                                                        <?php
                                                            
                                                                     }
                                                                  } else {

                                                                         if(count($leave_quotaswfh)>0){
                                                                        ?>
                                                                         <option value="<?= $leave_quotaswfh[0]['leave_type_id']; ?>"><?= $leave_quotaswfh[0]['leave_type_name']; ?></option>

                                                                        <?php
                                                            
                                                                     }else{
                                                                        ?>
                                                                    <option value="">No Leave Types</option>
                                                                <?php 
                                                                     }                                                                    } ?>
                                                           </select>
                                                        </div>

                                                    </div>
                                                    <input type="hidden" name="level_type_name" id="level_type_name">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Leave Length </label>
                                                            <select class="form-control" name="leave_length" id="leave_length" onchange="Leavetypelengthc(this)">

                                                                <option value="1" selected>Full Day</option>                                            
                                                                <option value="2">Half Day</option>             
                                                            </select>
                                                        </div>                                                  
                                                    </div> 
                                                </div>
                                                <?php if (count($quota_list) <= 0) { ?>
                                                    <div class="Vital-notes">
                                                        <span>Leave Quota not allocated. Please consult HR Admin</span>
                                                    </div>
                                                <?php } ?>

                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" id="from_date">
                                                        <div class="form-group">
                                                            <label>From Date <small class="text-danger">*</small></label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" name="leave_from_date" id="leave_from_date" required="" placeholder="dd-mm-yyyy" />
                                                                <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                                <input type="hidden" name="today_date" id="today_date" value="<?php echo date('d-m-Y');?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" id="to_date">
                                                        <div class="form-group">
                                                            <label>To Date <small class="text-danger">*</small></label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control"  placeholder="dd-mm-yyyy" name="leave_to_date" id="leave_to_date" required="" />
                                                                <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="optional_holiday" style="display:none;">

                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Optional Holiday List<small class="text-danger">*</small></label>
                                                            <select class="form-control" name="leave_from_date_1" id="optional_holiday_type" required="">
                                                                <option value="">Select Optional </option>

                                                            <?php


                                                            if (count($optional_leave_quotas) > 0) {

                                                            foreach ($optional_leave_quotas as $quotas) {
                                                            $dateconversion=$quotas['date'];
                                                                $date=date('d-m-Y',strtotime($dateconversion));
                                                                $name=$quotas['holiday_name'];
                                                                ?>
                                                                <option value="<?php echo $date;?>"><?php echo $date.' - '.$name; ?> </option>

                                                                <?php

                                                            }
                                                           }

                                                            ?>
                                                        </select>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Comments <small class="text-danger">*</small></label>
                                                            <textarea class="form-control commonAlphaNum" name="comments" id="comments" required="" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
												 <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                          <div class="cls_val"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-12 col-sm-4  col-md-4 ">
                                                        <ul class="vitals-links">
                                                            <li><button type="submit" id="submit_btn" class="vital_yellow_btn wdt_100">Apply</button></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </main>
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



<div class="modal" id="confirmModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Apply for Leave?</h4>
                            <p>Are you sure you want to  submit this leave request?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-success" onclick="submitRequest();" data-dismiss="modal">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal" id="confirmModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body onboarding-permission text-center">
                <div class="text-right">
                    <a class="portfolioclose" data-dismiss="modal">Close</a>
                </div>
                <div class="popup-content">
                    <p>Are you sure you want to apply the leave?</p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-secondary" onclick="submitRequest();" data-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="modal" id="confirmModal_wfh" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body onboarding-permission text-center">
                <div class="text-right">
                    <a class="portfolioclose" data-dismiss="modal">X</a>
                </div>
                <div class="popup-content">
                    <!-- <p>Please change the date and apply !</p> -->
                   <!--  <p>You cannot apply for work from home after 8:30 am today. Please select another date to apply for this leave type</p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="modal" id="confirmModal_wfh" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content data_congifpopup">
            <div class="modal-header text-center">
                <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                            class="fas fa-check-circle"></i></span> Apply for Leave</h5>
            </div>
            <div class="modal-body onboarding-permission text-center">
                <ul>
                    <p style="
    padding: 0 60px 0px 0px;
">You cannot apply for work from home after 8:30 am today. Please select another date to apply for this leave type.</p>
                </ul>
                <div class="popup-content-final popup-content">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="modal" id="confirmModal_wfh" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Apply for Work From Home?</h4>
                            <p style="
    padding: 0 60px 0px 0px;
">You cannot apply for work from home after 8:30 am today. Please select another date to apply for this leave type.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">

 function Leavetype(leavemethod) {
  var value = leavemethod.value;

 /* if(value == 'LTY014'){
    //$('#leave_length').append("<option value='3'>Optional Holiday</option>")
  }else{
     document.getElementById("optional_holiday_type").required = false;
    $('#optional_holiday').hide();
    //$("#leave_length option[value='3']").remove();
    $('#from_date').show();
    $('#to_date').show();
    document.getElementById("leave_from_date").required = true;
    document.getElementById("leave_to_date").required = true;

  } */

  if(value == 'LTY014'){
    document.getElementById("leave_from_date").required = false;
    document.getElementById("leave_to_date").required = false;
    document.getElementById("optional_holiday_type").required = true;
    $('#from_date').hide();
    $('#to_date').hide();
    $('#optional_holiday').show();

    //$('#leave_length').append("<option value='3'>Optional Holiday</option>")
  }else{
    $('#from_date').show();
    $('#to_date').show();
    $('#optional_holiday').hide();
    document.getElementById("leave_from_date").required = true;
    document.getElementById("leave_to_date").required = true;
     document.getElementById("optional_holiday_type").required = false;
    
    //$("#leave_length option[value='3']").remove();
  }   





  //console.log(value);
  }

  function Leavetypelength(leavemethodlength) {
  var value1 = leavemethodlength.value;

  if(value1 == '3'){
    document.getElementById("leave_from_date").required = false;
    document.getElementById("leave_to_date").required = false;
    document.getElementById("optional_holiday_type").required = true;
    $('#from_date').hide();
    $('#to_date').hide();
    $('#optional_holiday').show();

    //$('#leave_length').append("<option value='3'>Optional Holiday</option>")
  }else{
    $('#from_date').show();
    $('#to_date').show();
    $('#optional_holiday').hide();
    document.getElementById("leave_from_date").required = true;
    document.getElementById("leave_to_date").required = true;
     document.getElementById("optional_holiday_type").required = false;
    
    //$("#leave_length option[value='3']").remove();
  }  
  console.log(value1);
  }

  

	$(".cls_val").html('');
    $(document).on('click', '#submit_btn', function (e) {
       /*  var check_val = $("#applyleaveForm").valid();
        var from_date=$('#leave_from_date').val();
        var today_date=$('#today_date').val();
        var leave_type=$('#leave_type').val();
        var leave_type2=$('#leave_type').find(":selected").text();
		  
		if (check_val == true) {
		if(leave_type2=="Work From Home"){     
		if(today_date==from_date){

		var currentTime = new Date();
		var currentOffset = currentTime.getTimezoneOffset();

		var ISTOffset = 330;   // IST offset UTC +5:30 
		var ISTTime = new Date(currentTime.getTime() + (ISTOffset + currentOffset)*60000);
		// ISTTime now represents the time in IST coordinates
		var hoursIST = ISTTime.getHours()
		var minutesIST = ISTTime.getMinutes()
		var dateTime = hoursIST+':'+minutesIST;

		var standard_time='08:00';
		//var standard_time_2='07:01';false
		 $('#confirmModal_wfh').modal('hide');
		if(standard_time < dateTime){
		   $('#confirmModal_wfh').modal('show');
		   return  false;

		}

          }

        }
        
        $('#level_type_name').val(leave_type2);

            $('#confirmModal').modal('show');
            e.preventDefault();
        } else {
            $('#confirmModal').modal('hide');
        } */
		
		e.preventDefault();
		$(".cls_val").html('');
		var check_val = $("#applyleaveForm").valid();
        var from_date=$('#leave_from_date').val();
        var leave_to_date=$('#leave_to_date').val();
        var leave_type=$('#leave_type').val();
        var leave_type2=$('#leave_type').find(":selected").text();
		
		if($("#applyleaveForm").valid()){
			if($("#leave_type").val()=="LTY001"){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/leave/getCasualLeaveAjax",
					data: {
						fromDate: from_date,
						toDate: leave_to_date
					},
					dataType: 'json',
					success: function (msg) {
						if(msg.status=='0'){
							casualLeaveStatus = 1;
							e.preventDefault();
							$(".cls_val").html('<label style="text-align: inherit; color: #FF0000 !important; font-size: 12px !important; padding-left: 2px !important; float: left !important;" id="cl_validation_cls">Casual leave not allowed for more than 3 days</label>');
							return false;
						}else{
							callApplyLeave();
						}
					},
				});
			}else{
				callApplyLeave();
			}
		}
		
		function callApplyLeave(){
			if (check_val == true) {
				if(leave_type2=="Work From Home"){     
					if(today_date==from_date){

						var currentTime = new Date();
						var currentOffset = currentTime.getTimezoneOffset();

						var ISTOffset = 330;
						var ISTTime = new Date(currentTime.getTime() + (ISTOffset + currentOffset)*60000);
						var hoursIST = ISTTime.getHours()
						var minutesIST = ISTTime.getMinutes()
						var dateTime = hoursIST+':'+minutesIST;

						var standard_time='08:00';
						 $('#confirmModal_wfh').modal('hide');
						if(standard_time < dateTime){
						   $('#confirmModal_wfh').modal('show');
						   return  false; 
						}
				  }

			} 
				$('#level_type_name').val(leave_type2);
				$('#confirmModal').modal('show');
				e.preventDefault();
			} else {
				$('#confirmModal').modal('hide');
			}
		}
		
		

    });

    function submitRequest() {
        $('#applyleaveForm').submit();
    }

    $('#applyleaveForm').validate({
        rules: {
            leave_type: "required",
            leave_from_date: "required",
            leave_to_date: "required",
            comments: "required",
            leave_length: "required"
        },
        messages: {
            leave_type: "Select leave type",
            leave_from_date: "Select from date",
            leave_to_date: "Select to date",
            comments: "Enter comments",
            leave_length: "Select leave length"
        }
    });

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    var datesArray = [<?php echo $holiday_list; ?>];

    $("#leave_from_date").datepicker({
        dateFormat: "dd-mm-yy",
        beforeShowDay: function (date) {
            var theday = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
            return [true, $.inArray(theday, datesArray) >= 0 ? "specialDate" : ''];
        },
        onSelect: function () {
            var dt2 = $('#leave_to_date');
            var startDate = $(this).datepicker('getDate');
            startDate.setDate(startDate.getDate() + 30);
            var minDate = $(this).datepicker('getDate');
            var dt2Date = dt2.datepicker('getDate');
            var dateDiff = (dt2Date - minDate) / (86400 * 1000);

            if (dt2Date == null || dateDiff < 0) {
                dt2.datepicker('setDate', minDate);
            } else if (dateDiff > 30) {
                dt2.datepicker('setDate', startDate);
            }
            dt2.datepicker('option', 'maxDate', startDate);
            dt2.datepicker('option', 'minDate', minDate);
        }
    }).on("change", function () {
        calcDiff();
    });

    $('#leave_to_date').datepicker({
        dateFormat: "dd-mm-yy",
        minDate: 0,
        beforeShowDay: function (date) {
            var theday = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
            return [true, $.inArray(theday, datesArray) >= 0 ? "specialDate" : ''];
        },
    }).on("change", function () {
        calcDiff();
    });

    function calcDiff() {
        var d1 = $('#leave_from_date').datepicker('getDate');
        var d2 = $('#leave_to_date').datepicker('getDate');
        var diff = 0;
        if (d1 && d2) {
    diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000); // ms per day
}

if(diff > 0) {
        //$('#leave_length').css('display', 'none');
        $("#leave_length").attr("disabled", true);
        $("#leave_length").val(1);
    } else {
        //$('#leave_length').css('display', 'block');
        $("#leave_length").attr("disabled", false);
    } 
}

</script>



<style type="text/css">
    .ui-datepicker-week-end a {background: rgb(144, 238, 144) !important;}
    .ui-datepicker .specialDate a {color: #fff !important; background: #dc3545 !important;}
</style>

</body>
</html>
