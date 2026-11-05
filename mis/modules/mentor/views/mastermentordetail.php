<?php 

if(php72_count($mentortotaldetail)>0)
{
 $val=$mentortotaldetail[0];
}

?>
<h1><?=$cpagetitle ?></h1>

 <div id="user-grid" class="gtable sortable">
			
        <form>
		<?php 
		   if($company=='Villgro')
		   {?>
			<dl class="inline">
                 
                <dt><label for="name"><img src="<?=base_url();?>source/template/images/icons/dummy.gif" ></label></dt>
				<dd><?php echo $val['emp_firstname']; ?></dd>
                
                <dt><label for="password">Mobile</label></dt>
				<dd><?php echo $val['emp_mobile']; ?></dd>
                
                <dt><label for="password">Email</label></dt>
				<dd><?php echo $val['emp_work_email']; ?></dd>
                
                <dt><label for="comments">Comments</label></dt>
                <dd><?php echo $val['city_code']; ?></dd>
                 
                 
                <dt><label for="comments">Resume</label></dt>
                <dd>
				   <?php echo "NO Document"; ?>
				 
				</dd>
                
			</dl>
			<?php } 
			else
			  { ?>
			  
			   <dl class="inline">
                 
               <dt><label for="name"><img src="<?=base_url();?>source/template/images/icons/dummy.gif" ></label></dt>
				<dd><?php echo $val['first_name']; ?></dd>
      
                <dt><label for="password">Mobile</label></dt>
				<dd><?php echo $val['mobile']; ?></dd>
                
                <dt><label for="password">Email</label></dt>
				<dd><?php echo $val['email']; ?></dd>
                
                <dt><label for="comments">Comments</label></dt>
                <dd><?php echo $val['comments']; ?></dd>
                 
                <dt><label for="comments">Resume</label></dt>
                <dd>
				<?php 
				if($val['documents'])
				{?>
				 <a href="#"><img src="<?=base_url();?>source/template/images/icons/resume.jpg" height="86" width="86"> Click to Download</a>
		  <?php }
		        else
				{ 
				 echo "No Document Available";
				 } ?>
				
				 
				</dd>
                
			</dl>
			  
		<?php }
			?>
			
		</form>
		
			
            <div style="clear:both"></div>


  </div>   
