<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>video gallery</title>
<h2><?=$cpagetitle;?></h2>
<style>
    .event-table{border-collapse: collapse;border-right: 1px solid #BAD0E4;border-top: 1px solid #BAD0E4;margin: 1em auto;width:100%;text-align: left;font-size: 13px;}
.event-table div.list-footer{margin-top: 1%;margin-right: 25%;width: auto;}
.event-table .counter{margin-left:58%;}
.event-table tfoot td{border-right: 1px solid #FFF;background:none;border-left:1px solid #fff;border-bottom:1px solid #fff;}
.event-table a{text-decoration: none;color:#265D89;}
.event-table a:hover{text-decoration: underline;}
.event-table th{border-left:1px solid #BAD0E4;border-bottom:1px solid #BAD0E4;padding:0.3em 1em;}
.event-table thead th{background-color: #F4F9FE;color: #0F3756;font-size:13px;font-weight:normal;}
.event-table tr.even td{background-color: #F7FBFF;}
.event-table td{background-color: #FFFFFF;border-bottom: 1px solid #BAD0E4;border-left: 1px solid #BAD0E4;color: #323131;padding: 0.3em 1em;}
#search input[type="text"] {
    background: url(search-white.png) no-repeat 10px 6px #444;
    border: 0 none;
    font: bold 12px Arial,Helvetica,Sans-serif;
    color: #d7d7d7;
    width:150px;
    padding: 6px 15px 6px 35px;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
    text-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 3px rgba(0, 0, 0, 0.2) inset;
    -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 3px rgba(0, 0, 0, 0.2) inset;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 3px rgba(0, 0, 0, 0.2) inset;
    -webkit-transition: all 0.7s ease 0s;
    -moz-transition: all 0.7s ease 0s;
    -o-transition: all 0.7s ease 0s;
    transition: all 0.7s ease 0s;
    }
#search input[type="text"]:focus {
    background: url(search-dark.png) no-repeat 10px 6px #fcfcfc;
    color: #6a6f75;
    width: 200px;
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(0, 0, 0, 0.9) inset;
    -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(0, 0, 0, 0.9) inset;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(0, 0, 0, 0.9) inset;
    text-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
    }
</style>
<script type="text/javascript" src="http://gettopup.com/releases/latest/top_up-min.js"></script> 

<script type="text/javascript" src="<?=base_url();?>source/template/javascripts/top_up-min.js"/>
<link rel="stylesheet" href="<?=base_url();?>source/template/stylesheets/style.css"/>
<link rel="stylesheet" href="<?=base_url();?>source/template/stylesheets/example.css"/>
<script type="text/javascript">
    function getcontent(path)
    {
       var paths = path;
       var datas = $.ajax({	
            type: "POST",
            url: "<?php echo site_url('imggallery/example/getfolder');?>",
            data: {'paths':paths,'isajax':true},
            dataType:'json',
            success: function(datas) {
                var m = populateSelectbox(datas);
            }
        });
    }
    
</script>
</head>
    <body>
	<form method="post" action="<?php echo site_url('imggallery/example/searchkeyword')?>" id="search">
  	<input name="q"  type="text" size="40" placeholder="Search..." />
	</form>
	<div align="right" style="padding-left:230px;">
	<a class="fancyboxIframe" href="<?php echo site_url('imggallery/example/fileupload/?path='.$_SERVER['REQUEST_URI'])?>"><img src="<?php echo base_url();?>source/template/images/file_add.png" height="25" width="25" title="Upload"/></a>&nbsp;&nbsp;
	<a class="fancybox" href="<?php echo site_url('imggallery/example/createfolder/?path='.$_SERVER['REQUEST_URI'])?>"><img src="<?php echo base_url();?>source/template/images/folder-new.png" height="25" width="25" title="New Folder"/></a>&nbsp;&nbsp;
	<a href=""><img src="<?php echo base_url();?>source/template/images/GetOpenContent.gif" height="25" width="25" title="Get Link"/></a>&nbsp;&nbsp;
	<a href=""><img src="<?php echo base_url();?>source/template/images/edit_delete.png" height="25" width="25" title="Show Delete Information"/></a>&nbsp;&nbsp;
	</div>
    <div>
        <?php
        $folder = (array)$folder; ?>
        <table id="tableId" class="event-table">
            <tr>
                <thead>
                    <th>Name</th>
                    <th>Kind</th>
                    <th>Modified</th>
                </thead>
            </tr>
            <tbody>
                <?php for($i=0,$count = count($folder['contents']);$i<$count;$i++) {  
                   
                    $content = $folder['contents'][$i]; 
					
						$name = join("/", array_slice(explode("/", $content->path), 2));	
                ?>
                <tr>
                    <?php 
					if($content->icon == 'folder' || $content->icon == 'folder_user')
                    {  $file = join("/", array_slice(explode("/", $content->path), 1));?>
                    <td><img style="float:left;" height="35" width="30" src="<?php echo base_url();?>source/template/images/icon.png"/>
                        &nbsp;&nbsp;<p style="margin-top:-15px; padding-left: 45px;"><a href="<?php echo site_url('imggallery/example/get_folder/'.$name)?>" ><b><?php echo $name;?></b></a></p></td>
                        <?php } 
					elseif($content->icon == 'page_white_picture') 
						{ $nam = join("/", array_slice(explode("/", $content->path), 3));$filename = join("/", array_slice(explode("/", $content->path), 4));         if($filename == $nam){
							$filename = NULL;
						}
						?>
                    <td><p style="margin-top:-15px; padding-left: 45px;"><a href="<?php echo site_url('imggallery/example/get_link/'.$name);?>" ><b><?php echo $name;?></b></a></p></td>
                    <?php }else { ?>
	                    <td><p style="margin-top:-15px; padding-left: 45px;"><a href="<?php echo site_url('imggallery/example/get_videolink/'.$name);?>" ><b><?php echo $name;?></b></a></p></td>
					<?php } ?>
                    <td><a href=""><?php echo $content->icon;?></a></td>
                    <td><a href=""><?php echo $content->modified;?></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>        
</html>