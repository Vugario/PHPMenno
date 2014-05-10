<?php

if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
	if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['opvraagwoord'])) {
		$email = mysql_real_escape_string(substr($_POST['email'],0,200));
		$opvraagwoord = mysql_real_escape_string(substr($_POST['opvraagwoord'],0,255));
		$sql = mysql_query("SELECT email,opvraagwoord FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		if($row['email'] == $_POST['oudemail'] || $row['opvraagwoord'] == $_POST['oudopvraagwoord']) {
		
		mysql_query("UPDATE leden SET email='".$email."',opvraagwoord='".$opvraagwoord."' WHERE member_id='".$_SESSION['id']."'");
		if(mysql_error() == "") {
			echo "<strong>Je gegevens zijn succesvol geupdate.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}else{
			echo "Er is iets mis gegaan, Misschien bestaat dit email al bijna een ander account.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}
	}else{
	echo "Foutieve gegevens!";
	}
	}else{
		$sql = mysql_query("SELECT email,opvraagwoord FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		?>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=gegevensveranderen" method="post">
		<table>
			<tr>
				<td><strong>Oude email</strong></td>
				<td><input type="text" name="oudemail"></td>
			</tr>
			<tr>
				<td><strong>Email</strong></td>
				<td><input type="text" name="email" value=""></td>
			</tr>
			<tr>
				<td><strong>Oude Opvraagwoord</strong></td>
				<td><input type="text" name="oudopvraagwoord" value=""></td>
			</tr>
			<tr>
				<td><strong>Opvraagwoord</strong></td>
				<td><input type="text" name="opvraagwoord" value=""></td>
			</tr>
			<tr>
				<td><input type="submit" name="submit" value="Wijzig!"></td>
			</tr>
		</table>
	</form>
<?php }
}
?>