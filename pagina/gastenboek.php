<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?><?php

if(isset($_SESSION['id'])) {


class gastenboek {
	function gastenboekAanmaken () {
		if(isset($_SESSION['id'])) {
			mysql_query("INSERT INTO gastenboek (member_id) VALUES ('".$_SESSION['id']."')");
			$sql = mysql_query("SELECT gastenboek_id FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
			$row = mysql_fetch_assoc($sql);
			mysql_query("INSERT INTO gastenboek_berichten (gastenboek_id,habbonaam,bericht,datum) VALUES ('".$row['gastenboek_id']."','Systeem','Gefeliciteerd met je gastenboek<br>Dit is het eerste bericht.<br>Je kan deze verwijder via de menulink Gastenboek.<br><br>Groeten, Managment',NOW())");
			if(mysql_error() == "") {
				return "Je gastenboek is succesvol aangemaakt.<br /><a href='?p=profiel&mid=".$_SESSION['id']."'>Bekijk hem hier</a>";
			}else{
				if(eregi("Duplicate",mysql_error())) {
					return "Je hebt al een gastenboek op je profiel.<br />Je kan er natuurlijk maar 2 maken";
				}else{
					return mysql_error();
				}
			}
		}else{
			return "Je bent niet ingelogd";
		}
	}
	function gastenboekBerichttoevoegen ($bericht,$gastenboek_id) {
		$gastenboek_id = mysql_real_escape_string(substr($gastenboek_id,0,255));
		$bericht = mysql_real_escape_string(nl2br($bericht));
		// Spam beveiliging start //
		$timeoutseconds = 300;
		$timestamp = time();
		$timeout = $timestamp-$timeoutseconds;
		mysql_query("DELETE FROM gastenboek_ip WHERE moment<$timeout AND ip='".$_SERVER['REMOTE_ADDR']."'");
		
		$sql_spam = mysql_query("SELECT * FROM gastenboek_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
		if(mysql_num_rows($sql_spam) == 1) {
			return "Je mag maar 1 keer in de 5 minuten een bericht posten in een gastenboek.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
		
			/// spam beveiliging einde //
			$row = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$_SESSION['id']."'"));
			mysql_query("INSERT INTO gastenboek_ip (ip,moment) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$timestamp."')");
			mysql_query("INSERT INTO gastenboek_berichten (gastenboek_id,habbonaam,bericht,datum) VALUES ('".$gastenboek_id."','".$row['gebruikersnaam']."','".$bericht."',NOW())");
			if(mysql_error() == "") {
				return "Je hebt succesvol een bericht geplaatst in het gastenboek.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				return mysql_error();
			}
		}
	}
	function gastenboekBerichtverwijderen ($bericht_id) {
		$bericht_id = mysql_real_escape_string(substr($bericht_id,0,30));
		$sql = mysql_query("SELECT gastenboek_id FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		$sql_insert = mysql_query("DELETE FROM gastenboek_berichten WHERE bericht_id='".$bericht_id."' AND gastenboek_id='".$row['gastenboek_id']."'");
		if(mysql_error() == "") {
			return "Het bericht is succesvol verwijderd.";
		}else{
			return mysql_error();
		}
	}
	function gastenboekBerichtaanpassen ($habbonaam,$bericht,$bericht_id) {
		$bericht_id = mysql_real_escape_string(substr($bericht_id,0,30));
		$bericht = mysql_real_escape_string($bericht);
		$habbonaam = mysql_real_escape_string(substr($habbonaam,0,255));
		$sql = mysql_query("SELECT gastenboek_id FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		$sql_insert = mysql_query("UPDATE gastenboek_berichten SET habbonaam='".$habbonaam."',bericht='".$bericht."' WHERE gastenboek_id='".$row['gastenboek_id']."' AND bericht_id='".$bericht_id."'");
		if(mysql_error() == "") {
			return "Het bericht is succesvol aangepast.<br><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
}
$gastenboek = new gastenboek();

	
	$sql_gastenboek = mysql_query("SELECT * FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
	if(mysql_num_rows($sql_gastenboek) == 0) {
		echo "
		<a href='?p=gastenboek&a=aanmaken'>Gastenboek Aanmaken</a> | ";
	}else{
		echo "<a href='?p=gastenboek&a=beheren'>Gastenboek Beheren</a>";
	}
	echo "<br><br><br>";
	
	if(isset($_GET['a'])) {
		if($_GET['a'] == "aanmaken") {
			
			if(isset($_POST['aanmaken'])) {
				echo $gastenboek->gastenboekAanmaken();
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=gastenboek&a=aanmaken" method="post">
					<table width="300">
						<tr>
							<td>Wil je een gastenboek aanmaken die verschijnt op je profiel?</td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="aanmaken" value="Aanmaken" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "beheren") {
			if(isset($_POST['verwijderen']) && isset($_POST['bericht_id'])) {
				echo $gastenboek->gastenboekBerichtverwijderen($_POST['bericht_id']);
			}elseif(isset($_POST['aanpassen']) && !empty($_POST['habbonaam']) && !empty($_POST['bericht'])) {
					echo $gastenboek->gastenboekBerichtaanpassen($_POST['habbonaam'],$_POST['bericht'],$_POST['bericht_id']);
			}elseif(isset($_POST['wijzigen']) & isset($_POST['bericht_id'])){
				$sql = mysql_query("SELECT * FROM gastenboek_berichten WHERE bericht_id='".$_POST['bericht_id']."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=gastenboek&a=beheren" method="post">
				<input type="hidden" name="bericht_id" value="<?php echo $_POST['bericht_id']; ?>">
				<input type="hidden" name="wijzigen" value="wijzigen">
					<table>
						<tr>
							<td>Habbonaam</td>
							<td><input type="text" name="habbonaam" value="<?php echo $row['habbonaam']; ?>" /></td>
						</tr>
						<tr>
							<td>Bericht</td>
							<td><textarea name="bericht" style="width:200px; height:150px;"><?php echo $row['bericht']; ?></textarea></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="aanpassen" value="Aanpassen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}else{
				?>
					<table>
						<tr>
							<td><strong>Habbonaam</strong></td>
							<td><strong>Datum</strong></td>
							<td><strong>Stuk van bericht</strong></td>
							<td><strong>Verwijderen</strong></td>
							<td><strong>Wijzigen</strong></td>
						</tr>
					<?php
					$sql = mysql_query("SELECT gastenboek_id FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
					$row = mysql_fetch_assoc($sql);
					$sql_berichten = mysql_query("SELECT *,DATE_FORMAT(datum, '%d/%m %h:%i') AS datum FROM gastenboek_berichten WHERE gastenboek_id='".$row['gastenboek_id']."'");
					
					while($row_berichten = mysql_fetch_assoc($sql_berichten)) {
						?>
						<tr>
							<td><?php echo htmlspecialchars($row_berichten['habbonaam']); ?></td>
							<td><?php echo htmlspecialchars($row_berichten['datum']); ?></td>
							<td><?php echo htmlspecialchars(substr($row_berichten['bericht'],0,20)); ?></td>
							<td>
								<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=gastenboek&a=beheren" method="post">
									<input type="hidden" name="bericht_id" value="<?php echo $row_berichten['bericht_id']; ?>">
									<input type="submit" name="verwijderen" value="Verwijderen">
								</form>
							</td>
							<td><form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=gastenboek&a=beheren" method="post">
									<input type="hidden" name="bericht_id" value="<?php echo $row_berichten['bericht_id']; ?>">
									<input type="submit" name="wijzigen" value="Wijzigen">
								</form>
							</td>
						</tr>
						<?php
					}
					?>
					</table>
					<?php
					if(mysql_num_rows($sql_berichten) == 0) {
						echo "<br>Er zijn geen berichten in dit gastenboek.";
					}
					?>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "posten") {
			if(isset($_POST['posten']) && isset($_POST['gastenboek_id']) && !empty($_POST['bericht'])) {
				echo $gastenboek->gastenboekBerichttoevoegen($_POST['bericht'],$_POST['gastenboek_id']);
			}else{
				echo "Je hebt iets overgeslagen.";
			}
		}
	}else{
		echo "Kies een link uit het submenu.";
	}
}else{
	echo "Je bent niet ingelogd.";
}
?>