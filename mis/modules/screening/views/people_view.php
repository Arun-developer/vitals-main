<h2><?= $cpagetitle ?></h2>
<?php
$innovationTab = array(
    '1' => "Buyers", '2' => "Users", '3' => "Possible End-Beneficiary", '4' => "End-Beneficiary",
);
$enterprenarTab = array(
    '5' => "Competitors", '6' => "Market Research"
);
$socialTab = array(
    '7' => "Entrepreneur", '8' => "Company Auditor", '9' => "Supplier"
);
$businessTab = array(
    '100' => "Innovation(Patent)", '101' => "Product Expert",
);
$scalableTab = array(
    '102' => "Seed Funder", '103' => "Potential Investor", '104' => "Potential Buyer (Acquisition)"
);

$incubationTab = array(
    '105' => "Product Cost", '106' => "Selling Price", '107' => "Projected Volume", '108' => "Market Size", '109' => "Ability to reach Target",
    '110' => "Unit Economics and validation"
);
$masterTab = array(
    'm1' => "Assessment", 'm2' => "Documents Validation", 'm3' => "External Validation",
);

$innovation = $this->uri->segment("3");
$masterTabValue = $this->uri->segment("4");
$criteria = $this->uri->segment("5");
?>
<?php
$isAuth = false;
if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {
    $isAuth = true;
}
?>
<input type="hidden" name="txttabID" value="<?php echo $this->uri->segment("4"); ?>" id="txttabID" />
<input type="hidden" name="txtCriteria" value="<?php echo $this->uri->segment("5"); ?>" id="txtcriteriaTabID" />

<a href="<?= site_url('screening/pre_ic/' . $this->uri->segment('3')); ?>" class="button" style="margin-left:850px;"
   name="peopleSubmit" id="peopleSubmitID">Submit</a>

<div id="showMaster">
    <ul class="tabs">
        <li class="<?php
        if ($this->uri->segment('4') == "m1") {
            echo "selected";
        }
        ?>">
            <a href="<?= site_url('screening/assessform/' . $this->uri->segment('3') . '/' . 'm1' . '/' . '11'); ?>"
               id="masterTabID"><?php echo "Assessment"; ?></a>
        </li>
        <li class="<?php
        if ($this->uri->segment('4') == "m2") {
            echo "selected";
        }
        ?>">
            <a href="<?= site_url('screening/docverifyform/' . $this->uri->segment('3') . '/' . 'm2' . '/' . '11'); ?>"
               id="masterTabID"><?php echo "Documents Validation"; ?></a>
        </li>
        <li class="<?php
        if ($this->uri->segment('4') == "m3") {
            echo "selected";
        }
        ?>">
            <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . 'm3/' . '11' . '/' . '1'); ?>"
               id="masterTabID"><?php echo "External Validation"; ?></a>
        </li>

    </ul>
</div>


<input type="hidden" name="txtmastertabID" value="<?php echo $this->uri->segment("4"); ?>" />


<div id="showdocVerify">
    <?php $this->load->view("docverifyform"); ?>

