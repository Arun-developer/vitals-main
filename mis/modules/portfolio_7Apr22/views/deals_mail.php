<?php
//error_reporting(E_ALL);
$this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Send Mail', 'page_table' => 'datatable'));
?>
<?php
$branch_name = $this->session->userdata('partner_id');
if ($branch_name == '10') {
    $getSectorList = array("99" => 'Agriculture & Fish', "100" => 'Textile', "101" => 'Dairy', "102" => 'Fishery', "103" => 'Others');
} else {
    $getSectorList = array("1" => 'Agri-business', "2" => 'CleanTech', "4" => 'Climate Action', "3" => 'Education & Employability', '64' => 'Employability', "5" => 'Health', "10" => 'Livelihoods & Job creation', "7" => 'Skill Development', "12" => 'Others');
}
$formAction = site_url('login/deals_mail');
$id = '';
$val = array();
$action = 'Send';
if (count($mailDetails)) {
    $val = $mailDetails['0'];
    $id = $val['id'];
    $formAction = $formAction . "/" . $id;
    $action = 'Resend';
}
if (isset($_POST['action'])) {
    $val = $_POST;
}
$subject = isset($val["subject"]) ? $val["subject"] : "";
$mail_type = isset($val["mail_type"]) ? $val["mail_type"] : "";
$body = isset($val["body"]) ? $val["body"] : "";
$to = isset($val["to"]) ? $val["to"] : '';
$from = isset($val["from"]) ? $val["from"] : "";

if (isset($_POST['mail_type'])) {
    $partner_id = $this->session->userdata('partner_id');
    $mailContent = $this->Mmail->getMailContent($innovation['id'], $_POST['mail_type'], $partner_id);

    if (count($mailContent)) {
        $subject = $mailContent['subject'];
        $body = $mailContent['body'];
        $from = $mailContent['from'];
    }
}
?>

