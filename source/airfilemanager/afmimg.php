<?php
 # file encoding: UTF-8
 # © 2010 airmedia.pl

 error_reporting(0);
 ini_set('display_errors', 'Off');
 if(ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off');
 setlocale(LC_ALL, 'en_US.UTF-8');
 mb_internal_encoding('UTF-8');

 ob_start();
 ob_clean();
 header("Pragma: public");
 header("Expires: 0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
 header("Cache-Control: private", false);
 header("Content-Transfer-Encoding: binary");

 require_once 'config.php';

 if(!isset($_GET['f']) || strlen(trim($_GET['f'])) < 1) die('-1');
 $filename = urldecode($_GET['f']);
 $afm_path = preg_replace('@[\/]+@', '/', str_replace(DIRECTORY_SEPARATOR, '/', realpath(FILES_PATH)));
 $fnm_path = $afm_path.preg_replace('@[\/]+@', '/', str_replace(DIRECTORY_SEPARATOR , '/', $filename));
 if(!file_exists($fnm_path) || !is_file($fnm_path)) die('-2');
 if(!strstr($fnm_path, $afm_path)) die('-3');
 if(strstr($fnm_path, '../..')) die('-4');

 function Cached($s)
 {
  global $afm_path;
  return str_replace($afm_path, $afm_path.'/'.CACHEDIR, $s);
 }

 $file_extension = strtolower(end(explode('.', $filename)));
 $imagetype = 'jpg';
 switch($file_extension)
 {
  case 'bm':
  case 'bmp':
  	header('Content-Type: image/bmp');
	$imagetype = 'bmp';
	break;
  case 'gif':
  	header('Content-Type: image/gif');
	$imagetype = 'gif';
	break;
  case 'png':
  	header('Content-Type: image/png');
	$imagetype = 'png';
	break;
  default:
  	header('Content-Type: image/jpeg');
 }



 # randomly execute cache clean function
 if(rand(1,20) == 1)
 {
  function AFM_CClean($dirname)
  {
   if(!is_dir($dirname)) return false;
   $dir = dir($dirname);
   while(false !== $entry=$dir->read())
   {
    if($entry == '.' || $entry == '..') continue;
    if(is_dir($dirname.'/'.$entry)) AFM_CClean($dirname.'/'.$entry);
     elseif(is_file($dirname.'/'.$entry))
	  if(time() - filemtime($dirname.'/'.$entry) >= 1209600) # two weeks lifetime
	   @unlink($dirname.'/'.$entry);
   }
   $dir->close();
   return @rmdir($dirname);
  }

  clearstatcache();
  AFM_CClean($afm_path.'/'.CACHEDIR);
  header("X-AFM-CacheCleaner: OK"); // this is for debugging, you can safely turn it off ...
 }



 if(USE_CACHE && file_exists(Cached($fnm_path)) && is_file(Cached($fnm_path)))
 {
  header("X-AFM-ImageFromCache: OK"); // this is for debugging, you can safely turn it off ...
  header("Content-Length: ".filesize(Cached($fnm_path)));
  readfile(Cached($fnm_path));
 }
  else
 {
  $iminfo = @getimagesize($fnm_path);
  if(!$iminfo) die('-5');
  $width = $iminfo[0];
  $height = $iminfo[1];
  switch($imagetype)
  {
   case 'bmp':
   	$im = imagecreatefromwbmp($fnm_path);
	break;
   case 'gif':
   	$im = imagecreatefromgif($fnm_path);
	break;
   case 'png':
   	$im = imagecreatefrompng($fnm_path);
	break;
   default:
   	$im = imagecreatefromjpeg($fnm_path);
  }
  if(!$im) die('-6');
  if($width < 1 || $height < 1) die('-7');

  if($width != MWIDTH) $ProcentS = MWIDTH / $width; else $ProcentS = 1.0;
  if($height != MHEIGHT) $ProcentW = MHEIGHT / $height; else $ProcentW = 1.0;
  $Procent = ($ProcentS > $ProcentW) ? $ProcentS : $ProcentW;
  if($Procent != 0)
  {
   $width *= $Procent;
   $height *= $Procent;
  }
  $width = (int)ceil($width);
  $height = (int)ceil($height);
  $thumb = imagecreatetruecolor(MWIDTH, MHEIGHT);
  $offsetX = 0;
  $offsetY = 0;
  if($width > MWIDTH) $offsetX = round((($width - MWIDTH) / 2) * ($iminfo[0] / $width));
  if($height > MHEIGHT) $offsetY = round((($height - MHEIGHT) / 2) * ($iminfo[1] / $height));
  imagecopyresampled($thumb, $im, 0, 0, $offsetX, $offsetY, $width, $height, $iminfo[0], $iminfo[1]);

  if(!USE_CACHE)
  {
   switch($imagetype)
   {
    case 'bmp':
    	imagewbmp($thumb);
		break;
    case 'gif':
    	imagegif($thumb);
		break;
    case 'png':
    	imagepng($thumb);
		break;
    default:
    	imagejpeg($thumb, NULL, 95);
   }
   imagedestroy($thumb);
   header("Content-Length: ".ob_get_length());
  }
   elseif(!is_file(Cached($fnm_path)))
  {
   $cd = $afm_path.'/'.CACHEDIR;
   # check if cache directory exists
   # if not, attept to create it
   if(!is_dir($cd))
   {
    if(!@mkdir($cd)) die('-8');
	@chmod($cd, 0777);
   }
   if(!is_writable($cd)) die('-9');
   # create subdirectories if needed
   $fp = explode('/', $filename);
   array_pop($fp);
   $pth = '';
   foreach($fp as $cat)
    if(mb_strlen(trim($cat)) > 0)
    {
     if(!is_dir($cd.$pth.$cat))
	 {
	  if(!@mkdir($cd.$pth.$cat)) die('-10 '.$cd.$pth.$cat);
	  @chmod($cd.$pth.$cat, 0777);
	 }
	 $pth.= $cat.'/';
    }
   # create image
   switch($imagetype)
   {
    case 'bmp':
    	imagewbmp($thumb, Cached($fnm_path));
		break;
    case 'gif':
    	imagegif($thumb, Cached($fnm_path));
		break;
    case 'png':
    	imagepng($thumb, Cached($fnm_path));
		break;
    default:
    	imagejpeg($thumb, Cached($fnm_path), 95);
   }
   imagedestroy($thumb);
   header("Content-Length: ".filesize(Cached($fnm_path)));
   readfile(Cached($fnm_path));
  }
 }

 ob_end_flush();
 die();
?>