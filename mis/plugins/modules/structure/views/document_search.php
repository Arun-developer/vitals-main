<link rel="stylesheet" type="text/css" href="<?=base_url();?>source/template/css/ajaxpagination.css">
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

#searchedHistory {}
</style>

<script type="text/javascript">
$(function() {
    //-------------- Update Button-----------------
    var Timer = '';
    var selecter = 0;
    var Main = 0;

    $(".search_button").click(function() {
        var search_word = $("#search_box").val();
        var keywordornot = $("#keywordornotID").val();
        var searchtype = $("#searchtypeID").val();
        if (search_word == '') {
            $("#searchword").show();
            $("#searchword").text("Please Type keyword to Search !!").css('color', 'red');
        } else {
            $.ajax({
                type: "POST",
                aync: false,
                url: "<?=site_url('dms/document_system/searchDocsByKey');?>",
                'data': {
                    'search_word': search_word,
                    'keywordornot': keywordornot,
                    'searchtype': searchtype
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

    $("#searchtypeID").click(function() {
        var searchtype = $(this).val();
        if (searchtype == "with") {
            $("#searchgoogle").show();
        }
        if (searchtype == "without") {
            $("#searchgoogle").show();
        }

    });

    $("#insert_search").on('click', 'li.page', function() {

        var pageid = this.id;
        $.ajax({
            'type': 'POST',
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


    $("#1").css({
        'background-color': '#006699'
    });

});
</script>


<div id="searchedHistory" align="right">
    <a href="<?php echo site_url("dms/document_system/searchedKeyWord"); ?>" class="button">Scheduled Documents</a>
</div>
<div style="margin-left:34px;">
    <table cellpadding="3" cellspacing="5" width="40%">
        <tr>
            <td style="font-weight:bold;">Search Type :</td>
            <td>
                <select name="searchType" id="searchtypeID">
                    <option value="">--Select --</option>
                    <option value="1">With Keyword</option>
                    <option value="0">Without Keyword</option>
                </select>
            <td>
        </tr>
    </table>
</div>
<div align="center">

    <div id="searchgoogle" style="width:600px;border: 1px solid #F0F0F0;">


        <div style="margin-top:20px; text-align:left">

            <form method="get" action="">
                <input type="text" name="search" id="search_box" class='search_box' />
                <input type="submit" value="Search" class="search_button" /><br />
                <span style="color:#666666; font-size:14px; font-family:Arial, Helvetica, sans-serif;"><b>Eg :</b>
                    jquery, ajax, facebook, php, twitter</span>

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