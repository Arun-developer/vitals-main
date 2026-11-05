<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => "Master - Stage Efficiency")); ?>
<div class="display-hide deleteMsg">
    <div class="position-absolute d-flex flex-column p-4 toastPlace">
        <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
                <div class="toast deletetoast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header bg-success text-white">
                        <strong class="mr-auto">Record(s) deleted successfully</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="text-white">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'stage_efficiency')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Stage Efficiency</h4>
                    </div>
                    <div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                        </ul>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <form method="post" name="insertEditStage_efficiency" id="insertEditStage_efficiency" action="<?php echo base_url() . 'index.php/incubation_master/insertEditStage_efficiency'; ?>" class="form" novalidate autocomplete="off">
                                    <div class="inputplan-structureall plan-structure-new ">
                                        <div class="row v_m_e_search">
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>New</label>
                                                    <div class="display-flex">
                                                        <input disabled data-attr="new_err" value="<?php if (isset($stage_efficiency[0]->new) && $stage_efficiency[0]->new != '') echo $stage_efficiency[0]->new; ?>" name="new" class="form-control currencyField edit_cls" type="text" placeholder=""><span>Days</span>
                                                    </div>
                                                    <div id="new_err" ></div>
                                                    <!--<label for="new" class="tbl_err" style="margin-left: -48px;">Please enter a valid number.</label>-->
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Entry</label>
                                                    <div class="display-flex">
                                                        <input disabled data-attr="entry_err" value="<?php if (isset($stage_efficiency[0]->entry) && $stage_efficiency[0]->entry != '') echo $stage_efficiency[0]->entry; ?>" name="entry" class="form-control edit_cls" type="text" placeholder=""><span>Days</span>
                                                    </div>
                                                    <div id="entry_err" ></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row v_m_e_search">
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Lead</label>
                                                    <div class="display-flex">
                                                        <input disabled data-attr="lead_err" value="<?php if (isset($stage_efficiency[0]->lead) && $stage_efficiency[0]->lead != '') echo $stage_efficiency[0]->lead; ?>" name="lead" class="form-control edit_cls" type="text" placeholder=""><span>Days</span>
                                                    </div>
                                                    <div id="lead_err" ></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Shortlisted </label>
                                                    <div class="display-flex">
                                                        <input disabled data-attr="short_err" value="<?php if (isset($stage_efficiency[0]->shortlisted) && $stage_efficiency[0]->shortlisted != '') echo $stage_efficiency[0]->shortlisted; ?>" name="shortlisted" class="form-control edit_cls" type="text" placeholder=""><span>Days</span>
                                                    </div>
                                                    <div id="short_err" ></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row v_m_e_search">
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Due-Diligence</label>

                                                    <div class="display-flex">
                                                        <input disabled data-attr="due_err" value="<?php if (isset($stage_efficiency[0]->due_diligence) && $stage_efficiency[0]->due_diligence != '') echo $stage_efficiency[0]->due_diligence; ?>" name="due_diligence" class="form-control edit_cls" type="text" placeholder=""><span>Days</span>
                                                    </div>
                                                    <div id="due_err" ></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Incubation</label>
                                                    <div class="display-flex">
                                                        <input disabled data-attr="incubation_err" value="<?php if (isset($stage_efficiency[0]->incubation) && $stage_efficiency[0]->incubation != '') echo $stage_efficiency[0]->incubation; ?>" name="incubation" class="form-control edit_cls" type="text" placeholder=""><span>Days</span>
                                                    </div>
                                                    <div id="incubation_err" ></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row leaveLabel">
                                            <div id="submit_btn_cls" class="col-12 col-sm-4  col-md-4" style="display:none;" >
                                                <ul class="vitals-links">
                                                    <li><input type="submit" value="Save" id="submit_btn" class="vital_yellow_btn wdt_100"></input></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/incubation_master/stage_efficiency'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

<style type="text/css">
    label.tbl_err {
        width: 100%;
        text-align: right;
        color: #FF0000 !important;
        font-size: 12px !important;
    }
</style>

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">

    $('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop() + 150);
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

    $(document).on('click', '.summaryEdit', function () {
        $("#edit_status").val("1");
        $(".edit_cls").attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
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
                x1 = x1.replace(rgx, '$1' + '' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + '' + '$2');
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


    $(document).ready(function () {
        $('.nav-tabs').scrollingTabs({
            enableSwiping: true
        }).on('ready.scrtabs', function () {
            $('.tab-content').show();
        });
        $('#navLoad').removeClass('display-hide');
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
        $('.toast').toast('show');
        setTimeout(function () {
            $('.success').addClass('display-hide');
        }, 3000);
    });

    $(document).on('click', '#submit_btn', function (e) {
        /* if(!$("#insertEditStage_efficiency").valid()){
         e.preventDefault();
         }else{
         $('#insertEditStage_efficiency').submit();
         } */
        $('#insertEditStage_efficiency').submit();
    });

</script>

</body>
</html>