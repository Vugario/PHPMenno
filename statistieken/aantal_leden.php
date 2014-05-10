<?php
$sql_aantal_members = mysql_query("SELECT member_id FROM leden");
$aantal_members = mysql_num_rows($sql_aantal_members);

echo "<br /><strong>Aantal Leden</strong><br />";
echo $aantal_members." Gebruikers.<br /><br />";

?>