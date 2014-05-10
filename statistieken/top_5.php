<?php

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