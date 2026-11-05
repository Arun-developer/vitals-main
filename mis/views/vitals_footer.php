<?php // $multi_select = $page_name = $text_editor = $quantitative = $bootstrap_DT = $load_currency = $load_application = $module = $chart = '';                                         ?>

<div class="modal" id="deleteModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="editSubmit"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="welcomeModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body onboarding-permission text-center">
                <div class="text-right">
                    <a class="portfolioclose" data-dismiss="modal">Close</a>
                </div>
                <div class="popup-content">
                    <p>Do you want to download attached documents as well?</p>
                    <button type="button" class="btn btn-secondary" onclick="attachedfileNo();" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-secondary" onclick="attachedfileYes();" data-dismiss="modal">Yes</button>
                    <input type="hidden" value="" id="download_id">
                    <input type="hidden" value="" id="program_id">
                    <input type="hidden" value="" id="doc1_id">
                    <input type="hidden" value="" id="doc2_id">
                    <input type="hidden" value="" id="doc3_id">
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($page_load == 'portfolio' && $copyrights != '0') { ?>
    <footer id="bottom">
        <section class="mar-lf25">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-12">
                        Copyright © <?= date('Y'); ?> <a href="<?= site_url(); ?>">vitals.villgroapps.org</a>&nbsp;V2.0
                    </div>
                </div>
            </div>
        </section>
    </footer>
<?php } ?>


<?php if ($page_load != 'drag_multiselect' && $page_load != 'portfolio') { ?>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <?php if ($quantitative == 'tiny') { ?>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/tinymce.min.js'; ?>"></script>
    <?php } ?>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>
<?php } ?>

<?php if ($page_load == 'portfolio') { ?>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
	 <script src="<?php echo base_url() . 'source/portfolio_assets/js/select/select2.min.js'; ?>"></script>
	
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/main.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/tinymce.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>
<?php } ?>

<?php if ($multi_select == 'multiselect') { ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<?php } ?>

<?php if ($page_name != '' && $page_name == 'datatable') { ?>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<?php } ?>

<?php if ($module != '' && $module != 'leave_summary' && $page_load != 'portfolio') { ?>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<?php } ?>

<?php if ($module == 'travel_accom') { ?>
    <script src="<?php echo base_url() . 'source/autocomplete/dimensions.js'; ?>" type="text/javascript"></script>
<?php } ?>

<?php if ($text_editor == 'textEditor') { ?>
    <script src="<?php echo base_url() . 'source/tiny_mce/tiny_mce.js'; ?>"></script>
<?php } ?>

<?php if ($bootstrap_DT == 'datatable') { ?>
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<?php } ?>

<?php if ($page_load == 'user_setup') { ?>
    <link type="text/css" href="<?= base_url(); ?>source/jquery_ui/css/south-street/ui.multiselect.css" rel="stylesheet" />
    <link type="text/css" href="<?= base_url(); ?>source/jquery_ui/css/south-street/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="<?= base_url(); ?>source/template/js/jquery.js" ></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/ui.multiselect.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/custom-ui.js"></script>
<?php } ?>

<?php if ($chart == 'yes') { ?>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/highcharts.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/series-label.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/exporting.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/export-data.js'; ?>"></script>
<?php } ?>

<?php if ($page_load == 'drag_multiselect') { ?>
    <link type="text/css" href="<?= base_url(); ?>source/jquery_ui/css/south-street/ui.multiselect.css" rel="stylesheet" />
    <link type="text/css" href="<?= base_url(); ?>source/jquery_ui/css/south-street/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/template/js/jquery.js" ></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/ui.multiselect.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>source/jquery_ui/js/custom-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
<?php } ?>

<?php if ($page_load == 'portfolio') { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 210) + 'px'
            });
        });
    </script>
<?php } ?>

<?php if ($page_load != 'user_setup' && $page_load != 'portfolio') { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.nav-tabs').scrollingTabs({enableSwiping: true}).on('ready.scrtabs', function () {
                $('.tab-content').show();
            });

            $('#navLoad').removeClass('display-hide');

            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 190) + 'px'
            });

        });
    </script>
<?php } ?>

<?php if ($page_load != 'user_setup' && $page_load != 'drag_multiselect') { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.toast').toast('show');
            setTimeout(function () {
                $('.toasterHide').removeClass('toastPlace');
            }, 5000);
        });
    </script>
<?php } ?>


