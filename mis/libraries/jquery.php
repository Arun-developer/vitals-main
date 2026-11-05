<?php
class Jquery {
	
	 function fancybox()
	 {
		?>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>source/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		<script type="text/javascript" src="<?=base_url()?>source/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="<?=base_url()?>source/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="<?=base_url()?>source/fancybox/custom.fancybox.js"></script>
        <?php
	 }
	 
	 function jvalidate()
	 {
		 ?>
        <script src="<?php echo base_url();?>source/validate/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>source/validate/jquery.metadata.js" type="text/javascript"></script>
        <script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            jQuery.validator.addMethod("phone", function(value, element) { 
                  return this.optional(element) || /^[\+0-9\-]+$/.test(value); 
                }, "Please Enter Valid Phone Number");
            jQuery.validator.addMethod("mobile", function(value, element) { 
                  return this.optional(element) || /^[\+0-9\-]+$/.test(value); 
                }, "Please Enter Valid Mobile Number");
            $(".uniform").validate();
		  });
		 </script>
         <?php
	 }
	 
	 function jalert()
	 {
		 ?>
         <link type="text/css" href="<?=base_url()?>source/alerts/jquery.alerts.css" rel="stylesheet" />	
         <script type="text/javascript" src="<?=base_url()?>source/alerts/jquery.alerts.js"></script>
        <!-- <script type="text/javascript">
			$(document).ready( function() {
				//confirmantion Box
					$(".confirmDelete").click( function() {
						var linkUrl = $(this).attr('url');
						jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
							if(r)
							{
								$(window.location).attr('href',linkUrl);
							}
							
						});
					});
			  });
		  </script> -->
         <?php 
	 }
	 
	 function tinymce()
	 {
		 ?>
		 <script type="text/javascript" src="<?=base_url()?>source/tiny_mce/tiny_mce.js"></script>
         <script type="text/javascript">
		// O2k7 skin (silver)
		tinyMCE.init({
			// General options
			mode : "exact",
			elements : "editor",
			theme : "advanced",
			skin : "o2k7",
			skin_variant : "silver",
			plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
	
			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			file_browser_callback:"airfilemanager",
			document_base_url: BASE_URL,
			relative_urls:true,
			remove_scripts_host:false
		});
		function airfilemanager(field_name, url, type, win) {
				switch(type) { 
					case "media":
					case "image":
					case "flash":
					case "file": 
					break;
					default:
					return !1;
				}
				tinyMCE.activeEditor.windowManager.open({ 
				url: BASE_URL+"source/airfilemanager/afm.php"+"?type="+type, 
				width: 780, 
				height: 500, 
				inline: "yes", 
				close_previous: "no"
				},{ window: win, input: field_name });
			}
		</script>
         <?php
	 }
	 
	 function jqueryui()
	 {
		 ?>
        <link type="text/css" href="<?=base_url()?>source/jquery_ui/css/south-street/ui.multiselect.css" rel="stylesheet" />
        <link type="text/css" href="<?=base_url()?>source/jquery_ui/css/south-street/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="<?=base_url()?>source/jquery_ui/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>source/jquery_ui/js/ui.multiselect.js"></script>
        <script type="text/javascript" src="<?=base_url()?>source/jquery_ui/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?=base_url()?>source/jquery_ui/js/custom-ui.js"></script>
         <?php
	 }
	 
	 function uniform()
	 {
		?>
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/uniform.default.css">
		<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.uniform.min.js"></script>
        <script type="text/javascript">
		 $(document).ready( function() {
        	 $('.uniform input[type="checkbox"], .uniform input[type="radio"], .uniform input[type="file"]').uniform();
		 });
		 </script>
        <?php
	 }
	 
	 function facebox()
	 {
		?>
    	<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/facebox.css">
		<script type="text/javascript" src="<?=base_url();?>source/template/js/facebox.js"></script>
        <?php
	 }
	 
	 function superfish()
	 {
		?>
    	<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/superfish.css">
		<script type="text/javascript" src="<?=base_url();?>source/template/js/superfish.js"></script>
        <script type="text/javascript">
		$(document).ready(function() {
		$('ul.sf-menu').superfish({delay:107,animation:false,dropShadows:false});
		});
		</script>
        <?php
	 }
	 
	 function wysiwyg()
	 {
		?>
    	<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/jquery.wysiwyg.css">
		<script type="text/javascript" src="<?=base_url();?>source/template/js/jquery.wysiwyg.js"></script>
        <script type="application/javascript">
        $(function($){
                $('#wysiwyg').wysiwyg();
        }
		</script>
        <?php
	 }
 
 }
?>
