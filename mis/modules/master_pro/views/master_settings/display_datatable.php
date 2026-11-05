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
      <div class="plan-structure-vital">
         <div>
            <div class="newCLickTabs">
               <div>
                  <ul class="nav nav-tabs" role="tablist">
                     <li role="presentation"  role="tab">Travel Mode</a></li>
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
                           </ul>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                           <form  class="display_lists"  name="display_lists" action="<?php echo base_url().'index.php/master_pro/master/update_master_data' ?>" method="POST">
                              <input type="hidden" name="master_type">                  
                              <table class="table table-hover dt-responsive" id="datatable_tbl" name="display_lists">
                                 <thead>
                                    <tr>
                                       <th><input type="checkbox"  class="form-control"/></th>
                                       <th>name</th>
                                       <th>Status</th>
                                       <th>no</th>
                                       <th>data</th>
                                    </tr>
                                 </thead>
                                 <tbody>    
                                       <tr>
                                          <td><input type="checkbox"  class="form-control"/></td>
                                          <td>Arunkumar</td>
                                          <td>active</td>
                                          <td>1</td>
                                          <td>8</td>
                                       </tr>   
                                       <tr>
                                          <td><input type="checkbox"  class="form-control"/></td>
                                          <td>kumar</td>
                                          <td>Inactive</td>
                                          <td>123</td>
                                          <td>987879</td>
                                       </tr>
                                       <tr>
                                          <td><input type="checkbox"  class="form-control"/></td>
                                          <td>kumar</td>
                                          <td>Inactive</td>
                                          <td>0</td>
                                          <td>5</td>
                                       </tr>                                                        
                                 </tbody>
                              </table>
                           </form>
                        </div>
                     </div>
                  </div>
                  
               </main>
            </div>
         </div>
      </div>

      
   </main>




</div>
</div>
</body>

<script>
   $(document).ready(function() {
        $('#datatable_tbl').dataTable({
            "bPaginate": false,
            "showNEntries" : false,
            "aoColumnDefs": [{"bSortable": false, "aTargets": [0]}],
            "order": [[0, 'asc']]
        });
    }); 
</script>
</html> 