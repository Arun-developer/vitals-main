<link rel="stylesheet" href="<?php echo base_url(); ?>source/chosen/chosen.css" />
<style type="text/css">
    #table1 tbody tr.even {
        background-color: white;
    }

    #table1 tbody tr.odd {
        background-color: #F0F9D9;
    }

    #fancybox-content {
        width: 100% !important;
        max-height: 500px !important;
        overflow: auto;
    }

    .global_search form dl.inline dt {
        clear: both;
        width: 40% !important;
        float: left;
        text-align: right;
    }

    .global_search form dl.inline dd input {
        width: 230px !important;
    }

    .global_search form div.buttons {
        margin: 20px 0 5px 0;
        text-align: center;
    }

    .global_search table th {
        background-color: #A9CF55;
        border: none;
    }

    #fancybox-close {
        right: -25px !important;

    }

    .global_search table {
        width: 96%;
        margin: 0 auto;
    }

    #partnersTable thead th,
    #partnersTable thead td,
    #partnersTable tbody td {
        padding: 3px 8px;
        border: none;
    }

    #partnersTable tbody tr:nth-child(even) {
        background-color: #F0F9D9;
    }

    .reduce_space {
        width: 95%;
    }

    .modal-body {
        padding-bottom: 15px;
    }

    .text-left {
        text-align: left !important;
    }
</style>
<script type="text/javascript">

    function innovation(id) {
        $("#branch_name").val(id);
        $("#txtSubmit").click();
    }
</script>

<h1 class="reduce_space"><?= $cpagetitle ?> - <?= ucfirst($currentTab) ?> Innovations - <?php
    if ($this->session->userdata('user_type') != 'superadmin') {
        echo $userbranch[0]['branch_name'];
    }
    if ($currentTab == 'similar') {
        echo '( ' . $name_of_enterprise . ' )';
    }
    ?> <?php
    $branch_n = !empty($this->session->branchdetails['admin_branch']) ? $this->session->branchdetails['admin_branch'] : $this->session->userdata('partner_id');
    if ($this->session->userdata('user_type') == 'superadmin') {
        ?>
        <label for="program"> From Partner</label>
        <select name="branch" id="branch" onchange="innovation(this.value);">
            <?php foreach ($branch as $partner) { ?>
                <option value="<?php echo $partner['id']; ?>" <?php echo ($partner['id'] == $branch_n ? 'selected' : ''); ?>>
                    <?php echo $partner['branch_name']; ?> </option>
            <?php } ?>
        </select>
        <?php
    } else if (($this->session->userdata('user_type') == 'employee' || $this->session->userdata('user_type') == 'ceo' || $this->session->userdata('user_type') == 'cio' || $this->session->userdata('user_type') == 'abi' || $this->session->userdata('user_type') == 'icm') && $this->session->userdata('accessTo') != '') {
        $sql = "SELECT id,branch_name FROM hs_hr_branch where (id IN (" . $this->session->userdata['accessTo'] . ") OR id =" . $this->session->userdata['partner_id'] . ") and status = 'active' ";
        $values = array();
        $result = mysqli_query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $values[] = array('branch_name' => $row['branch_name'],
                'id' => $row['id']);
        }
        ?>
        <label for="program"> From Partner </label>
        <select name="branchname" id="branchname" onchange="innovation(this.value);">
            <option value="">Select Partner</option>
            <?php foreach ($values as $partner) { ?>
                <option value="<?php echo $partner['id']; ?>" <?php echo ($partner['id'] == $branch_n ? 'selected' : ''); ?>>
                    <?php echo $partner['branch_name']; ?> </option>
            <?php } ?>
        </select>

        <?php
    } else if ($this->session->userdata('user_type') == 'admin' && $this->session->userdata('accessTo') != '') {
        $sql = "SELECT id,branch_name FROM hs_hr_branch where (id IN (" . $this->session->userdata['accessTo'] . ") OR id =" . $this->session->userdata['partner_id'] . ") and status = 'active' ";
        $values = array();
        $result = mysqli_query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $values[] = array('branch_name' => $row['branch_name'],
                'id' => $row['id']);
        }
        ?>
        <label for="program"> From Partner </label>
        <select name="branchname" id="branchname" onchange="innovation(this.value);">
            <option value="">Select partner</option>
            <?php foreach ($values as $partner) { ?>
                <option value="<?php echo $partner['id']; ?>" <?php echo ($partner['id'] == $branch_n ? 'selected' : ''); ?>>
                    <?php echo $partner['branch_name']; ?> </option>
            <?php } ?>
        </select>

    <?php } else { ?>
        <input type="hidden" name="branchname" id="branchname" value=<?php echo $this->session->userdata['partner_id']; ?>>
    <?php } ?>

</h1>

<?php
$nullLink = "javascript:void(0);";
$form_name = "innovation_pool";

$isAssign = false;
$isExport = false;
$isAssignCycle = false;
$isDetails = true;
if (in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio'))) {
    $isAssign = true;
    $isExport = true;
    $isAssignCycle = true;
}

