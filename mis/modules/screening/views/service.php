<?php
$isAuth = false;
if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) {
    $isAuth = true;
}
?>
<fieldset>
    <legend>Select Services</legend>
    <dl class="inline">
        <dt><label for="board_details">Services that you would like to avail from Villgro</label></dt>
        <dd>
            <?php
$this->load->model('master/Mprogram_service');
$cfValue = $this->Mscreening->getInnovationService($innovation['id']);
$programService = $this->Mprogram_service->getProgramServiceCombo('46');

foreach ($programService as $rw):

?>
            <script type="text/javascript">
            $(document).ready(function() {
                $("#descriptionLink_<?=$rw["id"]?>").fancybox({
                    'titlePosition': 'inside',
                    'transitionIn': 'none',
                    'transitionOut': 'none'
                });
            });
            </script>
            <div style="display:none">
                <div id="description_<?=$rw["id"]?>" style="width:500px;">
                    <h2><?=$rw['title']?></h2>
                    <?=$rw["description"]?>
                </div>
            </div>

            <?php
$detail_link = '<a id="descriptionLink_' . $rw["id"] . '" href="#description_' . $rw["id"] . '" > (Info) </a>';
if ($isView) {
    echo (php72_in_array($rw['id'], $cfValue)) ? $rw['title'] . $detail_link . '<br/>' : '';
} else {
    ?>
            <label><input type="checkbox" name="services[]" value="<?=$rw['id']?>"
                    <?=(php72_in_array($rw['id'], $cfValue)) ? 'checked="checked"' : '';?> />
                <?=$rw['title']?></label><?=$detail_link?><br />
            <?php
}
endforeach;
?>
        </dd>
    </dl>
</fieldset>