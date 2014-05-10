<?php

$sql_laatste_5_members = mysql_query("SELECT gebruikersnaam,member_id FROM leden ORDER BY regdatum DESC LIMIT 5");
echo "<strong>Laatste 5 gebruikers</strong><br />";
while($row = mysql_fetch_assoc($sql_laatste_5_members)) {
	echo "&raquo; <a href='?p=profiel&mid=".$row['member_id']."'>".stripslashes(substr($row['gebruikersnaam'],0,25))."</a><br>";
}

?>