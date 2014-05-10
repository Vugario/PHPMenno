<?php

$sql = mysql_query("SELECT * FROM blogs_berichten ORDER BY datum DESC LIMIT 15");

while($row = mysql_fetch_assoc($sql)) {
	$row_member = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
	$aantal_reacties = mysql_num_rows(mysql_query("SELECT reactie_id FROM blogs_reacties WHERE blogs_id='".$row['blogs_id']."'"));
	echo "
	<table width='429' cellpadding='0' cellspacing='0'>
		<tr>
			<td height='22' background='http://simat.ohost.nl/images/top.bmp'><strong><font face='Verdana' size='1'>&nbsp;&nbsp;<a href='?p=blogs&nid=".$row['blogs_id']."'>".stripslashes($row['titel'])."</a></size></strong></td>
		</tr>
		<tr>
			<td><i><font face='Verdana' size='1'>Gepost door <b>".$row_member['gebruikersnaam']."</b> op <b>".$row['datum']."</font></b></i><hr></td>
		</tr>
		<tr>
			<td><font face='Verdana' size='1'>".stripslashes($row['bericht'])."</font></td>
		</tr>
		<tr>
			<td style='text-align: right;'><font face='Verdana' size='1'><a href='?p=blogs&nid=".$row['blogs_id']."'>Lees meer</a> | <a href='?p=blogs&nid=".$row['blogs_id']."'>".$aantal_reacties." Reacties</a></font></td>
		</tr>
	</table><br><br>
	<hr align=\"left\" />";
}
if(mysql_num_rows($sql) == 0) {
	echo "Er zijn geen blogs.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
}

?>