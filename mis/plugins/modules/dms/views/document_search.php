<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/ajaxpagination.css">
<!-- jQuery Color Plugin -->
<script type="text/javascript" src="<?php echo base_url()."source/custom_js/jquery.color.js"; ?>"></script>
<!-- Import The jQuery Script -->
<script type="text/javascript" src="<?php echo base_url()."source/custom_js/jMenu.js"; ?>"></script>
<style type="text/css">
a {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

div.update {
    list-style: none;
    font-size: 1.1em;
    margin-top: 20px
}

div.update li {
    height: 70px;
    border-bottom: #dedede dashed 1px;
    text-align: left;
}

div.update li:first-child {
    height: 70px;
    text-align: left;
    clear: both;
}

#flash {
    margin-top: 20px;
    text-align: left;

}

#searchword {
    text-align: left;
    margin-top: 20px;
    display: none;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 16px;
    color: #000;
}

.searchword {
    font-weight: bold;
    color: #000000;

}

#search_box {
    padding: 4px;
    width: 300px;
    height: 30px;
    font-size: 18px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
}

#search_boxout {
    padding: 4px;
    width: 300px;
    height: 30px;
    font-size: 18px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
}

.search_button {
    background: url(http://static.twitter.com/images/bg-btn-signup.png);
    border: #000000 solid 1px;
    padding-left: 9px;
    padding-right: 9px;
    padding-top: 9px;
    padding-bottom: 9px;
    color: #000;
    font-weight: bold;
    font-size: 16px;
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
}
</style>

<script type="text/javascript">
$(function() {
    //-------------- Update Button-----------------
    var Timer = '';
    var selecter = 0;
    var Main = 0;

    $(".search_button").click(function() {
        var search_word;
        var keywordornot;
        var searchtype;
        var urlpath;

        if ($("#searchtypeID").val() != '' && $("#keywordSearchTypeId").val() != '') {
            search_word = $("#search_box").val();
            urlpath = $("#urlpathID").val();
            searchtype = $("#keywordSearchTypeId").val();

        } else {
            search_word = $("#search_box").val();
            searchtype = '';
        }
        if (search_word == '') {
            $("#searchword").show();
            $("#searchword").text("Please Select All option and Type keyword to Search !!").css('color',
                'red');
        } else {
            $('.items tbody>tr:last').clone(true).insertAfter('.items tbody>tr:last').html(search_word +
                " <span style='color:#000;font-weight:bold;'> - In Progress</span>").css("color",
                'red');
            $.ajax({
                type: "POST",
                aync: false,
                url: "<?=site_url('dms/document_system/searchDocsByKey');?>",
                'data': {
                    'search_word': search_word,
                    'keywordornot': keywordornot,
                    'searchtype': searchtype,
                    'urlpath': urlpath
                },
                cache: false,
                beforeSend: function(html) {
                    document.getElementById("insert_search").innerHTML = '';
                    $("#flash").show();
                    $("#searchword").show();
                    $(".searchword").html(search_word);
                    $("#flash").html(
                        '<img src="<?=base_url();?>source/template/images/icons/ajax-loader.gif" align="absmiddle">&nbsp;<span style="color:#698401;font-weight:bold;">Loading Results...</span>'
                        );
                },
                success: function(msg) {
                    $("#insert_search").show();
                    $("#insert_search").append(msg);
                    $("#flash").hide();

                }
            });

        }


        return false;
    });
    //---------------- Delete Button----------------
    function showLoader() {

        $('.search-background').fadeIn(200);
    }

    $("#paging_button ul li").click(function() {

        showLoader();

        $("#paging_button li").css({
            'background-color': ''
        });
        $(this).css({
            'background-color': '#006699'
        });
        return false;
    });



    $("#insert_search").on('click', 'li.page', function() {

        var pageid = this.id;
        $.ajax({
            'type': 'POST',
            aync: false,
            'url': '<?PHP echo site_url('
            dms / document_system / searchDocsByKey ');?>',
            'data': {
                'search_word': $('#search_box').val(),
                'isajx': 'true',
                'counter': pageid
            },
            success: function(msg) {
                if (msg) {
                    $("#flash").html(
                        '<img src="<?=base_url();?>source/template/images/icons/ajax-loader.gif" align="absmiddle">&nbsp;Loading Results...'
                        );
                    $('#insert_search').show();
                    $('#insert_search').html(msg);
                    $('#flash').hide();
                } else {

                    $('.update').text('No Records Found !!');
                }
            }
        });

    });

    $("#searchtypeID").click(function() {
        var searchtype = $(this).val();
    });
    $("#1").css({
        'background-color': '#006699'
    });

});
</script>
<?php
$keywordSearchType = array('word' => 'Documents','pdf' => 'Pdf','excel' => 'Excel','all' => 'All');
?>

<div id="searchedHistory" align="right">
    <a href="javascript:history.go(-1);" class="button"> Back</a>
</div>

<blink><span
        style="color:red;">&nbsp;&nbsp;<?php echo " >> Please Select Module and Document Type to Schedule Documents !!"; ?>
    </span> </blink>
<div id="treeViewID"
    style="float:left;border:1px solid lightgrey;width:300px;height:480px;overflow:scroll;scroll:auto;">

    <!--Document Tree List Start -->
    <!-- Menu Start -->
    <div id="jQ-menu">
        <div style="border:1px solid #A9CF55;height:29px;">
            <h2 style="margin-left: 85px;">Modules</h2>
        </div>
        <?php
	$path = "./";

	function createDir($path = '.')
	{
            $queue = array();
		if ($handle = opendir($path))
		{
			echo "<ul>";

			while (false !== ($file = readdir($handle)))
			{
				if (is_dir($path.$file) && $file != '.' && $file !='..')
					printSubDir($file, $path, $queue);
				else if ($file != '.' && $file !='..')
					$queue[] = $file;
			}

			printQueue($queue, $path);
			echo "</ul>";
		}
	}

	function printQueue($queue =array(), $path="")
	{
		foreach ($queue as $file)
		{
			printFile($file, $path);
		}
	}

	function printFile($file ="", $path="")
	{
		echo "<li><a href=\"".$path.$file."\">$file</a></li>";
	}

	function printSubDir($dir= "", $path="")
	{
       	echo "<li><span class=\"toggle\" onclick='geturlLink(\"".$path.$dir."\");'>$dir</span>";
		createDir($path.$dir."/");
		echo "</li>";
	}
                  $path = "../ajaxplorer/data/personal/admin/Villgro/";
	createDir($path);


?>

    </div>
    <!-- End Menu -->

    <script type="text/javascript">
    function geturlLink(val) {
        document.getElementById("urlpathID").value = val;
        return false;

    }
    </script>

    <style type="text/css">
    ul li .toggle {
        background: url('<?php echo base_url();?>source/template/images/directory.png') no-repeat !important;
        padding-left: 20px;
    }
    </style>
    <!--Document Tree List End -->
</div>

<div style="margin-top: 40px;border: 1px solid #F0F0F0;float:left; margin-left: 34px;padding-bottom: 34px;">
    <div style="margin-left:34px;">
        <table cellpadding="3" cellspacing="5" width="40%">
            <tr>
                <td style="font-weight:bold;">
                    <div class="keywordtypeCLass">Document Type : </div>
                </td>
                <td>
                    <div class="keywordtypeCLass">
                        <select name="searchKeywordType" id="keywordSearchTypeId" class="">
                            <option value="">--Select --</option>
                            <?php foreach($keywordSearchType as $key=> $value) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <td>
            </tr>
        </table>
    </div>
    <input type="hidden" id="urlpathID" name="urlpathname" size="120" />

    <div id="withKeywodpanel" class="withKeywodpanel" style="width:600px;border: 1px solid #F0F0F0; margin-left: 34px;">
        <div align="center">
            <div style="width:600px;">


                <div style="margin-top:20px; text-align:left">

                    <form method="get" action="">
                        <input type="text" name="search" id="search_box" class='search_box' />
                        <input type="submit" value="Schedule Document" class="search_button" /><br />
                        <span style="color:#666666; font-size:14px; font-family:Arial, Helvetica, sans-serif;"><b>Eg
                                :</b> jquery, ajax, facebook, php, twitter</span>

                    </form>
                </div>
                <div>
                    <div id="searchword">Search results for <span class="searchword"></span></div>
                    <span class="emptysearch"> </span>
                    <div id="flash"></div>
                    <div class="search-background">
                        <label style="display:none;"><img src="<?=base_url();?>source/template/images/icons/loader.gif"
                                alt="" /></label>
                    </div>
                    <div id="insert_search" class="update">
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- Grid Start-->

<div id="user-grid">
    <div aligh="left" style="clear:both;">
        <a href="<?php echo site_url("dms/document_system/searchDocsByKey"); ?>"> <img src="<?Php echo base_url()."
                source/template/images/icons/refresh.gif"; ?>" height="30" width="30"/> </a>
    </div>
    <div class="gtable sortable">
        <table width="100%" class="items">
            <thead>
                <tr>
                    <?php $nullLink=""; ?>
                    <th><a href="<?=$nullLink?>" field="label">Keyword</a></th>
                    <th><a href="<?=$nullLink?>" field="label">Time</a></th>
                    <th><a href="<?=$nullLink?>" field="label">File Path</a></th>
                    <th><a href="<?=$nullLink?>" field="label">Count(Max Results)</a></th>
                </tr>
            </thead>
            <tbody>
                <?php

    if(count($docList))
	{
        $r=1;
                                $i=0;
        foreach($docList as $row)
        {
                $row_type = ($r%2 == 0) ? ('even'):('odd');
                $r++;
                ?>
                <tr class="clickable">
                    <?php if(@$docList[$i]['status'] == 'checked'){
                        ?>
                    <td align="left" valign="middle" style="color:blue;"><a
                            href="<?php echo site_url("dms/document_system/gettotalkeyword/".$docList[$i]["keywords"]); ?>"><?=@$docList[$i]["keywords"];?></a>
                    </td>
                    <?php } else {
                        ?>
                    <td align="left" valign="middle" style="color:red;"><?=@$docList[$i]["keywords"];?></td>
                    <?php } ?>
                    <td align="left" valign="middle"><?=@$docList[$i]["time"];?></td>
                    <td align="left" valign="middle"><?=@$docList[$i]["module"];?></td>
                    <td align="left" valign="middle" style="font-weight: bold;color:#000;"><?=@$docList[$i]["count"];?>
                    </td>
                </tr>
                <?php
                $i++;
        }
	}
	else
	{ ?>
                <tr>
                    <td colspan='9' align='center'>No Records found!</td>
                </tr>
                <?
	} ?>
            </tbody>
        </table>
        <!-- Paging style -->
    </div>



    <!-- Grid End-->