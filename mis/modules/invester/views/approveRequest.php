<section id="main">
    <form id="approverequestform" action="<?= site_url('invester/changevillgrostatus/approve/' . $innovationid . '/' . $requestid); ?>" class="uniform" method="post">
        <?php $status = 1; ?>
        <input type="hidden" name="requestid" value="<?= $requestid; ?>" />
        <input type="hidden" name="villgrostatus" value="<?= $status; ?>" />
        <input type="hidden" name="investerid" value="<?= $investerid; ?>" />
        <input type="hidden" name="id" value="<?= $id; ?>"/>
        <h1><?= $cpagetitle ?></h1>
        <dl class="inline">

            <dt><label for="namesd">Comments</label></dt>
            <dd>
                <textarea  name="comments" id="comments" class=""></textarea>
            </dd>
            <div class="buttons">
                <input type="submit" name="approveSubmit"  value="Submit" class="button" />
                <input type="reset" value="Reset" class="button white" />
            </div>
    </form>
</section>