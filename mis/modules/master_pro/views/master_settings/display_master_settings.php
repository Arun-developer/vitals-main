<?php $cat_type =  $this->uri->segment(4);
$active_status = "";
?>
<style>
   .form-inline {
      display: block;
   }
   .table.dataTable {
      border-collapse: collapse;
   }
</style>
<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
   <div class="plan-structure-vital vital_windowScroll">

      <main class="page-content">
         <div class="row dataconfig d_v_d_c">
            <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
               <h4>Master Settings</h4>
            </div>
         </div>
         <form id="delete_form" action="<?php echo base_url() . 'index.php/master_pro/master/common_delete' ?>" method="POST">
            <input type="hidden" name="redirect_master_type" value="<?php echo $cat_type; ?>">
            <div class="delete_ids"></div>
         </form>
         <div class="plan-structure-vital">
            <div class="tab-slider--container tab-content">
               <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                  <main class="page-content">
                     <div class="inputplan plan-structure-new">
                     <form method="post" id="paygrade_form" action="<?php echo base_url().'index.php/master_pro/master/master_settings/pay_grade' ?>" method="POST">
                           <ul class="vitals-links">
                           <li>
                              <div class="form-group mar-bt8 wdt_180">
                                       <select name="form_type" id="form_type" class="form-control wdt_180">
                                          <option <?php if((isset($form_type) && $form_type == 'travel_mode') || $cat_type == 'travel_mode')echo "selected"; ?> value="travel_mode">Travel mode</option>
                                          <option <?php if((isset($form_type) && $form_type == 'pay_grade') || $cat_type == 'book_cat')echo "selected"; ?> value="book_cat">Book category</option>
                                          <option <?php if((isset($form_type) && $form_type == 'it_asset') || $cat_type == 'it_asset')echo "selected"; ?> value="it_asset">It assets</option>
                                          <option <?php if((isset($form_type) && $form_type == 'business_card_category') || $cat_type == 'business_card_category')echo "selected"; ?> value="business_card_category">Business card category</option>
                                          <option <?php if((isset($form_type) && $form_type == 'utilities_type') || $cat_type == 'utilities_type')echo "selected"; ?> value="utilities_type">Utilities type</option>
                                          <option <?php if((isset($form_type) && $form_type == 'pay_grade') || $cat_type == 'pay_grade')echo "selected"; ?> value="pay_grade">Pay Grade</option>
                                          <option <?php if((isset($form_type) && $form_type == 'job_specification') || $cat_type == 'job_specification')echo "selected"; ?> value="job_specification">Job specification</option>
                                       </select>
                                    </div>
                                    <label class="error hidden" id="sel_error">Select type</label>
                                 </li>
                                 <li class="pad-lt15px">
                                    <div class="form-group has-search-right mar-bt8 wdt_180">
                                       <a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
                                       <input type="text" id="filter_type" value="<?php if(isset($filter_type) && $filter_type!= '')echo $filter_type; ?>"  name="filter_type" class="form-control" value="<?php if ($filter_val != '') echo $filter_val; ?>" placeholder="Search">
                                    </div>
                                    <label class="error hidden" id="txt_error">Enter value</label>
                                 </li>
                              <li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
                           </ul>
                        </form>
                     </div>
                    
                     <div class="table_configcontentnew pad-bt0">
                        <div class="tabpanel-title">
                           <div class="row">
                              <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                 <h4>Pay Grade</h4>
                              </div>
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                 <ul class="milestone-links">
                                    <li class="brd-left-onboard">
                                       <a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="add_paygrade"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                    </li>
                                    <li class="brd-left-onboard">
                                       <a href="javascript:void(0)" data-chk-attr='contact_checkbox' class="edit-btnconfig none-pointer opacity5 mar-tp15 delete_cls" data-toggle="modal" data-target="" id="delete_paygrade"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                    </li>
                                    <li class="brd-left-onboard"><a   href="javascript:void(0)" class="saveContinue  none-pointer opacity5 mar-tp15" id="save_pay_grade_form" >Save</a></li>
                                 </ul>
                              </div>
                           </div>

                        </div>
                     </div>
                     <input type="hidden" id="hid_table_type">
                     <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                       <form method="post" id="insertMasterData" name="insertMasterData" action="<?php echo base_url().'index.php/master_pro/master/update_master_data' ?>" method="POST">
                           <table class="table" id="payGrade_table" style="margin-top: 0">
                              <input type="hidden" name="master_type" value="<?php echo $cat_type; ?>">   
                              <thead>
                                 <tr>
                                    <th width="5%" class="removeArrow"><input class="form-control common_checkbox" id="common_checkbox" type="checkbox"></th>
                                    <th width="20%">Payjhj Grade</th>
                                    <th width="20%">Status</th>
                                 </tr>
                              </thead>
                              <tbody></tbody>
                           </table>
                        </form>
                     </div>
                     
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
</body>
<script type="text/javascript">


      $(document).on('click', '#reset_search', function () {
         $("#filter_type").val('');
         var current_val= $("#form_type").val();
         window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/master_settings/'?>' + current_val;
      });
      $(document).on('change', '#form_type', function() { 
         var current_val= $(this).val();
         window.location.href = '<?php echo base_url() . 'index.php/master_pro/master/master_settings/'?>' + current_val;
      }); 
      $("#search_btn").click(function(){
         $("#paygrade_form").submit();
      });

      $(document).on('change', '.new_contact_checkbox', function() { 
         $("#save_pay_grade_form").removeClass("opacity5 none-pointer");
      });
     
      $("#add_paygrade").click(function(){
         var contact_tbl_len = $('#payGrade_table tr').length + 1;
         var markup = "<tr class='metric_more' id=contact_tbl_"+contact_tbl_len+"><td class='valign-center'><input class='form-control check_box_list new_contact_checkbox' type='checkbox'></td><td> <input type='hidden' name='master_err_id[]'  value="+contact_tbl_len+"><input type='text' placeholder='Enter pay grade' name='master_name[]' data-err='master_"+contact_tbl_len+"' class='form-control alphaonly'><label style='display: block;' class='error tbl_err' id='master_"+contact_tbl_len+"'></label></td><td><select name='status[]' class='form-control' ><option selected='' value='1'>Active</option><option value='0'>Inactive</option></select></td>";
         $("#payGrade_table tbody").prepend(markup);
         $('#contact_checkbox').prop('checked',false);
         $("#save_pay_grade_form").removeClass("opacity5 none-pointer");
      });

      $('#common_checkbox').click(function(e){
         var table= $(e.target).closest('table');
         $('td input:checkbox',table).prop('checked',this.checked);
      });
      $('.common_checkbox').click(function(e){
         var table= $(e.target).closest('table');
         var cur_tbl_id = $(e.target).closest('table').attr('id');
         $('td input:checkbox',table).prop('checked',this.checked);
         if(!this.checked){
               $("#"+cur_tbl_id+" tbody").find('input[type="checkbox"]').each(function(){
                  if(!$(this).is(":checked")){
                     $(this).parents("tr").find('input[type="text"],input[type="hidden"],select,textarea').prop("disabled",true);
                  }
            });
         }else{
            $("#"+cur_tbl_id+" tbody").find('input[type="checkbox"]').each(function(){
               if($(this).is(":checked")){
                  $(this).parents("tr").find('input[type="text"],input[type="hidden"],select,textarea').prop("disabled",false);
               }
            });
         }
      });
      $("#editSubmit").click(function(){
         toastr.success('Record Deleted Successfully','Success'); 
        // setTimeout(function() { window.location.reload(); }, 10000);
      });   

      $(document).on('click', '.check_box_list,#common_checkbox', function() { 
         if($('input:checkbox.check_box_list').length != $('input:checkbox.check_box_list:checked').length){
               $('#common_checkbox').prop('checked',false);
         }else{
               $('#common_checkbox').prop('checked',true);
         }
         if($('input:checkbox.check_box_list:checked').length > 0){
            $("#delete_paygrade").removeClass("opacity5 none-pointer");
            $("#save_pay_grade_form").removeClass("opacity5 none-pointer");
            $("#delete_paygrade").attr({ "data-target" : "#deleteModal"});
         }else{
            $("#delete_paygrade").addClass("opacity5 none-pointer");
            $("#save_pay_grade_form").addClass("opacity5 none-pointer");
            $("#delete_paygrade").attr({ "data-target" : ""});
         }

         if($('input:checkbox.new_contact_checkbox').length > 0){
                $("#save_pay_grade_form").removeClass("opacity5 none-pointer");
                $(".new_contact_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled",false);
         }

         if(!$(this).is(":checked")){
            $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled",true);
         }else{
            $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled",false);
         }
         $(".new_contact_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled",false);
         
      });


   
   $(document).ready(function() {


      $('#payGrade_table').DataTable({
         "bProcessing": true,
         "bSortable": true,
         "destroy": true,
         "bDestroy": true,
         "paging": true,
         "ordering": true,
         "info": false,
         "searching": false,
         "lengthChange": false,
         "bServerSide": true,
         "stateSave": false,
         "autoWidth": false,
         "pageLength": 10,
         "ajax": {
            "url": "<?php echo base_url(); ?>index.php/master_pro/master/ajax_load_datatable",
            "data": {"form_type": '<?php echo $form_type; ?>', "filter_type": "<?php echo $filter_type; ?>"},
            "type": "POST"
         },
         'columnDefs': [{
            'orderable': false,
            'targets': [0,]
         }],
         "order": [1, 'desc']
      });
      //$('.vital_windowScroll').css({'height': (($(window).height()) - 200) + 'px'});
      $("#display_lists").validate();
   });
   $('.vital_bordered_btn').click(function() {
      window.location.reload();
   });

   $("#save_pay_grade_form").click(function(e) {
      $(".tbl_err").text('');
      type = "alpha_special";
      manual_required('insertMasterData', type,'Enter Paygrade');
      check_ajax_master_data();
   });

   function check_ajax_master_data() {
      $.ajax({
         url: '<?php echo base_url() . 'index.php/master_pro/master/check_ajax_masterdata' ?>',
         cache: false,
         type: "POST",
         data: $("#insertMasterData").serialize(),
         dataType: "json",
         success: function(response) {
            if (response.status > 0) {
               for (const [key, value] of Object.entries(response.response)) {
                  $("#" + key).text(value);
               }
            }
            if (response.status == 0) {
                  $("#insertMasterData").submit();
            }
         }
      });
   }

   $(document).on('input', 'textarea', function() {
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