if (isset($_POST['txtSubmit']) && $_POST['txtSubmit']) {
    if ($_POST['created_date'] != '') {
        $_POST['created_date'] = str_replace('/', '_', $_POST["created_date"]);
    }

    if ($_POST['created_date_to'] != '') {
        $_POST['created_date_to'] = str_replace('/', '_', $_POST["created_date_to"]);
    }
    if ($_POST['submitted_date'] != '') {
        $_POST['submitted_date'] = str_replace('/', '_', $_POST["submitted_date"]);
    }

    if ($_POST['submitted_date_to'] != '') {
        $_POST['submitted_date_to'] = str_replace('/', '_', $_POST["submitted_date_to"]);
    }

    if ($_POST['email'] != '') {
        $_POST['email'] = str_replace('@', '^at^', $_POST['email']);
    }
    if ($_POST['stage'] != '') {
        $_POST['stage'] = str_replace("-", "^", $_POST['stage']);
    }
    if ($_POST['copy_id']) {
        $_POST['copy_id'] = str_replace("_", "ab", $_POST['copy_id']);
    }
    $url_post = '';
    $post = implode(':', array_map(function ($key, $val) {

                return $key . '-' . $val;
            }, array_keys($_POST), $_POST)
    );
    $url_post .= '"' . $post . '"';
}
?>
<script type="text/javascript">


    function Partner() {
        var vals = "<?php echo $this->session->userdata('accessTo'); ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getPartner",
            data: {
                id: vals
            },
            dataType: 'json',
            success: function (msg) {
                var arr = msg;
                $("#openModal").show();

            },
        });

    }

    function DeleteInnovation(url, start) {
        var incomplete = register = deleted = '';
        if ($("#incompleteid").is(':checked'))
            incomplete = $("#incompleteid").val();
        if ($("#registerid").is(':checked'))
            register = $("#registerid").val();
        if ($("#deletedid").is(':checked'))
            deleted = $("#deletedid").val();
        var url_part = 'incomplete-' + incomplete + ':register-' + register + ':deleted-' + deleted;

        var oTable;
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'text',
            success: function (msg) {
                if (msg == "successMsg") {
<?php
if (isset($url_post)) {
    ?>
                        var url =
                                "<?php echo base_url(); ?>index.php/scouting/getInnovationList/<?php echo $currentTab; ?>/" +
    <?php echo $url_post; ?> + ":" + url_part;
    <?php
} else {
    ?>
                        var url =
                                "<?php echo base_url(); ?>index.php/scouting/getInnovationList/<?php echo $currentTab; ?>/" +
                                url_part;
    <?php
}
?>


                    var oTable = $('#table1').dataTable({
                        "bAutoWidth": true,
                        "bAutoHeight": true,
                        "sScrollX": "100%",
                        "sScrollY": "300px",
                        "iDisplayStart": start,
                        "iDisplayLength": 10,
                        "aLengthMenu": [
                            [10, 15, 25, 50, -1],
                            [10, 15, 25, 50, "All"]
                        ],
                        'bFilter': false,
                        "oTableTools": {
                            "sSwfPath": "<?php echo base_url() . "DataTables-1.9.4/media/swf/copy_csv_xls_pdf.swf"; ?>",
                            "aButtons": [{
                                    "sExtends": "print",
                                }, ]
                        },
                        "sDom": '<"clear"><"H"lfr>t<"F"ip>',
                        "bServerSide": true,
                        "bProcessing": true,
                        "bStateSave": true,
                        "sAjaxSource": url,
                        "fnDrawCallback": function (oSettings) {
                            $(".fancybox").fancybox();
                            /*------Deleting an application deal-------*/
                            $(".confirmDelete").click(function () {
                                var linkUrl = $(this).attr('url');
                                var program = $(this).attr('program');

                                if (program == "SEED" || program == "EIR" || program == "Unc-Pitch") {
                                    msg = "This is an application submitted via the website. Are you sure you want to delete it?";
                                } else {
                                    msg = 'Are you sure you want to delete this deal?';
                                }

                                jConfirm(msg, 'Confirmation Dialog', function (r) {
                                    if (r) {
                                        console.log('all');
                                        var oSettings = oTable.fnSettings();
                                        var start = oSettings._iDisplayStart;
                                        oTable.fnDestroy();
                                        DeleteInnovation(linkUrl, start, length);

                                    }

                                });
                            });
                        },
                        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                            // Bold the grade for all 'A' grade browsers

                            $('td', nRow).attr('nowrap', 'nowrap');
                            if (nRow.className == 'even') {
                                oTable.$('tr:even').css('backgroundColor', '#FFFFFF');
                                oTable.$('tr:even').each(function () {
                                    $(this).find("td:eq(0)").css({
                                        'background-color': '#FFFFFF'
                                    });
                                });
                            }
                            return nRow;
                        }

                    });
                    var oFC = new FixedColumns(oTable, {
                        "iLeftColumns": 5, //Freezed first for columns
                        "sHeightMatch": "auto",
                        "iLeftWidth": 550
                    });
                }
            },
        });

    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#source_type").change(function () {
            var form_data = {
                source_type: $(this).val(),
                ajax: '4'
            };
            $.ajax({
                url: '<?php echo site_url("master/source/get_source_combo"); ?>',
                type: 'POST',
                data: form_data,
                success: function (msg) {
                    $('#source').html(msg);
<?php if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') { ?>
                        $("#source option[value='<?php echo $_REQUEST['source']; ?>']").attr(
                                "selected", "selected");
<?php } ?>
                }
            });
        });

        if ($("#source_type").val() != '') {
            $("#source_type").change();
        }

        $("#source").click(function () {

            if ($("#source_type").val() == '') {
                alert("Select Source type to select source");
            }

        });

