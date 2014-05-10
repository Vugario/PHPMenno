<?php

if(isset($_SESSION['id'])) {
	echo "Hier vind je een lijst van alle guildleden.<br><br><table width='100%'>
			<tr>
				<td><strong>#</strong></td>
				<td><strong>Gebruikersnaam</strong></td>
				<td><strong>Rang</strong></td>
			</tr>";
	$i = 1;
	$sql_check = mysql_query("SELECT * FROM guild_leden WHERE member_id='".$_SESSION['id']."'");
	while($row = mysql_fetch_assoc($sql_check)) {
		$sql_member = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'");
		$row_member = mysql_fetch_assoc($sql_member);
		$sql_rang = mysql_query("SELECT naam FROM guild_rangen WHERE id='".$row['rang_id']."'");
		$row_rang = mysql_fetch_assoc($sql_rang);
		echo "
		<tr>
			<td>".$i."</td>
			<td>".$row_member['gebruikersnaam']."</td>
			<td>".$row_rang['naam']."</td>
		</tr>";
	}
	echo "</table>";
}
?>