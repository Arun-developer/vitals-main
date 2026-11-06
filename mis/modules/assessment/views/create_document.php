
	<table width="75%" align="center" >
    <tr><td>
    <h2><?=$innovationInfo['name_of_enterprise']?></h2>
    </td>
    </tr>
    
    <tr>
    <td>
	<?php
	$rowType = 'odd';
    foreach($assessDetails as $row):
		$rowType = ($rowType=='odd')?'even':'odd';
	?>
    <div class="<?=$rowType?>" style="border-bottom:1px dashed #CCC; padding:5px;">
    <h2><?=$row['criteria_title']?> - <?=$row['title']?></h2>
    <p class="t-left">
	<?php
  	$source = $row['description'];
    $imgLink = '/S*src\s*=\s*[\""\']?([^\""\']*)/i'; 
			preg_match_all($imgLink, $source, $matches);
			$matchVal = php72_array_filter($matches);
			$count = count($matchVal); 
			if($count != 0)
			{
				$imageArray = $matchVal['1'];
				foreach($imageArray as $key=>$img):
					$imgArray[] = $img;
 					$imgFullPath[] = base_url().str_replace('/mis/','',$img);
					
				endforeach;
				$source = str_replace($imgArray,$imgFullPath,$source);
				$source = str_replace('http://localhosthttp://','http://',$source);
				$source = str_replace('https://mis.villgroapps.orghttps://','https://',$source);
			}//count the array elements 
	  echo $source;		
				
    ?></p>
    
    <a href="<?=$row['link']?>" target="_blank"><p class="t-left"><?=$row['link']?></p></a>
    
    <p class="t-left"><strong>Added Date :</strong> 
	<?=mysql2date($row['created_date'])?>, <strong>Added By :</strong> <?=$row['created_emp']?>
     <?php if($row['modified_by']!=''){ ?>
    <strong>Last Modified :</strong><?=mysql2date($row['modified_date'])?>,
    <strong>Modified By :</strong><?=$row['modified_emp']?>
    <?php } ?>
    </p>
     <?php 
	 $assessComments = $this->Massessment->getAssessComments($row['id']);
	 if(php72_count($assessComments))
	 {
		 echo '<h2>Comments</h2>';
	 }
	 foreach($assessComments as $com):
	 ?>
		<div style="border-bottom:1px dashed #CCC; ">
		<p ><?=$com['comments']?></p>
		<p>
		<strong>Added Date :</strong><?=mysql2date($com['created_date'])?>,
		<strong>Added By :</strong> <?=$com['created_emp']?>,
		<?php if(php72_cmp($com['modified_by'])!= 0){ ?>
		<strong>Last Modified :</strong><?=mysql2date($com['modified_date'])?>,
		<strong>Modified By :</strong><?=$com['modified_emp']?>
		<?php } ?>
		</p>
		
		</div>
	  <?php
	  endforeach; 
	 ?>
    </div>
    <?php endforeach; ?>
    <?php if(!php72_count($assessDetails)){ echo ' <p class="t-center">No Details</p>';} ?>
    </td>
    </tr>
    <?php
	$currentStage = $this->Mprogram_stage->getCurrentStage('1');
	$activity = $this->Mactivities->getActivityForGrading($innovationInfo['id'],$currentStage);
	if(php72_count($activity)){ ?>
    <tr><td>
    <h3>Spider Map</h3>
    <?php
	$this->load->model('grading/Mgrading');
    $isMap = $this->Mgrading->makeSpider($activity['0']['id']);
			if($isMap){
			?>
            <div style="text-align:center; margin-left:60px;  width:600px;"><img src="<?=base_url()?>map.png" align="center" ></div>
            <?php
			}
			else
			{
				echo "No records to display";
			}
	?>
    </td>
    </tr>
    <?php }	?>

    </table>
<!-- end id-form  -->


<!-- end id-form  -->
