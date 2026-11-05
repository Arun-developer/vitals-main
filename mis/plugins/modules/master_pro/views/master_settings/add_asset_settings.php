
<?php $back_link = "";
   $cat_type =  $this->uri->segment(4);
   if($cat_type != ''){
       $back_link = "index.php/master_pro/master/disaplay_asset/".$cat_type;
   } 
   ?>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
   <main class="page-content">
      <div class="row dataconfig d_v_d_c">
         <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
            <span><a href="<?php echo base_url().$back_link; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
            <h4>Add Master</h4>
         </div>
      </div>
      <div class="plan-structure-vital vital_windowScroll">
         <main class="page-content">
            <div class="inputplan-structureall plan-structure-new">
               <div class="row">
                  <div class="col-12 col-sm-4 col-md-6 col-lg-4 col-xl-4">
                     <form action="<?php echo base_url().'index.php/master_pro/master/insert_edit_asset_settings' ?>" method="POST" id="master_setting">
                        <input type="hidden" name="tab_title" id="tab_title" value="<?php echo $tab_title; ?>" />
                        <input type="hidden" name="main_tab" id="main_tab" value="<?php echo $cat_type; ?>" />    
                        <div class="form-group">
                           <label>Master Type <span>*</span></label>
                           <select id="master_type" name="master_type" class="form-control required">
                              <option value="">Select</option>
                              <?php 
                                 if(!empty($menuMaster)){
                                     foreach($menuMaster as $key => $value){        
                                 ?>
                              <option <?php if($cat_type == $key)echo "selected"; ?> value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
                              <?php }} ?>
                           </select>
                        </div>
                            
                        <div class="form-group" id="donor_data" style="display:none">
                           <?php if(!empty($donorList)){?>
                              <label>Donor <span>*</span></label>
                              <select name="donor_master_id" id="donor_master_id" class="form-control required">
                                 <option value ="">-- Please select the donor type --</option>  
                                 <?php foreach($donorList as $lists){ ?>
                                    <option value ="<?php echo $lists['master_id']; ?>"><?php echo $lists['master_name']; ?></option>  
                                 <?php } ?>
                              </select>
                           <?php } ?>
                        </div>
                        <div class="form-group" id="budget_msid" style="display:none">
                           <label><?php echo 'Budget Head'; ?></label>
                              <div class="has-search-right mar-bt8 wdt_150">
                                 <select  name="budget_filter_msid" id="budget_filter_msid" class="form-control required">
                                    <option value="">Please select the budget type</option>
                                 </select>
                              </div>
                        </div>  

                        <div class="form-group">
                           <label><?php  echo $tab_title; ?> <span> *</span></label>
                           <input type="text" name="master_name" id="master_name" class="form-control required" placeholder="Please enter the travel mode" />
                            <div id="error_msg" ></div>
                        </div>
                        <div>
                           <ul class="vitals-links">
                              <li><input type="submit" class="button vital_yellow_btn save_btn" value="Add Master"></li>
                              <li><a href="<?php echo base_url().$back_link; ?>" class="vital_bordered_btn">Cancel</a></li>
                           </ul>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </main>
      </div>
   </main>
</div>
<script>

   $(function() { 
   	   $("#master_setting").validate();
   });

   $(document).ready(function(){
        var cat_type = $("#main_tab").val();
         if(cat_type =='line_item' && cat_type!= undefined){
            var donor_master_id = $("#donor_master_id").val();
            if(donor_master_id !='' && donor_master_id != undefined){
                  $("#budget_msid").css("display", "block");
                  ajax_call(donor_master_id);
            }    
            $('#donor_master_id').on('change', function() {
                  var donor_id = this.value;
                  $("#budget_msid").css("display", "block");
                  ajax_call(donor_id);
            });
         }
    });
    function ajax_call(donor_id){
        $.ajax({
            url: '<?php echo base_url().'index.php/master_pro/master/get_budget_ajax_data' ?>',
            cache: false,
            type: "POST",
            data: {donor_id : donor_id},
            dataType: "json",
            success: function(response){ //console.log('response' + response);
               $("#budget_filter_msid").html('');
               if(response.status == 1){
                     $("#budget_filter_msid").html(response.response);
               }else if(response.status == 0){
                     $("#budget_filter_msid").html('<option value="">Please select the budget type</option>');    
               }
            }
         });
    }

   $(document).ready(function(){
      if($("#master_type").val() == 'budget_head'){
            $("#donor_data").css("display", "block");
      }else if($("#master_type").val() == 'line_item'){
         $("#donor_data").css("display", "block");
         $("#budget_msid").css("display", "block");
      }
      $('#master_type').on('change', function() {
         window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_add_asset_form/' ?>'+this.value;
         $("#donor_data").css("display", "none");
         if(this.value == 'budget_head'){
               $("#donor_data").css("display", "block");
            }
         });
   });   
   

    $('.save_btn').click(function (e) {
        if($('#master_setting').valid() == true){
            e.preventDefault(); 
            var tab_title = $("#tab_title").val();
            var master_type = $("#master_type").val();
            var master_name = $("#master_name").val();
            var donor_ms_id = $("#donor_master_id").val();
            
            var donor_master_id = '';
            if(donor_ms_id !='' && donor_ms_id!= undefined){
                  donor_master_id = $("#donor_master_id").val();
            }
            $.ajax({
               url: '<?php echo base_url().'index.php/master_pro/master/check_ajax_asset_data' ?>',
               cache: false,
               type: "POST",
               data:$("#master_setting").serialize(),
               dataType: "json",
               success: function(response){
                        $("#error_msg").html("");
                  if(response.status =='1'){
                        $("#error_msg").html("<label class='error'>"+response.err_msg+"</label>");
                  }else if(response.status =='0'){
                        $("#master_setting").submit();
                  }
               }
            });
         }   
    });

</script>