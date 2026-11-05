<?php
$current_page = $this->uri->segment(2); 
   $tab_status = "";
   if(isset($current_page) && $current_page!='' ){
      $tab_status = "active";
   }
?>
<style>
    .fa-search{
        margin-top: 10px;
    }
    .pagination{
        float: right;
        margin-right: 30px;
        margin-top:-18px;
    }
    .dataTables_info{
        display:none;
    }
   

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>
    <?php $this->load->view('../templates/includes.php'); ?>
   </head>

   <!-- Model (Print) -->
<div class="modal" id="deleteModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                            </div>
                        </div>
                </div>
                </div>
                <div class="modal-footer">                        
                     <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                    <button type="button" class="btn btn-success" id="editSubmit"> Delete Selected</button>
                </div>
        </div>
    </div>
</div>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('../templates/header.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="Vital-Newmenu">
                <div class="row">
                    <div class="col">
                        <ul>
                            <li><a href=""><i class="fas fa-home"></i> Home</a></li>
                            <li><a href=""><i class="fas fa-tag"></i> Deals</a></li>
                            <?php if ($this->session->userdata['user_type'] == 'employee' && $this->session->userdata['ais_privilege'] == '1') { ?>
                              <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/leave_list'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <?php } ?> 
                            <?php if ($this->session->userdata['ais_privilege'] == '1') { ?>
                              <li><a href=""><i class="far fa-check-square"></i> Approve</a></li>
                            <?php } ?>
                            <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <?php if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                              <li class="<?php echo $tab_status; ?>"><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>    
                            <?php } ?>  
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('../templates/sidemenu.php', array('page' => 'master_setting')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    
                     <?php if (($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'assigned') || ($this->uri->segment('2') == 'innovation_pool' && $this->uri->segment('3') == 'all')) { ?>
                        <?php } else { ?>
                        <?php } ?>
                     <?php $this->load->view('../message'); ?>
                     <?php
                        if ($this->uri->segment('1') == 'master' && ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin')) {
                           $this->load->view('master/left_menu');
                        }
                        $this->load->view($cpage);
                        ?> 
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
$(document).ready(function () {
    window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted ||( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
        if ( historyTraversal ) { 
            window.location.reload();
        }
    });
    var flashdata  = '<?php echo $this->session->flashdata('Success'); ?>';
	if(flashdata !='' ){
		toastr.success(flashdata, 'Success')
        //window.location.reload();
    }
    var flashdata  = '<?php echo $this->session->flashdata('error'); ?>';
	if(flashdata !='' ){
		toastr.error(flashdata, 'Error')
    }
    if($('#display_lists input:checked').length > 0){
        $(".master_deluser").addClass("master_deluser_mark");
        $(".master_deluser").css("color", "#e52644");   
        $("#delete_btn").attr({ "data-target" : "#deleteModal"});
    }else{
        $(".master_deluser").removeClass("master_deluser_mark");
        $("#delete_btn").attr({ "data-target" : ""});
    }


$('#editSubmit').click(function () {
   $("#delete_form").submit();
});

});


</script>

<?php $this->load->view('../templates/common_footer.php'); ?>
</html>