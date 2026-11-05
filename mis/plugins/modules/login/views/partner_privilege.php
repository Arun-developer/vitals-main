<ul class="option-tab">
    <li><a href="<?php echo $base_url; ?>/vital/index.php/login/master" class="button">Back</a></li>
</ul>

<h2 style="font-family:Gill !important;">Enabling AIS Sections </h2>

<form name="partner_privilege" action="<?= site_url('login/partner_privilege/'); ?>" method="post" id="partner_privilege" class="uniform">

    <dl class="inline">
        <?php foreach ($partner_data as $value) { ?>
            <dt>
                <label><?php echo $value['branch_name']; ?></label>
            </dt>
            <dd>
                <input type='hidden' value='0' name=<?php echo $value['partner_id']; ?>>
                <input type="checkbox" name=<?php echo $value['partner_id']; ?> value="1" <?php
                if ($value['ais_privilege'] == '1') {
                    echo "checked=checked";
                }
                ?> >
            </dd>
<?php } ?>

    </dl>

    <div class="clear"></div>
    <div class="buttons">
        <input type="submit" class="button"  name="partnerSubmit" value="Submit" />
    </div>

</form>