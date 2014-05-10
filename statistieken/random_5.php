<?php

$sql_laatste_5_members = mysql_query("SELECT member_id,gebruikersnaam FROM leden ORDER BY RAND() LIMIT 5");
echo "<strong>5 Random gebruikers</strong><br />";
while($row = mysql_fetch_assoc($sql_laatste_5_members)) {
	echo "&raquo; <a href='?p=profiel&mid=".$row['member_id']."'>".stripslashes(substr($row['gebruikersnaam'],0,25))."</a><br>";
}

?>