<?php

if(isset($_SESSION['admin']) || isset($_SESSION['nieuwsreporter'])) {

if(isset($_GET['a'])) {
	if($_GET['a'] == "reacties" && isset($_GET['s'])) {
		if($_GET['s'] == "verwijderen") {
			if(isset($_POST['verwijderen'])) {
			
				$reactie_id = addslashes(substr($_POST['reactie_id'],0,30));
				mysql_query("DELETE FROM nieuws_reacties WHERE reactie_id='".$reactie_id."'");
				if(mysql_error() == "") {
					echo "Hij is succesvol verwijderd.<br>Wil je er nog meer verwijderen?<br><a href='javascript:history.go(-2)'>Ga terug</a>";
				}else{
					echo "Er is een fout opgetreden.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}
				
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_reacties&a=reacties&s=verwijderen" method="post">
					<input type="hidden" name="reactie_id" value="<?php echo $_GET['id']; ?>" />
					Weet je zeker dat je de reactie wilt verwijderen?<br />
					<input type="submit" value="Verwijderen" name="verwijderen" />
				</form>
				<?php
			}
		}
	}
}else{
			$sql = mysql_query("SELECT * FROM nieuws_reacties");
			echo "<table width=\"100%\">
					<tr>
						<td><strong>#</strong></td>
						<td><strong>Gebruiker</strong></td>
						<td><strong>Bericht</strong></td>
						<td><strong>IP</strong></td>
						<td><strong>Verwijderen</strong></td>
					</tr>";
			$i = 1;
			while($row = mysql_fetch_assoc($sql)) {
				$row_member = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
				echo "<tr>
						<td>".$i."</td>
						<td>".$row_member['gebruikersnaam']."</td>
						<td>".substr($row['bericht'],0,30)."</td>
						<td>".$row['ip']."</td>
						<td><a href='?p=admin_reacties&a=reacties&s=verwijderen&id=".$row['reactie_id']."'>Verwijderen</a></td>
					</tr>";
				$i++;
			}
			echo "</table>";
			
			if(mysql_num_rows($sql) == 0) {
				echo "Er zijn geen reacties gevonden.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
			}
}
}else{
	echo "Zou wel leuk zijn als je admin was.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>