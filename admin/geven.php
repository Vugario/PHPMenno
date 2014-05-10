<?php

if(isset($_SESSION['admin'])) {
	if(isset($_POST['submit']) && !empty($_POST['soort']) && !empty($_POST['member_id'])) {
		$soort = mysql_real_escape_string($_POST['soort']);
		if($_POST['soort'] == "badges") {
			$id = mysql_real_escape_string($_POST['badge_id']);
			$soort1 = "badge";
		}else{
			$id = mysql_real_escape_string($_POST['rang_id']);
			$soort1 = "rang";
		}
		$member_id = mysql_real_escape_string($_POST['member_id']);
		mysql_query("INSERT INTO gekochte_".$soort." (".$soort1."_id,member_id) VALUES ('".$id."','".$member_id."')");
		if(mysql_error() == "") {
			echo "<strong>De ".$soort." is succesvol uitgedeeld.</strong>";
		}else{
			echo "<strong>er is iets vreemds aan de hand.</strong><br />Misschien heeft deze gebruiker al deze rang/badge.<br />";
		}
	}else{
		?>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_geven" method="post">
			<table>
				<tr>
					<td>Wat wil je geven</td>
					<td><select name="soort">
							<option value="badges">Badge</option>
							<option value="rangen">Rang</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Kies badge of rang</td>
					<td>badge:<br />
							<select name="badge_id">
							<?php
							$sql = mysql_query("SELECT badge_id,titel FROM shop_badges");
							while($row = mysql_fetch_assoc($sql)) {
								echo "<option value=\"".$row['badge_id']."\">".$row['titel']."</option>";
							}
							?>
							</select><br />rang:<br />
							<select name="rang_id">
							<?php
							$sql = mysql_query("SELECT rang_id,titel FROM shop_rangen");
							while($row = mysql_fetch_assoc($sql)) {
								echo "<option value=\"".$row['rang_id']."\">".$row['titel']."</option>";
							}
							?>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td>Aan wie?</td>
					<td>
						<select name="member_id">
						<?php $sql = mysql_query("SELECT gebruikersnaam,member_id FROM leden ORDER BY gebruikersnaam ASC");
						while($row = mysql_fetch_assoc($sql)) {
							echo "<option value=\"".$row['member_id']."\">".$row['gebruikersnaam']."</option>";
						}
						?>
						</select>
					</td>
				<tr>
					<th colspan="2"><input type="submit" name="submit" value="Geven!" /></th>
				</tr>
			</table>
		</form>
		<?php
	}
}else{
	echo "Ben jij een admin?<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>