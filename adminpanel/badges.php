<?php

/////////// Badge aan persoon toevoegen ///////////////

echo "<h2>Geef iemand een badge</h2>";
if(isset($_SESSION['admin'])) {
	if(isset($_POST['geven']) && !empty($_POST['member_id']) && !empty($_POST['badge_id'])) {
	
		echo $admin->badgeGeven($_POST['member_id'],$_POST['badge_id']);
	
	}else{
		?>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_badges" method="post">
			<strong>Kies een lid</strong><br />
			<select name="member_id">
				<?php
				$sql = mysql_query("SELECT gebruikersnaam,member_id FROM leden ORDER BY gebruikersnaam ASC");
				while($row = mysql_fetch_assoc($sql)) {
					echo "<option value=\"".$row['member_id']."\">".$row['gebruikersnaam']."</option>";
				}
				?>
			</select><br />
			<br />
			<strong>Welke badge wil je geven?</strong><br />
			<?php
			$sql = mysql_query("SELECT plaatje,badge_id,titel FROM speciale_badges ORDER BY titel ASC");
			echo "<table>";
			while($row = mysql_fetch_assoc($sql)) {
				echo "<tr>
						<td rowspan=\"3\"><input type=\"radio\" name=\"badge_id\" value=\"".$row['badge_id']."\"></td>
					</tr>
					<tr>
						<td><strong>".$row['titel']."</strong></td>
					</tr>
					<tr>
						<td></td>
						<td>";
				echo "		<img src=\"".$row['plaatje']."\" />
						</td>
					</tr>";
			}
			echo "</table>";
			?><br>
			<br>
			<input type="submit" name="geven" value="Geef de badge!">
		</form>
		<?php
	}
	
	echo "<br>
		<br>
		<br>
		<br>
		<h2>Maak een speciale badge</h2>";
		
	if(isset($_POST['maken']) && !empty($_POST['titel'])) {
	
		copy($_FILES['file']['tmp_name'], "uploads/badges/" . $_FILES['file']['name']) or die("Er is iets fout gegaan tijdens het uploaden van het plaatje.");
		$plaatje = "uploads/badges/" . $_FILES['file']['name'];
		echo $admin->badgeAanmaken($_POST['titel'],$plaatje);
	
	}else{
		?>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_badges" enctype="multipart/form-data" method="post">
			<strong>Badge Titel</strong><br />
			<input type="text" name="titel" maxlength="25"><br />
			<br />
			<strong>Plaatje</strong><br />
			<input type="file" name="file"><br>
			<br>
			<input type="submit" name="maken" value="Maak de badge!">
		</form>
		<?php
	}
}else{
	echo "Geen toegang!";
}
?>