<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?><center>
<?
$sql_vrienden = mysql_query("SELECT * FROM vrienden WHERE member_id='".$_SESSION['id']."' AND actief='actief'");
$sql_vv = mysql_query("SELECT * FROM vrienden WHERE member_id='".$_SESSION['id']."' AND actief='dood'");
echo "
	<table border='0' cellpadding='0' cellspacing='0' width='300'>
		<tr>
			<th colspan='2'><h2>Vrienden</h2></th>
		</tr>";
while($row_vrienden = mysql_fetch_assoc($sql_vrienden)) {
	$row_vrienden_naam = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row_vrienden['vriend_id']."'"));
	echo "
		<tr>
			<td><a href='?p=profiel&mid=".$row_vrienden['vriend_id']."'>".$row_vrienden_naam['gebruikersnaam']."</a></td>
			<td width='75'><input type=\"Button\" value=\"Verwijder\" class=\"submit\" style=\"width: 75px;\" onClick=\"document.location.href='?p=vriend_beheren&vid=".$row_vrienden['vriend_id']."&a=verwijderen'\"></td>
		</tr>";
}

echo "
	</table>";
if(mysql_num_rows($sql_vrienden) == 0) {
	echo "Je hebt nog geen vrienden gemaakt.<br />";
}
	echo"<br /><br />";
echo "
	<table border='0' cellpadding='0' cellspacing='0' width='300'>
		<tr>
			<th colspan='3'><h2>VV's</h2></th>
		</tr>";
while($row_vv = mysql_fetch_assoc($sql_vv)) {
	$row_vv_naam = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row_vv['vriend_id']."'"));
	echo "
		<tr>
			<td><a href='?p=profiel&mid=".$row_vv['vriend_id']."'>".$row_vv_naam['gebruikersnaam']."</a></td>
			<td width='75'><input type=\"Button\" value=\"Accepteren\" class=\"submit\" style=\"width: 75px;\" onClick=\"document.location.href='?p=vriend_beheren&vid=".$row_vv['vriend_id']."&a=accepteren'\"></td>
			<td width='75'><input type=\"Button\" value=\"Verwijder\" class=\"submit\" style=\"width: 75px;\" onClick=\"document.location.href='?p=vriend_beheren&vid=".$row_vv['vriend_id']."&a=verwijderen'\"></td>
		</tr>";
}

echo "
	</table>";
if(mysql_num_rows($sql_vv) == 0) {
	echo "Je hebt nog geen vrienden verzoeken gekregen.<br />";
}
?>
</center>