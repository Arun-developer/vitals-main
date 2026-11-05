<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
    $(function() {
        $( ".monthYear" ).datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) { 
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
    });
</script>
<script type="text/javascript">
    function addRow(tableID) {

        var table = document.getElementById(tableID);

        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        var cell1 = row.insertCell(0);
        var element1 = document.createElement("input");
        element1.type = "checkbox";
        cell1.appendChild(element1);

        var cell2 = row.insertCell(1);
        var element2 = document.createElement("input");
        element2.type = "text";
        element2.name = "kra[]";
        cell2.appendChild(element2);

        var cell3 = row.insertCell(2);
        var element3 = document.createElement("input");
        element3.type = "text";
        element3.name = "kpi[]";
        cell3.appendChild(element3);


    }

    function deleteRow(tableID) {
        try {
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;

        for(var i=0; i<rowCount; i++) {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked) {
                table.deleteRow(i);
                rowCount--;
                i--;
            }


        }
        }catch(e) {
            alert(e);
        }
    }
 
 
</script>        
         <style>
        .ui-datepicker-calendar {
            display: none;
            }
        </style>
<section>
    <section>
        <p style="float:right;color:red;font-weight:bold;" >Fields marked with (*) represents required.</p>
        <h1>Add KRA Details</h1>
    </section>
    <form method="post" action="<?=site_url('master/fellow/add');?>">
            <dl class="inline">
                <dt><label for="employee"><b>Employee:</b></label></dt>
                <dd>
                    <select name="employee">
                        <option value="">Select</option>
                        <?php print_r($userList); foreach($userList as $row):?>
                        <option value="<?=$row['emp_number'];?>"><?=$row['emp_name'];?></option>
                        <?php endforeach;?>
                    </select>
                </dd>
                <dt><label for="from-date">From Date:</label></dt>
                <dd><input type="text" name="from-date" class="monthYear input-text required"/></dd>
                <dt><label for="to-date">To Date:</label></dt>
                <dd><input type="text" name="to-date" class="monthYear input-text required"/></dd>
            </dl>
            <INPUT type="button" class="button" value="Add Row" onclick="addRow('dataTable')" />
            <INPUT type="button" class="button" value="Delete Row" onclick="deleteRow('dataTable')" />
             <table class="gtable" id="dataTable" border="1">
                 <tr>
                    <th>Select</th>
                    <th>KRA</th>
                    <th>KPI</th>
                </tr>
                <tr>
                    <td><INPUT type="checkbox" name="chk"/></td>
                    <td><INPUT type="text" name="kra[]" /></td>
                    <td><INPUT type="text" name="kpi[]"/></td>
                </tr>
            </table><br/>
            <div align="center">
                <input type="submit" class="button" name="txtsubmit" value="Submit"/>
                <input type="reset" class="white button" name="reset" value="reset"/>
            </div>
    </form>
</section>