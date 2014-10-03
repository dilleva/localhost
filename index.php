<?php 
session_start();
$_SESSION['user']['id'] = '1';
/*if(!($_SESSION['user']['id'])){
	
	echo '<style>body{margin:0;}</style><iframe src="./root/login.php" width="100%" height="100%" style="border:none;margin:0;"></iframe>';
	exit;
}*/
?>

<?php
/*
Server Explorer - Version 4.1
====================================
Contributors:
 Elijah Bee <elijah@dilleva.com> / www.dilleva.com
 Ash Young <ash@evoluted.net> / www.evoluted.net
 Large Icons by Zerode / http://www.zerode.com
 Little Icons by Fague / 

INTRODUCTION
============
This is a dropbox type that creates folders for each user and each user can upload files and view a public file directory through their browser. Authenticated users can upload files to the public folder.

CONFIGURATION
=============
Include URL - If you are including this script in another file, 
please define the URL to the Directory Listing script (relative
from the host)
*/
$includeurl = false;

/*
Start Directory - To list the files contained within the current 
directory enter '.', otherwise enter the path to the directory 
you wish to list. The path must be relative to the current 
directory and cannot be above the location of index.php within the 
directory structure.
*/
if(!($_SESSION['user']['id'])){
	$startdir = 'public';
	}else{
	if(($_SESSION['user']['id']) == 1){
		$startdir = './';
	}else{
		if(isset($_REQUEST['dir']) && substr($_REQUEST['dir'], 0, 6) == 'public'){
			$startdir = './';
		}else{
			if(!is_dir('./users/'.$_SESSION['user']['id'])){
				// For first time users we create their user folder
				$userpath='./users/'.$_SESSION['user']['id'];
				mkdir($userpath,0777,TRUE);
				// Create a readme file
				$filename = $userpath.'\readme.txt';
				$content = " Hi ".$_SESSION['user']['first']."\n Welcome to the DillEva. Network\n \n You can upload your files into your private folder and view files from everyone in the public folder.\n \n We hope you enjoy using this service.\n \n If there's any way you belive we can improve it do let us know by emailing care@dilleva.com\n";
				$handle = fopen($filename,"x+");
				fwrite($handle,$content);
				//echo "Success";
				fclose($handle);
			}
			$startdir = './users/'.$_SESSION['user']['id'];
		}
	}
}

/*
Show Thumbnails? - Set to true if you wish to use the 
scripts auto-thumbnail generation capabilities.
This requires that GD2 is installed.
*/
$showthumbnails = false; 

/*
Memory Limit - The image processor that creates the thumbnails
may require more memory than defined in your PHP.INI file for 
larger images. If a file is too large, the image processor will
fail and not generate thumbs. If you require more memory, 
define the amount (in megabytes) below
*/
$memorylimit = false; // Integer

/*
Show Directories - Do you want to make subdirectories available?
If not set this to false
*/
if(!($_SESSION['user']['id'])){
	$showdirs = true;
	}else{
	$showdirs = true;
}
/* 
Force downloads - Do you want to force people to download the files
rather than viewing them in their browser?
*/
if(($_SESSION['user']['id']) == 1){
	$forcedownloads = false;
}else{
	$forcedownloads = false;
}

/*
Hide Files - If you wish to hide certain files or directories 
then enter their details here. The values entered are matched
against the file/directory names. If any part of the name 
matches what is entered below then it is not shown.
*/
if(!($_SESSION['user']['id'])){
	$hide = array(
				'root',
				'Thumbs',
				'.htpasswd',
				'.DS_Store',
				'_MACOSX',
				'forbidden',
				'restricted',
				'xampp',
				'favicon.ico',
				'apache_pb.gif',
				'apache_pb.png',
				'apache_pb2.gif',
				'apache_pb2.png',
				'apache_pb2_ani.gif',
				'Thumbs.db'
			);
	}else{
	$hide = array(
				'root',
				'Thumbs',
				'.htpasswd',
				'.DS_Store',
				'_MACOSX',
				'forbidden',
				'restricted',
				'xampp',
				'favicon.ico',
				'apache_pb.gif',
				'apache_pb.png',
				'apache_pb2.gif',
				'apache_pb2.png',
				'apache_pb2_ani.gif',
				'index2.php',
				'Thumbs.db'
			);
}

			
/* Only Display Files With Extension... - if you only wish the user
to be able to view files with certain extensions, add those extensions
to the following array. If the array is commented out, all file
types will be displayed.
*/
if(!($_SESSION['user']['id'])){
	$showtypes = array(
					'7z',
					'ai',
					'asc',
					'avi',
					'bmp',
					'cab',
					'doc',
					'docx',
					'eps',
					'exe',
					'fh10',
					'fla',
					'gif',
					'gz',
					'jpeg',
					'jpg',
					'js',
					'm3u',
					'mid',
					'mmm',
					'mov',
					'm4a',
					'mp3',
					'mp4',
					'mpeg',
					'mpg',
					'msi',
					'ogg',
					'pdf',
					'png',
					'ppt',
					'pptx',
					'psd',
					'rar',
					'rm',
					'rtf',
					'setup',
					'sig',
					'swf',
					'tif',
					'txt',
					'wav',
					'wma',
					'xls',
					'xlsx',
					'zip',
				);
	}else{
	/*$showtypes = array(
					'jpg',
					'png',
					'gif',
					'zip',
					'txt'
				);*/
}
			 
/* 
Show index files - if an index file is found in a directory
to you want to display that rather than the listing output 
from this script?
*/
if(!($_SESSION['user']['id'])){
	$displayindex = true;
}else{
	$displayindex = false;
}
/*
Allow uploads? - If enabled users will be able to upload 
files to any viewable directory. You should really only enable
this if the area this script is in is already password protected.
*/
if(!($_SESSION['user']['id'])){
	$allowuploads = false;
}else{
	$allowuploads = true;
}

