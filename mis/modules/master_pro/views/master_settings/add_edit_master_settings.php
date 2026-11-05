<?php $back_link = "";
   $cat_type =  $this->uri->segment(4);
   if($cat_type != ''){
       $back_link = "index.php/master_pro/master/master_settings/".$cat_type;
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
                     <form action="<?php echo base_url().'index.php/master_pro/master/insert_edit_master_settings' ?>" method="POST" id="master_setting">
                        <input type="hidden" name="tab_title" id="tab_title" value="<?php echo $tab_title; ?>" />
                        <input type="hidden" name="main_tab" value="<?php echo $cat_type; ?>" />    
                        <div class="form-group">
                           <label>Type <span>*</span></label>
                           <select id="master_type" name="master_type" class="form-control required">
                              <?php 
                                 if(!empty($menuMaster)){
                                     foreach($menuMaster as $key => $value){  
                                       if($cat_type == 'business_card_catsset'){
                                        $cat_type= 'business_card';
                                       }       
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

                        <div class="form-group">
                           <label><?php  echo $tab_title; ?> <span> *</span></label>
                           <input type="text" name="master_name" id="master_name" data-err="master" class="form-control required alpha_spec" placeholder="" />
                           <div id="error_master"></div>
                        </div>
                        <?php if(isset($cat_type) && $cat_type == 'job_specification'){?>
                           <div class="form-group">
                              <label>Specification Description<span> *</span></label>
                              <textarea  name="description" id="description" data-err="description" class="form-control alpha_spec" /> </textarea>
                              <div id="error_description"></div>
                           </div>
                           <div class="form-group">
                              <label>Specification Duties <span> *</span></label>
                              <textarea name="duties" id="duties" data-err="duties"  class="form-control alpha_spec" /> </textarea>
                              <div id="error_duties"></div>
                           </div>
                        <?php } ?>            
                        <div>
                           <ul class="vitals-links">
                              <li><input type="submit" class="button vital_yellow_btn save_btn" value="Add Record"></li>
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
      if($("#master_type").val() == 'budget_head'){
            $("#donor_data").css("display", "block");
      }
      $('#master_type').on('change', function() {
         var change_form = this.value;
         if(change_form == 'business_card' && this.value!= undefined){
            change_form = 'business_card_catsset';
         }else if( change_form == 'utilities_type' && this.value!= undefined){
            change_form = 'utilities';
         }
         window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/disaplay_add_edit_form/' ?>'+change_form;
         $("#donor_data").css("display", "none");
         if(this.value == 'budget_head'){
               $("#donor_data").css("display", "block");
            }
         });
   });   
   

    $('.save_btn').click(function (e) {
         e.preventDefault(); 
        var tab_title = $("#tab_title").val();
        var master_type = $("#master_type").val();
        var master_name = $("#master_name").val();
        var donor_ms_id = $("#donor_master_id").val();
        
        var donor_master_id = '';
        if(donor_ms_id !='' && donor_ms_id!= undefined){
            donor_master_id = $("#donor_master_id").val();
        }
        var i = 0; er_count = 0;
        $("#error_master").html('');$("#error_duties").html('');$("#error_description").html('');
        $(".alpha_spec").each(function() {
            if(this.value!='' && this.value!=undefined){
               var label_err = $(this).attr('data-err');
               var values =  this.value;
               var value_without_space = values.replace(/\s/g, "");
               if(value_without_space !=''){
                  var regex = new RegExp("^[a-zA-Z,•()&.-:\-/–+’ ]+$");
                  if (!regex.test(value_without_space)){ console.log("#error_"+label_err);
                     $("#error_"+label_err).html('<label  class="error tbl_err">The field is required values</label>');
                     er_count = i+1;
                  }
               }
            } i++;
         });
        $.ajax({
                url: '<?php echo base_url().'index.php/master_pro/master/check_ajax_data' ?>',
                cache: false,
                type: "POST",
                data: {master_type : master_type,master_name : master_name,tab_title : tab_title,donor_master_id : donor_master_id},
                dataType: "json",
                success: function(response){
                        $("#error_msg").html("");
                    if(response.status =='1'){
                        $("#error_msg").html("<label class='error'>"+response.err_msg+"</label>");
                    }else if(response.status =='0'){
                        if(er_count == 0){
                           $("#master_setting").submit();
                        }
                    }
                }
            }); 
            return false;
    });

</script>