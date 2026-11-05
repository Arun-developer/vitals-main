<?php 

if(count($boardmemberdetail)>0)
{
  $val=$boardmemberdetail[0];
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
                <dt><label for="name">Experience</label></dt>
                <dd><?php echo $val['experience']; ?> years</dd>
            
				<dt><label for="password">Position</label></dt>
				<dd>Board Member</dd>
                
                <dt><label for="password">Telephone</label></dt>
				<dd><?php echo $val['telephone']; ?></dd>
                
                <dt><label for="password">Mobile</label></dt>
				<dd><?php echo $val['mobile']; ?></dd>
                
                <dt><label for="password">Email</label></dt>
				<dd><?php echo $val['email']; ?></dd>
                
                 
                <dt><label for="comments">Education</label></dt>
              
				<dd><?php echo $val['education']; ?></dd>
                
                
                <dt><label for="comments">Comments</label></dt>
                <dd><?php echo $val['comments']; ?></dd>
                 
                 
                <dt><label for="comments">Resume</label></dt>
                <dd><?php if($val['resume']){ ?>
                    <a href="<?php echo base_url()."uploads/resume/".$val['resume'];?>"  target="_blank" >&nbsp;&nbsp;<img src="<?=base_url();?>source/template/images/icons/download.gif" height="20"  /><?=$val['resume']?></a>
                    <?php } ?></dd>
                
			</dl>
			
		</form>	
            <div style="clear:both"></div>


  </div>   
