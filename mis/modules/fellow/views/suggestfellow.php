<script type="text/javascript">
		 $(document).ready( function() {
			$.metadata.setType("attr", "validate");
            $("#membersuggest").validate();		
 });

</script>
<script type="text/javascript">
$(document).ready(function(){ 
     $("#twoCarDiv").hide();
     $("#threeCarDiv").show();
    
    $("input[name$='mentor']").click(function() 
	  {
      var test = $(this).val();
      if(test === "Villgro")
      {
        $('#companyvill').val(test);
        $("#twoCarDiv").hide();
        $("#threeCarDiv").show();
      }   
      else
	    {
	      $('#companyout').val(test);
        $("#twoCarDiv").show();
		    $("#threeCarDiv").hide();
	   }	

    }); 
});
</script>
<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();

$form_name = 'membersuggestsubmit';
$nullLink = 'javascript:void(0);';

$sector = isset($_REQUEST["sector"])?$_REQUEST["sector"]:"";
$experience = isset($_REQUEST["experience"])?$_REQUEST["experience"]:"";

?>

<h1>
  <?=$cpagetitle ?>
</h1>
<div>

  <div style=" float:right;"> <a class="button" href="<?=site_url('fellow/applicantdetail/'.$innovationid.'/'.$id);?>">Back to Details</a> &nbsp;&nbsp; </div>
    <br/>
    <!--start table-content  -->
    <div id="user-grid" class="gtable sortable">
      <form name="membersuggestsubmit" enctype="multipart/form-data"  action="<?=site_url('fellow/suggestSubmit/'.$innovationid.'/'.$id);?>" method="post" id="lineitemForm" >
        <input type ="hidden"  name="company" id="companyout" value="" />
        <table id="table1" class="gtable sortable">
          <thead>
            <tr>
              <th><input id="check_all" type="checkbox" /></th>
              <th>FellowName</th>
			  <th><a href="<?=$nullLink?>" field="sector" class="sortlink">Sector</a></th>
              <th>Experience</th>
              <th>Email</th>
              <th>View</th>
            </tr>
          </thead>
          <tbody id="lineitemTable">
            <?php 
		
			 if(php72_count($fellows))
			{    
					$rowtype = 'odd';
					foreach($fellows as $row):
					?>
					<tr class="<?=$rowtype = ($rowtype == 'odd')?'even':'odd';?>">
					  <td><input type="checkbox" name="check[]" value=<?php echo $row['firstname']; ?> /></td>
					  <td align="left" valign="middle" width="235"><?=$row['firstname']?></td>
					  <td align="left" valign="middle" ><?=$row['source']?> </td>
					  <td align="left" valign="middle"><?=$row['experience']?></td>
					  <td align="left" valign="middle"><?=$row['email']?></td>
					  <td align="left" valign="middle"><a class="fancybox" href="<?=site_url('fellow/viewprofile/'.$row['id']);?>">View Profile</a> </td>
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
