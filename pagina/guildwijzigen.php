<?php

if(isset($_SESSION['id'])) {
	$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
	if(mysql_num_rows($sql) ==  0) {
		echo "Je hebt geen guild in je bezit.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
	}else{
		if(isset($_POST['submit']) && !empty($_POST['rang2']) && !empty($_POST['rang3']) && !empty($_POST['rang4']) && !empty($_POST['rang5']) && !empty($_POST['beschrijving'])) {
			$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
			if(mysql_num_rows($sql) ==  1) {
				$row = mysql_fetch_assoc($sql);
				$rang1 = "Guild master";
				$rang2 = mysql_real_escape_string(substr($_POST['rang2'],0,255));
				$rang3 = mysql_real_escape_string(substr($_POST['rang3'],0,255));
				$rang4 = mysql_real_escape_string(substr($_POST['rang4'],0,255));
				$rang5 = mysql_real_escape_string(substr($_POST['rang5'],0,255));
				$beschrijving = mysql_real_escape_string($_POST['beschrijving']);
				mysql_query("UPDATE guild SET beschrijving='".$beschrijving."' WHERE id='".$row['id']."'");
				mysql_query("INSERT INTO guild_info (guild_id,info,datum) VALUES ('".$guild_id."','De guild gegevens zijn gewijzigd.',NOW())");
				$sql = mysql_query("SELECT * FROM guild_rangen WHERE guild_id='".$row['id']."' ORDER BY id ASC");
				$i = 1;
				while($row = mysql_fetch_assoc($sql)) {
					if($i == 1) {
						$rang = $rang1;
					}
					if($i == 2) {
						$rang = $rang2;
					}
					if($i == 3) {
						$rang = $rang3;
					}
					if($i == 4) {
						$rang = $rang4;
					}
					if($i == 5) {
						$rang = $rang5;
					}
					mysql_query("UPDATE guild_rangen SET naam='".$rang."' WHERE id='".$row['id']."'");
					$i++;
				}
				if(mysql_error() == "") {
					echo "Je guild is succesvol gewijzigd.<br><br>";
				}else{
					echo "Er is een onbekende fout opgetreden.<br /><br>";
				}
			}
		}
			$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
			$row = mysql_fetch_assoc($sql);
			$sql_rangen = mysql_query("SELECT * FROM guild_rangen WHERE guild_id='".$row['id']."'");
			?>
			<form action="" method="post"><h3><?php echo $row['naam']; ?></h3>
				<table width="350">
					<?php
					$i = 1;
					while($row_rangen = mysql_fetch_assoc($sql_rangen)) {
						if($row_rangen['naam'] != "Guild master") { ?>
						<tr>
							<td>Rang <?php echo $i; ?></td>
							<td><input type="text" name="rang<?php echo $i; ?>" value="<?php echo stripslashes($row_rangen['naam']); ?>" maxlength="255" /></td>
						</tr>
						<?php
						}else{
							?>
							<tr>
								<td>Rang <?php echo $i; ?></td>
								<td><?php echo $row_rangen['naam']; ?></td>
							</tr>
							<?php
						}
						$i++;
					}
					?>
					<tr>
						<td valign="top">Beschrijving</td>
						<td><textarea cols="45" rows="12" name="beschrijving"><?php echo stripslashes($row['beschrijving']); ?></textarea></td>
					</tr>
					<tr>
						<th colspan="3"><input class="submit" type="submit" name="submit" value="Wijzig Guild"></th>
					</tr>
				</table>
			</form>
			<?php
	}
}else{
	echo "Je moet ingelogd zijn voor deze pagina.";
}
?>