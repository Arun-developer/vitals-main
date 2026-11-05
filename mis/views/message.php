<?php

$errorMsg = (!empty($errorMsg))?$errorMsg:'';

$successMsg = (!empty($successMsg))?$successMsg:'';

$warningMsg = (!empty($warningMsg))?$warningMsg:'';

$infoMsg = (!empty($infoMsg))?$infoMsg:'';

$errorMsg = ($this->session->flashdata('errorMsg'))?$this->session->flashdata('errorMsg'):$errorMsg;

$successMsg = ($this->session->flashdata('successMsg'))?$this->session->flashdata('successMsg'):$successMsg;

$warningMsg = ($this->session->flashdata('warningMsg'))?$this->session->flashdata('warningMsg'):$warningMsg;

$infoMsg = ($this->session->flashdata('infoMsg'))?$this->session->flashdata('infoMsg'):$infoMsg;



if(!empty($warningMsg)){  $show_msg = $warningMsg; $show_class ='warning'; 	}

if(!empty($infoMsg)){ $show_msg = $infoMsg; $show_class ='info'; }

if(!empty($errorMsg)){ $show_msg = $errorMsg; $show_class ='error'; }

if(!empty($successMsg)){ $show_msg = $successMsg; $show_class ='success';}



if(!empty($show_msg))

{

?>

<div class="msg <?=$show_class?>" ><?=$show_msg?></div>

<?php } ?>