</div>
<!-- Criteria Tab for Assement Document To Produce  -->
<div id="criteriaTabFordocProduce">
    <ul class="tabs">
        <?php foreach ($criteriaList as $value): ?>

            <li class="<?= ($criteria == $value['id']) ? 'selected' : ''; ?>">
                <a
                    href="<?= site_url('screening/assessform/' . $this->uri->segment('3') . '/' . $value['id']); ?>"><?= $value['master_name'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<!-- End Document To Produce -->

<div id="showCriteria">
    <ul class="tabs">
        <?php foreach ($criteriaList as $row): ?>

            <li class="<?php
            if ($this->uri->segment("5") == $row['id']) {
                echo "selected";
            }
            ?>">
                <a
                    href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterTabValue . '/' . $row['id']); ?>"><?= $row['master_name'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="showInnovation">
    <ul class="tabs">
        <?php foreach ($innovationTab as $rowkey => $rowValue): ?>
            <li class="<?php
            if ($this->uri->segment("6") == $rowkey) {
                echo "selected";
            }
            ?>">
                <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterTabValue . '/' . $this->uri->segment('5') . '/' . $rowkey); ?>"
                   class="anchorID" id="<?php echo $rowkey; ?>"><?= $rowValue ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="showEnterprenar" style="display:none;">
    <ul class="tabs">
        <?php foreach ($enterprenarTab as $rowkey => $rowValue): ?>
            <li class="<?php
            if ($this->uri->segment("6") == $rowkey) {
                echo "selected";
            }
            ?>">
                <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterTabValue . '/' . $this->uri->segment('5') . '/' . $rowkey); ?>"
                   class="anchorID" id="<?php echo $rowkey; ?>"><?= $rowValue ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div id="showSocial" style="display:none;">
    <ul class="tabs">
        <?php foreach ($socialTab as $rowkey => $rowValue): ?>
            <li class="<?php
            if ($this->uri->segment("6") == $rowkey) {
                echo "selected";
            }
            ?>">
                <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterTabValue . '/' . $this->uri->segment('5') . '/' . $rowkey); ?>"
                   class="anchorID" id="<?php echo $rowkey; ?>"><?= $rowValue ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div id="showBusiness" style="display:none;">
    <ul class="tabs">
        <?php foreach ($businessTab as $rowkey => $rowValue): ?>
            <li class="<?php
            if ($this->uri->segment("6") == $rowkey) {
                echo "selected";
            }
            ?>">
                <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterTabValue . '/' . $this->uri->segment('5') . '/' . $rowkey); ?>"
                   class="anchorID" id="<?php echo $rowkey; ?>"><?= $rowValue ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="showScalable" style="display:none;">
    <ul class="tabs">
        <?php foreach ($scalableTab as $rowkey => $rowValue): ?>
            <li class="<?php
            if ($this->uri->segment("6") == $rowkey) {
                echo "selected";
            }
            ?>">
                <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterTabValue . '/' . $this->uri->segment('5') . '/' . $rowkey); ?>"
                   class="anchorID" id="<?php echo $rowkey; ?>"><?= $rowValue ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div id="showIncubation" style="display:none;">
    <ul class="tabs">
        <?php foreach ($incubationTab as $rowkey => $rowValue): ?>
            <li class="<?php
            if ($this->uri->segment("6") == $rowkey) {
                echo "selected";
            }
            ?>">
                <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterTabValue . '/' . $this->uri->segment('5') . '/' . $rowkey); ?>"
                   class="anchorID" id="<?php echo $rowkey; ?>"><?= $rowValue ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<br />