/* Upload Types - If you are allowing uploads but only want
users to be able to upload file with specific extensions,
you can specify these extensions below. All other file
types will be rejected. Comment out this array to allow
all file types to be uploaded.
*/
if(!($_SESSION['user']['id'])){
	$uploadtypes = $showtypes;
}else{
	/*$uploadtypes = array(
						'zip',
						'gif',
						'doc',
						'png'
					);*/
}

/*
Overwrite files - If a user uploads a file with the same
name as an existing file do you want the existing file
to be overwritten?
*/
$overwrite = true;

/*
Index files - The follow array contains all the index files
that will be used if $displayindex (above) is set to true.
Feel free to add, delete or alter these
*/
$indexfiles = array (
				'index.html',
				'index.htm',
				'index.php',
				'default.htm',
				'default.html'
			);
			
/*
File Icons - If you want to add your own special file icons use 
this section below. Each entry relates to the extension of the 
given file, in the form <extension> => <filename>. 
These files must be located within the dlf directory.
*/
$filetypes = array (
				'7z' => 'archive.png',
				'asc' => 'sig.gif',
				'css' => 'css-icon.png',
				'eps' => 'eps.gif',
				'fh10' => 'fh10.gif',
				'gz' => 'archive.png',
				'htaccess' => 'config.png',
				'js' => 'js-icon.jpg',
				'mov' => 'video2.gif',
				'ogg' => 'music-icon.png',
				'mp4' => 'music-icon.png',
				'pdf' => 'pdf-icon.jpg',
				'php' => 'php-icon.png',
				'rm' => 'real.gif',
				'msi' => 'setup.gif',
				'setup' => 'setup.gif',
				'sig' => 'sig.gif',
				'sql' => 'sql-icon.jpg',
								
				'fla' => 'icons/Adobe-Flash-icon.png',
				'swf' => 'icons/Adobe-Flash-icon.png',
				'ai' => 'icons/Adobe-Illustrator-icon.png',
				'psd' => 'icons/Adobe-Photoshop-icon.png',
				'avi' => 'icons/avi-icon.png',
				'bat' => 'icons/Document-bat-icon.png',
				'ini' => 'icons/Document-config-icon.png',
				'exe' => 'icons/Document-exe-icon.png',
				'htm' => 'icons/Document-html-icon.png',
				'html' => 'icons/Document-html-icon.png',
				'txt' => 'icons/Document-txt-icon.png',
				'rtf' => 'icons/Document-write-icon.png',
				'bmp' => 'icons/Filetype-bmp-icon.png',
				'gif' => 'icons/Filetype-gif-icon.png',
				'jpeg' => 'icons/Filetype-jpg-icon.png',
				'jpg' => 'icons/Filetype-jpg-icon.png',
				'm3u' => 'icons/Filetype-m3u-icon.png',
				'mid' => 'icons/Filetype-mid-icon.png',
				'mmm' => 'icons/Filetype-mmm-icon.png',
				'mp3' => 'icons/Filetype-mp-3-icon.png',
				'mpeg' => 'icons/Filetype-mpeg-icon.png',
				'mpg' => 'icons/Filetype-mpg-icon.png',
				'png' => 'icons/Filetype-png-icon.png',
				'tif' => 'icons/Filetype-tif-icon.png',
				'wav' => 'icons/Filetype-wav-icon.png',
				'wma' => 'icons/Filetype-wma-icon.png',
				'cab' => 'icons/Folder-Archive-cab-icon.png',
				'rar' => 'icons/Folder-Archive-rar-icon.png',
				'zip' => 'icons/Folder-Archive-zip-icon.png',
				'xls' => 'icons/Office-Excel-icon.png',
				'xlsx' => 'icons/Office-Excel-icon.png',
				'ppt' => 'icons/Office-Outlook-icon.png',
				'pptx' => 'icons/Office-Outlook-icon.png',
				'doc' => 'icons/Office-Word-icon.png',
				'docx' => 'icons/Office-Word-icon.png',
				
				'music' => 'icons/Folder-Music-icon.png',
				'documents' => 'icons/Folder-My-documents-icon.png',
				'videos' => 'icons/Folder-Videos-icon.png',
				'apps' => 'icons/Folder-Programs-icon.png',


/*
'' => 'icons/Adobe-Dreamweaver-icon.png',
'' => 'icons/Camera-icon.png',
'' => 'icons/CD-icon.png',
'' => 'icons/Control-Panel-icon.png',
'' => 'icons/Desktop-icon.png',
'' => 'icons/Device-Printer-icon.png',
'' => 'icons/Device-RAM-icon.png',
'' => 'icons/Document-help-icon.png',
'' => 'icons/Document-icon.png',
'' => 'icons/Document-scheduled-tasks-icon.png',
'' => 'icons/Drive-CD-Rom-icon.png',
'' => 'icons/Drive-Floppy-blue-icon.png',
'' => 'icons/Drive-Floppy-icon.png',
'' => 'icons/Drive-HD-icon.png',
'' => 'icons/Drive-Network-connected-icon.png',
'' => 'icons/Drive-Network-offline-icon.png',
'' => 'icons/Drive-Removable-icon.png',
'' => 'icons/Folder-Empty-back-icon.png',
'' => 'icons/Folder-Empty-front-icon.png',
'' => 'icons/Folder-Favorites-icon.png',
'' => 'icons/Folder-Fonts-icon.png',
'' => 'icons/Folder-Html-icon.png',
'' => 'icons/Folder-icon.png',
'' => 'icons/Folder-Network-icon.png',
'' => 'icons/Folder-Office-icon.png',
'' => 'icons/Folder-Open-icon.png',
'' => 'icons/Folder-Options-icon.png',
'' => 'icons/Folder-Pictures-icon.png',
'' => 'icons/Folder-Scheduled-Tasks-icon.png',
'' => 'icons/Folder-Settings-Tools-icon.png',
'' => 'icons/Folder-Subscription-icon.png',
'' => 'icons/Folder-URL-History-icon.png',
'' => 'icons/Help-Support-icon.png',
'' => 'icons/Internet-Explorer-icon.png',
'' => 'icons/Mail-icon.png',
'' => 'icons/My-Computer-icon.png',
'' => 'icons/My-Network-Places-icon.png',
'' => 'icons/Network-Earth-icon.png',
'' => 'icons/Network-Entire-icon.png',
'' => 'icons/Office-Access-icon.png',

'' => 'icons/Overlay-Sharing-icon.png',
'' => 'icons/Overlay-Shortcut-icon.png',
'' => 'icons/Recycle-Bin-empty-icon.png',
'' => 'icons/Recycle-Bin-full-icon.png',
'' => 'icons/Search-icon.png',
'' => 'icons/Set-Program-Access-icon.png',
'' => 'icons/Shell-run-icon.png',
'' => 'icons/Taskbar-Start-Menu-icon.png',
'' => 'icons/Workgroup-icon.png',
*/
			);
			
