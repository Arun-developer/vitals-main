<html>

    <head>
        <title>Print</title>
        <script type="text/javascript">
            function Print() {
                window.focus();
                window.print();
                window.onfocus = function () {
                    window.close();
                }
            }
        </script>
    </head>

    <body onload="Print();">

        <h1 style="margin-top:10px;"><?= $cpagetitle ?> - <?= ucfirst($currentTab) ?> Innovations
            <?php if ($currentTab == 'similar') {
                echo '( ' . $name_of_enterprise . ' )';
            } ?></h1>
        <?php
        $nullLink = "javascript:void(0);";
        $form_name = "innovation_pool";

        $isAssign = false;
        $isExport = false;
        $isAssignCycle = false;
        $isDetails = true;
        if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) {
            $isAssign = true;
            $isExport = true;
            $isAssignCycle = true;
        }
        ?>


        <div id="dvData" style="overflow:visible">
            <table id="table1" class="gtable sortable">
                <thead>
                    <tr>
                        <?php if ($currentTab == 'lead') { ?>
                            <th><input type="checkbox" class="checkall" /></th>
<?php } ?>

                        <th>Select</th>

                        <th nowrap="nowrap">S N0</a></th>
                        <th nowrap="nowrap">INV ID</th>
                        <th nowrap="nowrap">Partner</th>
                        <th nowrap="nowrap">Name of the Incubatee</th>
                        <th nowrap="nowrap">Name of the Entrepreneur</th>
                        <th>Source/Category</th>
                        <th nowrap="nowrap">Source Type</th>
                        <th>Sector</th>
                        <th>Program</th>
                        <th>Stage</th>
                        <th>Status</th>
                        <th nowrap="nowrap">Registered Date</th>
                        <th>Geography</th>
                        <th>City</th>
                        <th>LIS</th>
                        <th nowrap="nowrap">Donor Fit</th>
                        <th nowrap="nowrap">Assign in-Charge</th>
                        <th nowrap="nowrap">Email</th>
                        <th nowrap="nowrap">Phone Number</th>
                        <th nowrap="nowrap">Submitted Date</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (php72_count($innovationList)) {
                        $i = 'odd';
                        $j = 0;
                        foreach ($innovationList as $row):
                            $loop = true;
                            $i = ($i == 'odd') ? 'even' : 'odd';
                            if ($row['program'] == '1')
                                $program = 'EIR';
                            else if ($row['program'] == '2')
                                $program = 'SEED';
                            else if ($row['program'] == '3')
                                $program = 'Unc Pitch';
                            else
                                $program = 'Incubation';
                            ?>
                            <tr class="<?= $i ?>">
                                <?php if ($row['status'] != '3' && in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio'))) { ?>
                                    <td><input type="checkbox" class="chk_box" name="innovation_id[]" value="<?= $row['id'] ?>" /></td>
                                <?php } else { ?>
                                    <td></td>
        <?php } ?>
                                <td><?php echo ++$j; ?></td>
                                <td><?= $row['innovation_id'] ?></td>
                                <td><?= ucfirst($row['branch_name']) ?></td>
                                <td><?= $row['name_of_enterprise'] ?></td>
                                <td><?= $row['name_of_entrepreneur'] ?></td>
                                <td><?= ($row['source_type'] == '0') ? 'Direct Application' : $row['source_type'] ?></td>
                                <td><?= (($row['source_type'] == '0') ? 'Direct Application' : empty($row['source_name'])) ? $row['source_others'] : $row['source_name'] ?>
                                </td>
                                <td><?php $sector = ($row['sector'] != '0' && $row['sector'] != '') ? (($row['sector'] == 'MCH') ? 'Maternal & child health' : $row['sector']) : (($row['sector_others'] != '0' && $row['sector_others'] != '') ? $row['sector_others'] : '');
        echo $sector; ?>
                                </td>
                                <td><?= $program ?></td>
                                <?php
                                $stage = $this->Minnovation->getInnvationStage();
                                $status = $this->Minnovation->getInnvationStatus();
                                ?>
                                <td><?= ($row['fstage'] == '') ? $stage[$row['stage']] : $row['fstage'] ?></td>
                                <td><?= $status[$row['status']] ?></td>
                                <td><?= mysql2date($row['created_date']) ?></td>
                                <td><?= $row['state'] ?></td>
                                <td><?= $row['city'] ?></td>
                                <td>
                                    <?php
                                    if (php72_cmp($row['LIS']) == 0)
                                        $lis = 'No';
                                    else if (php72_cmp($row['LIS']) == 1)
                                        $lis = 'Yes';
                                    else
                                        $lis = '';
                                    echo $lis;
                                    ?>
                                </td>
                                <td>
        <?php
        $names = $this->Minnovation->getDonorFitName($row['donor_fit']);
        $donor_fit = php72_implode(',', $names);
        echo $donor_fit;
        ?>
                                </td>
                                <td><?= $row['associate_emp_name'] ?></td>
                                <td><?= $row['email_id'] ?></td>
                                <td><?= $row['mobile_no'] ?></td>
                                <td><?= mysql2date($row['submitted_date']) ?></td>

                                <td style="white-space: nowrap">
                                    <?php
                                    if ($isDetails) {

                                        if ($this->session->userdata('user_name') == 'Altacit') {
                                            $detailLink = 'scouting/innovation_details/' . $row['id'];
                                        } else {
                                            if (($this->uri->segment('3') == 'incubation') || ($this->uri->segment('3') == 'assigned_incubation')) {

                                                $detailLink = 'login/myportfolio/' . $row['id'];
                                            } else if ($this->uri->segment('3') == 'decision_pending') {
                                                $detailLink = 'assessment/view_list/' . $row['id'];
                                            } else {
                                                $detailLink = 'login/assessment/' . $row['id'];
                                            }
                                        }
                                        ?>

                                        <a href="<?= site_url($detailLink) ?>"
                                           class="button"><?= ($row['grading_status'] == '1') ? 'Decision Pending' : 'Details'; ?></a>
                                    <?php } ?>
                                </td>
        <?php if ($this->session->userdata('user_type') == 'admin') { ?>
        <?php } ?>
                            </tr>

                                <?php
                            endforeach;
                        } else {
                            ?>


                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>No Records</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
    <?php if ($this->session->userdata('user_type') == 'admin') { ?>
                        <td></td>
    <?php } ?>

<?php } ?>


                </tbody>
            </table>

        </div>
    </body>

</html>