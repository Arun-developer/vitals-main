<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => $this->session->userdata['partner_name'] . ' - User Setup')); ?>


<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'user_setup')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>AN Assign User</h4>
                    </div>
                </div>
                <?php if ($successMsg != '') { ?>
                    <div id="toast-container" aria-live="polite" class="manual_msg" aria-atomic="true" style="margin-top: -36px;">
                        <div id="toast-wrapper">
                            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-success text-white">
                                    <strong class="mr-auto"><?= $successMsg; ?></strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="plan-structure-vital vital_windowScroll" style="height: 500px;">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane userActiveSetupNew active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <form method="post" name="insertEdit_usersetup" id="insertEdit_usersetup" action="<?php echo base_url() . 'index.php/user/insertEdit_an_assign_users'; ?>" class="form" novalidate autocomplete="off">
                                    <div class="inputplan-structureall plan-structure-new">
                                        		
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Between 50,000 to 3,00,000  (Non incubation activity)</label>
                                                    <select name="lessthan_3" id="ceo" class="form-control edit_cls">
                                                        <option value="">--Select--</option>
														<?php  foreach($users as $lists){ 
														
															$selected_txt ='';
															if($get_user_data[0]->id=='1'){
																if($lists['id'] == $get_user_data[0]->below_three_lakhs){
																	$selected_txt ='selected';
																}
															}
														
														?>
															<option <?php echo $selected_txt;?> value="<?php  echo $lists['id']; ?>"><?php echo  $lists['emp_name']; ?></option>
														<?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Above 3 Lakhs (Non incubation activity)</label>
                                                    <select name="above_3" id="cio" class="form-control edit_cls">
                                                        <option value="">--Select--</option>
														<?php  foreach($users as $list){ 
														
															$selected_txt1 ='';
															if($get_user_data[0]->id=='1'){
																if($list['id'] == $get_user_data[0]->above_three_lakhs){
																	$selected_txt1 ='selected';
																}
															}
														
														?>
															<option <?php echo $selected_txt1;?> value="<?php  echo $list['id']; ?>"><?php echo  $list['emp_name']; ?></option>
														<?php } ?>
														
                                                    </select>
                                                </div>
                                            </div>
											
											
											<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Above 10 Lakhs (Both for incubation and non incubation activity)</label>
                                                    <select name="above_ten_lakhs" id="cio" class="form-control edit_cls">
                                                        <option value="">--Select--</option>
														<?php  foreach($users as $list){ 
														
															$selected_txt1 ='';
															if($get_user_data[0]->id=='1'){
																if($list['id'] == $get_user_data[0]->above_ten_lakhs){
																	$selected_txt1 ='selected';
																}
															}
														
														?>
															<option <?php echo $selected_txt1;?> value="<?php  echo $list['id']; ?>"><?php echo  $list['emp_name']; ?></option>
														<?php } ?>
														
                                                    </select>
                                                </div>
                                            </div>
											
                                        </div>
                                        <div class="row leaveLabel">
                                            <div id="submit_btn_cls" class="col-12 col-sm-4  col-md-4" >
                                                <ul class="vitals-links">
                                                    <li><input type="submit" value="Save" id="submit_btn" class="vital_yellow_btn wdt_100"></input></li>
                                                    <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable', 'page_load' => 'user_setup')); ?>

<style>
.page-content{
height: -500%!important;
}
</style>
<script type="text/javascript">

</script>

<style type="text/css">
    .vitals_mainContent .tabpanel-details label {
        color: #212529;
        font-size: 13px !important;
    }


    .vitals_mainContent .tabpanel-details label {
        color: #212529;
        font-size: 13px !important;
    }
    .selected{
        width: 225px;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget {
        width: 100% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected,.ui-multiselect.ui-helper-clearfix.ui-widget .available{
        width: 50% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected .selected.connected-list.ui-sortable,.ui-multiselect.ui-helper-clearfix.ui-widget .available .available.connected-list{
        width: 100% !important;
    }
    .multiselect {
        height: 250px !important;
    }

</style>

</body>
</html>