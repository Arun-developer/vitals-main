<?php
$isAuth = false;
$isGrade = false;
if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
    $isAuth = true;
    $isGrade = true;
}
?>
<h1><?=$cpagetitle?> - <?=$innovation['name_of_enterprise']?></h1>
<ul class="option-tab">
    <?php if ($isGrade && $innovation['stage'] == '3') {?>
    <li><a href="<?=site_url('grading/next_grading/' . $innovation['id'])?>" class="button">Next > Grading &amp;
            Feedback</a></li>
    <?php
} elseif ($isGrade) {
    $currentStage = $this->Mprogram_stage->getCurrentStage('3');
    $activity = $this->Mactivities->getActivityForGrading($innovation['id'], $currentStage);
    if (count($activity)) {?>
    <li><a href="<?=site_url('grading/view/' . $activity['0']['id']);?>" class="button">View Grading &amp; Feedback</a>
    </li>
    <?php }
}
?>
    <li><a href="<?=site_url('presentation/form/' . $innovation['id'])?>" class="button">Add
            <?=($isAuth) ? 'Comments' : 'Minutes of meeting';?></a></li>
</ul>


<br />
<br />

<ul class="comments">
    <?php
foreach ($presentationList as $row):
    $deleteOption = $editOption = ($row['created_by'] == $this->session->userdata('emp_number') || $isAuth) ? true : false;
    $user_type = $this->Mauth->getUserType($row['created_by']);
    $description_title = (in_array($user_type, array('admin', 'ceo', 'cio'))) ? 'Comments' : 'Minutes of meeting';
    ?>
    <li style=" <?=($description_title == 'Comments') ? 'background:#D3DEEE; padding:5px;' : '';?>">
        <div class="comment-body clearfix">
            <?php if ($row['description'] != '') {?>
            <div><strong>Document Description : </strong><?=$row['description']?></div>
            <?php }?>
            <?php if (!empty($row['document'])) {?>
            <div>
                <strong>Document: </strong><?=$row['document'];?>
                <a href="<?=base_url() . 'uploads/presentation/' . $row['document']?>" target="_blank"><img
                        src="<?=base_url();?>source/template/images/icons/download.gif" title="Download"
                        height="25" /></a>
            </div>
            <?php }?>
            <div><strong><?=$description_title?> </strong>:<?=$row['description'];?></div>
        </div>
        <div class="links">
            <span class="date"><strong>Added By :</strong><?=$row['created_emp']?></span>
            <span class="date"><strong>Added Date :</strong><?=mysql2date($row['created_date'])?></span>

            <?php if ($row['modified_by'] != '') {?>
            <span class="date"><strong>Last Modified :</strong><?=$row['modified_date']?></span>
            <span class="date"><strong>Modified By :</strong><?=mysql2date($row['modified_emp'])?></span>
            <?php }
    if ($editOption) {
        ?>
            <a href="<?=site_url('presentation/form/' . $innovation['id'] . '/' . $row["id"]);?>"><img
                    src="<?=base_url();?>source/template/images/icons/edit.png" title="Edit" /></a>
            <?php
    }
    if ($deleteOption) {?>
            <a href="javascript:void(0);"
                url="<?=site_url('presentation/delete/' . $innovation['id'] . '/' . $row["id"]);?>"
                class="delete confirmDelete">Delete</a>
            <?php }?>
        </div>
    </li>
    <?php
endforeach;
?>
</ul>
<br />

<h1>Comments</h1>
<ul class="comments">
    <?php
foreach ($comments as $com):
?>
    <li>
        <div class="comment-body clearfix">
            <img class="comment-avatar" src="<?=base_url();?>source/template/images/icons/dummy.gif" />

            <div><?=$com['comments']?></div>
        </div>
        <div class="links">
            <span class="date"><strong>Added Date :</strong><?=mysql2date($com['created_date'])?></span>
            <span class="date"><strong>Added By :</strong> <?=$com['created_emp']?></span>
            <a href="javascript:void(0);"
                url="<?=site_url('presentation/delete_comments/' . $innovation['id'] . '/' . $com["id"], "delete", 'class="button"');?>"
                class="confirmDelete delete">Delete</a>
        </div>
    </li>
    <?php
endforeach;
?>
</ul>
<form name="add_assess_comments" action="<?=site_url('presentation/add_comments/' . $innovation['id'])?>" method="post"
    id="add_assess_comments" class="uniform">
    <fieldset>
        <legend>Post Comments</legend>
        <dl class="inline">
            <dt><label for="name">Comments<span class="req_field">*</span></label></dt>
            <dd><textarea name="comments" id="editor" class="input-text" rows="5" cols="80"></textarea></dd>
        </dl>
        <div class="buttons" style="margin-left:40%;">
            <input type="submit" value="Post Comments" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>
    </fieldset>
</form>