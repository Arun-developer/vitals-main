<h1><?=$cpagetitle;?></h1>
<form name="ic_confirm" method="post" action="<?=site_url('screening/ic_confirm/'.$id);?>"
    enctype="multipart/form-data">
    <dl class="inline">
        <dt><label for="request_title_">Title</label></dt>
        <dd>
            <input type="text" name="title" class="medium" size="50" value="" />
        </dd>
        <dt><label for="description">Description</label></dt>
        <dd>
            <textarea name="description" id="editor" class="medium"></textarea><small> Brief Description</small>
        </dd>
        <dt><label for="interview">Decision</label></dt>
        <dd>
            <select name="decision">
                <option value="">-select-</option>
                <option value="1">Accepted</option>
                <option value="2">Rejected</option>
            </select>
        </dd>
        <dt><label for="document">Documents</label></dt>
        <dd> <input type="file" name="document" size=19 id="document" value="" /> </dd>
        <div class="buttons">
            <input type="submit" value="Save" class="button" name="txtSubmit" />
            <input type="reset" value="Reset" class="button white" />
        </div>
    </dl>
</form>