<?php
if (isset($url_post)) {
    ?>
            var url = "<?php echo base_url(); ?>index.php/scouting/getInnovationList/<?php echo $currentTab; ?>/" +
    <?php echo $url_post; ?>;
    <?php
} else {
    ?>

            var url = "<?php echo base_url(); ?>index.php/scouting/getInnovationList/<?php echo $currentTab; ?>";
    <?php
}
?>


                var oTable = $('#table1').dataTable({
                    "bAutoWidth": true,
                    "bAutoHeight": true,
                    "sScrollX": "100%",
                    "sScrollY": "300px",
                    "iDisplayLength": 10,
                    "aLengthMenu": [
                        [10, 15, 25, 50, -1],
                        [10, 15, 25, 50, "All"]
                    ],
                    'bFilter': false,
                    "oTableTools": {
                        "sSwfPath": "<?php echo base_url() . "DataTables-1.9.4/media/swf/copy_csv_xls_pdf.swf"; ?>",
                        "aButtons": [{
                                "sExtends": "print",
                            }, ]

                    },
                    "sDom": '<"clear"><"H"lfr>t<"F"ip>',
                    "bServerSide": true,
                    "bProcessing": true,
                    "bStateSave": false,
                    "bSort": true,
                    "sAjaxSource": url,
                    "fnServerData": function (sSource, aoData, fnCallback) {
                        // get filter ID
                        var filter_id = $('#storedFilter_id').val();
                        // send filter ID
                        aoData.push({
                            "name": "filter_id",
                            "value": $.trim(filter_id)
                        });
                        $.getJSON(sSource, aoData, function (json) {

                            // check for expired session being returned, if so, send the user back to the login page
                            if (json == 'LoginError') {
                                var url = "<?php echo base_url(); ?>index.php";
                                console.log(url);
                                window.location.href = "<?php echo base_url(); ?>index.php/login";
                            } else {
                                fnCallback(json)
                            }

                        });
                    },
                    "fnDrawCallback": function (oSettings) {
                        $(".fancybox").fancybox();
                        $(".confirmDelete").click(function () {
                            var linkUrl = $(this).attr('url');
                            var program = $(this).attr('program');

                            if (program == "SEED" || program == "EIR" || program == "Unc-Pitch") {
                                msg =
                                        "This is an application submitted via the website. Are you sure you want to delete it?";
                            } else {
                                msg = 'Are you sure you want to delete this deal?';
                            }


                            jConfirm(msg, 'Confirmation Dialog', function (r) {
                                if (r) {
                                    var oSettings = oTable.fnSettings();
                                    var start = oSettings._iDisplayStart;
                                    oTable.fnDestroy();
                                    DeleteInnovation(linkUrl, start);
                                    oTable.fnDraw();
                                }

                            });
                        });

                    },
                    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        // Bold the grade for all 'A' grade browsers
                        $('td', nRow).attr('nowrap', 'nowrap');
                        if (nRow.className == 'even') {
                            oTable.$('tr:even').css('backgroundColor', '#FFFFFF');
                            oTable.$('tr:even').each(function () {
                                $(this).find("td:eq(0)").css({
                                    'background-color': '#FFFFFF'
                                });
                            });
                        }
                        return nRow;
                    }

                });
                var oFC = new FixedColumns(oTable, {
                    "iLeftColumns": 5, //Freezed first for columns
                    "sHeightMatch": "auto",
                    "iLeftWidth": 550
                });


                $('#assign_incharge').click(function () {

                    var val = [];
                    $(':checkbox:checked').each(function (i) {
                        val[i] = $(this).val();
                    });
                    if ($('input[type="checkbox"]:checked').length > 0) {
                        Populate();
                    } else {
                        alert('Please select atleast one');

                        $(".fancybox").fancybox({
                            modal: true,
                            afterLoad: load
                        });
                    }
                });

                $(".fancybox").fancybox({
                    onClosed: function () {
                        $('#associate_employee option').map(function () {
                            $(this).attr("selected", false);
                        });
                    }
                });

                $('#txtsub').click(function () {
                    var ids = $('#innovation_id').val();
                    if (ids == '') {
                        alert('Please select atleast one deal!');
                        return false;
                    }

                });

                function Populate() {
                    $('#associate_employee').val('');
                    vals = $('input[type="checkbox"]:checked').map(function () {
                        return this.value;
                    }).get().join(',');
                    var myresult = vals.split(',');
                    if (myresult != "")
                        var count = myresult.length;
                    else
                        var count = 0;
                    if (count == 1) {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>index.php/scouting/getassemployee",
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
                    } else {
                        $('#associate_employee option').map(function () {
                            $(this).attr("selected", false);
                        });
                    }
                    $('#innovation_id').val(vals);
                }


                $(".chk_box").trigger("liszt:updated");
                $('input[type="checkbox"]').on('click', function () {

                }).change();

            });

            function popitup(url) {
                newwindow = window.open(url, 'name', 'height=400,width=450');
                if (window.focus) {
                    newwindow.focus()
                }
                return false;
            }
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#draft_hint").mouseover(function () {
            $("#draft").dialog({
                modal: true,
                width: 460,
                maxWidth: 500,
                resizable: false,
                dialogClass: "dialogaddSeasons"
            });
        });

        $('.filter').click(function () {
            var incomplete = register = deleted = '';
            if ($("#incompleteid").is(':checked')) {
                incomplete = $("#incompleteid").val();
                $('#app_draft').val(incomplete);
            } else {
                $('#app_draft').val('');
            }
            if ($("#registerid").is(':checked')) {
                register = $("#registerid").val();
                $('#app_regist').val(register);
            } else {
                $('#app_regist').val('');
            }
            if ($("#deletedid").is(':checked')) {
                deleted = $("#deletedid").val();
                $('#app_delet').val(deleted);
            } else {
                $('#app_delet').val('');
            }
            var url_part = 'incomplete-' + incomplete + ':register-' + register + ':deleted-' + deleted;
            var arg = '';
            $("#eincomplete, #exincomplete").val(incomplete);
            $("#eregister, #exregister").val(register);
            $("#edeleted, #exdeleted").val(deleted);

<?php
if (isset($url_post)) {
    $url_post1 = str_replace('incomplete-draft:register-register:deleted-delete:', '', $url_post);
    ?>
                var url =
                        "<?php echo base_url(); ?>index.php/scouting/getInnovationList/<?php echo $currentTab; ?>/" +
    <?php echo $url_post1; ?> + ':' + url_part;
                var arg = <?php echo $url_post1; ?> + ':' + url_part
    <?php
} else {
    ?>
                var url =
                        "<?php echo base_url(); ?>index.php/scouting/getInnovationList/<?php echo $currentTab; ?>/" +
                        url_part;
                var arg = url_part;
    <?php
}
?>
            var link_url = "<?php echo site_url('scouting/innovation_print/' . $currentTab . '/'); ?>";
            var pop_url = '<?php echo site_url("scouting/innovation_print/" . $currentTab . "/"); ?>'
            var pop = "'" + pop_url + '/' + arg + "'";
            $('#link_print').html('<a href="' + link_url + '/' + arg + '" onclick=" return popitup(' + pop +
                    ');" id="Print_link" class="button">Print ALL</a>');

            var oTable = $('#table1').dataTable({
                "bAutoWidth": true,
                "bAutoHeight": true,
                "bDestroy": true,
                "sScrollX": "100%",
                "sScrollY": "300px",
                "iDisplayLength": 10,
                "aLengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                'bFilter': false,
                "oTableTools": {
                    "sSwfPath": "<?php echo base_url() . "DataTables-1.9.4/media/swf/copy_csv_xls_pdf.swf"; ?>",
                    "aButtons": [{
                            "sExtends": "print",
                        }, ]
                },
                "sDom": '<"clear"><"H"lfr>t<"F"ip>',
                "bServerSide": true,
                "bProcessing": true,
                "bStateSave": true,
                "sAjaxSource": url,
                "fnDrawCallback": function (oSettings) {
                    $(".fancybox").fancybox();
                    $(".confirmDelete").click(function () {
                        var linkUrl = $(this).attr('url');
                        var program = $(this).attr('program');

                        if (program == "SEED" || program == "EIR" || program ==
                                "Unc-Pitch") {
                            msg =
                                    "This is an application submitted via the website. Are you sure you want to delete it?";
                        } else {
                            msg = 'Are you sure you want to delete this deal';
                        }

                        jConfirm(msg, 'Confirmation Dialog', function (r) {
                            if (r) {
                                var oSettings = oTable.fnSettings();
                                var start = oSettings._iDisplayStart;
                                oTable.fnDestroy();
                                DeleteInnovation(linkUrl, start);
                                oTable.fnDraw();
                            }

                        });
                    });

                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    // Bold the grade for all 'A' grade browsers
                    $('td', nRow).attr('nowrap', 'nowrap');
                    if (nRow.className == 'even') {
                        oTable.$('tr:even').css('backgroundColor', '#FFFFFF');
                        oTable.$('tr:even').each(function () {
                            $(this).find("td:eq(0)").css({
                                'background-color': '#FFFFFF'
                            });
                        });
                    }
                    return nRow;
                }

            });
            var oFC = new FixedColumns(oTable, {
                "iLeftColumns": 5, //Freezed first for columns
                "sHeightMatch": "auto",
                "iLeftWidth": 550
            });
        });
    });
</script>
<style type="text/css">
    .dialogaddSeasons {
        display: block;
        float: left;
        height: 150px;
        outline-color: -moz-use-text-color;
        outline-style: none;
        outline-width: 0;
        right: 305px;
        left: 486px;
        top: -459.6px;
        width: 490px;
        z-index: 1002;
    }

    .ui-widget-overlay {
        background: none;
        opacity: none;
    }

    .ui-dialog-titlebar-close {
        display: inline-block;
        float: right;
    }
</style>

