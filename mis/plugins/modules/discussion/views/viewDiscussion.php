<ul class="option-tab">
<li><a href="<?=site_url('activities/view_list/'.$activityDetails['0']['innovation'])?>" class="button" >Activities</a></li>
<li><a href="<?=site_url('activities/activity_details/'.$activityDetails['0']['innovation'].'/'.$activityDetails['0']['id']);?>" class="button white">Back</a></li>
</ul>
<h1><?=$cpagetitle?>-<?=$activityDetails['0']['name_of_enterprise']?></h1>
<?php
$nullLink = 'javascript:void(0);';
$form_name = 'query_list';
?>

<?php if(count($discussionDetails)=='0'){ ?>


<form id="discussion" action="<?=site_url('discussion/create/'.$activity)?>" enctype="multipart/form-data" method="post" name="discussion" class="uniform">

<fieldset>
    <legend>Create Discussion</legend>
    <p style="float:right; color:red; font-weight:bold; text-align:right;">Fields marked with (*) represents required. </p>
    <dl class="inline">
        <dt><label for="discussion_title">Title<font class="req_field">*</font></label></dt>
        <dd>
		<?php $discussion_title = isset($_REQUEST["discussion_title"])?$_REQUEST["discussion_title"]:""; ?>
		<input type="text"  name="discussion_title" class="input-text required" value="<?=$discussion_title?>"  size="40" /></dd>
        
        <dt><label for="description">Description<font class="req_field">*</font></label></dt>
        <dd>
        <?php $description = isset($_REQUEST["description"])?$_REQUEST["description"]:""; ?>
        <textarea name="description" class="input-text required" rows="5" cols="40" ><?=$description?></textarea>
        </dd>
        
        <dt><label for="link">Link</label></dt>
        <dd>
		<?php $link = isset($_REQUEST["link"])?$_REQUEST["link"]:""; ?>
		<input type="text"  name="link" class="input-text" value="<?=$link?>"  size="40" /></dd>
        
        <dt><label for="documents">Document</label></dt>
        <dd>
		<?php $documents = isset($_REQUEST["documents"])?$_REQUEST["documents"]:""; ?>
		<input type="file"  name="documents"  /></dd>
</dl>
	
<div class="buttons">
		<input type="submit" value="Create" name="txtSubmit" class="button"  />&nbsp;&nbsp;
        <input type="reset" value="Reset" name="txtSubmit" class="button white"  />
</div>
</fieldset>
</div>
</form>
<?php }else{ 
?>
<ul class="comments">
<?php 
foreach($discussionDetails as $row):
?>
				<li>
						<div class="comment-body clearfix">
							<h2><?=$row['discussion_title']?></h2>
							<div><?=$row['description']?></div>
                            <?php if(!empty($row['link'])){ ?>
                            <div><strong>Link :&nbsp;</strong><a href="<?=$row['link'];?>"  target="_blank" ><?=$row['link']?></a></div>
                            <?php } ?>
                            <?php if(!empty($row['documents'])){ ?>
                            <div><strong>Document:&nbsp;</strong><?=$row['documents']?><a href="<?php echo base_url()."uploads/discussion/".$row['documents'];?>"  target="_blank" >&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /></a></div>
                            <?php } ?>
						</div>
						<div class="links">
							<span class="date"><strong>Created On :</strong><?=date("d M Y",strtotime($row['created_date']))?></span>
                            <span class="date"><strong>Created by :</strong><?=$row['created_emp']?></span>
						</div>
					</li>
<?php 
$discussion = $row['id'];
endforeach;
?>	
          </ul>
<?php }

if(count($discussionDetails)!='0'){
?><br />

<h1>Comments (<?=@$row['no_of_comments']?>)</h1>
<ul class="comments">
	   <?php
        if(count($commentsList))
        {    
            $r=1;
            foreach($commentsList as $row)
            {
                $row_type = ($r%2 == 0) ? ('even'):('odd');
                $r++;
                ?>
                <li>
						<div class="comment-body clearfix">
							<h2><?=$row['title']?></h2>
							<div><?=$row['comments']?></div>
                            
                            <?php if(!empty($row['documents'])){ ?>
                            <div><strong>Document:&nbsp;</strong><?=$row['documents']?><a href="<?php echo base_url()."uploads/discussion/".$row['documents'];?>"  target="_blank" >&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /></a></div>
                            <?php } ?>
						</div>
						<div class="links">
							<span class="date"><strong>Created On :</strong><?=date("d M Y",strtotime($row['created_date']))?></span>
                            <span class="date"><strong>Created by :</strong><?=$row['created_emp']?></span>
                            <a href="javascript:void(0);" url="<?=site_url('discussion/delete_comments/'.$activity.'/'.$row["discussion"].'/'.$row["id"])?>" class="confirmDelete delete" >Delete</a>
						</div>
					</li>

                <?php 
            }
        }
        else
        {
		?>
		<li>No Comments Added!</li>
	<?
	} ?>
</ul>
 <form action=""  method="post" name="discussionSearch" id="discussionSearch"></form>
    <?php echo  $this->pagination->create_links('discussionSearch');?>
    
    
<form id="add_comments" action="<?=site_url('discussion/add_comments/'.$activity.'/'.$discussion)?>" enctype="multipart/form-data" method="post" 
name="add_comments" class="uniform">
<fieldset>
    <legend>Post your Comments</legend>
    <p style="float:right; color:red; font-weight:bold; text-align:right">Fields marked with (*) represents required. </p>
    
<dl class="inline">
        <dt><label for="title">Title<font class="req_field">*</font></label></dt>
        <dd>
		<?php $title = isset($_REQUEST["title"])?$_REQUEST["title"]:""; ?>
		<input type="text"  name="title" class="input-text required" value="<?=$title?>"  size="60" />
        </dd>
		
        <dt><label for="comments">Comments<font class="req_field">*</font></label></dt>
        <dd>
        <?php $comments = isset($_REQUEST["comments"])?$_REQUEST["comments"]:""; ?>
        <textarea name="comments" class="input-text required" rows="5" cols="60" ><?=$comments?></textarea>
        </dd>
        
        <dt><label for="documents">Documents</label></dt>
        <dd>
		<?php $documents = isset($_REQUEST["documents"])?$_REQUEST["documents"]:""; ?>
        <input type="file"  name="documents"  />
        </dd>
</dl>
<div class="buttons">
		<input type="submit" value="Post" name="txtSubmit" class="button"  />&nbsp;&nbsp;
        <input type="reset" value="Reset" name="txtSubmit" class="button white"  />
</div>
</fieldset>
</form>
<!-- Paging style -->
<?php } ?>
