<?php
if($instellingen['berichten'] == "uit") {
	echo "Berichten versturen staat uit.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
}else{
	echo "<center>
	<a href='?p=bericht&a=bekijken'>Inbox</a> | 
	<a href='?p=bericht&a=versturen'>Bericht Versturen</a> | 
	<a href='?p=bericht&a=bekijken&s=verzonden'>Verzonden Berichten</a> | 
	<a href='?p=bericht&a=bekijken&s=opgeslagen'>Opgeslagen Berichten</a> |
	<br><br>";
	
	if(isset($_GET['a'])) {
		if($_GET['a'] == "versturen") {
			if(isset($_POST['versturen']) && !empty($_POST['aan']) && !empty($_POST['titel']) && !empty($_POST['bericht'])) {
				$aan = mysql_real_escape_string(substr($_POST['aan'],0,255));
				$sql = mysql_query("SELECT member_id FROM leden WHERE gebruikersnaam='".$aan."'");
				if(mysql_num_rows($sql) == 1) {
					$row = mysql_fetch_assoc($sql);
					
					echo $pb->berichtVersturen($row['member_id'],$_POST['titel'],$_POST['bericht']);
				}else{
					echo "Deze gebruikersnaam is niet bekend bij onze leden.";
				}
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=bericht&a=versturen" method="post">
					<table>
						<tr>
							<td>Aan</td>
							<td><input type="text" name="aan"
								<?php if(isset($_GET['aan'])) { echo "value='".$_GET['aan']."'"; }elseif(isset($_POST['aan'])) { echo "value=\"".$_POST['aan']."\""; } ?> maxlength="255" /></td>
						</tr>
						<tr>
							<td>Onderwerp</td>
							<td><input <?php if(isset($_POST['titel'])) { echo "value='".$_POST['titel']."'"; } ?> type="text" name="titel" maxlength="255" /></td>
						</tr>
						<tr>
							<td valign="top">Bericht</td>
							<td><textarea name="bericht" style="width:200px; height:200px;"><?php if(isset($_POST['bericht'])) { echo $_POST['bericht']; } ?></textarea></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="versturen" value="Versturen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "verwijderen") {
			if(isset($_POST['bericht_id']) && isset($_POST['verwijderen'])) {
				echo $pb->berichtVerwijderen($_POST['bericht_id']);
			}else{
				?>
					<table>
						<?php
						$sql = mysql_query("SELECT titel,bericht_id FROM berichten WHERE aan='".$_SESSION['id']."'");
						while($row = mysql_fetch_assoc($sql)) {
							echo "
							<tr>
								<td>".htmlspecialchars($row['titel'])."</td>
								<td>
									<form action='".$_SERVER['PHP_SELF']."?p=bericht&a=verwijderen' method='post'>
										<input type='hidden' name='bericht_id' value='".$row['bericht_id']."' />
										<input type='submit' name='verwijderen' value='Verwijderen' />
									</form>
								</td>
							</tr>";
						}
						?>
					</table>
				<?php
			}
		}elseif($_GET['a'] == "opslaan") {
			if(isset($_POST['bericht_id']) && isset($_POST['opslaan'])) {
				echo $pb->berichtOpslaan($_POST['bericht_id']);
			}else{
				?>
					<table>
						<?php
						$sql = mysql_query("SELECT titel,bericht_id FROM berichten WHERE aan='".$_SESSION['id']."'");
						while($row = mysql_fetch_assoc($sql)) {
							echo "
							<tr>
								<td>".htmlspecialchars($row['titel'])."</td>
								<td>
									<form action='".$_SERVER['PHP_SELF']."?p=bericht&a=opslaan' method='post'>
										<input type='hidden' name='bericht_id' value='".$row['bericht_id']."' />
										<input type='submit' name='opslaan' value='Opslaan' />
									</form>
								</td>
							</tr>";
						}
						?>
					</table>
				<?php
			}
		}elseif($_GET['a'] == "opslaan_verwijderen") {
			if(isset($_POST['opgeslagen_id']) && isset($_POST['verwijderen'])) {
				echo $pb->berichtOpslaanVerwijderen($_POST['opgeslagen_id']);
			}else{
				?>
					<table>
						<?php
						$sql = mysql_query("SELECT titel,opgeslagen_id FROM opgeslagen_berichten WHERE aan='".$_SESSION['id']."'");
						while($row = mysql_fetch_assoc($sql)) {
							echo "
							<tr>
								<td>".htmlspecialchars($row['titel'])."</td>
								<td>
									<form action='".$_SERVER['PHP_SELF']."?p=bericht&a=opslaan_verwijderen' method='post'>
										<input type='hidden' name='opgeslagen_id' value='".$row['opgeslagen_id']."' />
										<input type='submit' name='verwijderen' value='Verwijderen' />
									</form>
								</td>
							</tr>";
						}
						?>
					</table>
				<?php
			}
		}elseif($_GET['a'] == "bekijken") {
			if(isset($_GET['s'])) {
				if($_GET['s'] == "opgeslagen") {
					$sql = mysql_query("SELECT * FROM berichten_opgeslagen WHERE aan='".$_SESSION['id']."'");
					if(mysql_num_rows($sql) == 0) {
						echo "Je hebt geen opgeslagen berichten.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						echo "<table width='300'>
							<tr>
								<td><strong>Door</strong></td>
								<td><strong>Titel</strong></td>
								<td><strong>Bekijken</strong></td>
							</tr>";
						while($row = mysql_fetch_assoc($sql)) {	
							$sql_door = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['door']."'");
							$row_door = mysql_fetch_assoc($sql_door);	
							echo "
								<tr>
									<td>".htmlspecialchars($row_door['gebruikersnaam'])."</td>
									<td>".htmlspecialchars($row['titel'])."</td>
									<td><a href='?p=bericht&bid=".$row['bericht_id']."'>Bekijken</a></td>
								</tr>";
						}
					echo "</table><br />";
					}
				}elseif($_GET['s'] == "verzonden") {
					$sql = mysql_query("SELECT * FROM berichten_verzonden WHERE door='".$_SESSION['id']."'");
					if(mysql_num_rows($sql) == 0) {
						echo "Je hebt geen verzonden berichten.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						echo "<table width='300'>
							<tr>
								<td><strong>Aan</strong></td>
								<td><strong>Titel</strong></td>
								<td><strong>Bekijken</strong></td>
							</tr>";
						while($row = mysql_fetch_assoc($sql)) {	
							$sql_door = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['aan']."'");
							$row_door = mysql_fetch_assoc($sql_door);	
							echo "
								<tr>
									<td>".htmlspecialchars($row_door['gebruikersnaam'])."</td>
									<td>".htmlspecialchars($row['titel'])."</td>
									<td><a href='?p=bericht&bid=".$row['bericht_id']."&s=verzonden'>Bekijken</a></td>
								</tr>";
						}
						echo "</table>";
					}
				}
			}else{
				$sql = mysql_query("SELECT * FROM berichten WHERE aan='".$_SESSION['id']."'");
				if(mysql_num_rows($sql) == 0) {
					echo "Je hebt geen berichten.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
				}else{
					echo "<table width='300'>
							<tr>
								<td><strong>Door</strong></td>
								<td><strong>Titel</strong></td>
								<td><strong>Bekijken</strong></td>
							</tr>";
					while($row = mysql_fetch_assoc($sql)) {	
						$sql_door = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['door']."'");
						$row_door = mysql_fetch_assoc($sql_door);	
						echo "
							<tr>
								<td>".htmlspecialchars($row_door['gebruikersnaam'])."</td>
								<td>".htmlspecialchars($row['titel'])."</td>
								<td><a href='?p=bericht&bid=".$row['bericht_id']."'>Bekijken</a></td>
							</tr>";
					}
					echo "</table><br /><a href='?p=bericht&a=verwijderen'>Verwijder berichten</a>";
				}
			}
		}else{ // hier kan je een nieuwe }elseif($_GET['a'] == "LALALA") {
			echo "Deze actie wordt niet herkend.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}
	}elseif(isset($_GET['bid'])) {
		if(isset($_GET['s']) && $_GET['s'] == "verzonden") {
			$bid = mysql_real_escape_string(substr($_GET['bid'],0,30));
			$sql = mysql_query("SELECT * FROM berichten WHERE bericht_id='".$bid."' AND door='".$_SESSION['id']."'")or die (mysql_error());
			if(mysql_num_rows($sql) == 1) {
				$row = mysql_fetch_assoc($sql);
				$sql_door = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['aan']."'");
				$row_door = mysql_fetch_assoc($sql_door);
				echo "
				<table>
					<tr>
						<td><strong>Aan</strong></td>
						<td>".htmlspecialchars($row_door['gebruikersnaam'])."</td>
					</tr>
					<tr>
						<td><strong>Titel</strong></td>
						<td>".htmlspecialchars($row['titel'])."</td>
					</tr>
						<td valign='top'><strong>Bericht</strong></td>
						<td>".htmlspecialchars($row['bericht'])."</td>
					</tr>
				</table>";
			}
		}else{
		$bid = mysql_real_escape_string(substr($_GET['bid'],0,30));
		$sql = mysql_query("SELECT * FROM berichten WHERE bericht_id='".$bid."' AND aan='".$_SESSION['id']."'")or die (mysql_error());
		if(mysql_num_rows($sql) == 1) {
			$row = mysql_fetch_assoc($sql);
			$sql_door = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['door']."'");
			$row_door = mysql_fetch_assoc($sql_door);
			echo "
			<table>
				<tr>
					<td><strong>Door</strong></td>
					<td>".htmlspecialchars($row_door['gebruikersnaam'])."</td>
				</tr>
				<tr>
					<td><strong>Titel</strong></td>
					<td>".htmlspecialchars($row['titel'])."</td>
				</tr>
					<td valign='top'><strong>Bericht</strong></td>
					<td>".htmlspecialchars($row['bericht'])."</td>
				</tr>
			</table>";
		}
		}
	}else{
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=?p=bericht&a=bekijken\" />";
	}
	echo "</center>";
}
?>