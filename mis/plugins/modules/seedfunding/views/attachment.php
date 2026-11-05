<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <script type="text/javascript">
    $.metadata.setType("attr", "validate");
    $(document).ready(function() {
        $("#form1").validate();
    });
    </script>
</head>

<body>
    <table width="400" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
            <td><strong></strong></td>
        </tr>
    </table>
    <div class="clear"></div>
    <p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
    <table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
            <td>
                <form id="form1" method="post" action="<?=site_url('screening/send_editrequest/'.$innovation)?>">
                    <dl class="inline">
                        <dt><label for="namesd">Subject</label></dt>
                        <dd>
                            <input type="text" name="subject" id="subject" class="">
                        </dd>
                        <dt><label for="namesd">Document</label></dt>
                        <dd>
                            <input type="file" name="document" id="document" class="">
                        </dd>
                        <dt><label for="namesd">Description</label></dt>
                        <dd>
                            <textarea name="description" id="description" class=""></textarea>
                        </dd>
                    </dl>
                    <div class="buttons">
                        <input type="submit" name="txtsubmit" value="Submit" class="button" />
                        <input type="reset" value="Reset" class="button white" />
                    </div>
                </form>
                </form>
            </td>
        </tr>
    </table>
</body>

</html>