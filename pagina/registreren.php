<?php

function checkRaretekens($string) {
	if(!strpos($string," ") && !strpos($string,"'") && !strpos($string,"\\") && !strpos($string,"/")) {
		return true;
	}else{
		return false;
	}
}

if(isset($_POST['registreren']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord']) && !empty($_POST['wachtwoordh']) && !empty($_POST['email']) && !empty($_POST['dag']) && !empty($_POST['maand']) && !empty($_POST['jaar']) && $_POST['wachtwoord'] == $_POST['wachtwoordh'] && !strpos($_POST['gebruikersnaam']," ") && !strpos($_POST['gebruikersnaam'],"'") && !strpos($_POST['gebruikersnaam'],"/")  && !strpos($_POST['gebruikersnaam'],"´") && strlen($_POST['gebruikersnaam']) >= 4 && $_POST['gebruikersnaam'] != "systeem" && $_POST['gebruikersnaam'] != "<noscript>" && $_POST['gebruikersnaam'] != "<noscript />" && $_POST['gebruikersnaam'] != "<noscript >" && strpos($_POST['gebruikersnaam'],"<") == false) {

	echo $doe->registeren($_POST['gebruikersnaam'],$_POST['wachtwoord'],$_POST['dag'],$_POST['maand'],$_POST['jaar'],$_POST['email']);
	
}else{
	?>
	<script language="javascript" src="js/registratie.js" type="text/javascript"></script>
	<form name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>?p=registreren" onsubmit="return ValidateForm()" method="post">
		<table>
			<tr>
				<td colspan="3">Je gebruikersnaam is tevens ook je habbonaam</td>
			</tr>
			<tr>
				<td rowspan="7"><img src="http://images.habbohotel.nl/c_images/album1188/habbo_hug_001.png" /></td>
			</tr>
			<tr>
				<td>Gebruikersnaam</td>
				<td width="80%"><input type="text" name="gebruikersnaam" 
					<?php if(isset($_POST['registreren'])) { echo "value='".$_POST['gebruikersnaam']."'"; } ?> maxlength="25" />
					
					<?php 
						if(isset($_POST['registreren']) && empty($_POST['gebruikersnaam'])) {
							echo "Je hebt je gebruikersnaam leeggelaten.";
						}
						if(isset($_POST['registreren']) && !empty($_POST['gebruikersnaam'])) {
							echo "Foute gebruikersnaam";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam']," ")) {
							echo "Spaties zijn niet toegestaan.";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam'],"/")) {
							echo "Er bevinden zich rare tekens in de naam.";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam'],"´")) {
							echo "Er bevinden zich rare tekens in de naam.";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam'],"'")) {
							echo "Er bevinden zich rare tekens in de naam.";
						}
						if(isset($_POST['registreren']) && strlen($_POST['gebruikersnaam']) < 4) {
							echo "Je gebruikersnaam moet uit 4 of meer tekens bestaan.";
						}
							
					?>
					</td>
			</tr>
			<tr>
				<td>Wachtwoord</td>
				<td><input type="password" name="wachtwoord" 
					<?php if(isset($_POST['registreren'])) { echo "value='".$_POST['wachtwoord']."'"; } ?> maxlength="255" />
					
					<?php 
						if(isset($_POST['registreren']) && empty($_POST['wachtwoord'])) {
							echo "Je hebt je wachtwoord leeggelaten.";
						}
						
						if(isset($_POST['registreren']) && $_POST['wachtwoord'] != $_POST['wachtwoordh']) {
							echo "De wachtwoorden zijn niet hetzelfde.";
						}
					?>
					</td>
			</tr>
			<tr>
				<td>Wachtwoord</td>
				<td><input type="password" name="wachtwoordh" 
					<?php if(isset($_POST['registreren'])) { echo "value='".$_POST['wachtwoordh']."'"; } ?> maxlength="255" />
					
					<?php 
						if(isset($_POST['registreren']) && empty($_POST['wachtwoordh'])) {
							echo "Je hebt geen wachtwoord herhalen ingevult.";
						}
					?>
					</td>
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
						$jaar = range(date("Y") - 4,1930);
						foreach($jaar as $var) {
							echo "<option value='".$var."'>".$var."</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="text" name="email"
					<?php if(isset($_POST['registreren'])) { echo "value='".$_POST['email']."'"; } ?> maxlength="60" />
					
					<?php 
						if(isset($_POST['registreren']) && empty($_POST['email'])) {
							echo "Je hebt je email leeggelaten.";
						}
					?>
					</td>
			</tr>
			<tr>
				<th colspan="2"><input type="submit" name="registreren" value="Registreren"></th>
			</tr>
		</table>
	</form>
	<?php
}
?>