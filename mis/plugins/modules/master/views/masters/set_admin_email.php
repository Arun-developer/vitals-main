<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>
    <!-- <link rel="stylesheet" href="http://192.168.1.200:8095/vital/source/portfolio_assets/css/new-portfolio.css"> -->

</head>

<body>
    <?php
    $this->load->view('masters/header.php', array('page' => 'master'));
    ?>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
           <?php
           $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
           $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
           if ($successMsg != '') {
            ?>
            <div class="position-absolute d-flex flex-column p-4 toastPlace">
                <div id="toast-container" aria-live="polite" aria-atomic="true">
                    <div id="toast-wrapper">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                            <div class="toast-header bg-success text-white">
                                <strong class="mr-auto"><?= $successMsg; ?></strong>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true" class="text-white">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            if ($errorMsg != '') {
                ?>
                <div class="position-absolute d-flex flex-column p-4 toastPlace">
                    <div id="toast-container" aria-live="polite" aria-atomic="true">
                        <div id="toast-wrapper">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-danger text-white">
                                    <strong class="mr-auto"><?= $errorMsg; ?></strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('masters/master_sidemenu', array('page' => 'master_setting')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <h4>Set Admin Email Address</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div class="newCLickTabs">
                                    <div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" <?php if($master_type == 'Travel Mode'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/travel_mode'; ?>" >Travel Mode</a></li>
                                            <li role="presentation" <?php if($master_type == 'Books Category'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/books_category'; ?>" >Books Category</a></li>
                                            <li role="presentation" <?php if($master_type == 'General Asset'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/general_asset'; ?>">General Asset</a></li>
                                            <li role="presentation" <?php if($master_type == 'IT Asset'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/it_asset'; ?>" >IT Asset</a></li>
                                            <li role="presentation" <?php if($master_type == 'Business Card Category'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/business_card'; ?>" >Business Card Category</a></li>
                                            <li role="presentation" <?php if($master_type == 'Utilities Type'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/utilities_type'; ?>" >Utilities Type</a></li>
                                            <li role="presentation"  <?php if($master_type == 'Donor'){ ?>class="active"<?php }?>><a href="<?php echo base_url() . 'index.php/master/donor'; ?>"  >Donor</a></li>
                                            <li role="presentation" <?php if($master_type == 'Budget Head'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/budget_head'; ?>" >Budget Head</a></li>
                                            <li role="presentation" <?php if($master_type == 'Line Item'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/line_item'; ?>" >Line Item</a></li>
                                            <li role="presentation" <?php if($master_type == 'Additional Info'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/additional_info'; ?>" >Additional Info</a></li>
                                            <li role="presentation" <?php if($master_type == 'Balance Sheet'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/balance_sheet'; ?>" >Balance Sheet</a></li>
                                            <li role="presentation" <?php if($master_type == 'Financial Year'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/financial_year'; ?>" >Financial Year</a></li>
                                            <li role="presentation" <?php if($master_type == 'Programme'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/programme'; ?>" >Programme</a></li>
                                            <li role="presentation" <?php if($master_type == 'Set Admin Email'){ ?>class="active"<?php } ?>><a href="<?php echo base_url() . 'index.php/master/set_admin_email'; ?>" >Set Admin Email</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <main class="page-content">  
                                    <div class="inputplan-structureall plan-structure-new brd-none">                       
                                        <form id="programme_form" method="post" action="<?php echo base_url() . 'index.php/master/addAdminemail'; ?>" autocomplete="off">                                
                                            <div class="row">
                                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label>Admin email ID <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control programmeInput" disabled name="adminmail" id="adminmail" maxlength="50" placeholder="Programme name"  value="<?php echo isset($adminemail) && $adminemail[0]['email2'] != '' ? $adminemail[0]['email2'] : ''; ?>"/>                                            
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-sm-4  col-md-4 ">
                                                    <div class="text-left">
                                                        <ul class="vitals-links saveLinkView display-hide">
                                                            <li><input type="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                                            <li><a href="<?php echo base_url() . 'index.php/master/set_admin_email'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($editid) ? $editid : '' ?>" />
                                        </form>
                                    </div>
                                </main>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>
    $('#programme_form').validate({
        rules: {
            adminmail: {
                required : true,
                email : true
            },

        },
        messages: {
            adminmail: "Enter admin email id",
        }
    });

    $(document).ready(function () {
                     $('.nav-tabs').scrollingTabs({
                enableSwiping: true
            }).on('ready.scrtabs', function() {
                $('.tab-content').show();
            });
            $('#navLoad').removeClass('display-hide');
        $('.vital_windowScroll').css({'height': (($(window).height()) - 180) + 'px'});
        $('.toast').toast('show');
        setTimeout(function() {
            $('.success').addClass('display-hide');
        }, 3000);

                    $('#donor_types').multiselect({
                buttonWidth: '100%',
                includeSelectAllOption: true,
                nonSelectedText: 'Select an Option'
              });
    });


    $('.summaryEdit').click(function(){
        $(".programmeInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>
</body>

</html>