<?php
$nullLink = 'javascript:void(0);';
$innovation = $this->uri->segment("3");
$criteria = $this->uri->segment("4");
$subfield = $this->uri->segment("5");
$subTabValue = $this->uri->segment("5");
if ($subTabValue != "") {
    ?>
    <!--start table-content  -->
    <div id="user-grid" class="grid-view">
        <table width="100%" class="gtable sortable">
            <thead>
                <tr>
                    <th width="65">S.No.</th>
                    <th width="91"><a href="<?= $nullLink ?>" field="criteria" class="sortlink">Criteria</a></th>
                    <th width="91"><a href="<?= $nullLink ?>" field="criteria" class="sortlink">Sub Criteria</a></th>
                    <th width="91"><a href="<?= $nullLink ?>" field="criteria" class="sortlink">Individual/Organization</a>
                    </th>
                    <th width="176"><a href="<?= $nullLink ?>" field="label" class="sortlink">Where </a></th>
                    <th width="93"><a href="<?= $nullLink ?>" field="input_type" class="sortlink">Date</a></th>
                    <th width="93"><a href="<?= $nullLink ?>" field="input_type" class="sortlink">Document</a></th>
                    <th width="93"><a href="<?= $nullLink ?>" field="input_type" class="sortlink">Upload</a></th>
                    <th><a href="<?= $nullLink ?>" field="status" class="sortlink">Status</a></th>
                    <th class="head">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (php72_count($peopleDetails)) {
                    $r = 1;
                    foreach ($peopleDetails as $row) {
                        $row_type = ($r % 2 == 0) ? ('even') : ('odd');
                        ?>
                        <tr class="<?= $row_type ?>">
                            <td align="left" valign="middle"><?php
                                echo $r;
                                $r++;
                                ?></td>
                            <td align="left" valign="middle"><?php
                                if ($row['criteria'] == "11") {
                                    echo "Innovation";
                                }
                                if ($row['criteria'] == "12") {
                                    echo "Entrepreneur and the Organization";
                                }
                                if ($row['criteria'] == "13") {
                                    echo "Social Impact";
                                }
                                if ($row['criteria'] == "14") {
                                    echo "Business Viability";
                                }
                                if ($row['criteria'] == "15") {
                                    echo "Scalability";
                                }
                                if ($row['criteria'] == "61") {
                                    echo "Incubation Fit";
                                }
                                ?></td>

                            <td align="left" valign="middle">
                                <?php
                                if ($this->uri->segment('5') == '11') {
                                    foreach ($innovationTab as $innovationkey => $innovationValue) {

                                        if ($row['subcriteria'] == $innovationkey) {
                                            echo $innovationValue;
                                        }
                                    }
                                }
                                if ($this->uri->segment('5') == '12') {
                                    foreach ($enterprenarTab as $key => $value) {

                                        if ($row['subcriteria'] == $key) {
                                            echo $value;
                                        }
                                    }
                                }
                                if ($this->uri->segment('5') == '13') {
                                    foreach ($socialTab as $key => $value) {

                                        if ($row['subcriteria'] == $key) {
                                            echo $value;
                                        }
                                    }
                                }
                                if ($this->uri->segment('5') == '14') {
                                    foreach ($businessTab as $key => $value) {

                                        if ($row['subcriteria'] == $key) {
                                            echo $value;
                                        }
                                    }
                                }
                                if ($this->uri->segment('5') == '15') {
                                    foreach ($scalableTab as $key => $value) {

                                        if ($row['subcriteria'] == $key) {
                                            echo $value;
                                        }
                                    }
                                }
                                if ($this->uri->segment('5') == '61') {
                                    foreach ($incubationTab as $key => $value) {

                                        if ($row['subcriteria'] == $key) {
                                            echo $value;
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td align="left" valign="middle"><?= $row["category"]; ?></td>
                            <td align="left" valign="middle"><?= $row["place"]; ?></td>
                            <td align="left" valign="middle"><?= $row["date"]; ?></td>
                            <td align="left" valign="middle"><a
                                    href="<?php echo base_url(); ?>uploads/screening/assessment/<?= $row["document"]; ?>"><?= $row['document']; ?></a>
                            </td>
                            <td align="left" valign="middle"><a
                                    href="<?php echo site_url('screening/upload_docs/' . $innovation . '/' . $criteria . '/' . $subfield . '/' . $this->uri->segment('6') . '/' . $row["id"]); ?>"
                                    class="fancybox">Upload</a></td>
                            <td align="left" valign="middle" width="60">
                                <?php if ($row["status"] == '1') {
                                    ?>
                                    <a href="<?= site_url('screening/changestatus/' . $innovation . '/' . $criteria . '/' . $subfield . '/' . $row["id"] . '/0') ?>"
                                       title="Make Inctive">
                                        <img src="<?php echo base_url(); ?>source/template/images/icons/active.png">
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?= site_url('screening/changestatus/' . $innovation . '/' . $criteria . '/' . $subfield . '/' . $row["id"] . '/1') ?>"
                                       title="Make Active">
                                        <img src="<?php echo base_url(); ?>source/template/images/icons/inactive.png">
                                    </a>

                                <?php } ?>

                            </td>

                            <td nowrap="nowrap" width="70">
                                <a href="<?= site_url('screening/peopleform/' . $innovation . '/' . $row["id"]) ?>"><img
                                        src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>
                                <a href="<?= $nullLink ?>"
                                   url="<?php echo site_url('screening/delete/' . $innovation . '/' . $criteria . '/' . $subfield . '/' . $row["id"]); ?>"
                                   class="confirmDelete"><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png"
                                                           title="Delete"></a>

                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan='9' align='center'>No Records found!</td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <!-- Paging style -->
    </div>
<?php } ?>
<?php
$masterID = $this->uri->segment("4");

if ($masterID == "m3") {
    ?>
    <!-- Comments -->
    <br>
    <br>
    <table border="0" cellpadding="0" cellspacing="0" class="main">
        <tr>
            <td>
                <table>
                    <tr>
                        <td class="comment"></td>
                        <td class="comment"><b></b></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="comment_but">
                            <a href="#" id="comment_but">Comment</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" id="new_comment_here">

            </td>
        </tr>
        <tr class="comm_row" id="comm_row" align="center">
            <td colspan="2" align="center">
                <textarea class="comm_input" style="width:584px;" id="comm_input"></textarea><br />
                <button class="post_but" id="post_but">Comment!</button>
            </td>
        </tr>
    </table>
    <?php
    $innovation = $this->uri->segment('3');
    $masterType = $this->uri->segment('4');
    $criteria = $this->uri->segment('5');
    $subcriteria = $this->uri->segment('6');
    ?>
    <input type="hidden" value="<?php echo $innovation; ?>" id="innovationID" />
    <input type="hidden" value="<?php echo $masterType; ?>" id="masterTypeID" />
    <input type="hidden" value="<?php echo $criteria; ?>" id="criteriaID" />
    <input type="hidden" value="<?php echo $subcriteria; ?>" id="subcriteriaID" />

    <?php
    $this->load->model("Mscreening");
    if ($masterType == "m1") {
        $master = "Document to Produce";
    }
    if ($masterType == "m2") {
        $master = "Document to Verify";
    }
    if ($masterType == "m3") {
        $master = "People to Meet";
    }

    $data = $this->Mscreening->getCommentsData($innovation, $master, $criteria, $subcriteria);

    $url_server = explode('/', site_url(''), 5);
    $counter = '1';
    $htm = "";
    $htm .= '<table class="new_comment_table" id="new_comment_table' . $counter . '" align="center">';
    foreach ($data as $row) {

        $htm .='<tr class="new_comment_row" id="' . $counter . '">';
        $htm .='<td class="new_comment_img" id="new_comment_img"> <img src="' . $url_server['0'] . '//' . $url_server['2'] . '/source/template/images/icons/rss_comments_icon.png' . '" height="40" width="40"></td>';
        $htm .= '<td class="new_comment_text" id="new_comment_text"><b style="color:#00688B;font-weight:bold;">' . $row['comments_by'] . '&nbsp;  : </b>' . $row['comments'];
        $htm .= '<br /><div class="comment_del_but" id="' . $counter . '" align="right""></div>';
        $htm .= '</td>';
        $htm .= '</tr>';
        /* Append new table in predefined area  <a href="#">Delete</a> */
        $counter++;
    }
    $htm .= '</table>';
    echo $htm;
}
?>



<!-- End Comments -->
<script type="text/javascript">
    $("#addPeople").click(function () {
        $("#peopleSubmit").submit();
    });

    $(document).ready(function () {
        $("#showInnovation").hide();
        $("#showCriteria").hide();
        $("#showDocProduce").hide();
        $("#docVerifyID").hide();


        var tabID = $("#txttabID").val();
        var criteriaID = $("#txtcriteriaTabID").val();

        if (tabID == "m1") {

            $("#criteriaTabFordocProduce").show();
            $("#showCriteria").hide();
            $("#showInnovation").hide();
            $("#connectPeopleID").hide();
            $("#showEnterprenar").hide();
            $("#showSocial").hide();
            $("#showBusiness").hide();
            $("#showScalable").hide();
        } else {
            $("#criteriaTabFordocProduce ").hide();
        }

        if (tabID == "m3") {
            $("#showCriteria").show();
            $("#showInnovation").hide();
            $("#connectPeopleID").hide();
            $("#showEnterprenar").hide();
            $("#showSocial").hide();
            $("#showBusiness").hide();
            $("#showScalable").hide();
        } else {
            $("#showMaster").show();

        }

        if (criteriaID == "11" || criteriaID == '1' || criteriaID == '2' || criteriaID == '3' || criteriaID ==
                '4') {
            $("#showInnovation").show();
            $("#connectPeopleID").show();
            $("#showEnterprenar").hide();
            $("#showSocial").hide();
            $("#showBusiness").hide();
            $("#showScalable").hide();

        } else {
            $("showInnovation").hide();

        }
        if (criteriaID == "12" || criteriaID == '5' || criteriaID == '6') {
            $("#showEnterprenar").show();
            $("#connectPeopleID").show();
            $("showInnovation").hide();
            $("#showSocial").hide();
            $("#showBusiness").hide();
            $("#showScalable").hide();
        } else {
            $("#showEnterprenar").hide();

        }
        if (criteriaID == "13" || criteriaID == '7' || criteriaID == '8' || criteriaID == '9') {
            $("#showSocial").show();
            $("#connectPeopleID").show();
            $("showInnovation").hide();
            $("#showEnterprenar").hide();
            $("#showBusiness").hide();
            $("#showScalable").hide();
        } else {
            $("#showSocial").hide();

        }

        if (criteriaID == "14" || criteriaID == '100' || criteriaID == '101') {
            $("#showBusiness").show();
            $("#connectPeopleID").show();
            $("showInnovation").hide();
            $("#showEnterprenar").hide();
            $("#showSocial").hide();
            $("#showScalable").hide();
        } else {
            $("#showBusiness").hide();

        }

        if (criteriaID == "15" || criteriaID == '102' || criteriaID == '103' || criteriaID == '104') {
            $("#showScalable").show();
            $("#connectPeopleID").show();
            $("showInnovation").hide();
            $("#showEnterprenar").hide();
            $("#showSocial").hide();
            $("#showBusiness").hide();
        } else {
            $("#showScalable").hide();

        }
        if (criteriaID == "61" || criteriaID == '105' || criteriaID == '106' || criteriaID == '107' || criteriaID ==
                '108' || criteriaID == '109' || criteriaID == '110') {
            $("#showIncubation").show();
            $("#connectPeopleID").show();
            $("showInnovation").hide();
            $("#showEnterprenar").hide();
            $("#showSocial").hide();
            $("#showBusiness").hide();
            $("#showScalable").hide();
        } else {
            $("#showIncubation").hide();

        }

    });
</script>

<script type="text/javascript">

    $(document).ready(function () {
        var counter = 1;
        /*Show input box*/
        $('#comment_but').click(function () {
            $('#comm_row').slideDown();
        });

        /*Delete the comment*/
        $('.comment_del_but').live("click", function () {
            var ID = $(this).attr("id");
            if (confirm("Are you sure to delete this Comment?")) {
                $("#new_comment_table" + ID).slideUp();
                /*
                 Write AJAX logic for deletion here
                 */
            }
        });

        /* Post your comment */
        $('#post_but').click(function () {
            var innovation = $("#innovationID").val();
            var masterType = $("#masterTypeID").val();
            var criteria = $("#criteriaID").val();
            var subcriteria = $("#subcriteriaID").val();
            var comm = $('#comm_input').val();
            if (comm.length != 0) {
                /*Disables the input box*/
                $('#comm_input').attr({
                    'disabled': 'true'
                });
                /*Disables the post button*/
                $('#post_but').attr({
                    'disabled': 'true'
                });

                /*Send ajax request*/
                $.ajax({
                    'url': "<?php echo site_url('screening/comments'); ?>",
                    data: {
                        'comment': comm,
                        'innovation': innovation,
                        'master_type': masterType,
                        'criteria': criteria,
                        'subcriteria': subcriteria
                    },
                    'type': 'POST',
                });
                /*Append new table in predefined area*/
                $('#new_comment_here').append(htm);
                $('#comm_input').removeAttr('disabled');
                $('#post_but').removeAttr('disabled');
                counter++;

            }

        });

        $("#peopleSubmitID").click(function () {
            var status = '1';
            var innovation = $("#innovationID").val();

            $.ajax({
                'url': "<?php echo site_url('screening/assessmentsubmit'); ?>",
                data: {
                    'isAjax': true,
                    'peopleSubmit': status,
                    'innovation': innovation
                },
                'type': 'POST'

            });
            var url = '<?php echo base_url(); ?>index.php/screening/pre_ic/' + innovation;
            $(location).attr('href', url);
        });


    });
</script>



<style type="text/css">
    body {
        font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
        font-size: 12px;
    }

    .main {
        width: 650px;
        padding: 3px;
        border: 1px solid #ececec;
    }

    .status {
        background-color: #D2F2EE;
        width: 440px;
    }

    .comment {
        padding: 5px;
        vertical-align: top;
        margin-top: 2px;
    }

    .comment_but {
        text-align: right;
        padding: 3px;
        margin-right: 16px;
    }

    .comment_but a {
        text-decoration: none;
        color: #6F88DF;
        font-size: 10px;
    }

    .comment_but a:hover {
        text-decoration: underline;
    }

    .new_comment_table {
        clear: left;
        float: none;
        overflow: hidden;
        padding: 5px 0 4px 5px;
        width: 690px;
        font-size: 11px;
        margin: 1px 0 0 25px;
    }

    .new_comment_row {
        background-color: #ECEFF5;
    }

    .new_comment_img {
        width: 50px;
        margin-top: 2px;
        vertical-align: top
    }

    .new_comment_text {
        width: 300px;
        margin-top: 2px;
        vertical-align: top;
    }

    #comm_row {
        display: none;
        background-color: #ECEFF5;
        border-bottom: 1px solid #E5EAF1;
        width: 350px;
        margin: 2px 0 0 40px;
    }

    .comm_input {
        overflow: hidden;
        height: 29px;
        margin: 5px 5px 0 0;
        min-height: 29px;
        width: 298px;
        border: 1px solid #BDC7D8;
        font-family: "lucida grande", tahoma, verdana, arial, sans-serif;
        font-size: 11px;
        padding: 3px;
    }

    .post_but {
        background: #EEEEEE;
        border-color: #999999 #999999 #888888;
        border-style: solid;
        border-width: 1px;
        color: #333333;
        cursor: pointer;
        display: inline-block;
        font-size: 11px;
        font-weight: bold;
        line-height: normal !important;
        padding: 2px 6px;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        white-space: nowrap;
        float: right;
    }
</style>