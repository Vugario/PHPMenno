<font color="orange">Admin</font><br />
<font color="lightgreen">Forum Beheerder</font><br />
<font color="blue">Nieuws Reporter</font><br />
<br />
<?
function rang($level,$user){
	if($level == 6){
		return("<font color='orange'>".$user."</font>");
	} elseif($level == 3){
		return("<font color='lightgreen'>".$user."</font>");
	} elseif($level == 2){
		return("<font color='blue'>".$user."</font>");
	} else {
		return($user);
	}
}

$sql = "SELECT member_id,gebruikersnaam,level FROM leden WHERE DATE_SUB(NOW(),INTERVAL 5 MINUTE) <= lastonline ORDER BY gebruikersnaam ASC";
$query = mysql_query($sql);
echo mysql_error();
$tellen = mysql_num_rows($query);

while($rij = mysql_fetch_array($query)) {
	$user = $rij['gebruikersnaam'];
	$level = $rij['level'];
	echo "» <a href=\"?p=profiel&mid=".$rij['member_id']."\">".rang($level,$user)."</a><br>";
$i++;
	}
if($tellen == 0) {
	echo "Er zijn geen online gebruikers.";
}
echo '<br>Totaal: ' . $tellen . '<br><br>';
?>