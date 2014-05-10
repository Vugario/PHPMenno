<?php

if(isset($_SESSION['admin']) || isset($_SESSION['moderator'])) {
	if(isset($_POST['sturen'])) {
		mysql_query("INSERT INTO infracties (member_id,reden,datum,door) VALUES ('".$_POST['member_id']."','".nl2br($_POST['reden'])."',NOW(),'".$_POST['door']."')");
		mysql_query("UPDATE leden SET infractie=infractie+1 WHERE member_id=".$_POST['member_id']."");
		mysql_query("INSERT INTO alert (member_id,reden,gelezen,datum,door) VALUES ('".$_POST['member_id']."','<b>Je hebt een infractie ontvangen met de volgende rede:</b> ".nl2br($_POST['reden'])."','Nee',NOW(),'".$_POST['door']."')");
		echo "De infractie is verzonden.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
	}else{
		?>
		<form method="post">
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
					<td>Tekst in infractie</td>
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