/*
That's it! You are now ready to upload this script to the server.

Only edit what is below this line if you are sure that you know what you
are doing!
*/

if($includeurl)
{
	$includeurl = preg_replace("/^\//", "${1}", $includeurl);
	if(substr($includeurl, strrpos($includeurl, '/')) != '/') $includeurl.='/';
}

error_reporting(0);
if(!function_exists('imagecreatetruecolor')) $showthumbnails = false;
if($startdir) $startdir = preg_replace("/^\//", "${1}", $startdir);
$leadon = $startdir;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

if($_GET['dir']) {
	//check this is okay.
	
	if(substr($_GET['dir'], -1, 1)!='/') {
		$_GET['dir'] = strip_tags($_GET['dir']) . '/';
	}
	
	$dirok = true;
	$dirnames = split('/', strip_tags($_GET['dir']));
	for($di=0; $di<sizeof($dirnames); $di++) {
		
		if($di<(sizeof($dirnames)-2)) {
			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
		}
		
		if($dirnames[$di] == '..') {
			$dirok = false;
		}
	}
	
	if(substr($_GET['dir'], 0, 1)=='/') {
		$dirok = false;
	}
	
	if($dirok) {
		 $leadon = $leadon . strip_tags($_GET['dir']);
	}
}

if($_GET['download']) {
	$file = str_replace('/', '', $_GET['download']);
	$file = str_replace('..', '', $file);

	if(file_exists($includeurl . $leadon . $file)) {
		header("Content-type: application/x-download");
		header("Content-Length: ".filesize($includeurl . $leadon . $file)); 
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($includeurl . $leadon . $file);
		die();
	}
	die();
}
//create directory
if($allowuploads && $_POST['foldername']) {
	mkdir($leadon.$_POST['foldername'], 0777);
}

//Rename a file
if(isset($_REQUEST['ren']) && is_file($startdir.$_REQUEST['dir'].'/'.$_REQUEST['file']) && isset($_SESSION['user']['id'])){
	$filename = $startdir.$_REQUEST['dir'].'/'.$_REQUEST['file'];
	$newname = $startdir.$_REQUEST['dir'].'/'.$_REQUEST['to'];
	rename($filename, $newname);
}

//Delete a file
if(isset($_REQUEST['del']) && is_file($startdir.$_REQUEST['dir'].'/'.$_REQUEST['file']) && isset($_SESSION['user']['id'])){
	$filename = $startdir.$_REQUEST['dir'].'/'.$_REQUEST['file'];
	unlink($filename);
}

//process uploaded file
if($allowuploads && $_FILES['file']) {
	$upload = true;
	if(!$overwrite) {
		if(file_exists($leadon.$_FILES['file']['name'])) {
			$upload = false;
		}
	}
	
	if($uploadtypes)
	{
		if(!in_array(substr($_FILES['file']['name'], strpos($_FILES['file']['name'], '.')+1, strlen($_FILES['file']['name'])), $uploadtypes))
		{
			$upload = false;
			$uploaderror = "<strong>ERROR: </strong> You may only upload files of type ";
			$i = 1;
			foreach($uploadtypes as $k => $v)
			{
				if($i == sizeof($uploadtypes) && sizeof($uploadtypes) != 1) $uploaderror.= ' and ';
				else if($i != 1) $uploaderror.= ', ';
				
				$uploaderror.= '.'.strtoupper($v);
				
				$i++;
			}
		}
	}
	
	if($upload) {
		move_uploaded_file($_FILES['file']['tmp_name'], $includeurl.$leadon . $_FILES['file']['name']);
	}
}

$opendir = $includeurl.$leadon;
if(!$leadon) $opendir = '.';
if(!file_exists($opendir)) {
	$opendir = '.';
	$leadon = $startdir;
}

