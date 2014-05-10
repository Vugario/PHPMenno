<?php

function checkRaretekens($string) {
	if(!strpos($string," ") && !strpos($string,"'") && !strpos($string,"\\") && !strpos($string,"/")) {
		return true;
	}else{
		return false;
	}
}

if(isset($_POST['registreren']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord']) && !empty($_POST['wachtwoordh']) && !empty($_POST['opvraagwoord']) && !empty($_POST['email']) && $_POST['wachtwoord'] == $_POST['wachtwoordh'] && !strpos($_POST['gebruikersnaam']," ") && !strpos($_POST['gebruikersnaam'],"'") && !strpos($_POST['gebruikersnaam'],"/")  && !strpos($_POST['gebruikersnaam'],"´") && strlen($_POST['gebruikersnaam']) >= 4 && $_POST['gebruikersnaam'] != "systeem" && $_POST['gebruikersnaam'] != "<noscript>" && $_POST['gebruikersnaam'] != "<noscript />" && $_POST['gebruikersnaam'] != "<noscript >" && strpos($_POST['gebruikersnaam'],"<") == false && !ereg("noscript",$_POST['gebruikersnaam'])) {

	echo $doe->registeren($_POST['gebruikersnaam'],$_POST['wachtwoord'],$_POST['opvraagwoord'],$_POST['email']);
	
}else{
	?>
	<script language="javascript" src="js/registratie.js" type="text/javascript"></script>
	<form name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>?p=registreren" onsubmit="return ValidateForm()" method="post">
		<table>
			<?php if($instellingen['habbo'] == "ja") { ?>
			<tr>
				<td colspan="3">Je gebruikersnaam is tevens ook je habbonaam</td>
			</tr>
			<tr>
				<td rowspan="7"><img src="http://images.habbohotel.nl/c_images/album1188/habbo_hug_001.png" /></td>
			</tr>
			<?php } ?>
			<tr>
				<td>Gebruikersnaam</td>
				<td width="80%"><input type="text" name="gebruikersnaam" 
					<?php if(isset($_POST['registreren'])) { echo "value='".$_POST['gebruikersnaam']."'"; } ?> maxlength="25" />
					
					<?php 
						if(isset($_POST['registreren']) && empty($_POST['gebruikersnaam'])) {
							echo "Je hebt je gebruikersnaam leeggelaten.&nbsp;";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam']," ")) {
							echo "Spaties zijn niet toegestaan.&nbsp;";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam'],"/")) {
							echo "Er bevinden zich rare tekens in de naam.&nbsp;";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam'],"´")) {
							echo "Er bevinden zich rare tekens in de naam.&nbsp;";
						}
						if(isset($_POST['registreren']) && strpos($_POST['gebruikersnaam'],"'")) {
							echo "Er bevinden zich rare tekens in de naam.&nbsp;";
						}
						if(isset($_POST['registreren']) && strlen($_POST['gebruikersnaam']) < 4) {
							echo "Je gebruikersnaam moet uit 4 of meer tekens bestaan.&nbsp;";
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
				<td>Opvraagwoord</td>
				<td><input type="text" name="opvraagwoord"  
					<?php if(isset($_POST['registreren'])) { echo "value='".$_POST['opvraagwoord']."'"; } ?>  />
					<?php
					if(isset($_POST['registreren']) && empty($_POST['opvraagwoord'])) {
						echo "Je hebt je opvraagwoord leeggelaten.&nbsp;";
					}
					?>
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