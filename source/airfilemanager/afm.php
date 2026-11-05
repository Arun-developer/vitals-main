<?php
 # file encoding: UTF-8
 # © 2010 airmedia.pl

 error_reporting(1);
 ini_set('error_reporting', E_ALL);
 ini_set('display_errors', 'On');
 ini_set('arg_separator.output', '&amp;');
 setlocale(LC_ALL, 'en_US.UTF-8');
 mb_internal_encoding('UTF-8');
 header('Content-Type: text/html; charset=UTF-8');

 # path & location
 $GLOBALS['AFMPATH'] = preg_replace('@\/afm.php(.*)$@i', '', str_replace('\\', '/', __FILE__));
 $GLOBALS['AFMPATH'] = str_replace(DIRECTORY_SEPARATOR, '/', realpath(rtrim($GLOBALS['AFMPATH'], " \t\\\n\r/"))).'/';
 $dn = rtrim(dirname($_SERVER['PHP_SELF']), " \t\\\n\r/");
 if($dn{mb_strlen($dn)-1} != '/') $dn.= '/';
 $GLOBALS['siteurl'] = $_SERVER['HTTP_HOST'].$dn;
 $GLOBALS['siteuri'] = (stristr($_SERVER['REQUEST_URI'], 'www.') ? 'www.' : '').$GLOBALS['siteurl'];
 if(!isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on') $_SERVER['HTTPS'] = 'off';
 $GLOBALS['siteroot'] = 'http'.($_SERVER['HTTPS']=='on' ? 's' : '').'://'.$GLOBALS['siteuri'];

 # required files
 require_once $GLOBALS['AFMPATH'].'config.php';
 require_once $GLOBALS['AFMPATH'].'afmlib.php';

 # A&R::CMS login check 
 if(AIRCMS)
 {
  ini_set('session.use_trans_sid', 0);
  ini_set('session.cookie_lifetime', 0);
  ini_set('session.gc_maxlifetime', 3600);
  ini_set('session.gc_divisor', 1);
  ini_set('session.gc_probability', 1);
  session_name('sesid');
  session_start();
  if(!isset($_SESSION['admlogged']) || $_SESSION['admlogged'] != true) die('Not logged in!');
 }

 # include language file
 $lf = $GLOBALS['AFMPATH'].'langs/'.strtolower(LANG).'.php';
 if(file_exists($lf) && is_file($lf)) include_once $lf; else die("Language file cannot be found: \n'$lf'");
 unset($lf);

 # variables
 $navig = '?';
 if(!isset($_GET['type']) || ($_GET['type'] != 'image' && $_GET['type'] != 'media' && $_GET['type'] != 'flash')) $_GET['type'] = 'file';
 $navig.= 'type='.$_GET['type'];
 if(!isset($_GET['mode']))
 {
  if($_GET['type'] == 'image') $_GET['mode'] = 'thumb';
   else $_GET['mode'] = 'list';
 }
 if($_GET['mode'] != 'list' && $_GET['mode'] != 'thumb') $_GET['mode'] = 'list';
 $navig.= '&mode='.$_GET['mode'];
 if(!isset($_GET['vall']) && VIEW_ALL) $_GET['vall'] = '1';
 if(isset($_GET['vall']) && $_GET['vall'] == '1') $_GET['vall'] = '1'; else $_GET['vall'] = '0';
 $navig.= '&vall='.$_GET['vall'];

 $mydir = str_replace(DIRECTORY_SEPARATOR, '/', realpath(FILES_PATH));
 if(mb_strlen($mydir) < 5) die('Sorry! There was likely a security problem and the script can not continue. Check path in configuration file.');
 $dirtbl = array();
 $filetbl = array();
 $inidir = '/';
 $navig_nodir = $navig;
 if(isset($_GET['fmcdir']) && mb_strlen($_GET['fmcdir']) > 0) $inidir = urldecode(preg_replace('@[\/]+@', '/', $_GET['fmcdir'])); else $_GET['fmcdir'] = urlencode($inidir);
 $navig.= '&fmcdir='.$_GET['fmcdir'];

 ##########################################################################################################

 # change directory
 if(isset($_GET['dir']) && mb_strlen($_GET['dir']) > 0 && !stristr($_GET['dir'], '..'))
 {
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.$navig_nodir.'&fmcdir='.$_GET['dir'].'/');
  die();
 }

 # dirup
 if(isset($_GET['updir']) && isset($_GET['fmcdir']) && mb_strlen($_GET['fmcdir']) > 1)
 {
  $tmp = explode('/', rtrim($_GET['fmcdir'], '/'));
  array_pop($tmp);
  $_GET['fmcdir'] = implode('/', $tmp).'/';
  unset($tmp);
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.$navig_nodir.'&fmcdir='.$_GET['fmcdir']);
  die();
 }

 # change view mode to thumbnails
 if(isset($_POST['view_as_icon']) || isset($_POST['view_as_icon_x']))
 {
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.str_replace('mode=list', 'mode=thumb', $navig));
  die();
 }

 # change view mode to list
 if(isset($_POST['view_as_list']) || isset($_POST['view_as_list_x']))
 {
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.str_replace('mode=thumb', 'mode=list', $navig));
  die();
 }

 # view all files
 if(isset($_POST['view_all']) || isset($_POST['view_all_x']))
 {
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  if(strstr($navig, 'vall='))
  {
   if(strstr($navig, 'vall=1')) $navig = str_replace('vall=1', 'vall=0', $navig);
    else $navig = str_replace('vall=0', 'vall=1', $navig);
  } else $navig.= '&vall=1';
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.$navig);
  die();
 }

 # create a new directory
 if(isset($_POST['action-mkdir']) && isset($_POST['xdirname']) && mb_strlen($_POST['xdirname']) > 0)
 {
  $ret = AFMRC_MKDIRERR;
  $dn = AFM_SafeDirName(mb_substr($_POST['xdirname'], 0, 32));
  if(strlen($dn) >= 1)
  {
   if(@mkdir($mydir.$inidir.$dn)) $ret = AFMRC_MKDIROK;
   if($ret == AFMRC_MKDIROK && isset($_POST['ndirpubl']) && $_POST['ndirpubl'] == 'yes') @chmod($mydir.$inidir.$dn, 0777);
  }
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.$navig.'&afmrc='.$ret);
  die();
 }

 # delete files and/or directiories
 if(isset($_POST['action-delete']) && isset($_POST['zaz']) && is_array($_POST['zaz']))
 {
  $ret = AFMRC_DELETEOK;
  $results = array();
  ignore_user_abort(true);
  foreach($_POST['zaz'] as $folder) $results[] = AFM_UniDelete($mydir.$inidir.$folder);
  ignore_user_abort(false);
  foreach($results as $result) if(!$result) $ret = AFMRC_DELETEERR;
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.$navig.'&afmrc='.$ret);
  die();
 }

 # upload files
 if(isset($_POST['action-upload']) && (is_uploaded_file($_FILES['file1']['tmp_name']) || is_uploaded_file($_FILES['file2']['tmp_name'])
  || is_uploaded_file($_FILES['file3']['tmp_name']) || is_uploaded_file($_FILES['file4']['tmp_name'])))
 {
  $ret = AFMRC_UPLOADOK;
  ignore_user_abort(true);
  for($i=1; $i<=4; $i++)
   if(isset($_FILES['file'.$i]) && is_uploaded_file($_FILES['file'.$i]['tmp_name']))
   {
	if(!in_array(AFM_fileExt(basename($_FILES['file'.$i]['name'])), explode(',', EXCLUDE_FILES)))
	{
     $tmp = $fot = AFM_SafeFileName(basename($_FILES['file'.$i]['name']));
     $trynr = 0;
     while(file_exists($mydir.$inidir.$fot) && $trynr < 2000)
     {
      $trynr++;
      $fot = rand(0, 1999).'_'.$tmp;
     }
     if($trynr >= 1999) $fot = time().'_'.$tmp;
     move_uploaded_file($_FILES['file'.$i]['tmp_name'], $mydir.$inidir.$fot);
     @chmod($mydir.$inidir.$fot, 0666);
	 if(isset($_POST['crthb']) && $_POST['crthb'] == '1' && is_numeric($_POST['thx']) && is_numeric($_POST['thy']) && $_POST['thx'] > 0 && $_POST['thy'] > 0)
     {
      $nw = (int)$_POST['thx'];
	  $nh = (int)$_POST['thy'];
	  if(isset($_POST['cutthb']) && $_POST['cutthb'] == '1') $nc = true; else $nc = false;
	  if(!AFM_CreateThumb($mydir.$inidir.$fot, $nw, $nh, $nc)) $ret = AFMRC_UPERR_THMB;
     }
    }
	else $ret = AFMRC_UPERR_TYPE;
   }
  ignore_user_abort(false);
  if(AIRCMS) session_write_close();
  header($_SERVER['SERVER_PROTOCOL'].' 303 See Other', true, 303);
  header('Location: '.$GLOBALS['siteroot'].'afm.php'.$navig.'&afmrc='.$ret);
  die();
 }

 ##########################################################################################################

 AFM_readFolder();

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="<?php echo strtolower(LANG); ?>">
<head>
	<title>A&amp;R FileManager</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="<?php echo strtolower(LANG); ?>">
	<meta name="robots" content="noindex, nofollow">
	<meta name="author" content="www.airmedia.pl">
	<script type="text/javascript" src="js/mceapi.js"></script>
	<script type="text/javascript" src="js/afm.js"></script>
	<style type="text/css" media="all">
		@import "css/manager.css";
	</style>