clearstatcache();
if ($handle = opendir($opendir)) {
	while (false !== ($file = readdir($handle))) { 
		//first see if this file is required in the listing
		if ($file == "." || $file == "..")  continue;
		$discard = false;
		for($hi=0;$hi<sizeof($hide);$hi++) {
			if(strpos($file, $hide[$hi])!==false) {
				$discard = true;
			}
		}
		
		if($discard) continue;
		if (@filetype($includeurl.$leadon.$file) == "dir") {
			if(!$showdirs) continue;
		
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($includeurl.$leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			$dirs[$key] = $file . "";
		}
		else {
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($includeurl.$leadon.$file) . ".$n";
			}
			elseif($_GET['sort']=="size") {
				$key = @filesize($includeurl.$leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			
			if($showtypes && !in_array(substr($file, strpos($file, '.')+1, strlen($file)), $showtypes)) unset($file);
			if($file) $files[$key] = $file;
			
			if($displayindex) {
				if(in_array(strtolower($file), $indexfiles)) {
					header("Location: $leadon$file");
					die();
				}
			}
		}
	}
	closedir($handle); 
}

//sort our files
if($_GET['sort']=="date") {
	@ksort($dirs, SORT_NUMERIC);
	@ksort($files, SORT_NUMERIC);
}
elseif($_GET['sort']=="size") {
	@natcasesort($dirs); 
	@ksort($files, SORT_NUMERIC);
}
else {
	@natcasesort($dirs); 
	@natcasesort($files);
}

//order correctly
if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}
if($_GET['order']=="desc") {$files = @array_reverse($files);}
$dirs = @array_values($dirs); $files = @array_values($files);

//Reorder selector
$baseurl = strip_tags($_SERVER['PHP_SELF']) . '?dir='.strip_tags($_GET['dir']) . '&amp;';
$fileurl = 'sort=name&amp;order=asc';
$sizeurl = 'sort=size&amp;order=asc';
$dateurl = 'sort=date&amp;order=asc';

switch ($_GET['sort']) {
	case 'name':
		if($_GET['order']=='asc') $fileurl = 'sort=name&amp;order=desc';
		break;
	case 'size':
		if($_GET['order']=='asc') $sizeurl = 'sort=size&amp;order=desc';
		break;
		
	case 'date':
		if($_GET['order']=='asc') $dateurl = 'sort=date&amp;order=desc';
		break;  
	default:
		$fileurl = 'sort=name&amp;order=desc';
		break;
}

//Format File Size
function filesize_format($filesize){
    
    if(is_numeric($filesize)){
    $decr = 1024; $step = 0;
    $prefix = array('Bytes','KB','MB','GB','TB','PB');
        
    while(($filesize / $decr) > 0.9){
        $filesize = $filesize / $decr;
        $step++;
    } 
    return round($filesize,2).' '.$prefix[$step];
    } else {

    return 'NaN';
    }
    
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<title><?php 	if(isset($_GET['dir'])){
		echo trim($filename);
		}else{echo trim('DillEva. Server');}?>
</title>
<link rel="stylesheet" type="text/css" href="<?php echo $includeurl; ?>root/css/style.css" />
<link rel="stylesheet" href="<?php echo $includeurl; ?>root/css/jquery-ui.css" />
<!--[if IE]><script type="application/javascript" src="./root/js/excanvas.js"></script>     <![endif]-->
<script type="application/javascript" src="./root/js/jquery-1.8.3.js"></script>
<script type="application/javascript" src="./root/js/jquery-ui.js"></script>
<script type="application/javascript" src="./root/js/iscroll.js"></script>
<script src="./root/js/h5utils.js"></script>
<script src="./root/js/modernizr.custom.js"></script>
<script>
	var scrollContent,
		scrollNav;

	function loaded() {
		scrollContent = new iScroll('contentWrapper', {
			useTransform: false,
			onBeforeScrollStart: function (e) {
				var target = e.target;
				while (target.nodeType != 1) target = target.parentNode;

				if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA' && target.tagName != 'IFRAME') e.preventDefault();
			}
			
		});
		
		
		scrollNav = new iScroll('navWrapper', {
			useTransform: false,
			onBeforeScrollStart: function (e) {
				var target = e.target;
				while (target.nodeType != 1) target = target.parentNode;

				if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA' && target.tagName != 'IFRAME')
					e.preventDefault();
			}
		});
	}

	document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

	document.addEventListener('DOMContentLoaded', loaded, false);
</script>
<?php
if($showthumbnails) {
?>
<script language="javascript" type="text/javascript">
<!--
function o(n, i) {
	document.images['thumb'+n].src = '<?php echo $includeurl; ?>root/i.php?f='+i<?php if($memorylimit!==false) echo "+'&ml=".$memorylimit."'"; ?>;

}

function f(n) {
	document.images['thumb'+n].src = 'root/img/trans.gif';
}
//-->
</script>
<?php
}
?>
<script>
function boost(){
	document.getElementById('sidebar').style.width = '0px';
	document.getElementById('sidebar').style.display = 'none';
	document.getElementById('breadcrumbs').style.left = '0';
	document.getElementById('boost').style.display = 'none';
	document.getElementById('shoot').style.display = 'block';
	return true;
}

function shoot(){
	document.getElementById('sidebar').style.width = '240px';
	document.getElementById('sidebar').style.display = 'block';
	document.getElementById('breadcrumbs').style.left = '256px';
	document.getElementById('boost').style.display = 'block';
	document.getElementById('shoot').style.display = 'none';
	return true;
}

function show(ID){
	document.getElementById(ID).style.display = 'block';
}

function hide(ID){
	document.getElementById(ID).style.display = 'none';
}

function output(ID){
	document.getElementById('output').style.display = 'block';
	$('#output').html(ID);
}

function reload(){
	document.getElementById('contentScroller').style.display = 'none';
	document.getElementById('loader').style.display = 'block';
}

function destroy(file){
	show('delete');
	document.getElementById('renamer').innerHTML = file + '<input type="hidden" name="file" value="' + file + '"/>';
	document.getElementById('victims').innerHTML = file + '<input type="hidden" name="file" value="' + file + '"/>';
}
</script>
<script>
    (function( $ ) {
        $.widget( "ui.combobox", {
            _create: function() {
                var input,
                    that = this,
                    select = this.element.hide(),
                    selected = select.children( ":selected" ),
                    value = selected.val() ? selected.text() : "",
                    wrapper = this.wrapper = $( "<span>" )
                        .addClass( "ui-combobox" )
                        .insertAfter( select );
 
                function removeIfInvalid(element) {
                    var value = $( element ).val(),
                        matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
                        valid = false;
                    select.children( "option" ).each(function() {
                        if ( $( this ).text().match( matcher ) ) {
                            this.selected = valid = true;
                            return false;
                        }
                    });
                    if ( !valid ) {
                        // remove invalid value, as it didn't match anything
                        $( element )
                            .val( "" )
                            .attr( "title", value + " didn't match any item" )
                            .tooltip( "open" );
                        select.val( "" );
                        setTimeout(function() {
                            input.tooltip( "close" ).attr( "title", "" );
                        }, 2500 );
                        input.data( "autocomplete" ).term = "";
                        return false;
                    }
                }
 
                input = $( "<input>" )
                    .appendTo( wrapper )
                    .val( value )
                    .attr( "value", "<?php echo $_GET['dir'];?>" )
                    .addClass( "ui-state-default ui-combobox-input" )
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: function( request, response ) {
                            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                            response( select.children( "option" ).map(function() {
                                var text = $( this ).text();
                                if ( this.value && ( !request.term || matcher.test(text) ) )
                                    return {
                                        label: text.replace(
                                            new RegExp(
                                                "(?![^&;]+;)(?!<[^<>]*)(" +
                                                $.ui.autocomplete.escapeRegex(request.term) +
                                                ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                            ), "<strong>$1</strong>" ),
                                        value: text,
                                        option: this
                                    };
                            }) );
                        },
                        select: function( event, ui ) {
                            ui.item.option.selected = true;
                            that._trigger( "selected", event, {
                                item: ui.item.option
                            });
                        },
                        change: function( event, ui ) {
                            if ( !ui.item )
                                return removeIfInvalid( this );
                        }
                    })
                    .addClass( "ui-widget ui-widget-content ui-corner-left search" );
 
                input.data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + item.label + "</a>" )
                        .appendTo( ul );
                };
 
                /*$( "<a>" )
                    .attr( "tabIndex", -1 )
                    .attr( "title", "Show All Items" )
                    .tooltip()
                    .appendTo( wrapper )
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass( "ui-corner-all" )
                    .addClass( "ui-corner-right ui-combobox-toggle" )
                    .click(function() {
                        // close if already visible
                        if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
                            input.autocomplete( "close" );
                            removeIfInvalid( input );
                            return;
                        }
 
                        // work around a bug (likely same cause as #5265)
                        $( this ).blur();
 
                        // pass empty string as value to search for, displaying all results
                        input.autocomplete( "search", "" );
                        input.focus();
                    });
					*/
 
                    input
                        .tooltip({
                            position: {
                                of: this.button
                            },
                            tooltipClass: "ui-state-highlight"
                        });
            },
 
            destroy: function() {
                this.wrapper.remove();
                this.element.show();
                $.Widget.prototype.destroy.call( this );
            }
        });
    })( jQuery );
 
    $(function() {
        $( ".combobox" ).combobox();
        $( "#toggle" ).click(function() {
            $( ".combobox" ).toggle();
        });
    });
    </script>
	<script>
		document.oncontextmenu=RightMouseDown;
		document.onmousedown = mouseDown; 
		
		function mouseDown(e) {
			if (e.which==3) {//righClick
				//alert("Right-click menu goes here");
			}
		}

		function RightMouseDown() { return false; }
	</script>
