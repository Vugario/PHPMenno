<?php

if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
	if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['dag']) && !empty($_POST['maand']) && !empty($_POST['jaar'])) {
		$email = mysql_real_escape_string(substr($_POST['email'],0,200));
		$geboortedatum = mysql_real_escape_string($_POST['dag']."-".$_POST['maand']."-".$_POST['jaar']);
		
		mysql_query("UPDATE leden SET email='".$email."',geboortedatum='".$geboortedatum."' WHERE member_id='".$_SESSION['id']."'");
		if(mysql_error() == "") {
			echo "<strong>Je gegevens zijn succesvol geupdate.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}else{
			echo "Er is iets mis gegaan, Misschien bestaat dit email al bijna een ander account.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}
	}else{
		$sql = mysql_query("SELECT email,geboortedatum FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		$geboortedatum = explode("-",$row['geboortedatum']);
		?>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=gegevensveranderen" method="post">
		<table>
			<tr>
				<td><strong>Email</strong></td>
				<td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
			</tr>
			<tr>
				<td><strong>Geboortedatum</strong></td>
				<td><select name="dag">
						<?php
						$dag = range(1,31);
						foreach($dag as $i) {
							echo "<option ";
							if($geboortedatum[0] == $i) { echo "selected"; }
							echo " value=\"".$i."\">".$i."</option>";
						}
						?>
					</select>
					<select name="maand">
						<?php
						$maand = range(1,12);
						foreach($maand as $i) {
							echo "<option ";
							if($geboortedatum[1] == $i) { echo "selected=\"selected\""; }
							echo " value=\"".$i."\">".$i."</option>";
						}
						?>
					</select>
					<select name="jaar">
						<?php
						$jaar = range(date("Y") - 4, 1930);
						foreach($jaar as $i) {
							echo "<option ";
							if($geboortedatum[2] == $i) { echo "selected"; }
							echo " value=\"".$i."\">".$i."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="2"><input type="submit" name="submit" value="Wijzigen"></th>
			</tr>
		</table>
		</form>
	<?php
	}
}

?>