<?php if ($load_currency != 'currency') { ?>
    <script type="text/javascript">
        $(document).on('input', '.currencyField', function (evt) {
            var self = $(this);
            self.val(self.val().replace(/[^0-9\.]/g, ''));
            self.val(inrFormat(self.val()));
            var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
            var matchedString = self.val().match(patt);
            if (matchedString) {
                self.val(matchedString);
            }
        });

        function inrFormat(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            var z = 0;
            var len = String(x1).length;
            var num = parseInt((len / 2) - 1);
            while (rgx.test(x1)) {
                if (z > 0) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                } else {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    rgx = /(\d+)(\d{2})/;
                }
                z++;
                num--;
                if (num == 0) {
                    break;
                }
            }
            return x1 + x2;
        }
    </script>
<?php } ?>

<?php if ($load_application == 'application') { ?>
    <script type="text/javascript">

        $(document).on('click', '#assign_incharge', function () {
            $('#form_employeelist').modal('show');
            $('#associate_employee').val('');
            assign_populate();
        });

        function showLog() {
            $('#logModal').modal('show');
        }
        function showComments() {
            $('#logComments').modal('show');
        }

        $('#comment_form').validate({
            rules: {
                "comment_status": "required",
                "comment": "required"
            },
            messages: {
                "comment_status": "Select status",
                "comment": "Enter Comments"
            }
        });

        $("#submit_form").click(function () {
            if ($("#comment_form").valid() == true) {
                $("#comment_form").submit();
            }
        });

        $('#save_action').on('click', function () {
            var action_value = $('#changeStatus').val();
            if (action_value == '1') {
                $('#actionModal').modal('show');
                pard_populate();
            } else {
                $('#commentModal').modal('show');
                comment_populate();
            }
        });

        function assign_populate() {
            var vals = "<?= $application_id; ?>";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/getassemployee",
                data: {
                    id: vals
                },
                dataType: 'json',
                success: function (msg) {
                    var arr = msg;
                    for (var prop in arr) {
                        $('#associate_employee option').map(function () {
                            if (arr[prop]['associate_employee'] == $(this).val()) {
                                $(this).prop("selected", 'selected');
                            }
                        });
                    }
                },
            });
            $('#innovation_id').val(vals);
        }

        function pard_populate() {
            var invID = "<?= $application_id; ?>";
            $('#innovations').val(invID);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/scouting/getassemployee",
                data: {
                    id: invID
                },
                dataType: 'json',
                success: function (msg) {
                    var arr = msg;
                    for (var prop in arr) {
                        $('#associate_employee option').map(function () {
                            if (arr[prop]['associate_employee'] == $(this).val()) {
                                $(this).attr("selected", 'selected');
                            }
                        });
                    }
                },
            });
        }

        function comment_populate() {
            var action = $('#changeStatus').val();
            $('#act_status').val(action);
        }

        $('#txtsub').click(function () {
            $('#showSpinner').removeClass('hidden_cls');
            var associate_employee = $('#associate_employee').val();
            var innovation_id = $('#innovation_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deals_assign_multi_incharge",
                data: {"associate_employee": associate_employee, "innovations": innovation_id},
                success: function (msg) {
                    if (msg == 1) {
                        location.reload();
                    }
                }
            });
        });

        // function attachmentDownload(inv_id, program, doc1, doc2) {
        //     if (confirm("Do you want to download attached documents as well?") == true) {
        //         if (inv_id != '') {
        //             var url = "<?php echo base_url() . 'index.php/scouting/export_deals_pdf/'; ?>";
        //             window.location.href = url + inv_id;
        //         }
        //         setTimeout(function () {
        //             attachedfile(program, doc1, doc2)
        //         }, 10000);
        //     } else {
        //         if (inv_id != '') {
        //             var url = "<?php echo base_url() . 'index.php/scouting/export_deals_pdf/'; ?>";
        //             window.location.href = url + inv_id;
        //         }
        //     }
        // }

        // function attachedfile(program, doc1, doc2) {
        //     var url;
        //     if (program == 0) {
        //         url = "<?php echo host_url() . 'IncubationForm/mis_download.php?file_name='; ?>";
        //     } else if (program == 3) {
        //         url = "<?php echo host_url() . 'pitchform/mis_download.php?file_name='; ?>";
        //     } else if (program == 4) {
        //         url = "<?php echo host_url() . 'poweringlivelihoods/mis_download.php?file_name='; ?>";
        //     }
        //     if (doc1 != '') {
        //         window.location.href = url + doc1;
        //     }
        //     var myset = setTimeout(function () {
        //         if (doc2 != '') {
        //             window.location.href = url + doc2;
        //         }
        //     }, 10000);
        // }

        function attachmentDownload(inv_id, program, doc1, doc2, doc3) {
            if (doc1 != '' || doc2 != '' || doc3 != '') {
                $('#welcomeModal').modal('show');
                $('#download_id').val(inv_id);
                $('#program_id').val(program);
                $('#doc1_id').val(doc1);
                $('#doc2_id').val(doc2);
                $('#doc3_id').val(doc3);
            } else {
                $('#download_id').val(inv_id);
                attachedfileNo();
            }
        }

        function attachedfileNo() {
            var inv_id = $('#download_id').val();
            if (inv_id != '') {
                var url = "<?php echo base_url() . 'index.php/scouting/export_deals_pdf/'; ?>";
                window.location.href = url + inv_id;
            }
        }

        var interval;

        function attachedfileYes() {
            var inv_id = $('#download_id').val();
            var program = $('#program_id').val();
            var doc1 = $('#doc1_id').val();
            var doc2 = $('#doc2_id').val();
            var doc3 = $('#doc3_id').val();

            var app_url, doc1_url, doc2_url, doc3_url;

            var host = "<?php echo host_url(); ?>";
            var base = "<?php echo base_url(); ?>";
            var app_url = base + 'index.php/scouting/export_deals_pdf/' + inv_id;

            if (program == 0 || program == 11 || program == 13) {
                if (doc1 != '') {
                    doc1_url = host + 'IncubationForm/mis_download.php?file_name=' + doc1;
                }
                if (doc2 != '') {
                    doc2_url = host + 'IncubationForm/mis_download.php?file_name=' + doc2;
                }
            } else if (program == 3) {
                if (doc1 != '') {
                    doc1_url = host + 'pitchform/mis_download.php?file_name=' + doc1;
                }
                if (doc2 != '') {
                    doc2_url = host + 'pitchform/mis_download.php?file_name=' + doc2;
                }
            } else if (program == 4) {
                if (doc1 != '') {
                    doc1_url = host + 'poweringlivelihoods/mis_download.php?file_name=' + doc1;
                }
                if (doc2 != '') {
                    doc2_url = host + 'poweringlivelihoods/mis_download.php?file_name=' + doc2;
                }
            } else if (program == 5) {
                if (doc1 != '') {
                    doc1_url = host + 'fpai/mis_download.php?file_name=' + doc1;
                }
                if (doc2 != '') {
                    doc2_url = host + 'fpai/mis_download.php?file_name=' + doc2;
                }
            } else if (program == 6) {
                if (doc1 != '') {
                    doc1_url = 'https://www.villgro.org/ubsapply/mis_download.php?file_name=' + doc1;
                }
                if (doc2 != '') {
                    doc2_url = 'https://www.villgro.org/ubsapply/mis_download.php?file_name=' + doc2;
                }
            } else if (program == 7) {
                if (doc1 != '') {
                    doc1_url = host + 'ysvf/mis_download.php?file_name=' + doc1;
                }
            } else if (program == 9) {
                if (doc1 != '') {
                    doc1_url = host + 'swachhata_startupchallenge/mis_download.php?file_name=' + doc1;
                }
                if (doc2 != '') {
                    doc2_url = host + 'swachhata_startupchallenge/mis_download.php?file_name=' + doc2;
                }
            } else if (program == 10) {
                if (doc1 != '') {
                    doc1_url = host + 'tanseed/mis_download.php?file_name=' + doc1;
                }
                if (doc2 != '') {
                    doc2_url = host + 'tanseed/mis_download.php?file_name=' + doc2;
                }
                if (doc3 != '') {
                    doc3_url = host + 'tanseed/mis_download.php?file_name=' + doc3;
                }
            } else if (program == 12) {
                if (doc1 != '') {
                    doc1_url = host + 'jhpiego/mis_download.php?file_name=' + doc1;
                }
            }else if (program == 14) {
                if (doc1 != '') {
                    doc1_url = host + 'cisco/mis_download.php?file_name=' + doc1;
                }
            }

            var urls = [app_url, doc1_url, doc2_url, doc3_url];
            urls = $.grep(urls, function (n) {
                return(n);
            });

            interval = setInterval(download, 300, urls);
        }

        function download(urls) {
            var url = urls.pop();
            if (url != null && url != undefined) {
                var link = document.createElement('a');
                link.download = '';
                link.href = url;
                document.body.appendChild(link);
                link.click();
                link.remove();

                if (urls.length == 0) {
                    clearInterval(interval);
                }
            } else {
                return false;
            }
        }

        $('#actionForm').validate({
            rules: {
                "status": "required",
                "reasons": "required",
                "comments": "required",
            },
            messages: {
                "status": "Select status",
                "reasons": "Select reasons",
                "comments": "Enter comments"
            }
        });
		
		
    </script>
    <?php } ?>
	<script>
		function go_to_previous_page(){
			let get_local_storage_url = localStorage.getItem('back_link');
			if(get_local_storage_url!=''){
				window.location.href = get_local_storage_url;
			}
		}
	</script>