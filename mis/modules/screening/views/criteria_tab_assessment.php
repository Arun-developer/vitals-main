<?php
$pre_ic_status = array('Pending', 'Approved', 'Rejected');
?>
<input type="text" name="txtdocProduce" id="docProduceID" value="<?php echo $criteria; ?>" />
<?php
$masterTab = array(
    'm1' => "Document to Produce", 'm2' => "Document to Verify", 'm3' => "People to Meet",
);
$criteriaId = $this->uri->segment("4");
$criteria = $this->uri->segment("5");

?>
<div id="showMaster">
    <ul class="tabs">
        <?php foreach ($masterTab as $masterKey => $masterValue): ?>

        <li class="<?php if ($this->uri->segment('4') == $masterKey) {echo "selected";}?>">
            <a href="<?=site_url('screening/peoplemeet/' . $this->uri->segment('3') . '/' . $masterKey);?>"
                id="masterTabID"><?=$masterValue?></a>
        </li>
        <?php endforeach;?>
    </ul>
</div>
<ul class="tabs">
    <?php foreach ($criteriaList as $value): ?>

    <li class="<?=($criteria == $value['id']) ? 'selected' : '';?>">
        <a
            href="<?=site_url('screening/assessform/' . $this->uri->segment('3') . '/' . $value['id']);?>"><?=$value['master_name']?></a>
    </li>
    <?php endforeach;?>
</ul>
<br />