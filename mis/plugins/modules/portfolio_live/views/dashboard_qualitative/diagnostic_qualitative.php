<?php
$togg = array(1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve');
$t = 1;
foreach ($qtr_loop as $loopkey => $loopval) {
    if ($loopkey == 'q_four_desc') {
        $get_end_year = $this->Mportfolio->getFYtoYear($this->session->userdata('partner_id'), $fin_year);
        $fin_year = $get_end_year[0]['fin_to_year'];
    }
    if ($loopval == 0) {
        if ($loopkey == 'q_one_desc') {
            $month_tl = $get_month_list[0] . '-' . $get_month_list[2];
            $q_title = 'Q1';
        } else if ($loopkey == 'q_two_desc') {
            $month_tl = $get_month_list[3] . '-' . $get_month_list[5];
            $q_title = 'Q2';
        } else if ($loopkey == 'q_three_desc') {
            $month_tl = $get_month_list[6] . '-' . $get_month_list[8];
            $q_title = 'Q3';
        } else if ($loopkey == 'q_four_desc') {
            $month_tl = $get_month_list[9] . '-' . $get_month_list[11];
            $q_title = 'Q4';
        }
        ?>
        <div class="vill_chatcardQuater">
            <div class="vil_month">
                <h6><?php echo $q_title . '<br>' . $month_tl . '<br> ' . $fin_year; ?></h6>
            </div>
            <div class="desc-wrap">
                <?php if ($plan_qual[0][$loopkey] != '') { ?>
                    <div class="chat_achievement minimizeplan">
                        <span><?php echo isset($plan_qual) ? date("d-M-Y, g:i A", strtotime($plan_qual[0]["created_at"])) : ''; ?></span>
                        <div class="chat_achievement_inner string_cond greenBandQuater">
                            <?php
                            $text = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $plan_qual[0][$loopkey]);
                            $qual_head_tags = strip_tags($text);
                            $qualhead_len = strlen($qual_head_tags);
                            $short_qual_text = substr($qual_head_tags, 0, 220);

                            if ($qualhead_len > 220) {
                                $sdisp = '';
                                $ldisp = 'style="display: none;"';
                            } else {
                                $sdisp = 'style="display: none;"';
                                $ldisp = '';
                            }
                            ?>
                            <p id="short_qual" <?= $sdisp; ?> ><?php echo preg_replace('/\s/', ' ', $short_qual_text); ?></p>

                            <p id="long_qual" <?= $ldisp; ?> ><?php echo preg_replace('/\s/', ' ', $qual_head_tags); ?></p>
                        </div>
                        <div class="close-link greenplan" style="display: none;" onclick="close_link(this, 'qual');"><a href="javascript:;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a></div>
                        <?php if ($qualhead_len > 220) { ?>
                            <div class="desc-fade"></div>
                            <div class="open-link greenplan" style="display: block;" onclick="open_link(this, 'qual');"><a href="javascript:;"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a></div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div>
        <div class="vill_chatcard <?= $togg[$t]; ?>_chartChat">
            <div class="vil_month">
                <h6><?php echo $month_title[$loopval] . ' ' . $fin_year; ?></h6>
            </div>
            <div class="desc-wrap">
                <?php if ($plan_qual[0][$loopkey] != '') { ?>
                    <div class="chat_plan minimizeplan">
                        <span><?php echo isset($plan_qual) ? date("d-M-Y, g:i A", strtotime($plan_qual[0]["created_at"])) : ''; ?></span>
                        <div class="chat_plan_inner string_cond">
                            <?php
                            $textplan = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $plan_qual[0][$loopkey]);
                            $plan_tags = strip_tags($textplan);
                            $plan_len = strlen($plan_tags);
                            $short_plan_text = substr($plan_tags, 0, 220);

                            if ($plan_len > 220) {
                                $splandisp = '';
                                $lplandisp = 'style="display: none;"';
                            } else {
                                $splandisp = 'style="display: none;"';
                                $lplandisp = '';
                            }
                            ?>
                            <p id="short_plan" <?= $splandisp; ?> ><?php echo preg_replace('/\s/', ' ', $short_plan_text); ?></p>

                            <p id="long_plan" <?= $lplandisp; ?> ><?php echo preg_replace('/\s/', ' ', $plan_tags); ?></p>
                        </div>
                        <div class="close-link oneplan" style="display: none;" onclick="close_link(this, 'plan');"><a href="javascript:;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a></div>
                        <?php if ($plan_len > 220) { ?>
                            <div class="desc-fade"></div>
                            <div class="open-link oneplan" style="display: block;" onclick="open_link(this, 'plan');"><a href="javascript:;"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a></div>
                        <?php } ?>
                    </div>
                    <?php
                }
                if ($actual_qual[$loopval][0]["description"] != '') {
                    ?>
                    <div class="chat_achievement minimize_acm">
                        <span><?php echo isset($actual_qual) ? date("d-M-Y, g:i A", strtotime($actual_qual[$loopval][0]["created_at"])) : ''; ?></span>
                        <div class="chat_achievement_inner string_cond">
                            <?php
                            $textactual = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $actual_qual[$loopval][0]["description"]);

                            $actualtags = strip_tags($textactual);
                            $actual_len = strlen($actualtags);
                            $short_actual_text = substr($actualtags, 0, 220);

                            if ($actual_len > 220) {
                                $sactdisp = '';
                                $lactdisp = 'style="display: none;"';
                            } else {
                                $sactdisp = 'style="display: none;"';
                                $lactdisp = '';
                            }
                            ?>
                            <p id="short_actual" <?= $sactdisp; ?> ><?php echo preg_replace('/\s/', ' ', $short_actual_text); ?></p>

                            <p id="long_actual" <?= $lactdisp; ?> ><?php echo preg_replace('/\s/', ' ', $actualtags); ?></p>
                        </div>
                        <!-- <div class="chartnewbtnlabel">new</div> -->
                        <div class="close-link oneAchivement" style="display: none;" onclick="close_link(this, 'actual');"><a href="javascript:;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a></div>
                        <?php if ($actual_len > 220) { ?>
                            <div class="desc-fade"></div>
                            <div class="open-link oneAchivement" style="display: block;" onclick="open_link(this, 'actual');"><a href="javascript:;"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a></div>
                        <?php } ?>
                        <!-- <div class="chartnewbtnlabel">new</div> -->
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="clearfix"></div>
        <?php
        $t++;
    }
}
?>
<!--<div class="vill_chatcard two_chartChat">
    <div class="vil_month">
        <h6><?php echo $month_title[1] . ' ' . $fin_year; ?></h6>
    </div>
    <div class="desc-wrap">
        <div class="chat_plan">
            <span><?php echo isset($plan_qual) ? date("d-M-Y, g:i A", strtotime($plan_qual[0]["created_at"])) : ''; ?></span>
            <div class="chat_plan_inner">
<?php echo $plan_qual[0]["second"]; ?>
            </div>
        </div>
        <div class="chat_achievement">
            <span><?php echo isset($actual_qual) ? date("d-M-Y, g:i A", strtotime($actual_qual[2]["created_at"])) : ''; ?></span>
            <div class="chat_achievement_inner">
                <p><?php echo isset($actual_qual) ? $actual_qual[2][0]["description"] : ''; ?></p>
            </div>
        </div>
        <div class="close-link two" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a></div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="desc-fade"></div>
    <div class="open-link two" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a></div>
</div>
<div class="vill_chatcard thr_chartChat">
    <div class="vil_month">
        <h6><?php echo $month_title[2] . ' ' . $fin_year; ?></h6>
    </div>
    <div class="desc-wrap">
        <div class="chat_plan">
            <span><?php echo isset($plan_qual) ? date("d-M-Y, g:i A", strtotime($plan_qual[0]["created_at"])) : ''; ?></span>
            <div class="chat_plan_inner">
<?php echo $plan_qual[0]["third"]; ?>
            </div>
        </div>
        <div class="chat_achievement">
            <span><?php echo isset($actual_qual) ? date("d-M-Y, g:i A", strtotime($actual_qual[3]["created_at"])) : ''; ?></span>
            <div class="chat_achievement_inner">
                <p><?php echo isset($actual_qual) ? $actual_qual[3][0]["description"] : ''; ?></p>
            </div>
        </div>
        <div class="close-link three" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a></div>
    </div>

    <div class="desc-fade"></div>
    <div class="open-link three" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a></div>-->
<!--</div>-->