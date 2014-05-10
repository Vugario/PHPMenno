<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}


$sql = mysql_query("SELECT * FROM poll WHERE member_id='".$_SESSION['id']."'");
if(mysql_num_rows($sql) == 1) {
	echo "
		<a href='?p=poll&a=veranderen'>Poll Veranderen</a> | 
		<a href='?p=poll&a=verwijderen'>Poll Verwijderen</a> | ";
}else{
	echo "<a href='?p=poll&a=aanmaken'>Poll Aanmaken</a> | ";
}
echo "<br><br><br>";

if(isset($_GET['a'])) {
	if($_GET['a'] == "aanmaken") {
		if(isset($_POST['aanmaken']) && !empty($_POST['vraag']) && !empty($_POST['ant1']) && !empty($_POST['ant2']) && !empty($_POST['ant3']) && !empty($_POST['ant4'])) {
			echo $poll->pollAanmaken($_POST['vraag'],$_POST['ant1'],$_POST['ant2'],$_POST['ant3'],$_POST['ant4']);
		}else{
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=poll&a=aanmaken" method="post">
				<table width="300">
					<tr>
						<td>Vraag</td>
						<td><input type="text" name="vraag" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 1</td>
						<td><input type="text" name="ant1" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 2</td>
						<td><input type="text" name="ant2" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 3</td>
						<td><input type="text" name="ant3" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 4</td>
						<td><input type="text" name="ant4" maxlength="255" /></td>
					</tr>
					<tr>
						<th colspan="2"><input type="submit" name="aanmaken" value="Aanmaken" /></th>
					</tr>
				</table>
			</form>
			<?php
		}
	}elseif($_GET['a'] == "veranderen") {
		if(isset($_POST['aanpassen']) && !empty($_POST['vraag']) && !empty($_POST['ant1']) && !empty($_POST['ant2']) && !empty($_POST['ant3']) && !empty($_POST['ant4'])) {
			echo $poll->pollVeranderen($_POST['vraag'],$_POST['ant1'],$_POST['ant2'],$_POST['ant3'],$_POST['ant4']);
		}else{
			$sql = mysql_query("SELECT * FROM poll WHERE member_id='".$_SESSION['id']."'");
			$row = mysql_fetch_assoc($sql);
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=poll&a=veranderen" method="post">
				<table width="300">
					<tr>
						<td>Vraag</td>
						<td><input type="text" name="vraag" value="<?php echo $row['vraag']; ?>" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 1</td>
						<td><input type="text" name="ant1" value="<?php echo $row['ant1']; ?>" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 2</td>
						<td><input type="text" name="ant2" value="<?php echo $row['ant2']; ?>" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 3</td>
						<td><input type="text" name="ant3" value="<?php echo $row['ant3']; ?>" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Antwoord 4</td>
						<td><input type="text" name="ant4" value="<?php echo $row['ant4']; ?>" maxlength="255" /></td>
					</tr>
					<tr>
						<th colspan="2"><input type="submit" name="aanpassen" value="Aanpassen" /></th>
					</tr>
				</table>
			</form>
			<?php
		}
	}elseif($_GET['a'] == "verwijderen") {
		if(isset($_POST['verwijderen'])) {
			echo $poll->pollVerwijderen();
		}else{
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=poll&a=verwijderen" method="post">
				<table width="300">
					<tr>
						<td>Weet je zeker dat je je poll wilt verwijderen?</td>
					</tr>
					<tr>
						<th colspan="2"><input type="submit" name="verwijderen" value="Ja, Verwijderen" /></th>
					</tr>
				</table>
			</form>
			<?php
		}
	}elseif($_GET['a'] == "stemmen") {
		if(isset($_POST['ant']) && isset($_POST['poll_id'])) {
			echo $poll->pollStemmen($_POST['ant'],$_POST['poll_id']);
		}else{
			echo "Er is iets fout gegaan.";
		}
	}
}else{
	echo "Kies een optie uit het menu hierboven.";
}
?>