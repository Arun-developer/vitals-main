<?php

$url_server= base_url()."webcal/login.php";

$login = lcfirst($this->session->userdata('user_name'));
$password = $this->session->userdata('password');

?>

<iframe src="<?php echo $url_server."?login=".$login."&&password=".$password; ?>" name="dms" width="100%" height="750" frameborder="0"> </iframe>