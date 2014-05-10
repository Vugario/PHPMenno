<?php

if(isset($_SESSION['id'])) {

	$sessdata = $_SESSION['id'];
	
	$sessdata_str = serialize($sessdata);
	$md5hash = md5($sessdata_str);

	if(isset($_SESSION['hash']) && isset($_SESSION['ip']) && $_SESSION['hash'] == $md5hash && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] && is_numeric($_SESSION['id'])) {
		$sql = mysql_query("SELECT * FROM sessies WHERE member_id='".$_SESSION['id']."' AND ip='".$_SERVER['REMOTE_ADDR']."' AND hash='".$md5hash."'");
		if(mysql_num_rows($sql) >= 1) {
			return true;
		}else{
			include('pagina/uitloggen.php');
		}
	}else{
		include('pagina/uitloggen.php');
		die();
	}
}

?>