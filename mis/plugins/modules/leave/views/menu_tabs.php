            <div class="Vital-Newmenu">
                <div class="row">
                    <div class="col">
                        <ul>
                            <?php
                            if($page == 'user'){
                                $req = 'active';
                            } else {
                                $req = '';
                            }

                            if($page == 'admin'){
                                $admn = 'active';
                            } else {
                                $admn = '';
                            }
                             ?>
                            <li><a href="<?php echo base_url() . 'index.php/portfolio/dashboard'; ?>"><i class="fas fa-home"></i> Home</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-tag"></i> Deals</a></li>
                                                                        <?php 
                            if($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin'){
                                ?>
                            <li class="<?= $req; ?>"><a href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                        <?php } else { ?>
                            <li class="<?= $req; ?>"><a href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><i class="fas fa-sync-alt"></i> Approve</a></li>
                            <?php } ?>
                            <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                            <li><a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary'; ?>"><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/login/resources'; ?>"><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href="<?php echo base_url() . 'index.php/login/reports'; ?>"><i class="fas fa-suitcase"></i> Reports</a></li>
                            <?php 
                            if($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin'){
                                ?>
                            <li class="<?= $admn; ?>"><a href="<?php echo base_url() . 'index.php/user/lists/3'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>