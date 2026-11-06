<script type="text/javascript">
   $(document).ready(function() { 
    $('.viewScaleFact').click(function(){
			$('.scaleFact').hide();						   
			$(this).parents('td').find('.scaleFact').show();								   
		});
		$('.closeScaleFact').click(function(){
			$(this).parents('table').find('.scaleFact').hide();								   
		});
}); 
</script>
<?php
	$val = array();
	if(php72_count($assessInfo)) { 
		$action = 'Update';
		$val = $assessInfo['0'];
		$val_grade= $gradevalue['0'];//getting grade value
	}
	else
	{
		$action = 'add';
	} 
	if(isset($_POST['id'])){ $val = $_POST; }
	
	$title = isset($val["title"])?$val["title"]:"";
	$description = isset($val["description"])?$val["description"]:"";
	$documents = isset($val["documents"])?$val["documents"]:"";
	$link = isset($val["link"])?$val["link"]:"";
	$id = isset($val["id"])?$val["id"]:"";
	$grade = isset($val_grade['grade'])?$val_grade['grade']:"";
	
switch(php72_cmp($criteria))
{
    case 11:
        $cpagetitl = 'Innovation';
        break;
    case 12:
        $cpagetitl = 'Entrepreneur';
        break;
    case 13:
        $cpagetitl = 'Social Impact';
        break;
    case 14:
        $cpagetitl = 'Business Viability';
        break;
    case 15:
        $cpagetitl = 'Scalability';
        break;
    case 61:
        $cpagetitl = 'Incubation Fit';
        break;
    
}

?>

<ul class="option-tab">
<li><a href="<?=site_url('assessment/view_details/'.$innovation['id'].'/'.$criteria);?>" class="button">Back</a></li>
</ul>
<h1><?=$cpagetitle?>-<?=$cpagetitl;?></h1>
<p style="float:right; color:red; font-weight:bold;">Fields marked with (*) represents required. </p>
<form name="add_assess_details" enctype="multipart/form-data" action="<?=site_url('assessment/form/'.$innovation['id'].'/'.$criteria)?>" method="post" id="add_assess_details" class="uniform" >
<input type="hidden" name="id" value="<?=$id?>"  />
<input type="hidden" name="olddocument" value="<?=$documents?>" />
<table>
	<tr>
    <td><label for="score">Score</label></td>
    <td>
        <select name="score"> 
            <option value="1" <?php echo isset($val_grade['grade']) && ($val_grade['grade']=='1') ?"selected=selected":"" ;?> >1</option>
            <option value="2" <?php echo isset($val_grade['grade']) && ($val_grade['grade']=='2')  ? "selected='selected'":"" ;?> >2</option>
            <option value="3" <?php echo isset($val_grade['grade']) && ($val_grade['grade']=='3') ?"selected=selected":"" ;?> >3</option>
            <option value="4" <?php echo isset($val_grade['grade']) && ($val_grade['grade']=='4') ?"selected=selected":"" ;?> >4</option>
            <option value="5" <?php echo isset($val_grade['grade']) && ($val_grade['grade']=='5') ?"selected=selected":"" ;?> >5</option>
            <option value="6" <?php echo isset($val_grade['grade']) && ($val_grade['grade']=='6') ?"selected=selected":"" ;?> >6</option>
        </select>
	<?php foreach($gradesMasterList as $row): ?>
        <?php 
        if($row['category'] == $criteria){ ?>
         
            <a href="javascript:void(0);" class="viewScaleFact" >View</a>
            
            <table class="scaleFact" style="display:none;z-index: 1;position:absolute; background:#C5DBED; border:2px solid #666; width:500px;" >
            <tr>
                <td align="center" valign="top" colspan="2">Scaling Factors ( <a href="javascript:void(0);" class="closeScaleFact" style="color:red;" >Close</a>)</td>
			</tr>
			<?php 
			$scaling_factor = @unserialize($row['scaling_factor']);
			$scaling_factor = (is_array($scaling_factor))?$scaling_factor:array();
                        
			foreach($scaling_factor as $key=>$value): ?>
             <tr>
                <td width="100"  align="right" valign="top">[<strong>Scale <?=$key+1?></strong>]</td>
                <td><?=$value?></td>
			</tr>
   			<?php endforeach;?>
            </table>
           
            
        <?php } ?>
        <?php endforeach;?></td></tr>
	 <tr>
    <td><label for="description">Description<span class="req_field">*</span></label></td>
    <td><textarea name="description" id="editor" class="input-text" rows="20" cols="70" ><?=$description?></textarea>
        <?=form_error('description','<div class="req_field">','<div>');?></td></tr>
     <tr>
    <td><label for="name">Documents</label></td>
    <td><input type="file" name="documents" />
		<?php if($documents!=''){?>
		<a href="<?=base_url()?>uploads/assessment/<?=$documents?>" class="button">view</a>
		<?php }?></td>
      </tr><tr>
    <td><label for="link">Link</label></td>
    <td><input type="text" name="link" class="input-text url" size="40" value="<?=$link?>" /></td></tr>
</table>   
<div class="clear"></div> 
<div class="buttons">
			<input type="submit" value="<?=ucfirst($action)?> Details" name="txtSubmit" class="button" />
			<input type="reset" value="Reset" name="txtReset" class="button white" />
</div>
</form>