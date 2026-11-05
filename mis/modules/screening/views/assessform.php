<h1><?= $cpagetitle ?>-<?= $innovationInfo['name_of_enterprise']; ?></h1>
<?php
$isAuth = false;
if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {
    $isAuth = true;
}
?>
<?php
$masterTab = array(
    'm1' => "Assessment", 'm2' => "Documents Validation", 'm3' => "External Validation",
);
?>

<div id="showMaster">
    <ul class="tabs">
        <li class="<?php if ($this->uri->segment('4') == "m1") {
    echo "selected";
} ?>">
            <a href="<?= site_url('screening/assessform/' . $this->uri->segment('3') . '/' . 'm1' . '/' . '11'); ?>"
               id="masterTabID"><?php echo "Assessment"; ?></a>
        </li>
        <li class="<?php if ($this->uri->segment('4') == "m2") {
    echo "selected";
} ?>">
            <a href="<?= site_url('screening/docverifyform/' . $this->uri->segment('3') . '/' . 'm2' . '/' . '11'); ?>"
               id="masterTabID"><?php echo "Document Validation"; ?></a>
        </li>
        <li class="<?php if ($this->uri->segment('4') == "m3") {
    echo "selected";
} ?>">
            <a href="<?= site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . 'm3/' . '11' . '/' . '1'); ?>"
               id="masterTabID"><?php echo "External Validation"; ?></a>
        </li>
    </ul>
</div>
<input type="hidden" name="txtmasterTabID" value="<?php echo $this->uri->segment("4"); ?>" id="txttabID" />

        <?php
        $masterId = $this->uri->segment("4");
        ?>
<div id="showCriteria">
    <ul class="tabs">
        <?php foreach ($criteriaList as $row): ?>

            <li class="<?php if ($this->uri->segment("5") == $row['id']) {
                echo "selected";
            } ?>">
                <a
                    href="<?= site_url('screening/assessform/' . $this->uri->segment('3') . '/' . $masterId . '/' . $row['id']); ?>"><?= $row['master_name'] ?></a>
            </li>
<?php endforeach; ?>
    </ul>
</div>

<br />
<div align="right">
    <a href="<?= site_url('screening/showalldocuments/' . $innovation) ?>" class="button">View Document</a></div>
<div id="showproduceDocs">
    <span style="font-weight:bold;">Upload Document </span>
    <span id="spanshowID" style="color:green;font-weight:bold;margin-left:690px;"><a href="#">[+]</a></span>
</div>
<div id="produceDocs">
    <form name="add_assess_comments" enctype="multipart/form-data"
          action="<?= site_url('screening/docsto_produce/' . $innovation . '/' . $masterId . '/' . $criteria . '/') ?>" method="post"
          id="upload_Docs" class="uniform">
        <dl class="inline">
            <legend>Document</legend>
            <dt><label for="description">Document Description</label></dt>
            <dd>
                <textarea style="width:40%;height:40%;" name="document-description"></textarea>
            </dd>
            <dt><label for="">Document to produce</label></dt>


            <input class=" " type="file" name="docToProduce" size="40" style="opacity: 0;">

            <div class="fieldMainAssess">
                <div class="fieldLabelAssess">&nbsp;</div>
                <div class="buttons">
                    <input type="submit" class="button" name="txtDocSubmit" value="Save" id="submit" />&nbsp;&nbsp;
                    <input type="reset" class="button white" name="txtReset" value="Reset" />
                </div>
            </div>
        </dl>


    </form>
</div>

<form name="assessform"
      action="<?= site_url('screening/assessform/' . $innovation . '/' . $masterId . '/' . $criteria . '/' . $pid); ?>"
      enctype="multipart/form-data" method="post" id="assessform" class="uniform">
    <input type="hidden" name="criteria" value="<?= $criteria ?>" />
    <input type="hidden" name="innovation" value="<?= $innovation ?>" />

            <?php
            foreach ($fieldsList as $row):
                ?>
        <div class="fieldMainAssess">
            <div class="fieldLabelAssess">

            <?php
            $this->load->model('Mscreening');
            $data = $this->Mscreening->getAnswerListBYID($row['id'], $innovation);

            echo $row['label'];
            ?>
            </div>

            <?php if (!empty($data['0']['answer'])) { ?>
                <input type="hidden" disabled="disabled" value="<?php echo $row['id']; ?>" name="field[]" />
                <textarea cols="120" rows="5" class="assessin input-text" disabled="disabled"
                          name="answer[]"><?php echo $data['0']['answer']; ?></textarea><a href="javascript:void(0);"
                          class="answerthis">Ok</a>
                <span style="color:green"><a
                        href="<?php echo base_url() . 'uploads/screening/assesment/produce/' . $data['0']['documents']; ?>"><?php echo $data['0']['documents']; ?></a></span>

    <?php } else { ?>
                <input type="hidden" value="<?php echo $row['id']; ?>" name="field[]" />
                <textarea cols="120" rows="5" class="assessin input-text" name="answer[]"></textarea><a
                    href="javascript:void(0);" class="answerthis">Ok</a>
                <input type="file" name="document[]" size="40" />
        <?php } ?>


            <div class="note_option">Edit</div>
            <div class="fieldInputAssess" style="display:none">
            </div>
        </div>
    <?php
