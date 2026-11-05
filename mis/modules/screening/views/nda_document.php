<?php

$isAuth = false;
if(in_array($this->session->userdata('user_type'),array('admin','ceo','cio')) || $innovation['isAssociate'])
{
	$isAuth = true;
}
?>
<h1><?php echo $cpagetitle.' - '.$innovation['name_of_enterprise']; ?></h1>

<?php if($isAuth && count($ndaList) == 0){ ?>
<div style="margin-left:480px;">

    <form name="frmEdit" action="<?=site_url('screening/editnda_docs/'.$innovation['id']);?>" method="post">
        <a href="<?=site_url('screening/nda_copy1/'.$innovation["id"]);?>" class="fancybox button">Upload Signed
            Document</a>
        <input type="hidden" value="edit" name="ndaEdit">
        <a href="<?=site_url('screening/editnda_docs/'.$innovation['id']);?>" class="fancybox button">Edit NDA
            Document</a>
    </form>

</div>
<br />
<br />
<?php } ?>


<!--Start NDA Docs -->

<?php  foreach($templateDetails as $row) { ?>
<div id="showAgreement"><?php echo $row['body']; ?></div>
<?php } ?>

<!--End NDA Docs -->
<?php 
if(count($ndaList)) {
$i = 0;
foreach($ndaList as $row):
		?>
<form>
    <fieldset>
        <legend>NDA Document By Villgro</legend>
        <dl class="inline">
            <dt><label for="">Document</label></dt>
            <dd><?php echo $row['copy1']; ?>
                <a href="<?=base_url();?>uploads/nda/<?php echo $row['copy1']; ?>" target="_blank">
                    <img src="<?=base_url();?>source/template/images/icons/download.gif" alt="Download"
                        height="16" /></a></dd>

            <?php if($isAuth){ ?> <dt><label for="">Upload</label></dt>
            <dd>
                <a href="<?=site_url('screening/nda_copy1/'.$row["innovation"].'/'.$row["id"]);?>" class="fancybox">
                    <img src="<?=base_url();?>source/template/images/icons/edit.png" alt="Edit" /></a>
            </dd>
            <?php } ?>
            <dt><label for="">Added Date</label></dt>
            <dd><?=mysql2date($row['copy1_date'])?></dd>

            <dt><label for="">Added Employee</label></dt>
            <dd><?=$row['created_emp']?></dd>

        </dl>
    </fieldset>
    <fieldset>
        <legend>NDA Document by <?=$innovation['name_of_enterprise']?></legend>
        <dl class="inline">
            <dt><label for="">Document</label></dt>
            <dd><?php echo $row['copy2']; 
			if($row['copy2'] != ''){ ?>
                <a href="<?=base_url();?>uploads/nda/<?php echo $row['copy2']; ?>" target="_blank">
                    <img src="<?=base_url();?>source/template/images/icons/download.gif" alt="Download"
                        height="16" /></a>
                <?php } ?></dd>


            <dt><label for="">Terms & Condition</label></dt>
            <dd>
                <input type="checkbox" id="ischecked" />
                <span style="font-weight:bold;">Please accept the terms & condition to upload the signed copy of the NDA
                    Document.</span></dd>

            <div id="showUpload" style="display:none">
                <dt><label for="">Upload</label></dt>
                <dd><a href="<?=site_url('screening/nda_copy1/'.$row["innovation"].'/'.$row["id"].'/copy2');?>"
                        class="fancybox">
                        <img src="<?=base_url();?>source/template/images/icons/edit.png" alt="Edit" /> Click here to
                        upload signed copy</a></dd>
            </div>

            <dt><label for="">Added Date</label></dt>
            <dd><?=mysql2date($row['copy2_date'])?></dd>

        </dl>
    </fieldset>

</form>
<?php 
	endforeach;
}
else
{
	echo 'No Documents Added';
}

if(!$this->Mauth->isLogged() && $innovation["accept_status"] == '0') { 
?>
<br />
<div class="buttons">
    <a href="<?=site_url('screening/accept/'.$this->uri->segment('3'));?>" class="button">Continue</a>
</div>
<?php 
}
?>

<script type="text/javascript">
var accepted = document.getElementById("ischecked");

$("#showUpload").hide();

$("#ischecked").click(function() {
    $("#showUpload").show();
});
</script>


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