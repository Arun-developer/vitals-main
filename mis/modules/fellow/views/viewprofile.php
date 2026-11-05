<?php 
$val= $applicantList[0];
 
?>

	<section class="container_12 clearfix">
		<section id="main" class="">
			<article id="dashboard">
			  <h1><?= $cpagetitle; ?></h1>
          <form class="uniform" >
			<dl >
			    <dt><label for="name">Applicant Name:</label></dt>
                <dd><?php  echo $val['applicant_name']; ?></dd>
				 
				 
                <dt><label for="name">AreaofWorking:</label></dt>
                <dd>
					<?php  echo $val['area']; ?>
				</dd>
				
				 <dt><label for="name">Qualification:</label></dt>
                <dd>
					<?php  echo $val['qualification']; ?>
				</dd>
                
                <dt><label for="name">Experience:</label></dt>
                <dd>
					<?php  echo $val['experience']; ?>
				</dd>
        
			    <dt><label for="name">Address:</label></dt>
                <dd>
					<?php  echo $val['address1']; ?>
				</dd>
                <dt><label for="password">Telephone:</label></dt>
				<dd><?php  echo $val['telephone']; ?> </dd>
                
                <dt><label for="password">Mobile:</label></dt>
				<dd><?php  echo $val['mobile']; ?> </dd>
                
                <dt><label for="password">Email</label></dt>
				<dd><?php  echo $val['email']; ?></dd>
                
			</dl>
            <div style="clear:both"></div>

			</form>
				
			</article>
		</section>
        
        
		
	</section>

