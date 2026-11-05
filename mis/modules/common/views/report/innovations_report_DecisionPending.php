<?php
$nullLink = "javascript:void(0);";
$form_name = "innovations_report";
?>
<script type="application/javascript">
    $(document).ready(function() {

    $('#Data_innovations_report_decisionpending').dataTable( {
    "bAutoWidth": false,
    'bFilter': false,
    "iDisplayLength": 15,
    "aLengthMenu": [[10,15, 25, 50, -1], [10,15, 25, 50, "All"]],
    "oTableTools": {
    "sSwfPath": "<?php echo base_url() . "DataTables-1.9.4/media/swf/copy_csv_xls_pdf.swf"; ?>",
    "aButtons": [
    "csv",
    {"sExtends": "print",
    "bShowAll": false,
    },
    ]
    },

    "fnDrawCallback": function ( oSettings ) {
    if ( oSettings.aiDisplay.length == 0 )
    {
    return;
    }

    var nTrs = $('#Data_innovations_report_decisionpending tbody tr');
    var iColspan = nTrs[0].getElementsByTagName('td').length;
    var sLastGroup = "";
    for ( var i=0 ; i<nTrs.length ; i++ )
    {
    var iDisplayIndex = oSettings._iDisplayStart + i;
    var sGroup = oSettings.aoData[ oSettings.aiDisplay[iDisplayIndex] ]._aData[0];
    if ( sGroup != sLastGroup )
    {
    var nGroup = document.createElement( 'tr' );
    var nCell = document.createElement( 'td' );
    nCell.colSpan = iColspan;
    nCell.className = "group";
    nCell.innerHTML = sGroup;
    nGroup.appendChild( nCell );
    nTrs[i].parentNode.insertBefore( nGroup, nTrs[i] );
    sLastGroup = sGroup;
    }
    }
    },
    "aoColumnDefs": [
    { "bVisible": false, "aTargets": [ 0 ] }
    ],
    "aaSortingFixed": [[ 0, 'desc' ]],
    "aaSorting": [[ 1, 'desc' ]],
    "sDom": 'T<"clear"><"H"lfr>t<"F"ip>',
    } );
    //get source list
    sourceCombo(0); // loading source values for source type direct application
    $("#sourceType").change(function(){
    sourceCombo(this.value);

    });
    if($("#sourceType").val()){
    sourceCombo($("#sourceType").val());
    }
    function sourceCombo(sourec_type)
    {
    var form_data = {
    source_type: sourec_type,
    ajax: '4'
    };
    $.ajax({
    url: '<?= site_url('master/source/get_source_combo'); ?>',
    type: 'POST',
    data: form_data,
    success: function(msg) {
    $('#sourceList').html(msg);
    $('#instanceList').html('<option value="">-Select-</option>');
    }
    });
    }
    //get instance list
    $("#sourceList").change(function(){
    instanceCombo(this.value);
    });
    if($("#sourceList").val()){
    instanceCombo($("#sourceType").val());
    }
    function instanceCombo(sourceid){
    var form_data = {
    source: sourceid,
    ajax: '4'
    };
    $.ajax({
    url: '<?= site_url('master/instance/get_instance_combo'); ?>',
    type: 'POST',
    data: form_data,
    success: function(msg) {
    $('#instanceList').html(msg);
    }
    });
    }
    });
