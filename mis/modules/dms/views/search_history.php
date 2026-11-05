<?php error_reporting(0);?>
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

            keywordornot = $("#searchtypeID").val();

            searchtype = $("#keywordSearchTypeId").val();

        } else {

            search_word = $("#search_box").val();

            keywordornot = $("#searchtypeID").val();

            searchtype = '';

        }

        if (search_word == '') {

            $("#searchword").show();

            $("#searchword").text("Please Select All option and Type keyword to Search !!").css('color',
                'red');

        } else {

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

    function hideLoader() {
        $('.search-background').fadeOut(200);
    };

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

        if (searchtype == "1") {

            $(".withKeywodpanel").show();

            $(".keywordtypeCLass").show();

        }



        if (searchtype == "0") {

            $(".withKeywodpanel").show();

        }

    });

    $("#1").css({
        'background-color': '#006699'
    });

});
</script>

<?php

$keywordSearchType = array('word' => 'Documents','pdf' => 'Pdf','excel' => 'Excel','all' => 'All');

?>



<div id="treeViewID" style="float:left;border:1px solid lightgrey;width:300px;height:750px;overflow:scroll;">

    <!--Document Tree List Start -->

    <!-- Menu Start -->

    <div id="jQ-menu">



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
		$pths = '../../../'.$path;
		echo "<li><a href=\"".$pths.$file."\">$file</a></li>";
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





    <!-- Add jQuery From the Google AJAX Libraries -->

    <script type="text/javascript">
    function geturlLink(val) {

        document.getElementById("urlpathID").value = val;

        document.getElementById('path').value = val;

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

<a class="button" href="<?php echo site_url('dms/document_system/searchDocsByKey'); ?>"
    style="float:right;margin-bottom:10px;font-weight:bold;">Schedule Document</a>



<div style="margin-top: 40px;border: 1px solid #F0F0F0;float:left; padding-bottom: 34px;">

    <div>

    </div>

    <input type="hidden" id="urlpathID" name="urlpathname" size="120" />

    <div>

        <form action="<?=site_url('dms/document_system/searchedKeyWord')?>" method="post" class="niceform">

            <fieldset>

                <legend>Search Options</legend>

                <dl>

                    <dt><label for="pattern">Search Pattern</label></dt>

                    <dd><input type="text" name="pattern" id="pattern" size="32" maxlength="128" /></dd>

                </dl>

                <dl>

                    <dt><label for="path">Work Path</label></dt>

                    <dd><input type="text" name="path" id="path" value="../" size="32" maxlength="32" /></dd>

                </dl>

                <input type="hidden" name="format" value="statistics" />

            </fieldset>

            <fieldset class="action">

                <input type="submit" name="submit" class="button" id="submit" value=" Search " />

            </fieldset>

        </form>

    </div>



    <div id="user-grid" class="gtable sortable">

        <table width="100%" class="gtable items">

            <thead>

                <tr>

                    <?php $nullLink=""; ?>

                    <th><a href="<?=$nullLink?>" field="label">Serial No</a></th>

                    <th><a href="<?=$nullLink?>" field="label">Filename</a></th>

                </tr>

            </thead>

            <?php

$i=0;

	    // Count hits

            foreach (@$aryResults as $value) {

                // Increase counter

                $i++;

            }

			echo '	<fieldset>' . "\n";

            echo '    	<legend>Search Results</legend>' . "\n";

            echo '<dl>' . "<br />\n";

            // Check hits if they are files or directories

            if (substr(@$pattern, -1, 1) == '/') {

                $echowhat = 'directories';

            }else{

                $echowhat = 'files';

            }

               echo '<span style="font-weight:bold;">There are total of<span style="color:red;"> ' . $i . ' ' . $echowhat . 'Matching the pattern "' . @$pattern. "<br />\n";

            // Stop the timer

            $endTime = microtime(true);

            $timedblqecho = $endTime - $startTime;

            // Print search time
        
            echo '</dl>' . "<br />\n";

            echo '</fieldset>' . "\n";

            echo '<fieldset class="action" style="text-align: left">' . "\n";

            echo '    <input type=button class="button" value=" Back " onClick="history.go(-1)">' . "\n";

            echo '</fieldset>' . "\n";

            echo '</fieldset>' . "\n";

            $i=1;


$r= 0;

if(php72_count($aryResults)) {

            foreach (@$aryResults as $value) {

                $path = $value;

                $replacedpath = str_replace("../","", $path);

                $newpath = str_ireplace("\\","//",$replacedpath);

                $filepath = host_url().$newpath;

?>
            <tbody>

                <?php

                                $row_type = "";

                                $row_type = ($r%2 == 0) ? ('style="background:#fff;"'):('style="background:#F0F9D9;"'); $r++;

	?>

                <tr <?=$row_type?>>

                    <td align="left" valign="middle"><?php echo $r; ?></td>

                    <td align="left" valign="middle"><a href="<?php echo $filepath; ?>"><?php echo $value; ?></a></td>

                </tr>

                <?php } } else { ?>

                <tr>

                    <td colspan='3' align='center'>No Records found!</td>

                </tr>

                <?php }



        ?>

            </tbody>

        </table>

        <!-- Paging style -->

    </div>