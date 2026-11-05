<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>
    <!-- <link rel="stylesheet" href="http://192.168.1.200:8095/vital/source/portfolio_assets/css/new-portfolio.css"> -->
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <script src="<?php echo base_url() . 'source/portfolio_assets/css/toastr.min.css'; ?>"></script>
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
                        </ol><!-- /.carousel-indicators -->

                        <div class="carousel-inner">
                            <div class="carousel-item bannerOneVitals vital_windowScroll active">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1>Idea To Market</h1>
                                    <p>Idea To Market is a curated Knowledge base to help Entrepreneurs and Portfolio Managers through every stage of the enterprise building process ...</p>
                                    <a href="">Login into Idea To Market</a>
                                </div>
                            </div>
                            <div class="carousel-item bannerTwoVitals vital_windowScroll">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1>Incubator Playbook</h1>
                                    <p>Villgro's Incubation Playbook includes four modules which aim to assist incubators through the process of setting up an incubator for social ...</p>
                                    <a href="">Read the book</a>
                                </div>
                            </div>
                            <br>
                        </div><!-- /.carousel-inner -->
                        <div class="loginFooterBt">
                            <p>copyright &copy; 2020 mis.villgroapps.org</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wdt-55 position-relative ">
                <div class="display-flex vital_windowScroll alignLoginItem">
                    <div class="loginNewForm">
                        <div class="villgro_logo">
                            <img  src="<?php echo base_url() . 'source/portfolio_assets/img/logo1.png'; ?>">
                        </div>
                        <form>
                            <h2>Change Password</h2>
                            <div class="from-group">
                                <label>Old Password</label>
                                <div class="position-relative">
                                    <input class="form-control" type="password" value="claritaz">
                                    <span class="passwordIcon"><i class="far fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="from-group">
                                <label>New Password</label>
                                <div class="position-relative">
                                    <input class="form-control" type="password" value="claritaz">
                                    <span class="passwordIcon"><i class="far fa-eye-slash"></i></span>
                                </div>
                            </div>                            
                            <ul class="vitals-links">
                                <li><a href="<?php echo base_url() . 'index.php/user/user_ui/login'; ?>" class="vital_yellow_btn wdt_100">Submit</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/user/user_ui/login'; ?>" class="vital_bordered_btn wdt_100">Cancel</a></li>
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
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': ($(window).height()) + 'px'
        });        
    });
</script>

</html>