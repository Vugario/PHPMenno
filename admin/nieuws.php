<?php

if(isset($_SESSION['admin']) || isset($_SESSION['nieuwsreporter']) || isset($_SESSION['moderator'])) {


class nieuws {
	function nieuwsToevoegen($titel,$bericht,$langbericht,$actief) {
		$titel = mysql_real_escape_string(substr($titel,0,75));
		$bericht = mysql_real_escape_string(substr($bericht,0,5000));
		$langbericht = mysql_real_escape_string(substr($langbericht,0,5000));
		$actief = mysql_real_escape_string(substr($actief,0,3));
		
		setlocale(LC_ALL, 'nl_NL');
		
		mysql_query("INSERT INTO nieuws_berichten (titel,bericht,langbericht,actief,datum,member_id) VALUES ('".$titel."','".$bericht."','".$langbericht."','".$actief."','".date("y-m-d H:i:s")."','".$_SESSION['id']."')");
		if(mysql_error() == "") {
			echo "Er is succesvol een nieuwsitem aangemaakt.<br /><strong>".$titel."</strong><br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			echo "Deze titel komt al voor in het nieuws archief.<br />Kies een andere.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}
	}
	
	function nieuwsWijzigen($titel,$bericht,$langbericht,$actief,$nieuws_id) {
		$titel = mysql_real_escape_string(substr($titel,0,75));
		$bericht = mysql_real_escape_string(substr($bericht,0,5000));
		$langbericht = mysql_real_escape_string(substr($langbericht,0,5000));
		$actief = mysql_real_escape_string(substr($actief,0,3));
		$nieuws_id = mysql_real_escape_string(substr($nieuws_id,0,30));
		
		mysql_query("UPDATE nieuws_berichten SET titel='".$titel."',bericht='".$bericht."',langbericht='".$langbericht."',actief='".$actief."' WHERE nieuws_id='".$nieuws_id."'");
		if(mysql_error() == "") {
			echo "Dit nieuwsitem is succesvol gewijzigd.<br /><strong>".$titel."</strong><br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			echo "Deze titel komt al voor in het nieuws archief.<br />Kies een andere.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}
	}
	
	function nieuwsVerwijderen($nieuws_id) {
		$nieuws_id = mysql_real_escape_string(substr($nieuws_id,0,30));
		
		mysql_query("DELETE FROM nieuws_berichten WHERE nieuws_id='".$nieuws_id."'");
		if(mysql_error() == "") {
			echo "Dit nieuwsitem is succesvol verwijderd.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan, Misschien bestaat hij niet meer.<br><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	// nieuwe function
}

$nieuws = new nieuws();



	?>
	<script type="text/javascript" src="editor/scripts/wysiwyg.js"></script>
	<script type="text/javascript" src="editor/scripts/wysiwyg-settings.js"></script>
	<!-- 
		Attach the editor on the textareas
	-->
	<script type="text/javascript">
		// Use it to attach the editor to all textareas with full featured setup
		//WYSIWYG.attach('all', full);
		
		// Use it to attach the editor directly to a defined textarea
		WYSIWYG.attach('bericht',small); // default setup
		WYSIWYG.attach('langbericht',small); // default setup
	</script>
	<?php

if(isset($_GET['a'])) {
	if($_GET['a'] == "nieuws" && isset($_GET['s'])) {
		if($_GET['s'] == "toevoegen") {
			if(isset($_POST['toevoegen'])) {
			
				echo $nieuws->nieuwsToevoegen($_POST['titel'],$_POST['bericht'],$_POST['langbericht'],$_POST['actief']);
				
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_nieuws&a=nieuws&s=toevoegen" method="post">
					<table width="300">
						<tr>
							<td>Titel</td>
							<td><input type="text" name="titel" maxlength="25" /></td>
						</tr>
						<tr>
							<td colspan="2">Kort Bericht</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="bericht" name="bericht" style="background:#FFFFFF;" cols="60" rows="20"></textarea></td>
						</tr>
						<tr>
							<td colspan="2">Lang Bericht</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="langbericht" name="langbericht" style="background:#FFFFFF;" cols="60" rows="20"></textarea></td>
						</tr>
						<tr>
							<td>Aan of uit?</td>
							<td><input type="radio" checked="checked" name="actief" value="aan" /> Aan <input type="radio" name="actief" value="uit" /> Uit </td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" value="Toevoegen" name="toevoegen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['s'] == "wijzigen") {
			if(isset($_POST['wijzigen'])) {
				echo $nieuws->nieuwsWijzigen($_POST['titel'],$_POST['bericht'],$_POST['langbericht'],$_POST['actief'],$_POST['nieuws_id']);
			}elseif(isset($_GET['nid'])) {
				$nid = mysql_real_escape_string(substr($_GET['nid'],0,30));
				$sql = mysql_query("SELECT * FROM  nieuws_berichten WHERE nieuws_id='".$nid."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_nieuws&a=nieuws&s=wijzigen" method="post">
					<input type="hidden" name="nieuws_id" value="<?php echo $_GET['nid']; ?>" />
					<table width="300">
						<tr>
							<td>Titel</td>
							<td><input type="text" name="titel" <?php echo "value=\"".stripslashes($row['titel'])."\""; ?> maxlength="25" /></td>
						</tr>
						<tr>
							<td colspan="2">Kort Bericht</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="bericht" name="bericht" style="background:#FFFFFF;" cols="30" rows="20"><?php echo stripslashes($row['bericht']); ?></textarea></td>
						</tr>
						<tr>
							<td colspan="2">Lang Bericht</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="langbericht" name="langbericht" style="background:#FFFFFF;" cols="30" rows="20"><?php echo stripslashes($row['langbericht']); ?></textarea></td>
						</tr>
						<tr>
							<td>Aan of uit?</td>
							<td><input type="radio" <?php if($row['actief'] == "aan") echo "checked=\"checked\""; ?> name="actief" value="aan" /> Aan <input type="radio" <?php if($row['actief'] == "uit") echo "checked=\"checked\""; ?> name="actief" value="uit" /> Uit </td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" value="Wijzigen" name="wijzigen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}else{
				$sql = mysql_query("SELECT * FROM nieuws_berichten");
				echo "<table width=\"700\">
						<tr>
							<td>Titel</td>
							<td>K. Bericht</td>
							<td>L. Bericht</td>
							<td>Actief</td>
							<td>Wijzigen/verwijderen</td>
						</tr>";
				while($row = mysql_fetch_assoc($sql)) {
					echo "<tr>
							<td>".$row['titel']."</td>
							<td>".substr($row['bericht'],0,15)."</td>
							<td>".substr($row['langbericht'],0,15)."</td>
							<td>".$row['actief']."</td>
							<td><a href='?p=admin_nieuws&a=nieuws&s=wijzigen&nid=".$row['nieuws_id']."'>Wijzigen</a><br />
								<a href='?p=admin_nieuws&a=nieuws&s=verwijderen&nid=".$row['nieuws_id']."'>Verwijderen</a>
							</td>
						</tr>";
				}
				echo "</table>";
			}
		}elseif($_GET['s'] == "verwijderen") {
			if(isset($_POST['verwijderen'])) {
				echo $nieuws->nieuwsVerwijderen($_POST['nieuws_id']);
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_nieuws&a=nieuws&s=verwijderen" method="post">
					<input type="hidden" value="<?php echo $_GET['nid'] ?>" name="nieuws_id" />
					<input type="submit" value="Verwijderen" name="verwijderen" />
				</form>
				<?php
			}
		}
	}
}else{
	echo "&raquo; <a href=\"?p=admin_nieuws&a=nieuws&s=toevoegen\">Nieuws Toevoegen</a><br />
		&raquo; <a href=\"?p=admin_nieuws&a=nieuws&s=wijzigen\">Nieuws Wijzigen/Verwijderen</a><br />";
}
}else{
	echo "Zou wel leuk zijn als je admin was.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>
	<script language="javascript1.2">
	generate_wysiwyg('bericht');
	generate_wysiwyg('langbericht');
	</script>