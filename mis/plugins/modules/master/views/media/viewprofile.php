<?php 
$val= $applicantDetails[0];
?>

	<section class="container_12 clearfix">
		<section id="main" class="">
			<article id="dashboard">
			  <h1><?= $cpagetitle; ?></h1>
          <form class="uniform" >
			<dl class="inline">
			    <dt><label for="name">Media Name:</label></dt>
                <dd><?php  echo $val['media_name']; ?></dd>
				 
				 
                <dt><label for="name">Media Type:</label></dt>
                <dd>
					<?php  echo $val['media_type']; ?>
				</dd>
				
				 <dt><label for="name">Media Sub Type</label></dt>
                <dd>
					<?php  echo $val['media_subtype']; ?>
				</dd>
                
                <dt><label for="name">Journalist Name</label></dt>
                <dd>
					<?php  echo $val['journalist_name']; ?>
				</dd>
        
			    <dt><label for="name">Address</label></dt>
                <dd>
					<?php  echo $val['address1']; ?>
				</dd>
                <dt><label for="password">Telephone</label></dt>
				<dd><?php  echo $val['phone']; ?> </dd>
                
                <dt><label for="password">Email</label></dt>
				<dd><?php  echo $val['email']; ?></dd>
                
			</dl>
            <div style="clear:both"></div>

			</form>
				
			</article>
		</section>
        
        
		
	</section>