</head>
<body>
<div id="header">
	<a href="/" onClick="reload();"><div id="logo"><img  src="./root/img/dlogo.png" width=100 height="auto"/></div></a>
	<span id="menuish">
		<ul id="mainmenu">
			
			<?php //<a href="/" onClick="reload();"><li class="link"><img src="./root/img/home.png" width=24 height=24 /></li></a> ?>
			
			<?php
			$class = 'b';
					if($dirok) {
					/* ?>
					<div class="item"><a href="<?php echo strip_tags($_SERVER['PHP_SELF']).'?dir='.urlencode($dotdotdir);?>" class="<?php echo $class;?>"><img src="<?php echo $includeurl; ?>root/img/dirup.png" alt="Folder" /><strong>..</strong> <em>&nbsp;</em>&nbsp;</a></div>
					*/ ?>
					<?php
						if($class=='b') $class='w';
						else $class = 'b';
					}
			?>
			<li class="link" onclick="reload();history.back();"><img src="./root/img/arrow-180.png" width=24 height=24 /></li>
			<?php /* <li class="link" onclick="reload();history.forward();"><img src="./root/img/arrow.png" width=24 height=24 /></li>
			<li class="link" onclick="reload();location.reload();"><img src="./root/img/arrow-circle-315.png" width=24 height=24 /></li>
			<?php */ 
			if(isset($_SESSION['user']['id'])){?>
			<a onClick="show('uploader');return false;"><li class="link"><img src="./root/img/upload.png" width=24 height=24 /></li></a>
			<a onClick="show('newfolder');return false;"><li class="link"><img src="./root/img/folder.png" width=24 height=24 /></li></a>
			<?php } if(!($_SESSION['user']['id'])){	
				echo '<a onClick="show(\'loginbox\');return false;"><li class="link"><img src="./root/img/lock.png" width=24 height=24 /></li></a>';
			}else{echo '<a href="./root/logout.php"><li class="link" onClick="reload();"><img src="./root/img/user.png" width=24 height=24 /></li></a>';}?>
			<li>
				<form action="<?php echo $baseurl; ?>" id="sorty" method="get">
					<input type="hidden" name="dir" value="<?php if(isset($_REQUEST['dir'])){echo $_REQUEST['dir'];} ?>"/>
					<input type="hidden" name="order" value="<?php if(isset($_REQUEST['order'])){
						$order = $_REQUEST['order'];
						switch($order) {
							case 'asc':
								echo 'desc';
								break;
							
							case 'desc':
								echo 'asc';
								break;
						}
					}else{echo 'asc';}?>"/>
					<select type="select" name="sort" placeholder="<?php echo 'Sort by'; ?>" onChange="document.forms['sorty'].submit()">
						<option>Sort by...</option>
						<option value="name">Name</option>
						<option value="size">Size</option>
						<option value="date">Modified</option>
					</select>
				</form>
		</li>
	</ul>
