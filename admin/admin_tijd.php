<?php
// 1 uur
// 2 uur
// 10 minuten
// 24 uur
// 48 uur

if(isset($_SESSION['admin']) || isset($_SESSION['moderator'])) {

if(isset($_POST['submit']) && isset($_POST['member_id']) && isset($_POST['tijd']) && isset($_POST['reden']) && is_numeric($_POST['tijd'])) {
	$id = mysql_real_escape_string($_POST['member_id']);
	$reden = mysql_real_escape_string($_POST['reden']);
	$tijd = $_POST['tijd'];
	
	$dag = date("d");
	$uur = date("H");
	$minuut = date("i");
	
	if($tijd == "1") {
		$uur = $uur + 1;
		$datum = $dag."-".$uur.":".$minuut;
		mysql_query("INSERT INTO tijd_bannen (tijd,reden,member_id) VALUES ('".$datum."','".$reden."','".$id."')");
		if(mysql_error() == "") {
			echo "Succesvol verbannen.";
		}
	}elseif($tijd == "2") {
		$uur = $uur + 2;
		$datum = $dag."-".$uur.":".$minuut;
		mysql_query("INSERT INTO tijd_bannen (tijd,reden,member_id) VALUES ('".$datum."','".$reden."','".$id."')");
		if(mysql_error() == "") {
			echo "Succesvol verbannen.";
		}
	}elseif($tijd == "48") {
		$dag = $dag + 2;
		$datum = $dag."-".$uur.":".$minuut;
		mysql_query("INSERT INTO tijd_bannen (tijd,reden,member_id) VALUES ('".$datum."','".$reden."','".$id."')");
		if(mysql_error() == "") {
			echo "Succesvol verbannen.";
		}
	}elseif($tijd == "24") {
		$dag = $dag + 1;
		$datum = $dag."-".$uur.":".$minuut;
		mysql_query("INSERT INTO tijd_bannen (tijd,reden,member_id) VALUES ('".$datum."','".$reden."','".$id."')");
		if(mysql_error() == "") {
			echo "Succesvol verbannen.";
		}
	}elseif($tijd == "10") {
		$minuut = $minuut + 10;
		$datum = $dag."-".$uur.":".$minuut;
		mysql_query("INSERT INTO tijd_bannen (tijd,reden,member_id) VALUES ('".$datum."','".$reden."','".$id."')");
		if(mysql_error() == "") {
			echo "Succesvol verbannen.";
		}
	}
}else{
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_tijd" method="POST">
	Selecteer een tijd<br>
	<select name="tijd">
		<option value="1">1 Uur</option>
		<option value="2">2 Uur</option>
		<option value="10">10 Minuten</option>
		<option value="24">24 Uur</option>
		<option value="48">48 Uur</option>
	</select>
	<br>
	Kies een lid<br>
	<select name="member_id">
	<?php $sql = mysql_query("SELECT gebruikersnaam,member_id FROM leden ORDER BY gebruikersnaam ASC");
	while($row = mysql_fetch_assoc($sql)) {
		echo "<option value=\"".$row['member_id']."\">".$row['gebruikersnaam']."</option>";
	}
	?>
	<option value="1">Menno</option>
	</select><br>
	Typ een reden<br>
	<textarea name="reden"></textarea><br>
	<br>
	<input type="submit" value="Bannen" name="submit">
	</form>
	<?php
}
}
?>