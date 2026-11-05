<?php
$server_url = $this->config->item('server_url');
$url_server=explode('/',site_url(''), 5); 
echo $username;
echo $password;

?>
<iframe src="<?php echo $url_server['0']."//".$url_server['2']."/mip/"; ?>" name="mip" width="100%" height="750" frameborder="0"> </iframe>