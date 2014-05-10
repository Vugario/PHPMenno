<?php

if(isset($_SESSION['admin'])) {
	if(isset($_POST['submit']) && !empty($_POST['bericht'])) {
		$bericht = mysql_real_escape_string($_POST['bericht']);
		$dag = date("Y-m-d");
mysql_query( "INSERT INTO alert (member_id,reden,gelezen,datum,door) (SELECT member_id, '{$bericht}' as reden, 'Nee' as gelezen, NOW() as datum, '{$_SESSION['gebruikersnaam']}' as door FROM leden)" );
		if(mysql_error() == "") {
			echo "Alerts zijn succesvol verstuurd.";
		}else{
			echo "Er is een onbekende fout opgetreden.";
			echo mysql_error();
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