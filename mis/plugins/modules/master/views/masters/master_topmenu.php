<div class="col">
    <ul>
        <li><a href=""><i class="fas fa-home"></i>&nbsp;Home</a></li>
        <li><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-tag"></i>&nbsp;Deals</a></li>
        <?php if ($this->session->userdata['user_type'] == 'employee' && $this->session->userdata['ais_privilege'] == '1') { ?>
            <li><a href="<?php echo base_url() . 'index.php/login/requests'; ?>"><i class="fas fa-sync-alt"></i>&nbsp;Requests</a></li>
        <?php } ?>
        <?php if ($this->session->userdata['ais_privilege'] == '1') { ?>
            <li><a href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><i class="far fa-check-square"></i>&nbsp;Approve</a></li>
        <?php } ?>
        <li><a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary'; ?>"><i class="far fa-chart-bar"></i>&nbsp;Portfolio</a></li>
        <li><a href="<?php echo base_url() . 'index.php/login/resources'; ?>"><i class="fas fa-archive"></i>&nbsp;Resources</a></li>
        <li><a href="<?php echo base_url() . 'index.php/login/reports'; ?>"><i class="fas fa-suitcase"></i>&nbsp;Reports</a></li>
        <?php if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
            <li class="active"><a href="<?php echo base_url() . 'index.php/login/master'; ?>"><i class="fas fa-user-friends"></i>&nbsp;Master's</a></li>
            <?php } ?>
    </ul>
</div>