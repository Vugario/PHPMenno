<?php

$sql_aantal_members = mysql_query("SELECT member_id FROM leden");
$aantal_members = mysql_num_rows($sql_aantal_members);

// 5 laatst geregistreerde gebruikers
$sql_laatste_5_members = mysql_query("SELECT gebruikersnaam,member_id FROM leden ORDER BY regdatum DESC LIMIT 5");
echo "<strong>Laatste 5 gebruikers</strong><br />";
while($row = mysql_fetch_assoc($sql_laatste_5_members)) {
	echo "&raquo; <a href='?p=profiel&mid=".$row['member_id']."'>".stripslashes(substr($row['gebruikersnaam'],0,25))."</a><br>";
}
echo "<br /><strong>Aantal Leden</strong><br />";
echo $aantal_members." Gebruikers.<br /><br />";


/// 5 random gekozen gebruikers
$sql_laatste_5_members = mysql_query("SELECT member_id,gebruikersnaam FROM leden ORDER BY RAND() LIMIT 5");
echo "<strong>5 Random gebruikers</strong><br />";
while($row = mysql_fetch_assoc($sql_laatste_5_members)) {
	echo "&raquo; <a href='?p=profiel&mid=".$row['member_id']."'>".stripslashes(substr($row['gebruikersnaam'],0,25))."</a><br>";
}


/// top 5 gebruikers
$sql_top_5_members = mysql_query("SELECT gebruikersnaam,member_id,punten FROM leden ORDER BY punten DESC LIMIT 5")or die (mysql_error());
echo "<br /><br /><strong>Top 5 Gebruikers</strong><br />";
echo "<table>";
while($row = mysql_fetch_assoc($sql_top_5_members)) {
	echo "
	<tr>
		<td>&raquo; <a href='?p=profiel&mid=".$row['member_id']."'>".stripslashes(substr($row['gebruikersnaam'],0,25))."</a></td>
		<td>".$row['punten']." Punten</td>
	</tr>";
}
echo "</table>";

?>