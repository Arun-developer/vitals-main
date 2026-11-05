<script type="text/javascript">
    $(document).ready(function () {
        $('#print_form').click(function () {
            $('#print_table').show().printElement();
        });

    });
</script>

<?php
$isAuth = false;
if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {
    $isAuth = true;
}
?>
<h1><?php echo $cpagetitle; ?></h1>
<a href="javascript:void(0)" id="print_form" style="float:right" class="button">Print</a>
<a href="<?= site_url('assessment/linkdoc/' . $innovation['id']); ?>" style="float:right" class="fancybox button">View Links and Documents</a>
<ul class="option-tab">
    <li><a href="<?= site_url('grading/view/' . $innovation['id']); ?>" class="button white" >Back</a></li>
</ul>
<br />
<br />
<div id="print_table">
    <?php
    $assessDetails = array();
    $this->load->model('Massessment');

    if (count($criteria)) {
        foreach ($criteria as $cri):
            $assessDetails = $this->Massessment->getAssessDetails($innovation['id'], $cri['id']);
            if (count($assessDetails) || count($criteria) == '1') {
                ?>
                <h2><?php echo $innovation['name_of_enterprise'] . " - " . $cri['master_name']; ?></h2>
                <ul class="comments">
                    <?php
                    $rowType = 'odd';
                    foreach ($assessDetails as $row):
                        $rowType = ($rowType == 'odd') ? 'even' : 'odd';
                        ?>
                        <li>
                            <div class="comment-body clearfix">
                                <h3><?= $row['title'] ?></h3>
                                <div style="width:100%; overflow:auto;"><?php
                                    $source = $row['description'];
                                    $imgLink = '/S*src\s*=\s*[\""\']?([^\""\']*)/i';
                                    preg_match_all($imgLink, $source, $matches);
                                    $matchVal = array_filter($matches);
                                    $count = count($matchVal);
                                    if ($count != 0) {
                                        $imageArray = $matchVal['1'];
                                        foreach ($imageArray as $key => $img):
                                            $imgArray[] = $img;
                                            $imgFullPath[] = base_url() . str_replace('/mis/', '', $img);

                                        endforeach;
                                        $source = str_replace($imgArray, $imgFullPath, $source);
                                        $source = str_replace('http://localhosthttp://', 'http://', $source);
                                        $source = str_replace('https://mis.villgroapps.orghttps://', 'https://', $source);
                                    }//count the array elements
                                    echo $source;
                                    ?></div>
                            </div>
                            <div class="links">
                                <span class="date"><strong>Added By :</strong><?= !empty($row['created_emp']) ? $row['created_emp'] : 'Admin'; ?></span>
                                <span class="date"><strong>Added Date :</strong><?= mysql2date($row['created_date']) ?></span>

                                <?php if ($row['modified_by'] != '') { ?>
                                    <span class="date"><strong>Last Modified :</strong><?= $row['modified_date'] ?></span>
                                    <span class="date"><strong>Modified By :</strong><?= $row['modified_emp'] ?></span>
                                    <?php
                                }
                                if (empty($gradingDetails[0])) {
                                    ?>
                                    <a href="<?= site_url('assessment/view_list/' . $row['innvation'] . '/' . $row["id"] . '/' . $row['criteria']); ?>"  class="noPrint"><img src="<?= base_url(); ?>source/template/images/icons/edit.png" title="Edit" /></a>
                                    <?php
                                }
                                if (empty($gradingDetails[0])) {
                                    ?>
                                    <a href="javascript:void(0);" url="<?= site_url('assessment/delete_details/' . $row['innvation'] . '/' . $row['criteria'] . '/' . $row["id"]); ?>" class="delete confirmDelete noPrint" >Delete</a>
                                <?php }
                                ?>
                                <a class="reply noPrint" id="commentFormLink_<?= $row["id"] ?>" href="#commentForm_<?= $row["id"] ?>" >
                                    <?= ($innovation['isAssociate']) ? 'Post Reply' : 'Post Comments'; ?></a>
                            </div>
                            <?php
                            $assessComments = $this->Massessment->getAssessComments($row['id']);
                            if (count($assessComments)) {
                                ?>
                                <br />
                                <div class="boxed menu" style="padding:0 10px 10px 10px; border-radius:0; background:#fff; box-shadow:2px 2px 0 #fff;">
                                    <h2 style="margin:0px;">Comments</h2>

                                    <ul class="comments">

                                        <?php
                                        foreach ($assessComments as $com):
                                            ?>
                                            <li>
                                                <div class="comment-body clearfix">
                                                    <img class="comment-avatar" src="<?= base_url() ?>source/template/images/icons/dummy.gif" />
                                                    <div><?= $com['comments'] ?></div>
                                                    <div class="links">
                                                        <span class="date"><strong>Added By :</strong><?= !empty($com['created_emp']) ? $com['created_emp'] : 'Admin'; ?></span>
                                                        <span class="date"><strong>Added Date :</strong><?= mysql2date($com['created_date']) ?></span>
                                                        <?php
                                                        if (($this->session->userdata('emp_number') == $com['created_by'] || $isAuth)) {
                                                            ?>
                                                            <span class="date"><a href="javascript:void(0);" url="<?= site_url('assessment/delete_comments/' . $row['innvation'] . '/' . $row['criteria'] . '/' . $com["id"]); ?>" class="delete confirmDelete" style="float:right">Delete</a></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            $optionCount = (count($criteria) != 1) ? "/all" : '';
                            ?>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $("#commentFormLink_<?= $row["id"] ?>").fancybox({
                                        'titlePosition': 'inside',
                                        'transitionIn': 'none',
                                        'transitionOut': 'none'
                                    });
                                });
                            </script>
                            <div style="display:none">
                                <div id="commentForm_<?= $row['id'] ?>" style="width:600px;">
                                    <h2><?= ($innovation['isAssociate']) ? 'Post Reply' : 'Post Comments'; ?></h2>
                                    <form name="add_assess_comments" enctype="multipart/form-data"
                                          action="<?= site_url('assessment/add_comments/' . $innovation['id'] . '/' . $criteria['0']['id'] . '/' . $row['id'] . $optionCount) ?>"
                                          method="post" id="add_assess_comments_<?= $row['id'] ?>" class="uniform"  >
                                        <input type="hidden" name="assess_id" value=""  />
                                        <dl class="inline">
                                            <dt><label for="password">Comments</label></dt>
                                            <dd>
                                                <textarea name="comments" class="input-text" rows="5" cols="50" ></textarea>
                                            </dd>
                                            <div class="buttons">
                                                <input type="submit" value="Post Comments" name="txtSubmit" class="button" />
                                                <input type="reset" value="Reset" name="txtReset" class="button white" />
                                            </div>
                                        </dl>
                                    </form>
                                </div>
                            </div>

                        </li>
                        <?php
                    endforeach;
                }
            endforeach;
            ?>
        </ul>
        <?php
    }
    ?>

    <?php
    if (!count($assessDetails) && count($criteria) == '1') {
        echo ' <p class="t-center">No Details</p>';
    }
    ?>
    <!-- end id-form  -->

</div>
<!-- end id-form  -->
