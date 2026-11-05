<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VITALS</title>
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
    <section class="newLogin">
        <div class="display-flex ">
            <div class="wdt-45">
                <div class="loginVitalSLider">
                    <div class="carousel slide vital_windowScroll position-relative" id="main-carousel" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#main-carousel" data-slide-to="1"></li>
                        </ol>

                        <div class="carousel-inner">
                            <div class="carousel-item bannerOneVitals vital_windowScroll active">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1>Idea To Market</h1>
                                    <p>Idea To Market is a curated Knowledge base to help Entrepreneurs and Portfolio Managers through every stage of the enterprise building process ...</p>
                                    <a href="https://www.villgro.org/ideatomarket/login/" target="_blank">Login into Idea To Market</a>
                                </div>
                            </div>
                            <div class="carousel-item bannerTwoVitals vital_windowScroll">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1>Incubator Playbook</h1>
                                    <p>Villgro's Incubation Playbook includes four modules which aim to assist incubators through the process of setting up an incubator for social ...</p>
                                    <a href="https://www.villgro.org/incubationplaybook/" target="_blank">Read the playbook</a>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="loginFooterBt">
                            <p>Copyright &copy; <?= date('Y'); ?> <a href="<?= site_url(); ?>">vitals.villgroapps.org</a>&nbsp;V2.0</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wdt-55 position-relative ">
                <div class="display-flex vital_windowScroll alignLoginItem">
                    <div class="loginNewForm">
                        <div class="villgro_logo">
                            <img src="<?php echo base_url() . 'source/portfolio_assets/img/logo1.png'; ?>">
                        </div>
                        <form id="loginForm" method="post" action="<?php echo site_url('login'); ?>" autocomplete="off">
                            <?php if ($errorMsg != '') { ?>
                                <div class="msg error text-center"><strong><i class="fas fa-times"></i></strong>&nbsp;<?= $errorMsg; ?></div>
                            <?php } ?>
                            <div class="from-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" id="loginEmail" Placeholder="Enter username" autofocus />
                            </div>
                            <div class="from-group">
                                <label>Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" name="password" id="loginPass" Placeholder="Enter password" />
                                    <span class="passwordIcon"><i class="far fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <ul class="vitals-links">
                                <li><input type="submit" class="vital_yellow_btn wdt_100" name="txtSubmit" value="Login" /></li>
                                <li><input type="reset" class="vital_bordered_btn wdt_100" value="Cancel" /></li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="loginFooterRt">
                    <ul class="vitals-links">
                        <li><a href="javascript:">Privacy Policy</a></li>
                        <li>|</li>
                        <li><a href="javascript:">Terms and Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="modal" id="kenyaModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content delete-alert">
                <div class="modal-body text-center">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-exclamation"></i>
                            </div>
                            <div class="col-10">
                                <!-- <h4>Are you sure you want to delete selected items?</h4> -->
                                <p>The Villgro Africa VITALS has moved to a new location. <br>Please use this link to login in - <a href="https://villgrokenya.villgro-us.org">villgrokenya.villgro-us.org</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                    <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                    <button type="button" class="btn btn-success" id="kenyaLink">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <?php $kenya_user = isset($kenya_user) && $kenya_user != '' ? $kenya_user : 0; ?>
    <input type="hidden" id="kenyaPartner" value="<?php echo $kenya_user; ?>">

    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/css/toastr.min.css'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': ($(window).height()) + 'px'});
            var kenya = $('#kenyaPartner').val();
            if(kenya == 1) {
                $('#kenyaModal').modal('show');
            }
        });

        $('#kenyaLink').on('click', function () {
            window.location.href = "https://villgrokenya.villgro-us.org";
        });

        $('#loginForm').validate({
            rules: {
                username: "required",
                password: "required"
            },
            messages: {
                username: "Enter username",
                password: "Enter password"
            }
        });

        $(document).on('click', '.passwordIcon', function (e) {
            var target = e.currentTarget;
            $(target).hasClass('show') ? hidePassword($(target)) : showPassword($(target));
        });

        function hidePassword(e) {
            e.removeClass('show').addClass('hide');
            $('#loginPass').attr('type', 'password');
            $('.passwordIcon i').removeClass('fa-eye');
            $('.passwordIcon i').addClass('fa-eye-slash');
        }

        function showPassword(e) {
            e.removeClass('hide').addClass('show');
            $('#loginPass').attr('type', 'text');
            $('.passwordIcon i').removeClass('fa-eye-slash');
            $('.passwordIcon i').addClass('fa-eye');
        }

    </script>

</body>
</html>