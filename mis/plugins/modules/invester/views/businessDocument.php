
<form name="boardbusinessdoc" enctype="multipart/form-data"  action="<?=site_url('invester/investerDetail/'.$innovationid.'/'.$id.'/'.$tabid.'/');?>" method="post" id="lineitemForm" >
<input type="hidden" name="requestid" value="<?php echo $requestid; ?>" />
	 <fieldset>
		  <legend>Upload Modified Business Plan Document</legend>
				
				
			   
				<dl class="inline">
					  <?php $i=1;foreach($commentfile as $value)
					   {?>
						 <dt><label for="name">Document Version<?=$i?></label></dt>
						 <dd>docuemnt_ver.doc-n<?=$value['created_date']?>(<a target="_blank" href="<?=base_url()?>/uploads/invester/businessdoc/<?php echo $value['document']?>">Download</a>)&nbsp;(<a href="#">Delete</a>)
			 <?php $i++;} ?>
						</dd>
					<dt><label for="name">Upload File</label></dt>
					<dd><input type="file" name="filedoc"/></dd>
				</dl>   
			   <div class="buttons">
					<input type="submit" class="button" name="fileSubmit" value="Upload" />
					<input type="reset" class="button white" name="txtReset" value="Reset" />
			   </div>
	  </fieldset>
 </form>
 
    <h1>Comments</h1>
                         <ul class="comments">
						         <?php 
								 foreach($commentdata as $value)
								 {?>
                                    <li>
                                        <div class="comment-body clearfix">
                                            <img src="<?php echo base_url(); ?>source/template/images/icons/dummy.gif" class="comment-avatar" />
                                            
                                            <div><?php  echo $value['comments']; ?></div>
                                        </div>
                                        <div class="links">
                                            <span class="date"><strong>Added Date :</strong><?php echo $value['created_date']; ?></span>
                                            <span class="date"><strong>Added By :</strong><?php echo $value['created_by']; ?></span>
                                            <a class="confirmDelete delete" url="<?php echo base_url(); ?>index.php/screening/delete_comments/42/61/6" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </li>
							<?php  } ?>
                                   
                                
                        </ul>
  <form id="add_assess_comments" method="post" action="<?=site_url('invester/investerDetail/'.$innovationid.'/'.$id.'/'.$tabid.'/comment');?>"  name="add_assess_comments">
  <input type="hidden" name="requestid" value="<?php echo $requestid; ?>" />
                            <fieldset>
                                <legend>Post Comments</legend>
                                <dl class="inline">
                                    <dt><label for="name">Comments<span class="req_field">*</span></label></dt>
                                    <dd><textarea cols="50" rows="5" class="input-text required" name="comments"></textarea></dd>
                                </dl>
                                <div  class="buttons">
                                        <input type="submit" class="button" name="commentSubmit" value="Post Comments" />
                                        <input type="reset" class="button white" name="txtReset" value="Reset" />
                                </div>
                            </fieldset>
    </form> 