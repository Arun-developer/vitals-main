
<?php

	$val = array();
	if(php72_count($selectComments)) 
	{ 
	  $val=$selectComments[0];
	} 
	if(isset($_POST['id'])){ $val = $_POST; }
	$description = isset($val["description"])?$val["description"]:"";
	$document = isset($val["document"])?$val["document"]:"";

	
?>

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" >
			
				<h1><?=$cpagetitle ?></h1>
                       <ul class="comments">
					     <?php
						  foreach($selectComments as $value)
						  {?>
                           <li>
                                <div class="comment-body clearfix">
                                    <img src="<?php echo base_url(); ?>source/template/images/icons/dummy.gif" class="comment-avatar" />
                                    
                                    <div><?php echo $value['description']; ?> </div>
                                </div>
                                <div class="links">
                                    <span class="date"><strong>Added Date :</strong><?php echo $value['created_date']; ?></span>
                                    <span class="date"><strong>Added By :</strong> <?php echo $value['created_by']; ?></span>
                                    <a class="confirmDelete delete" url="<?php echo base_url(); ?>index.php/screening/delete_comments/42/11/4" href="javascript:void(0);">Delete</a>
                                </div>
                            </li>
						 <?php } ?>	
        			   </ul>
					  
                  <form name="membersuggestsubmit" enctype="multipart/form-data"  action="<?=site_url('boardmember/boardmemberComments/'.$innovation.'/'.$id);?>" method="post" id="lineitemForm" >   
						 <fieldset>
							 <legend>Post Comments</legend>
							   <dl class="inline">
								 <dt><label for="name">Document Description<span class="req_field">*</span></label></dt>
								 <dd><input type="text" name="document_description" value="" />
								 </dd>
								 
								 
								  <dt><label for="name">Document</label></dt>
       							  <dd><input type="file" name="document"/>
										<?php if($document!='')
										{?>
											<?=$document?>&nbsp;<a href="/ajaxplorer/data/personal/admin/Villgro/System Files/MIS/uploads/presentation/<?=$document?>" target="_blank" class="button">View / Download</a>
           						  <?php }?></dd>
								  </dd>
								 
								 <dt><label for="name"><?= 'Comments';?><span class="req_field">*</span></label></dt>
        						  <dd><textarea name="description" id="editor" class="input-text" rows="8" cols="80" ><?=$description?></textarea>
        						  <?=form_error('description','<div class="req_field">','<div>');?>
								 </dd>
							  </dl>
							<div style="margin-left:40%;" class="buttons">
							 <input type="submit" class="button" name="txtSubmit" value="Post Comments" />
							 <input type="reset" class="button white" name="txtReset" value="Reset" />
						   </div>
						</fieldset>
					</form>	        
					
   
                
					
				
		
		</section>
        
        
		
		
	</section>
</section>