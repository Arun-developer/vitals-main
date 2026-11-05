<?php 
$val= $investerDetails[0];
?>

	<section class="container_12 clearfix">
		<section id="main" class="">
			<article id="dashboard">
			  <h1><?= $cpagetitle; ?></h1>
          <form class="uniform" >
			<dl class="inline">
			    <dt><label for="name">
               <?php if($val['photograph']=='')
			     {?>
			   <img src="<?=base_url();?>source/template/images/icons/dummy.gif" >
		 <?php   } ?></label></dt> 
              
                <dd><?php  echo $val['first_name']; ?></dd>
				 
				 
                <dt><label for="name">Sector</label></dt>
                <dd>
					<?php  echo $val['sector']; ?>
				</dd>
        
			   
               
                
                <dt><label for="password">Telephone</label></dt>
				<dd><?php  echo $val['telephone']; ?> </dd>
                
                <dt><label for="password">Mobile</label></dt>
				<dd><?php  echo $val['mobile']; ?> </dd>
                
                <dt><label for="password">Email</label></dt>
				<dd><?php  echo $val['email']; ?></dd>
				
			
                
                <dt><label for="password">Comments</label></dt>
				<dd><?php  echo $val['comments']; ?></dd>
				
        
             
                
			</dl>
            <div style="clear:both"></div>

			</form>
				
			</article>
		</section>
        
        
		
	</section>

