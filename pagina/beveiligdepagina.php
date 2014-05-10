<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?>
	
	
	<h3><?php echo $_SESSION['gebruikersnaam']; ?></h3>
	Hier komt je vrije beveiligde pagina.<br><br>
	<strong>Gebruikers Panel</strong><br>
	<a href="?p=ledenlijst">Ledenlijst</a><br>
	<a href="?p=wwveranderen">Wachtwoord Veranderen</a><br>
	<?php
	if(isset($_SESSION['admin'])) {
		echo "<a href='?p=admin'>Admin Panel</a><br>";
	}
	?>
	<a href="?p=uitloggen">Uitloggen</a><br>
	<br>
	<strong>Je habbo look </strong>:<br>
	<?php $row = mysql_fetch_assoc(mysql_query("SELECT land FROM profiel WHERE member_id='".$_SESSION['id']."'"));
	if($row['land'] != "") {
		$land = $row['land'];
	}else{
		$land = "nl";
	}
	?>
	<img src="http://www.habbo.<?php echo $land; ?>/habbo-imaging/avatarimage?user=<?php echo $_SESSION['gebruikersnaam']; ?>&action=hallo&frame=1&direction=4&head_direction=3&gesture=smile&size=b&img_format=gif" />