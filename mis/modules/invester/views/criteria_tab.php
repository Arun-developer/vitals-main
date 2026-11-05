<ul class="tabs">
    
	<?php 
	if(count($match)>0)
	{
	foreach($match as $row):
	   $url= $this->uri->segment('5');
	?>  
	               
        <li class="<?=($url == $row['id'])?'selected':'';?>">
          <a href="<?=site_url('invester/investerDetail/'.$innovationid.'/'.$id.'/'.$row['id'].'/');?>" ><?=$row['master_name']?></a>
        </li>
    <?php endforeach; ?>
 </ul>
 <br/> <?php
			  if($url==113)
			  {
				 $tabid=$url;
				 $this->load->view('businessDocument');	
			  }
			  elseif($url==114)  
			  {
				  $this->load->view('boardResolution');
			  }
			  elseif($url==115)
			  {
				   $this->load->view('pitchDocument');
			  }
			  else
			  {
				   $this->load->view('businessDocument');
			  }
	}	
			   ?>
		
	