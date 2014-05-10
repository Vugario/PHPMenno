<?php

if(isset($_SESSION['admin'])) {
	if(isset($_POST['submit']) && !empty($_POST['bericht'])) {
		$bericht = mysql_real_escape_string($_POST['bericht']);

		$sql = "SELECT member_id,gebruikersnaam,level FROM leden ORDER BY gebruikersnaam ASC";
		$query = mysql_query($sql);
		
		while($row = mysql_fetch_assoc($query)) {
			mysql_query("INSERT INTO alert (member_id,reden,gelezen,datum,door) VALUES ('".$row['member_id']."','".$bericht."','Nee',NOW(),'".$_SESSION['gebruikersnaam']."')");
			$i++;
		}
		if(mysql_error() == "") {
			echo "Alerts zijn succesvol verstuurd.";
		}else{
			echo "Er is een onbekende fout opgetreden.";
		}
	}else{
		?>
		<form action="<?php $_SERVER['PHP_SELF'] ?>?p=admin_massaalert" method="POST">
		<strong>Stuur elk online lid een alert</strong><br />
		Reden:<br />
		<textarea name="bericht" rows="10" cols="40"></textarea><br />
		<br />
		<input type="submit" value="Sturen" name="submit"  />
		</form>
		<?php
	}
}else{
	echo "Je bent helaas geen admin.";
}
?>