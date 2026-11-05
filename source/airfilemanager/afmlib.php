<?php
 # file encoding: UTF-8
 # © 2010 airmedia.pl

 define('AFMRC_MKDIROK', 1);
 define('AFMRC_MKDIRERR', 2);
 define('AFMRC_DELETEOK', 3);
 define('AFMRC_DELETEERR', 4);
 define('AFMRC_UPLOADOK', 5);
 define('AFMRC_UPERR_TYPE', 6);
 define('AFMRC_UPERR_THMB', 7);

 function AFM_readFolder()
 {
  global $dirtbl;
  global $filetbl;
  global $mydir;
  global $inidir;
  if(strstr(preg_replace('@[\/]+@', '/', str_replace(DIRECTORY_SEPARATOR , '/', $mydir.$inidir)), '/..')) die('AFM_readFolder: Security risk - given path is '.$mydir.$inidir);
  $dir = @opendir($mydir.$inidir);
  $cnt = 0;
  if($dir)
  {
   while($fi = readdir($dir))
   {
    if($fi != '.' && is_dir($mydir.$inidir.$fi) && $fi != rtrim(CACHEDIR, '/')) array_push($dirtbl, $fi);
    if($fi != '.' && $fi != '..' && is_file($mydir.$inidir.$fi) && !in_array(AFM_fileExt($fi), explode(',', EXCLUDE_FILES)))
    {
     if($_GET['vall'] == '1' || $_GET['type'] == 'file'
      || ($_GET['type'] == 'image' && in_array(AFM_fileExt($fi), explode(',', IMAGE_FILES)))
      || ($_GET['type'] == 'media' && in_array(AFM_fileExt($fi), explode(',', MEDIA_FILES)))
      || ($_GET['type'] == 'flash' && in_array(AFM_fileExt($fi), explode(',', MEDIA_FILES)))
      || ($_GET['type'] == 'file' && in_array(AFM_fileExt($fi), explode(',', TEMPL_FILES))))
	  {
       $filetbl[$cnt]['name'] = $fi;
       $filetbl[$cnt]['size'] = filesize($mydir.$inidir.$fi);
       if(in_array(AFM_fileExt($fi), explode(',', IMAGE_FILES)))
       {
        $filetbl[$cnt]['type'] = 'image';
        $inf = @getimagesize($mydir.$inidir.$fi);
        if($inf[0] < 1 || $inf[1] < 1) $filetbl[$cnt]['type'] = 'file';
       }
       elseif(in_array(AFM_fileExt($fi), explode(',', MEDIA_FILES))) $filetbl[$cnt]['type'] = 'media';
       elseif(in_array(AFM_fileExt($fi), explode(',', TEMPL_FILES))) $filetbl[$cnt]['type'] = 'text';
       else $filetbl[$cnt]['type'] = 'file';
       $cnt++;
	  }
    }
   }
   closedir($dir);
  }
  return $cnt;
 }

 function AFM_fileExt($filename)
 {
  return strtolower(end(explode('.', $filename)));
 }

 function AFM_SafeDirName($s)
 {
  $data = array(
   "\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C",
   "\xc4\x99" => "e", "\xc4\x98" => "E", "\xc5\x82" => "l", "\xc5\x81" => "L",
   "\xc3\xb3" => "o", "\xc3\x93" => "O", "\xc5\x9b" => "s", "\xc5\x9a" => "S",
   "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
   "\xc5\x84" => "n", "\xc5\x83" => "N", ' ' => '_');
  $newname = strtr($s, $data);
  $newname = preg_replace('@[\.]+@', '.', preg_replace('/[^(a-zA-Z0-9_\.\-\!)]+/su', '', $newname));
  return trim($newname, '.-');
 }

 function AFM_SafeFileName($s)
 {
  $data = array(
   "\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C",
   "\xc4\x99" => "e", "\xc4\x98" => "E", "\xc5\x82" => "l", "\xc5\x81" => "L",
   "\xc3\xb3" => "o", "\xc3\x93" => "O", "\xc5\x9b" => "s", "\xc5\x9a" => "S",
   "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
   "\xc5\x84" => "n", "\xc5\x83" => "N", ' ' => '_');
  $newname = strtr($s, $data);
  $newname = preg_replace('/[^(a-zA-Z0-9_,\.\-\!)]+/su', '', $newname);
  return trim($newname, '.,-');
 }

 function AFM_UniDelete($dirname)
 {
  global $mydir;
  global $inidir;
  if(strstr(preg_replace('@[\/]+@', '/', str_replace(DIRECTORY_SEPARATOR , '/', $dirname)), '../..'))
   die('AFM_UniDelete: Security risk - given path is '.$dirname);
  if(is_file($dirname)) return @unlink($dirname);
  if(!is_dir($dirname)) return false;
  $dir = dir($dirname);
  while(false !== $entry=$dir->read())
  {
   if($entry == '.' || $entry == '..') continue;
   if(is_dir("$dirname/$entry")) AFM_UniDelete("$dirname/$entry");
    elseif(is_file("$dirname/$entry")) @unlink("$dirname/$entry");
  }
  $dir->close();
  return @rmdir($dirname);
 }

 function AFM_CreateThumb($filename, $mwidth = THUMB_W, $mheight = THUMB_H, $cut = THUMB_PAD)
 {
  $image = @pathinfo($filename);
  $thumbnail = $image['dirname'].'/'.$image['filename'].'_thumb.'.$image['extension'];
  $ImMIME[0] = 'image/x-png';
  $ImMIME[1] = 'image/pjpeg';
  $ImMIME[2] = 'image/gif';
  $Picture = 'image/pjpeg';
  if(strtolower($image['extension']) == 'png') $Picture = 'image/x-png';
  if(strtolower($image['extension']) == 'gif') $Picture = 'image/gif';
  $ImAttr = @getimagesize($filename);
  $Width = $ImAttr[0];
  $Height = $ImAttr[1];
  switch($Picture)
  {
   case $ImMIME[0] : { $im = @imagecreatefrompng($filename); imagealphablending($im, true); break; }
   case $ImMIME[1] : $im = @imagecreatefromjpeg($filename); break;
   case $ImMIME[2] : $im = @imagecreatefromgif($filename); break;
  }
  if($im)
  {
   if(!$cut)
   {
    if($Width > $mwidth) $ProcentS = $mwidth / $Width; else $ProcentS = 1.0;
    if($Height > $mheight) $ProcentW = $mheight / $Height; else $ProcentW = 1.0;
	$Procent = ($ProcentS < $ProcentW) ? $ProcentS : $ProcentW;
   }
    else
   {
    if($Width != $mwidth) $ProcentS = $mwidth / $Width; else $ProcentS = 1.0;
    if($Height != $mheight) $ProcentW = $mheight / $Height; else $ProcentW = 1.0;
	$Procent = ($ProcentS > $ProcentW) ? $ProcentS : $ProcentW;
   }
   if($Procent)
   {
    $Width *= $Procent;
    $Height *= $Procent;
   }
   $Width = (int)ceil($Width);
   $Height = (int)ceil($Height);
   if($cut) $mini = imagecreatetruecolor($mwidth, $mheight); else $mini = imagecreatetruecolor($Width, $Height);
   $offsetX = 0;
   $offsetY = 0;
   if($cut)
   {
    if($Width > $mwidth) $offsetX = round((($Width - $mwidth) / 2) * ($ImAttr[0] / $Width));
    if($Height > $mheight) $offsetY = round((($Height - $mheight) / 2) * ($ImAttr[1] / $Height));
   }
   imagecopyresampled($mini, $im, 0, 0, $offsetX, $offsetY, $Width, $Height, $ImAttr[0], $ImAttr[1]);
  } else return false;
  switch($Picture)
  {
   case $ImMIME[0] : { imagesavealpha($im, true); imagepng($mini, $thumbnail, 0); break; }
   case $ImMIME[1] : imagejpeg($mini, $thumbnail, 95); break;
   case $ImMIME[2] : imagegif($mini, $thumbnail); break;
  }
  @chmod($thumbnail, 0666);
  return $thumbnail;
 }

 function printmod_mkdir()
 {
  global $LANG;
  global $inidir;
  echo'
	<div id="mod_mkdir" class="printmod">
		<p style="margin-top:0; padding:25px 30px 5px 0;"><strong>'.$LANG['%NewDirInfo%'].' '.htmlspecialchars($inidir).'</strong></p>
		<p><label>'.$LANG['%NewDirName%'].':<br><input type="text" id="ndirnameid" name="xdirname" maxlength="32" size="32"></label></p>
		<p><label><input type="checkbox" name="ndirpubl" value="yes" checked> '.$LANG['%NewDirChmod%'].'</label></p>
		<p style="text-align:center; padding-top:6px">
			<input type="submit" style="font-weight:bold; margin-right:20px;" name="action-mkdir" value="'.$LANG['%Create%'].'">
			<button type="button" onclick="closeModPanels();">'.$LANG['%Cancel%'].'</button>
		</p>
	</div>
  ';
 }

 function printmod_upload()
 {
  global $LANG;
  $dx = 100;
  $dy = 100;
  $dp = false;
  if(AIRCMS)
  {
   @include_once '../../../../../config.php';
   $dx = NTHUMB_W;
   $dy = NTHUMB_H;
   $dp = NTHUMB_PAD;
  }
  echo'
	<div id="mod_upload" class="printmod">
		<div class="upfile">
			<label>'.$LANG['%FilesToUpload%'].':
			<br><input type="file" name="file1"></label>
			<br><input type="file" name="file2">
			<br><input type="file" name="file3">
			<br><input type="file" name="file4">
		</div>
		<label class="hrlab"><input type="checkbox" name="crthb" value="1"> '.$LANG['%CreateThumb%'].'</label>
		<label>'.$LANG['%Width%'].': <input type="text" name="thx" size="4" maxlength="4" value="'.$dx.'"></label>
		<label style="padding-left:7px;">'.$LANG['%Height%'].': <input type="text" name="thy" size="4" maxlength="4" value="'.$dy.'"></label>
		<label style="padding-left:7px;"><input type="checkbox" name="cutthb" value="1"'; if($dp) echo ' checked'; echo'> '.$LANG['%CutThb%'].'</label>
		<p class="upctrl">
			<input type="submit" style="font-weight:bold; margin-right:20px;" name="action-upload" value="'.$LANG['%Upload%'].'">
			<button type="button" onclick="closeModPanels();">'.$LANG['%Cancel%'].'</button>
		</p>
	</div>
  ';
 }

 function printmod_about()
 {
  global $LANG;
  echo'
	<div id="mod_about" class="printmod">
		<p style="text-align:center; margin-top:0; padding-top:10px;"><strong>A&amp;R FileManager</strong></p>
		<p style="text-align:center;">'.$LANG['%Version%'].' 0.9.3ß (2010-06-17)</p>
		<p style="margin:15px auto; width:80%; line-height:150%; font-size:11px;">'.$LANG['%CopyrightNotice%'].'</p>
		<p style="margin:15px auto; width:80%; text-align:center; font-size:10px;"><a rel="license" target="_blank" href="http://creativecommons.org/licenses/by/3.0/pl/"><img alt="Creative Commons License" style="border-width:0" src="http://creativecommons.org/images/public/somerights20.png" /></a><br /><span xmlns:dc="http://purl.org/dc/elements/1.1/" property="dc:title">A&amp;R FileManager</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.airmedia.pl/" target="_blank" property="cc:attributionName" rel="cc:attributionURL">A&amp;R Multimedia</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/3.0/pl/" target="_blank">Creative Commons Uznanie autorstwa 3.0 Polska License</a>.</p>
		<p style="margin:15px auto; width:80%; line-height:150%; font-size:11px;">Russian translation: Bogdan Savluk</p>
		<p style="text-align:center;"><button type="button" onclick="closeModPanels();">'.$LANG['%ClosePanel%'].'</button></p>
	</div>
  ';
 }
?>