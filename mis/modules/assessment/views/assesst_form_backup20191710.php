
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/grid.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/chosen.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/jquery.fancybox.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/datatables.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/mystyle.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/misstylesheet.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/green.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/style.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "source/pre_assesst/css/styles.css"; ?>"/>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . "source/pre_assesst/js/jquery.fancybox.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "source/pre_assesst/js/simpletreemenu.js"; ?>"></script>
<link type="text/css" href="<?php echo base_url(); ?>source/jquery_ui/css/south-street/ui.multiselect.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>source/jquery_ui/css/south-street/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>source/jquery_ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>source/jquery_ui/js/ui.multiselect.js"></script>
<script type="text/javascript">
    function export_xl()
    {
        var htmltable = document.getElementById('export_table');
        var html = htmltable.outerHTML;
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    }
    $(document).ready(function () {
        setTotal();
        $('.select_box').change(function () {
            if ($(this).val() != '')
            {
                $(this).siblings(".error").text('');
            }
        });
        $('.checkbox').change(function () {
            $('.score').keyup(function () {
                var this_value = $(this).val();
                if (this_value > 3) {
                    alert("You can't add greater than three");
                    $(this).val('');
                    var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                    $('.child-' + parent_html).each(function () {
                        var input_value = $(this).find(".pre-input").attr("type");
                        if (input_value == 'text') {
                            $(this).find(".pre-input").val('');
                        }
                    });
                } else {
                    var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                    $('.child-' + parent_html).each(function () {
                        var input_value = $(this).find(".pre-input").attr("type");
                        if (input_value == 'text') {
                            $(this).find(".pre-input").val(this_value);
                        }
                    });
                }

            });

            var select = '#reason' + $(this).val();
            var input = '#sub' + $(this).val();
            var reas = '#reasonerror' + $(this).val();
            $(select).toggle(this.checked);

            if ($(this).is(':checked')) {
                var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                $(this).parent().parent().find(".score").attr("readonly", "readonly");
                $('.child-' + parent_html).each(function () {
                    var input_value = $(this).find(".pre-input").attr("type");
                    if (input_value == 'text') {
                        $(this).find(".pre-input").val('');
                        $(this).find(".pre-input").attr("readonly", "readonly");
                        $(this).find(".pre-input").prop('checked', true);
                    }
                });
            } else {
                var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                $(this).parent().parent().find(".score").removeAttr("readonly");
                $('.child-' + parent_html).each(function () {
                    var input_value = $(this).find(".pre-input").attr("type");
                    if (input_value == 'text') {
                        $(this).find(".pre-input").removeAttr("readonly");
                        $(this).find(".pre-input").prop('checked', false);
                    }
                });
                ;
            }
            $('.area').keyup();
        });
        $('.score').keyup(function () {
            var this_value = $(this).val();
            if (this_value > 3) {
                alert("You can't add greater than three");
                $(this).val('');
                var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                $('.child-' + parent_html).each(function () {
                    var input_value = $(this).find(".pre-input").attr("type");
                    if (input_value == 'text') {
                        $(this).find(".pre-input").val('');
                    }
                });
            } else {
                var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                $('.child-' + parent_html).each(function () {
                    var input_value = $(this).find(".pre-input").attr("type");
                    if (input_value == 'text') {
                        $(this).find(".pre-input").val(this_value);
                    }
                });
            }

        });
        $("#assessor_employee").multiselect();
        var original = $('#asset_form').serialize();

        $('.fancybox').fancybox();
        $(function () {
            $('.firstDiv').click(function () {
                $('tr.parent').css("cursor", "pointer")
                .attr("title", "Click to expand/collapse")
                .siblings('.child-' + this.id).toggle('300');
            });

            $('tr.in-child')
            .css("cursor", "pointer")
            .attr("title", "Click to expand/collapse")
            .click(function () {
                $(this).siblings('.child-' + this.id).toggle();
            });
        });

        /*--------Key up function for validation of score values between 0 and 3 and
        fetching total score and total score percentage values---------*/
        $(".area").keyup(function () {
            var area_id = $(this).siblings("#area_id").val();
            var sub_count = $(this).siblings("#sub_count").val();
            var sub = 0;
            var count_sub = empty_count = 0;
            for (var i = 1; i <= sub_count; i++)
            {
                if ($("#sub" + area_id + '_' + i).val() != '' && !$.isNumeric($("#sub" + area_id + '_' + i).val()))
                {
                    $("#sub" + area_id + '_' + i).focus();
                    var len = $("#sub" + area_id + '_' + i).val().length;
                    var str = $("#sub" + area_id + '_' + i).val().substring(0, len - 1);
                    $("#sub" + area_id + '_' + i).val(str);
                } else
                {
                    if (parseInt($("#sub" + area_id + '_' + i).val()) > 3)
                    {
                        $("#sub" + area_id + '_' + i).focus();
                        $("#suberror" + area_id + '_' + i).html("Enter number between 0 to 3").show().css('color', 'red');
                    } else
                    {
                        if ($("#sub" + area_id + '_' + i).val() != '')
                        {
                            var val = $("#sub" + area_id + '_' + i).val();
                            sub = parseFloat(sub) + parseFloat(val);
                        }
                        if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                            count_sub = parseInt(count_sub) + 1;
                        else
                            empty_count = empty_count + 1;
                        $("#suberror" + area_id + '_' + i).html("");
                    }
                }
            }

            var avg = '';
            if (sub == 0 && sub_count != empty_count)
                avg = 0;
            if (sub != 0 && count_sub != 0)
                avg = (sub / count_sub)
            if (avg % 1)
                avg = avg.toFixed(2);

            $("#score_" + area_id).val(avg);

            var total = 0;
            $('.score').each(function () {
                var val = ($(this).val() != '') ? $(this).val() : 0;
                total = parseFloat(total) + parseFloat(val);
            });


            var count_sub = 0;
            var sub_val = 0;
            var pre_area = 0;
            $('.area').each(function () {
                var area_id = $(this).siblings("#area_id").val();
                if (pre_area != area_id) {
                    var sub_count1 = $(this).siblings("#sub_count").val();
                    for (var i = 1; i <= sub_count1; i++)
                    {
                        if ($("#sub" + area_id + '_' + i).val() != '')
                        {
                            sub_val = parseFloat($("#sub" + area_id + '_' + i).val()) + sub_val;
                        }
                        if ($("#sub" + area_id + '_' + i).val() != '')
                            count_sub = parseInt(count_sub) + 1;
                    }
                }
                pre_area = area_id;

            });

            total = (total != 'NaN') ? total : '';

            if (total != '')
                total = total.toFixed(2);

            if (total != '') {
                $("#total_score").val(total);
            } else {
                $("#total_score").val('0');
            }

            /*-----Calculation for total score percentage-----*/
            var tot_count1 = parseInt(count_sub) * 3;
            total_per = 0;
            total_per = (sub_val / tot_count1) * 100;
            total_per = total_per.toFixed(2);
            if (total_per != '') {
                if (isNaN(total_per)) {
                    $("#total_per").val('0');
                } else {
                    $("#total_per").val(total_per);
                }
            }

        });

        $("#total_score, #total_per").focus(function () {
            var total = 0;
            $('.score').each(function () {
                var val = ($(this).val() != '') ? $(this).val() : 0;
                total = parseFloat(total) + parseFloat(val);
            });
            total = (total != 'NaN') ? total : '';
            if (total != '' && total != 'NaN') {
                total = total.toFixed(2);
                $("#total_score").val(total);
            }

            var count_sub = 0;
            var sub_val = 0;
            var pre_area = 0;
            $('.area').each(function () {
                var area_id = $(this).siblings("#area_id").val();
                if (pre_area != area_id) {
                    var sub_count1 = $(this).siblings("#sub_count").val();
                    for (var i = 1; i <= sub_count1; i++)
                    {
                        if ($("#sub" + area_id + '_' + i).val() != '')
                        {
                            sub_val = parseFloat($("#sub" + area_id + '_' + i).val()) + sub_val;
                        }
                        if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                            count_sub = parseInt(count_sub) + 1;
                    }
                }
                pre_area = area_id;

            });
            var tot_count1 = parseInt(count_sub) * 3;
            total_per = 0;
            total_per = (sub_val / tot_count1) * 100;
            total_per = total_per.toFixed(2);
            if (total_per != '')
                $("#total_per").val(total_per);
        });

        $(".save").click(function () {
            $('.area').each(function () {
                var area_id = $(this).siblings("#area_id").val();
                var sub_count = $(this).siblings("#sub_count").val();
                var sub = count_sub = empty_count = 0;
                for (var i = 1; i <= sub_count; i++) {
                    if ($("#check" + area_id + '_' + i).is(':checked')) {
                        // alert("#check" + area_id + '_' + i);
                        if ($("#reason" + area_id + '_' + i).val() == '') {
                            $("#reasonerror" + area_id + '_' + i).html("Please select a reason").show().css('color', 'red');
                            location.href = "#reason" + area_id + '_' + i;
                        } else {
                            $("#reasonerror" + area_id + '_' + i).html("");
                        }
                    } else {
                        if ($("#sub" + area_id + '_' + i).val() != '' && !$.isNumeric($("#sub" + area_id + '_' + i).val())) {
                            $("#sub" + area_id + '_' + i).focus();
                            var len = $("#sub" + area_id + '_' + i).val().length;
                            var str = $("#sub" + area_id + '_' + i).val().substring(0, len - 1);
                            $("#sub" + area_id + '_' + i).val(str);
                        } else {
                            if (parseInt($("#sub" + area_id + '_' + i).val()) > 3) {
                                $("#sub" + area_id + '_' + i).focus();
                                $("#suberror" + area_id + '_' + i).html("Enter number between 0 to 3").show().css('color', 'red');
                            } else {
                                var val = ($("#sub" + area_id + '_' + i).val() != '') ? $("#sub" + area_id + '_' + i).val() : 0;
                                sub = parseFloat(sub) + parseFloat(val);
                                if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                                    count_sub = parseInt(count_sub) + 1;
                                else
                                    empty_count = empty_count + 1;
                                $("#suberror" + area_id + '_' + i).html("");
                            }
                        }
                    }
                }
            });
            var tot_in = $("input:visible").length;

            var empty = 0;
            $("input:visible").each(function () {
                if ($(this).val() == '')
                    empty = empty + 1;
            });

            if (empty == tot_in)
                alert("Enter Incubatee Score to submit");
            else {
                var errorval = 0;
                var total = 0;
                $('.score').each(function () {
                    var val = ($(this).val() != '') ? $(this).val() : 0;
                    total = parseFloat(total) + parseFloat(val);
                });
                total = (total != 'NaN') ? total : '';
                if (total != '' && total != 'NaN')
                    $("#total_score").val(total);

                var count_sub = 0;
                var sub_val = 0;
                var pre_area = 0;
                $('.area').each(function () {
                    var area_id = $(this).siblings("#area_id").val();
                    if (pre_area != area_id) {
                        var sub_count1 = $(this).siblings("#sub_count").val();
                        for (var i = 1; i <= sub_count1; i++)
                        {
                            if ($("#sub" + area_id + '_' + i).val() != '')
                            {
                                sub_val = parseFloat($("#sub" + area_id + '_' + i).val()) + sub_val;

                            }
                            if ($("#sub" + area_id + '_' + i).val() != '') // || $("#check"+area_id+'_'+i).is(':checked'))
                                count_sub = parseInt(count_sub) + 1;
                        }
                    }
                    pre_area = area_id;
                });

                var tot_count1 = parseInt(count_sub) * 3;
                total_per = 0;
                total_per = (sub_val / tot_count1) * 100;
                total_per = total_per.toFixed(2);

                if (total_per != '')
                    $("#total_per").val(total_per);

                $('.error').each(function () {
                    if ($('.error').text() != '')
                        errorval = errorval + 1;
                });
                if (errorval == 0) {
                    $("#asset_form").submit();
                }
            }
        });
});

