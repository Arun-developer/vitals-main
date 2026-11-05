<script type="text/javascript">
$(document).ready(function() {

    var k = '';
    $(':checkbox:checked').each(function() {
        h = $(this).attr('value');
        if (k != '')
            k = k + ',' + h;
        else if (h != 'on')
            k = h;
        $('input[name=innovation]').val(k);
    });
    if (k == '') {}
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $.metadata.setType("attr", "validate");
    $("#action").validate();
});
</script>
<h2>Assign Incubation Cycle </h2>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>

<form name="action" enctype="multipart/form-data" action="<?=site_url('scouting/multi_cycle/');?>" method="post"
    id="action">
    <input type="hidden" name="innovation" />
    <dl class="inline">
        <dt><label for="source_type">Incubation Cycle:<font color="red">*</font></label></dt>
        <dd>
            <select name="cycle">
                <option value="">-Select-</option>
                <?php
            foreach($cycleList as $row):
                ?>
                <option value="<?=$row['id']?>"><?=$row['master_name']?></option>
                <?php 
            endforeach;
          ?>
            </select>
        </dd>
        <dt><label for="source_type">Comments:<font color="red">*</font></label></dt>
        <dd><textarea name="comments" class="input-text" cols="40" rows="4"></textarea></dd>
    </dl>
    <div class="clear"></div>
    <div class="buttons">
        <input type="submit" value="Save" name="txtSubmit" class="button" />
        <input type="reset" value="Reset" name="txtReset" class="button white" />
    </div>


</form>

<!-- end id-form  -->