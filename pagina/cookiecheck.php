<?php
if(isset($_SESSION['hash'])) {
	setcookie("hash", $_SESSION['hash'], time()+30758400, "/");
}
if($_SESSION['uitloggen'] == true) {
	setcookie("hash", "", time()+1, "/");
}
if(isset($_COOKIE['hash'])) {
	$hash = mysql_real_escape_string($_COOKIE['hash']);
	$sql = mysql_query("SELECT * FROM sessies WHERE hash='".$hash."' LIMIT 1");
	if(mysql_num_rows($sql) == 1) {
		$row = mysql_fetch_assoc($sql);
		if($_SERVER['REMOTE_ADDR'] == $row['ip']) {
			$sql_leden = mysql_query("SELECT gebruikersnaam,level FROM leden WHERE member_id='".$row['member_id']."'");
			$row_leden = mysql_fetch_assoc($sql_leden);
			$_SESSION['id'] = $row['member_id'];
			$_SESSION['gebruikersnaam'] = $row_leden['gebruikersnaam'];
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['hash'] = $hash;
			if($row['level'] == 6) {
				$_SESSION['admin'] = 1;
			}
			if($row['level'] == 2) {
				$_SESSION['nieuwsreporter'] = 1;
			}
			if($row['level'] == 5) {
				$_SESSION['moderator'] = 1;
			}
			if($row['level'] == 3) {
				$_SESSION['forumbeheerder'] = 1;
			}
		}else{
			// Geen goede gegevens
		}
	}
}

?>