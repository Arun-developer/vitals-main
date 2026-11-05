           <?php
		   
            $i = 0;
			foreach($gradeList as $row):
			++$i;
			?>
                    <tr class="odd">
                    <td align="left" valign="middle" class="sNo"><?=$i?>
                    </td>
                    <td align="left" valign="middle">
                        <?php
                        foreach($gradingCategory as $pt):
                            echo ($row['category']==$pt['id'])?$pt['master_name']:''; 
                        endforeach;
                        ?>
                        </select>
                    </td>
                    <td align="left" valign="middle"><?=$row['criteria']?></td>
                    <td align="left" valign="middle"><?=$row['waitage']?>
                    </td>
                    <td align="left" valign="middle"><?=$row['scale']?>
                    </td>
                    <td align="left" valign="middle"><a href="<?=site_url('master/grade/form/'.$row['id']);?>" id="viewFactor" class="button" >View / Edit</a>
                    

                    </td>
                     <td align="left" valign="middle"> 
                     <a href="javascript:void(0);" id="<?=$row['id']?>" class="removeGradeList button" >Remove</a>
                    </td>
                    </tr>
            <?php 
			endforeach; ?>