<?php

$sql = mysql_query("SELECT *,DATE_FORMAT(regdatum, '%d/%m %h:%i') AS datum FROM leden ORDER BY gebruikersnaam ASC");

echo "
	<table width='100%' cellspacing='0' cellpadding='0'>
		<tr>
			<td style='border-bottom:#000000 solid 1px;'><strong>#</strong></td>
			<td style='border-bottom:#000000 solid 1px;'><strong>Gebruikersnaam</strong></td>
			<td style='border-bottom:#000000 solid 1px;'><strong>Lid sinds</strong></td>
			<td style='border-bottom:#000000 solid 1px;'><strong>Punten</strong></td>
			<td style='border-bottom:#000000 solid 1px;'><strong>Munten</strong></td>
			<td style='border-bottom:#000000 solid 1px;'><strong>Rang</strong></td>
		</tr>";
$i = 1;
while($row = mysql_fetch_assoc($sql)) {
	$sql_profiel = mysql_query("SELECT profiel_id FROM profiel WHERE member_id='".$row['member_id']."'");
	if(mysql_num_rows($sql_profiel) == 1) {
		$profiel = "ja";
	}else{
		$profiel = "nee";
	}
	echo "
		<tr>
			<td>".$i."</td>
			<td><a href='?p=profiel&mid=".$row['member_id']."'>".stripslashes(substr($row['gebruikersnaam'],0,25))."</a></td>
			<td width='100'>".$row['datum']."</td>
			<td>".$row['punten']."</td>
			<td>".$row['muntjes']."</td>
			<td>".$row['rang']."</td>
		</tr>";
	$i++;
}
echo "</table>";
?>