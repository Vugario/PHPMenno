<?php

function randomwachtwoord($length)
{
    $tekens = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $key  = $tekens{rand(0,60)};
    for($i=1;$i<$length;$i++)
    {
        $key .= $tekens{rand(0,60)};
    }
    return $key;
}

if (isset($_POST['submit']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['email']) && !empty($_POST['opvraagwoord']))
 {
 
 	$gebruikersnaam = mysql_real_escape_string(substr($_POST['gebruikersnaam'],0,255));
	$email = mysql_real_escape_string(substr($_POST['email'],0,255));
	$opvraagwoord = mysql_real_escape_string(substr($_POST['opvraagwoord'],0,255));
	$wachtwoord = randomwachtwoord(8); 
	$wachtwoordmd5 = md5($wachtwoord);
	
	$sql2 = "SELECT gebruikersnaam,email FROM leden WHERE gebruikersnaam='".$gebruikersnaam."' AND email='".$email."' AND opvraagwoord='".$opvraagwoord."'";
	$res2 = mysql_query($sql2)or die(mysql_error());
	if(mysql_num_rows($res2) < 1) {
		echo "Sorry,<br><br>Er is iets fout gegaan. Een of meerdere gegevens zijn fout, klik <a href='?p=wwvergeten'>hier</a> om het nog eens te proberen.<br>
		Als je geen account heb kan je je <a href='?p=registreren'>hier</a> registreren.";
		}else{
			$row = mysql_fetch_assoc($res2);
			mysql_query("UPDATE leden SET wachtwoord='".$wachtwoordmd5."' WHERE gebruikersnaam='".$gebruikersnaam."'");
			$headers = "Content-type: text/html";
			mail($row['email'],"Wachtwoord vergeten - ".SITENAAM,"
			Hoi ".$gebruikersnaam.",<br><br />Je heeft gebruik gemaakt van de wachtwoord vergeten functie<br>Hierbij sturen we je een nieuw wachtwoord <br><br>
			Je nieuwe wachtwoord is: <strong>".$wachtwoord."</strong> <br>
			<br>
			Het is verstandig om je wachtwoord te wijzigen zodat je deze niet vergeet.
			<br>
			<a href='".SITELINK."/'>Log hier in op ".SITENAAM."</a>
			<br>
			<br><br><strong><a href='".SITELINK."'>".SITELINK."</a></strong><br><br><i>Stuur a.u.b. geen bericht terug, deze zullen wij niet ontvangen.<br />",$headers);  // stuur de email
			echo "De mail is gestuurd. Open de mail en zoek je nieuwe wachtwoord.<br />
				Daarmee kan je inloggen vanaf nu.<br />
				Zodra je bent ingelogd is het verstandig om hem te veranderen."; // leuk uitlegje
		}
	}else{
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=wwvergeten" method="post">
		<table width="350">
			
			<tr>
				<td>Gebruikersnaam</td>
				<td><input type="text" name="gebruikersnaam" <?php if(isset($_POST['naam'])) { echo "value='".$_POST['naam']."'"; } ?> maxlength="255">
				<?php if(isset($_POST['submit']) && empty($_POST['naam'])) { echo "<br> Vul een gebruikersnaam in."; } ?>
					</td>
					</tr>
					<tr>
				<td>Email</td>
				<td><input type="text" name="email" <?php if(isset($_POST['email'])) { echo "value='".$_POST['email']."'"; } ?> maxlength="255">
				<?php if(isset($_POST['submit']) && empty($_POST['email'])) { echo "<br> Vul een email in."; } ?>
					</td>
			</tr>
					<tr>
				<td>Opvraagwoord</td>
				<td><input type="text" name="opvraagwoord" <?php if(isset($_POST['opvraagwoord'])) { echo "value='".$_POST['opvraagwoord']."'"; } ?> maxlength="255">
				<?php if(isset($_POST['submit']) && empty($_POST['opvraagwoord'])) { echo "<br> Vul je opvraagwoord in."; } ?>
					</td>
			</tr>

			<tr>
				<th colspan="2"><input type="submit" name="submit" value="Verstuur"></th>
			</tr>

		</table>
					
	</form>
	
	<?php
	};
	?>