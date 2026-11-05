<?php 
$nullLink = "javascript:void(0);";

if(php72_count($jobDetails)>0)
{
$val=array();
$val=$jobDetails[0];
}

?>
<input type="hidden" name="innovationid" value="<?php echo $innovationid; ?>" />
<h1><?=$cpagetitle ?></h1>

<br />


<!--start table-content  -->


 <div id="user-grid" class="gtable sortable">
	  
        <table class="gtable sortable">
            <tbody>
                <tr>
                    <td width="22%">Request No. </td>
                    <td width="78%"><?php echo $val['request_key']; ?></td>
                </tr>
               
                <tr>
                    <td>Innovator Name</td>
                    <td><?php echo $val['innovator_name']; ?></td>
                </tr>
				 <tr>
                    <td>Request Date</td>
                    <td><?php echo $val['request_date']; ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo $val['job_description']; ?></td>
                </tr>
                <tr>
                    <td>From Period</td>
                    <td><?php echo $val['from_period']; ?></td>
                </tr>
                <tr>
                    <td>To Period</td>
                    <td><?php echo $val['to_period']; ?></td>
                </tr>
            </tbody>
         </table>		
  </div>
  <br/><br/>
