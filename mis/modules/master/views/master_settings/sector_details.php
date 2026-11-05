<div id="form_employeelist" style="display:none;">
    <div align="center" id="form_container" style="width:400px; height:400px;" >

        <form action="<?php echo site_url('master/master_settings/addSectorIncharge'); ?>" id="assign" method="post">

            <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1"  name="associate_employee[]">
                <?php
                foreach ($usersList as $row) {
                    ?>
                    <option value="<?= $row['emp_number'] ?>" ><?= $row['emp_name'] ?></option>
                <?php }
                ?>
            </select>

            <input type="hidden" name="sector_value" id="sector_value" />
            <br/><br/>
            <div>
                <input type="submit" name="txtSubmit" class="button" id="txtsub" value="Submit"/>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <h1 style="margin: 15px 0 10px;">Sector Details</h1>
</div>

<table id="table1" class="gtable sortable">
    <thead>
        <tr>
            <th width="25%" nowrap="nowrap"><center>Sector</center></th>
<th width="25%" nowrap="nowrap"><center>Assigned Incharge</center></th>
<th width="25%" nowrap="nowrap"><center>Email</center></th>
<th width="25%" nowrap="nowrap"><center>Action</center></th>
</tr>
</thead>
<tbody>
    <?php 
    foreach ($sector_details as $index => $row) {
        ?>
        <tr>
            <td style="padding:5px;"><?php echo $row['sector'] ?></td>
            <td style="padding:5px;"><?php echo $row['emp_name'] ?></td>
            <td style="padding:5px;"><?php echo $row['emp_work_email'] ?></td>
            <td style="display:none;" class="sector"><?php echo $row['id'] ?></td>
            <td style="padding:5px;"><center><a class="button assign-incharge" id="assign-incharge" >Assign Incharge </a></center></td>
    </tr>
    <?php
}
?>
</tbody>
</table>


<script type="text/javascript">
    $(document).ready(function () {
        jQuery('.assign-incharge').on('click', function () {
            var sectorid = jQuery(this).closest('tr').children('.sector').text();

            Populate(sectorid);
            jQuery("#sector_value").val(sectorid);
            jQuery.fancybox([
                {href: '#form_container'}
            ]);

        });
    });

    function Populate(sectorid) {
        $('#associate_employee').val('');
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/master/master_settings/getSectorIncharges',
            data: {id: sectorid},
            dataType: 'json',
            success: function (msg) {
                var arr = msg;
                for (var prop in arr)
                {
                    console.log(arr[prop]['associate_employee']);
                    $('#associate_employee option').map(function () {
                        if (arr[prop]['associate_employee'] == $(this).val())
                        {
                            $(this).attr("selected", 'selected');
                        }
                    });
                }
            },
        });
    }
</script>