</div>
<div id="page">
	<div id="sidebar" style="display:none;">
		<header>Navigation</header>
		<nav id="navWrapper">
			<ul id="navScroller">
				<li>
					<form id="directory" action="" method="get">
						<div class="ui-widget">
							<select id="shadow_search" name="dir" class="combobox">
							<option value="<?php echo $_GET['dir'];?>"><?php echo $_GET['dir'];?></option>
							<?php $arsize = sizeof($dirs);
							for($i=0;$i<$arsize;$i++) {
								if(isset($_GET['dir'])){$link = $_GET['dir'].c;}else{$link = $dirs[$i];}
								echo '<option value="'.$link.'">'.$link.'</option>';
							} ?>
							</select>
						</div>
						<input id="gobutton" type="submit" value="Go" onClick="reload();"/>
					</form>
				</li>
				<?php if(isset($_SESSION['user']['id'])){?>
				<a href="./"><li><img src='./root/img/home.png' alt='icon' class='icon'/>Home</li></a>
				<?php }
				if(($_SESSION['user']['id']) == 1){?>
				<a href="?dir=users/1" target="_parent"><li><img src='./root/img/icons/Folder-Network-icon.png' alt='icon' class='icon'/>My Folder</li></a>
				<?php } ?>
				<?php if(isset($_SESSION['user']['id'])){?>
				<a href="?dir=public"><li><img src='./root/img/icons/Folder-Network-icon.png' alt='icon' class='icon'/>Public</li></a>
				<?php } if(($_SESSION['user']['id']) == 1){?>
				<a href="phpmyadmin" target="_blank"><li><img src='./root/img/database-sql.png' alt='icon' class='icon'/>Databases</li></a>
				<header>Applications</header>
				<a href="./root/apps/sigma/VisualJS/index.html" target="_blank"><li><img src='./root/apps/sigma/favicon.ico' alt='icon' class='icon'/>Sigma UI Builder</li></a>
				<a href="./root/apps/jsbin-master/index.php" target="_blank"><li><img src='./root/apps/sigma/favicon.ico' alt='icon' class='icon'/>JS Bin</li></a>
				<a href="./root/apps/kendoui.web.2012.2.710.open-source/examples/web/index.html" target="_blank"><li><img src='./root/apps/sigma/favicon.ico' alt='icon' class='icon'/>Kendo UI Docs</li></a>
				<?php } ?>
				<!-- //TODO: Add the ability to add favorites on the fly -->				
				<div class="pusher"> </div>
			</ul>
		</nav>
	</div>
	<div id="boost" onClick="boost();"><img src="./root/img/fancyBox-prev.png" width=25 height="auto"/></div>
	<div id="shoot" onClick="shoot();"><img src="./root/img/fancyBox-next.png" width=25 height="auto"/></div>
	<div id="content">
	<article id="contentWrapper">
		<?php if(isset($_REQUEST['url'])){
		echo '
			<div id="contentScroller">
				<iframe src="'.$_REQUEST['url'].'" width="100%" style="margin: -18px;
position: fixed;bottom:40px;top:57px;height:100%;"></iframe>
			</div>';}else{?>
		<div id="contentScroller">
		
			  <?php if(!($_GET['display'])){ ?>
			  <div id="listingcontainer">
			  		
				<div id="listing">
				
				<?php
				//show welcome message
				if(isset($_SESSION['user']['id']) && ($_SESSION['user']['id'] != 1) && !($_REQUEST['dir'])){
					echo '<h1>Hello '.$_SESSION['user']['first'].'</h1>';}
				
				//list directories
				for($i=0;$i<$arsize;$i++) {
				?>
				<div  class="item">
					<a href="<?php echo strip_tags($_SERVER['PHP_SELF']).'?dir='.urlencode(str_replace($startdir,'',$leadon).$dirs[$i]);?>" class="<?php echo $class;?>" onClick="reload();">
						<div class='label'>
							<span class='thumbnail'style='background:transparent  url(<?php echo $includeurl; ?>/root/img/folder-documents.png) center center no-repeat;' >
							</span>
							<span class='itemname'>
								<strong><?php echo $dirs[$i];?></strong>
								<br>
								<em><?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$dirs[$i]));?></em>
							</span>
						</div>
					</a>
				</div>
				
				<?php
					if($class=='b') $class='w';
					else $class = 'b';	
				}
				
				//show public folder to signed in users
				if(isset($_SESSION['user']['id']) && ($_SESSION['user']['id'] != 1) && !($_REQUEST['dir'])){
					echo '<div class="item">
						<a href="/index.php?dir=public" class="b" onclick="reload();">
							<div class="label">
								<span class="thumbnail" style="background:transparent  url(./root/img/icons/Folder-Network-icon.png) center center no-repeat;">
								</span>
								<span class="itemname">
									<strong>Public</strong>
									<br>
									<em> </em>
								</span>
							</div>
						</a>
					</div>';
				}
				
				$arsize = sizeof($files);
				for($i=0;$i<$arsize;$i++) {
					$icon = 'script.png';
					$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
					$supportedimages = array('gif', 'png', 'jpeg', 'jpg');
					$thumb = '';
					
					if($showthumbnails && in_array($ext, $supportedimages)) {
						$thumb = '<span class="thumb"><img src="root/img/trans.gif" alt="'.$files[$i].'" name="thumb'.$i.'" /></span>';
						$thumb2 = ' onmouseover="o('.$i.', \''.urlencode($leadon . $files[$i]).'\');" onmouseout="f('.$i.');"';
						
					}
					
					if($filetypes[$ext]) {
						$icon = $filetypes[$ext];
					}
					
					$filename = $files[$i];
					if(strlen($filename)>43) {
						$filename = substr($files[$i], 0, 40) . '...';
					}
					
					$fileurl = $includeurl . $leadon . $files[$i];
					if($forcedownloads) {
						$fileurl = $_SESSION['PHP_SELF'] . '?dir=' . urlencode(str_replace($startdir,'',$leadon)) . '&download=' . urlencode($files[$i]);
					}
					
					$directlink = $_SESSION['PHP_SELF'] . '?dir=' . urlencode(str_replace($startdir,'',$leadon)) . '/' . urlencode($files[$i]);

				?>
				<div  class="item">
					<a href="<?php 
					switch ($ext) {
						case 'mp4':
							echo /*'./VideoPlayer/?url='.*/$directlink;
							break;
						case 'mp3':
							echo /*'./AudioPlayer/?dir='.$_REQUEST['dir'].'&url='.*/$directlink;
							break;
						default:
							echo $fileurl;
							break;
					}					
					?>" class="<?php echo $class;?>"<?php echo $thumb2; if($ext == 'mp3') {echo 'target="_parent"';}else{echo 'target="_blank"';}?>
					>
						<div class='label'>
							<span class='thumbnail'style='background:transparent  url(<?php echo $includeurl; ?>root/img/<?php
									if(in_array(strtolower($filename), $indexfiles)) {
										echo 'globe.png';
									}else{
							echo $icon;}?>) center center no-repeat;' ></span>
							<span class='itemname'>
								<strong><?php echo $filename;?></strong> 
								<br>
								<em>
									<strong>
										<?php echo filesize_format(filesize($includeurl.$leadon.$files[$i]));
										?>
									</strong>
									<br>
									<?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$files[$i]));?><?php echo $thumb;?>
								</em>
							</span>
						</div>
					</a>
					<input id="deletebtn" type="button" onClick="destroy('<?php echo $filename; ?>');" value="-">
				</div>
				
				<?php
					if($class=='b') $class='w';
					else $class = 'b';	
				}	
				?>
				</div>
			  </div>
			  
			  <div class="pusher"></div>
			  
			  <?php }else{ ?>
			  
			   <div id="listingcontainer">
				<div id="listingheader"> 
				<div id="headerfile"><a href="<?php echo $baseurl . $fileurl;?>">File</a></div>
				<div id="headersize"><a href="<?php echo $baseurl . $sizeurl;?>">Size</a></div>
				<div id="headermodified"><a href="<?php echo $baseurl . $dateurl;?>">Modified</a></div>
				</div>
				<div id="listing">
				<?php
				$class = 'b';
				if($dirok) {
				?>
				<div><a href="<?php echo strip_tags($_SERVER['PHP_SELF']).'?dir='.urlencode($dotdotdir);?>" class="<?php echo $class;?>"><img src="<?php echo $includeurl; ?>root/img/dirup.png" alt="Folder" /><strong>..</strong> <em>&nbsp;</em>&nbsp;</a></div>
				<?php
					if($class=='b') $class='w';
					else $class = 'b';
				}
				$arsize = sizeof($dirs);
				for($i=0;$i<$arsize;$i++) {
				?>
				<div><a href="<?php echo strip_tags($_SERVER['PHP_SELF']).'?dir='.urlencode(str_replace($startdir,'',$leadon).$dirs[$i]);?>" class="<?php echo $class;?>"><img src="<?php echo $includeurl; ?>root/img/folder.png" alt="<?php echo $dirs[$i];?>" /><strong><?php echo $dirs[$i];?></strong> <em>-</em> <?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$dirs[$i]));?></a></div>
				<?php
					if($class=='b') $class='w';
					else $class = 'b';	
				}
				
				$arsize = sizeof($files);
				for($i=0;$i<$arsize;$i++) {
					$icon = 'unknown.png';
					$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
					$supportedimages = array('gif', 'png', 'jpeg', 'jpg');
					$thumb = '';
					
					if($showthumbnails && in_array($ext, $supportedimages)) {
						$thumb = '<span><img src="root/img/trans.gif" alt="'.$files[$i].'" name="thumb'.$i.'" /></span>';
						$thumb2 = ' onmouseover="o('.$i.', \''.urlencode($leadon . $files[$i]).'\');" onmouseout="f('.$i.');"';
						
					}
					
					if($filetypes[$ext]) {
						$icon = $filetypes[$ext];
					}
					
					$filename = $files[$i];
					if(strlen($filename)>43) {
						$filename = substr($files[$i], 0, 40) . '...';
					}
					
					$fileurl = $includeurl . $leadon . $files[$i];
					if($forcedownloads) {
						$fileurl = $_SESSION['PHP_SELF'] . '?dir=' . urlencode(str_replace($startdir,'',$leadon)) . '&download=' . urlencode($files[$i]);
					}

				?>
				<div><a href="<?php echo $fileurl;?>" class="<?php echo $class;?>"<?php echo $thumb2;?>><img src="<?php echo $includeurl; ?>root/img/<?php echo $icon;?>" alt="<?php echo $files[$i];?>" /><strong><?php echo $filename;?></strong><em><?php echo round(filesize($includeurl.$leadon.$files[$i])/1024);?></em><?php echo date ("M d Y h:i:s A", filemtime($includeurl.$leadon.$files[$i]));?><?php echo $thumb;?></a></div>
				<?php
					if($class=='b') $class='w';
					else $class = 'b';	
				}	
				?></div>
			  </div>
			  
			  <?php } ?>
	  </div>
		<?php } ?>
		<div id="loader">
			<img src="./root/img/loading.gif" />
		</div>
	</article>
	
	<div id="uploader" class="popup inhouse">
		<header>
		File Uploader
		</header>
		<?php
			if($allowuploads) {
				$phpallowuploads = (bool) ini_get('file_uploads');		
				$phpmaxsize = ini_get('upload_max_filesize');
				$phpmaxsize = trim($phpmaxsize);
				$last = strtolower($phpmaxsize{strlen($phpmaxsize)-1});
				switch($last) {
					case 'g':
						$phpmaxsize *= 102400000;
					case 'm':
						$phpmaxsize *= 102400000;
				}
			?>
			<div id="upload">
				<div id="uploadtitle">
					<strong>File Upload</strong><em>(Max Filesize: <?php echo round(filesize($phpmaxsize)/1024);?>KB)</em>
					<?php if($uploaderror) echo '<div class="upload-error">'.$uploaderror.'</div>'; ?>
				</div>
				<div id="uploadcontent">
					<?php
						if($phpallowuploads) {
						?>
						<form method="post" action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>?dir=<?php echo urlencode(str_replace($startdir,'',$leadon));?>" enctype="multipart/form-data">
						<input type="file" required name="file" /> <input type="submit" value="Upload" />
						</form>
						<?php
						}
						else {
						?>
						File uploads are disabled in your php.ini file. Please enable them.
						<?php
						}
					
					?>
				</div>
				
			</div>
			<?php
			}else{
			?>You need to log in to upload files<?php } ?>
			<footer onClick="hide('uploader');">
			Close
			</footer>
		</div>
		
		<div id="newfolder" class="popup inhouse">
		<header>
		New Folder
		</header>
		<?php
			if($allowuploads) {
			?>
			<div id="upload">
				<div id="uploadtitle">
					<strong>Create A New Folder</strong>
				</div>
				<div id="uploadcontent">
					<?php
						if($phpallowuploads) {
						?>
						<form method="post" action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
						<input type="text" required name="foldername" /> <input type="submit" required value="Create" />
						</form>
						<?php
						}
						else {
						?>
						File uploads are disabled in your php.ini file. Please enable them.
						<?php
						}
					
					?>
				</div>
				
			</div>
			<?php
			}else{
			?>You need to log in to modify files<?php } ?>
			<footer onClick="hide('newfolder');">
			Close
			</footer>
		</div>
		
		<div id="delete" class="popup inhouse">
		<header>
		File Operations
		</header>
		<?php
			if($allowuploads) {
			?>
			<div id="upload">
				
				<div id="uploadtitle">
					<strong>Rename</strong>
				</div>
				<div id="uploadcontent">
					<?php
						if($phpallowuploads) {
						?>
						<form method="get" action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
						Rename <strong>
						<input type="hidden" name="dir" value="<?php if(isset($_REQUEST['dir'])){echo $_REQUEST['dir'];}else{echo '';}?>"/>
						<input type="hidden" name="ren" required value="1"/>
						<input type="text" name="to" required placeholder="newname" autocomplete="off">
						<em id="renamer"></em></strong>
						<input type="submit" required value="Rename" />
						</form>
						<?php
						}
						else {
						?>
						File modifications are disabled in your php.ini file. Please enable them.
						<?php
						}
					
					?>
				</div>
				
				<div id="uploadtitle">
					<strong>Delete</strong>
				</div>
				<div id="uploadcontent">
					<?php
						if($phpallowuploads) {
						?>
						<form method="get" action="<?php echo strip_tags($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
						Delete <strong>
						<input type="hidden" name="dir" value="<?php if(isset($_REQUEST['dir'])){echo $_REQUEST['dir'];}else{echo '';}?>"/>
						<input type="hidden" name="del" value="1"/>
						<em id="victims"></em></strong>
						<input type="submit" value="Yes" />
						</form>
						<?php
						}
						else {
						?>
						File modifications are disabled in your php.ini file. Please enable them.
						<?php
						}
					
					?>
				</div>
				
			</div>
			<?php
			}else{
			?>You need to log in to modify files<?php } ?>
			<footer onClick="hide('delete');">
			Close
			</footer>
		</div>
		
		
		<div id="loginbox" class="popup">	
			<iframe src="./root/login.php" width="100%" height="100%" style="border:none;margin:0;background:transparent;"><style>body{margin:0;}</style></iframe>
		</div>

	</div>
	<div id="footer">
		<div id="breadcrumbs"> <a href="<?php echo strip_tags($_SERVER['PHP_SELF']);?>">Home</a> 
		  <?php
			 $breadcrumbs = split('/', str_replace($startdir, '', $leadon));
			if(($bsize = sizeof($breadcrumbs))>0) {
				$sofar = '';
				for($bi=0;$bi<($bsize-1);$bi++) {
					$sofar = $sofar . $breadcrumbs[$bi] . '/';
					echo ' &gt; <a href="'.strip_tags($_SERVER['PHP_SELF']).'?dir='.urlencode($sofar).'">'.$breadcrumbs[$bi].'</a>';
				}
			}
		  ?>

			<span id="status">
				
				<ol id="state"></ol>
				<script>
				var statusElem  = document.getElementById('status'),
					state       = document.getElementById('state');

				function online(event) {
				  statusElem.className = navigator.onLine ? 'online' : 'offline';
				  statusElem.innerHTML = navigator.onLine ? '<img src="./root/img/icons/Drive-Network-connected-icon.png" width=16 height=16 alt="offline"/> Online' : '<img src="./root/img/icons/Drive-Network-offline-icon.png" width=16 height=16 alt="offline"/> Offline';
				  state.innerHTML += '<li>New event: ' + event.type + '</li>';
				}

				addEvent(window, 'online', online);
				addEvent(window, 'offline', online);
				online({ type: 'ready' });
				</script>
			</span>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		document.getElementById('contentScroller').style.display = 'block';
		document.getElementById('loader').style.display = 'none';
	});
	
