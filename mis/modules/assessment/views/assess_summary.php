<div id="print_area2">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/grid.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/chosen.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/jquery.fancybox.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/datatables.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/mystyle.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/misstylesheet.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/green.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/style.css"; ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/styles.css"; ?>"/>

    <?php
    $innovationID = $innovation['id'];
    $formAction = site_url('common/mail/form/' . $innovationID);

    $exist_date = date("d/m/Y", strtotime($iic_log_detail[0]['modified_date']));
    $current_date = date("d/m/Y");
    $set_current_date = date("Y-m-d");
    $iic_exist_date = isset($iic_log_detail[0]['modified_date']) && $iic_log_detail[0]['modified_date'] != '' && $iic_log_detail[0]['modified_date'] != '0000-00-00 00:00:00' ? $exist_date : $current_date;
    $iic_save_date = date("d/m/Y", strtotime($feed_back[0]['internal_date']));
    $iic_date = isset($feed_back[0]['internal_date']) && $feed_back[0]['internal_date'] != '' && $feed_back[0]['internal_date'] != '0000-00-00 00:00:00' ? $iic_save_date : $iic_exist_date;

    $exist_save_date = isset($feed_back[0]['internal_date']) && $feed_back[0]['internal_date'] != '' && $feed_back[0]['internal_date'] != '0000-00-00 00:00:00' ? $feed_back[0]['internal_date'] : $set_current_date;
    $find_set_iic = isset($iic_log_detail[0]['modified_date']) && $iic_log_detail[0]['modified_date'] != '' && $iic_log_detail[0]['modified_date'] != '0000-00-00 00:00:00' ? $iic_log_detail[0]['modified_date'] : $exist_save_date;
    $already_set_iic = date("d-M-Y", strtotime($find_set_iic));
    ?>

    <div style="display:none;">
        <div align="center" id="mail_trigger" style="width:420px; height:180px;" >

            <h1 class="text-left reduce_space">Mail Confirmation</h1>
            <div>
                <p class="mailTriggerHead">Would you like to send the rejection email to the entrepreneur?</p>
                <p class="mailTrigger">Click OK to be redirected to the mailing section.</p>
                <p class="mailTrigger">Click Cancel to manually perform this operation later.</p>
                <div style="margin-top:20px;">
                    <a onclick="document.getElementById('templateForm').submit();" class="button triggerBtn">Ok</a>
                    <a onclick="$.fancybox.close()" class="button triggerBtn" id="mailTriggerCancel">Cancel</a>
                </div>
            </div>

        </div>
    </div>

    <a id="close_mail" class="fancybox button" href="#mail_trigger" style="display:none;"></a>

    <form name="templateForm" enctype="multipart/form-data" action="<?= $formAction ?>" method="post" id="templateForm" class="uniform" autocomplete="off">
        <input type="hidden" name="innovation" value="<?= $innovation['id'] ?>"  />
        <input type="hidden" name="mail_type" value="Rejection"  />
    </form>

    <script>
        $(window).on('load', function () {
            var close_action = "<?php echo $this->session->userdata('close_action'); ?>";
            if (close_action == 'yes') {
                $("#close_mail").trigger('click');
            }
        });

        $(function () {
            $('#iic_date').datepicker("option", "dateFormat", "dd-mm-yy");
        });

    </script>
    <?php echo $this->session->unset_userdata('close_action'); ?>

    <script type="text/javascript">
        function printDiv(divID) {
            $('#prints').hide();
            $('#saves').hide();
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                    "<html><head><title></title></head><body>" +
                    divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
            $('#prints').show();
            $('#saves').show();
        }

        $(document).ready(function () {
            $(".fancybox").fancybox({
            });

            $("#recomment").change(function () {
                if ($("#recomment").val() == 'Reject')
                {
                    $("#reject").show();
                    $("#reject1").show();
                    $("#reason").show();
                    $("#stage").hide();
                    $("#accept").hide();
                    $("#accept1").hide();
                } else
                {
                    $("#reject").hide();
                    $("#reject1").hide();
                    $("#reason").hide();
                    $("#stage").show();
                    $("#accept").show();
                    $("#accept1").show();
                }
            });

            $("#total_score").focus(function () {
                var total = 0;
                $('.score').each(function () {
                    var val = ($(this).val() != '') ? $(this).val() : 0;
                    total = parseFloat(total) + parseFloat(val);
                });

                total = (total != 0) ? total : '';
                $("#total_score").val(total);
            });

            $("#total_per_cio").focus(function () {
                var total = total_count = 0;
                $('.score').each(function () {
                    var val = ($(this).val() != '') ? $(this).val() : 0;
                    total = parseFloat(total) + parseFloat(val);
                    if (val != 0)
                        total_count = total_count + 1;
                });

                var tot_val_per = total_count * 3;
                var percent = '';
                if (total != '' && total != 0 && tot_val_per != 0)
                    percent = ((total / tot_val_per) * 100).toFixed(2);
                $("#total_per_cio").val(percent);
            });

            $(".score").keyup(function () {
                var id = $(this).attr('id');
                var area = id.split('_');
                if (!$.isNumeric($(this).val()))
                {
                    $("#" + id).focus();
                    var len = $("#" + id).val().length;
                    var str = $("#" + id).val().substring(0, len - 1);
                    $("#" + id).val(str);
                } else {
                    if (parseInt($(this).val()) > 3) {
                        $("#" + id).focus();
                        $("#score_error_" + area[1]).html("Enter number between 0 to 3").show().css('color', 'red');
                    } else {
                        $("#score_error_" + area[1]).html("");
                        var total = total_count = 0;
                        $('.score').each(function () {
                            var val = ($(this).val() != '') ? $(this).val() : 0;
                            total = parseFloat(total) + parseFloat(val);
                            if ($(this).val() != '')
                                total_count = total_count + 1;
                        });
                        total = (total != 0) ? total : '';
                        $("#total_score").val(total);

                        var tot_val_per = total_count * 3;
                        var percent = '';
                        if (total != '' && total != 0 && tot_val_per != 0)
                            percent = ((total / tot_val_per) * 100).toFixed(2);
                        $("#total_per_cio").val(percent);
                    }
                }
            });

            // var scoreVal = 0;
            // $(".submit,.ciosubmit").click(function (e) {
            //     $('.score_submit').each(function () {
            //         var assign_score = $(this).val();
            //         if (assign_score == 'NaN' || assign_score == '') {
            //             assign_score = 0;
            //         }
            //         scoreVal += parseFloat(assign_score);
            //     });
            //     if (scoreVal == 0 && $("#internal_status").val() == 'Accept') {
            //         alert("Enter score value");
            //         document.getElementById("back").click();
            //         return false;
            //     }
            // });

            $(".save,.submit,.ciosubmit").click(function () {
                var find_button = $(this).attr('class');
                var split_class = find_button.split(' ');
                var class_name = split_class[1];
                var formType = $(this).attr('id');
                $('#form_type').val(formType);
                var user_status = "<?php echo $feed_back[0]['result']; ?>";
                if (user_status == $("#recomment").val()) {
                    $("#accept_reject").val('0');
                } else {
                    $("#accept_reject").val('1');
                }

                var errorval = 0;
                var userVal = 0;
                var total_count = 0;
                var total = 0;
                var scoreVal = 0;

                $('.score').each(function () {
                    var val = ($(this).val() != '') ? $(this).val() : 0;
                    total = parseFloat(total) + parseFloat(val);
                    if ($(this).val() != '')
                        total_count = total_count + 1;
                });
                total = (total != 0) ? total : '';
                $("#total_score").val(total);

                var tot_val_per = total_count * 3;
                var percent = '';
                if (total != '' && total != 0 && tot_val_per != 0)
                    percent = ((total / tot_val_per) * 100).toFixed(2);
                $("#total_per_cio").val(percent);
                $('.error').each(function () {
                    if ($('.error').html() != '')
                        errorval = errorval + 1;
                });

                var user_accept = valid_doc('user_doc');
                if (user_accept == false) {
                    errorval = errorval + 1;
                }

                var iic_section = $("#iic_doc_count").val();
                if (iic_section == '1') {
                    var iic_accept = valid_doc('iic_doc');
                    if (iic_accept == false) {
                        errorval = errorval + 1;
                    }
                }

                /*---- Validation for enter fund detail for atleast one donor ----*/
<?php if ($this->session->userdata('emp_number') != $cio_emp_num) { ?>
                    if ($("#recomment").val() == 'Accept') {
                        var checkbox_length = $(".donor_fit").length;
                        $('.donor_fit').each(function () {
                            if ($(this).is(':checked')) {
                                userVal = 1;
                            } else {

                            }
                        });
                    } else {
                        userVal = 1;
                    }
                    if (userVal != 1 && checkbox_length > 0) {
                        alert("Enter funds detail for any donor");
                        return false;
                    }
<?php } ?>

<?php if ($this->session->userdata('emp_number') == $cio_emp_num) { ?>
                    if ($(this).attr('class').split(' ')[1] == 'ciosubmit') {

                        $('#assess_summary').append('<input type="hidden" name="ciosubmit" id="ciosubmit" value="submit"/>');
                        var score = 0;
                        $('.score').each(function () {
                            if ($(this).val() == '') {
                                score = score + 1;
                            }
                        });

                        var rational = 0;
                        $('.rational').each(function () {
                            if ($(this).val() == '') {
                                rational = rational + 1;
                            }
                        });

                        var risk = 0;
                        $('.risk').each(function () {
                            if ($(this).val() == '') {
                                risk = risk + 1;
                            }
                        });
                        if (score > 0) {
                            alert("Enter scores for each criteria");
                            errorval = errorval + 1;
                        } else if (rational > 0) {
                            alert("Enter rationale comments");
                            errorval = errorval + 1;
                        } else if (risk > 0) {
                            alert("Enter risk comments");
                            errorval = errorval + 1;
                        } else if ($("#cio_status").val() == "") {
                            alert("Select your recommendation to submit the innovation");
                            errorval = errorval + 1;
                        }
                    }
<?php } ?>

                var flag = 0;
                $("#recomment_error").html("");
                $("#stage_error").html("");
                $("#reason_error").html("");

                var score_total = '';
                var score_len = $('#scoring_count').val();
                if (class_name == 'submit' || class_name == 'ciosubmit') {
                    $('.score_submit').each(function () {
                        var assign_score = $(this).val();
                        // if (assign_score == 'NaN' || assign_score == '') {
                        score_total += assign_score;
                        // }
                        scoreVal += parseFloat(assign_score);
                    });

                    if (score_len == 0 && $("#internal_status").val() == 'Accept') {
                        alert("Enter score value");
                        errorval = errorval + 1;
                        document.getElementById("back").click();
                        return false;
                    }
                    var chosen_date = $('#iic_date').val();
                    if (score_len > 0 && $("#internal_status").val() == 'Accept' && chosen_date == '') {
                        alert("Select date");
                        errorval = errorval + 1;
                    }
                }

                /*-----Validation for recommendation(User Accept/Reject) and IC status(Accept/Reject) ------*/
                if (errorval == 0 && flag == 0)
                {
                    if ($(this).attr('class').split(' ')[1] == 'submit')
                    {
                        $('#assess_summary').append('<input type="hidden" name="submit1" id="submit1" value="submit"/>');
                        if ($("#recomment").val() == '')
                        {
                            alert("Select your recommendation before submit for approval");
                            return false
                        } else if ($("#recomment").val() == 'Accept')
                        {
                            if ($("#stage").val() == '')
                            {
                                alert("Select stage of innovation before submit for approval");
                                return false
                            }
                        } else if ($("#recomment").val() == 'Reject')
                        {
                            if ($("#reason").val() == '')
                            {
                                alert("Select reason for the rejection of innovation");
                                return false
                            }
                        }

                        if ($("#hcio_status").val() != '' && $("#hcio_status").val() == 'Accept')
                        {
                            if ($("#hinternal_status").val() == '' && $("#internal_status").val() == '')
                            {
                                alert("Select Internal IC recommendation of innovation before submit");
                                return false;
                            }
                        }

                        if ($("#internal_status").val() == 'Accept') {
                            var r = confirm("You are about to submit the IIC status of this deal. PA/RD scoring sheets will not be editable once this is done. Do you want to proceed?");
                            if (r == true) {
                                $("#assess_summary").submit();
                            } else {
                                return false;
                            }
                        }
                        $("#assess_summary").submit();
                    } else {
                        $("#assess_summary").submit();
                    }
                } else
                    return false;

            });

            $('.donor_fit').change(function () {
                if ($(this).is(':checked'))
                {
                    $(this).closest("tr").find("input[name='fund_recom[" + $(this).val() + "]']").prop('readonly', false);
                    $(this).closest("tr").find("input[name='fund_approved[" + $(this).val() + "]']").prop('readonly', false);
                } else
                {
                    $(this).closest("tr").find("input[name='fund_recom[" + $(this).val() + "]']").val('');
                    $(this).closest("tr").find("input[name='fund_recom[" + $(this).val() + "]']").prop('readonly', true);
                    $(this).closest("tr").find('.fund_recom_error').text('');
                    $(this).closest("tr").find("input[name='fund_approved[" + $(this).val() + "]']").val('');
                    $(this).closest("tr").find("input[name='fund_approved[" + $(this).val() + "]']").prop('readonly', true);
                    $(this).closest("tr").find('.fund_approved_error').text('');
                }
            });
            /*------Validation for fund values-----*/
            $('.fund_recom').blur(function () {
                if ($(this).val().length > 0 && $(this).val() == 0)
                {
                    $(this).closest("td").find('.fund_recom_error').text('Fund must be greater than zero').css('color', 'red');
                    $(this).val('');
                    $(this).focus();
                } else if (isNaN($(this).val()))
                {
                    $(this).closest("td").find('.fund_recom_error').text('Enter numbers only').css('color', 'red');
                    $(this).val('');
                    $(this).focus();
                } else
                {
                    $(this).closest("td").find('.fund_recom_error').text('');
                }
            });

            $('.fund_approved').blur(function () {
                if ($(this).val().length > 0 && $(this).val() == 0)
                {
                    $(this).closest("td").find('.fund_approved_error').text('Fund must be greater than zero').css('color', 'red');
                    $(this).val('');
                    $(this).focus();
                } else if (isNaN($(this).val()))
                {
                    $(this).closest("td").find('.fund_approved_error').text('Enter numbers only').css('color', 'red');
                    $(this).val('');
                    $(this).focus();
                } else
                {
                    $(this).closest("td").find('.fund_approved_error').text('');
                }

            });

            $('.transfer').click(function () {
                var id = $(this).attr('data');
                var inno = '<?php echo $this->uri->segment("3"); ?>';
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id, innov: inno},
                    url: '<?php echo site_url("assessment/getscore/"); ?>',
                    success: function (response) {
                        var array = response['area'];
                        $.each(array, function (index, value) {
                            $("#score_" + value).val(response[value]);
                            $("#total_score").val(response['total_score']);
                        });
                    }
                });
            });
        });

        function valid_doc(id) {
            var filename = $("#" + id).val();
            if (filename != '') {
                if (!(/\.(doc|docx|pdf|ppt|pptx)$/i).test(filename)) {
                    $("#" + id + "_file .filename").html('No file selected');
                    var fieldSpan = $("#" + id + "_file");
                    fieldSpan.html(fieldSpan.html());
                    $("#" + id + "_error").text("Invalid file. Supported document type is pdf,doc,ppt").css('color', 'red');
                    return false;
                    setTimeout(function () {
                        $("#" + id).focus();
                    }, 10);
                } else {
                    $("#" + id + "_file .filename").html(filename);
                    $("#" + id + "_error").text("");
                    return true;
                }
            } else {
                $("#" + id + "_file .filename").html("No file selected");
                $("#" + id + "_error").text("");
                return true;
            }
        }

    </script>

    <div id="download" style="display: none;">
        <h1>Preliminary Assessment</h1>
        <table class="tree" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <th>S.No.</th>
                <th>Parameters</th>
                <th>Score</th>
                <th>Rationale</th>
                <th>Risks</th>
            </tr>
            <tr>
                <td id="csno"></td>
                <td id="cparam"></td>
                <td>test</td>
                <td>test</td>
                <td>test</td>
            </tr>
        </table>
    </div>
    <section style="overfolw:visible" id="content">
        <section style="overfolw:visible;margin-left:0px!important;width:100%!important" class="clearfix">
            <section style="overfolw:visible" class="grid_12" id="main">
                <h1><?= $innovation['name_of_enterprise'] ?> - PA/RD Summary</h1>
                <?php
