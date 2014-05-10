<?php

if(isset($_SESSION['admin'])) {
	if(isset($_GET['a'])) {
		if($_GET['a'] == "categorie") {
			if($_GET['s'] == "toevoegen") {
				if(isset($_POST['toevoegen']) && !empty($_POST['titel']) && !empty($_POST['uitleg'])) {
					
					echo $forum->categorieToevoegen($_POST['titel'],$_POST['uitleg']);
					
				}else{
					?>
					<a href='?p=admin_forum&a=categorie&s=lijst'>Categorie wijzigen/verwijderen</a><br>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_forum&a=categorie&s=toevoegen" method="post">
						<table width="500">
							<tr>
								<td>Titel</td>
								<td><input type="text" name="titel" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Uitleg</td>
								<td><input type="text" style="width:300px;" name="uitleg" maxlength="255" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="toevoegen" value="Toevoegen" /></th>
							</tr>
						</table>
					</form>
					<?php
				}
			}elseif($_GET['s'] == "wijzigen") {
				if(isset($_POST['wijzigen']) && !empty($_POST['categorie_id']) && !empty($_POST['titel']) && !empty($_POST['uitleg'])) {
					
					echo $forum->categorieWijzigen($_POST['categorie_id'],$_POST['titel'],$_POST['uitleg']);
					
				}else{
					$sql = mysql_query("SELECT * FROM forum_categorie WHERE categorie_id='".$_POST['categorie_id']."'");
					$row = mysql_fetch_assoc($sql);
					?>
					<a href='?p=admin_forum&a=categorie&s=lijst'>Categorie wijzigen/verwijderen</a><br>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_forum&a=categorie&s=wijzigen" method="post">
						<input type="hidden" name="categorie_id" value="<?php echo $_POST['categorie_id']; ?>" />
						<table width="500">
							<tr>
								<td>Titel</td>
								<td><input type="text" name="titel" value="<?php echo $row['titel']; ?>" maxlength="255" /></td>
							</tr>
							<tr>
								<td>Uitleg</td>
								<td><input type="text" style="width:300px;" value="<?php echo $row['uitleg']; ?>" name="uitleg" maxlength="255" /></td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen" /></th>
							</tr>
						</table>
					</form>
					<?php
				}
			}elseif($_GET['s'] == "verwijderen") {
				if(isset($_POST['JAverwijderen']) && !empty($_POST['categorie_id'])) {
					
					echo $forum->categorieVerwijderen($_POST['categorie_id']);
					
				}else{
					$sql = mysql_query("SELECT * FROM forum_categorie WHERE categorie_id='".$_POST['categorie_id']."'");
					$row = mysql_fetch_assoc($sql);
					?>
					<a href='?p=admin_forum&a=categorie&s=lijst'>Categorie wijzigen/verwijderen</a><br>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_forum&a=categorie&s=verwijderen" method="post">
						<input type="hidden" name="categorie_id" value="<?php echo $_POST['categorie_id']; ?>" />
						<table width="500">
							<tr>
								<td colspan="2">Weet je zeker dat je de categorie wilt verwijderen?</td>
							</tr>
							<tr>
								<th colspan="2"><input type="submit" name="JAverwijderen" value="Verwijderen" /></th>
							</tr>
						</table>
					</form>
					<?php
				}
			}elseif($_GET['s'] == "lijst") {
				$sql = mysql_query("SELECT * FROM forum_categorie");
				echo "<a href='?p=admin_forum&a=categorie&s=toevoegen'>Categorie Toevoegen</a><br>
					<table>";
				while($row = mysql_fetch_assoc($sql)) {
					?>
					<tr>
						<td><?php echo $row['titel']; ?></td>
						<td>&nbsp;&nbsp;</td>
						<td><?php echo $row['uitleg']; ?></td>
						<td>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_forum&a=categorie&s=wijzigen" method="post">
								<input type="hidden" name="categorie_id" value="<?php echo $row['categorie_id']; ?>">
								<input type="submit" name="wijzigen" value="Wijzigen">
							</form>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_forum&a=categorie&s=verwijderen" method="post">
								<input type="hidden" name="categorie_id" value="<?php echo $row['categorie_id']; ?>">
								<input type="submit" name="verwijderen" value="Verwijderen">
							</form>
						</td>
					</tr>
					<?php
				}
			}// nieuw $_GET['s']
		}// andere $_GET['a']
	}// anders bestaat $_GET['a'] niet
}else{
	echo "Je bent geen admin.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
}
?>