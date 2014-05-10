<?php

$sql = mysql_query("SELECT * FROM nieuws_berichten ORDER BY datum DESC LIMIT 6");

while($row = mysql_fetch_assoc($sql)) {
	$row_member = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
	$aantal_reacties = mysql_num_rows(mysql_query("SELECT reactie_id FROM nieuws_reacties WHERE nieuws_id='".$row['nieuws_id']."'"));
	echo "
	<table>
		<tr>
			<td><strong><a href='?p=nieuws&nid=".$row['nieuws_id']."'>".stripslashes($row['titel'])."</a></strong></td>
		</tr>
		<tr>
			<td><i>Gepost door : ".$row_member['gebruikersnaam']." op ".$row['datum']."</i></td>
		</tr>
		<tr>
			<td>".stripslashes(htmlspecialchars($row['bericht']))."</td>
		</tr>
		<tr>
			<td style='text-align: right;'><a href='?p=nieuws&nid=".$row['nieuws_id']."'>Lees meer</a> | <a href='?p=nieuws&nid=".$row['nieuws_id']."'>".$aantal_reacties." Reacties</a></td>
		</tr>
	</table><br><br>
	<hr align=\"left\" />";
}
if(mysql_num_rows($sql) == 0) {
	echo "Er zijn geen nieuws berichten gevonden.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
}

?>