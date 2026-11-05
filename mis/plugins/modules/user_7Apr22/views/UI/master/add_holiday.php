<?php
?>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo base_url() . 'source/portfolio_assets/css/toastr.min.css'; ?>"></script>
</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="Vital-Newmenu">
                <div class="row">
                    <div class="col">
                        <ul>
                            <li><a href=""><i class="fas fa-home"></i> Home</a></li>
                            <li><a href=""><i class="fas fa-tag"></i> Deals</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'holiday')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <h4>Holiday Details</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li><a href="" class="edt_btnVital"><i class="fas fa-eye"></i> View Calendar</a></li>
                                        <li class="activeTabs"><a href="" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                        <li><a href="" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div>
                                    <div class="tab-slider--navform">
                                        <ul class="tab-slider--tabsform">
                                            <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>">Holiday Calendar-Current</a></li>
                                            <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/user/user_ui/archive_holiday_calendar'; ?>">Holiday Calendar-Archive</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="vitals_innerSub">Add Holiday</h4>
                                                    </div>
                                                </div>
                                                <form name="signup" class="form" novalidate>
                                                    <div class="row">
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Name of Holiday <span>*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter the Holiday Name" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date <span>*</span></label>
                                                                <input type="text" class="form-control" placeholder="Select the Date" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Repeats Annually </label>
                                                                <select class="form-control">
                                                                    <option>Yes</option>
                                                                    <option>No</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Full Day/ Half Day </label>
                                                                <select class="form-control">
                                                                    <option>Full Day</option>
                                                                    <option>Half Day</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="name" class="form-label form-label--required">
                                                                    Name:
                                                                </label>

                                                                <div class="form-addon" data-states-for="name">
                                                                    <div class="form-addon__addon">
                                                                        <span class="icon-name"></span>
                                                                    </div>

                                                                    <input type="text" id="name" name="name" class="form-input" placeholder="Andrew" required>

                                                                    <span class="form-addon__icon icon-valid"></span>
                                                                    <span class="form-addon__icon icon-invalid"></span>
                                                                </div>

                                                                <div data-errors-for="name">
                                                                    <small class="form-error" data-errors-when="valueMissing">
                                                                        This field is required.
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <ul class="vitals-links">
                                                                    <li><button id="showtoast" type="submit" class="vital_yellow_btn">Save Holiday</button></li>
                                                                    <li><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>" class="vital_bordered_btn">Cancel</a></li>
                                                                </ul>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/toastr.js'; ?>"></script>
<script>
    $('table').DataTable();


    // Window Height
    // ---------------------------------------
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 230) + 'px'
        });
    });

    // This is a demo of GentleForm:
    // https://github.com/Zhouzi/GentleForm

    const toaster = document.getElementsByClassName('toaster')[0];
    const form = document.querySelector('form');

    GentleForm(form, function(event) {
        event.preventDefault();

        if (this.isValid()) addToast('success', 'Yay, the form is valid!');
        else
            addToast('error', 'Oops, the form is invalid.');
    });

    function addToast(type, message) {
        const toast = document.createElement('div');

        toast.classList.add('toast');
        toast.classList.add('toast--' + type);
        toast.innerHTML = message;

        toaster.appendChild(toast);

        toast.addEventListener('transitionend', function(event) {
            if (event.propertyName !== 'transform') return;

            if (toast.classList.contains('toast--show')) {
                setTimeout(function() {
                    toast.classList.remove('toast--show');
                }, 3000);
            } else {
                toaster.removeChild(toast);
            }
        }, false);

        setTimeout(() => toast.classList.add('toast--show'), 100);
    }



    $(function() {
        var i = -1;
        var toastCount = 0;
        var $toastlast;

        var getMessage = function() {
            var msgs = ['My name is Inigo Montoya. You killed my father. Prepare to die!'];
            i++;
            if (i === msgs.length) {
                i = 0;
            }

            return msgs[i];
        };

        var getMessageWithClearButton = function(msg) {
            msg = msg ? msg : 'Clear itself?';
            msg += '<br /><br /><button type="button" class="btn clear">Yes</button>';
            return msg;
        };



        $('#showtoast').click(function() {
            var shortCutFunction = $("#toastTypeGroup input:radio:checked").val();
            var msg = $('#message').val();
            var title = $('#title').val() || '';
            var $showDuration = $('#showDuration');
            var $hideDuration = $('#hideDuration');
            var $timeOut = $('#timeOut');
            var $extendedTimeOut = $('#extendedTimeOut');
            var $showEasing = $('#showEasing');
            var $hideEasing = $('#hideEasing');
            var $showMethod = $('#showMethod');
            var $hideMethod = $('#hideMethod');
            var toastIndex = toastCount++;
            var addClear = $('#addClear').prop('checked');

            toastr.options = {
                closeButton: $('#closeButton').prop('checked'),
                debug: $('#debugInfo').prop('checked'),
                newestOnTop: $('#newestOnTop').prop('checked'),
                progressBar: $('#progressBar').prop('checked'),
                rtl: $('#rtl').prop('checked'),
                positionClass: $('#positionGroup input:radio:checked').val() || 'toast-top-right',
                preventDuplicates: $('#preventDuplicates').prop('checked'),
                onclick: null
            };

            if ($('#addBehaviorOnToastClick').prop('checked')) {
                toastr.options.onclick = function() {
                    alert('You can perform some custom action after a toast goes away');
                };
            }

            if ($('#addBehaviorOnToastCloseClick').prop('checked')) {
                toastr.options.onCloseClick = function() {
                    alert('You can perform some custom action when the close button is clicked');
                };
            }

            if ($showDuration.val().length) {
                toastr.options.showDuration = parseInt($showDuration.val());
            }

            if ($hideDuration.val().length) {
                toastr.options.hideDuration = parseInt($hideDuration.val());
            }

            if ($timeOut.val().length) {
                toastr.options.timeOut = addClear ? 0 : parseInt($timeOut.val());
            }

            if ($extendedTimeOut.val().length) {
                toastr.options.extendedTimeOut = addClear ? 0 : parseInt($extendedTimeOut.val());
            }

            if ($showEasing.val().length) {
                toastr.options.showEasing = $showEasing.val();
            }

            if ($hideEasing.val().length) {
                toastr.options.hideEasing = $hideEasing.val();
            }

            if ($showMethod.val().length) {
                toastr.options.showMethod = $showMethod.val();
            }

            if ($hideMethod.val().length) {
                toastr.options.hideMethod = $hideMethod.val();
            }

            if (addClear) {
                msg = getMessageWithClearButton(msg);
                toastr.options.tapToDismiss = false;
            }
            if (!msg) {
                msg = getMessage();
            }

            $('#toastrOptions').text('Command: toastr["' +
                shortCutFunction +
                '"]("' +
                msg +
                (title ? '", "' + title : '') +
                '")\n\ntoastr.options = ' +
                JSON.stringify(toastr.options, null, 2)
            );

            var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
            $toastlast = $toast;

            if (typeof $toast === 'undefined') {
                return;
            }

            if ($toast.find('#okBtn').length) {
                $toast.delegate('#okBtn', 'click', function() {
                    alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
                    $toast.remove();
                });
            }
            if ($toast.find('#surpriseBtn').length) {
                $toast.delegate('#surpriseBtn', 'click', function() {
                    alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
                });
            }
            if ($toast.find('.clear').length) {
                $toast.delegate('.clear', 'click', function() {
                    toastr.clear($toast, {
                        force: true
                    });
                });
            }
        });


    })
</script>

</script>

</html>