<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Dashboard Report of Incubatee</title>

    <script type="text/javascript">
    $(document).ready(function() {
        var dates = $("#fromdate, #todate").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function(selectedDate) {
                var option = this.id == "fromdate" ? "minDate" : "maxDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
            }
        });

    });
    fCount = 0;

    function addFileField() {
        fCount = fCount + 1;
        var id = 'file' + fCount;
        content = '<div id="' + id +
            '"><input type="file" class="upload" name="document[]"  />&nbsp;&nbsp;<a href="javascript:void(0);" style="color:red;" onclick="removeDiv(\'' +
            id + '\');" ><strong>( Remove )</strong></a><br/><br/></div>';

        $(content).appendTo('#multiFile');
    }

    function removeDiv(divId) {
        $('#' + divId).remove();
    }
    </script>

</head>



<body>

    <ul class="tabs">

        <?php foreach($yearly as $row5)

	{

        ?>

        <li class="<?=($defaultyear == $row5)?'selected':'';?>"><a
                href="<?=site_url('reports/incubation_report/view_incubateereport/'.$this->uri->segment('3').'/'.$row5.'/'.$defaultmonth);?>"><?=$row5;?></a>
        </li>

        <?php } ?>

    </ul>

    <ul class="tabs">

        <?php foreach($monthly as $row6)

		{

			?>

        <li class="<?=($defaultmonth == $row6)?'selected':'';?>"><a
                href="<?=site_url('reports/incubation_report/view_incubateereport/'.$this->uri->segment('3').'/'.$defaultyear.'/'.$row6);?>"><?= date("F", mktime(0, 0, 0, $row6, 1, 2000));?></a>
        </li>

        <?php }  ?>

    </ul>

    <form method="post" action="<?=site_url('reports/incubation_report/add_incubatee_report/'.$innovation)?>"
        enctype="multipart/form-data">

        <input type="hidden" name="month" value="<?=$defaultmonth;?>" />

        <input type="hidden" name="year" value="<?=$defaultyear;?>" />

        <input type="hidden" name="innovation" value="<?=$innovation;?>" />

        <div style="height: 600px;overflow:scroll">
            <fieldset>

                <dl class="inline">
                    <dt><label for="document_description">Document Description</label></dt>
                    <dd><textarea name="description" id="editor"></textarea></dd>
                    <dt><label for="">Document</label> </dt>
                    <dd id="multiFile">
                        <div><input type="file" name="document[]" class="" />
                            &nbsp;&nbsp;
                            <a href="javascript:void(0);" onclick="addFileField();" style="color:green"><strong>( Add
                                    )</strong></a><br /><br /></div>
                    </dd>
                </dl>

            </fieldset>
            <div class="buttons">
                <input type="submit" value="Add" name="txtSubmit" class="button" />
                <input type="reset" value="Reset" name="txtReset" class="button white" />
            </div>
        </div>
        <br />


    </form>

</body>

</html>