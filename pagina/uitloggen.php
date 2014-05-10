<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
if(isset($_SESSION['admin'])) {
    session_destroy();
}

?>

<?php

if(isset($_SESSION['id'])) {
	unset($_SESSION['id']);
	$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je bent succes vol uitgelogd. Tot ziens!</div>';
	header('Location:'.$root);
}

?>