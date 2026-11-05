<script type="text/javascript">
// O2k7 skin (silver)
tinyMCE.init({
    // General options
    mode: "exact",
    elements: "editor",
    theme: "advanced",
    skin: "o2k7",
    skin_variant: "silver",
    plugins: "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

    // Theme options
    theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
    theme_advanced_toolbar_location: "top",
    theme_advanced_toolbar_align: "left",
    theme_advanced_statusbar_location: "bottom",
    theme_advanced_resizing: true,
    file_browser_callback: "airfilemanager",
    document_base_url: BASE_URL,
    relative_urls: true,
    remove_scripts_host: false
});

function airfilemanager(field_name, url, type, win) {
    switch (type) {
        case "media":
        case "image":
        case "flash":
        case "file":
            break;
        default:
            return !1;
    }
    tinyMCE.activeEditor.windowManager.open({
        url: BASE_URL + "source/airfilemanager/afm.php" + "?type=" + type,
        width: 780,
        height: 500,
        inline: "yes",
        close_previous: "no"
    }, {
        window: win,
        input: field_name
    });
}
</script>
<div class="clear" style="width:650px;"></div>

<h2><?=$cpagetitle?></h2>
<form name="step1" action="<?=site_url('screening/update_agreement/'.$innovation);?>" enctype="multipart/form-data"
    method="post" id="step1">
    <input type="hidden" name="innovation" value="<?=$innovation?>" />

    <?php
	foreach($innovationAgreement as $row): 
	?>
    <dl>
        <dt><label for="agreement">Agreement</label></dt>
        <dd><textarea name="agreement" id="editor" rows="7" cols="20"
                style="height:300px; width:400px;"><?=$row['agreement']?></textarea></dd>
    </dl>
    <?php 
	endforeach;
	?>
    <div class="buttons">
        <input type="submit" name="txtSubmit" value="Save" class="button">
        <input type="reset" name="txtReset" value="Reset" class="button white">
    </div>
</form>