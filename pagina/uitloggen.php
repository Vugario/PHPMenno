<?php
error_reporting(0);
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}


if(isset($_SESSION['id'])) {
	mysql_query("DELETE FROM sessies WHERE ip = '".$_SERVER['REMOTE_ADDR']."'");
	session_destroy();
	session_start();
	$_SESSION['uitloggen'] = true;
	echo "Je bent nu succesvol uitgelogd.<br />
	Je wordt in 2 seconden doorgelinkt.";
	echo '<meta http-equiv="refresh" content="2;URL=index.php" />';
	
}else{
	echo "Je was nog niet ingelogd dus je kan ook niet uitloggen.";
}

?>