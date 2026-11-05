<?php
	$currentTab = $this->uri->segment('1'); 
	$id =$innovation['id'];

?>

<div class="boxed menu">

    <h2>Innovation Services</h2>

    <section>
        <?php if($this->session->userdata('user_type') == 'incubatee') { ?>
        <ul>
            <li class="<?=($currentTab == 'incubation')?'selected':'';?>"><a
                    href="<?=site_url('seedfunding/view/'.$id);?>">Seed Funding</a></li>
            <li class="<?=($currentTab == 'incubation')?'selected':'';?>"><a
                    href="<?=site_url('boardmember/view_list/'.$id);?>">Board Meeting</a></li>
        </ul>
        <?php } else {?>

        <ul>

            <li class="<?=($currentTab == 'incubation')?'selected':'';?>">

                <a href="<?=site_url('seedfunding/view/'.$id);?>">Seed Funding</a></li>

            <li class="<?=($currentTab == 'incubation')?'selected':'';?>">

                <a href="<?=site_url('boardmember/view_list/'.$id);?>">Board Meeting</a></li>

            <li class="<?=($currentTab == 'incubation')?'selected':'';?>">

                <a href="<?=site_url('activities/index/'.$id);?>">Activity</a></li>

            <li><a href="<?=site_url('assign_incubation/assign_incubation/assign_checklist/'.$innovation['id']);?>">Assign
                    Metrics Incubation</a></li>

            <li><a href="<?=site_url('reports/progress_report/index/'.$innovation['id']);?>">Incubation Progress
                    Report</a></li>

        </ul>
        <?php } ?>
    </section>
</div>