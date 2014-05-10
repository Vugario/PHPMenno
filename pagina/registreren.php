<?php

	if(isset($_POST['registreren']) && !empty($_POST['gebruikersnaam']) == false) {
		$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je bent vergeten een gebruikersnaam in te voeren.</div>';
		header('Location: registreren');
	}
	
	if(isset($_POST['registreren']) && !empty($_POST['email']) == false) {
		$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je bent vergeten een E-mail adres in te voeren.</div>';
		header('Location: registreren');
	}
	
	if(isset($_POST['registreren']) && !empty($_POST['wachtwoord']) == false) {
		$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je bent vergeten een wachtwoord in te voeren.</div>';
		$_SESSION['pass'] = 'lala';
		header('Location: registreren');
	}
				
	if(isset($_POST['registreren']) && ($_POST['wachtwoord'] == $_POST['wachtwoordh']) == false) {
		$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">De wachtwoorden komen niet overeen.</div>';
		header('Location: registreren');
	}
	
	if(isset($_POST['registreren']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord']) && !empty($_POST['wachtwoordh']) && !empty($_POST['email']) && !empty($_POST['dag']) && !empty($_POST['maand']) && !empty($_POST['jaar']) && $_POST['wachtwoord'] == $_POST['wachtwoordh'] && !strpos($_POST['gebruikersnaam']," ") && !strpos($_POST['gebruikersnaam'],"'") && !strpos($_POST['gebruikersnaam'],"/")  && !strpos($_POST['gebruikersnaam'],"´") && strlen($_POST['gebruikersnaam']) >= 4 && $_POST['gebruikersnaam'] != "systeem" && $_POST['gebruikersnaam'] != "<noscript>" && $_POST['gebruikersnaam'] != "<noscript />" && $_POST['gebruikersnaam'] != "<noscript >" && strpos($_POST['gebruikersnaam'],"<") == false) {

		echo registeren($_POST['gebruikersnaam'],$_POST['wachtwoord'],$_POST['dag'],$_POST['maand'],$_POST['jaar'],$_POST['email']);
		
	}else{
	
?>
	<form name="form1" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<table class="data">
			<tr>
				<td>Gebruikersnaam</td>
				<td><input type="text" name="gebruikersnaam" maxlength="25" /></td>
			</tr>
			<tr>
				<td>Wachtwoord</td>
				<td><input type="password" name="wachtwoord" maxlength="255" /></td>
			</tr>
			<tr>
				<td>Wachtwoord</td>
				<td><input type="password" name="wachtwoordh" maxlength="255" /></td>
			</tr>
			<tr>
				<td>Geboortedatum</td>
				<td>
					<select name="dag">
						<?php
							$dag = range(1,31);
							foreach($dag as $var) {
								echo "<option value='".$var."'>".$var."</option>";
							}
						?>
					</select>
					<select name="maand">
						<?php
							$maand = range(1,12);
							foreach($maand as $var) {
								echo "<option value='".$var."'>".$var."</option>";
							}
						?>
					</select>
					<select name="jaar">
						<?php
							$jaar = range(date("Y") - 0,1930);
							foreach($jaar as $var) {
								echo "<option value='".$var."'>".$var."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="text" name="email" maxlength="60" /></td>
			</tr>
			<tr>
				<th colspan="2"><input type="submit" name="registreren" value="Registreren"></th>
			</tr>
		</table>
	</form>
<?php } ?>