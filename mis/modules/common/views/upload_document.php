<h1><?= $cpagetitle . '-' . $name_of_enterprise ?></h1>
<?php
$server_url = $this->config->item('server_url');

$url_server = explode('/', site_url(''), 5);
?>

<br>

<iframe src="<?php echo $url_server['0'] . "//" . $url_server['2'] . "/phpfsmanager_1.0/fsmanager.php"; ?>" name="File manager" width="100%" height="500" frameborder="0"> </iframe>