<!-- Inner Dashboard-->
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'sendmail', 'page' => 'sendmail')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Send Mail</h4>
                    </div>
                </div>

                <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new">
                            <input type="hidden" name="triggerRejectionMail" id="triggerRejectionMail" value="<?= $_POST['mail_type'] ?>"  />
                            <!-- <p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p> -->
                            <div class="clear"></div>
                            <form name="templateForm" enctype="multipart/form-data" action="<?= $formAction ?>" method="post" id="templateForm" class="uniform" autocomplete="off">
                                <input type="hidden" name="action" value="<?= $action ?>"  />
                                <input type="hidden" name="id" value="<?= $id ?>"  />
                                <input type="hidden" name="innovation" value="<?= $innovation['id'] ?>"  />
                                <input type="hidden" name="from" value="<?= $from ?>"  />

                                <div class="row">
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label>Mail Type<span>*</span></label>
                                            <select name="mail_type" class="form-control" id="mail_type" onchange="templateForm.submit();" >
                                                <option value="">-Select-</option>
                                                <?php
                                                foreach ($mailType as $st):
                                                    ?><option value="<?= $st['messagetype'] ?>" <?= ($st['messagetype'] == $mail_type) ? 'selected' : ''; ?>><?= $st['messagetype'] ?></option>
                                                    <?php
                                                endforeach;
                                                ?>
                                                <option value="Others" <?= ('Others' == $mail_type) ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        </div>                                        
                                    </div>
                                </div>
                                <?php
                                $ses_to = isset($this->session->userdata["bulkmail_to"]) ? $this->session->userdata["bulkmail_to"] : '';
                                if ($ses_to != '') {
                                    $ses_idscount = explode(',', $ses_to);
                                    $ses_count_ids = count($ses_idscount);
                                } else {
                                    $ses_count_ids = 0;
                                }
                                ?>
                                <div class="row">                                    
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label>To<span>*</span></label>
                                            <input type="text" name="to" id="to"  readonly="" class="input-text form-control required" size="80" style="width:94%;" value="<?= isset($mail_ids) ? $mail_ids : $ses_to; ?>" />
                                            <p style="color:#000;letter-spacing: -0.8px"><span style="text-align: left"><?= isset($count_ids) && $count_ids != '' ? $count_ids : $ses_count_ids; ?> recipients selected </span>  <span  style="text-align: right; margin-left: 40px;">(Multiple Email should be comma seperated)</span></p>
                                        </div>

                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6">
                                        <span><a id="recipientsModal" class="vital_yellow_btn" data-toggle="modal" data-target="#recipientModal" style="cursor:pointer;">Select Recipients</a></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <label>Message Subject<span>*</span></label>
                                            <input type="text" name="subject" class="input-text form-control required" size="80" value="<?= $subject ?>" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-7 col-xl-7">
                                        <div class="form-group">
                                            <label>Message Body<span>*</span></label>
                                            <textarea name="body" class="input-text form-control" id="editor"  style="height:360px;" cols="100" ><?= $body ?></textarea>
                                            <textarea id="editor" id="messageBody" class="form-control edit_cls" name="messageBody">
                                                <?php if (isset($mail_details[0]->messagebody) && $mail_details[0]->messagebody != '') echo $mail_details[0]->messagebody; ?> </textarea>
                                                <div id="messagebody_err" ></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <input type="submit" value="<?= $action ?>" name="txtSubmit" class="vital_yellow_btn wdt_100" />
                                        <input type="reset" value="Reset" name="txtReset" class="vital_yellow_btn wdt_100" onclick="setTimeout(function () {
                                            window.location = '<?php echo $_SERVER["PHP_SELF"] ?>'
                                        }, 500)"/>
                                    </div>
                                </form>
                                <!-- end id-form  -->
                            </div>
                        </main>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade newdealmodal" id="recipientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Select Recipients</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="recipientsForm" id="recipientsForm" enctype="multipart/form-data"
                    action="" method="post">
                    <input type="hidden" name="txtSubmit" value="1">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <table class="tableresponsive">
                                <tbody>
                                    <tr>
                                        <td width="40%" ><label>Sector</label></td>
                                        <td width="60%" class="pad-lt15px">
                                            <div class="form-group" id="sectordiv">
                                                <select class="form-control form-control-sm" name="sector" id="sectorList">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    if ($this->session->userdata('role_id') == '4') {
                                                        $custom_sector = $this->session->userdata('sectorAccess');
                                                        $split_sector = explode(',', $custom_sector);
                                                        $new_sector = array();
                                                        foreach ($split_sector as $key => $val) {
                                                            $new_sector[] = $getSectorList[$val];
                                                        }
                                                        $getNewSectorList = array_intersect($getSectorList, $new_sector);
                                                    } else {
                                                        $getNewSectorList = $getSectorList;
                                                    }
                                                    foreach ($getNewSectorList as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $key; ?>" <?php echo ($sector == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class=""><label>Program</label></td>
                                        <td width="60%" class="pad-lt15px">
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" name="program" id="program">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    if ($this->session->userdata('role_id') == '4') {
                                                        $custom_program = $this->session->userdata('programAccess');
                                                        $split_program = explode(',', $custom_program);
                                                        if (in_array('1', $split_program)) {
                                                            ?>
                                                            <option value="0" <?= ($program == '0' || $program == '4') ? 'selected' : ''; ?>>Incubation</option>
                                                        <?php } if (in_array('2', $split_program)) { ?>
                                                            <option value="3" <?= ($program == '3') ? 'selected' : ''; ?>>Unc Pitch</option>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <option value="1" <?= ($program == '1') ? 'selected' : ''; ?>>EIR</option>
                                                        <option value="0" <?= ($program == '0' || $program == '4') ? 'selected' : ''; ?>>Incubation</option>
                                                        <option value="2" <?= ($program == '2') ? 'selected' : ''; ?>>SEED</option>
                                                        <option value="3" <?= ($program == '3') ? 'selected' : ''; ?>>Unc Pitch</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class=""><label>Stage</label></td>
                                        <td width="60%" class="pad-lt15px">
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" name="stage" id="stage">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    foreach ($stage_list as $key => $value):
                                                        ?><option value="<?= $key ?>" <?= ((string) $key == $stage) ? 'selected' : ''; ?>><?= $value ?></option>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class=""><label>Status</label></td>
                                        <td width="60%" class="pad-lt15px">
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" name="status[]" id="status" multiple>
                                                    <?php
                                                    foreach ($status as $key => $value):
                                                        if ($key != 21 && $key != 22) {
                                                            ?>
                                                            <option value="<?= $key; ?>"
                                                                <?php
                                                                if (in_array($key, $status_array_post)) {
                                                                    echo 'selected';
                                                                }
                                                                ?>><?= $value; ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <table class="tableresponsive">
                                <tbody>                                   
                                    <tr>
                                        <td width="40%" class=""><label>Date Submitted</label></td>
                                        <td width="60%" class="pad-lt15px">
                                            <div class="form-group">
                                                <input type="text" name="submitted_date" value="<?= $submitted_date ?>" class="submitStartDat form-control form-control-sm dateCalendar" onclick="datepickerSubmitted(); emptySubEndDate();" id="submitteddate" />&nbsp;-&nbsp;
                                                <input type="text" name="submitted_date_to" value="<?= $submitted_date_to ?>" class="submitEndDat form-control form-control-sm dateCalendar" onclick="datepickerSubmitted();" id="submitted_date_to" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class=""><label>Assigned Incharge</label></td>
                                        <td width="60%" class="pad-lt15px">
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" id="assigned_incharge" data-placeholder="Select Employee" name="assigned_incharge">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    foreach ($user_list as $row) {
                                                        ?>
                                                        <option value="<?= $row['emp_number'] ?>"
                                                            <?= (isset($assigned_incharge) && $assigned_incharge == $row['emp_number']) ? 'selected' : ''; ?>>
                                                            <?= $row['emp_name'] ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>

                    <p style="text-align: right; padding-right: 20px; margin-bottom: 0px !important"><span id="selectedreceipients">0</span> of <span id="totreceipients">0</span> recipients selected</p>
                    <div id="table_div">

                        <table class="gtable detailtable" id="search_table">
                            <thead>
                                <tr>
                                    <th>Entrepreneur Name</th>
                                    <th>Enterprise Name</th>
                                    <th>Sector</th>
                                    <th>Program</th>
                                    <th>Stage</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="search_tbody">
                                <tr>
                                    <td colspan="6" style="text-align:center;" id="load_content">No results found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="buttons text-center" id="receip_btn" style="display: none" >
                        <input type="button" value="Add Selected Recipients" onclick="set_recipients();" id="txtSelect" class="vital_yellow_btn" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="reset" id="txtReset" class="button white btn btn-success" onclick="setTimeout(function () {
                        window.location = '<?php echo $_SERVER["PHP_SELF"] ?>'
                    }, 500)" >Reset</button>
                    <button type="button" class="btn btn-success" onclick="load_incubatees();" value="Search" id="txtSubmit" name="txtSubmit">Search</button>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        /*button.multiselect.dropdown-toggle.btn.btn-default {
            width: 100%;
            font-size: 13px;
            border: 1px solid #ccc;
            padding: 5px 0;
            overflow:hidden;
            padding: 5px 5px 5px 10px;
        }
        ul.multiselect-container.dropdown-menu.show {
            width: 105%;
            overflow: hidden;
            height: 320px;
            overflow-y: auto;
        }
        ul.multiselect-container.dropdown-menu.show li a{
            width:100%;
        }
        .multiselect-container>li>a>label{
            width:100%;
        }
        .multiselect-container>li:first-child{
            display:none;
        }
        .multiselect-container>li>a>label {
            margin: 0;
            height: 100%;
            cursor: pointer;
            font-weight: 400;
            padding: 4px 15px 4px 15px;
            font-size: 14px;
            color: #333;
        }
        .multiselect-container>li>a>label>input[type=checkbox]{
            min-width: 25px;
            }*/

            .popupSearch{
                width:700px;
            }
            .popupSearch tr td label{
                width:100%;
                display: block;
                margin-bottom:3px;
            }
            .popupSearch tr td{
                vertical-align:top;
            }
            .popupSearch tr td input[type=text]{
                width:83%;
                margin-bottom:10px;
            }
            .popupSearch tr td select{
                width:90%;
                margin-bottom:10px;
            }
            #table_div{
                height:200px;
                overflow-y:scroll;
                margin-bottom:10px;
            }
            .gtable thead tr th {
                background-color: #A9CF55;
                text-align: left;
                padding: 2px 5px;
            }
            .gtable thead tr th:first-child{
                text-align: center;
            }
            .text-center{
                text-align: center;
            }
            input[type='checkbox'] {
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeSpeed;
                width: 13px;
                height: 13px;
                margin: 5px 0 -2px;
                margin-right: 1px;
                display: block;
                float: left;
                position: relative;
                cursor: pointer;
            }

            input[type='checkbox']:after {
                content: "";
                vertical-align: middle;
                text-align: center;
                line-height: 13px;
                position: absolute;
                cursor: pointer;
                height: 13px;
                width: 13px;
                left: 0;
                top: 0;
                font-size: 10px;
                -webkit-box-shadow: inset 0 1px 1px #70a758, 0 1px 0 #70a758;
                -moz-box-shadow: inset 0 1px 1px #70a758, 0 1px 0 #70a758;
                box-shadow: inset 0 1px 1px #70a758, 0 1px 0 #70a758;
                background: #70a758;
            }

            input[type='checkbox']:hover:after, input[type='checkbox']:checked:hover:after {
                background: #70a758;
                content: '\2714';
                color: #fff;
            }

            input[type='checkbox']:checked:after {
                background: #70a758;
                content: '\2714';
                color: #fff;
            }

        </style>
