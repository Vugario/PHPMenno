<?php

if(isset($_SESSION['admin']) || isset($_SESSION['nieuwsreporter']) || isset($_SESSION['forumbeheerder'])) {
	if(isset($_POST['sturen'])) {
		if($_POST['iedereen'] == "ja") {
			$sql = mysql_query("SELECT member_id FROM leden");
			while($row = mysql_fetch_assoc($sql)) {
				mysql_query("INSERT INTO alert (member_id,reden,gelezen,datum,door) VALUES ('".$row['member_id']."','".nl2br($_POST['reden'])."','Nee',NOW(),'".$_POST['door']."')");
			}
			echo "De alert is succesvol naar iedereen verstuurd.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
			mysql_query("INSERT INTO alert (member_id,reden,gelezen,datum,door) VALUES ('".$_POST['member_id']."','".nl2br($_POST['reden'])."','Nee',NOW(),'".$_POST['door']."')");
			echo "De alert is verstuurd.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}
	}else{
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_alert" method="post">
			<input type="hidden" name="door" value="<?php echo $_SESSION['gebruikersnaam']; ?>" />
			<table width="400">
				<tr>
					<td>Lid</td>
					<td>
						<?php 
							if(isset($_GET['mid']) && isset($_GET['naam'])) {
								echo "<input type=\"hidden\" value=\"".$_GET['mid']."\" name=\"member_id\">".$_GET['naam']."";
							}else{
								?>
								<select name="member_id">
									<?php
									$sql = mysql_query("SELECT * FROM leden");
									while($row = mysql_fetch_assoc($sql)) {
										echo "<option value=\"".$row['member_id']."\">".$row['gebruikersnaam']."</option>";
									}
									?>
								</select>
							<?php
							}
							?>
					</td>
				</tr>
				<tr>
					<td>OF stuur naar iedereen</td>
					<td><input type="radio" name="iedereen" value="ja" />Ja <input type="radio" name="iedereen" checked="checked" value="nee" />Nee</td>
				</tr>
				<tr>
					<td>Tekst in alert</td>
					<td><textarea name="reden" cols="30" rows="10"></textarea></td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="sturen" value="Sturen" /></th>
				</tr>
			</table>
		</form>
		<?php
	}
}

?>