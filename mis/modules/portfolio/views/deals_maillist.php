<div class="villgro-breadcrumb clearfix">
    <div class="row">
        <div class="col-md-12 col-12">
            <ul>
                <li> <a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">
                        Home <i class="fa fa-angle-double-right"></i>
                    </a></li>
                <li> <a href="<?= base_url() . 'index.php/portfolio/alldeals'; ?>">
                        All Deals <i class="fa fa-angle-double-right"></i>
                    </a></li>
                <li> <a href="<?= base_url() . 'index.php/login/deals_mail'; ?>">
                        Send Mail<i class="fa fa-angle-double-right"></i>
                    </a></li>
                <li> <a href="#" class="active">
                        Mail Reports
                    </a></li>
            </ul>
        </div>
    </div>
</div>
<form name="deals_maillist" action=""></form>

<ul class="option-tab">
    <li><a href="<?= site_url('login/deals_mail/'); ?>" class="button">Send Mail</a></li>
    <li><a href="<?= site_url('login/deals_mail/'); ?>" class="button">Back</a></li>
</ul>
<h1 class="h1-mail">Mail Reports</h1>
<br />
<table class="gtable sortable">
    <thead>
        <tr>
            <th style="width: 15%"><a href="javascript:void(0)" class="sortlink">Sent By</a></th>
            <th style="width: 15%"><a href="javascript:void(0)" class="sortlink">Sent Date & Time</a></th>
            <th style="width: 15%"><a href="javascript:void(0)" class="sortlink">Mail Template</a></th>
            <th style="width: 15%"><a href="javascript:void(0)" class="sortlink">Subject</a></th>
            <th style="width: 10%"><a href="javascript:void(0)" class="sortlink">Receipient Count</a></th>
            <th style="width: 10%"><a href="javascript:void(0)" class="sortlink">Success Count</a></th>
            <th style="width: 10%"><a href="javascript:void(0)" class="sortlink">Failure Count</a></th>
            <th style="width: 10%"><a href="javascript:void(0)" class="sortlink">Pending Count</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (php72_count($mail)) {
            $row_type = 'even';
            $partner_id = $this->session->userdata('partner_id');
            $mail_config = partner_smtp();
            $from_mail = $mail_config['smtp_user'];

            foreach ($mail as $row) {
                $mailtypes = $this->Mmailtemplate->getMailtype('', $row['mail_type']);
                $pendarr = $sucarr = $failarr = array();
                $pendarr[] = "status = 0";
                $pendarr[] = "bulk_id = " . $row['id'];
                $pendarrwhr = php72_implode(' and ', $pendarr);
                $pend_mail = $this->Mmail->MailDetails($pendarrwhr);

                $sucarr[] = "status = 1";
                $sucarr[] = "bulk_id = " . $row['id'];
                $sucarrwhr = php72_implode(' and ', $sucarr);
                $suc_mail = $this->Mmail->MailDetails($sucarrwhr);

                $failarr[] = "status = 2";
                $failarr[] = "bulk_id = " . $row['id'];
                $failarrwhr = implode(' and ', $failarr);
                $fail_mail = $this->Mmail->MailDetails($failarrwhr);

                $sender = $this->Muser->getUsersList($row['sender_id']);
                if (php72_cmp($row['status']) == 0) {
                    $status = 'Pending';
                } else if (php72_cmp($row['status']) == 1) {
                    $status = 'Sent';
                } else {
                    $status = 'Failed';
                }

                $row_type = ($row_type == 'odd') ? ('even') : ('odd');
                ?>
                <tr class="<?= $row_type ?>">
                    <td style="text-align: center;"><?php
                        if (php72_cmp($row['sender_id']) == 1) {
                            echo 'Super Admin';
                        } else {
                            echo $sender[0]['emp_name'];
                        }
                        ?></td>
                    <td style="text-align: center;"><?= date('d-M-Y g:i A', strtotime($row["created_at"])); ?></td>
                    <td style="text-align: center;"><a href="<?= site_url('master/mailtemplate/form/' . $mailtypes[0]["id"]); ?>" target="_blank"><?= $row["mail_type"]; ?></a></td>
                    <td style="text-align: center;"><?= $row["mail_subject"]; ?></td>
                    <td style="text-align: center;"><a href="<?= site_url('login/mailist_view/' . $row["id"]); ?>" class="fancybox"><?= $row["receipients_count"]; ?></a></td>
                    <td style="text-align: center;"><a href="<?= site_url('login/mailist_view/' . $row["id"] . '/1'); ?>" class="fancybox"><?= php72_count($suc_mail); ?></a></td>
                    <td style="text-align: center;"><a href="<?= site_url('login/mailist_view/' . $row["id"] . '/2'); ?>" class="fancybox"><?= php72_count($fail_mail); ?></a></td>
                    <td style="text-align: center;"><a href="<?= site_url('login/mailist_view/' . $row["id"] . '/0'); ?>" class="fancybox"><?= php72_count($pend_mail); ?></a></td>


                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan='9' align='center'>No Records found!</td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>

<?= $this->pagination->create_links('deals_maillist'); ?>
<style>
    .mailform {
        height: 100%;
        clear: both;
        display: grid;
    }
    .option-tab{
        margin-top:5px;
    }
</style>