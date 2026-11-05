<?php $cat_type =  $this->uri->segment(4);
$active_status = "" ;
?>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
  <div class="plan-structure-vital vital_windowScroll">
  
   <main class="page-content">
      <div class="row dataconfig d_v_d_c">
         <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
            <h4>Master Settings</h4>
         </div>
      </div>
      <form id="delete_form" action="<?php echo base_url().'index.php/master_pro/master/common_delete' ?>" method="POST">
         <input type="hidden" name="redirect_master_type" value="<?php echo $cat_type; ?>">
         <div class="delete_ids"></div>
      </form>
      <div class="plan-structure-vital">
             <div class="col-12 col-md-4 col-lg-4 col-xl-4">
               <label>Type</label>
               <div class="form-group">
                  <select name="form_type" id="form_type" class="form-control">
                     <option <?php if((isset($form_type) && $form_type == 'travel_mode') || $cat_type == 'travel_mode')echo "selected"; ?> value="travel_mode">Travel mode</option>
                     <option <?php if((isset($form_type) && $form_type == 'pay_grade') || $cat_type == 'book_cat')echo "selected"; ?> value="book_cat">Book category</option>
                     <option <?php if((isset($form_type) && $form_type == 'it_asset') || $cat_type == 'it_asset')echo "selected"; ?> value="it_asset">It assets</option>
                     <option <?php if((isset($form_type) && $form_type == 'business_card_category') || $cat_type == 'business_card_category')echo "selected"; ?> value="business_card_category">Business card category</option>
                     <option <?php if((isset($form_type) && $form_type == 'utilities_type') || $cat_type == 'utilities_type')echo "selected"; ?> value="utilities_type">Utilities type</option>
                     <option <?php if((isset($form_type) && $form_type == 'pay_grade') || $cat_type == 'pay_grade')echo "selected"; ?> value="pay_grade">Pay Grade</option>
                     <option <?php if((isset($form_type) && $form_type == 'job_specification') || $cat_type == 'job_specification')echo "selected"; ?> value="job_specification">Job specification</option>
                  </select>
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
                                 <label><?php echo $tab_title; ?></label>
                                 <div class="form-group has-search-right mar-bt8 wdt_180">
                                    <a id="search_btn" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                    <input type="text" id="filter_type" name="filter_type" class="form-control" value="<?php if($filter_val!='')echo $filter_val; ?>" placeholder="Search">
                                    <li><a href="<?php echo base_url().'index.php/master_pro/master/master_settings/'.$cat_type; ?>"><span class="vitals_clearSearch">Clear search</span></a></li>
                                 </div>
                                 
                                 <div class="col-xl-5 col-lg-5 col-md-12 col-12 text-right">
                                    <label>&nbsp;</label>
                                    <ul class="vitals-links">
                                       <li>
                                          <a href="<?php echo base_url() . 'index.php/master_pro/master/disaplay_add_edit_form/'.$cat_type; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a>
                                       </li>
                                       <li class="edit">
                                          <a style="display:none" href="javascript:" id="edit_btn" class="master_aduser"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
                                          <a href="javascript:" style="color:#6bc08a" id="dummy_edit_btn" class="master_aduser"><span><i class="fas fa-pencil-alt"></i></span> Edit</a>
                                       </li>
                                       <li>
                                          <a href="javascript:" id="delete_btn" class="master_deluser" data-toggle="modal" data-target=""><span><i class="fas fa-trash-alt"></i></span> Delete</a>
                                       </li>
                                    </ul>
                                </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                           <form id="display_lists"  class="display_lists"  name="display_lists" action="<?php echo base_url().'index.php/master_pro/master/update_master_data' ?>" method="POST">
                              <input type="hidden" name="master_type" value="<?php echo $cat_type; ?>">                  
                              <table class="table table-hover dt-responsive" id="display_lists_tbl" name="display_lists">
                                 <thead>
                                    <tr>
                                       <th><input type="checkbox" id="select_all" class="form-control"/></th>
                                       <th><?php echo $tab_title; ?></th>
                                       <?php  if($cat_type =='job_specification'){ ?>
                                          <th><?php echo 'Specification Description'; ?></th>
                                          <th><?php echo 'Specification Duties'; ?></th>
                                       <?php } ?>
                                       <th>Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if(!empty($get_results)){ ?>
                                       <?php $er=0; foreach($get_results as $type_lists){
                                          $set_id = $type_lists->master_id; 
                                          if($cat_type =='pay_grade'|| $cat_type =='job_specification'){
                                             $set_id = $type_lists->id;
                                          }
                                         # echo'<pre>';print_r($type_lists);die; ?>        
                                         <tr id="td_<?php echo  $set_id; ?>">
                                          <input type="hidden" disabled name="master_id[]" id="hid_<?php echo $set_id; ?>" value="<?php echo $set_id; ?>" class="form-control"/>                   
                                          <td><input type="checkbox" name="checkbox[]" value="<?php echo $set_id; ?>" class="form-control check_box_list"/></td>
                                          <td>
                                             <?php  if($cat_type =='pay_grade'){?>
                                                <input type="text" disabled name="master_name[]" data-err="master_<?php echo $er; ?>" value="<?php if(isset($type_lists->grade_name) && $type_lists->grade_name!='') echo $type_lists->grade_name; ?>" class="form-control"/>
                                             <?php }else if($cat_type =='job_specification'){?>
                                                <input type="text" disabled name="master_name[]" data-err="master_<?php echo $er; ?>" value="<?php if(isset($type_lists->specification_name) && $type_lists->specification_name!='') echo $type_lists->specification_name; ?>" class="form-control"/>
                                             <?php } else { ?>
                                                <input type="text" disabled name="master_name[]" data-err="master_<?php echo $er; ?>" value="<?php if(isset($type_lists->master_name) && $type_lists->master_name!='') echo $type_lists->master_name; ?>" class="form-control"/>
                                             <?php } ?>

                                             <input type="hidden" disabled name="master_err_id[]"  value="<?php echo $er; ?>"/>
                                             <label style="display: block;" class="error tbl_err" id="master_<?php echo $er; ?>"></label>
                                          </td>
                                          <?php  if($cat_type =='job_specification'){ ?>
                                             <td>
                                                <textarea type="text" disabled name="description[]" data-err="description_<?php echo $er; ?>"  class="form-control"><?php if(isset($type_lists->specification_description) && $type_lists->specification_description!='')echo $type_lists->specification_description; ?></textarea>
                                                <label style="display: block;" class="error tbl_err" id="description_<?php echo $er; ?>"></label>
                                             </td>
                                             <td><textarea type="text" disabled name="duties[]" data-err="duties_<?php echo $er; ?>" class="form-control"><?php if(isset($type_lists->specification_duties) && $type_lists->specification_duties!='')echo $type_lists->specification_duties; ?></textarea>
                                                <label style="display: block;" class="error tbl_err" id="duties_<?php echo $er; ?>"></label>
                                             </td>
                                             
                                          <?php } ?> 
                                          <td>
                                             <select name="status[]" class="form-control" disabled>
                                                <option <?php if(isset($type_lists->status) && $type_lists->status!=''){ if($type_lists->status == 1)echo"selected";}  ?> value ="1">Active</option>
                                                <option <?php if(isset($type_lists->status) && $type_lists->status!=''){ if($type_lists->status == 0)echo"selected";}  ?> value ="0">Inactive</option>
                                             </select>
                                          </td>
                                       </tr>
                                       <?php  $er++; } ?>   
                                    <?php } ?>                                                        
                                 </tbody>
                              </table>

                              
                           </form>
                        </div>
                     </div>
                     <div class="row justify-content-end">
                        <div class="col-12 col-sm-4  col-md-4 ">
                           <div class="text-right">
                              <ul class="vitals-links saveLinkView display-hide">                                    
                                 <li><input type="submit" class="vital_yellow_btn save_btn" value="Update Master"></li>
                                 <li><a class="vital_bordered_btn">Reset</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php echo $pagination;?>      
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
</body>
<script type="text/javascript">

      $(document).on('change', '#form_type', function() { 
         var current_val= $(this).val();
         window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/master_settings/'?>' + current_val;
      }); 
      
   $(document).ready(function(){
      $('table').DataTable({
        "bPaginate": false,
        "showNEntries" : false
    });
      //$('.vital_windowScroll').css({'height': (($(window).height()) - 200) + 'px'});
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
         window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/master_settings/'.$cat_type.'?donor_val=' ?>'+btoa(donor_filter_msid);
      }
   }
   if(filter_val!='' && filter_val!= undefined){
      window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/master_settings/'.$cat_type.'?filter_val=' ?>'+btoa(filter_val)+common_filter_val;
   }
});
   
   $('.vital_bordered_btn').click(function() {
     window.location.reload();
  });

   $(".save_btn").click(function(e) {
    var master_val = $("#master_type").val();
    type ="alpha_special";
    manual_required('display_lists',type);
    check_ajax_master_data();
 });
   function check_ajax_master_data(){
      $.ajax({
         url: '<?php echo base_url().'index.php/master_pro/master/check_ajax_masterdata' ?>',
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
                     //$("#display_lists").submit();
                  }
               }
            }
         });
   }
   
   $(document).on('input', 'textarea', function () {
     if (this.value.match(/[^a-zA-Z0-9_.,'"!$:\-&\/() ]/g)) {
       this.value = this.value.replace(/[^a-zA-Z0-9_.,'"!$:\-&\/() ]/g, '');
    }
 });

</script>
<style>
   .master_deluser_mark {
      color: red !important;
   } 
</style>
</html> 