<?php

$kostenclublid = 30;   // de prijs voor een maand clublid

if(isset($_SESSION['id'])) {
	if(isset($_POST['submit'])) {
		$sql = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		$sql_club = mysql_query("SELECT * FROM clublid WHERE member_id='".$_SESSION['id']."'");
		$row_club = mysql_fetch_assoc($sql_club);
		
		if($row['muntjes'] - $kostenclublid < 0) {
			echo "Je hebt niet genoeg muntjes om dit te kopen.<br />";
		}elseif(mysql_num_rows($sql_club) == 1) {
			echo "Je bent al clublid, je kan niet 2 keer clublid worden.";
		}else{
			echo "Je bent nu een echt clublid.";
			mysql_query("INSERT INTO clublid (member_id,datum) VALUES ('".$_SESSION['id']."',NOW())");
		}
	}else{
		?>
		<form method="POST">
		Wil jij een maand clublid kopen?<br />
		Bij het kopen van een maand clublid krijg je vele leuke extra's<br />
		<br />
		- Meer muntjes bij het inloggen<br />
		- Een echte clublid badge<br />
		- Een echte clublid rang<br />
		<br />
		<input type="submit" name="submit" value="Koop 1 maand" />
		<br />
		</form>
		<?php
	}
}else{
	echo "Je bent niet ingelogd";
}

?>