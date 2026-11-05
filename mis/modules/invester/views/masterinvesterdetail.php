<?php 

if(php72_count($investertotaldetail)>0)
{
 $val=$investertotaldetail[0];
}
?>
<h1><?=$cpagetitle ?></h1>

 <div id="user-grid" class="gtable sortable">
	
			
        <form>
			<dl class="inline">
                 
               <dt><label for="name"><img src="<?=base_url();?>source/template/images/icons/dummy.gif" ></label></dt>
				<dd><?php echo $val['first_name']; ?></dd>
                
                <dt><label for="name">Sector</label></dt> 
                <dd>
					<?php echo $val['sector']; ?>
				</dd>
              
                <dt><label for="password">Telephone</label></dt>
				<dd><?php echo $val['telephone']; ?></dd>
                
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
			
		</form>	
            <div style="clear:both"></div>


  </div>   