</head>

<body>
 <form id="afmf" action="<?php echo htmlspecialchars($GLOBALS['siteroot'].'afm.php'.$navig); ?>" method="post" enctype="multipart/form-data">

	<div id="mainmenu">
		<input type="image" name="view_as_icon" src="images/view_icon_<?php if($_GET['mode']=='thumb') echo '1'; else echo '0'; ?>.gif" class="onoffview" title="<?php echo $LANG['%ViewAsIcons%']; ?>" alt="">
		<input type="image" name="view_as_list" src="images/view_list_<?php if($_GET['mode']!='thumb') echo '1'; else echo '0'; ?>.gif" class="onoffview" title="<?php echo $LANG['%ViewAsList%']; ?>" alt="">
		<input type="image" name="view_all" src="images/view_all_<?php if(isset($_GET['vall']) && $_GET['vall']=='1') echo '1'; else echo '0'; ?>.gif" class="onoffview" title="<?php echo $LANG['%ViewAllFiles%']; ?>" alt="">
		<ul>
			<li class="ico_upload"><a href="#" onclick="openModPanel('mod_upload'); return!1;"><?php echo $LANG['%Upload%']; ?></a></li>
			<li class="ico_mkdir"><a href="#" onclick="openModPanel('mod_mkdir'); return!1;"><?php echo $LANG['%MakeDir%']; ?></a></li>
			<li class="ico_delete"><a href="#" onclick="doDelete('<?php echo htmlspecialchars($LANG['%NoSelectedFiles%']); ?>'); return!1;"><?php echo $LANG['%Delete%']; ?></a></li>
			<li class="ico_refresh"><a href="#" onclick="$('afmf').submit(); return!1;"><?php echo $LANG['%Refresh%']; ?></a></li>
			<li class="ico_info"><a href="#" onclick="openModPanel('mod_about'); return!1;"><?php echo $LANG['%About%']; ?></a></li>
		</ul>
	</div>

	<div id="breadcrumbs"><?php
 $tph = $tmpp = explode('/', $inidir);
 $cur = 0;
 $tph[$cur] = $LANG['%MyFiles%'];
 foreach($tph as $folder)
  if(mb_strlen(trim($folder)) > 0)
  {
   $cur++;
   $newdir = '';
   for($i=0; $i<$cur; $i++) $newdir.= $tmpp[$i].'/';
   echo '<a href="afm.php'.$navig.'&dir='.htmlspecialchars(urlencode($newdir)).'">'.htmlspecialchars($folder).'</a>&nbsp;/&nbsp;';
  }