</script>

<script>
//Drag and drop script...

</script>
</body>
</html>

<?php /*

MORE STUFF
1. There's lots more that can be done to this script...

I'm stopping here for now, the last piece I'm going to add is the user sign up and oath and then I'm done... I think

This has been an obsessive project. Really. It started out as a way to browse my server folder beautifully. But then all these things came up and I started thinking what about uploading and downloading. What about adding a text editor, audio player and video player. 

What about if I allowed users to have their own folders they could dump their stuff onto. What about creating a publicly shared folder where everyone can download stuff but only users can upload content. 

What about detecting the online or offline status of the browser and then prompting the user to downloa the app.

Well... as you can see, it became more and more like them online file sharing platforms ... like Dropbox, Google Docs, SkyDrive etc...

So I'm thinking of opening this up inside DillEva. I mean everyone can upload a few documents and get their own server space. You can even host http documents here... or, maybe not. I've added a few security measures like users (except me, hehehe) can't upload web executables... ie, html, php, js, css, sql, etc. . . cause you never know what they'll do afterwards like... 

Anywho.. this is me signing off on a long project that has taken it's days and nights, weeks and months... but the best thing about it is I did it myself.

Then I'd also like to give credit to where credit is due, I read lots of code from other developers. If that up there looks like your handwriting, thanks a lot!!

Cheers

Elijah Bee
18 December 2012 18:38 hours UTC +3 Jinja (at the Pirates Cafe)
1260 Lines of code
-- > Last save <--

*/ ?>