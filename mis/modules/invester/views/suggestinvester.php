<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();

$form_name = 'investersuggestsubmit';
$nullLink = 'javascript:void(0);';

$sector = isset($_REQUEST["sector"])?$_REQUEST["sector"]:"";
$experience = isset($_REQUEST["experience"])?$_REQUEST["experience"]:"";
$qualification = isset($_REQUEST["qualification"])?$_REQUEST["qualification"]:"";
?>

<h1><?=$cpagetitle ?></h1>
<div>

            <div style=" float:right;">
                 <a class="button" href="<?=site_url('invester/investerdetail/'.$innovationid.'/'.$id);?>">Back to Details</a> &nbsp;&nbsp;
			</div>	<br>
			
           <div id="slidebox"  style="display:none;"><br>
           <form name="membersuggest" enctype="multipart/form-data"  action="<?=site_url('invester/suggestInvester/'.$innovationid);?>" method="post" id="lineitemForm" >
                   <fieldset> 
                   <legend>Search Invester</legend>
				 
                    
                         <dt><label for="source_type">Experience</label></dt>
                         <dd> <input type="text" value="<?php echo $experience; ?>" id="experience" name="experience" /></dd>
                         <dt><label for="source_type">Qualification</label></dt>
                         <dd> <input type="text" value="<?php echo $qualification; ?>" name="qualification" id="qualification"/></dd>
                     </dl>
                    
                     <div class="buttons" >
                       <button type="submit" class="button" value="Search" name="txtSubmit">Search</button>
                       <button type="submit" class="button white" value="Search" name="txtSubmit">Reset</button>
                    </div>
                    
                   </fieldset> 
			  </div>	   
      		
                <div style="margin-left:790px;margin-top:10px;">
                       <button type="button" class="button" id="yearslideToggle" > Show Filter </button>

                </div>

<br /><br/>
<!--start table-content  -->
  

<div id="user-grid" class="gtable sortable">
	  <input type="hidden"  name="ordertype" value="<?=$ordertype?>"  />
      <input type="hidden"  name="orderby" value="<?=$orderby?>"  />
	  <input type="hidden"  name="id" value="<?=$id?>"  />
		<table id="table1" class="gtable sortable">
						<thead>
							<tr>
							    <th>Select <input type="checkbox" id="selectall"/></th>
								<th><a href="<?=$nullLink?>" field="sector" class="sortlink">Sector</a></th>
                                <th>MemberName</th>
                                <th>Telephone</th>
								<th>Mobile</th>
                                <th>Email</th>
                                <th>View</th>
                    
							</tr>
						</thead>
						
		<tbody id="lineitemTable">
    <?php 
	
	 if(php72_count($searchinvester))
	{    
			$rowtype = 'odd';
			foreach($searchinvester as $row):
			?>
                    <tr class="<?=$rowtype = ($rowtype == 'odd')?'even':'odd';?>">
						<td><input type="checkbox" name="check[]" class="case" value=<?php echo $row['id']; ?> /></td>
						<td align="left" valign="middle" >
						   <?=$row['sector']?>
						</td>
						<td align="left" valign="middle" width="235">
						   <?=$row['first_name']?>
						</td>
						
						<td align="left" valign="middle"> <?= $row['telephone']?></td>
						<td align="left" valign="middle"> <?=$row['mobile']?></td>
						<td align="left" valign="middle"><?=$row['email']?></td>
						<td align="left" valign="middle">
						<a class="fancybox" href="<?=site_url('invester/masterinvesterDetail/'.$innovationid.'/'.$row['id']);?>">View Profile</a>
						</td>
                    </tr>
            <?php 
			endforeach;
	}
	else
	{ ?>
	 
		<tr>
		<td colspan='7' align='center'>No Records found!</td>
		</tr>
	<?php
	} ?>
	 <br/>
	
	</tbody>				
						
	</table>
	
	  <br/>
	   <div align="right">
	     <td style="float:right;"><input type="submit" name="txtSubmit" value="Assign" class="button" /></td>
	  </div>	
	  
   </form>		
	 			 
						
   </div>   
</div>
<script type="text/javascript">
 $(document).ready( function() {

			 $("#yearslideToggle").click(function () {
				  $('#slidebox').slideToggle("slow");
				
				});
		  });
		
 </script>
 <script language="javascript">
$(function(){
 
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
          $('.case').attr('checked', this.checked);
    });
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
 
    });
});
</script>