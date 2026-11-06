<?php
$nullLink = "javascript:void(0);";
$this->load->library('jquery');
$this->jquery->fancybox();
$if = (!$isincubAuth);
?>
<h1><?=$cpagetitle ?></h1>
<ul class="option-tab" style="margin-top:0px;">
    <li><a href="<?=site_url('media/publisharticle/'.$innovationid);?>" class="button">Add Published Articles</a></li>
    <?php  if($isincubAuth)
    { ?>
    <li>
        <a href="<?=site_url('media/form/'.$innovationid);?>" class="button">Request Media</a></li>

    <?php	} else {?>
    <li>
        <a class="button" href="<?=site_url('activities/view_list/'.$innovationid);?>">
            Activities
        </a> </li>
    <?php } ?>
</ul>
<br /><br />
<!--start table-content  -->


<div id="user-grid" class="gtable sortable">
    <table width="100%" class="items">
        <thead>
            <tr>
                <th><a href="<?=$nullLink?>" field="label">Requested Title</a></th>
                <th><a href="<?=$nullLink?>" field="label">Requested Topic</a></th>
                <th><a href="<?=$nullLink?>" field="label">Requested On</a></th>
                <th><a href="<?=$nullLink?>" field="label">Requested By</a></th>
                <th><a href="<?=$nullLink?>" field="value">Decision</a></th>
                <th><a href="<?=$nullLink?>" field="status">Details</a></th>
                <th><a href="<?=$nullLink?>" field="value">Status</a></th>
                <?php if($if){?>
                <th><a href="<?=$nullLink?>" field="status">Action</a></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
	if(php72_count($applicantList))
	{    
		$r=1;
		foreach($applicantList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
            <tr class="<?=$row_type?>">
                <td align="left" valign="middle"><?=$row["title"];?></td>
                <td align="left" valign="middle"><?=$row["topic"];?></td>
                <td align="left" valign="middle"><?=$row["requested_on"];?></td>
                <td align="left" valign="middle"><?=$innovator;?></td>
                <td align="left" valign="middle">
                    <?php if(php72_cmp(($row['decision']))==0)
						      {
							    echo "Accepted";
							  }
							  else
							  { if(!$isincubAuth) {?>
                    <a class="button fancybox " height="200"
                        href="<?=site_url('media/liststatus/approve/'.$innovationid.'/'.$row['id']);?>">Approve</a>
                    <?php } }?>
                    <?php if(php72_cmp(($row['decision']))==1)
						   {
						     echo "Rejected";
						   }
						   else
						   { if(!$isincubAuth) {?>
                    <a class="button  fancybox" height="200"
                        href="<?=site_url('media/liststatus/reject/'.$innovationid.'/'.$row['id']);?>">Reject</a>
                    <?php } } ?>

                    <?php if(php72_cmp(($row['decision']))==2)
					      {
					         echo "Pending";
			   		      } ?>
                </td>
                <td align="left" valign="middle"><a href="<?=site_url('media/showdetail/'.$row['id'])?>"
                        class="fancybox">Details</a></td>
                <td align="left" valign="middle"><?=$row['status'];?></td>
                <td nowrap="nowrap">
                    <?php if(!$isincubAuth){ ?>
                    <?php if(php72_cmp($row['decision'])==0){?>
                    <a href="<?=site_url('media/addinnovator_detail/'.$innovationid.'/'.$row['id'])?>"
                        class="fancybox">Schedule Interview</a>
                    <a href="<?=site_url('media/addmedia_detail/'.$innovationid.'/'.$row['id'])?>" class="button">Add
                        Media</a><?php }?>
                    <a href="<?=site_url('media/form/'.$innovationid.'/'.$row['id'])?>">
                        <img src="<?php echo base_url(); ?>source/template/images/icons/edit.png" title="Edit">
                    </a>&nbsp;
                    <a href="<?=site_url('media/delete/'.$row['id'])?>" class="confirmDelete">
                        <img src="<?php echo base_url(); ?>source/template/images/icons/cross.png" title="Delete">
                    </a><?php } ?>
                </td>
            </tr>
            <?php 
		}
	}
	else
	{ ?>
            <tr>
                <td colspan='9' align='center'>No Records found!</td>
            </tr>
            <?php
	} ?>
        </tbody>
    </table>
    <!-- Paging style -->
</div>


<br /><br />