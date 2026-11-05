<?php $cur = $this->uri->segment('3');  
if($this->session->userdata('emp_type') != 'fellow') {?>
<div class="boxed menu">
    <h2>Innovation Pool</h2>
    <section>
        <ul>
            <li class="<?=($cur == 'assigned')?'active':'';?>"><a
                    href="<?=site_url('scouting/new_innovation/');?>">Create New Innovation</a></li>
            <li class="<?=($cur == 'assigned')?'active':'';?>"><a
                    href="<?=site_url('scouting/innovation_pool/assigned');?>">Assigned Innovations</a></li>
            <li class="<?=($cur == 'identified')?'active':'';?>"><a
                    href="<?=site_url('scouting/innovation_pool/identified');?>">My Applications</a></li>
            <li class="<?=($cur == 'all')?'active':'';?>"><a href="<?=site_url('scouting/innovation_pool/all');?>">All
                    Innovations</a></li>
            <li class="<?=($cur == 'lead')?'active':'';?>"><a
                    href="<?=site_url('scouting/innovation_pool/lead');?>">Lead Innovations</a></li>
            <li class="<?=($cur == 'lead')?'active':'';?>"><a
                    href="<?=site_url('common/report/innovation_report');?>">Innovation Reports</a></li>
            <li class="<?=($cur == 'old')?'active':'';?>"><a
                    href="<?=site_url('scouting/old_innovation/');?>">Innovation Archives</a></li>
        </ul>
    </section>
</div>
<?php } ?>