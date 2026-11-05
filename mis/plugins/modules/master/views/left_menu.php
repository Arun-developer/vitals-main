<?php if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') { ?>
    <h2>Master</h2>
    <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
        <nav id="topmenu" style="min-width:900px;">
            <ul id="mainmenu" class="sf-menu">
            <?php } else {
                ?>
                <nav id="topmenu" style="height:34px;min-width:900px;">
                    <ul id="mainmenu" class="sf-menu">
                        <?php
                    }
                    if ($this->session->userdata('user_type') == 'superadmin') {
                        $linkArray = array('master/user_setup' => 'User Setup',
                            'master/stageefficiency/setup' => 'Stage Efficiency',
                            'master/master_settings/view_list' => 'Master Settings',
                            'master/source/view_list' => 'Source/Instance Master',
                            'master/program_service/view_list' => 'Program Service Master',
                            'master/program_stage/view_list' => 'Program Stage Master',
                            'master/grade/view_list' => 'Grading Master',
                            'master/screening_master/view_list' => 'Screening Master',
                            'master/incub_progress_master/view_list' => 'Incubation Progress Master',
                            'master/master_settings/reject_reasons' => 'Reject Reasons',
                            'master/mailtemplate/view_list' => 'Mail Template Master',
                            'master/master_settings/donor_fit_list' => 'Donor Fit',
                            'master/master_settings/preliminary_reason' => 'Preliminary Reasons',
                            'master/master_settings/sector_details' => 'Sectors',
                            'master/master_settings/document_type' => 'Document Type',
                            'master/master_settings/meeting_type' => 'Meeting Type',
                            'master/master_settings/portfolio_list/designation' => 'Portfolio Settings',
                            'master/master_settings/sector_leads' => 'Sector Leads'
                        );
                    } else if ($this->session->userdata('partner_id') == '1' || $this->session->userdata('partner_id') == '10') {
                        $linkArray = array(
                            'master/master_settings/sector_details' => 'Sectors',
                            'master/master_settings/reject_reasons' => 'Reject Reasons',
                            'master/mailtemplate/view_list' => 'Mail Template Master',
                            'master/master_settings/donor_fit_list' => 'Donor Fit',
                            'master/master_settings/preliminary_reason' => 'Preliminary Reasons',
                            'master/user_setup' => 'User Setup',
                            'master/master_settings/portfolio_list/designation' => 'Portfolio Settings',
                            'master/master_settings/sector_leads' => 'Sector Leads'
                        );
                    } else {
                        $linkArray = array(
                            'master/master_settings/sector_details' => 'Sectors',
                            'master/master_settings/reject_reasons' => 'Reject Reasons',
                            'master/mailtemplate/view_list' => 'Mail Template Master',
                            'master/master_settings/donor_fit_list' => 'Donor Fit',
                            'master/master_settings/preliminary_reason' => 'Preliminary Reasons',
                            'master/user_setup' => 'User Setup',
                            'master/master_settings/sector_leads' => 'Sector Leads'
                        );
                    }

                    foreach ($linkArray as $href => $linkLabel):
                        $current = $this->uri->segment('2');
                        $current = ($current == 'means_validation') ? 'screening_master' : $current;

                        $ar = explode('/', $href);
                        if ($current == 'activity') {
                            $selected = (@$ar['2'] == $this->uri->segment('3') && $ar['1'] == $current ) ? 'submenu-active' : '';
                        } else {
                            $selected = ($ar['1'] == $current && $ar['2'] == 'view_list' && $ar['2'] == $this->uri->segment('3') ) ? 'submenu-active' : '';
                        }
                        ?>
                        <li class="<?= $selected ?>"><a href="<?= site_url($href); ?>"><?= $linkLabel ?></a>
                            <?php if ($current == 'master_settings' && $ar['1'] == $current && $ar['2'] == 'view_list' && $ar['2'] == $this->uri->segment('3')) { ?>
                                <ul>
                                    <?php
                                    $currentTab = $this->uri->segment('4');
                                    foreach ($masterType as $key => $value):
                                        ?>
                                        <li class="<?= (@$currentTab == $key) ? 'selected' : ''; ?>"><a href="<?= site_url('master/master_settings/view_list/' . $key); ?>"><?= $value ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php } ?>
                            <?php if ($current == 'master_settings' && $ar['1'] == $current && $ar['2'] == 'portfolio_list' && $ar['2'] == $this->uri->segment('3')) { ?>
                                <ul>
                                    <?php
                                    $currentTab = $this->uri->segment('4');
                                    foreach ($protoType as $key => $value):
                                        ?>
                                        <li class="<?= (@$currentTab == $key) ? 'selected' : ''; ?>"><a href="<?= site_url('master/master_settings/portfolio_list/' . $key); ?>"><?= $value ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php } ?>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
            </nav>
        <?php } ?>

