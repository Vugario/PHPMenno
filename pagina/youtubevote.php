<?php

if(isset($_GET['id']) && isset($_GET['a']) && is_numeric($_GET['id']) && is_numeric($_GET['a']) && $_GET['a'] >= 1 && $_GET['a'] <= 5 && isset($_GET['s']) && $_GET['s'] == "vote") {
	$id = mysql_real_escape_string($_GET['id']);
	$a = mysql_real_escape_string($_GET['a']);
	
	$sql = mysql_query("SELECT score FROM youtube WHERE id='".$id."'");
	$row = mysql_fetch_assoc($sql);
	$tekst = $row['score'];
	$tekst .= ",".$a;
	mysql_query("INSERT INTO youtubeip (ip,datum,youtube_id) VALUES ('".$_SERVER['REMOTE_ADDR']."',NOW(),'".$id."')");
	if(mysql_error() == "") {
		mysql_query("UPDATE youtube SET score = '".$tekst."' WHERE id = '".$id."'");
		echo "<span style=\"color:green; text-weight:bold;\">Je hebt succesvol een ".$a." op dit artikel gestemd.<br /><a href='javascript:history.go(-1)'>Ga terug</a><br /></span>";
	}else{
		echo "<span style=\"color:red; text-weight:bold;\">Je hebt helaas al op dit artikel gestemd, je kan niet 2x op 1 artikel stemmen.<br /><a href='javascript:history.go(-1)'>Ga terug</a><br /></span>";
	}
}
?>