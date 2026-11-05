<?php
 error_reporting(0);

 if(!isset($_GET['file']) || strlen(trim($_GET['file'])) < 1) die(-1);
 $filename = urldecode($_GET['file']);
 if(!file_exists($filename) || !is_file($filename)) die(-2);
 if(ini_get('zlib.output_compression')) ini_set('zlib.output_compression', 'Off');

 $file_extension = strtolower(end(explode('.', $filename)));
 $MIMEtable = array(
  'afl'		=> 'video/animaflex',
  'ai'		=> 'application/postscript',
  'aif'		=> 'audio/aiff',
  'aifc'	=> 'audio/x-aiff',
  'ani'		=> 'application/x-navi-animation',
  'arj'		=> 'application/arj',
  'asf'		=> 'video/x-ms-asf',
  'asm'		=> 'text/x-asm',
  'asx'		=> 'application/x-mplayer2',
  'avi'		=> 'video/avi',
  'bm'		=> 'image/bmp',
  'bmp'		=> 'image/bmp',
  'boo'		=> 'application/book',
  'book'	=> 'application/book',
  'bz'		=> 'application/x-bzip',
  'bz2'		=> 'application/x-bzip2',
  'cat'		=> 'application/vnd.ms-pki.seccat',
  'com'		=> 'application/octet-stream',
  'css'		=> 'text/css',
  'doc'		=> 'application/msword',
  'dot'		=> 'application/msword',
  'dv'		=> 'video/x-dv',
  'dwg'		=> 'application/acad',
  'eps'		=> 'application/postscript',
  'exe'		=> 'application/octet-stream',
  'fla'		=> 'application/fla',
  'flv'		=> 'video/x-flv',
  'gif'		=> 'image/gif',
  'gsm'		=> 'audio/x-gsm',
  'gz'		=> 'application/x-gzip',
  'gzip'	=> 'application/x-gzip',
  'help'	=> 'application/x-helpfile',
  'hlp'		=> 'application/hlp',
  'hta'		=> 'application/hta',
  'htc'		=> 'text/x-component',
  'htm'		=> 'text/html',
  'html'	=> 'text/html',
  'htmls'	=> 'text/html',
  'htt'		=> 'text/webviewhtml',
  'ico'		=> 'image/x-icon',
  'imap'	=> 'application/x-httpd-imap',
  'jav'		=> 'text/x-java-source',
  'java'	=> 'text/x-java-source',
  'jcm'		=> 'application/x-java-commerce',
  'jfif'	=> 'image/pjpeg',
  'jpe'		=> 'image/pjpeg',
  'jpeg'	=> 'image/jpeg',
  'jpg'		=> 'image/jpeg',
  'jps'		=> 'image/x-jps',
  'js'		=> 'application/x-javascript',
  'ksh'		=> 'text/x-script.ksh',
  'log'		=> 'text/plain',
  'm1v'		=> 'video/mpeg',
  'm2a'		=> 'audio/mpeg',
  'm2v'		=> 'video/mpeg',
  'm3u'		=> 'audio/x-mpequrl',
  'mht'		=> 'message/rfc822',
  'mhtml'	=> 'message/rfc822',
  'mid'		=> 'audio/midi',
  'midi'	=> 'audio/midi',
  'mime'	=> 'message/rfc822',
  'mme'		=> 'application/base64',
  'mod'		=> 'audio/mod',
  'mov'		=> 'video/quicktime',
  'mp2'		=> 'audio/mpeg',
  'mp3'		=> 'audio/mpeg3',
  'mpa'		=> 'video/mpeg',
  'mpe'		=> 'video/mpeg',
  'mpeg'	=> 'video/mpeg',
  'mpg'		=> 'video/mpeg',
  'mpga'	=> 'audio/mpeg',
  'pas'		=> 'text/pascal',
  'pcx'		=> 'image/x-pcx',
  'pdf'		=> 'application/pdf',
  'pic'		=> 'image/pict',
  'pict'	=> 'image/pict',
  'png'     => 'image/png',
  'ppt'		=> 'application/vnd.ms-powerpoint',
  'pps'		=> 'application/mspowerpoint',
  'ppz'		=> 'application/mspowerpoint',
  'ps'		=> 'application/postscript',
  'psd'		=> 'application/octet-stream',
  'qt'		=> 'video/quicktime',
  'ra'		=> 'audio/x-realaudio',
  'ram'		=> 'audio/x-pn-realaudio',
  'rf'		=> 'image/vnd.rn-realflash',
  'rm'		=> 'audio/x-realaudio',
  'rpm'		=> 'audio/x-pn-realaudio-plugin',
  'rt'		=> 'text/richtext',
  'rtf'		=> 'application/rtf',
  's3m'		=> 'audio/s3m',
  'sh'		=> 'application/x-bsh',
  'shar'	=> 'application/x-bsh',
  'shtml'	=> 'text/html',
  'snd'		=> 'audio/basic',
  'svf'		=> 'image/vnd.dwg',
  'svg'		=> 'image/svg+xml',
  'swf'		=> 'application/x-shockwave-flash',
  'tcl'		=> 'text/x-script.tcl',
  'tex'		=> 'application/x-tex',
  'text'	=> 'text/plain',
  'tgz'		=> 'application/x-compressed',
  'tif'		=> 'image/tiff',
  'tiff'	=> 'image/tiff',
  'txt'		=> 'text/plain',
  'uu'		=> 'text/x-uuencode',
  'wav'		=> 'audio/wav',
  'wbmp'	=> 'image/vnd.wap.wbmp',
  'wmf'		=> 'windows/metafile',
  'wml'		=> 'text/vnd.wap.wml',
  'word'	=> 'application/msword',
  'wp'		=> 'application/wordperfect',
  'wp5'		=> 'application/wordperfect',
  'wp6'		=> 'application/wordperfect6.0',
  'wri'		=> 'application/mswrite',
  'wrl'		=> 'model/vrml',
  'xl'		=> 'application/excel',
  'xla'		=> 'application/x-msexcel',
  'xlb'		=> 'application/x-msexcel',
  'xls'		=> 'application/vnd.ms-excel',
  'xlm'		=> 'application/vnd.ms-excel',
  'xlt'		=> 'application/vnd.ms-excel',
  'xm'		=> 'audio/xm',
  'xml'		=> 'application/xml',
  'z'		=> 'application/x-compressed',
  'zip'		=> 'application/zip',
  'zsh'		=> 'text/x-script.zsh'
 );
 $mime = 'application/force-download';
 if(array_key_exists($file_extension, MIMEtable)) $mime = $MIMEtable[$file_extension];

 # Security - allow to download only the files that are in the a&r filemanager FILES_PATH directory
 require_once 'config.php';
 $afm_path = preg_replace('@[\/]+@', '/', str_replace(DIRECTORY_SEPARATOR, '/', realpath(FILES_PATH)));
 $fnm_path = preg_replace('@[\/]+@', '/', str_replace(DIRECTORY_SEPARATOR , '/', $filename));
 if(!strstr($fnm_path, $afm_path)) die(-3);
 if(strstr($fnm_path, '../..')) die(-4);

 header("Pragma: public");
 header("Expires: 0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
 header("Cache-Control: private", false);
 header("Content-Type: ".$mime);
 header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
 header("Content-Transfer-Encoding: binary");
 header("Content-Length: ".filesize($fnm_path));
 readfile($fnm_path);
 exit();
?>