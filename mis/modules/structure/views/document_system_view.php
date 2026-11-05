<?php
$server_url = $this->config->item('server_url');
$url_server=explode('/',site_url(''), 5);

?>
<a class="button" href="<?php echo site_url('dms/document_system/searchDocsByKey'); ?>" style="float:right;margin-bottom:10px;font-weight:bold;">Document Search </a>
<br>
<iframe src="<?php echo $url_server['0']."//".$url_server['2']."/ajaxplorer/"; ?>" name="dms" width="100%" height="750" frameborder="0"> </iframe>