function chooseReason(id, select) {
    $('.dropCheck_' + id).val(select);
}

function checkAll(id) {
    var box_name = $('.allCheck_' + id);
    if (box_name.is(':checked')) {
        $('.selCheck_' + id).attr('checked');
        $('.dropCheck_' + id).css('display', 'block');
    } else {
        $('.selCheck_' + id).removeAttr('checked');
        $('.dropCheck_' + id).css('display', 'none');
    }
}

function individualBox(area, id) {
    var box_name = $('#check' + area + '_' + id);
    if (box_name.is(':checked')) {
        $('#reason' + area + '_' + id).css('display', 'block');
    } else {
        $('#reason' + area + '_' + id).css('display', 'none');
    }
}

$(document).on('keyup', '.area', function () {
    setTotal();
});

function setTotal() {
    var scoreVal = '';
    $(".area").each(function () {
        var assign_score = $(this).val();
        if (assign_score != 'NaN' && assign_score != '')
            scoreVal += parseFloat(assign_score);
    });

    if (scoreVal == '') {
        $("#total_score").val('');
    }
}

</script>
<style type="text/css">
    .fancybox-custom .fancybox-skin {
        box-shadow: 0 0 50px #222;
    }
</style>
<?php
if ($inno_status != '3' && $inno_status != '9' && $inno_status != '7' && !isset($feed_back) && !$feed_back['cio_status'] == 'Accept') {
    $readonly = '';
    $disabled = '';
    $display = '';
} else {
    $readonly = "readonly='readonly'";
    $disabled = 'disabled="disabled"';
    $display = 'style = "display:none"';
}

