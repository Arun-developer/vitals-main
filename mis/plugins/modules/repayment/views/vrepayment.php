<?php
$nullLink = "javascript:void(0);";
?>

<h1><?=$cpagetitle?>&nbsp;&nbsp;<?php echo ucfirst($innovation['name_of_entrepreneur']);?></h1>
<br />
<form name="frmRepayment" id="frmrepaymentID" action="<?php echo site_url('repayment/send_mail/'.$innovationID.'/'); ?>"
    method="post">
    <input type="hidden" name="repayment[innovationID]" value="<?php echo $innovation['id'];?>">
    <?php if(isset($successMsg)) {echo $successMsg; } ?>
    <fieldset>
        <legend>Repayment </legend>
        <dl class="inline">
            <dt><label for="source_type">Innovation Name : </label></dt>
            <dd>
                <input type="text" name="repayment[innovation]" readonly="readonly" class="required"
                    value="<?php echo $innovation['name_of_entrepreneur'];?>">
            </dd>
            <dt><label for="source_type">Amount to Repay: </label></dt>
            <dd>
                <input type="text" name="repayment[repayment_amount]" id="repayAmount" class="required">
            </dd>
            <dt><label for="source_type">From Date : </label></dt>
            <dd>
                <input type="text" name="repayment[from_date]" id="repaymentFromID" class="frm_Date datepicker">
            </dd>

            <dt><label for="source_type">To Date : </label></dt>
            <dd>
                <input type="text" name="repayment[to_date]" id="repaymentDate_ID" class="to_Date datepicker">
            </dd>

            <dt><label for="source_type">Average Amount :</label></dt>
            <dd>
                <input type="text" name="repayment[average_amount]" id="avgAmount" class="required">
            </dd>
            <dt><label for="source_type">Description : </label></dt>
            <dd>
                <textarea name="repayment[description]" cols='40' rows='6' class="required"></textarea>
            </dd>

            <div class="buttons1" style="margin-left:330px;margin-top:10px;">
                <button type="submit" class="button" value="Submit"
                    name="txtSubmit">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="reset" class="button white" value="Reset" name="txtSubmit">Reset</button>
            </div>



        </dl>
    </fieldset>
</form>


<style type="text/css">
dt {
    width: 35% !important;
}

dd {
    width: 65% !important;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmrepaymentID").validate();
});
$(".frm_Date").datepicker({
    showButtonPanel: true,
    dateFormat: 'yy-mm-dd',
    changeYear: true,
    onClose: function(dateText, inst) {}
});
$('#repaymentDate_ID').datepicker({
    showButtonPanel: true,
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd',
    onClose: function(dateText, inst) {

        if ($(this).val()) {
            var fromDate = $("#repaymentFromID").val();
            var toDate = $(this).val();
            var format = 'yy/mm/dd';
            var from_data = fromDate.split("-", 3);
            var to_data = toDate.split("-", 3);

            var getMonthNumber = monthsBetween(new Date(from_data[0], from_data[1], from_data[2]), new Date(
                to_data[0], to_data[1], to_data[2]));
            var amount = $("#repayAmount").val();
            var averageAmount;

            if (getMonthNumber) {
                averageAmount = amount / getMonthNumber;

                document.getElementById("avgAmount").value = averageAmount;
            }
        }
    }
});

function monthsBetween(date1, date2) {

    var months = date2.getFullYear() * 12 + date2.getMonth() - date1.getFullYear() * 12 - date1.getMonth();
    if (date2.getDate() < date1.getDate()) {
        months--;
    }

    return months;
}
</script>