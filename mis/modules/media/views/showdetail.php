<?php 
$nullLink = "javascript:void(0);";

if(php72_count($applicantList)>0)
{
$val=array();
$val=$applicantList[0];
}

?>
<input type="hidden" name="innovationid" value="<?php echo $val['innovation']; ?>" />
<h1><?=$cpagetitle ?></h1>

<br />


<!--start table-content  -->


<div id="user-grid" class="gtable sortable">

    <table class="gtable sortable">
        <tbody>
            <tr>
                <td width="22%">Request Title </td>
                <td width="78%"><?php echo $val['title']; ?></td>
            </tr>

            <tr>
                <td>Request Topic</td>
                <td><?php echo $val['topic']; ?></td>
            </tr>
            <tr>
                <td>Request Date</td>
                <td><?php echo $val['requested_on']; ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo $val['description']; ?></td>
            </tr>
            <tr>
                <td>Media Name</td>
                <td><?php echo $val['media_name']; ?></td>
            </tr>
            <tr>
                <td>Documents</td>
                <td><?php echo $val['Document']; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<br /><br />