?></div>

<?php
 if(isset($_GET['afmrc']) && is_numeric($_GET['afmrc']) && $_GET['afmrc'] >= 1)
 {
  echo "\t\t".'<div id="messagebar">'.$LANG['%Err'.intval($_GET['afmrc']).'%'];
  echo '<a class="cx" href="#" onclick="$(\'messagebar\').style.display=\'none\'; return!1;">X</a></div>';
 }
?>
	<div id="leftpanel">
		<div id="filelist"<?php if($_GET['mode'] == 'thumb') echo ' style="overflow-y:scroll;"'; ?>>
<?php
 $cnt = 0;
 $total_size = 0;
 asort($dirtbl, SORT_LOCALE_STRING);

 if($_GET['mode'] != 'thumb')
 {
  # show directories
  foreach($dirtbl as $item)
  {
   if($item == '..' && mb_strlen($inidir) > 1)
   {
    $cnt++;
    echo "\t\t".'<input type="checkbox" name="dummy" value="none" disabled><a href="'.htmlspecialchars($navig).'&amp;updir=yes" class="updir">[ '.htmlspecialchars($item).' ]</a>'."\n";
   }
   if($item != '..')
   {
    $cnt++;
    echo "\t\t".'<input type="checkbox" name="zaz[]" value="'.htmlspecialchars(urlencode($item)).'"><a href="'.htmlspecialchars($navig).'&amp;dir='.htmlspecialchars(urlencode($inidir.$item)).'" class="dir">[ '.htmlspecialchars($item).' ]</a>'."\n";
   }
  }
  # show files
  foreach($filetbl as $item)
  {
   $cnt++;
   $name = htmlspecialchars($item['name']);
   $preview = 'false';
   if($item['type'] == 'image' || $item['type'] == 'text') $preview = 'true';
   $total_size += $item['size'];
   $fsize = $item['size'].' B';
   if($item['size'] > 1023) $fsize = number_format($item['size'] / 1024, 1, '.', ' ').' KiB';
   if($item['size'] > 1048575) $fsize = number_format($item['size'] / 1048576, 1, '.', ' ').' MiB';
   $icon = 'unknown.gif';
   if(stristr($item['name'], '.doc') || stristr($item['name'], '.rtf') || stristr($item['name'], '.sxw') || stristr($item['name'], '.txt')) $icon = 'doc.gif';
    elseif(stristr($item['name'], '.gif') || stristr($item['name'], '.jpg') || stristr($item['name'], '.png') || stristr($item['name'], '.jpeg') || stristr($item['name'], '.jpe') || stristr($item['name'], '.svg')) $icon = 'image.gif';
    elseif(stristr($item['name'], '.pdf')) $icon = 'pdf.gif';
    elseif(stristr($item['name'], '.swf')) $icon = 'swf.gif';
   echo "\t\t".'<input type="checkbox" name="zaz[]" value="'.htmlspecialchars(urlencode($name)).'"><a href="#" onclick="sel(\''.htmlspecialchars(urlencode($name)).'\','.$preview.',false); return!1;" style="background-image:url(images/'.$icon.');"><span>'.htmlspecialchars($name).'</span> '.$fsize.'</a>'."\n";
  }
 }
  else
 {
  # show directories
  foreach($dirtbl as $item)
  {
   if($item == '..' && mb_strlen($inidir) > 1)
   {
    $cnt++;
    echo "\t\t".'<div class="thbfile"><a href="'.htmlspecialchars($navig).'&amp;updir=yes"><img src="images/th_cdup.gif" alt="cdup"></a><label>'.htmlspecialchars($item).'</label></div>'."\n";
   }
   if($item != '..')
   {
    $cnt++;
    echo "\t\t".'<div class="thbfile"><a href="'.htmlspecialchars($navig).'&amp;dir='.htmlspecialchars(urlencode($inidir.$item)).'"><img src="images/th_directory.gif" alt="dir"></a><label><input type="checkbox" name="zaz[]" value="'.htmlspecialchars(urlencode($item)).'"> '.htmlspecialchars($item).'</label></div>'."\n";
   }
  }
  # show files
  foreach($filetbl as $item)
  {
   $cnt++;
   $name = htmlspecialchars($item['name']);
   $preview = 'false';
   if($item['type'] == 'image' || $item['type'] == 'text') $preview = 'true';
   $total_size += $item['size'];
   $fsize = $item['size'].' B';
   if($item['size'] > 1023) $fsize = number_format($item['size'] / 1024, 1, '.', ' ').' KiB';
   if($item['size'] > 1048575) $fsize = number_format($item['size'] / 1048576, 1, '.', ' ').' MiB';
   $icon = 'unknown.gif';
   if(stristr($item['name'], '.doc') || stristr($item['name'], '.rtf') || stristr($item['name'], '.sxw') || stristr($item['name'], '.txt')) $icon = 'doc.gif';
    elseif(stristr($item['name'], '.gif') || stristr($item['name'], '.jpg') || stristr($item['name'], '.png') || stristr($item['name'], '.jpeg') || stristr($item['name'], '.jpe') || stristr($item['name'], '.bmp') || stristr($item['name'], '.bm')) $icon = false;
    elseif(stristr($item['name'], '.pdf')) $icon = 'pdf.gif';
    elseif(stristr($item['name'], '.swf')) $icon = 'swf.gif';
   echo "\t\t".'<div class="thbfile"><a href="#" onclick="sel(\''.htmlspecialchars(urlencode($name)).'\','.$preview.',false); return!1;" title="'.htmlspecialchars($name).'">';
   if($icon !== false) echo '<img src="images/th_'.$icon.'" alt="?">';
    else echo '<img src="afmimg.php?f='.htmlspecialchars(urlencode($inidir.$name)).'" alt="loading…">';
   echo '</a><label><input type="checkbox" name="zaz[]" value="'.htmlspecialchars(urlencode($name)).'"> '.htmlspecialchars(mb_substr($name,0,20)).'</label></div>'."\n";
  }
 }
