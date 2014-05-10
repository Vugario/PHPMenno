<?php
	if(isset($_SESSION['id'])) {
		if(isset($_POST['submit']) && !empty($_POST['muntjes']) && is_numeric($_POST['muntjes']) && $_POST['muntjes'] > 0) {
			$muntjes = mysql_real_escape_string(substr(round($_POST['muntjes']),0,30));
			$sql = mysql_query("SELECT muntjes,bank FROM leden WHERE member_id='".$_SESSION['id']."'");
			$row = mysql_fetch_assoc($sql);
			
			if($row['muntjes'] - $muntjes < 0) {
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je hebt niet genoeg muntjes om op de bank te zetten.</div>';
				header('Location:bank');
			}else{
				mysql_query("UPDATE leden SET muntjes=muntjes-".$muntjes." WHERE member_id='".$_SESSION['id']."'");
				mysql_query("UPDATE leden SET bank=bank+".$muntjes." WHERE member_id='".$_SESSION['id']."'");
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je hebt succesvol <strong>' . $muntjes . '</strong> muntjes gestort.</div>';
				header('Location:bank');
			}
		}elseif(isset($_POST['opnemen']) && !empty($_POST['muntjes']) && is_numeric($_POST['muntjes']) && $_POST['muntjes'] > 0) {
			$muntjes = mysql_real_escape_string(substr($_POST['muntjes'],0,30));
			$sql = mysql_query("SELECT muntjes,bank FROM leden WHERE member_id='".$_SESSION['id']."'");
			$row = mysql_fetch_assoc($sql);
			
			if($row['bank'] - $muntjes < 0) {
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je hebt niet genoeg muntjes op de bank om op te nemen.</div>';
				header('Location:bank');
			}else{
				mysql_query("UPDATE leden SET muntjes=muntjes+".$muntjes." WHERE member_id='".$_SESSION['id']."'");
				mysql_query("UPDATE leden SET bank=bank-".$muntjes." WHERE member_id='".$_SESSION['id']."'");
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je hebt succesvol <strong>'.$muntjes.'</strong> muntjes opgenomen.</div>';
				header('Location:bank');
			}
		}
	}
?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
	<?php
		$sql_bank = mysql_query("SELECT bank FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row_bank = mysql_fetch_assoc($sql_bank);
	?>
	<table class="data">
		<tr>
			<td>Aantal muntjes op bank</td>
			<td><?php echo $row_bank['bank']; ?></td>
		</tr>
		<tr>
			<td>Aantal storten/opnemen</td>
			<td><input type="text" name="muntjes" width="50"></td>
		</tr>
		<tr>
			<th colspan="2"><input type="submit" name="submit" value="Storten"> <input type="submit" name="opnemen" value="Opnemen"></th>
		</tr>
	</table>
</form><br /><br /><br />







<?php
	if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
		if(isset($_POST['overschrijven']) && !empty($_POST['muntjes']) && !empty($_POST['ontvanger']) && is_numeric($_POST['muntjes']) && $_POST['muntjes'] >= 0) {
			$muntjes = mysql_real_escape_string(substr(round($_POST['muntjes'],0),0,30));
			$ontvanger = mysql_real_escape_string($_POST['ontvanger']);
			$bericht = mysql_real_escape_string(substr(htmlspecialchars($_POST['bericht']),0,255));
			
			$sql = mysql_query("SELECT muntjes FROM leden WHERE gebruikersnaam='".$_SESSION['gebruikersnaam']."'");
			$row = mysql_fetch_assoc($sql);
			
			if($row['muntjes'] - $muntjes < 0) {
				$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je hebt niet genoeg muntjes.</div>';
				header('Location:bank');
			}else{	
				mysql_query("UPDATE leden SET muntjes=muntjes-".$muntjes." WHERE gebruikersnaam='".$_SESSION['gebruikersnaam']."'");
				mysql_query("UPDATE leden SET muntjes=muntjes+".$muntjes." WHERE gebruikersnaam='".$ontvanger."'");				
				mysql_query("INSERT INTO overschrijvingen (muntjes,naar_id,van_id,datum,bericht)
							VALUES ('".$muntjes."','".$ontvanger."','".$_SESSION['gebruikersnaam']."',NOW(),'".$bericht."')");
				if(mysql_error() == "") {
					$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Er zijn succesvol '.$muntjes.' muntjes naar '.$ontvanger.' gestuurd!</div>';
					header('Location:bank');
				}else{
					$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Er ging wat mis. Waarschijnlijk bestaat de gebruiker niet.</div>';
					header('Location:bank');
				}
			}
		}else{
?>
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
				<table class="data">
					<tr>
						<td>Naar de gebruiker</td>
						<td><input type="text" name="ontvanger"></td>
					</tr>
					<tr>
						<td>Bedrag in muntjes</td>
						<td><input type="text" name="muntjes"></td>
					</tr>
					<tr>
						<td width="300px;">Bericht/toevoeging</td>
						<td><input type="text" name="bericht"></td>
					</tr>
					<tr>
						<th colspan="2"><input type="submit" name="overschrijven" value="Overschrijven"></th>
					</tr>
				</table><br /><br />
<?php
		}
	}
?>
<a href="<?php echo $root; ?>bank/log">Bekijk mijn bank log »</a>






<?php 
	if(isset($url[1])) {
		if($url[1] == "log") {
			echo "<br /><br /><strong><u>Jouw laatste 5 overschrijvingen</u></strong><br /><br />";
			echo "<table class='data'>
				<tr>
					<th>#</th>
					<th>Naar</th>
					<th>Bedrag</th>
					<th>Datum</th>
					<th>Bericht</th>
				</tr>";
			$sql = mysql_query("SELECT * FROM overschrijvingen WHERE van_id='".$_SESSION['id']."' ORDER BY datum DESC LIMIT 5");
			$i = 1;
			while($row = mysql_fetch_assoc($sql)) {
				$sql_naam = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['naar_id']."'");
				$row_naam = mysql_fetch_assoc($sql_naam);
				echo "
				<tr>
					<td>".$i."</td>
					<td>".$row['naar_id']."</td>
					<td>".$row['muntjes']."</td>
					<td>".$row['datum']."</td>
					<td>".$row['bericht']."</td>
				</tr>";
				$i++;
			}
			echo "</table><br />";

			echo "<strong><u>Jouw laatste 5 ontvangen muntjes</u></strong><br /><br />";
			echo "<table class='data'>
				<tr>
					<th>#</th>
					<th>Naar</th>
					<th>Bedrag</th>
					<th>Datum</th>
					<th>Bericht</th>
				</tr>";
			$sql2 = mysql_query("SELECT * FROM overschrijvingen WHERE naar_id='".$_SESSION['gebruikersnaam']."' ORDER BY datum DESC LIMIT 5");
			$i = 1;
			while($row2 = mysql_fetch_assoc($sql2)) {
				$sql2_naam = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row2['van_id']."'");
				$row2_naam = mysql_fetch_assoc($sql2_naam);
				echo "
				<tr>
					<td>".$i."</td>
					<td>".$row2['naar_id']."</td>
					<td>".$row2['muntjes']."</td>
					<td>".$row2['datum']."</td>
					<td>".$row2['bericht']."</td>
				</tr>";
				$i++;
			}
			echo "</table>";
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		}
	}
?>