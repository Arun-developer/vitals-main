<?php
if (php72_count($conversation) > 0) {
    foreach ($conversation as $chart) {
        $split_name = explode(' ', $chart['emp_name']);
        $first_name = ucfirst($split_name[0]);
        $title = "";
        foreach ($split_name as $words) {
            $title = $title . $words[0];
        }
        ?>
        <div class="indivdualChatmodel" >
            <ul>
                <li class="imageChat">
                    <span title="<?= ucwords($chart['emp_name']); ?>"><?= strtoupper($title); ?></span>
                </li>
                <li class="chatContent">
                    <label><?php echo strlen($first_name) > 12 ? substr($first_name, 0, 12) . "..." : $first_name; ?></label>
                    <label class="dateFormat"><?= date('d-M-Y, h:i A', strtotime($chart['created_at'])); ?></label>
                    <p><?= stripslashes($chart['comments']); ?></p>
                </li>
            </ul>
        </div>
        <?php
    }
} else {
    if ($this->session->userdata['sector_lead'] != 1 && $this->session->userdata['user_type'] != 'admin' && $this->session->userdata['user_type'] != 'superadmin') {
        ?>
        <p>No comments added by sector lead</p>
    <?php
    }
}
?>
