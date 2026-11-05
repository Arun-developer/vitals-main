            <?php 
            $i = 0;
			foreach($programStageList as $row):
			++$i;
			?>
                    <tr class="odd">
                    <td align="left" valign="middle" class="sNo"><?=$i?>
                    </td>
                    <td align="left" valign="middle">
                    <?php
                        foreach($activityType as $pt):
                           echo ($row['activity_type']==$pt['id'])?$pt['master_name']:'';
                        endforeach;
                        ?>
                    </td>
                    <td align="left" valign="middle"><?=$row['activity_description']?></td>
                     <td align="left" valign="middle"> 
                    <input type="checkbox" name="use[]" value="<?=$row['id']?>" <?=(php72_in_array($row['id'],$usedActivity))?'checked':'';?>  />
                    </td>
                    </tr>
            <?php 
			endforeach; ?>