?>
		</div>
	</div>

	<div id="rightpanel">
		<iframe id="prev" frameborder="0" marginheight="0" marginwidth="0" allowtransparency="true" scrolling="auto" width="100%" height="268" src="<?php echo $GLOBALS['siteroot']; ?>langs/noprev_<?php echo strtolower(LANG); ?>.php"></iframe>
		<?php printmod_mkdir(); ?>
		<?php printmod_upload(); ?>
		<?php printmod_about(); ?>
	</div>

	<div id="infopanel">
		<div class="leftside">
			<p id="funct">
				<a href="#" onclick="selectBoxes(3, 'zaz'); return!1;"><?php echo $LANG['%SelectAll%']; ?></a>
				<a href="#" onclick="selectBoxes(1, 'zaz'); return!1;"><?php echo $LANG['%DeSeleAll%']; ?></a>
				<a href="#" onclick="selectBoxes(2, 'zaz'); return!1;"><?php echo $LANG['%RevSelect%']; ?></a>
			</p>
			<p><?php echo $LANG['%CurrentFile%']; ?>: <strong id="cfle"><?php echo $LANG['%none%']; ?></strong></p> 
			<p><?php echo $LANG['%DirSize%']; ?>: <strong><?php 
					$fsize = $total_size.' B';
					if($total_size > 1023) $fsize = number_format($total_size / 1024, 1, '.', ' ').' KiB';
					if($total_size > 1048575) $fsize = number_format($total_size / 1048576, 1, '.', ' ').' MiB';
					echo $fsize;
				?></strong></p>

			<input type="hidden" name="nurlname" id="vurl" value="<?php echo htmlspecialchars(FILES_URI.$inidir); ?>">
			<input type="hidden" name="currfile" id="vfle" value="">
			<input type="hidden" name="ndirname" id="vdir" value="">
			<input type="hidden" id="js_msg_delete" value="<?php echo htmlspecialchars($LANG['%ConfirmDelete%']); ?>">
		</div>
		<div class="rightside">
			<button type="button" id="selbutton" onclick="selectFile($('vurl').value + $('vfle').value);" disabled><strong><?php echo $LANG['%Select%']; ?></strong></button>
			<button type="button" id="ddlbutton" onclick="downloadFile('<?php echo htmlspecialchars($mydir.$inidir, ENT_QUOTES); ?>'+$('vfle').value);" disabled><?php echo $LANG['%Download%']; ?></button>
			<button type="button" onclick="cancelSelectFile();"><?php echo $LANG['%Cancel%']; ?></button>
		</div>
	</div>
 </form>
<script type="text/javascript">
<!--
function sel(fname, preview, editable)
{
 $('cfle').innerHTML = decodeURIComponent('<?php echo urlencode($inidir); ?>'+fname);
 $('vfle').value = fname;
 if($('vfle').value.length > 0)
 {
  $('selbutton').disabled=false;
  $('ddlbutton').disabled=false;
 }
 if(preview)
  $('prev').src = '<?php echo htmlspecialchars(FILES_URI); ?>'+decodeURIComponent('<?php echo urlencode($inidir); ?>'+fname);
   else $('prev').src = '<?php echo $GLOBALS['siteroot']; ?>langs/noprev_<?php echo strtolower(LANG); ?>.php';
 return !1;
}

function downloadFile(filename)
{
 document.location.href = '<?php echo $GLOBALS['siteroot']; ?>download.php?file='+filename;
 return !1;
}
//-->
</script>
</body>
</html>