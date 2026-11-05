<?php
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

$this->session->set_userdata("bulkmail_invs", $_POST['to_inv_id']);
if (isset($_POST['action'])) {
    $val = $_POST;
}
$subject = isset($val["subject"]) ? $val["subject"] : "";
$mail_type = isset($val["mail_type"]) ? $val["mail_type"] : "";
$body = isset($val["body"]) ? $val["body"] : "";
$to = isset($val["to"]) ? $val["to"] : '';
$from = isset($val["from"]) ? $val["from"] : "";
$this->session->set_userdata("bulkmail_to", $to);
if (isset($_POST['mail_type'])) {
    echo 'KK';die;
    $partner_id = $this->session->userdata('partner_id');
    $mailContent = $this->Mmail->getBulkMailContent($_POST['mail_type'], $partner_id);

    if (count($mailContent)) {
        $subject = $mailContent[0]['subject'];
        $body = $mailContent[0]['body'];
        $from = $mailContent[0]['from'];
        $this->session->set_userdata("bulkmail_mailtype", $_POST['mail_type']);
        $this->session->set_userdata("bulkmail_subject", $subject);
        $this->session->set_userdata("bulkmail_body", $body);
        $this->session->set_userdata("bulkmail_from", $from);
    }
} else {
    echo 'MM';die;
    $this->session->set_userdata("bulkmail_subject", $_POST['to_subject']);
    $this->session->set_userdata("bulkmail_body", $_POST['to_body']);
}
?>
<div class="villgro-breadcrumb clearfix">
    <div class="row">
        <div class="col-md-12 col-12">
            <ul>
                <li> <a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">
                    Home <i class="fa fa-angle-double-right"></i>
                </a></li>
                <li> <a href="<?= base_url() . 'index.php/portfolio/alldeals'; ?>">
                    All Deals <i class="fa fa-angle-double-right"></i>
                </a></li>
                <li> <a href="#" class="active">
                    Send Email
                </a></li>
            </ul>
        </div>
    </div>
</div>

<ul class="option-tab">
    <li><a style="color: white;" href="<?= site_url('login/deals_maillist/'); ?>" class="button">Bulk Mail List</a></li>
    <li><a href="<?= site_url('portfolio/alldeals/'); ?>" class="button">Back</a></li>
</ul>
<h1 class="h1-mail">Send Mail</h1>
<!-- start id-form -->
<input type="hidden" name="triggerRejectionMail" id="triggerRejectionMail" value="<?= $_POST['mail_type'] ?>"  />
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<div class="clear"></div>
<form name="templateForm" enctype="multipart/form-data" action="<?= $formAction ?>" method="post" id="templateForm" class="uniform" >
    <input type="hidden" name="action" value="<?= $action ?>"  />
    <input type="hidden" name="from" value="<?= $from ?>"  />
    <div class="mailform">
        <dl class="inline">
            <dt><label for="mail_type">Mail Type <font class="req_field" style="color: red">*</font></label></dt>
            <dd>
                <select name="mail_type" id="mail_type" class="input-text required" onchange="templateForm.submit();" >
                    <option value="">-Select-</option>
                    <?php
                    foreach ($mailType as $st):
                        $ses_mailtype = isset($this->session->userdata["bulkmail_mailtype"]) ? $this->session->userdata["bulkmail_mailtype"] : '';
                        if ($st['messagetype'] == $ses_mailtype) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        ?><option value="<?= $st['messagetype'] ?>" <?= $selected; ?> ><?= $st['messagetype'] ?></option>
                        <?php
                    endforeach;
                    ?>
                    <option value="Others" <?= ('Others' == $ses_mailtype) ? 'selected' : ''; ?>>Others</option>
                </select>
                <?= form_error('mail_type', '<div class="errortxt">', '</div>'); ?>
            </dd>

            <?php
            $ses_to = isset($this->session->userdata["bulkmail_to"]) ? $this->session->userdata["bulkmail_to"] : '';
            if ($ses_to != '') {
                $ses_idscount = explode(',', $ses_to);
                $ses_count_ids = count($ses_idscount);
            } else {
                $ses_count_ids = 0;
            }
            ?>
            <dt><label for="to">To <font class="req_field"  style="color: red">*</font></label></dt>
            <dd style="width:41%">
                <input type="text" name="to" id="to" class="input-text  required" size="80" style="width:94%;" value="<?= isset($mail_ids) ? $mail_ids : $ses_to; ?>" />
                <?= form_error('subject', '<div class="errortxt">', '</div>'); ?>
                <p style="color:#000;letter-spacing: -0.8px"><span style="text-align: left"><?= isset($count_ids) && $count_ids != '' ? $count_ids : $ses_count_ids; ?> receipients selected </span>  <span  style="text-align: right; margin-left: 40px;">(Multiple Email should be comma seperated)</span></p>
            </dd>
            <dd style="width:25%"><span><a href="<?= site_url('login/recipients'); ?>" class="fancybox button">Select Recipients</a>
            </span></dd>
            <?php
            $ses_subject = isset($this->session->userdata["bulkmail_subject"]) ? $this->session->userdata["bulkmail_subject"] : '';
            ?>
            <dt><label for="subject">Message Subject <font class="req_field"  style="color: red">*</font></label></dt>
            <dd>
                <input type="text" name="subject" id="subject" class="input-text  required" size="80" value="<?= $ses_subject ?>" />
                <?= form_error('subject', '<div class="errortxt">', '</div>'); ?>
            </dd>

            <dt><label for="body">Message Body <font class="req_field"  style="color: red">*</font></label></dt>
            <dd>
                <?php
                $ses_body = isset($this->session->userdata["bulkmail_body"]) ? $this->session->userdata["bulkmail_body"] : '';
                ?>
                <textarea name="body" class="input-text" id="editor"  style="height:360px;" cols="100" ><?= $ses_body; ?></textarea>
                <?= form_error('body', '<div class="errortxt">', '</div>'); ?>
                <span title="Name of the Enterprise">#name_of_enterprise#</span> <span title="Name of the Entrepreneur">#name_of_entrepreneur#</span> <span title='Application Date'>#applied_date#</span> <span title="Title Reasons">#reasons#</span> <span title="Applicant email id">#email#</span> <span title="CEO name">#action_employee#</span> <span title="Unique Innovation Id associated to the application">#innovation_id#</span> <span title="Name of the applicant">#to#</span> <span title="Loggedin User Name">#from#</span>
            </dd>
        </dl>
    </div>
    <div class="buttons">
        <input type="submit" value="Save & Send" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>
    <?php
    $ses_invs = isset($this->session->userdata["bulkmail_invs"]) ? $this->session->userdata["bulkmail_invs"] : '';
    ?>
    <input type="hidden" name="to_inv_id" class="to_inv_id" id="to_inv_id" value="<?= isset($to_inv_id) && $to_inv_id != '' ? $to_inv_id : $ses_invs; ?>" />
</form>

<script type="text/javascript">
    var BASE_URL = '<?= base_url() ?>';

    var SITE_URL = BASE_URL + 'index.php/';
    $(document).ready(function () {
        var mailRejection = "<?php echo $_POST['mail_type']; ?>";
        if (mailRejection == 'Rejection') {
            $('#mail_type').val('Rejection');
        }
    });

</script>

<?php
$this->load->library('jquery');
$this->jquery->tinymce();
?>

<style type="text/css">
    .mailform {
        height: 100%;
        clear: both;
        display: grid;
    }
    .option-tab{
        margin-top:5px;
    }
</style>