</script>
<h1><?= $cpagetitle ?></h1>
<form id="<?= $form_name ?>" action="<?= site_url('common/report/innovations_report_identifiedBy/' . $currentTab) ?>" method="post" name="<?= $form_name ?>">
    <input type="hidden"  name="ordertype" value="<?= $ordertype ?>"  />
    <input type="hidden"  name="orderby" value="<?= $orderby ?>"  />
    <input type="hidden"  name="export" value=""  />
    <br />

    <div class="searchBox" style="display:none">
        <table class="gtable detailtable" cellpadding="5" style="width:90%; float:left">

            <tr>
                <td width="24%" align="right" valign="top">Date Applied:</td>
                <td>
                    <?php
                    $created_date = isset($_REQUEST['created_date']) ? $_REQUEST['created_date'] : '';
                    $created_date_to = isset($_REQUEST['created_date_to']) ? $_REQUEST['created_date_to'] : '';
                    ?>
                    <input type="text" name="created_date" value="<?= $created_date ?>" class="input-text" id="fromdate" />&nbsp;-&nbsp;
                    <input type="text" name="created_date_to" value="<?= $created_date_to ?>" class="input-text" id="todate"/>

                </td>
            </tr>

            <tr>
                <td width="39%" align="right" >Name of the Incubatee</td>
                <td width="58%">
                    <?php $name_of_enterprise = isset($_REQUEST["name_of_enterprise"]) ? $_REQUEST["name_of_enterprise"] : ''; ?>
                    <input type="text" value="<?= $name_of_enterprise ?>" name="name_of_enterprise" class="input-text" /></td>
            </tr>
            <tr>
                <td width="39%" align="right" >Person Incharge </td>
                <td><?php $person_incharge = isset($_REQUEST["person_incharge"]) ? $_REQUEST["person_incharge"] : ''; ?>
                    <select name="person_incharge"  >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                            <option value="<?= $row['emp_number'] ?>" <?= ($person_incharge == $row['emp_number']) ? 'selected' : ''; ?>><?= $row['emp_name'] ?></option>
                            <?php
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td width="39%" align="right" >Identified by </td>
                <td><?php $created_by = isset($_REQUEST["created_by"]) ? $_REQUEST["created_by"] : ''; ?>
                    <select name="created_by"  >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                            <option value="<?= $row['emp_number'] ?>" <?= ($created_by == $row['emp_number']) ? 'selected' : ''; ?>><?= $row['emp_name'] ?></option>
                        <?php } ?>

                    </select></td>

            </tr>
            <tr>
                <td width="39%" align="right" valign="top">Reasons for reject/on-hold</td>
                <td>
                    <?php $reasons = isset($_REQUEST["reasons"]) ? $_REQUEST["reasons"] : ''; ?>
                    <select name="reasons" >
                        <option value="">-Select-</option>
                        <?php
                        foreach ($reasonsList as $row):
                            ?>
                            <option value="<?= $row['id'] ?>" <?= ($reasons == $row['id']) ? 'selected' : ''; ?>><?= $row['master_name'] ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td></td>
                <td valign="top">
                    <input type="submit" value="Search" name="txtSubmit" class="button" />
                    <input type="reset" value="Reset" name="txtReset" class="button white" />
                </td>
            </tr>
        </table>
    </div>
</form>
<div class="clear"></div>
<?php
$nullLink = "javascript:void(0);";
?>
<div style=" float:right; text-align:right;width:100%;">
    &nbsp;&nbsp;

</div>
<br /><br />


<table class="gtable sortable" id="Data_innovations_report_decisionpending">
    <thead>
        <tr>
            <th nowrap="nowrap">Identified By</th>
            <th nowrap="nowrap">Innovator ID</th>
            <th nowrap="nowrap">Name of the Incubatee</th>
            <th nowrap="nowrap">Date Applied</th>
            <th nowrap="nowrap">Assigned to</th>
            <th nowrap="nowrap">Stage</th>
            <th nowrap="nowrap">Status</th>
        </tr>

    </thead>
    <tbody>
        <?php
        if (php72_count($innovationList)) {
            $i = 'odd';
            foreach ($innovationList as $row):

                $i = ($i == 'odd') ? 'even' : 'odd';
                ?>

                <tr class="<?= $i ?>">
                    <td><?= $row['created_emp'] ?></td>
                    <td><?php echo $row['innovation_id']; ?></td>
                    <td><?= $row['name_of_enterprise'] ?></td>
                    <td><?= mysql2date($row['created_date']) ?></td>
                    <td width="150"><?= $row['associate_emp_name'] ?></td>
                    <td><?= $stage[$row['stage']] ?></td>
                    <td><?= $status[$row['status']] ?></td>
                </tr>


                </tr>
                <?php
            endforeach;
        }
        else {
            ?>
            <tr class="odd">
                <td></td>
                <td></td>
                <td>No Records</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

            </tr>
        <?php } ?>

    </tbody>
</table>


<!-- Paging style -->
<?php echo $this->pagination->create_links($form_name); ?>
