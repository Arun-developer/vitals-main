<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>jQuery Drop Down Menu</title>

<!-- CSS For The Menu -->
<link rel="stylesheet" href="style.css" />

</head>
<body>

<!-- Menu Start -->
<div id="jQ-menu">

<?php
	$path = "./";

	function createDir($path = '.')
	{
            $queue = array();
		if ($handle = opendir($path))
		{
			echo "<ul>";

			while (false !== ($file = readdir($handle)))
			{
				if (is_dir($path.$file) && $file != '.' && $file !='..')
					printSubDir($file, $path, $queue);
				else if ($file != '.' && $file !='..')
					$queue[] = $file;
			}

			printQueue($queue, $path);
			echo "</ul>";
		}
	}

	function printQueue($queue =array(), $path="")
	{
		foreach ($queue as $file)
		{
			printFile($file, $path);
		}
	}

	function printFile($file ="", $path="")
	{
		echo "<li><a href=\"".$path.$file."\">$file</a></li>";
	}

	function printSubDir($dir= "", $path="")
	{
		echo "<li><span class=\"toggle\" onclick='geturlLink(\"".$path.$dir."\");'>$dir</span>";
		createDir($path.$dir."/");
		echo "</li>";
	}
    $path = "../ajaxplorer/data/personal/admin/Villgro/";
	createDir($path);

?>

</div>
<!-- End Menu -->


<!-- Add jQuery From the Google AJAX Libraries -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>

<!-- jQuery Color Plugin -->
<script type="text/javascript" src="jquery.color.js"></script>

<!-- Import The jQuery Script -->
<script type="text/javascript" src="jMenu.js"></script>

<style type="text/css">
    ul li .toggle {
            background:url(images/directory.png) no-repeat !important;
            padding-left: 20px;
    }
</style>
</body>
</html>