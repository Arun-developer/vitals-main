<?php

$server_url = $this->config->item('server_url');

$url_server=explode('/',site_url(''), 5); 

?>

<iframe src="<?php echo $url_server['0']."//".$url_server['2']."/ajaxplorer/"; ?>" name="dms" width="100%" height="750" frameborder="0"> </iframe>