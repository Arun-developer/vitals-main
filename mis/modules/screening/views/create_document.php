<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>

<body>
    <?php
#criteria
foreach($criteriaList as $cri):
	//fields
	$fieldsList = $this->Mscreening->getFiledsAnswerList($innovation,$cri['id']);
	if(php72_count($fieldsList))
	{
		echo '<h2>'.$cri['master_name'].'</h2>';
		?>

    <?php
		foreach($fieldsList as $row):
			?>
    <table width="80%" align="center" cellpadding="5" cellspacing="0">
        <tr>
            <td width="40%">
                <h3><?php echo $row['label']; ?></h3>
            </td>
            <td><?php echo $row['answer']; ?></td>
        </tr>
        <?php
			if($row['assess_field']>0 ){
				//assessment fiels
				$assessList = $this->Mscreening->getFiledsAnswerList($innovation,$cri['id'],$row['id']);
				
				if(php72_count($assessList)){
					?>
        <tr>
            <td colspan="2" bgcolor="#D2DAE8">
                <h3>Assessment - <?php echo $row['label']; ?></h3>
            </td>
        </tr>
        <?php
					foreach($assessList as $assess):
						?>
        <tr>
            <td bgcolor="#D2DAE8">
                <h3><?php echo $assess['label']; ?></h3>
            </td>
            <td bgcolor="#D2DAE8"><?php echo $assess['answer']; ?></td>
        </tr>
        <?php
					endforeach;
					?><?php
				}
			}
			?>
    </table><?php
		endforeach;
	}
	
	#comments
	$assessComments = $this->Mscreening_comments->getScreeningComments($innovation,$cri['id']);
	if(php72_count($assessComments))
	{
		?><br />

    <table width="80%" align="center" cellpadding="5" cellspacing="0">
        <tr>
            <td>
                <h2>Comments</h2>
            </td>
        </tr>
        <?php 
		 foreach($assessComments as $com):
		 ?>
        <tr>
            <td><?=$com['comments']?></td>
        </tr>
        <tr>
            <td><strong>Added Date :</strong><?=mysql2date($com['created_date'])?>,
                <strong>Added By :</strong> <?=$com['created_emp']?>,
                <?php if($com['modified_by']!= 0){ ?>
                <strong>Last Modified :</strong><?=mysql2date($com['modified_date'])?>,
                <strong>Modified By :</strong><?=$com['modified_emp']?>
                <?php } ?></td>
        </tr>
        <?php
		  endforeach; 
	}
endforeach;
?>

</body>

</html>