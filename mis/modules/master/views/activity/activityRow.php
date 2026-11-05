            <?php 
            $i = 0;
			foreach($programStageList as $row):
			++$i;
			?>
                    <tr class="odd">
                    <td align="left" valign="middle" class="sNo"><?=$i?>
                    </td>
                    <td align="left" valign="middle">
                    <input type="hidden" name="id[]" value="<?=$row['id']?>" disabled="disabled" />
                    <select name="activity_type[]" disabled="disabled" >
                        <option value="">-Select-</option>
                        <?php
                        foreach($activityType as $pt):
                            ?>
                            <option value="<?=$pt['id']?>" <?=($row['activity_type']==$pt['id'])?'selected':'';?>><?=$pt['master_name']?></option><?php 
                        endforeach;
                        ?>
                        </select>
                    </td>
                    <td align="left" valign="middle"><input type="text" name="activity_description[]" size="80" value="<?=$row['activity_description']?>" class="input-text required" disabled="disabled" /></td>
                     <td align="left" valign="middle"> 
                     
                     <a href="javascript:void(0);" id="<?=$row['id']?>" class="editActivityRow " ><img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit"></a>
                     <a href="javascript:void(0);" id="<?=$row['id']?>" class="removeActivityList " ><img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Edit"></a>
                    </td>
                    </tr>
            <?php 
			endforeach; ?>