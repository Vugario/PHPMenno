<?php

if(isset($_SESSION['admin']) || isset($_SESSION['nieuwsreporter']) || isset($_SESSION['forumbeheerder'])) {
	
	if(isset($_GET['a'])) {
		if($_GET['a'] == "toevoegen") {
			if(isset($_POST['submit']) && !empty($_POST['vraag']) && !empty($_POST['antwoord'])) {
				$vraag = mysql_real_escape_string(substr($_POST['vraag'],0,45));
				$antwoord = mysql_real_escape_string($_POST['antwoord']);
				
				mysql_query("INSERT INTO faq (vraag,antwoord) VALUES ('".$vraag."','".$antwoord."')");
				if(mysql_error() == "") {
					echo "De vraag is succesvol toegevoegd, je kan hem bekijken op de <a href=\"?p=faq\">F.A.Q. Pagina</a><br />
							<a href='#' onclick='history.go(-2)'>Ga terug naar overzicht</a>";
				}else{
					echo "Er is iets foutgegaan, Misschien bestaat deze vraag al.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
				}
			}else{
				?>
				<a href="?p=admin_faq">Overzicht</a><br>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_faq&a=toevoegen" method="POST">
					<table>
						<tr>
							<td>Vraag</td>
							<td><input type="text" name="vraag" maxlength="45" /></td>
						</tr>
						<tr>
							<td>Antwoord</td>
							<td><textarea style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;" name="antwoord" cols="40" rows="10"></textarea></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="submit" value="Toevoegen"></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "wijzigen") {
			if(isset($_POST['submit']) && !empty($_POST['vraag']) && !empty($_POST['antwoord']) && is_numeric($_POST['faq_id'])) {
				$vraag = mysql_real_escape_string(substr($_POST['vraag'],0,45));
				$antwoord = mysql_real_escape_string($_POST['antwoord']);
				$faq_id = mysql_real_escape_string($_POST['faq_id']);
				
				mysql_query("UPDATE faq SET vraag='".$vraag."',antwoord='".$antwoord."' WHERE faq_id='".$faq_id."'");
				if(mysql_error() == "") {
					echo "De vraag is succesvol gewijzigd, je kan hem bekijken op de <a href=\"?p=faq\">F.A.Q. Pagina</a><br />
							<a href='#' onclick='history.go(-2)'>Ga terug naar overzicht</a>";
				}else{
					echo "Er is iets foutgegaan, Misschien bestaat deze vraag al.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
				}
			}elseif(isset($_GET['faq_id']) && is_numeric($_GET['faq_id'])) {
				$faq_id = mysql_real_escape_string($_GET['faq_id']);
				$row = mysql_fetch_assoc(mysql_query("SELECT vraag,antwoord FROM faq WHERE faq_id='".$faq_id."'"));
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_faq&a=wijzigen" method="POST">
					<input type="hidden" name="faq_id" value="<?php echo $_GET['faq_id']; ?>">
					<table>
						<tr>
							<td>Vraag</td>
							<td><input type="text" value="<?php echo $row['vraag']; ?>" name="vraag" maxlength="45" /></td>
						</tr>
						<tr>
							<td>Antwoord</td>
							<td><textarea style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;" name="antwoord" cols="40" rows="10"><?php echo $row['antwoord']; ?></textarea></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="submit" value="Wijzigen"></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "verwijderen") {
			if(isset($_POST['submit']) && is_numeric($_POST['faq_id'])) {
				$faq_id = mysql_real_escape_string($_POST['faq_id']);
				
				mysql_query("DELETE FROM faq WHERE faq_id='".$faq_id."'");
				if(mysql_error() == "") {
					echo "De vraag is succesvol verwijderd.<br><a href='#' onclick='history.go(-2)'>Ga terug</a>";
				}else{
					echo "Er is iets foutgegaan, Misschien bestaat deze vraag niet.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
				}
			}elseif(isset($_GET['faq_id']) && is_numeric($_GET['faq_id'])) {
				$faq_id = mysql_real_escape_string($_GET['faq_id']);
				$row = mysql_fetch_assoc(mysql_query("SELECT vraag,antwoord FROM faq WHERE faq_id='".$faq_id."'"));
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_faq&a=verwijderen" method="POST">
					<input type="hidden" name="faq_id" value="<?php echo $_GET['faq_id']; ?>">
					Wil je echt deze vraag en antwoord verwijderen? :<br>
					<br>
					<strong><?php echo $row['vraag']; ?></strong><br>
					<?php echo $row['antwoord']; ?><br>
					<br>
					<input type="submit" name="submit" value="Verwijderen">
				</form>
				<?php
			}
		}
	}else{
		echo "<a href=\"?p=admin_faq&a=toevoegen\">Vraag Toevoegen</a><br>";
		$sql = mysql_query("SELECT * FROM faq");
		echo "<table>";
		while($row = mysql_fetch_assoc($sql)) {
			echo "
				<tr>
					<td>".substr($row['vraag'],0,60)."</td>
					<td><a href=\"?p=admin_faq&a=wijzigen&faq_id=".$row['faq_id']."\">Wijzigen</a></td>
					<td><a href=\"?p=admin_faq&a=verwijderen&faq_id=".$row['faq_id']."\">Verwijderen</a></td>
				</tr>";
		}
		echo "</table>";
		if(mysql_num_rows($sql) == 0) {
			echo "Er zijn geen vragen, <a href=\"?p=admin_faq&a=toevoegen\">Wil je er 1 toevoegen</a>?";
		}
	}
}else{
	echo "Je bent helaas geen admin.<br><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>