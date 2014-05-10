<?php

$sql = mysql_query("SELECT * FROM blogs_berichten ORDER BY datum DESC LIMIT 15");

while($row = mysql_fetch_assoc($sql)) {
	$row_member = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
	$aantal_reacties = mysql_num_rows(mysql_query("SELECT reactie_id FROM blogs_reacties WHERE blogs_id='".$row['blogs_id']."'"));
	$bericht = $row['bericht'];
	$bericht = str_replace("<script","",$bericht);
	$bericht = str_replace("<javascript","",$bericht);
	$bericht = str_replace("noscript","",$bericht);
	$bericht = str_replace("alert(","",$bericht);
	$bericht = str_replace("window.","",$bericht);
	echo "
	<table width='100%' cellpadding='0' cellspacing='0'>
		<tr>
			<td><strong>&nbsp;&nbsp;<a href='?p=blogs&nid=".$row['blogs_id']."'>".stripslashes($row['titel'])."</a></strong></td>
		</tr>
		<tr>
			<td><i>Gepost door <b>".$row_member['gebruikersnaam']."</b> op <b>".$row['datum']."</b></i><hr></td>
		</tr>
		<tr>
			<td>".stripslashes($bericht)."</td>
		</tr>
		<tr>
			<td style='text-align: right;'><a href='?p=blogs&nid=".$row['blogs_id']."'>Lees meer</a> | <a href='?p=blogs&nid=".$row['blogs_id']."'>".$aantal_reacties." Reacties</a></td>
		</tr>
	</table><br><br>
	<hr align=\"left\" />";
}
if(mysql_num_rows($sql) == 0) {
	echo "Er zijn geen blogs.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
}

?>