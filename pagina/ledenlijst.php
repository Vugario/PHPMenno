<?php

	$sql = mysql_query("SELECT *,DATE_FORMAT(regdatum, '%d/%m %h:%i') AS datum FROM leden ORDER BY gebruikersnaam ASC");

	echo "
		<table class='data'>
			<tr>
				<th class='ledenlijst'><strong>Gebruikersnaam</strong></td>
				<th class='ledenlijst'><strong>Lid sinds</strong></td>
				<th class='ledenlijst'><strong>Profiel</strong></td>
			</tr>
	";

	$i = 0;
	while($row = mysql_fetch_assoc($sql)) {
		$i ^= 1;//laten staan: nodig voor rij-om-rij kleur :)
		$sql_profiel = mysql_query("SELECT profiel_id FROM profiel WHERE member_id='".$row['member_id']."'");
		if(mysql_num_rows($sql_profiel) == 1) {
			$profiel = "Ja";
		}else{
			$profiel = "Nee";
		}
		echo "
			<tr class='row" . $i . "'>
				<td><a href='profiel/gebruiker/?user=".$row['member_id']."'>".ucfirst(stripslashes(substr($row['gebruikersnaam'],0,25)))."</a></td>
				<td width='100'>".$row['datum']."</td>
				<td>".$profiel."</td>
			</tr>";
	}
	echo "</table>";
	
?>