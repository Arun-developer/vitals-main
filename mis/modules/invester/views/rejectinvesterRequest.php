<section id="main">
    <form id="approverequestform" action="<?= site_url('invester/changeinvesterstatus/reject/' . $innovationid . '/' . $requestid); ?>" class="uniform" method="post">
        <?php $status = 2; ?>
        <input type="hidden" name="requestid" value="<?= $requestid; ?>" />
        <input type="hidden" name="id" value="<?= $id; ?>" />
        <input type="hidden" name="investerstatus" value="<?= $status; ?>" />
        <input type="hidden" name="investerid" value="<?= $investerid; ?>" />
        <h1><?= $cpagetitle ?></h1>
        <dl class="inline">

            <dt><label for="namesd">Comments</label></dt>
            <dd>
                <textarea  name="comments" id="comments" class=""></textarea>
            </dd>

            <div class="buttons">
                <input type="submit" name="rejectSubmit"  value="Submit" class="button" />
                <input type="reset" value="Reset" class="button white" />
            </div>
    </form>
</section>