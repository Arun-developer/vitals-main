<ul class="tabs">
    
	<?php 
	if(php72_count($match)>0)
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
			  if(php72_cmp($url)==113)
			  {
				 $tabid=$url;
				 $this->load->view('businessDocument');	
			  }
			  elseif(php72_cmp($url)==114)  
			  {
				  $this->load->view('boardResolution');
			  }
			  elseif(php72_cmp($url)==115)
			  {
				   $this->load->view('pitchDocument');
			  }
			  else
			  {
				   $this->load->view('businessDocument');
			  }
	}	
			   ?>
		
	