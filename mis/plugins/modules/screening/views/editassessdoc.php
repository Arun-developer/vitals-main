<h2><?=$cpagetitle;?></h2>

<form name="editdoc" action="<?=site_url('screening/editassessdoc/'.$innovation.'/'.$id)?>" method="post">
  <input type="hidden" name="criteria" value="<?=$details[0]['criteria'];?>"/>
  <input type="hidden" name="field" value="<?=$details[0]['field'];?>"/>
  <input type="hidden" name="mastertype" value="<?=$details[0]['master_type'];?>"/>
  <dl class="inline">
  <fieldset>
    <dt><label for="master_name">Master Name</label></dt>
    <dd>
      <input type="text" name="mastername" value="<?=$details[0]['master_name'];?>"/>
    </dd>
    <dt><label for="master_name">Field</label></dt>
    <dd>
     <textarea style="width:40%;height:40%;" readonly="readonly" name="field_label"><?=$details[0]['label']?></textarea>
    </dd>
    <dt><label for="master_name">Description</label></dt>
    <dd>
     <textarea style="width:40%;height:40%;" name="document-description"><?=$details[0]['answer']?></textarea>
    </dd>
    <dt><label for="master_name">Document</label></dt>
    <dd>
      <input type="file" name="document" value=""/><label><?=$details[0]['documents'];?></label>
    </dd>
    <div class="buttons">
			<input type="submit" class="button" name="txtDocSubmit" value="Save" id="submit" />&nbsp;&nbsp;
			<input type="reset" class="button white" name="txtReset" value="Reset" />
		</div>
  </fieldset>
  </dl>
</form>
