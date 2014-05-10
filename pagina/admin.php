<?php

if(!isset($_SESSION['id'])) {
	$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je bent helemaal geen admin!</div>';
	header('Location:'.$root);
	exit;
}
if(isset($url[1])) {
	if($url[1] == 'leden') {
		include ('adminpanel/gebruikers.php');
	}
	if($url[1] == 'nieuws') {
		include ('adminpanel/nieuws.php');
	}
	if($url[1] == 'winkel') {
		include ('adminpanel/winkel.php');
	}
    if($url[1] == 'faq') {
		include ('adminpanel/faq.php');
	}
}else{
	include ('adminpanel/index.php');
}

?>