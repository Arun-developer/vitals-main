<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$header;?></title>
<link rel="stylesheet" href="<?= base_url();?>source/jquery_ui/css/south-street/master.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script src="<?= base_url();?>source/jquery_ui/js/coda.js" type="text/javascript"> </script>
</head>

<body>
  <div id="wrapper">
  <?php $this->load->view($main);?>
  </div>
</body>
</html>