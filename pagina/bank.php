=<?php

if(isset($_SESSION['id'])) {
	if(isset($_POST['submit']) && !empty($_POST['muntjes']) && is_numeric($_POST['muntjes']) && $_POST['muntjes'] > 0) {
		$muntjes = mysql_real_escape_string(substr(round($_POST['muntjes']),0,30));
		$sql = mysql_query("SELECT muntjes,bank FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		if($row['muntjes'] - $muntjes < 0) {
			echo "Je hebt niet genoeg muntjes om op de bank te zetten.";
		}else{
			mysql_query("UPDATE leden SET muntjes=muntjes-".$muntjes." WHERE member_id='".$_SESSION['id']."'");
			mysql_query("UPDATE leden SET bank=bank+".$muntjes." WHERE member_id='".$_SESSION['id']."'");
			
			echo "Je hebt succesvol <strong>".$muntjes."</strong> gestort.";
		}
	}elseif(isset($_POST['opnemen']) && !empty($_POST['muntjes']) && is_numeric($_POST['muntjes']) && $_POST['muntjes'] > 0) {
		$muntjes = mysql_real_escape_string(substr($_POST['muntjes'],0,30));
		$sql = mysql_query("SELECT muntjes,bank FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		if($row['bank'] - $muntjes < 0) {
			echo "Je hebt niet genoeg muntjes op de bank om op te nemen.";
		}else{
			mysql_query("UPDATE leden SET muntjes=muntjes+".$muntjes." WHERE member_id='".$_SESSION['id']."'");
			mysql_query("UPDATE leden SET bank=bank-".$muntjes." WHERE member_id='".$_SESSION['id']."'");
			echo "Je hebt succesvol <strong>".$muntjes."</strong> opgenomen.";
		}
	}	
	?>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=bank" method="POST"><br><br>
	<?php
	$sql_bank = mysql_query("SELECT bank FROM leden WHERE member_id='".$_SESSION['id']."'");
	$row_bank = mysql_fetch_assoc($sql_bank);
	?>
	Je hebt momenteel <strong><?php echo $row_bank['bank']; ?></strong> muntjes op je bank staan.<br />
	<?
	$sql_club = mysql_query("SELECT * FROM clublid WHERE member_id='".$_SESSION['id']."'");
	$row_club = mysql_fetch_assoc($sql_club);
	
	if(mysql_num_rows($sql_club) == 1) {
		?>
		Je krijgt elke dag dat je inlogt 5% rente op je banksaldo.<br />
		<?php
	}else{
		?>
		Je krijgt elke dag dat je inlogt 2% rente op je banksaldo.<br />
		<strong>Tip</strong>: Wist je dat je 5% rente krijgt als je clublid bent.<br />
		<?php
	}
	?>
	Aantal muntjes: <input type="text" name="muntjes" width="50"><br>
	<br>
	<input type="submit" name="submit" value="Storten"> <input type="submit" name="opnemen" value="Opnemen">
	</form>
	<?php
}else{
	echo "Je bent niet ingelogd, Het is dus niet mogelijk om deze pagina te bekijken.";
}
?>