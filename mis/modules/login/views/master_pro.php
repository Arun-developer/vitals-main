                        <div class="plan-structure-vital">
                                <div>
                                    <div class="newCLickTabs">
                                        <div>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/travel_mode'; ?>" role="tab" data-toggle="tab">Travel Mode</a></li>
                                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/travel_mode'; ?>" role="tab" data-toggle="tab">Books Category</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">General Asset</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">IT Asset</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Business Card Category</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Utilities Type</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Donor</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Budget Head</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Line Item</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Additional Info</a></li>
                                                <li role="presentation" ><a href="<?php echo base_url() . 'index.php/user/user_ui/travel_mode'; ?>" role="tab" data-toggle="tab">Balance Sheet</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Financial Year</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Programme</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Set Admin Email</a></li>
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
                                                                <div class="form-group has-search-right mar-bt8 wdt_180">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                            </li>
                                                            <li><span class="vitals_clearSearch">Clear search</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th>Travel Mode</th>
                                                                    <th>Status</th>                                                                   
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>                                                                    
                                                                    <td>Train</i></td>
                                                                    <td><span class="clr_geen"><i class="fas fa-check"></i></span></td>
                                                                    <td><a href="" class="clr_geen"><i class="fas fa-edit"></i></a> <a class="clr_red pad-lt15px" href=""><i class="fas fa-trash"></i></a>  </td>
                                                                </tr> 
                                                                <tr>                                                                    
                                                                    <td>Flight</i></td>
                                                                    <td><span class="clr_geen"><i class="fas fa-check"></i></span></td>
                                                                    <td><a href="" class="clr_geen"><i class="fas fa-edit"></i></a> <a class="clr_red pad-lt15px" href=""><i class="fas fa-trash"></i></a>  </td>
                                                                </tr> 
                                                                <tr>                                                                    
                                                                    <td>Bus</i></td>
                                                                    <td><span class="clr_geen"><i class="fas fa-check"></i></span></td>
                                                                    <td><a href="" class="clr_geen"><i class="fas fa-edit"></i></a> <a class="clr_red pad-lt15px" href=""><i class="fas fa-trash"></i></a>  </td>
                                                                </tr>                                                         
                                                            </tbody>
                                                        </table>
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
            </div>
        </div>
    </div>
</body>
    <?php
    $url_server = explode('/', site_url(''), 2);
    $ais_url = $url_server['0'] . "//" . $this->config->item('ais_url');
    $this->config->item('ais_url');
    $hris_url = $url_server['0'] . "//" . $this->config->item('hris_url');
    $approvalUrl = $ais_url . 'login/index/';
    $travelUrl = $ais_url . 'traveladmin/requestlist';
    $timeSheet = $hris_url;
    $sessionhris_url = $url_server['0'] . "//" . $_SERVER['HTTP_HOST'] . "/ctl_vill/index.php/";

    $url_server = explode('/', site_url(''), 4);
    $dmsUser = site_url('dms/document_system/index/');
    $url = "";
    ?>
    <form name="frmApprovalSession" id="sessionMasterFRM" method="post" action="<?php echo $approvalUrl; ?>">
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('password'); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="masters" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />
        <input type="hidden" value="<?php echo $sessionhris_url; ?>" name="seesion[hris_url]" />

    </form>
    <form name="frmTravelSession" id="sessionHRIS" method="post" action="<?php echo $timeSheet; ?>">

        <input type="hidden" value="<?php echo $this->session->userdata("user_name"); ?>" name="seesion[user_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata("password"); ?>" name="seesion[password]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_name'); ?>" name="seesion[username]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" name="seesion[userid]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_number'); ?>" name="seesion[emp_number]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('emp_name'); ?>" name="seesion[emp_name]"/>
        <input type="hidden" value="<?php echo $this->session->userdata('user_type'); ?>" name="seesion[user_type]"/>
        <input type="hidden" value="ess" name="seesion[requests]"/>
        <input type="hidden" value="<?php echo site_url() . "/"; ?>" name="seesion[mis_url]" />
        <input type="hidden" value="<?php echo $ais_url; ?>" name="seesion[ais_url]" />

    </form>
    <script type="text/javascript">
        /* $('#submitMasters').click(function () {
            $('#sessionMasterFRM').submit();
        });
        $('#dmsID').click(function () {
            $('#sessionHRIS').submit();
        }); */
    </script>
	
</html>