<?php
$name = (isset($_REQUEST['branch_name']) && !empty($_REQUEST['branch_name'])) ? $_REQUEST['branch_name'] : $this->session->userdata['partner_id'];
if ($name == '10') {
    $program = isset($_REQUEST['program']) && $_REQUEST['program'] != '' ? '4' : '';
    $getSectorList = array("99" => 'Agriculture & Fish', "100" => 'Textile', "101" => 'Dairy', "102" => 'Fishery', "103" => 'Others');
} else {
    $program = isset($_REQUEST['program']) ? $_REQUEST['program'] : '';
    $getSectorList = array("1" => 'Agri-business', "2" => 'CleanTech', "4" => 'Climate Action', "3" => 'Education', '64' => 'Employability', "5" => 'Health', "10" => 'Livelihoods & Job creation', "7" => 'Skill Development', "182" => 'Gender Inclusion', "12" => 'Others');
}
$copy_id = isset($_REQUEST['copy_id']) ? $_REQUEST['copy_id'] : '';
$branch_sel = isset($_REQUEST['branch']) ? $_REQUEST['branch'] : $this->session->userdata('partner_id');
$branch_name = isset($_REQUEST['branch_name']) ? $_REQUEST['branch_name'] : $this->session->userdata('partner_id');
$name_of_enterprise = isset($_REQUEST["name_of_enterprise"]) ? $_REQUEST["name_of_enterprise"] : '';
$name_of_entrepreneur = isset($_REQUEST["name_of_entrepreneur"]) ? $_REQUEST["name_of_entrepreneur"] : '';
$source_type = isset($_REQUEST['source_type']) ? $_REQUEST['source_type'] : '';
$source = isset($_REQUEST['source']) ? $_REQUEST['source'] : '';
$sector = isset($_REQUEST['sector']) ? $_REQUEST['sector'] : '';
$stage_post = isset($_REQUEST['stage']) ? $_REQUEST['stage'] : "";
$status_post = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
$created_date = isset($_REQUEST['created_date']) ? $_REQUEST['created_date'] : '';
$created_date_to = isset($_REQUEST['created_date_to']) ? $_REQUEST['created_date_to'] : '';
$submitted_date = isset($_REQUEST['submitted_date']) ? $_REQUEST['submitted_date'] : "";
$submitted_date_to = isset($_REQUEST['submitted_date_to']) ? $_REQUEST['submitted_date_to'] : "";
$geography = isset($_REQUEST['geography']) ? $_REQUEST['geography'] : '';
$city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
$lis = isset($_REQUEST['lis']) ? $_REQUEST['lis'] : '';
$donors = isset($_REQUEST['donor_fit']) ? $_REQUEST['donor_fit'] : '';
$assigned_incharge = (isset($_REQUEST['assigned_incharge'])) ? $_REQUEST['assigned_incharge'] : '';
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$mobile = isset($_REQUEST['mobile']) ? $_REQUEST['mobile'] : '';

$incomplete_val = $register_val = $deleted_val = '';
if (isset($_REQUEST['ordertype'])) {
    if (isset($_REQUEST['incomplete'])) {
        $incomplete_val = 1;
    }
    if (isset($_REQUEST['register'])) {
        $register_val = 1;
    }
    if (isset($_REQUEST['deleted'])) {
        $deleted_val = 1;
    }
}
?>

<form name="export" id="export" action="<?= site_url('scouting/innovation_pool/' . $currentTab); ?>" method="post">
    <input type="hidden" name="ordertype" value="<?= $ordertype ?>" />
    <input type="hidden" name="orderby" value="<?= $orderby ?>" />
    <input type="hidden" name="branch_id" value="<?php echo $name; ?>" />
    <input type="hidden" name="branch_name" value="<?= $branch_name ?>" />
    <input type="hidden" name="copy_id" value="<?= $copy_id ?>" />
    <input type="hidden" name="name_of_enterprise" value="<?= $name_of_enterprise ?>" />
    <input type="hidden" name="name_of_entrepreneur" value="<?= $name_of_entrepreneur ?>" />
    <input type="hidden" name="source_type" value="<?= $source_type ?>" />
    <input type="hidden" name="source" value="<?= $source ?>" />
    <input type="hidden" name="sector" value="<?= $sector ?>" />
    <input type="hidden" name="program" value="<?= $program ?>" />
    <input type="hidden" name="stage" value="<?= $stage_post ?>" />
    <input type="hidden" name="status" value="<?= $status_post ?>" />
    <input type="hidden" name="created_date" value="<?= $created_date ?>" />
    <input type="hidden" name="created_date_to" value="<?= $created_date_to ?>" />
    <input type="hidden" name="submitted_date" value="<?= $submitted_date ?>" />
    <input type="hidden" name="submitted_date_to" value="<?= $submitted_date_to ?>" />
    <input type="hidden" name="geography" value="<?= $geography ?>" />
    <input type="hidden" name="city" value="<?= $city ?>" />
    <input type="hidden" name="lis" value="<?= $lis ?>" />
    <input type="hidden" name="donor_fit" value="<?= $donors ?>" />
    <input type="hidden" name="export_serch" value="1" />
    <input type="hidden" name="assigned_incharge" value="<?= $assigned_incharge ?>" />
    <input type="hidden" name="email" value="<?= $email ?>" />
    <input type="hidden" name="mobile" value="<?= $mobile ?>" />
    <input type="hidden" id="eincomplete" name="incomplete" value="<?= $incomplete_val ?>" />
    <input type="hidden" id="eregister" name="register" value="<?= $register_val ?>" />
    <input type="hidden" id="edeleted" name="deleted" value="<?= $deleted_val ?>" />
    <input type="hidden" name="txtExport" value="1" />
</form>


<form name="export_all" id="export_all" action="<?= site_url('scouting/innovation_pool/' . $currentTab); ?>"
      method="post">
    <input type="hidden" name="ordertype" value="<?= $ordertype ?>" />
    <input type="hidden" name="orderby" value="<?= $orderby ?>" />
    <input type="hidden" name="branch_id" value="<?php echo $name; ?>" />
    <input type="hidden" name="branch_name" value="<?= $branch_name ?>" />
    <input type="hidden" name="copy_id" value="<?= $copy_id ?>" />
    <input type="hidden" name="name_of_enterprise" value="<?= $name_of_enterprise ?>" />
    <input type="hidden" name="name_of_entrepreneur" value="<?= $name_of_entrepreneur ?>" />
    <input type="hidden" name="source_type" value="<?= $source_type ?>" />
    <input type="hidden" name="source" value="<?= $source ?>" />
    <input type="hidden" name="sector" value="<?= $sector ?>" />
    <input type="hidden" name="program" value="<?= $program ?>" />
    <input type="hidden" name="stage" value="<?= $stage_post ?>" />
    <input type="hidden" name="status" value="<?= $status_post ?>" />
    <input type="hidden" name="created_date" value="<?= $created_date ?>" />
    <input type="hidden" name="created_date_to" value="<?= $created_date_to ?>" />
    <input type="hidden" name="submitted_date" value="<?= $submitted_date ?>" />
    <input type="hidden" name="submitted_date_to" value="<?= $submitted_date_to ?>" />
    <input type="hidden" name="geography" value="<?= $geography ?>" />
    <input type="hidden" name="city" value="<?= $city ?>" />
    <input type="hidden" name="lis" value="<?= $lis ?>" />
    <input type="hidden" name="donor_fit" value="<?= $donors ?>" />
    <input type="hidden" name="export_serch" value="1" />
    <input type="hidden" name="assigned_incharge" value="<?= $assigned_incharge ?>" />
    <input type="hidden" name="email" value="<?= $email ?>" />
    <input type="hidden" name="mobile" value="<?= $mobile ?>" />
    <input type="hidden" id="exincomplete" name="incomplete" value="<?= $incomplete_val ?>" />
    <input type="hidden" id="exregister" name="register" value="<?= $register_val ?>" />
    <input type="hidden" id="exdeleted" name="deleted" value="<?= $deleted_val ?>" />
    <input type="hidden" name="txtExport_all" value="1" />
