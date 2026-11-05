<div class="vill_chatcardQuater">
    <div class="vil_month">
        <h6><?php echo $q_title . '<br>' . $month_title[0] . '-' . $month_title[2] . '<br> ' . $fin_year; ?></h6>
    </div>
    <div class="desc-wrap">
        <div class="chat_achievement ">
            <span><?php echo isset($plan_qual) ? date("d-M-Y, g:i A", strtotime($plan_qual[0]["created_at"])) : ''; ?></span>
            <div class="chat_achievement_inner greenBandQuater">
                <p><?php echo $plan_qual[0]["desc"]; ?></p>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="vill_chatcard one_chartChat">
    <div class="vil_month">
        <h6><?php echo $month_title[0] . ' ' . $fin_year; ?></h6>
    </div>
    <div class="desc-wrap">
        <div class="chat_plan">
            <span><?php echo isset($plan_qual) ? date("d-M-Y, g:i A", strtotime($plan_qual[0]["created_at"])) : ''; ?></span>
            <div class="chat_plan_inner">
                <?php echo $plan_qual[0]["first"]; ?>
            </div>
        </div>
        <div class="chat_achievement">
            <span><?php echo isset($actual_qual) ? date("d-M-Y, g:i A", strtotime($actual_qual[1]["created_at"])) : ''; ?></span>
            <div class="chat_achievement_inner">
                <p><?php echo isset($actual_qual) ? $actual_qual[1]["description"] : ''; ?></p>
            </div>
            <div class="chartnewbtnlabel">new</div>
        </div>
        <div class="close-link one" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a></div>
    </div>

    <div class="desc-fade"></div>
    <div class="open-link one" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a></div>
</div>
<div class="vill_chatcard two_chartChat">
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
                <p><?php echo isset($actual_qual) ? $actual_qual[2]["description"] : ''; ?></p>
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
                <p><?php echo isset($actual_qual) ? $actual_qual[3]["description"] : ''; ?></p>
            </div>
        </div>
        <div class="close-link three" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a></div>
    </div>

    <div class="desc-fade"></div>
    <div class="open-link three" style="display: block;"><a href="javascript:;"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></a></div>
</div>