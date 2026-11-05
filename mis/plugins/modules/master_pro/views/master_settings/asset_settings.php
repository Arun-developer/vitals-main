<?php $cat_type =  $this->uri->segment(4);
   $active_status = "" ;
   ?>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
   <main class="page-content">
      <div class="row dataconfig d_v_d_c">
         <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
            <h4>Master Settings</h4>
         </div>
         <div class="col-xl-8 col-lg-8 col-md-12 col-12 text-right">
            <ul class="vitals-links">
               <li>
                  <a href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_add_asset_form/'.$cat_type; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a>
               </li>
               <li class="edit">
                  <a style="display:none" href="javascript:" id="edit_btn" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
                  <a href="javascript:" style="color:#6bc08a" id="dummy_edit_btn" class="master_aduser"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
               </li>
               <li>
                  <a href="javascript:" id="delete_btn" class="master_deluser" data-toggle="modal" data-target=""><span><i class="fas fa-trash-alt"></i></span> Delete</a>
               </li>
            </ul>
         </div>
      </div>
      <form id="delete_form" action="<?php echo base_url().'index.php/master_pro/master/common_asset_delete' ?>" method="POST">
         <input type="hidden" name="redirect_master_type" value="<?php echo $cat_type; ?>">
         <div class="delete_ids"></div>
      </form>
      <div class="plan-structure-vital">
         <div>
            <div class="newCLickTabs">
               <div>
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation" class="<?php  if($cat_type == 'donor') echo $active_status = "active" ; ?>" ><a href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/donor'; ?>"  role="tab" >Donor</a></li>
                     <li role="presentation" class="<?php  if($cat_type == 'budget_head') echo $active_status = "active" ; ?>" ><a href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/budget_head'; ?>"  role="tab">Budget Head</a></li>
                     <li role="presentation" class="<?php  if($cat_type == 'line_item') echo $active_status = "active" ; ?>" ><a href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/line_item'; ?>" role="tab">Line Item</a></li>
                     <li role="presentation" class="<?php  if($cat_type == 'additional_info') echo $active_status = "active" ; ?>" ><a  href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/additional_info'; ?>" role="tab" ">Additional Info</a></li>
                     <li role="presentation"><a href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/line_item'; ?>" role="tab" >Balance Sheet</a></li>
                     <li role="presentation"><a  href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/line_item'; ?>" role="tab" >Financial Year</a></li>
                     <li role="presentation"><a  href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/line_item'; ?>" role="tab" >Programme</a></li>
                     <li role="presentation"><a  href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/line_item'; ?>" role="tab" >Set Admin Email</a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="tab-slider--container tab-content">
            <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
               <main class="page-content">
                  <div class="inputplan-structureall plan-structure-new">
                     <div class="row leaveLabel">

                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                           <?php if(!empty($donorList) && $tab_title == 'Budget Head'){ ?>
                           <label><?php echo 'Donor'; ?></label>
                              <div class="form-group">
                                 <select name="donor_filter_msid" id="donor_filter_msid" class="form-control">
                                    <option value ="">Please select the donor type</option>
                                    <?php foreach($donorList as $lists){ ?>
                                    <option <?php if($donor_val == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           <?php } ?> 

                           <?php if(!empty($donorList_search)){ ?>
                              <label><?php echo 'Donor'; ?></label>
                              <div class="form-group">
                                 <select  name="donor_filter_msid" id="donor_filter_msid" class="form-control">
                                    <option value ="">Please select the donor type</option>
                                    <?php foreach($donorList_search as $lists){ ?>
                                    <option <?php if($donor_id == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           <?php } ?>
                           <label><?php echo $tab_title; ?></label>
                           <div class="form-group has-search-right mar-bt8 wdt_180">
                              <a id="search_btn" class="form-control-feedback"><span class="fa fa-search"></span></a>
                              <input type="text" id="filter_type" name="filter_type" class="form-control" value="<?php if($filter_val!='')echo $filter_val; ?>" placeholder="Search">
                              <a href="<?php echo base_url().'index.php/master_pro/master/disaplay_asset/'.$cat_type; ?>"><span class="vitals_clearSearch">Clear search</span></a>       
                           </div>
                       </div>
                       <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                              <?php if(!empty($budgetList)){ ?>
                              <label><?php echo 'Budget Head'; ?></label>
                              <div class="form-group">
                                 <select  name="budget_filter_msid" id="budget_filter_msid" class="form-control">
                                    <option value="">Please select the budget type</option>
                                 </select>
                              </div>
                              <?php } ?>
                       </div>
                       
                     </div>
                     <form id="display_lists" class="display_lists" name="display_lists" action="<?php echo base_url().'index.php/master_pro/master/update_asset_master_data' ?>" method="POST">
                        <input type="hidden" name="master_type" id="master_type" value="<?php echo $cat_type; ?>">
                        <div class="row">
                           <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                              <table class="table table-hover dt-responsive">
                                 <thead>
                                    <tr>
                                       <th><input type="checkbox" id="select_all" class="form-control"/></th>
                                       <?php if($cat_type == 'line_item'){?>
                                       <th>Budget Head</th>
                                       <?php } ?>
                                       <?php if($cat_type == 'budget_head' || $cat_type == 'donor' || $cat_type == 'line_item'){?>      
                                       <?php if(!empty($donorList)){?>
                                       <th>Donor</th>
                                       <?php } ?>
                                       <?php } ?>
                                       <?php if($cat_type == 'additional_info'){?> 
                                       <th>Programme</th>
                                       <th>Donor</th>
                                       <th>Budget Head</th>
                                       <th>Line Item</th>
                                       <?php } ?>
                                       <th><?php echo $tab_title; ?></th>
                                       <th>Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if(!empty($get_results)){ ?>
                                    <?php $i = 0; foreach($get_results as $type_lists){ ?>        
                                    <tr id="td_<?php echo $type_lists->master_id; ?>">
                                       <td><input type="checkbox" name="checkbox[]" value="<?php echo $type_lists->master_id; ?>" class="form-control check_box_list"/></td>
                                       <?php if($cat_type == 'line_item'){?>
                                       <?php if(!empty($budgetList)){?>
                                       <td>
                                          <select name="budget_head[]" id="budget_head" data-err="budget_head_<?php echo $i; ?>" class="form-control required" disabled>
                                             <option value ="">Please select the budget head</option>
                                             <?php foreach($budgetList as $lists){ ?>
                                             <option  <?php if($type_lists->pid == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <input type="hidden" disabled name="hid_budget_head[]"   value="<?php echo $i; ?>"/>
                                          <label style="display: block;" class="error tbl_err" id="budget_head_<?php echo $i; ?>"></label>
                                       </td>
                                       <?php } ?>
                                       <?php } ?>
                                       <?php if($cat_type == 'budget_head' || $cat_type == 'donor' || $cat_type == 'line_item'){?>      
                                       <?php if(!empty($donorList)){?>
                                       <td>
                                          <select name="donor_master_id[]" id="donor_master_id" data-err="donor_master_<?php echo $i; ?>" class="form-control required" disabled>
                                             <option value ="">Please select the donor type</option>
                                             <?php foreach($donorList as $lists){ ?>
                                             <option <?php if($type_lists->pid == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                          <input type="hidden" disabled name="hid_donor_master[]"   value="<?php echo $i; ?>"/>
                                          <label style="display: block;" class="error tbl_err" id="donor_master_<?php echo $i; ?>"></label>
                                       </td>
                                       <?php } ?>
                                       <?php } ?>
                                       <?php if($cat_type == 'additional_info'){?>      
                                       <?php  if(!empty($programme)){?>
                                       <td>
                                          <select style="width:123px" name="programmes[]" id="programmes_<?php echo $i; ?>" class="form-control required" disabled>
                                             <option value ="">Select programme</option>
                                             <?php foreach($programme as $lists){ ?>
                                             <option <?php //if($type_lists->pid == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists->programme_id; ?>"><?php echo $lists->programme; ?></option>
                                             <?php } ?>
                                          </select>
                                          <input type="hidden" disabled name="hid_programmes[]"   value="<?php echo $i; ?>"/>
                                          <label style="display: block;" class="error tbl_err" id="programmes_<?php echo $i; ?>"></label>
                                       </td>
                                       <?php  } ?>
                                       <?php if(!empty($donorList)){?>
                                       <td>
                                          <input type="hidden" disabled name="hid_donor_master[]"  value="<?php echo $i; ?>"/>
                                          <select  style="width:120px" name="donor_master_id[]" id="donor_master_id" class="form-control required" disabled>
                                             <option value ="">Select donor type</option>
                                             <?php foreach($donorList as $lists){ ?>
                                             <option <?php if($type_lists->pid == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                       </td>
                                       <?php } ?>
                                       <?php if(!empty($budgetList)){?>
                                       <td>
                                          <select style="width:123px" name="budget_head[]" id="budget_head" class="form-control required" disabled>
                                             <option value ="">Select budget</option>
                                             <?php foreach($budgetList as $lists){ ?>
                                             <option  <?php if($type_lists->pid == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                       </td>
                                       <?php } ?>
                                       <?php if(!empty($lineitemList)){?>
                                       <td>
                                          <select style="width:120px" name="lineitemList[]" id="lineitemList" class="form-control required" disabled>
                                             <option value ="">Select Line</option>
                                             <?php foreach($lineitemList as $lists){ ?>
                                             <option  <?php if($type_lists->pid == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>
                                             <?php } ?>
                                          </select>
                                       </td>
                                       <?php } ?>
                                       <?php } ?>
                                       <td>
                                          <input type="text" disabled name="master_name[]" data-err="master_<?php echo $i; ?>" value="<?php if(isset($type_lists->master_name) && $type_lists->master_name!='') echo $type_lists->master_name; ?>" class="form-control"/>
                                          <input type="hidden" disabled name="master_err_id[]"  value="<?php echo $i; ?>"/>
                                          <label style="display: block;" class="error tbl_err" id="master_<?php echo $i; ?>"></label>
                                          <input type="hidden" disabled name="master_id[]" value="<?php echo $type_lists->master_id; ?>" class="form-control"/> 
                                       </td>
                                       <td>
                                          <select name="status[]" class="form-control" disabled>
                                             <option <?php if(isset($type_lists->status) && $type_lists->status!=''){ if($type_lists->status == 1)echo"selected";}  ?> value ="1">Active</option>
                                             <option <?php if(isset($type_lists->status) && $type_lists->status!=''){ if($type_lists->status == 0)echo"selected";}  ?> value ="0">Inactive</option>
                                          </select>
                                       </td>
                                    </tr>
                                    <?php  $i++; } ?>   
                                    <?php  } ?>                                                        
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </form>
                     <div class="row justify-content-end">
                        <div class="col-12 col-sm-4  col-md-4 ">
                           <div class="text-right">
                              <ul class="vitals-links saveLinkView display-hide">
                                 <li><a href="javascript:" id="save_btn" class="vital_yellow_btn">Update Master</a></li>
                                 <li><a class="vital_bordered_btn">Reset</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </main>
            </div>
         </div>
      </div>
      <?php echo $pagination;?>                                               
   </main>
</div>
</div>
</div>
</div>
</div>
</body>
<script type="text/javascript">
   $(document).ready(function(){
      $('table').DataTable();
      var budget_data = '<?php echo $budget_id; ?>';  var budget_id = '';
      if(budget_data !='' && budget_data!=undefined ){
         budget_id = budget_data;
      }
      var donor_filter_msid = $("#donor_filter_msid").val();
      if(donor_filter_msid !='' && donor_filter_msid != undefined){
         ajax_call_fun(donor_filter_msid,budget_id);
      }    
      $('#donor_filter_msid').on('change', function() {
         var donor_id = this.value;
         ajax_call_fun(donor_id,budget_id);
      });
      
      function ajax_call_fun(donor_id,budget_id){
         $.ajax({
               url: '<?php echo base_url().'index.php/master_pro/master/get_budget_ajax_data' ?>',
               cache: false,
               type: "POST",
               data: {donor_id : donor_id,budget_id:budget_id},
               dataType: "json",
               success: function(response){ console.log('response' + response);
                  $("#budget_filter_msid").html('');
                  if(response.status == 1){
                        $("#budget_filter_msid").html(response.response);
                  }else if(response.status == 0){
                        $("#budget_filter_msid").html('<option value="">Please select the budget type</option>');    
                  }
               }
         });
      }
   });
   
   $(function() {
   	   $("#display_lists").validate();
   });
   $('#search_btn').click(function() {
       var filter_val = $("#filter_type").val();
       var donor_filter_msid = $("#donor_filter_msid").val();
       var budget_filter_msid = $("#budget_filter_msid").val();
       var common_filter_val = '';
       var cat_type = '<?php echo $cat_type; ?>';
       
       if(cat_type != '' && cat_type == 'budget_head'){
         if(donor_filter_msid !='' && donor_filter_msid != undefined){
            common_filter_val= '&donor_val='+btoa(donor_filter_msid);
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?donor_val=' ?>'+btoa(donor_filter_msid);
         }
       }
       if(budget_filter_msid!='' && budget_filter_msid!=undefined && cat_type == 'line_item'){
            common_filter_val= '&budget_id='+btoa(budget_filter_msid);
            if(donor_filter_msid !='' && donor_filter_msid != undefined){
                common_filter_val= '&donor_id='+btoa(donor_filter_msid)+common_filter_val;   
            }
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?' ?>'+common_filter_val;
        }
       if(filter_val!='' && filter_val!= undefined){
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?filter_val=' ?>'+btoa(filter_val)+common_filter_val;
         }
   });
   
   $('.vital_bordered_btn').click(function() {
       window.location.reload();
   });
   
           
   $(".check_box_list").click(function () { 
       $(".delete_ids").html("");
       $(".master_deluser").removeClass("master_deluser_mark");
       if($('#display_lists input:checked').length > 0){
               delete_checkbox();
               $("#delete_btn").attr({ "data-target" : "#deleteModal"});
               $(".master_deluser").css("color", "#e52644");
               $(".master_deluser").addClass("master_deluser_mark");
       }else{
           $("#delete_btn").attr({ "data-target" : ""});
       }
   }); 
   function delete_checkbox(){
       checkbox_ids = [];
       i=0;
       $(".check_box_list").each(function() {
           if(this.checked) {
               checkbox_ids[i] = this.value;
               i++;
           }
       });
       $(".delete_ids").html("<input type='hidden' name='delete_ids' id='delete_ids' value='"+checkbox_ids+"'>");
   }
   
   $("#save_btn").click(function(e) {
     var master_val = $("#master_type").val();
      //console.log('master_val'+master_val);
      manual_required('display_lists');
      if((master_val == 'donor' || master_val == 'budget_head'|| master_val == 'line_item') && err_count ==0 ){
         check_ajax_master_data();
      }
      function check_ajax_master_data(){
         $.ajax({
               url: '<?php echo base_url().'index.php/master_pro/master/check_ajax_duplication' ?>',
               cache: false,
               type: "POST",
               data:$("#display_lists").serialize(),
               dataType: "json",
               success: function(response){
                  if(response.status > 0){
                     for (const [key, value] of Object.entries(response.response)) {
                        $("#"+key).text(value);
                     }
                  }
                  if(response.status == 0){
                     if(err_count == 0){
                        $("#display_lists").submit();
                     }
                  }
               }
         });
      }
   
   });
   
    
   
   
</script>
<style>
   .master_deluser_mark {
   color: red !important;
   } 
</style>
</html>