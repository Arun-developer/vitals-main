<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - No Due Certificate')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'nodue')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content" <?php
            if ($certificate != 'yes') {
                echo 'style="height: 950px;"';
            }
            ?> >
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <h4>No Due Certificate</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <form name="emp_form" id="emp_form" action="" method="POST">
                        <div class="row v_m_e_search">
                            <div class="col-xl-7 col-lg-7 col-md-12 col-12 ">
                                <ul class="vitals-links">
                                    <li><label>Employee</label></li>
                                    <li>
                                        <div class="form-group mar-bt8 wdt_180">
                                            <select class="form-control wdt_180" id="employee_ud" name="employee_id">
                                                <option value=''>Search</option>
                                                <?php foreach ($userList as $list) { ?>
                                                    <option value="<?= $list['id'] ?>" <?php echo ($employee_id == $list['id']) ? ('selected') : (''); ?>><?= $list['user_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="pad-lt15px">
                                        <div class="form-group ">
                                            <a href="javascript:void(0)" onclick="submit_empform()" class="vital_yellow_btn pad-hr15">Generate</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <input type="hidden" name="generate" />
                    </form>
                    <?php if ($certificate == 'yes') { ?>
                        <div class="row">
                            <div class="col-12 col-lg-12 col-md-12 ">
                                <div class="nocertificate">
                                    <p align="right" style="cursor:pointer"><strong><u>
                                                <?php if ($download == 'yes') { ?><a href="javascript:void(0)" onclick="submit_certificateform()" class="link_button" >Download</a> <?php } ?></u></strong></p>
                                    <div class="text-center">
                                        <h4 class="vitals_innerSub brd_btm">NO DUE CERTIFICATE</h4>
                                        <h4 class="vitals_innerSub ">Accounts In charge</h4>
                                        <p>This is to state that there are no dues pending for settlement under the name of <?= $username[0]['user_name']; ?>.</p>
                                    </div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Date :</label>
                                                <p><?= date('d/m/Y'); ?></p>
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
                                        <p>This is to state that there are no dues pending for settlement under the name of <?= $username[0]['user_name']; ?>.</p>
                                    </div>
                                    <div style="height:20px"></div>
                                    <?php if ($download != 'yes') { ?>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <!-- <h4>Contact Details</h4> -->
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="addMore" ><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig  mar-tp15 opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt" ></i>&nbsp;Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" id="save_btn" class="saveContinue nodue_submit" onclick="submit_certificateform();">Save</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <form method="post" name="certificate_form" id="certificate_form" action="<?= isset($formaction) ? $formaction : ''; ?>">
                                        <input type="hidden" name="txtsave" />
                                        <input type="hidden" name="generate" />
                                        <input type="hidden" name="employee_id" value="<?= $employee_id; ?>" />
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <?php
                                            if ($download != 'yes') {
                                                ?>
                                                <table class="table" id="nodue_table" style="margin-top: 0">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" class="removeArrow"><input class="form-control nodues_check_all" type="checkbox" name="nodues_check_all" id="nodues_check_all" onclick="selectall_chk()" ></th>
                                                            <th width="25%">Description</th>
                                                            <th width="20%">Details<br>(brand name, user id, password etc)</th>
                                                            <th width="18%">Whether returned/ obtained</th>
                                                            <th width="25%">Remarks<br>(including any damage caused to assets, if any)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $book = '';
                                                        if (php72_count($library_dues)) {
                                                            foreach ($library_dues as $rows) {
                                                                $book .= "Book Number - " . $rows['book_number'] . "<br>Book Name - " . $rows['book_name'] . "<br><br>";
                                                                ?> <?php
                                                            }
                                                        } else {
                                                            $book .= "NA";
                                                        }
                                                        ?>
                                                        <tr id="nodue_tr_1" class="nodue_more">
                                                            <td class="valign-center"><input class="form-control due_check" type="checkbox" name="nodues_check" id="nodues_check_1" onchange="deleteids(this.value);" value="1"></td>
                                                            <td><textarea name="description[]" class="form-control inline_field_1" rows="2">Library Books</textarea></td>
                                                            <td><textarea name="details[]" class="form-control  inline_field_1" rows="2"><?= $book ?></textarea></td>
                                                            <td><textarea name="obtain[]" class="form-control  inline_field_1" rows="2"></textarea></td>
                                                            <td><textarea name="remarks[]" class="form-control  inline_field_1" rows="2"></textarea></td>
                                                        </tr>
                                                        <?php
                                                        $asset = '';
                                                        if (php72_count($asset_dues)) {
                                                            $asset = '';
                                                            foreach ($asset_dues as $rows) {
                                                                $ass_type = $this->Mmaster->showMaster($rows['asset_type']);
                                                                $asset .= "Asset Number - " . $rows['asset_no'] . "<br>Asset Name - " . $ass_type . " ( " . $rows['asset_name'] . " ) <br><br>";
                                                                ?> <?php
                                                            }
                                                        } else {
                                                            $asset .= "NA";
                                                        }
                                                        ?>
                                                        <tr id="nodue_tr_2" class="nodue_more">
                                                            <td class="valign-center"><input class="form-control due_check" type="checkbox" name="nodues_check" id="nodues_check_2" onchange="deleteids(this.value);" value="1"></td>
                                                            <td><textarea name="description[]" class="form-control  inline_field_2" rows="2">Assets</textarea></td>
                                                            <td><textarea name="details[]" class="form-control inline_field_2" rows="2"><?= $asset ?></textarea></td>
                                                            <td><textarea name="obtain[]" class="form-control inline_field_2" rows="2"></textarea></td>
                                                            <td><textarea name="remarks[]" class="form-control inline_field_2" rows="2"></textarea></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <?php
                                            }
                                            if ($download == 'yes') {
                                                ?>
                                                <div style="display: none">
                                                    <?php
                                                    foreach ($description as $key => $value):
                                                        ?>
                                                        <textarea name="description[]" ><?= $description[$key] ?></textarea>
                                                        <textarea name="details[]" ><?= $details[$key] ?></textarea>
                                                        <textarea name="obtain[]" ><?= $obtain[$key] ?></textarea>
                                                        <textarea name="remarks[]" ><?= $remarks[$key] ?></textarea>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </div>
                                                <table class="table" id="nodue_table" style="margin-top: 0; border-collapse: collapse; border: 1px solid black;">
                                                    <thead>
                                                        <tr>
                                                            <th style="border: 1px solid black;" width="5%" class="removeArrow">S.No</th>
                                                            <th style="border: 1px solid black;" width="25%">Description</th>
                                                            <th style="border: 1px solid black;" width="20%">Details<br>(brand name, user id, password etc)</th>
                                                            <th style="border: 1px solid black;" width="18%">Whether returned/ obtained</th>
                                                            <th style="border: 1px solid black;" width="25%">Remarks<br>(including any damage caused to assets, if any)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $t = 0;
                                                        foreach ($description as $key => $value):
                                                            ++$t;
                                                            ?>
                                                            <tr>
                                                                <td style="border: 1px solid black;"><?= $t ?>&nbsp;</td>
                                                                <td style="border: 1px solid black;"><?= $description[$key] ?>&nbsp;</td>
                                                                <td style="border: 1px solid black;"><?= $details[$key] ?>&nbsp;</td>
                                                                <td style="border: 1px solid black;"><?= $obtain[$key] ?>&nbsp;</td>
                                                                <td style="border: 1px solid black;"><?= $remarks[$key] ?>&nbsp;</td>
                                                            </tr>
                                                            <?php
                                                        endforeach;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>

                                            <input type="hidden" name="delete_ids" id="delete_ids" />
                                        </div>
                                    </form>
                                    <div style="height: 30px;"></div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Date :</label>
                                                <p><?= date('d/m/Y'); ?></p>
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
                    <?php } ?>
                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                            <p>you are about to delete <span id="delCount"></span> selected rows, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">
    function submit_empform() {
        $('#emp_form').submit();
    }

    function submit_certificateform() {
        $('#certificate_form').submit();
    }

    function selectall_chk() {
        if ($('input[name="nodues_check_all"]:checked').length > 0) {
            $('.due_check').prop('checked', true);
            // var favorite = [];
            $.each($(".due_check:checked"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        } else {
            $('.due_check').prop('checked', false);
            $("#delUser").addClass("opacity5 none-pointer");
            $.each($(".due_check"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        }
    }

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".due_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var noduelen = $('.due_check').length;
        var nodueinput = $('.due_check:checked').length;
        var delete_id = $('#nodue_edit_id_' + checkid).val();
        if (noduelen != nodueinput) {
            $('.nodues_check_all').prop('checked', false);
        } else {
            $('.nodues_check_all').prop('checked', true);
        }
        if ($('#nodues_check_' + checkid).prop('checked') == true) {
            // $(".master_deluser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            $('.nodue_submit').removeClass("opacity5 none-pointer");
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
                arr.push(delete_id)
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            $('.inline_field_' + delete_id).attr('readonly', false);
            $('.inline_field_' + delete_id).removeClass('opacity5 none-pointer');
        } else {
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
            } else {
                $('.inline_field_' + delete_id).attr('readonly', true);
                $('.inline_field_' + delete_id).addClass('opacity5 none-pointer');
                arr.splice(arr.indexOf(delete_id), 1);
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            if (arr == '') {
                var new_f = $(".new_field").length;
                if (new_f > 0) {
                    $('.nodue_submit').removeClass("opacity5 none-pointer");
                } else {
                    $('.nodue_submit').addClass("opacity5 none-pointer");
                }
                // $(".master_deluser").removeClass("clr_red");
                $("#delUser").addClass("opacity5 none-pointer");
            }
        }
    }

    $(document).on('click', '.due_check', function () {
        if (!$(this).is(":checked")) {
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        } else {
            $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
        }
        if ($('input:checkbox.due_check').length > 0) {
            if ($('input:checkbox.due_check').length != $('input:checkbox.due_check:checked').length) {
                $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
            } else if ($('input:checkbox.due_check').length == $('input:checkbox.due_check:checked').length) {
            }
        }
        if ($('input:checkbox.due_check:checked').length == 0) {
            console.log('3');
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        }
    });

    $(document).on('click', '#deleteRecord', function () {
        var id = $('#delete_ids').val();
        var arr = id.split(',');
        for (var i = 0; i < arr.length; i++) {
            $('#nodue_tr_' + arr[i]).remove();
        }
        $('#deletemodal').modal('hide');
    });

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('click', '#addMore', function () {
        var dyn = $("#nodue_table tr").length;
        var i = parseInt(dyn);
        var datas = '<tr id="nodue_tr_' + i + '" class="nodue_more"><input type="hidden" name="nodue_edit_id[]" id="nodue_edit_id_' + i + '" value="' + i + '"><td class="valign-center"><input class="form-control due_check new_field" type="checkbox" name="nodues_check" id="nodues_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><textarea name="description[]" class="form-control inline_field_' + i + '" rows="2" ></textarea></td>';
        datas += '<td><textarea name="details[]" class="form-control inline_field_' + i + '" rows="2"></textarea></td>';
        datas += '<td><textarea name="obtain[]" class="form-control inline_field_' + i + '" rows="2"></textarea></td>';
        datas += '<td><textarea name="remarks[]" class="form-control inline_field_' + i + '" rows="2"></textarea></td></tr>';
        // $(datas).insertBefore($('#holiday_tr_1'));
        $("#nodue_table tbody").append(datas);
        $('.nodue_submit').removeClass("opacity5 none-pointer");
    });

</script>

</body>
</html>