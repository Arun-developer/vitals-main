<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>    
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">    
</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header1.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="dataconfig-content page-wrapper  position-relative">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative"">
                        <div id=" leftMenuLoad">
                        <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'no_due_certificate')); ?>
                    </div>
                    <div class="footer-link">
                        <p>copyright &copy; mis.villgroapps.org</p>
                    </div>
                </div>
                <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                    <main class="page-content">
                        <div class="row dataconfig d_v_d_c">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                <h4>No Due Certificate</h4>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right pad-none">                                
                            </div>
                        </div>
                        <div class="plan-structure-vital vital_windowScroll">
                            <div class="row v_m_e_search">
                                <div class="col-xl-7 col-lg-7 col-md-12 col-12 ">
                                    <ul class="vitals-links">
                                        <li><label>Employee</label></li>
                                        <li>
                                            <div class="form-group mar-bt8 wdt_180">                                                
                                                <select class="form-control wdt_180">
                                                    <option>Search by</option>
                                                    <option>Employee</option>
                                                </select>
                                            </div>
                                        </li>
                                        <li class="pad-lt15px">
                                            <div class="form-group ">
                                                <a href="#" class="vital_yellow_btn pad-hr15">Generate</a>
                                            </div>
                                        </li>                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-12 col-md-12 ">
                                   <div class="nocertificate">
                                        <div class="text-center">
                                            <h4 class="vitals_innerSub brd_btm">NO DUE CERTIFICATE</h4>
                                            <h4 class="vitals_innerSub ">Accounts In charge</h4>
                                            <p>This is to state that there are no dues pending for settlement under the name of Abhijit Sathe (IITK).</p>
                                        </div>
                                        <div class="row approvalLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="display-flex">
                                                    <label>Date :</label>
                                                    <p>19/07/2020</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 text-right">
                                                <div class="display-flex">
                                                    <label>Signature </label>
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row approvalLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="display-flex">
                                                    <label>Place :</label>
                                                    <p></p>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <hr>
                                        <div style="height: 30px;"></div>
                                        <div class="text-center">
                                            <h4 class="vitals_innerSub ">Administration</h4>
                                            <p>This is to state that there are no dues pending for settlement under the name of  Abhijit Sathe (IITK).</p>
                                        </div>
                                        <div style="height:20px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <!-- <h4>Contact Details</h4> -->
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <!-- <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig donorTableEditbtn mar-tp15"><i class="fas fa-pencil-alt"></i>&nbsp;Edit</a>
                                                            </li> -->
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig  mar-tp15"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue ">Save</a></li>                                                              
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th>
                                                        <th width="25%">Description</th>
                                                        <th width="20%">Details<br>(brand name, user id, password etc)</th>
                                                        <th width="18%">Whether returned/ obtained</th>
                                                        <th width="25%">Remarks<br>(including any damage caused to assets, if any)</th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="metric_more">
                                                        <td class="valign-center"><input class="form-control donorTableEdit" type="checkbox"></td>
                                                        <td><textarea class="form-control" rows="2" disabled>Library Books</textarea></td>
                                                        <td><textarea class="form-control" rows="2" disabled>NA</textarea></td>
                                                        <td><textarea class="form-control" rows="2" disabled></textarea></td>
                                                        <td><textarea class="form-control" rows="2" disabled></textarea></td>                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="height: 30px;"></div>
                                        <div class="row approvalLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="display-flex">
                                                    <label>Date :</label>
                                                    <p>19/07/2020</p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4 text-right">
                                                <div class="display-flex ">
                                                    <label>Signature </label>
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row approvalLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="display-flex">
                                                    <label>Place :</label>
                                                    <p></p>
                                                </div>
                                            </div>                                            
                                        </div>
                                   </div>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 200) + 'px'
        });
    });
</script>

</html>