</form>

<form id="<?= $form_name; ?>" action="<?= site_url('scouting/innovation_pool/' . $currentTab) ?>" method="post"
      name="<?= $form_name; ?>" class="searchForm">
    <input type="hidden" name="ordertype" value="<?= $ordertype ?>" id="ordertype" />
    <input type="hidden" name="orderby" value="<?= $orderby ?>" id="orderby" />
    <input type="hidden" name="export" value="" />
    <input type="hidden" name="branch_name" id="branch_name" value="<?= $branch_name ?>" />
    <input type="hidden" name="branch" id="branch" value="<?php echo $name; ?>" />
    <input type="hidden" name="app_draft" id="app_draft" value="" />
    <input type="hidden" name="app_regist" id="app_regist" value="" />
    <input type="hidden" name="app_delet" id="app_delet" value="" />
    <div class="searchBox" style="display:none;">
        <dl class="inline">
            <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
            <?php } ?>

            <dt><label for="created_date">Innovation Id</label></dt>
            <dd>
                <input type="text" name="copy_id" value="<?= $copy_id ?>" class="input-text" id="copy_id" />
            </dd>

            <dt><label for="name_of_enterprise">Name of the Incubatee</label></dt>
            <dd>
                <input type="text" value="<?= $name_of_enterprise ?>" name="name_of_enterprise" id="name_of_enterprise"
                       class="input-text" />
            </dd>

            <dt><label for="name_of_entrepreuner">Name of the Entrepreneur</label></dt>
            <dd>
                <input type="text" value="<?= $name_of_entrepreneur; ?>" name="name_of_entrepreneur"
                       id="name_of_entrepreneur" class="input-text" />
            </dd>

            <dt><label for="source_type">Source Type</label></dt>
            <dd>
                <select name="source_type" id="source_type">
                    <option value="">-Select-</option>
                    <option value="0" <?php echo ($source_type == '0') ? 'selected' : ''; ?>>Website</option>
                    <option value="1" <?php echo ($source_type == '1') ? 'selected' : ''; ?>>User Added</option>
                </select>
            </dd>

            <dt><label for="sector">Sector</label></dt>
            <dd>
                <div class="form-group" id="sectordiv">
                    <select name="sector" id="sectorList">
                        <option value="">-Select-</option>
                        <?php foreach ($getSectorList as $key => $value) { ?>
                            <option value="<?php echo $key; ?>" <?php echo ($sector == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </dd>



            <dt><label for="program">Program</label></dt>
            <dd>
                <select name="program" id="program">
                    <option value="">-Select-</option>
                    <option value="1" <?= ($program == '1') ? 'selected' : ''; ?>>EIR</option>
                    <option value="0" <?= ($program == '0' || $program == '4') ? 'selected' : ''; ?>>Incubation</option>
                    <option value="2" <?= ($program == '2') ? 'selected' : ''; ?>>SEED</option>
                    <option value="3" <?= ($program == '3') ? 'selected' : ''; ?>>Unc Pitch</option>
                </select>
            </dd>


            <dt><label for="stage">Stage</label></dt>
            <dd>
                <select name="stage" id="stage">
                    <option value="">-Select-</option>
                    <?php
                    foreach ($stage as $key => $value):
                        ?><option value="<?= $key ?>" <?= ((string) $key == $stage_post) ? 'selected' : ''; ?>><?= $value ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
            </dd>

            <dt><label for="status">Status</label></dt>
            <dd>
                <select name="status" id="status">
                    <option value="">-Select-</option>
                    <?php
                    foreach ($status as $key => $value):
                        if ($key != 21 && $key != 22) {
                            ?><option value="<?= $key ?>" <?= ((string) $key == $status_post) ? 'selected' : ''; ?>><?= $value ?></option>
                            <?php
                        }
                    endforeach;
                    ?>
                </select>
            </dd>

            <dt><label for="created_date">Date Registered</label></dt>
            <dd>
                <input type="text" name="created_date" value="<?= $created_date ?>" class="input-text"
                       id="fromdate" />&nbsp;-&nbsp;
                <input type="text" name="created_date_to" value="<?= $created_date_to ?>" class="input-text"
                       id="todate" />
                <input type="hidden" name="dealsearch" value="1" />
            </dd>

            <dt><label for="created_date">Date Submitted</label></dt>
            <dd>
                <?php
                $currentdate = date("d/m/Y");
                $year = (date("Y") - 1);
                $preyear = date('d/m') . "/" . $year;
                ?>
                <input type="text" name="submitted_date" value="<?= $submitted_date ?>" class="input-text datepicker"
                       id="submitteddate" />&nbsp;-&nbsp;
                <input type="text" name="submitted_date_to" value="<?= $submitted_date_to ?>"
                       class="input-text datepicker" id="submitted_date_to" />
            </dd>

            <dt><label for="created_date">Geography</label></dt>
            <dd>
                <input type="text" name="geography" value="<?= $geography ?>" class="input-text" id="geography" />

            </dd>

            <dt><label for="created_date">City</label></dt>
            <dd>
                <input type="text" name="city" value="<?= $city ?>" class="input-text" id="city" />

            </dd>

            <dt><label for="created_date">LIS</label></dt>
            <dd>
                <select name="lis" id="lis">
                    <option value="">-Select-</option>
                    <option value="1" <?php echo ($lis == '1') ? 'selected' : ''; ?>>Yes</option>
                    <option value="0" <?php echo ($lis == '0') ? 'selected' : ''; ?>>No</option>
                </select>
            </dd>

            <dt><label for="created_date">Donor Fit</label></dt>
            <dd>
                <select name="donor_fit" id="donor_fit">
                    <option value="">-Select-</option>
                    <?php
                    foreach ($donor_fit as $donor) {
                        ?>
                        <option value="<?php echo $donor['id']; ?>" <?= ($donor['id'] == $donors) ? 'selected' : ''; ?>>
                            <?php echo $donor['name']; ?></option>
                    <?php } ?>
                </select>
            </dd>


            <dt><label for="assigned_incharge">Assigned Incharge</label></dt>
            <dd>
                <select id="assigned_incharge" data-placeholder="Select Employee" name="assigned_incharge">
                    <option value="">Select</option>
                    <?php
                    foreach ($usersList as $row) {
                        ?>
                        <option value="<?= $row['emp_number'] ?>"
                                <?= (isset($_REQUEST['assigned_incharge']) && $_REQUEST['assigned_incharge'] == $row['emp_number']) ? 'selected' : ''; ?>>
                            <?= $row['emp_name'] ?></option>
                    <?php }
                    ?>
                </select>
            </dd>

            <dt><label for="created_date">Email-Id</label></dt>
            <dd>
                <input type="text" name="email" value="<?= $email ?>" class="input-text" id="email" />

            </dd>

            <dt><label for="created_date">Phone no</label></dt>
            <dd>
                <input type="text" name="mobile" value="<?= $mobile ?>" class="input-text" id="mobile" />

            </dd>

        </dl>

        <div class="buttons">
            <button type="submit" class="button" value="Search" id="txtSubmit" name="txtSubmit">Deals Search</button>
            <button type="reset" id="txtReset" class="button white" onclick="setTimeout(function () {
                        window.location = '<?php echo $_SERVER["PHP_SELF"] ?>'
                    }, 500)">Reset</button>
        </div>
    </div>
    <ul class="option-tab">

        <?php if ($this->session->userdata('user_name') == 'Altacit') {
            ?>

            <li><a href="<?= site_url('scouting/new_innovation'); ?>" class="button">Create Innovation</a></li>
            &nbsp;&nbsp;
            <li><a href="<?= site_url('login/logout'); ?>" class="button">Logout</a></li>
            <li> <a class="button fancybox" height="200" href="<?= site_url('login/changepassword'); ?>"> Change
                    Password</a></li>

        <?php } else { ?>
            <li><a href="<?= $nullLink; ?>" class="button toggleSearch">Show Search</a></li>
            <?php
            if (in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio')) && $_POST['branch_name'] !== $this->session->userdata['accessTo']) {
                ?>
                <li> <a class="button fancybox" height="200" id="assign_incharge" href="#form_container">Assign Incharge </a>
                </li>

            <?php } ?>
            <?php if ($currentTab == 'all') { ?>
                <li> <a href="#partnersModal" id="partnersPopup" class="fancybox button">Global Search</a> </li>
            <?php } ?>
            <li> <a href="#" id="Export_link" class="button">Export summary</a> </li>
            <li> <a href="#" id="Export_link_all" class="button">Export Applications</a> </li>
            <li>
                <?php
                if (isset($url_post)) {
                    $url_post = trim($url_post, '"');
                } else {
                    $url_post = "";
                }
                ?>
            </li>
            <?php if ($isExport) { ?>
                <li></li>
                <?php
            }
        }
        ?>
    </ul>
    <br />
    <br />
    <dl class="inline">

        <div id="dvData">
            <?php
            if ($currentTab == 'all') {
                if ($this->session->userdata('partner_id') != '2') {
                    ?>
                    <div style="float:right"><strong>Include Applications: <a href="javascript:(void)"
                                                                              id="draft_hint">(?)</a></strong>
                        <div id="draft" title="Information" style="display:none;height:100px;">
                            <p>
                                <b>Draft:</b>Applications that are currently being filled by the user and not yet submitted
                                <br />
                                <b>Registered:</b>Applicants who tried to registered but could not meet the eligibility
                                criteria<br />
                                <b>Deleted:</b>Applications that were in draft mode for more than 3 weeks and hence have been
                                deleted by the system<br />
                            </p>
                        </div>
                        <input type="checkbox" <?php
                        if ($selDraft == 'draft') {
                            echo 'checked';
                        }
                        ?> class="filter" name="incomplete" id="incompleteid" value="draft"
                               style="margin:5px;vertical-align:top">Draft
                        <input type="checkbox" <?php
                        if ($selRegis == 'register') {
                            echo 'checked';
                        }
                        ?> class="filter" name="register" id="registerid" value="register"
                               style="margin:5px;vertical-align:top">Registered
                        <input type="checkbox" <?php
                        if ($selDelet == 'delete') {
                            echo 'checked';
                        }
                        ?> class="filter" name="deleted" id="deletedid" value="delete"
                               style="margin:5px;vertical-align:top">Deleted
                    </div>

                    <?php
                }
            }
            ?>
            </form>
            <table id="table1" class="gtable sortable">
                <thead>


                    <tr>
                        <?php if ($currentTab == 'lead') { ?>
                            <th><input type="checkbox" class="checkall" /></th>
                        <?php } ?>

                        <th>Select</th>

                        <th nowrap="nowrap">INV ID</th>
                        <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                            <th nowrap="nowrap">Partner</th>
                        <?php } ?>
                        <th nowrap="nowrap">Name of the Incubatee</th>
                        <th nowrap="nowrap">Name of the Entrepreneur</th>
                        <th>Source Type</th>
                        <th>Sector</th>
                        <th>Program</th>
                        <th>Stage</th>
                        <th>Status</th>
                        <th nowrap="nowrap">Registered Date</th>
                        <th>City</th>
                        <th nowrap="nowrap">Applied to Partners</th>
                        <th nowrap="nowrap">Assign in-Charge</th>
                        <th nowrap="nowrap">Email</th>
                        <th nowrap="nowrap">Phone Number</th>
                        <th nowrap="nowrap">Submitted Date</th>
                        <th nowrap="nowrap">Copied Date</th>
                        <th>View</th>
                        <th>Download</th>
                        <?php if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $branch_n) || $this->session->userdata('user_type') == 'superadmin') { ?>
                            <th>Delete</th>
                        <?php } ?>
                        <?php if (($this->session->userdata('partner_id') == $branch_n) || $this->session->userdata('user_type') == 'superadmin') { ?>
                            <th>Copy</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>


                    <tr>
                        <td>
                <center>Processing...</center>
                </td>
                </tr>

                </tbody>

            </table>

        </div>

        <div id="form_employeelist" style="display:none;">
            <div align="center" id="form_container" style="height:400px;">

                <form action="<?php echo site_url('scouting/assign_multi_incharge'); ?>" id="assign" method="post">
                    <?php
                    $associate_employee = isset($_REQUEST["associate_employee"]) ? $_REQUEST["associate_employee"] : array();

                    if ($_POST['branch_name'] != '') {
                        $userSetup1 = $this->Mmaster->getUserSetup_branch($_POST['branch_name']);
                        if ($userSetup1['abi'] != '') {
                            $usersList_incharge = $this->Muser->getUsersList($userSetup1['abi']);
                        }
                        ?>

                        <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                                style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">

                            <?php
                            foreach ($usersList_incharge as $row) {
                                ?>
                                <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                            <?php }
                            ?>
                        </select>
                    <?php } else {
                        ?>
                        <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                                style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                                    <?php
                                    foreach ($usersList as $row) {
                                        ?>
                                <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                            <?php }
                            ?>
                        </select>
                    <?php } ?>
                    <input type="hidden" name="innovations" id="innovation_id" />
                    <br /><br />
                    <div>
                        <input type="submit" name="txtSubmit" class="button" id="txtsub" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
        <?php
        if ($currentTab == 'lead' && count($innovationList) && $isAssign) {
            ?>
            <a href="<?= site_url('scouting/multi_cycle/') ?>" class="fancyboxt button">Assign Cycle</a>
            <?php
        }
        ?>
        <script src="<?php echo base_url(); ?>source/chosen/chosen.jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
                $(document).ready(function () {

                    $("#fancybox-close").click(function () {
                        $('#associate_employee option').map(function () {
                            $(this).attr("selected", false);
                        });
                    });

                });
        </script>

        <script type="text/javascript">
            function modal_copy(id) {
                $("#newpartner").val(id);
                $("#openModal").show();
            }

            $('#Export_link_all').click(function () {
                var program = $('#program').val();
                $.ajax({
                    type: "POST",
                    data: $('#export_all').serialize(),
                    url: "<?php echo base_url(); ?>index.php/scouting/innovation_pool_export_all",
                    beforeSend: function () {
                    },
                    success: function (msg) {
                        var arr = msg;
                        if (arr == 'invalid' || program == '') {
                            alert("Data to be exported contains applications for multiple programmes. Use the search options to retrieve applications in one programme and then use this export option");
                        } else {
                            $("#export_all").submit();
                        }


                    }
                });
            });
            $(document).ready(function () {

                $("#txtsubc").click(function () {
                    var partner = $("#branchname1").val();
                    if (partner == '') {
                        alert("please select partner");
                        return false;
                    } else {

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>index.php/scouting/getPartnerName",
                            data: {
                                id: partner
                            },
                            dataType: 'json',
                            success: function (msg) {
                                var a = confirm(
                                        'You are about to trigger an email to the applicant requesting for permission to send the application to ' +
                                        msg +
                                        '. Once the applicant approves the request, A copy of this incubation application form will be sent to ' +
                                        msg + '. Do you want to continue');
                                if (a) {
                                    $("#assignpartner").submit();
                                }

                            }
                        });
                        return false;
                    }
                });

            });

            $(document).ready(function () {

                var a = '<?php echo $this->session->userdata['partner_id'] ?>';
                var usr = '<?php echo $this->session->userdata["user_type"] ?>';
                if (usr == 'superadmin') {
                    var b = $('#branch option:selected').text();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/scouting/PartnerId",
                        data: {
                            branch_name: b
                        },
                        dataType: 'json',
                        success: function (msg) {
                            var arr = msg;
                            $("#branchname1 option[value='" + arr + "']").remove();
                        },
                    });
                }
                if (usr != 'superadmin') {
                    $("#branchname1 option[value='" + a + "']").remove();
                }

            });
        </script>
        <div style="display:none;">
            <div id="partnersModal" class="global_search" align="center" style="width:900px;">
                <h1 class="text-left reduce_space"><?= $cpagetitle ?> - <?= ucfirst($currentTab) ?> Innovations - Global Search
                </h1>
                <div class="modal-head">
                    <p style="width: 100%;text-align:center;font-size: 16px;margin-bottom:0;font-weight: bold;">Search Across
                        Partners</p>
                </div>
                <div class="modal-body">
                    <form name="otherPartners" id="otherPartners" action="" autocomplete="off" method="post"
                          style="width:50%;margin:auto;">
                        <input type="hidden" name=partnersLightBox id='partnersLightBox' value='1'>
                        <dl class="inline">
                            <dt><label for="partners_enterprise">Name of the Incubatee</label></dt>
                            <dd style="width:0 !important">
                                <?php $partners_entreprise = isset($_REQUEST["partners_enterprise"]) ? $_REQUEST["partners_enterprise"] : ''; ?>
                                <input type="text" value="<?= $partners_entreprise; ?>" name="partners_enterprise"
                                       id="partners_enterprise" class="input-text" />
                            </dd>
                            <dt><label for="partners_entrepreuner">Name of the Entrepreneur</label></dt>
                            <dd style="width:0 !important">
                                <?php $partners_entrepreneur = isset($_REQUEST["partners_entrepreneur"]) ? $_REQUEST["partners_entrepreneur"] : ''; ?>
                                <input type="text" value="<?= $partners_entrepreneur; ?>" name="partners_entrepreneur"
                                       id="partners_entrepreneur" class="input-text" />
                            </dd>
                            <dt><label for="created_date">Email ID</label></dt>
                            <dd style="width:0 !important">
                                <?php $partnersemail = isset($_REQUEST['partners_email']) ? $_REQUEST['partners_email'] : ''; ?>
                                <input type="text" name="partners_email" value="<?= $partnersemail; ?>" class="input-text"
                                       id="partners_email" />
                            </dd>
                        </dl>
                        <div class="buttons">
                            <p id='err_txt' style='color:red;'></p>
                            <button type="button" class="button" value="Search" id="partnerSubmit" name="partnerSubmit">Search
                                across partners</button>
                            <button type="reset" onclick='rmvPartners();' ; class="button">Reset</button>
                        </div>
                    </form>
                    <div id="ajax_load_partners"></div>
                </div>
            </div>
        </div>

        <div id="openModal" class="modalDialog" style="display:none;">
            <div><a href="#close" title="Close" class="close">X</a>
                <h2>Copy</h2>
                <form action="<?php echo site_url('scouting/copy_innovation'); ?>" id="assignpartner" method="post">
                    <input type="hidden" value="" name="newpartner" id="newpartner">

                    <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                        <label for="program"> To Partner</label>

                        <select name="branchname1" id="branchname1">
                            <?php foreach ($branch as $partner) { ?>
                                <option value="<?php echo $partner['id']; ?>"
                                        <?php echo ($partner['id'] == $_POST['branch_name'] ? 'selected' : ''); ?>>
                                    <?php echo $partner['branch_name']; ?> </option>
                            <?php } ?>
                        </select>

                        <?php
                    } else if (($this->session->userdata('user_type') == 'employee' || $this->session->userdata('user_type') == 'ceo' || $this->session->userdata('user_type') == 'cio' || $this->session->userdata('user_type') == 'abi' || $this->session->userdata('user_type') == 'icm')) {
                        $sql = "SELECT id,branch_name FROM hs_hr_branch where  status='active'";
                        $values = array();
                        $result = mysqli_query($sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $values[] = array('branch_name' => $row['branch_name'],
                                'id' => $row['id']);
                        }
                        ?>
                        <label for="program"> To Partner </label>
                        <select name="branchname1" id="branchname1">
                            <option value="">Select Partner</option>
                            <?php foreach ($values as $partner) { ?>
                                <option value="<?php echo $partner['id']; ?>"
                                        <?php echo ($partner['id'] == $_POST['branch_name'] ? 'selected' : ''); ?>>
                                    <?php echo $partner['branch_name']; ?> </option>
                            <?php } ?>
                        </select>

                        <?php
                    } else if ($this->session->userdata('user_type') == 'admin') {
                        $sql = "SELECT id,branch_name FROM hs_hr_branch where  status='active'";
                        $values = array();
                        $result = mysqli_query($sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $values[] = array('branch_name' => $row['branch_name'],
                                'id' => $row['id']);
                        }
                        ?>
                        <label for="program"> To Partner </label>
                        <select name="branchname1" id="branchname1">
                            <option value="">Select partner</option>
                            <?php foreach ($values as $partner) { ?>
                                <option value="<?php echo $partner['id']; ?>"
                                        <?php echo ($partner['id'] == $_POST['branch_name'] ? 'selected' : ''); ?>>
                                    <?php echo $partner['branch_name']; ?> </option>
                            <?php } ?>
                        </select>

                    <?php } ?>


                    <div><label for="program">Comment</label>
                        <textarea name='comment'></textarea>
                    </div>
                    <input type="submit" name="invSubmit1" class="button" id="txtsubc" value="Submit" />
                </form>
            </div>
        </div>

        <div id="downloadModal" style="display:none;height:100px;">
            <h2>Do you want to download attached documents as well?</h2>
            <div class="download_pop">
                <button type="button" class="button" onclick="attachedfileNo();" data-dismiss="modal">No</button>
                <button type="button" class="button" onclick="attachedfileYes();" data-dismiss="modal">Yes</button>
            </div>
            <input type="hidden" value="" id="download_id">
            <input type="hidden" value="" id="program_id">
            <input type="hidden" value="" id="doc1_id">
            <input type="hidden" value="" id="doc2_id">
        </div>

        <style type="text/css">
            .download_pop{
                text-align: center;
                padding: 10px;
            }

            .modalDialog {
                position: fixed;
                font-family: Arial, Helvetica, sans-serif;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background: rgba(0, 0, 0, 0.8);
                z-index: 99999;
                opacity: 0;
                -webkit-transition: opacity 400ms ease-in;
                -moz-transition: opacity 400ms ease-in;
                transition: opacity 400ms ease-in;
                pointer-events: none;
            }

            .modalDialog:target {
                opacity: 1;
                pointer-events: auto;
            }

            .modalDialog>div {
                width: 400px;
                position: relative;
                margin: 10% auto;
                padding: 5px 20px 13px 20px;
                border-radius: 10px;
                background: #fff;
                background: -moz-linear-gradient(#fff, #999);
                background: -webkit-linear-gradient(#fff, #999);
                background: -o-linear-gradient(#fff, #999);
            }

            .close {
                background: #606061;
                color: #FFFFFF;
                line-height: 25px;
                position: absolute;
                right: -12px;
                text-align: center;
                top: -10px;
                width: 24px;
                text-decoration: none;
                font-weight: bold;
                -webkit-border-radius: 12px;
                -moz-border-radius: 12px;
                border-radius: 12px;
                -moz-box-shadow: 1px 1px 3px #000;
                -webkit-box-shadow: 1px 1px 3px #000;
                box-shadow: 1px 1px 3px #000;
            }

            .close:hover {
                background: #00d9ff;
            }

            .sorting_asc {
                width: auto !important;
            }


            .sorting,
            .sorting_asc,
            .sorting_desc {
                background: none;
            }
        </style>

        <script type="text/javascript">
            $('#partnerSubmit').on('click', function (e) {
                var p_enterprise = $('#partners_enterprise').val();
                var p_enterpreneur = $('#partners_entrepreneur').val();
                var p_email = $('#partners_email').val();
                if (p_enterprise == '' && p_enterpreneur == '' && p_email == '') {
                    $('#err_txt').html('Please specify a search criteria');
                    setTimeout(function () {
                        $('#err_txt').html('');
                    }, 3000);
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/scouting/getPartnersList",
                        data: {
                            enterprise: p_enterprise,
                            enterpreneur: p_enterpreneur,
                            email: p_email
                        },
                        dataType: 'html',
                        success: function (result) {
                            $("#ajax_load_partners").html(result);
                        },
                    });
                    $('#err_txt').html('');
                }
            });

            function rmvPartners() {
                $('#partnersTable').remove();
                $('#popup_export').hide();
            }

            $("#Export_link").on('click', function () {
                $('#export').submit();
            });

            var interval;

            function attachmentDownload(inv_id, program, doc1, doc2) {
                if (inv_id != '') {
                    $('#download_id').val(inv_id);
                    $('#program_id').val(program);
                    $('#doc1_id').val(doc1);
                    $('#doc2_id').val(doc2);
                }
                if (doc1 != '' || doc2 != '') {
                    if (confirm("Do you want to download attached documents as well?") == true) {
                        var app_url, doc1_url, doc2_url;

                        var host = "<?php echo host_url(); ?>";
                        var base = "<?php echo base_url(); ?>";
                        var app_url = base + 'index.php/scouting/export_deals_pdf/' + inv_id;

                        if (program == 0) {
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
                        }

                        var urls = [app_url, doc1_url, doc2_url];
                        urls = $.grep(urls, function (n) {
                            return(n);
                        });

                        interval = setInterval(download, 300, urls);
                    } else {
                        var app_url;
                        var base = "<?php echo base_url(); ?>";
                        var app_url = base + 'index.php/scouting/export_deals_pdf/' + inv_id;
                        var urls = [app_url];
                        interval = setInterval(download, 300, urls);
                    }
                } else {
                    var app_url;
                    var base = "<?php echo base_url(); ?>";
                    var app_url = base + 'index.php/scouting/export_deals_pdf/' + inv_id;
                    var urls = [app_url];
                    interval = setInterval(download, 300, urls);
                }
            }

            function attachedfileYes() {
                var inv_id = $('#download_id').val();
                var program = $('#program_id').val();
                var doc1 = $('#doc1_id').val();
                var doc2 = $('#doc2_id').val();

                var app_url, doc1_url, doc2_url;

                var host = "<?php echo host_url(); ?>";
                var base = "<?php echo base_url(); ?>";
                var app_url = base + 'index.php/scouting/export_deals_pdf/' + inv_id;


                if (program == 0) {
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
                }

                var urls = [app_url, doc1_url, doc2_url];
                urls = $.grep(urls, function (n) {
                    return(n);
                });

                interval = setInterval(download, 300, urls);
            }

            function attachedfileNo() {
                var inv_id = $('#download_id').val();
                if (inv_id != '') {
                    var app_url;
                    var base = "<?php echo base_url(); ?>";
                    var app_url = base + 'index.php/scouting/export_deals_pdf/' + inv_id;
                    var urls = [app_url];
                    interval = setInterval(download, 300, urls);
                }
            }

            function download(urls) {
                var url = urls.pop();
                if (url != null && url != undefined) {
                    var a = document.createElement("a");
                    a.setAttribute('href', url);
                    a.setAttribute('download', url);
                    a.click();

                    if (urls.length == 0) {
                        clearInterval(interval);
                    }
                } else {
                    return false;
                }
            }
        </script>
