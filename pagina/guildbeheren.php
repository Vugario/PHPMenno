<?php

if(isset($_SESSION['id'])) {
	if(isset($_GET['a']) && $_GET['a'] == "wijzigen" && isset($_GET['id'])) {
		if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['rid']) && !empty($_GET['rid'])) {
			$sql_check = mysql_query("SELECT * FROM guild_leden WHERE id='".$_SESSION['id']."'");
			$row_check = mysql_fetch_assoc($sql_check);
			$sql_rang = mysql_query("SELECT * FROM guild_rangen WHERE id='".$row_check['rang_id']."'");
			$row_rang = mysql_fetch_assoc($sql_rang);
			if($row_rang['naam'] == 'Guild master') {
				if($row_check['id'] == $_SESSION['id']) {
					echo "Je kan je eigen rang niet aanpassen.<br />Je moet Guild master blijven.<br /><br />";
				}else{
					$id = mysql_real_escape_string(substr($_GET['id'],0,30));
					$rid = mysql_real_escape_string(substr($_GET['rid'],0,30));
					
					$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
					if(mysql_num_rows($sql) ==  1) {
						$row = mysql_fetch_assoc($sql);
						$sql_rangen = mysql_query("SELECT * FROM guild_rangen WHERE guild_id='".$row['id']."' AND id='".$rid."'");
						if(mysql_num_rows($sql) ==  1) {
							$row_rangen = mysql_fetch_assoc($sql_rangen);
							$sql_leden = mysql_query("SELECT * FROM guild_leden WHERE guild_id='".$row['id']."' AND id='".$id."'");
							if(mysql_num_rows($sql) ==  1) {
								mysql_query("UPDATE guild_leden SET rang_id='".$rid."' WHERE guild_id='".$row['id']."' AND id='".$id."'");
								echo mysql_error();
								echo "Succes";
							}else{
								echo "Dit lid zit niet in jou guild.";
							}
						}else{
							echo "Deze rang is niet van jou guild.";
						}
					}else{
						echo "Je hebt geen guild.";
					}
				}
			}
		}
	}
		?>
		<?php
	$sql_guild = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
	if(mysql_num_rows($sql_guild) ==  1) {
		$row_guild = mysql_fetch_assoc($sql_guild);
		echo "
		<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
			<tr>
				<td><strong>#</strong></td>
				<td><strong>Naam</strong></td>
				<td><strong>Rang</strong></td>
				<td><strong>Actie</strong></td>
			</tr>";
		$i = 1;
		$sql = mysql_query("SELECT * FROM guild_leden WHERE guild_id='".$row_guild['id']."'");
		while($row = mysql_fetch_assoc($sql)) {
			echo '<form action="?p=guildbeheren&a=wijzigen" method="GET">
			<input type="hidden" name="p" value="guildbeheren">
			<input type="hidden" name="a" value="wijzigen">
			<input type="hidden" name="id" value="'.$row['id'].'">';
			$sql_member = mysql_query("SELECT * FROM leden WHERE member_id='".$row['member_id']."'");
			$row_member = mysql_fetch_assoc($sql_member);
			$sql_rang = mysql_query("SELECT * FROM guild_rangen WHERE id='".$row['rang_id']."'");
			$row_rang = mysql_fetch_assoc($sql_rang);
			echo "
			<tr>
				<td>".$i."</td>
				<td>".$row_member['gebruikersnaam']."</td>
				<td>".$row_rang['naam']."</td>
				<td>
					<select name='rid'>";
					$sql_r = mysql_query("SELECT * FROM guild_rangen WHERE guild_id='".$row_guild['id']."'");
					while($row_r = mysql_fetch_assoc($sql_r)) {
						echo "<option ";
						if($row_r['id'] == $row['rang_id']) { echo "selected='selected'"; } echo " value='".$row_r['id']."'>".$row_r['naam']."</option>";
					}
				echo "</select> &nbsp;&nbsp;<input type='submit' name='submit' value='wijzigen'></td>
			</tr>";
			$i++;
		}
		echo "</table>";
	}
}
?>