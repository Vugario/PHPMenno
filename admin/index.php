<br />
<?php

if(isset($_SESSION['admin'])) {
	if(isset($_GET['a'])) {
		if($_GET['a'] == "instellingen") {
			if(isset($_POST['aanpassen'])) {
				$shop = mysql_real_escape_string(substr($_POST['shop'],0,255));
				$berichten = mysql_real_escape_string(substr($_POST['berichten'],0,255));
				$poll = mysql_real_escape_string(substr($_POST['poll'],0,255));
				$gastenboek = mysql_real_escape_string(substr($_POST['gastenboek'],0,255));
				$stemmen = mysql_real_escape_string(substr($_POST['stemmen'],0,255));
				$status = mysql_real_escape_string(substr($_POST['status'],0,255));
				$meubi = mysql_real_escape_string(substr($_POST['meubi'],0,255));
				$habbo_gegevens = mysql_real_escape_string(substr($_POST['habbo_gegevens'],0,255));
				$avatar_habbo = mysql_real_escape_string(substr($_POST['avatar_habbo'],0,255));
				mysql_query("UPDATE instellingen SET meubi='".$meubi."',habbo_gegevens='".$habbo_gegevens."',avatar_habbo='".$avatar_habbo."',shop='".$shop."',status='".$status."',berichten='".$berichten."',stemmen='".$stemmen."',poll='".$poll."',gastenboek='".$gastenboek."' WHERE instellingen_id='1'");
				if(mysql_error() == "") {
					echo "De instellingen zijn succesvol doorgevoerd.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}else{
					echo "Er is iets niet helemaal goed gedaan.<br />De volgende error heeft zicht voorgedaan:<br />".mysql_error();
				}
			}else{
				$sql = mysql_query("SELECT * FROM instellingen WHERE instellingen_id='1'");
				$row =  mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin&a=instellingen" method="post">
					<table>
						<tr>
							<td>Shop</td>
							<td><input type="radio" name="shop" value="aan"
							<?php if($row['shop'] == "aan") { echo 'checked="checked"'; } ?> />Aan <input type="radio" name="shop" value="uit"
							<?php if($row['shop'] == "uit") { echo 'checked="checked"'; } ?>  />Uit</td>
						</tr>
						<tr>
							<td>Meubels</td>
							<td><input type="radio" name="meubi" value="aan"
							<?php if($row['meubi'] == "aan") { echo 'checked="checked"'; } ?> />Aan <input type="radio" name="meubi" value="uit"
							<?php if($row['meubi'] == "uit") { echo 'checked="checked"'; } ?>  />Uit</td>
						</tr>
						<tr>
							<td>Berichten</td>
							<td><input type="radio" name="berichten" value="aan"
							<?php if($row['berichten'] == "aan") { echo 'checked="checked"'; } ?> />Aan <input type="radio" name="berichten" value="uit"
							<?php if($row['berichten'] == "uit") { echo 'checked="checked"'; } ?>  />Uit</td>
						</tr>
						<tr>
							<td>Stemmen</td>
							<td><input type="radio" name="stemmen" value="aan"
							<?php if($row['stemmen'] == "aan") { echo 'checked="checked"'; } ?> />Aan <input type="radio" name="stemmen" value="uit"
							<?php if($row['stemmen'] == "uit") { echo 'checked="checked"'; } ?>  />Uit</td>
						</tr>
						<tr>
							<td>Poll</td>
							<td><input type="radio" name="poll" value="aan"
							<?php if($row['poll'] == "aan") { echo 'checked="checked"'; } ?> />Aan <input type="radio" name="poll" value="uit"
							<?php if($row['poll'] == "uit") { echo 'checked="checked"'; } ?>  />Uit</td>
						</tr>
						<tr>
							<td>Gastenboek</td>
							<td><input type="radio" name="gastenboek" value="aan"
							<?php if($row['gastenboek'] == "aan") { echo 'checked="checked"'; } ?> />Aan <input type="radio" name="gastenboek" value="uit"
							<?php if($row['gastenboek'] == "uit") { echo 'checked="checked"'; } ?>  />Uit</td>
						</tr> 
						<tr>
							<td>Site offline</td>
							<td><input type="radio" name="status" value="aan"
							<?php if($row['status'] == "aan") { echo 'checked="checked"'; } ?> />Nee <input type="radio" name="status" value="uit"
							<?php if($row['status'] == "uit") { echo 'checked="checked"'; } ?>  />Ja</td>
						</tr> 
						<tr>
							<td>Habbo of Avatar op profiel pagina?</td>
							<td><input type="radio" name="avatar_habbo" value="avatar"
							<?php if($row['avatar_habbo'] == "avatar") { echo 'checked="checked"'; } ?> />Avatar <input type="radio" name="avatar_habbo" value="habbo"
							<?php if($row['avatar_habbo'] == "habbo") { echo 'checked="checked"'; } ?>  />Habbo</td>
						</tr> 
						<tr>
							<td>Habbo Gegevens op profiel pagina?</td>
							<td><input type="radio" name="habbo_gegevens" value="aan"
							<?php if($row['habbo_gegevens'] == "aan") { echo 'checked="checked"'; } ?> />Aan <input type="radio" name="habbo_gegevens" value="uit"
							<?php if($row['habbo_gegevens'] == "uit") { echo 'checked="checked"'; } ?>  />Uit</td>
						</tr> 
						<tr>
							<th colspan="2"><input type="submit" name="aanpassen" value="Aanpassen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "verbannen") {
			if(isset($_GET['mid'])) {
				$admin->lidVerbannen($_GET['mid']);
			}else{
				$sql_leden = mysql_query("SELECT * FROM leden");
				echo "<table width=\"700\">
						<tr>
							<td>Gebruikersnaam</td>
							<td>Verbannen</td>
						</tr>";
				while($row_leden = mysql_fetch_assoc($sql_leden)) {
					echo "<tr>
							<td>".$row_leden['gebruikersnaam']."</td>
							<td><a href=\"?p=admin&a=verbannen&mid=".$row_leden['member_id']."\">Verbannen</a></td>
						</tr>";
				}
				echo "</table>";
			}
		}
	}else{
		?>
		<h2>Admin Panel <?php echo $_SESSION['gebruikersnaam']; ?></h2>
		
		&raquo; <a href="?p=admin_gebruikers">Leden Beheren</a><br />
		&raquo; <a href="?p=admin&a=instellingen">Instellingen Veranderen</a><br />
		&raquo; <a href="?p=admin&a=instellingen">Leden Verbannen</a><br />
		&raquo; <a href="?p=admin_berichtenbalk">Berichtenbalk Beheren</a><br />
		&raquo; <a href="?p=admin_alert">Waarschuwingen Geven</a><br />
		&raquo; <a href="?p=admin_nieuws">Nieuws Toevoegen / Beheren</a><br />
		&raquo; <a href="?p=ipban">IP's bannen</a><br />
		&raquo; <a href="?p=admin_shop">Shop items toevoegen/aanpassen</a><br />
		&raquo; <a href="?p=admin_forum">Forum Beheren</a><br />
		&raquo; <a href="?p=admin_cms">Pagina's Beheren</a><br />
		<br />
		&raquo; <a href="?p=beveiligdepagina">Terug naar de site</a><br />
		
	<?php
	}
}else{
	echo "Je bent geen admin.";
}
?>