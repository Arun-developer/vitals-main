<?php
 # file encoding: UTF-8
 # © 2010 airmedia.pl
#assets/docs/mediaplayer/player.swf?file=files/
 # basic configuration
 define('LANG', 'en');  // available languages: en,pl,ru
 define('FILES_PATH', 'uploads/');  // relative to afm.php and config.php (dont` forget the slash at the end of the path!)
 define('VIEW_ALL', true);  // always view all files (irrespective of tiny_mce mode, eg. in media plugin show text and image files as well as media files)
 define('USE_CACHE', false);  // create & manage cache files when creating thumbnails
 # you usually dont`t need to change anything below
 define('AIRCMS', false);
 define('MWIDTH', 90);
 define('MHEIGHT', 64);
 define('CACHEDIR', '_afm.cache/');
 define('DATE_TIME_FORMAT', 'd.m.Y H:i:s');
 define('IMAGE_FILES', 'gif,png,jpg,jpe,jpeg,jfif,svg');
 define('MEDIA_FILES', 'swf,flv,wav,mp3,mp2,mpeg,mpe,mpg,mp4,divx,ogg,wmv,asf,aif,avi,mov,qt,acc,xm,wma,rm,rmvb,s3m,mod');
 define('TEMPL_FILES', 'txt,htm,html,xhtml,hta,htc');
 define('OTHER_FILES', 'otf,ttf,xls,doc,odt,pps,ppt,dot,rtf,odf,pdf,xml,sxw,zip,rar,tar,gz,7z,cat');

 # files below will not be listed in filemanager, nor can be upload by filemanager
 define('EXCLUDE_FILES', 'phtml,php,php3,php4,php5,php6,asp,aspx,py,pyc,jse,js,as,sh,ksh,zsh,bat,cmd,shs,vb,vbe,vbs,wsc,wsf,wsh,url,exe,msi,msp,reg,scr,ocx');

 # define('FILES_URI', '/res/editor'); // absolute URI where files are located (no ending slash!)
 # ↑ This ↑ might probably be done automatically
 # but if automatic fail you know what to do...
 $iurl = rtrim(dirname($_SERVER['PHP_SELF']), " \t\\\n\r/");
 if($iurl{mb_strlen($iurl)-1} != '/') $iurl.= '/';
 $cud = substr_count(FILES_PATH, '../');
 if($cud > 0)
 {
  $tmp = explode('/', $iurl);
  for($i=0;$i<=$cud;$i++) array_pop($tmp);
  $iurl = implode('/', $tmp).'/'.str_replace('../', '', FILES_PATH);
  unset($tmp);
 }
 else $iurl.= FILES_PATH;
 unset($cud);
 if($iurl{mb_strlen($iurl)-1} == '/') $iurl = mb_substr($iurl, 0, -1);
 $calc_uri = (stristr($_SERVER['REQUEST_URI'], 'www.') ? 'www.' : '').$_SERVER['HTTP_HOST'].$iurl;
 unset($iurl);
 if(!isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on') $_SERVER['HTTPS'] = 'off';
 $calc_uri = 'http'.($_SERVER['HTTPS']=='on' ? 's' : '').'://'.$calc_uri;
 define('FILES_URI', $calc_uri);
?>