endforeach;
?>
    <div class="fieldMainAssess">
        <div class="fieldLabelAssess">&nbsp;</div>
        <div class="buttons">
            <input type="submit" class="button" name="txtSubmit" value="Save" id="submit" />&nbsp;&nbsp;
            <input type="reset" class="button white" name="txtReset" value="Reset" />
        </div>
    </div>
</form>

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
                        <a href="#comment_but" id="comment_but">Comment</a>
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
            <textarea class="comm_input" style="width:384px;" id="comm_input"></textarea><br />
            <button class="post_but" id="post_but">Comment!</button>
        </td>
    </tr>
</table>
<?php
$innovation = $this->uri->segment('3');
$masterType = $this->uri->segment('4');
$criteria = $this->uri->segment('5');
?>
<input type="hidden" value="<?php echo $innovation; ?>" id="innovationID" />
<input type="hidden" value="<?php echo $masterType; ?>" id="masterTypeID" />
<input type="hidden" value="<?php echo $criteria; ?>" id="criteriaID" />

<?php
$master = '';
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

$master = isset($master);

$data = $this->Mscreening->getCommentsData($innovation, $master, $criteria, $subcriteria = null);

$counter = '1';
$htm = "";
$htm .= '<table class="new_comment_table" id="new_comment_table' . $counter . '" align="center">';
foreach ($data as $row) {

    $htm .= '<tr class="new_comment_row" id="' . $counter . '">';
    $htm .= '<td class="new_comment_img" id="new_comment_img"> <img src="http://localhost/mis/source/template/images/icons/rss_comments_icon.png" height="50" width="50"></td>';
    $htm .= '<td class="new_comment_text" id="new_comment_text"><b>' . $row['comments_by'] . ': </b>' . $row['comments'];
    $htm .= '<br /><div class="comment_del_but" id="' . $counter . '" align="right""></div>';
    $htm .= '</td>';
    $htm .= '</tr>';
    /* Append new table in predefined area  <a href="#">Delete</a> */
    $counter++;
}
$htm .= '</table>';
echo $htm;
?>




<style type="text/css">
    #assessform {
        min-height: 900px;
        height: auto;
    }

    .fieldMainAssess {
        border: 1px solid #F8F8F8;
        padding: 5px;

        margin-bottom: 5px;
        background: #FDFDFD;
        width: 100%;
    }

    .fieldLabelAssess {
        font-weight: bold;
        padding: 5px;
    }

    .fieldInputAssess {
        padding: 5px;
        margin-left: 219px;
    }

    .fieldAnswer {
        padding: 5px;
        border-right: 2px solid #CCC;
    }

    .answerthis {
        text-decoration: none;
        background: green;
        padding: 2px 4px;
        font-weight: bold;
        color: #FFF;
        border-radius: 3px 4px;

    }

    .fieldAnswer:hover {
        border: 1px solid #ccc;
        padding: 4px;
    }

    .note_option {
        display: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $("#produceDocs").hide();
        //.fieldAnswer,
        $('.answerthis').click(function () {
            $(this).parents('.fieldMainAssess').find('.fieldInputAssess').toggle();
            $(this).parents('.fieldMainAssess').find('.fieldAnswer').toggle();
            hh = $(this).parents('.fieldMainAssess').find('.assessin').val();
            $(this).parents('.fieldMainAssess').find('.fieldAnswer').html(hh);
        });

        $("#showproduceDocs").click(function () {

            $("#produceDocs").toggle();
        });

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
                        'criteria': criteria
                    },
                    'type': 'POST',
                    'async': false,
                    success: function (data) {
                        location.reload();
                    }
                });
                /*Append new table in predefined area*/
                $('#new_comment_here').append(htm);
                $('#comm_input').removeAttr('disabled');
                $('#post_but').removeAttr('disabled');
                counter++;

            }

        });
    });
</script>



<style type="text/css">
    a:hover {

        background-color: white;
        cursor: pointer;
        cursor: hand;
    }

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