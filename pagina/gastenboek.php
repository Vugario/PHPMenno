<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?><?php

if(isset($_SESSION['id'])) {
	
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