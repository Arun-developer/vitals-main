<script type="text/javascript">
	$.metadata.setType("attr", "validate");
	$(document).ready(function() {
		$("#vendorForm").validate();
	});
        
</script>
 
<h2>Create Group</h2>

    <form action="<?=site_url('incubator_metrics/wglobal_report/'.$report.'/'.$urlcode.'/'.$tab)?>" method="post" id="vendorForm">     
     
        <input type="hidden" name="tabkey" value="<?=$tab;?>"/>
        <input type="hidden" name="urlcode" value="<?=$urlcode?>"/>
        
      <div  id="showGroup">
          
        <div style="width:360px;" id="levelCode">
         <label for="title">Enter the Title:</label>
         <input type="text" name="title" id="title" value="" class="required"/>
         <fieldset>
             <legend>Choose the Labels</legend>
             <table id="table1" width="auto" class="gtable" cellspacing="3" cellpadding="4">
             <tr>
                 <th>Labels</th>
                 <th>Action</th>
             </tr>
            
             <?php 
             foreach($result as $row)
             {	
               ?><tr>
                <td><?php echo $row['label']; ?></td>
                <td><input type="checkbox" name='label[]' value="<?php echo $row['field'];?>" check='checked' class='required' /></td>
				</tr>
		   <?php  }
             ?>
         </table>
        </fieldset>
         <label for="Type of Show">Select the Mode to show</label>
         <select name="showtype">
              <option name="">-Select-</option>
             <option value="general">General</option>
             <option value="barchart">Bar Chart</option>
         </select>
         
          <button id="add" class="button black" style="float:right">Add Row</button>
          </br>
        </div>  
      </div>
        
          <div class="buttons">
             <input type="submit" class="button" name="txtsubmit" value="Submit"/>
             <input type="reset" class="button" name="reset" value="reset"/>
         </div>
    </form>
    <script type="text/javascript"> 
	$('#add').click(function() {
        var countValue= $("#levelCode").length;    
            $("#showGroup").append("<label for='title'>Enter the Title:</label><input type='text' name='title' id='title' value='' class='required'/><fieldset><legend>Choose the Labels</legend><table id='table1' width='auto' class='gtable' cellspacing='3' cellpadding='4'><tr><th>Labels</th><th>Action</th></tr><?php  foreach($result as $row){ ?><tr><td><?php echo $row['label']; ?></td><td><input type=checkbox name='label[]' value='<?php echo $row['field'];?>' check='checked' class='required' /></td></tr><?php }?></table></fieldset><label for='Type of Show'>Select the Mode to show</label><select name='showtype'><option name=''>-Select-</option><option value='general'>General</option><option value='barchart'>Bar Chart</option></select><br>");
    });

	
	
	
	</script>
    

