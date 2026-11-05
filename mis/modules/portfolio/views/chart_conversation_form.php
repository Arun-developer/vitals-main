
<div class="newChatPortfolio-model" id="chatLoadDiv_<?= $chat_module_id; ?>">
    <form id="commentSubmit_<?= $chat_module_id; ?>" method="POST" autocomplete="off">
        <h3 class="wdt-100">Comments</h3>
        <div class="input-group">
            <input type="text" name="txt_description" id="text_description_<?= $chat_module_id; ?>" class="form-control" placeholder="Enter your comments">
            <div class="input-group-append">
                <input type="button" id="char_submit_<?= $chat_module_id; ?>" class="btn btn-secondary chatSubmit" value="Submit">
            </div>
        </div>
        <label for="text_description_<?= $chat_module_id; ?>" class="error"></label>
        <input type="text" name="chart_sector" id="chart_sector_id_<?= $chat_module_id; ?>" value="<?= $chat_sector; ?>">
        <input type="hidden" name="financial_year" id="chartFY_<?= $chat_module_id; ?>" value="<?= $chart_fyear; ?>">
        <input type="hidden" name="module_id" id="chart_module_id_<?= $chat_module_id; ?>" value="<?= $chat_module_id; ?>">
        <input type="hidden" id="chart_partner_id_<?= $chat_module_id; ?>" value="<?= $this->session->userdata['partner_id']; ?>">
        <input type="hidden" name="page_id" value="2">
    </form>
    <div class="clearfix"></div>
    <span class="text-success" id="commentMsg_<?= $chat_module_id; ?>"></span>
    <div class="chatWindow-model" id="chart_conversation_data_<?= $chat_module_id; ?>">
        <?php
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
        <?php } ?>
        <div id="chart_load_conversation_<?= $chat_module_id; ?>"></div>
    </div>
</div>


<script>

    var limit = 5;
    var start = 0;
    var action = 'inactive';
    var dynamic_id = "<?= $chat_module_id; ?>";

    $('#commentSubmit_' + dynamic_id).validate({
        rules: {
            txt_description: "required"
        },
        messages: {
            txt_description: "Please enter description"
        }
    });

    $(document).on('keypress', '#text_description_' + dynamic_id, function (e) {
        var current_id = $(this).attr('id');
        var split_id = current_id.split("_");
        var actual_id = split_id[2];
        var key = e.which;
        if (key == 13) {
            $('#char_submit_' + actual_id).click();
            return false;
        }
    });

    $(document).on('click', '#char_submit_' + dynamic_id, function (e) {
        e.preventDefault();
        var current_id = $(this).attr('id');
        var split_id = current_id.split("_");
        var actual_id = split_id[2];
        if ($('#commentSubmit_' + actual_id).valid()) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() . 'index.php/portfolio/addChartConversation'; ?>",
                data: $('#commentSubmit_' + actual_id).serialize(),
                success: function (output) {
                    $("#commentSubmit_" + actual_id)[0].reset();
                    $('#commentMsg_' + actual_id).html('Comment posted successfully');
                    setTimeout(function () {
                        $('#commentMsg_' + actual_id).html('');
//                        $("#chart_conversation_data_" + actual_id).load("#chart_conversation_data_" + actual_id);
                        $("#chatLoadDiv_" + actual_id).load(location.href + " #chatLoadDiv_" + actual_id);
                    }, 3000);

                }
            });
        }
    });
</script>