<!--        <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>source/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>-->

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable','multi_select' => 'multiselect','text_editor' => 'textEditor')); ?>

<script type="text/javascript">

    var BASE_URL = '<?php echo base_url(); ?>';
    tinyMCE.init({
        mode: "exact",
        elements: "editor",
        theme: "advanced",
        skin: "o2k7",
        skin_variant: "silver",
        plugins: "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        file_browser_callback: "airfilemanager",
        document_base_url: BASE_URL,
        relative_urls: true,
        remove_scripts_host: false
    });

    function airfilemanager(field_name, url, type, win) {
        switch (type) {
            case "media":
            case "image":
            case "flash":
            case "file":
            break;
            default:
            return !1;
        }
        tinyMCE.activeEditor.windowManager.open({
            url: BASE_URL + "source/airfilemanager/afm.php" + "?type=" + type,
            width: 780,
            height: 500,
            inline: "yes",
            close_previous: "no"
        }, {window: win, input: field_name});
    }

    $(document).ready(function () {        
        $('#status').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

    $(document).ready(function () {
        datepickerSubmitted();
        var mailRejection = "<?php echo $_POST['mail_type']; ?>";
        if (mailRejection == 'Rejection') {
            $('#mail_type').val('Rejection');
        }
        $('#search_table').DataTable();
    });

    function isIndependentUser(id) {
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/login/checkIndepUser",
                data: {'user_id': id},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + key + '">' + value + '</option>');
                    });
                    $('#status').html(output.join(''));
                }
            });
        }
    }

    function load_incubatees() {
        var base_url = "<?php echo base_url(); ?>";
        var sectorList = $('#sectorList').val();
        var program = $('#program').val();
        var stage = $('#stage').val();
        var status = $('#status').val();
        var submitteddate = $('#submitteddate').val();
        var submitted_date_to = $('#submitted_date_to').val();
        var assigned_incharge = $('#assigned_incharge').val();
        $('#search_tbody').html('<tr><td colspan="6" style="text-align:center;" id="load_content">Processing data...</td></tr>');
        $.ajax({
            type: "POST",
            async: true,
            url: base_url + "index.php/login/search_dealsmail",
            data: {sector: sectorList, program: program, stage: stage, status: status, submitteddate: submitteddate, submitted_date_to: submitted_date_to, assigned_incharge: assigned_incharge},
            dataType: 'html',
            success: function (msg) {
                var results = msg.split('||*||');
                if (results[1] > 0) {
                    $('#receip_btn').css('display', 'block');
                } else {
                    $('#receip_btn').css('display', 'none');
                }

                $('#table_div').html(results[0]);
                var tot_cnt = $('#count_recipients').val();
                $('#selectedreceipients').text(tot_cnt);
                $('#totreceipients').text(tot_cnt);
            }
        });
    }

    function emptySubEndDate() {
        $(".submitEndDat").val('');
    }

    $(document).on('click', '#txtSubmittxtSubmit', function (e) {
        var messagebody = tinyMCE.activeEditor.getContent();
        $("#messagebody_err").html('');
        if (!$("#templateForm").valid() || messagebody == '') {
            $("#messagebody_err").html('<label for="messagebody_err" class="error" style="display: block;">Enter message body</label>');
            e.preventDefault();
        } else {
            $('#templateForm').submit();
        }
    });
    function set_recipients() {
        var tobody = $('#editor').val();
        var tosubject = $('#subject').val();
        $('#to_body').val(tobody);
        $('#to_subject').val(tosubject);
        $('#recipient_form').submit();
    }

    function selectall_chk() {
        var len = $('.typecheck').length;
        if ($('input[name="selectall"]:checked').length > 0) {
            $('.typecheck').prop('checked', true);
            $.each($(".typecheck:checked"), function () {
                var inc_id = $(this).val();
                var recipient_mail = $('#recipient_select_' + inc_id).val();
                var recipient_inv = $('#recipientinv_select_' + inc_id).val();
                selectRecipient(recipient_mail, recipient_inv);
            });
        } else {
            $('.typecheck').prop('checked', false);
            $.each($(".typecheck"), function () {
                var inc_id = $(this).val();
                var recipient_mail = $('#recipient_select_' + inc_id).val();
                var recipient_inv = $('#recipientinv_select_' + inc_id).val();
                selectRecipient(recipient_mail, recipient_inv);
            });
        }
    }

    function datepickerSubmitted() {
        $('.submitStartDat, .submitEndDat').datepicker({dateFormat: 'dd-mm-yy'});
        $(".submitStartDat").datepicker({
            onSelect: function (selected) {
                $(".submitStartDat").datepicker("option", "dateFormat", 'dd-mm-yy');
                $(".submitEndDat").val('');
                var dt = new Date(selected);
                var dateval = dt.getDate();
                var monthval = dt.getMonth() + 1;
                var yearval = dt.getFullYear();
                if (monthval < 10) {
                    monthval = "0" + monthval;
                } else {
                    monthval = monthval;
                }
                if (dateval < 10) {
                    dateval = "0" + dateval;
                } else {
                    dateval = dateval;
                }

                var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                $(".submitStartDat").val(fulldatevalue);
                dt.setDate(dt.getDate() + 1);
                $(".submitEndDat").datepicker("option", {minDate: dt});
            }
        });
        $(".submitEndDat").datepicker({
            onSelect: function (selected) {
                var dt = new Date(selected);
                var dateval = dt.getDate();
                var monthval = dt.getMonth() + 1;
                var yearval = dt.getFullYear();
                if (monthval < 10) {
                    monthval = "0" + monthval;
                } else {
                    monthval = monthval;
                }
                if (dateval < 10) {
                    dateval = "0" + dateval;
                } else {
                    dateval = dateval;
                }
                var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                $(".submitEndDat").val(fulldatevalue);
                dt.setDate(dt.getDate() - 1);
            }
        });
    }

    function selectRecipient(re_mail, re_inv) {
        var tot_recp = $('input[name="recipient_chk"]').length;
        var tot_recp_chk = $('input[name="recipient_chk"]:checked').length;
        if (tot_recp_chk == tot_recp) {
            $('.typecheck_all').prop('checked', true);
        } else {
            $('.typecheck_all').prop('checked', false);
        }
        $('#to_recipients').val('');
        $('.to_inv_id').val('');
        var mail_arr = [];
        var inv_arr = [];
        $.each($(".typecheck:checked"), function () {
            var inc_id = $(this).val();
            var recipient_mail = $('#recipient_select_' + inc_id).val();
            var recipient_inv = $('#recipientinv_select_' + inc_id).val();
            mail_arr.push(recipient_mail);
            inv_arr.push(recipient_inv);
        });
        var arrFiltered = mail_arr.filter(el => {
            return el != null && el != '';
        });
        var ss = $('#count_recipients').val();
        var selected_count = arrFiltered.length;
        var result = mail_arr.join();
        var result1 = inv_arr.join();
        $('#to_recipients').val(result);
        $('.to_inv_id').val(result1);
        $('#count_selected').val(selected_count);
        $('#totreceipients').text(ss);
        $('#selectedreceipients').text(selected_count);
    }

</script>

</body>
</html>