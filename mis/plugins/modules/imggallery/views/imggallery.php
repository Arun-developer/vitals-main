<html>
<div><a href="<?=site_url('imggallery/addvideo')?>" class="button">Add Video</a></div>
<iframe id="myframe" src="<?php echo "http://".$_SERVER['HTTP_HOST'].'/zenphoto/index.php?username='.$this->session->userdata('user_name').'&password='.$this->session->userdata('password');?>" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0" style="width:850px; height:700px;"></iframe>
</html>
