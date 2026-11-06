<ul class="option-tab">
    <li><a href="<?=site_url('activities/view_list/'.$activityDetails['0']['innovation'])?>"
            class="button">Activities</a></li>
    <li><a href="<?=site_url('activities/activity_details/'.$activityDetails['0']['innovation'].'/'.$activityDetails['0']['id']);?>"
            class="button white">Back</a></li>
</ul>
<h1><?=$cpagetitle?> - <?=$activityDetails['0']['name_of_enterprise']?></h1>
<?php
$nullLink = 'javascript:void(0);';
$form_name = 'query_list';
?>
<br />
<form id="company_list" action="<?=site_url('query/view_list/'.$activity)?>" method="post" name="<?=$form_name?>">
    <input type="hidden" name="ordertype" value="<?=$ordertype?>" />
    <input type="hidden" name="orderby" value="<?=$orderby?>" />
    <div class="searchBox" style=" <?=($_POST)?'':'display:none;'?>">
        <dl class="inline">
            <dt><label for="discussion_title">Raised By</label></dt>
            <dd>
                <?php $created_by = isset($_REQUEST["created_by"])?$_REQUEST["created_by"]:'';     ?>
                <select id="created_by" name="created_by">
                    <option value="">-Select-</option>
                    <?php 
		 foreach($usersList as $row) {
			 ?>
                    <option value="<?=$row['emp_number']?>"
                        <?php if($created_by == $row['emp_number']){  echo 'selected'; } ?>><?=$row['emp_name']?>
                    </option>
                    <?php } ?>

                </select>
            </dd>
            <dt><label for="discussion_title">Raised To</label></dt>
            <dd>
                <?php $employee = isset($_REQUEST["employee"])?$_REQUEST["employee"]:'';     ?>
                <select id="employee" name="employee">
                    <option value="">-Select-</option>
                    <?php 
		 foreach($usersList as $row) {
			 ?>
                    <option value="<?=$row['emp_number']?>"
                        <?php if($employee == $row['emp_number']){  echo 'selected'; } ?>>
                        <?=$row['emp_name']?></option>
                    <?php } ?>

                </select>
            </dd>
            <dt><label for="discussion_title">Subjcet Line</label></dt>
            <dd>
                <?php $subject_line = isset($_REQUEST['subject_line'])?$_REQUEST['subject_line']:'';?>
                <input type="text" name="subject_line" class="input-text" value="<?=$subject_line?>" />
            </dd>
        </dl>
        <div class="buttons">
            <input type="submit" value="Search" name="txtSubmit" class="button" />
            <input type="reset" value="Reset" name="txtReset" class="button white" />
        </div>

    </div>
</form>
<div style=" float:right; text-align:right;width:100%;">
    <a href="<?=$nullLink?>" class="button toggleSearch" class="button">Show Search</a>&nbsp;&nbsp;
    <?php echo anchor('query/add/'.$activity,'Add Query','class="button fancybox"'); ?>
</div>
<br /><br />

<table class="gtable sortable">
    <thead>
        <tr>
            <th><a href="<?=$nullLink?>" field="id" class="sortlink">Query Id</a></th>
            <th><a href="<?=$nullLink?>" field="subject_line" class="sortlink">Subjcet Line</a></th>
            <th><a href="<?=$nullLink?>" field="query_description" class="sortlink">Query Description</a></th>
            <th><a href="<?=$nullLink?>" field="query_response" class="sortlink">Query Response</a></th>
            <th><a href="<?=$nullLink?>" field="due_date" class="sortlink">Due Date</a></th>
            <th><a href="<?=$nullLink?>" field="documents" class="sortlink">Documents</a></th>
            <th><a href="<?=$nullLink?>" field="alert" class="sortlink">Alert</a></th>
            <th><a href="<?=$nullLink?>" field="created_by" class="sortlink">Raised by</a></th>
            <th><a href="<?=$nullLink?>" field="employee" class="sortlink">Raised to </a></th>
            <th><a href="<?=$nullLink?>" field="status" class="sortlink">Status</a></th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
	if(php72_count($queryList))
	{    
		$r=1;
		foreach($queryList as $row)
		{
			$row_type = ($r%2 == 0) ? ('even'):('odd');
			$r++;
			?>
        <tr class="<?=$row_type?>">
            <td align="left" valign="middle"><?=$row["id"]?></td>
            <td align="left" valign="middle"><?=$row["subject_line"]?></td>
            <td align="left" valign="middle"><?=$row["query_description"]?></td>
            <td align="left" valign="middle"><?=$row["query_response"]?></td>
            <td align="left" valign="middle"><?=mysql2date($row["due_date"])?></td>
            <td align="left" valign="middle"><?=$row["documents"]?></td>
            <td align="left" valign="middle"><?=(php72_cmp($row["alert"])==1)?'Yes':'No'?></td>
            <td align="left" valign="middle"><?=$row["created_emp"]?></td>
            <td align="left" valign="middle"><?=$row["employee_name"]?></td>
            <td align="left" valign="middle">
                <?php 
                if($row["query_status"]=='1') { 
                    echo anchor('query/changestatus/'.$activity.'/'.$row["id"].'/0',"Open",'class=""'); 
                }else{ 
                    echo anchor('query/changestatus/'.$activity.'/'.$row["id"].'/1',"Closed",'class=""');
                }
                ?>
            </td>
            <td nowrap="nowrap">
                <?php echo anchor('query/edit/'.$activity.'/'.$row["id"],"View",'class="fancybox"');	?>
                <a href="javascript:void(0);" url="<?=site_url('query/delete/'.$activity.'/'.$row["id"])?> "
                    class="confirmDelete">
                    <img src="<?=base_url();?>source/template/images/icons/cross.png" alt="Delete" />
                </a>

            </td>
        </tr>
        <?php 
		}
	}
	else
	{ ?>
        <tr>
            <td colspan='11' align='center'>No Records found!</td>
        </tr>
        <?php
	} ?>

    </tbody>
</table>
<!-- Paging style -->
<?php echo  $this->pagination->create_links($form_name);?>