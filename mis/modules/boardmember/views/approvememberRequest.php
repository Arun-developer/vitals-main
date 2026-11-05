<section id="main">
    <form id="approverequestform" action="<?= site_url('boardmember/changememberstatus/approve/' . $innovationid . '/' . $id); ?>" class="uniform" method="post">
        <?php $status = 1; ?>

        <input type="hidden" name="memberstatus" value="<?= $status; ?>" />
        <input type="hidden" name="requestid" value="<?= $requestid; ?>" />

        <input type="hidden" name="boardid" value="<?= $boardid; ?>" />
        <input type="hidden" name="detailid" value="<?= $id; ?>" />
        <input type="hidden" name="innovationid" value="<?= $innovationid; ?>" />
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