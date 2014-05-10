<center>
	<?php
	
		$sql_administrators = mysql_query("SELECT level,gebruikersnaam,member_id FROM leden WHERE level = 6");
		echo "<strong>Administrators</strong><br />";
		while($row = mysql_fetch_assoc($sql_administrators)) {
			echo "
				<a href='profiel/gebruiker/".$row['gebruikersnaam']."'><img src='http://www.habbo.nl/habbo-imaging/avatarimage?user=".$row['gebruikersnaam']."&action=wav&crr=1&direction=3&head_direction=3&gesture=sml' border='0' alt='".$row['gebruikersnaam']."'></a>
				<br />
			";
		}
	?>
	<?php
	
		$sql_nieuwsreporters = mysql_query("SELECT level,gebruikersnaam,member_id FROM leden WHERE level = 2");
		while($row = mysql_fetch_assoc($sql_nieuwsreporters)) {
			echo "<strong>Nieuwsreporters</strong><br />";
			echo "
				<a href='profiel/gebruiker/?user=".$row['member_id']."'><img src='http://www.habbo.nl/habbo-imaging/avatarimage?user=".$row['gebruikersnaam']."&action=wav&crr=1&direction=3&head_direction=3&gesture=sml' border='0' alt='".$row['gebruikersnaam']."'></a>
				<br />
			";
		}
	?>
</center>