if ($inno_status != '3' && $inno_status != '9' && $inno_status != '7' && php72_in_array($this->session->userdata('emp_number'), $assigned_incharge)) {
    $readonly = '';
    $disabled = '';
    $display = '';
}
?>
<!-- Assign Assessor popup -->
<div id="add" style="width:500px;display: none;">
    <h1>Add Assessors</h1>
    <table class="gtable detailtable">
        <thead>
            <?php
            if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && ($inno_status == '3' || $inno_status == '9' )) {
                ?>
                <tr>
                    <th>Assessor</th>
                    <th>Status</th>
                </tr>
            <?php } ?>
        </thead>
        <tbody>

            <?php
            $restrict = array();
            $employee1 = array();
            if (!empty($assessors)) {
                $status = unserialize($assessors[0]['status']);

                $employee = unserialize($assessors[0]['assessor_id']);
                $i = 0;
                foreach ($status as $stat) {
                    if ($status[$i] == '1')
                        $employee1[] = $employee[$i];

                    $restrict[] = $employee[$i];
                    ?>
                    <?php
                    if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && ($inno_status == '3' || $inno_status == '9' )) {
                        ?>
                        <tr>
                            <td><?php echo Massessment::getEmployeeName($employee[$i]); ?></td>
                            <td>
                                <?php
                                echo ($status[$i] == 1) ? 'Active' : 'InActive';
                                ?></td>
                                </tr><?php } ?>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge) && $inno_status != '3' && $inno_status != '9') {
                    ?>
                    <script type="text/javascript">
                        function validate()
                        {
                            if (!$("#assessor_employee option:selected").length)
                            {
                                $("#assign_error").html("Select atleast one assessor").css('color', 'red').show();
                                return false;
                            } else
                            {
                                $("#assign_error").html("");
                                return true;
                            }

                        }

                        function close_fancy_box()
                        {
                            $.fancybox.close()
                        }
                    </script>
                    <form name="assignAssessor" enctype="multipart/form-data" action="<?= site_url('assessment/assign_assessor/'); ?>" method="post" id="assignAssessor" class="uniform" onsubmit="return validate();"  >
                        <table style="margin-left: 10px;">
                            <tr><td>Employee:<font color="red">*</font></td></tr>
                            <tr><td>
                                <?php
                        //$assessor_employee = isset($_REQUEST["assessor_employee"])?$_REQUEST["assessor_employee"]:array();
                                $assessor_employee = isset($_REQUEST["assessor_employee"]) ? $_REQUEST["assessor_employee"] : $employee1;
                                ?>

                                <select id="assessor_employee" class="multiselect" multiple="multiple" name="assessor_employee[]" style="height:100px;width:485px;" >
                                    <?php
                                    foreach ($emplist as $row) {
                                        if (!php72_in_array($row['emp_number'], $assigned_incharge)) {
                                            ?>
                                            <option value="<?= $row['emp_number'] ?>" <?php
                                            if (php72_in_array($row['emp_number'], $assessor_employee)) {
                                                echo 'selected="selected"';
                                            }
                                            ?>><?= $row['emp_name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>

                                </select>
                                <span id="assign_error"></span>
                                <?php echo form_error('report_data', '<div class="errorMsg">', '</div>'); ?>
                            </td></tr>
                        </table>
                        <div class="buttons" style="margin: 10px 0 10px 38%;">
                            <input type="hidden" name="innovations" id="innovations" value="<?php echo $this->uri->segment('3'); ?>"/>
                            <input type="submit" value="Add" name="txtSubmit" class="button" />
                            <input type="button" value="Cancel" name="txtCancel" onclick="close_fancy_box();" class="button" />
                        </div>
                    </form>
                <?php } ?>
            </div>

            <!-- Assign Assessor Ends -->

            <section style="overfolw:visible" id="content">
                <section style="overfolw:visible;margin-left:0px!important;width:100%!important" class="clearfix">
                    <section style="overfolw:visible" class="grid_12" id="main">
                        <h1><?= $innovation['name_of_enterprise'] ?> - Preliminary Assessment</h1>
                        <ul class="option-tab">
                            <li><a id="logStatusModal" class="fancybox button" href="#status_log" style="cursor:pointer;">Application Status Log</a></li>
                            <li><a class="button" href="<?php echo site_url('assessment/view_assesst/' . $this->uri->segment(3) . '/export'); ?>">Download</a></li>
                            <?php
                            if (php72_in_array($this->session->userdata('emp_number'), $assigned_incharge)) {
                                ?>
                                <li><a class="button fancybox" id="" href="#add">Add Assessors</a></li>
                            <?php } ?>
                            <li><a role="button" tabindex="0" class="button save" id="save" aria-controls="table1" <?php echo $display; ?>>Save</a></li>
                            <li><a class="button next" id="table_next" href="<?php echo site_url('assessment/assess_summary/' . $this->uri->segment(3)); ?>">Next</a></li>
                        </ul>
                        <div class="clearfix"></div>

                        <div style="font-size:24px;">
                            <a id="openCollapse" style="color:#8cb928;cursor:pointer;"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <a id="closeCollapse" style="color:#8cb928;"><i class="fa fa-minus-circle" aria-hidden="true"></i></i></a>
                        </div>

                        <div class="table-tree">
                            <!-- Table view for assesst score details form -->
                            <table class="tree" width="100%" cellpadding="0" cellspacing="0" id="export_table">
                                <form name="asset_form" id="asset_form" action="<?php echo site_url('assessment/store_assesst'); ?>" method="post" autocomplete="off">
                                    <tr>
                                        <th width="90">Area</th>
                                        <th width="90">Incubatee Score</th>
                                        <th width="115">NA</th>
                                        <th width="80">No - 0</th>
                                        <th width="80">Low - 1</th>
                                        <th width="70">Medium - 2</th>
                                        <th width="80">High - 3</th>
                                    </tr>
                                    <?php
                                    /* ----- Unserializing the assesst details ----- */
                                    if (isset($assesst)) {
                                        $area_id = unserialize($assesst[0]['area_id']);
                                        $score = unserialize($assesst[0]['score']);
                                        $rational = unserialize($assesst[0]['rational']);
                                        $risk = unserialize($assesst[0]['risk']);
                                    }
                                    $count_area = php72_count($area);
                        // echo '<pre>';
                        // print_r($area);
                        // $i=1;
                                    foreach ($area as $area) {
                                        $i = isset($i) && $i != '' ? $i : 1;
                                        ?>
                                        <tr class="parent">
                                            <td class='firstDiv' style="cursor:pointer;" id="row<?php echo $area['id']; ?>"><strong><?php echo $area['Name']; ?></strong></td>
                                            <td>
                                                <input type="text" class="pre-input score area" style="width:70px" name="score[<?php echo $area['id']; ?>]" id="score_<?php echo $area['id']; ?>"  value="<?php
                                                if (isset($score[$area['id']])) {
                                                    echo $score[$area['id']];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>" />
                                                    <input type="hidden" name="area_count" id="area_count" value="<?php echo $count_area; ?>">
                                                    <input type="hidden" name="area_id[]" id="area" value="<?php echo $area['id']; ?>">
                                                </td>
                                                <td>
                                                    <?php
                                                    $sub_category1 = $this->Massessment->getSubCategory($area['id']);

                                                    if (isset($sub_assesst)) {
                                                        foreach ($sub_assesst as $sub) {
                                                            if ($area['id'] == $sub['area_id']) {
                                                                $category_id1 = unserialize($sub['sub_category']);
                                                                $sub_score = unserialize($sub['sub_score']);
                                                            }
                                                        }
                                                    }
                                                    $area_subscore = '';
                                                    foreach ($sub_category1 as $sub) {
                                                        if (isset($category_id1) && php72_in_array($sub['id'], $category_id1)) {
                                                            $key = php72_array_search($sub['id'], $category_id1);
                                                            if ($sub_score[$key] == '-1') {
                                                                $area_subscore = $sub_score[$key];
                                                            }
                                                        }
                                                    }


                                                    $checked = ($area_subscore == '-1') ? "checked" : "";
                                                    $display1 = ($area_subscore != '-1') ? "style='display:none'" : "";
                                                    ?>
                                                    <input <?php echo $disabled; ?> type="checkbox" onclick="checkAll('<?php echo $area['id']; ?>')" <?php echo $checked ?> name="check[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="check<?php echo $area['id']; ?>_<?php echo $i; ?>" value="<?php echo $area['id']; ?>_<?php echo $i; ?>" class="pre-input checkbox allCheck_<?php echo $area['id']; ?>"/>
                                                    <select <?php echo $disabled; ?> class="select_box" name="reason[<?php echo $area['id']; ?>_<?php echo $i; ?>]" onchange="chooseReason('<?php echo $area['id']; ?>', this.value);" id="reason<?php echo $area['id']; ?>_<?php echo $i; ?>" <?php echo $display1; ?>>
                                                        <option value="">--Select Reason--</option>
                                                        <?php
                                                        foreach ($reasons as $re) {
                                                            $selectsd = ($addscore == $re['id']) ? "selected" : "";
                                                            $selectbox_id = $re['id'];
                                                            echo "<option " . $selectsd . " value=" . $re['id'] . ">" . $re['name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <br>
                                                    <label class="error" style="display:none" name="reasonerror<?php echo $area['id']; ?>_<?php echo $i; ?>" id="reasonerror<?php echo $area['id']; ?>_<?php echo $i; ?>"></label>
                                                </td>
                                                <?php if ($innovation['program'] == '3') { ?>
                                                    <!-- Fetching db comments for values between 0 and 3 for pitch application -->
                                                    <td><?php echo nl2br($area['no']); ?></td>
                                                    <td><?php echo nl2br($area['low']); ?></td>
                                                    <td><?php echo nl2br($area['medium']); ?></td>
                                                    <td><?php echo nl2br($area['high']); ?></td>
                                                <?php } else { ?>
                                                    <!-- Fetching db comments for values between 0 and 3 for incubation application -->
                                                    <td class="lastDiv" colspan="4">&nbsp;</td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                            $r = 1;
                                            $sub_category = $this->Massessment->getSubCategory($area['id']);
                                            $sub_count = php72_count($sub_category);
                                            $i = 0;
                                            if (isset($sub_assesst)) {
                                                foreach ($sub_assesst as $sub) {
                                                    if ($area['id'] == $sub['area_id']) {
                                                        $category_id = unserialize($sub['sub_category']);
                                                        $sub_score = unserialize($sub['sub_score']);
                                                        $add_score = unserialize($sub['add_score']);
                                                    }
                                                }
                                            }
                                            foreach ($sub_category as $sub) {
                                                if (isset($category_id) && php72_in_array($sub['id'], $category_id)) {
                                                    $key = php72_array_search($sub['id'], $category_id);
                                                    $subscore = $sub_score[$key];
                                                    $addscore = $add_score[$key];
                                                }
                                                $i++;
                                                $r++;
                                                ?>
                                                <tr class="child-row<?php echo $area['id']; ?> in-child" style="display:none;">
                                                    <td><?php echo $sub['category']; ?></td>
                                                    <td>
                                                        <input type="text" class="pre-input area" style="width:70px" name="sub[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="sub<?php echo $area['id']; ?>_<?php echo $i; ?>" value="<?php
                                                        if (isset($subscore) && $subscore != '-1') {
                                                            echo $subscore;
                                                            } else {
                                                                echo "";
                                                            }
                                                            ?>" <?php if ($subscore == '-1') echo "readonly"; ?> <?php echo $readonly; ?> />
                                                            <input type="hidden" name="sub_count[<?php echo $area['id']; ?>]" id="sub_count" value="<?php echo $sub_count; ?>">
                                                            <input  type="hidden" name="category_id[<?php echo $area['id']; ?>_<?php echo $i; ?>]" id="category_id<?php echo $area['id']; ?>_<?php echo $i; ?>" value="<?php echo $sub['id']; ?>">
                                                            <input type="hidden" name="area" id="area_id" value="<?php echo $area['id']; ?>">
                                                            <br/><label class="error" style="display:none" name="suberror<?php echo $area['id']; ?>_<?php echo $i; ?>" id="suberror<?php echo $area['id']; ?>_<?php echo $i; ?>"></label>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $checked = ($subscore == '-1') ? "checked" : "";
                                                            $display1 = ($subscore != '-1') ? "style='display:none'" : "";
                                                            ?>
                                                            <input <?php echo $disabled; ?> type="checkbox" onclick="individualBox('<?php echo $area['id']; ?>', '<?php echo $r; ?>')" <?php echo $checked ?> name="check[<?php echo $area['id']; ?>_<?php echo $r; ?>]" id="check<?php echo $area['id']; ?>_<?php echo $r; ?>" value="<?php echo $area['id']; ?>_<?php echo $r; ?>" class="pre-input checkbox selCheck_<?php echo $area['id']; ?>"/>
                                                            <select <?php echo $disabled; ?> class="select_box dropCheck_<?php echo $area['id']; ?>" name="reason[<?php echo $area['id']; ?>_<?php echo $r; ?>]" id="reason<?php echo $area['id']; ?>_<?php echo $r; ?>" <?php echo $display1; ?>>
                                                                <option value="">--Select Reason--</option>
                                                                <?php
                                                                foreach ($reasons as $re) {
                                                                    $selectsd = ($addscore == $re['id']) ? "selected" : "";
                                                                    echo "<option " . $selectsd . " value=" . $re['id'] . ">" . $re['name'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <br>
                                                            <label class="error" style="display:none" name="reasonerror<?php echo $area['id']; ?>_<?php echo $r; ?>" id="reasonerror<?php echo $area['id']; ?>_<?php echo $r; ?>"></label>
                                                        </td>
                                                        <td><?php echo $sub['no']; ?></td>
                                                        <td><?php echo $sub['low']; ?></td>
                                                        <td><?php echo $sub['medium']; ?></td>
                                                        <td><?php echo $sub['high']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr class="child-row<?php echo $area['id']; ?> in-child" style="background: none repeat scroll 0 0 #E7F9CF; display:none;">
                                                    <td><strong>Rationale</strong></td>
                                                    <td colspan="2"><textarea class="pre-input" cols="30"  rows="3" name="rational[<?php echo $area['id']; ?>]" id="rational_<?php echo $area['id']; ?>" <?php echo $readonly; ?> ><?php
                                                    if (isset($rational[$area['id']])) {
                                                        echo $rational[$area['id']];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?></textarea></td>
                                                    <td><strong>Risk</strong></td>
                                                    <td colspan="2"><textarea class="pre-input" cols="30" rows="3" name="risk[<?php echo $area['id']; ?>]" id="risk_<?php echo $area['id']; ?>" <?php echo $readonly; ?>><?php
                                                    if (isset($risk[$area['id']])) {
                                                        echo $risk[$area['id']];
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?></textarea></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            <?php }
                                            ?>

                                            <tr class="parent" id="rowtotal">
                                                <td><strong>Total</strong></td>
                                                <td>
                                                    <input type="text" class="pre-input" style="width:70px" name="total_score" id="total_score" value="<?php
                                                    if (isset($assesst[0]['total_score'])) {
                                                        echo $assesst[0]['total_score'];
                                                        } else {
                                                            echo "";
                                                        }
                                                        ?>" readonly=""/>
                                                        <input type="hidden" name="innovation_id" id="innovation_id" value="<?php echo $this->uri->segment('3'); ?>">
                                                        <input type="hidden" name="assesst_id" id="assesst_id" value="<?php
                                                        if (isset($assesst[0]['id'])) {
                                                            echo $assesst[0]['id'];
                                                            } else {
                                                                echo "";
                                                            }
                                                            ?>">
                                                        </td>
                                                        <td><strong>Total %</strong></td>
                                                        <td>
                                                            <input type="text" class="pre-input" style="width:70px" name="total_per" id="total_per" value="<?php
                                                            if (isset($assesst[0]['total_per'])) {
                                                                echo $assesst[0]['total_per'];
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?>" readonly=""/>
                                                            </td>
                                                            <td colspan="3">&nbsp;</td>
                                                            <tr>
                                                                <td colspan="5"><textarea class="text-area-comment" rows="4" cols="100" name="comment" id="comment" placeholder="Comments" ><?php
                                                                if (isset($assesst[0]['comment'])) {
                                                                    echo $assesst[0]['comment'];
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?></textarea>
                                                                <td colspan="2">
                                                                    <div class="dataTables_paginate paging_two_button" id="table1_paginate">
                                                                        <a role="button" tabindex="0" class="button save" id="save" aria-controls="table1" <?php echo $display; ?>>Save</a>
                                                                        <a href="<?php echo site_url('assessment/assess_summary/' . $this->uri->segment(3)); ?>" role="button" tabindex="0" class="button next" id="table1_next" aria-controls="table1">Next</a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tr>
                                                    </form>
                                                </table>
                                            </div>

                                        </section>
                                    </section>
                                </section>


                                <div style="display:none;">
                                    <div align="center" id="status_log" style="width:800px; height:400px;" >

                                        <h1 class="text-left reduce_space">Application Status Log - Deals </h1>

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
                                                            if ($row['modified_by_user'])
                                                                echo $row['modified_by_user'];
                                                            else
                                                                echo 'Admin';
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
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('#closeCollapse').hide();
                                    });
                                    $("#openCollapse").on('click', function () {
                                        $('#openCollapse').hide();
                                        $('#closeCollapse').show();
                                        $('.child-row1, .child-row2, .child-row3, .child-row4, .child-row5, .child-row6, .child-row7, .child-row8, .child-row9, .child-row10, .child-row11').show();
                                    });
                                    $("#closeCollapse").on('click', function () {
                                        $('#closeCollapse').hide();
                                        $('#openCollapse').show();
                                        $('.child-row1, .child-row2, .child-row3, .child-row4, .child-row5, .child-row6, .child-row7, .child-row8, .child-row9, .child-row10, .child-row11').hide();
                                    });
                                </script>
                                <style type="text/css">
                                    #total_score, #total_per {
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
                                <?PHP ?>
                                <script type="text/javascript">

                                    $(".score").on("input", function (evt) {
                                        var self = $(this);
                                        self.val(self.val().replace(/[^0-9.]/g, ''));
                                    });

                                    $(document).ready(function () {
                                        var program = "<?php echo $innovation['program']; ?>";
                                        var selectbox_id = "<?php echo $selectbox_id; ?>";
                                        var stage = "<?php echo $innovation['stage']; ?>";
                                        var pitch_deal_id = "<?php echo $innovation['id']; ?>";

                                        if (stage != '8') {
                                            $(".area").each(function () {
                                                $(".score").attr("readonly", "readonly");
                                                $(".pre-input").attr("readonly", "readonly");
                                                $(".checkbox").attr("disabled", true);
                                            });
                                        }

                                        if (program == '3' && pitch_deal_id != '16036' && pitch_deal_id != '14253') {
                                            $('#check8_4, #check9_1, #check10_1').prop('checked', true);
                                            $('#check8_4, #check9_1, #check10_1').attr("disabled", true);
                                            $('#check8_4, #check9_1, #check10_1').each(function () {
                                                if ($(this).is(':checked')) {
                                                    var parent_html = $(this).parent().parent().find(".firstDiv").attr("id");
                                                    $(this).parent().parent().find(".select_box").css({display: "inline-block"});
                                                    $(this).parent().parent().find(".select_box").val(selectbox_id);
                                                    $(this).parent().parent().find(".select_box").attr("disabled", true);
                                                    $(this).parent().parent().find(".score").attr("readonly", "readonly");
                                                    $('.child-' + parent_html).each(function () {
                                                        var input_value = $(this).find(".pre-input").attr("type");
                                                        if (input_value == 'text') {
                                                            $(this).find(".pre-input").val('');
                                                            $(this).find(".pre-input").attr("readonly", "readonly");
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });

                                </script>