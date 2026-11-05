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
                  <a href="javascript:" id="edit_btn" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
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
                           <div class="col-xl-7 col-lg-7 col-md-12 col-12 ">
                              <ul class="vitals-links">
                                <li class="pad-lt15px">  
                                    <?php $total_length = php72_count($get_results)+1; ?>
                                    <?php if(!empty($programme)){ ?>
                                       <label><?php echo 'Programme'; ?></label>
                                          <div class="form-group has-search-right mar-bt8 wdt_190">
                                             <select  name="programme" id="programmes_<?php echo $total_length; ?>" class="form-control programmes_filter">
                                                <option value ="">Please select the Programme</option>  
                                                <?php foreach($programme as $lists){ ?>
                                                    <option <?php if($programmes_filter == $lists->programme_id)echo "selected"; ?>  value ="<?php echo $lists->programme_id; ?>"><?php echo $lists->programme; ?></option>  
                                                <?php } ?>
                                             </select>
                                             
                                          </div>
                                    <?php } ?>
                                    <?php if(!empty($donorList)){ ?>
                                       <label><?php echo 'Donor'; ?></label>
                                          <div class="form-group has-search-right mar-bt8 wdt_190">
                                             <select  name="donor" id="donor_<?php echo $total_length; ?>" class="form-control donor_filter">
                                                <option value ="">Please select the Donor</option>  
                                                <?php foreach($donorList as $lists){ ?>
                                                    <option <?php if($donor_filter == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>  
                                                <?php } ?>
                                             </select>
                                             
                                          </div>
                                    <?php } ?>
                                    <?php if(!empty($budgetList)){ ?>
                                        <label><?php echo 'Budget Head'; ?></label>
                                          <div class="form-group has-search-right mar-bt8 wdt_190">
                                             <select  name="budget" id="budget_<?php echo $total_length; ?>" class="form-control budget_filter">
                                                <option value ="">Please select the Budge Head</option>  
                                                <?php foreach($budgetList as $lists){ ?>
                                                    <option <?php if($budget_filter == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>  
                                                <?php } ?>
                                             </select>
                                          </div>
                                    <?php } ?> 
                                    <?php if(!empty($lineitemList)){ ?>
                                        <label><?php echo 'line item'; ?></label>
                                          <div class="form-group has-search-right mar-bt8 wdt_190">
                                             <select   name="lineitemList" id="lineitemList_<?php echo $total_length; ?>" class="form-control lineitemList_filter">
                                                <option value ="">Please select the line item</option>  
                                                <?php foreach($lineitemList as $lists){ ?>
                                                    <option <?php if($lineitemList_filter == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>  
                                                <?php } ?>
                                             </select>
                                          </div>
                                    <?php } ?> 
                                    <label><?php echo $tab_title; ?></label>
                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                       <a id="search_btn" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                       <input type="text" id="filter_type" name="filter_type" class="form-control" value="<?php if($filter_val!='')echo $filter_val; ?>" placeholder="Search">
                                    </div>
                                 </li>
                                 <li><a href="<?php echo base_url().'index.php/master_pro/master/disaplay_asset/'.$cat_type; ?>"><span class="vitals_clearSearch">Clear search</span></a></li>
                              </ul>
                           </div>
                        </div>

                        <form id="display_lists" name="display_lists" action="<?php echo base_url().'index.php/master_pro/master/update_additionalinfo_master_data' ?>" method="POST">
                           <input type="hidden" name="master_type" value="<?php echo $cat_type; ?>">
                              <div class="row">
                                 <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                    <table class="table table-hover dt-responsive">
                                       <thead>
                                          <tr>
                                             <th><input type="checkbox" id="select_all" class="form-control"/></th>
                                                <th>Programme</th>    
                                                <th>Donor</th> 
                                                <th>Budget Head</th> 
                                                <th>Line Item</th> 
                                             <th><?php echo $tab_title; ?></th>
                                             <th>Status</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php if(!empty($get_results)){ ?>
                                          <?php $i = 0; foreach($get_results as $type_lists){ #echo'<pre>';print_r($type_lists);die; ?>        
                                          <tr>
                                             <input type="hidden" name="id[]" value="<?php echo $type_lists->id; ?>" class="form-control"/>                   
                                             <td><input type="checkbox" name="checkbox[]" value="<?php echo $type_lists->id; ?>" class="form-control check_box_list"/></td>
                                             
                                                <?php  if(!empty($programme)){?>
                                                   <td>
                                                      <div class="form-group">
                                                         <select style="width:123px" name="programmes[]" id="programmes_<?php echo $i; ?>" class="form-control required" disabled>
                                                            <option value ="">-- Select --</option>  
                                                            <?php foreach($programme as $lists){ ?>
                                                               <option <?php if($type_lists->programme == $lists->programme_id)echo "selected"; ?> value ="<?php echo $lists->programme_id; ?>"><?php echo $lists->programme; ?></option>  
                                                            <?php } ?>
                                                         </select>
                                                      </div>
                                                   </td>
                                                <?php  } ?>
                                                <?php if(!empty($donorList)){?>
                                                   <td>
                                                      <div class="form-group">
                                                         <select  style="width:120px" name="donor_master_id[]" id="donor_<?php echo $i; ?>" class="form-control required" disabled>
                                                            <option value ="">-- Select --</option>  
                                                            <?php foreach($donorList as $lists){ ?>
                                                               <option <?php if($type_lists->donor == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>  
                                                            <?php } ?>
                                                         </select>
                                                      </div>
                                                   </td>
                                                <?php } ?>
                                                <?php if(!empty($budgetList)){?>
                                                   <td>
                                                      <div class="form-group">
                                                         <select style="width:123px" name="budget_head[]" id="budget_<?php echo $i; ?>" class="form-control required" disabled>
                                                            <option value ="">-- Select --</option>  
                                                            <?php foreach($budgetList as $lists){ ?>
                                                               <option  <?php if($type_lists->budgethead == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>  
                                                            <?php } ?>
                                                         </select>
                                                      </div>
                                                   </td>
                                                <?php } ?>
                                                <?php if(!empty($lineitemList)){?>
                                                   <td>
                                                      <div class="form-group">
                                                         <select style="width:120px" name="lineitemList[]" id="lineitemList_<?php echo $i; ?>" class="form-control required" disabled>
                                                            <option value ="">-- Select --</option>  
                                                            <?php foreach($lineitemList as $lists){ ?>
                                                               <option  <?php if($type_lists->lineitem == $lists['master_id'])echo "selected"; ?> value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>  
                                                            <?php } ?>
                                                         </select>
                                                      </div>
                                                   </td>
                                                <?php } ?>

                                             <td><input type="text" disabled name="master_name[]" id="master_name_<?php echo $i; ?>"  value="<?php if(isset($type_lists->additionalinfo) && $type_lists->additionalinfo!='') echo $type_lists->additionalinfo; ?>" class="form-control"/></i></td>
                                             <td>
                                                <div class="form-group">
                                                   <select name="status[]" class="form-control" disabled>
                                                      <option <?php if(isset($type_lists->status) && $type_lists->status!=''){ if($type_lists->status == 1)echo"selected";}  ?> value ="1">Active</option>
                                                      <option <?php if(isset($type_lists->status) && $type_lists->status!=''){ if($type_lists->status == 0)echo"selected";}  ?> value ="0">Inactive</option>
                                                   </select>
                                                </div>
                                             </td>
                                          </tr>
                                          <?php $i++; } ?>   
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
                                    <li><a id="save_btn" class="vital_yellow_btn">Update Master</a></li>
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
        $('select').on('change', function() {
            var current_id = this.id; 
            var current_value = this.value; 
            var split_cid =  current_id.split("_");
            var select_type = split_cid[0];
            var select_count = split_cid[1];
            var search_type = '0';

            var addinfo_length = '<?php echo php72_count($get_results)+1; ?>';
            console.log('addinfo_length' + addinfo_length);
            console.log('current_id'+ current_id);
            var donor_option_txt = budget_option_txt = line_option_txt ='-- Select --';
            if(addinfo_length == select_count){
                var search_type = '1';
                if(select_type=='programmes'){
                    var donor_option_txt = 'Please select the Donor';
                    var budget_option_txt = 'Please select the Budge Head';
                    var line_option_txt = 'Please select the Line item';
                }else if(select_type=='donor'){
                    var budget_option_txt = 'Please select the Budge Head';
                    var line_option_txt = 'Please select the Line item';
                }else if(select_type=='budget'){
                    var line_option_txt = 'Please select the Line item';
                }
            }
            if(select_type=='programmes'){
                $("#donor_"+select_count).html('<option value="">'+donor_option_txt+'</option>');
                $("#budget_"+select_count).html('<option value="">'+budget_option_txt+'</option>');
                $("#lineitemList_"+select_count).html('<option value="">'+line_option_txt+'</option>');
            }else if(select_type=='donor' && addinfo_length != select_count){
                $("#budget_"+select_count).html('<option value="">'+budget_option_txt+'</option>');
                $("#lineitemList_"+select_count).html('<option value="">'+line_option_txt+'</option>');
            }else if(select_type=='budget' && addinfo_length != select_count){
                $("#lineitemList_"+select_count).html('<option value="">'+line_option_txt+'</option>');
            }
            if(current_id!='' && current_id!=undefined && current_value!='' && current_value!= undefined){
                ajax_call_options(select_type,current_id,current_value,select_count,search_type);
            }    
        });
    });
    function ajax_call_options(select_type,current_id,current_value,select_count,search_type){
        $.ajax({
            url: '<?php echo base_url().'index.php/master_pro/master/get_ajax_option_data' ?>',
            cache: false,
            type: "POST",
            data: {select_type : select_type,current_id : current_id,current_value : current_value,search_type:search_type},
            dataType: "json",
            success: function(response){ //console.log('response' + response);
                if(select_type=='programmes'){
                    $("#donor_"+select_count).html('');
                    if(response.current_id!=''){
                        $("#donor_"+select_count).html(response.response);
                    } 
                }else if(select_type=='donor'){
                    $("#budget_"+select_count).html('');
                    if(response.current_id!=''){
                        $("#budget_"+select_count).html(response.response);
                    }
                }else if(select_type=='budget'){
                    $("#lineitemList_"+select_count).html('');
                    if(response.current_id!=''){
                        $("#lineitemList_"+select_count).html(response.response);
                    }
                } 
            }
        });
    }

   $(function() {
   	   $("#display_lists").validate();
   });
   $('#search_btn').click(function() {
       var filter_val = $("#filter_type").val();
       var donor_filter_msid = $("#donor_filter_msid").val();
       var budget_filter_msid = $("#budget_filter_msid").val();
       var common_filter_val = '';
       var cat_type = '<?php echo $cat_type; ?>';
       var programmes_filter = $(".programmes_filter").val();
       var donor_filter = $(".donor_filter").val();
       var budget_filter = $(".budget_filter").val();
       var lineitemList_filter = $(".lineitemList_filter").val();

        var common_filter_val = '';
        if(programmes_filter !='' && programmes_filter != undefined){
            common_filter_val= '&programmes_filter='+btoa(programmes_filter);
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?programmes_filter=' ?>'+btoa(programmes_filter);
        }
        if(donor_filter!='' && donor_filter!=undefined){
            common_filter_val= '&donor_filter='+btoa(donor_filter)+common_filter_val;  
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?' ?>'+common_filter_val;
        }
        if(budget_filter!='' && budget_filter!=undefined){
            common_filter_val= '&budget_filter='+btoa(budget_filter)+common_filter_val;   
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?' ?>'+common_filter_val;
        }
        if(lineitemList_filter!='' && lineitemList_filter!=undefined){
            common_filter_val= '&lineitemList_filter='+btoa(lineitemList_filter)+common_filter_val;   
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?' ?>'+common_filter_val;
        }
        if(filter_val!='' && filter_val!= undefined){
            window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_asset/'.$cat_type.'?filter_val=' ?>'+btoa(filter_val)+common_filter_val;
        }
   });
   
   $('.summaryEdit').click(function() {
     
   });
   $('.vital_bordered_btn').click(function() {
       window.location.reload();
   });
   $('#save_btn').click(function () {
       $("#display_lists").submit();
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
</script>
<style>
   .master_deluser_mark {
   color: red !important;
   } 
</style>
</html> 