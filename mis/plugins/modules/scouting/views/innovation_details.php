<script type="text/javascript">
    $(document).ready(function () {
        $("#add_info").hide();
        $("#ex_info").show();

        $('#ex_info').click(function () {
            $("#add_info").slideToggle();
        });

        $('#print_form').click(function () {
            $('#print_table').show().printElement();
        });
    });
</script>

<?php
$isEdit = false;
$isAssignCycle = false;
if (((in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) && ($this->session->userdata('partner_id') == $innovationDetails[0]['partner_id'])) || ($this->session->userdata('user_type') == 'superadmin')) {
    $isEdit = true;
    $isAssignCycle = true;
}
foreach ($innovationDetails as $row):

    if ($row['created_by'] == $this->session->userdata('emp_number'))
        $isEdit = true;
    ?>
    <a href="javascript:void(0)" id="print_form" style="float:right" class="button">Print</a>
    <?php
    if ($isEdit) {
        ?>
        <a href="<?= site_url('scouting/new_innovation/' . $row['id']); ?>" style="float:right" class="button">Edit</a>
    <?php } ?>
    <?php if ($this->session->userdata('user_type') == 'employee') {
        ?>
        <a href="<?= site_url('scouting/innovation_pool/all') ?>" class="button" style="float:right">Back</a><?php } ?>
    <div id="print_table">
        <h1><?= $row['name_of_enterprise'] ?></h1>
        <ul>
            <li><strong>Stage</strong> : <?php
                if ($row['stage'] == '2' && $isAssignCycle) {
                    ?>
                    <a href="<?= site_url('scouting/cycle/' . $row['id']) ?>"
                       class="fancybox button"><?= $stage[$row['stage']] ?></a>
                       <?php
                   } else {
                       echo $stage[$row['stage']];
                   }
                   ?></li>
            <li><strong>Status</strong> : <?= $status[$row['status']] ?></li>
            <?php if (count($cycle)) { ?>
                <li><strong>Incubation Cycle</strong> :<a href="<?= site_url('scouting/cycle/' . $row['id']) ?>"
                                                          class="fancybox"><?= $cycle['0']['cycle_name'] ?></a> ( <a
                                                          href="<?= site_url('scouting/cycle_history/' . $row['id']) ?>" class="fancybox">View History</a> )</li>
                    <?php
                }
                if ($row['comments'] != '') {
                    ?>
                <li><strong>Comments</strong> : <?= $row['comments'] ?> </li>
                <?php
            }
            if ($row['reasons_title'] != '') {
                ?>
                <li><strong>Reasons</strong>: <?= $row['reasons_title'] ?></li>
            <?php } ?>
        </ul>

        <table class="gtable detailtable">
            <thead>
                <tr>
                    <th colspan="2"><?= $row['name_of_enterprise'] ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:40%">Innovation Id </td>
                    <td><?= $row['innovation_id'] ?></td>
                </tr>
                <tr>
                    <td>Partner</td>
                    <td><?= ucfirst($row['branch_name']) ?></td>
                </tr>
                <tr>
                    <td>Name of your Entreprise</td>
                    <td><?= $row['name_of_enterprise'] ?></td>
                </tr>
                <tr>
                    <td>Name of the Promoter</td>
                    <td><?= $row['name_of_entrepreneur'] ?></td>
                </tr>
                <tr>
                    <td>A Short Summary of your Business.What Product / services do your offer? </td>
                    <td><?= nl2br($row['summary_of_business']); ?></td>
                </tr>
                <tr>
                    <td>Mobile Number</td>
                    <td><?= $row['mobile_no'] ?></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><?= $row['phone_no'] ?></td>
                </tr>
                <tr>
                    <td>Email Address</td>
                    <td><?= $row['email_id'] ?></td>
                </tr>

                <?php if ($row['business_plan_document'] != "") { ?>
                    <tr>
                        <td>Business Plan Document</td>
                        <td>

                            <a href="<?= base_url(); ?>uploads/innovaton/supporting_documents/<?= $row['business_plan_document'] ?>"
                               target="_blank">
                                   <?= $row['business_plan_document'] ?>
                                <img src="<?= base_url(); ?>source/template/images/icons/download.gif" alt="Download"
                                     height="16" />
                            </a></td>
                    </tr>
                <?php } ?>

                <tr>
                    <td>Any other supporting document you would like to share pertaining to the product/service?</td>
                    <td>
                        <?php if ($row['innovation_document'] == 0) { ?>No documents shared&nbsp;&nbsp;
                        <?php } ?>
                        <a href="<?= site_url('scouting/innovation_document/' . $row['id']); ?>"
                           class="fancyboxIframe button">
                            <?= ($row['innovation_document'] == 0) ? 'Add' : 'View'; ?> Documents</a>
                    </td>
                </tr>
                <tr>
                    <td><a href="#bottom" id="ex_info" style="color:#719e41;">** Additional Information</a>
                        <table id="add_info" class="gtable detailtable">
                            <?php if ($row['source_name'] != '' || $row['source'] == '-1' || $row['source_others'] != '') { ?>
                                <tr>
                                    <td>Source Type</td>
                                    <td><?= $row['source_type'] ?></td>
                                </tr>
                                <tr>
                                    <td>Source</td>
                                    <td><?= ($row['source'] != '-1' ? $row['source_name'] : ($row['source'] == '-1' ? 'others' : '')); ?><?php echo (!empty($row['source_others']) && $row['source'] == '-1') ? '-' . $row['source_others'] : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Instance</td>
                                    <td><?= $row['instance_name'] ?></td>
                                </tr>

                            <?php } ?>
                            <tr>
                                <td>Sector</td>
                                <td><?= $row['sector'] ?>
                                    <?php echo (!empty($row['sector_others']) && $row['sector'] == 'others') ? '-' . $row['sector_others'] : '' ?>
                                </td>
                            </tr>

                            <tr>
                                <td>Address Line1</td>
                                <td><?= $row['address_line1'] ?></td>
                            </tr>
                            <tr>
                                <td>Address Line1</td>
                                <td><?= $row['address_line2'] ?></td>
                            </tr>

                            <tr>
                                <td>City</td>
                                <td><?= $row['city'] ?></td>
                            </tr>
                            <tr>
                                <td>District</td>
                                <td><?= $row['district'] ?></td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td><?= $row['state'] ?></td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td><?= $row['country'] ?></td>
                            </tr>
                            <tr>
                                <td>Pin Code</td>
                                <td><?= $row['pincode'] ?></td>
                            </tr>


                            <tr>
                                <td>Website(If available)</td>
                                <td><a href="<?= $row['website']; ?>" target="_blank"><?= $row['website'] ?></a></td>
                            </tr>


                            <tr>
                                <td>For how long have you been in operation?</td>
                                <td><?= $row['entreprise_years'] ?></td>
                            </tr>
                            <tr>
                                <td>Do you Have a Business Plan ? </td>
                                <td><?= $row['business_plan'] ?></td>
                            </tr>

                            <?php if ($row['reference'] != '') { ?>
                                <tr>
                                    <td>Reference</td>
                                    <td><?= $row['reference'] ?></td>
                                </tr>
                                <?php
                            }
                            if ($row['other_reference'] != '') {
                                ?>
                                <tr>
                                    <td>Other Reference</td>
                                    <td><?= $row['other_reference'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td>Applied Date </td>
                                <td><?= mysql2date($row['created_date']) ?></td>
                            </tr>
                            <tr>
                                <td>Identified by </td>
                                <td><?= $row['created_emp'] ?></td>
                            </tr>
                            <tr>
                                <td>Last Modified</td>
                                <td><?= mysql2date($row['modified_date']) ?></td>
                            </tr>
                            <tr>
                                <td>Modified By</td>
                                <td><?= $row['modified_emp'] ?></td>
                            </tr>
                            </p>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
endforeach;
?>