// innovation status = 3 -> closed
                if (php72_in_array($this->session->userdata('emp_number'), $active_incharge) && $inno_status != '3' && $inno_status != '9' && $inno_status != '7') {
                    $readonly1 = '';
                    $disabled1 = '';
                    $display1 = '';
                    $class1 = 'multiselect';
                    $width1 = '';
                    $c_pointer = '';
                } else {
                    $readonly1 = "readonly='readonly'";
                    $disabled1 = 'disabled="disabled"';
                    $display1 = 'style = "display:none"';
                    $class1 = '';
                    $width1 = 'style="width:200px"';
                    $c_pointer = 'style="pointer-events: none;"';
                }
                if ($this->session->userdata('emp_number') == $cio_emp_num && $inno_status != '3' && $inno_status != '9' && $inno_status != '7' && $inno_status == '6' && isset($feed_back[0]['result']) && $feed_back[0]['result'] == 'Accept') {
                    $readonly = '';
                    $disabled = '';
                    $display = '';
                    $class = 'multiselect';
                    $width = '';
                } else if ($assigned_incharge[0] == $cio_emp_num && $inno_status == '1') {
                    $readonly = '';
                } else {
                    $readonly = "readonly='readonly'";
                    $disabled = 'disabled="disabled"';
                    $display = 'style = "display:none"';
                    $class = '';
                    $width = 'style="width:200px"';
                }
                ?>
                <form name="assess_summary" id="assess_summary" action="<?php echo site_url('assessment/store_summary'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <ul class="option-tab" id="prints">
                        <li><a id="logStatusModal" class="fancybox button" href="#status_log" style="cursor:pointer;">Application Status Log</a></li>
                        <li>
                            <input type="button" class="button" value="Print" onclick="javascript:printDiv('print_area2')" />
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="table-tree" id="print_area">
                        <table class="tree" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>S.No.</th>
                                <th>Parameters</th>
                                <?php
                                if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                    $final_assigned_incharge = array();
                                    $temp_assigned_incharge = $assigned_incharge;
                                    $check_pard_user = $this->Massessment->getInactivePARDuser($innovationID, $assigned_incharge);
                                    foreach ($check_pard_user as $active_user) {
                                        array_push($final_assigned_incharge, $active_user['associate_employee']);
                                        unset($temp_assigned_incharge[php72_array_search($active_user['associate_employee'], $temp_assigned_incharge)]);
                                    }

                                    if (php72_count($temp_assigned_incharge) > 0) {
                                        foreach ($temp_assigned_incharge as $active_user_id) {
                                            $inactive_user_score = $this->Massessment->getInactiveUserScore($innovationID, $active_user_id);
                                            array_push($final_assigned_incharge, $inactive_user_score[0]['assesst_by']);
                                        }
                                    }
                                    $assigned = count(array_filter($final_assigned_incharge));
                                    for ($a = 0; $a < $assigned; $a++) {
                                        $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $final_assigned_incharge[$a]);
                                        if (empty($assigned_score)) {
                                            $assigned_score[] = 0;
                                        }

                                        if (!empty($assigned_score)) {
                                            ?>
                                            <th style="text-align: left;">
                                                <?php
                                                $ass_user = Muser::getUsersList($final_assigned_incharge[$a]);
                                                $url = site_url("assessment/view_assesst_detail/" . $final_assigned_incharge[$a] . "/" . $this->uri->segment('3') . "/0/1");
                                                ?>
                                                <a href="#" title="Transfer Score" class="transfer" style="float:left" data="<?php echo $final_assigned_incharge[$a]; ?>">
                                                    <?php
                                                    echo "<a class='fancybox' style='text-decoration:none;color:#fff' id='assess_form' href='$url'>" . $ass_user[0]['emp_name'] . "</a>";
                                                    ?>
                                                </a>
                                            </th>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <?php
                                $emp = array();
                                if (isset($assessor) && !empty($assessor)) {
                                    $empl = unserialize($assessor[0]['assessor_id']);
                                    $status = unserialize($assessor[0]['status']);
                                    $e = 0;
                                    $s = 0;

                                    foreach ($status as $stat) {
                                        if (php72_cmp($stat) == 1) {
                                            $emp[$s] = $empl[$e];
                                            $s++;
                                        }
                                        $e++;
                                    }
                                }

                                $count = 0;
                                if (!empty($emp)) {
                                    $count = count($emp);
                                }

                                $j = 2;
                                for ($i = 0; $i < $count; $i++) {
                                    $ass_score = array();
                                    $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);

                                    if (!empty($assesst_sub)) {
                                        ?>
                                        <th>
                                            <?php
                                            $ass_asse = Muser::getUsersList($emp[$i]);
                                            $url = site_url("assessment/view_assesst_detail/" . $emp[0] . "/" . $this->uri->segment('3') . "/0/1");

                                            if ($this->session->userdata('emp_number') == $cio_emp_num && $inno_status != '7' && $inno_status != '9' && $inno_status != '3' && $inno_status == '6' && isset($feed_back[0]['result']) && $feed_back[0]['result'] == 'Accept') {
                                                ?>
                                                <a href="#" title="Transfer Score" class="transfer" data="<?php echo $emp[$i]; ?>" style="float:left"><img style="margin-bottom:-6px;" src="<?php echo base_url(); ?>source/images/images1.jpg"/></a> &nbsp;
                                                <?php
                                            }
                                            echo "<a class='fancybox' style='text-decoration:none;color:#fff' id='assess_form' href='$url'>" . $ass_asse[0]['emp_name'] . "</a>";
                                            ?>

                                        </th>
                                        <?php
                                    }
                                    $j++;
                                }
                                ?>
                                <th>Rationale</th>
                                <th>Risks</th>
                            </tr>
                            <?php
                            $error_msg = array();
                            $k = 0;
                            foreach ($area as $area) {
                                if (isset($feed_back) && !empty($feed_back)) {
                                    $feed_score = unserialize($feed_back[0]['area_score']);
                                    $feed_rational = unserialize($feed_back[0]['rational']);
                                    $feed_risk = unserialize($feed_back[0]['risk']);
                                }
                                if (isset($assesst)) {
                                    $score = unserialize($assesst[0]['score']);
                                    $rational = unserialize($assesst[0]['rational']);
                                    $risk = unserialize($assesst[0]['risk']);
                                }
                                $k++;
                                ?>
                                <tr class="in-child">
                                    <td id="sno"><?php echo $k; ?></td>
                                    <td id="param"><?php echo $area['Name']; ?></td>
                                    <?php
                                    if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                        $final_assigned_incharge = array();
                                        $temp_assigned_incharge = $assigned_incharge;
                                        $check_pard_user = $this->Massessment->getInactivePARDuser($innovationID, $assigned_incharge);
                                        foreach ($check_pard_user as $active_user) {
                                            array_push($final_assigned_incharge, $active_user['associate_employee']);
                                            unset($temp_assigned_incharge[php72_array_search($active_user['associate_employee'], $temp_assigned_incharge)]);
                                        }
                                        if (php72_count($temp_assigned_incharge) > 0) {
                                            foreach ($temp_assigned_incharge as $active_user_id) {
                                                $inactive_user_score = $this->Massessment->getInactiveUserScore($innovationID, $active_user_id);
                                                array_push($final_assigned_incharge, $inactive_user_score[0]['assesst_by']);
                                            }
                                        }

                                        $assigned = count(array_filter($final_assigned_incharge));
                                        $rationala = array();
                                        $riska = array();
                                        for ($a = 0; $a < $assigned; $a++) {
                                            $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $final_assigned_incharge[$a]);
                                            $scorea = unserialize($assigned_score[0]['score']);
                                            $comment[$final_assigned_incharge[$a]] = $assigned_score[0]['comment'];
                                            $rationala[$final_assigned_incharge[$a]] = unserialize($assigned_score[0]['rational']);
                                            $riska[$final_assigned_incharge[$a]] = unserialize($assigned_score[0]['risk']);
                                            $sub_cat_score = $this->Massessment->getSubAssesst($assigned_score[0]['id']);
                                            foreach ($sub_cat_score as $sub_cat) {
                                                $sub_scores = unserialize($sub_cat['sub_score']);
                                                foreach ($sub_scores as $ss) {
                                                    if ($ss == '') {
                                                        $error_msg[] = $final_assigned_incharge[$a];
                                                    }
                                                }
                                            }
                                            ?>
                                            <td><span class="score1"><?php echo (isset($scorea[$area['id']])) && $scorea[$area['id']] != '' ? $scorea[$area['id']] : '-'; ?></span></td>
                                            <?php
                                        }
                                        $comment_count = php72_count($comment);
                                        $assigned_comment = '';

                                        for ($l = 0; $l < $comment_count; $l++) {
                                            $username = Massessment::getEmpName($final_assigned_incharge[$l]);
                                            $user = explode(' ', $username);
                                            if ($comment[$final_assigned_incharge[$l]] != '') {
                                                $assigned_comment .= $user[0] . ' : ' . $comment[$final_assigned_incharge[$l]] . "\r\n\n";
                                            }
                                        }

                                        $assigned_count = count($rationala);
                                        $assigned_rational_val = '';
                                        for ($i = 0; $i < $assigned_count; $i++) {
                                            $username = Massessment::getEmpName($final_assigned_incharge[$i]);
                                            $user = explode(' ', $username);
                                            if ($rationala[$final_assigned_incharge[$i]][$area['id']] != '') {
                                                $assigned_rational_val .= $user[0] . ' : ' . $rationala[$final_assigned_incharge[$i]][$area['id']] . "\r\n\n";
                                            }
                                        }
                                        $assigned_risk_val = '';
                                        for ($i = 0; $i < $assigned_count; $i++) {
                                            $username = Massessment::getEmpName($final_assigned_incharge[$i]);
                                            $user = explode(' ', $username);
                                            if ($riska[$final_assigned_incharge[$i]][$area['id']] != '') {
                                                $assigned_risk_val .= $user[0] . ' : ' . $riska[$final_assigned_incharge[$i]][$area['id']] . "\r\n\n";
                                            }
                                        }
                                    }

                                    $ass_rational = array();
                                    $ass_risk = array();
                                    for ($i = 0; $i < $count; $i++) {
                                        $ass_score = array();
                                        $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);
                                        if ($emp[$i] && empty($assesst_sub)) {
                                            $error_msg[] = $emp[$i];
                                        }
                                        if (!empty($assesst_sub)) {
                                            $ass_score = unserialize($assesst_sub[0]['score']);
                                            $ass_rational[$emp[$i]] = unserialize($assesst_sub[0]['rational']);
                                            $ass_risk[$emp[$i]] = unserialize($assesst_sub[0]['risk']);
                                            $sub_cat_as_score = $this->Massessment->getSubAssesst($assesst_sub[0]['id']);
                                            foreach ($sub_cat_as_score as $sub_as_cat) {
                                                $sub_as_scores = unserialize($sub_as_cat['sub_score']);
                                                foreach ($sub_as_scores as $ass) {
                                                    if ($ass == '') {
                                                        $error_msg[] = $emp[$i];
                                                    }
                                                }
                                            }
                                            ?>
                                            <td><span class="score1"><?php
                                                    if (isset($ass_score[$area['id']])) {
                                                        echo $ass_score[$area['id']];
                                                    } else {
                                                        echo '1';
                                                    }
                                                    ?></span></td>
                                            <?php
                                        }
                                        $j++;
                                    }
                                    $ass_count = count($ass_rational);
                                    $ass_rational_val = '';
                                    for ($i = 0; $i < $ass_count; $i++) {
                                        $username = Massessment::getEmpName($emp[$i]);
                                        $user = explode(' ', $username);
                                        $ass_rational_val .= $user[0] . ' : ' . $ass_rational[$emp[$i]][$area['id']] . "\r\n";
                                    }
                                    $ass_risk_val = '';
                                    for ($i = 0; $i < $ass_count; $i++) {
                                        $username = Massessment::getEmpName($emp[$i]);
                                        $user = explode(' ', $username);
                                        $ass_risk_val .= $user[0] . ' : ' . $ass_risk[$emp[$i]][$area['id']] . "\r\n";
                                    }
                                    ?>


                                    <td><textarea class="pre-input rational" cols="30"  rows="3" name="rational[<?php echo $area['id']; ?>]" id="rational_<?php echo $area['id']; ?>" <?php echo $readonly; ?>><?php
                                            if (isset($feed_rational[$area['id']])) {
                                                $r_explode = explode(":", $feed_rational[$area['id']]);
                                            }

                                            if (trim($r_explode[1]) != '') {
                                                echo $feed_rational[$area['id']] . "\r\n";
                                            } else {
                                                if (isset($assigned_rational_val) && $assigned_rational_val != '') {
                                                    echo $assigned_rational_val;
                                                }

                                                if (isset($ass_rational_val) && $ass_rational_val != '') {
                                                    echo $ass_rational_val;
                                                }
                                            }
                                            ?></textarea></td>
                                    <td><textarea class="pre-input risk" cols="30"  rows="3" name="risk[<?php echo $area['id']; ?>]" id="risk_<?php echo $area['id']; ?>" <?php echo $readonly; ?>><?php
                                            if (isset($feed_risk[$area['id']])) {
                                                $explode = explode(":", $feed_risk[$area['id']]);
                                                if (trim($explode[1]) != '') {
                                                    echo $feed_risk[$area['id']] . "\r\n";
                                                }
                                            } else {
                                                if (isset($assigned_risk_val) && $assigned_risk_val != '') {
                                                    echo $assigned_risk_val;
                                                }

                                                if (isset($ass_risk_val) && $ass_risk_val != '') {
                                                    echo $ass_risk_val;
                                                }
                                            }
                                            ?></textarea></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tr class="parent">
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Total</strong>
                                </td>
                                <?php
                                if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                    $assigned = php72_count($assigned_incharge);
                                    for ($a = 0; $a < $assigned; $a++) {
                                        $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $assigned_incharge[$a]);
                                        if (!empty($assigned_score)) {
                                            ?>
                                            <td><strong><input type="text" class="pre-input score_submit" style="width:70px" name="total_score_assign" id="total_score_assign"  readonly value="<?php
                                                    if (isset($assigned_score[0]['total_score'])) {
                                                        echo $assigned_score[0]['total_score'];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>" /></strong></td>
                                            <?php } else {
                                                ?>
                                            <td><strong><input type="text" class="pre-input score_submit" style="width:70px" name="total_score" id="total_score"  readonly value="<?php
                                                    if (isset($feed_back[0]['score'])) {
                                                        echo $feed_back[0]['score'];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>" /></strong></td>
                                                <?php
                                            }
                                        }
                                    }

                                    for ($i = 0; $i < $count; $i++) {
                                        $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);
                                        if (!empty($assesst_sub)) {
                                            ?>
                                        <td><strong><input type="text" class="pre-input" style="width:70px" name="total_score_sub" id="total_score_sub"  readonly value="<?php
                                                if (isset($assesst_sub[0]['total_score'])) {
                                                    echo $assesst_sub[0]['total_score'];
                                                } else {
                                                    echo '';
                                                }
                                                ?>" /></strong></td>
                                            <?php
                                        }
                                    }
                                    ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="parent">
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Total %</strong>
                                </td>
                                <?php
                                if (isset($assigned_incharge) && !empty($assigned_incharge)) {
                                    $assigned = php72_count($assigned_incharge);
                                    for ($a = 0; $a < $assigned; $a++) {
                                        $assigned_score = $this->Massessment->getAssesst($this->uri->segment(3), $assigned_incharge[$a]);
                                        if (!empty($assigned_score)) {
                                            ?>
                                            <td><strong><input type="text" class="pre-input" style="width:70px" name="total_per_assign" id="total_per_assign"  readonly value="<?php
                                                    if (isset($assigned_score[0]['total_per'])) {
                                                        echo $assigned_score[0]['total_per'];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>" /></strong></td>
                                            <?php } else {
                                                ?>
                                            <td><strong><input type="text" class="pre-input" style="width:70px" name="total_per_cio" id="total_per_cio"  readonly value="<?php
                                                    if (isset($feed_back[0]['per_score'])) {
                                                        echo $feed_back[0]['per_score'];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>" /></strong></td>
                                                <?php
                                            }
                                        }
                                    }

                                    for ($i = 0; $i < $count; $i++) {
                                        $assesst_sub = $this->Massessment->getAssesst($this->uri->segment(3), $emp[$i]);
                                        if (!empty($assesst_sub)) {
                                            ?>
                                        <td><strong><input type="text" class="pre-input" style="width:70px" name="total_per_sub" id="total_per_sub"  readonly value="<?php
                                                if (isset($assesst_sub[0]['total_per'])) {
                                                    echo $assesst_sub[0]['total_per'];
                                                } else {
                                                    echo '';
                                                }
                                                ?>" /></strong></td>
                                            <?php
                                        }
                                    }
                                    ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>


                            <tr>
                                <td>&nbsp;</td>
                                <td><strong>Comments</strong></td>
                                <td colspan="2">
                                    <textarea rows="3" cols="30" name="comment" id="comment" readonly="readonly"><?php
                                        if (isset($assigned_comment) && $assigned_comment != '') {
                                            echo $assigned_comment;
                                        } else {
                                            echo '';
                                        }
                                        ?></textarea>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                        </table>
                        <br/>

                        <div class="table-tree" >
                            <table  class="tree" width="100%" >
                                <tr class="in-child">
                                    <td width="10%"><b>LIS</b></td>
                                    <td>
                                        <input type="radio" value="1" name="LIS" style="margin-right:3px;margin-top:3px;" <?php echo $disabled1; ?> <?php echo (isset($feed_back[0]['LIS']) && $feed_back[0]['LIS'] != '' && $feed_back[0]['LIS'] == '1') ? 'checked="checked"' : ''; ?>>Yes
                                        <input type="radio" value="0" name="LIS" style="margin-right:3px;margin-top:3px;" <?php echo $disabled1; ?> <?php echo (isset($feed_back[0]['LIS']) && $feed_back[0]['LIS'] != '' && $feed_back[0]['LIS'] == '0') ? 'checked="checked"' : ''; ?> <?php
                                        if ($feed_back[0]['LIS'] == '') {
                                            echo 'checked="checked"';
                                        }
                                        ?> >No
                                    </td>
                                <input type="hidden" name="LIS1" id="LIS1" value="<?php echo $feed_back[0]['LIS']; ?>">
                                <input type="hidden" name="accept_reject" id="accept_reject">
                                </tr>
                                <tr class="in-child">
                                    <td width="10%" valign="top"><b>Donor Fit</b></td>
                                    <td >
                                        <?php
                                        $donors = '';
                                        if (isset($feed_back[0]['donor_fit'])) {
                                            $donors = explode(',', $feed_back[0]['donor_fit']);
                                        }

                                        $recomm = explode(',', $feed_back[0]['fund_recom']);
                                        $approved = explode(',', $feed_back[0]['fund_approved']);
                                        if (!empty($recomm)) {
                                            foreach ($recomm as $value) {
                                                $array = explode('_', $value);
                                                if (!empty($array)) {
                                                    $recomm_array[$array[0]] = $array[1];
                                                }
                                            }
                                            foreach ($approved as $value) {
                                                $array = explode('_', $value);
                                                if (!empty($array)) {
                                                    $approved_array[$array[0]] = $array[1];
                                                }
                                            }
                                        }
                                        ?>

                                        <div style="width:620px;height:200px;overflow:auto;border:1px solid">
                                            <table style="width:100%">
                                                <tr>
                                                    <th style="text-align:center">Donor</th>
                                                    <th style="text-align:center">Funds Recommended</th>
                                                    <th style="text-align:center">Funds Approved</th>
                                                </tr>
                                                <?php
                                                foreach ($donor_fit as $donor) {
                                                    if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $inno_status != '3' && $inno_status != '9') {
                                                        $readonly_donor = (isset($feed_back[0]['donor_fit']) && php72_in_array($donor['id'], $donors)) ? '' : $readonly_donor = 'readonly="readonly"';
                                                    } else {
                                                        $readonly_donor = 'readonly="readonly"';
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input <?php echo $disabled1; ?> type="checkbox" id='donor_fit' name="donor_fit[]" value="<?php echo $donor['id']; ?>"  class="donor_fit" <?php echo (isset($feed_back[0]['donor_fit']) && php72_in_array($donor['id'], $donors)) ? 'checked="checked"' : ''; ?>>
                                                            <span style="margin-left:5px;margin-top:2px;"><?php echo $donor['name']; ?></span>
                                                        </td>
                                                        <td style="text-align:center"><input <?php echo $readonly_donor; ?> type="text" id="fund_recom" name="fund_recom[<?php echo $donor['id']; ?>]" value="<?php
                                                            if (isset($recomm_array[$donor['id']]) && $recomm_array[$donor['id']] != '0') {
                                                                echo $recomm_array[$donor['id']];
                                                            }
                                                            ?>" class="fund_recom"><br/><span class="fund_recom_error"></span></td>
                                                        <td style="text-align:center"><input <?php echo $readonly_donor; ?> type="text" id="fund_approved" name="fund_approved[<?php echo $donor['id']; ?>]" value="<?php
                                                            if (isset($approved_array[$donor['id']]) && $approved_array[$donor['id']] != '0') {
                                                                echo $approved_array[$donor['id']];
                                                            }
                                                            ?>" class="fund_approved"><br/><span class="fund_approved_error"></span></td>
                                                    </tr>

                                                    <?php
                                                }
                                                $hid_don_fit = $feed_back[0]['donor_fit'];
                                                ?>

                                                <input type="hidden" name='donor_fit1' id='donor_fit1' value="<?php echo $hid_don_fit; ?>">
                                            </table>        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <br/>
                        <?php
                        $ass_disabled = $ass_readonly = '';
                        if ($feed_back[0]['cio_status'] != '') {
                            $ass_disabled = 'disabled="disabled"';
                            $ass_readonly = 'readonly="readonly"';
                        }
                        ?>
                        <table class="tree" width="100%" align="center" cellpadding="0" cellspacing="0">

                            <tr class="in-child">
                                <td width="25%"><strong>Recommendation</strong></td>
                                <td>
                                    <select name="recomment" id="recomment" <?php
                                    echo $disabled1;
                                    echo $ass_disabled;
                                    ?>>
                                        <option value="">-Select-</option>
                                        <option value="Accept" <?php echo (isset($feed_back[0]['result']) && $feed_back[0]['result'] != '' && $feed_back[0]['result'] == 'Accept') ? 'selected="selected"' : ''; ?>>Accept</option>
                                        <option value="Reject" <?php echo (isset($feed_back[0]['result']) && $feed_back[0]['result'] != '' && $feed_back[0]['result'] == 'Reject') ? 'selected="selected"' : ''; ?>>Reject & Close</option>
                                    </select>
                                    <br/><label id="recomment_error" ></label>
                                    <?php
                                    if ($disabled1 != '' || $ass_disabled != '') {
                                        ?>
                                        <input type="hidden" name="recomment" id="recomment" value="<?php echo $feed_back[0]['result']; ?>">
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr class="in-child">
                                <td>
                                    <div id="accept" style="<?php echo $style = ($feed_back[0]['result'] == 'Accept') ? 'display:block' : 'display:none'; ?>" >
                                        <strong>Incubatee Stage</strong>
                                    </div>
                                    <div id="reject" style="<?php echo $style = ($feed_back[0]['result'] == 'Reject') ? 'display:block' : 'display:none'; ?>">
                                        <strong>Reason</strong>
                                    </div>
                                </td>
                                <td>
                                    <div id="accept1" style="<?php echo $style = ($feed_back[0]['result'] == 'Accept') ? 'display:block' : 'display:none'; ?>" >
                                        <select name="stage" id="stage" <?php
                                        echo $disabled1;
                                        echo $ass_disabled;
                                        ?>>
                                            <option value="">-Select Stage-</option>
                                            <option value="Pre-Product" <?php echo (isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' && $innovation['enterprise_stage'] == 'Pre-Product') ? 'selected="selected"' : ''; ?>>Pre-Product</option>
                                            <option value="Pre-Revenue" <?php echo (isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' && $innovation['enterprise_stage'] == 'Pre-Revenue') ? 'selected="selected"' : ''; ?>>Pre-Revenue</option>
                                            <option value="Pre-Scale" <?php echo (isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' && $innovation['enterprise_stage'] == 'Pre-Scale') ? 'selected="selected"' : ''; ?>>Pre-Scale</option>
                                        </select>
                                        <br/><label id="stage_error" ></label>
                                        <?php
                                        if ($disabled1 != '' || $ass_disabled != '') {
                                            ?>
                                            <input type="hidden" name="stage" id="stage" value="<?php echo $innovation['enterprise_stage']; ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="reject1" style="<?php echo $style = ($feed_back[0]['result'] == 'Reject') ? 'display:block' : 'display:none'; ?>">
                                        <select name="reason" id="reason" <?php
                                        echo $disabled1;
                                        echo $ass_disabled;
                                        ?>>
                                            <option value="">-Select Reason-</option>
                                            <?php
                                            foreach ($reasonsList as $list) {
                                                ?>
                                                <option value="<?php echo $list['id']; ?>" <?php echo (isset($feed_back[0]['reject_reason']) && $feed_back[0]['reject_reason'] != '' && $feed_back[0]['reject_reason'] == $list['id']) ? 'selected="selected"' : ''; ?>><?php echo $list['master_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <br/><label id="reason_error" ></label>
                                        <?php
                                        if ($disabled1 != '' || $ass_disabled != '') {
                                            ?>
                                            <input type="hidden" name="reason" id="reason" value="<?php echo $feed_back[0]['reject_reason']; ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="in-child">
                                <td><strong>Comments</strong></td>
                                <td>
                                    <textarea rows="3" name="comments" id="comments" <?php
                                    echo $readonly1;
                                    echo $ass_readonly
                                    ?>><?php echo (isset($feed_back[0]['feed_back'])) ? $feed_back[0]['feed_back'] : ''; ?></textarea>
                                    <input type="hidden" name="innovation_id" id="innovation_id" value="<?php echo $this->uri->segment(3); ?>"/>
                                    <input type="hidden" name="feed_back_id" id="feed_back_id" value="<?php echo (isset($feed_back[0]['id'])) ? $feed_back[0]['id'] : ''; ?>"/>
                                </td>
                            </tr>
                            <tr class="in-child">
                                <td><strong>Upload Document</strong></td>
                                <td>
                                    <input type="file" size="40"  name="user_doc" id="user_doc" class="input-text" value="" onblur="valid_doc('user_doc');" <?php
                                    echo $readonly1;
                                    echo $ass_readonly;
                                    echo $c_pointer;
                                    ?> />
                                           <?php
                                           if ($feed_back[0]['user_document'] != '') {
                                               ?>
                                        <a href="<?php echo base_url() . 'uploads/assessment/' . $feed_back[0]['user_document']; ?>" target="_blank"><?php echo $feed_back[0]['user_document']; ?></a>
                                    <?php } ?>
                                    <input type="hidden" name="user_doc_old" id="user_doc_old" value="<?php echo $feed_back[0]['user_document']; ?>"/>
                                    <br/><span id="user_doc_error"></span>
                                </td>
                            </tr>
                            <?php
// innovation status = 6 -> decision pending
                            $cio_readonly = '';
                            $cio_display = '';
                            $cio_show = '';

                            if (php72_cmp($inno_status) == 3 || php72_cmp($inno_status) == 9 || php72_cmp($inno_status) == 7 || php72_cmp($inno_status) != 6 || (isset($feed_back[0]['cio_status']) && $feed_back[0]['cio_status'] != '')) {
                                $cio_readonly = 'readonly="readonly"';
                                $cio_display = 'disabled="disabled"';
                                $cio_show = 'style="display:none"';
                            }

                            $error_msg = array_unique($error_msg);
                            $assign_users = '';
                            $i = 0;
                            foreach ($error_msg as $id) {
                                if ($i) {
                                    $assign_users .= ", ";
                                }
                                $assign_users .= $this->Massessment->getEmpName($id);
                                $i++;
                            }
                            ?>
                            <input type="hidden" name="assigned_err" id="assigned_err" value="<?php
                            if (isset($assign_users)) {
                                echo $assign_users;
                            }
                            ?>" />
                                   <?php
                                   $enable_iic = 0;
                                   if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $feed_back[0]['result'] == 'Accept') {
                                       $enable_iic = 1;
                                       ?>
                                <tr class="in-child">
                                    <td><strong>Internal IC Recommendation</strong></td>
                                    <td>
                                        <select name="internal_status" id="internal_status" <?php
                                        if ($inno_status == '7' || ($feed_back[0]['internal_status'] != '' && $inno_status != '12') || ($feed_back[0]['internal_status'] != '' && $innovation['stage'] == '12' && $inno_status == '12')) {
                                            echo 'disabled="disabled"';
                                        }
                                        ?>>
                                            <option value="">-Select-</option>
                                            <option value="Accept" <?php echo (isset($feed_back[0]['internal_status']) && $feed_back[0]['internal_status'] != '' && $feed_back[0]['internal_status'] == 'Accept') ? 'selected="selected"' : ''; ?>>Accept</option>
                                            <option value="Reject" <?php echo (isset($feed_back[0]['internal_status']) && $feed_back[0]['internal_status'] != '' && $feed_back[0]['internal_status'] == 'Reject') ? 'selected="selected"' : ''; ?>>Reject & Close</option>
                                        </select>
                                        <br/><label id="internal_status_error" ></label>
                                        <input type="hidden" id="hinternal_status" name="hinternal_status" value="<?php echo $feed_back[0]['internal_status']; ?>">
                                    </td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>Internal IC Date</strong></td>
                                    <td>
                                        <input type="text" name="iic_date" value="<?= $iic_date; ?>" id="iic_date" class="input-text datepicker">
                                    </td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>Internal IC Comments</strong></td>
                                    <td>
                                        <textarea rows="3" name="internal_comment" id="internal_comment" <?php
                                        if (php72_cmp($inno_status) == 7 || ($feed_back[0]['internal_status'] != '' && $inno_status != '12') || ($feed_back[0]['internal_status'] != '' && $innovation['stage'] == '12' && $inno_status == '12')) {
                                            echo 'readonly="readonly"';
                                        }
                                        ?>><?php echo (isset($feed_back[0]['internal_comment'])) ? $feed_back[0]['internal_comment'] : ''; ?></textarea>
                                    </td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>IIC Minutes</strong></td>
                                    <td>
                                        <input type="file" size="40"  name="iic_doc" id="iic_doc" class="input-text" value="" onblur="valid_doc('iic_doc');" <?php
                                        echo $readonly1;
                                        echo $ass_readonly
                                        ?> />
                                               <?php
                                               if ($feed_back[0]['iic_document'] != '') {
                                                   ?>
                                            <a href="<?php echo base_url() . 'uploads/assessment/' . $feed_back[0]['iic_document']; ?>" target="_blank"><?php echo $feed_back[0]['iic_document']; ?></a>
                                        <?php } ?>
                                        <input type="hidden" name="iic_doc_old" id="iic_doc_old" value="<?php echo $feed_back[0]['iic_document']; ?>"/>
                                        <br/><span id="iic_doc_error"></span>
                                    </td>
                                </tr>

                                <?php
                                $ext_style = "none";
                                if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $feed_back[0]['result'] == 'Accept' && $feed_back[0]['internal_status'] == 'Accept') {
                                    $ext_style = "row";
                                }
                                ?>


                                <?php
                            } else if ((!php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && php72_cmp($inno_status) == 7) || $feed_back[0]['internal_status'] != '') {
                                ?>
                                <tr class="in-child">
                                    <td><strong>Internal IC Recommendation</strong></td>
                                    <td><?php echo $feed_back[0]['internal_status']; ?>
                                    </td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>Internal IC Date</strong></td>
                                    <td><?php echo $already_set_iic; ?></td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>Internal IC Comments</strong></td>
                                    <td><?php echo $feed_back[0]['internal_comment']; ?></td>
                                </tr>
                                <tr class="in-child">
                                    <td><strong>ICC Minutes</strong></td>
                                    <td><a href="<?php echo base_url() . 'uploads/assessment/' . $feed_back[0]['iic_document']; ?>" target="_blank"><?php echo $feed_back[0]['iic_document']; ?></a></td>
                                </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <input type="hidden" name="form_type" id="form_type" value="">
                </form>
                <?php
                if ((!php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && php72_cmp($inno_status) == 7) || ($feed_back[0]['internal_status'] != '' && $inno_status != '12') || ($feed_back[0]['internal_status'] != '' && $innovation['stage'] == '12' && $inno_status == '12')) {
                    $display_none = 'style = "display:none"';
                } else {
                    $display_none = '';
                }
                ?>
                <ul class="option-tab">
                    <li><a class="button" id="back" href="<?php echo site_url('assessment/view_list/' . $this->uri->segment('3')); ?>"  >Back</a></li>
                    <li><a class="button save" id="saves" href="javascript:void(0);" <?php echo $display1; ?> <?php echo $display_none; ?>>Save</a></li>
                    <li><a class="button submit" id="submit" href="javascript:void(0);" <?php echo $display1; ?> <?php echo $display_none; ?>>Submit</a></li>

                </ul>
                <?php
// innovation status = 6 -> decision pending
                if ($this->session->userdata('emp_number') == $cio_emp_num && $inno_status == '6' && isset($feed_back[0]['result']) && $feed_back[0]['result'] == 'Accept') {
                    ?>
                    <ul class="option-tab">
                        <li><a class="button save" id="saves" href="javascript:void(0);" <?php echo $cio_show; ?> >Save</a></li>
                        <li><a class="button ciosubmit" id="submit" href="javascript:void(0);" <?php echo $cio_show; ?> >Submit</a></li>
                    </ul>
                <?php }
                ?>
            </section>
        </section>
    </section>
</div>
<input type="hidden" id="scoring_count" value="<?= $get_score[0]['score_entered']; ?>">
<input type="hidden" id="iic_doc_count" value="<?= $enable_iic; ?>">

<div style="display:none;">
    <div align="center" id="status_log" style="width:800px; height:400px;" >

        <h1 class="text-left reduce_space">Application Status Log - Deals</h1>

        <table style="width:100%" id="table1" class="gtable sortable">
            <thead style="border-bottom: 2px solid #ccc;">
                <tr>
                    <th style="padding:5px;text-align: left;">Date</th>
                    <th style="padding:5px;text-align: left;">Time</th>
                    <th style="padding:5px;text-align: left;">Assigned Incharge</th>
                    <th style="padding:5px;text-align: left;">Updated By</th>
                    <th style="padding:5px;text-align: left;">Deal Stage</th>
                    <th style="padding:5px;text-align: left;">Deal Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($log_details as $row) {
                    $date = date('d-m-Y', strtotime($row['modified_date']));
                    $time = date('h:i:s a', strtotime($row['modified_date']));

                    $stage = $this->Minnovation->getInnvationStage();
                    $status = $this->Minnovation->getInnvationStatus();
                    $status_text = $status[$row['status']];
                    $stage_text = $stage[$row['stage']];
                    ?>


                    <tr>

                        <?php
                        if ($row['reason'] != '') {
                            ?>
                            <td colspan="6" style="padding:5px;text-align:center;font-weight:bold;"><?php echo $row['reason']; ?></td>
                            <?php
                        } else {
                            ?>

                            <td style="padding:5px;"><?php echo $date; ?></td>
                            <td style="padding:5px;"><?php echo $time; ?></td>
                            <td style="padding:5px;"><?php echo $row['assigned_incharge']; ?></td>
                            <td style="padding:5px;"><?php
                                if ($row['modified_by_user']) {
                                    echo $row['modified_by_user'];
                                } else {
                                    echo 'Admin';
                                }
                                ?></td>
                            <td style="padding:5px;"><?php echo $stage_text; ?></td>
                            <td style="padding:5px;"><?php echo $status_text; ?></td>

                            <?php
                        }
                        ?>

                    </tr>


                    <?php
                }
                ?>
            </tbody>
        </table>

    </div>
</div>
<style type="text/css">
    .triggerBtn{
        font-size:14px;
    }
    .mailTrigger {
        font-size: 14px;
        text-align:left;
        margin-bottom:0px;
    }
    .mailTriggerHead{
        font-size: 14px;
        text-align:left;
        margin-bottom:10px;
        font-weight:600;
    }
    #total_score_assign, #total_per_assign, #comment{
        background-color: rgb(235, 235, 228);
        color: rgb(84, 84, 84);
    }
    .text-left{
        text-align:left !important;
    }
    .reduce_space{
        width:95%;
    }
</style>

<script type="text/javascript">
    var stage = "<?php echo $innovation['stage']; ?>";
    if (stage != '8') {
        $("#assess_summary :input").attr("disabled", true);
    }
</script>