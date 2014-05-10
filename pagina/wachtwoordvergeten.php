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

if (isset($_POST['submit']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['email']) && !empty($_POST['geboortedatum']))
 {
 
 	$gebruikersnaam = mysql_real_escape_string(substr($_POST['gebruikersnaam'],0,255));
	$email = mysql_real_escape_string(substr($_POST['email'],0,255));
	$geboortedatum = mysql_real_escape_string(substr($_POST['geboortedatum'],0,255));
	$wachtwoord = randomwachtwoord(8); 
	$wachtwoordmd5 = md5($wachtwoord);
	
	$sql2 = "SELECT gebruikersnaam,email FROM leden WHERE gebruikersnaam='".$gebruikersnaam."' AND email='".$email."' AND geboortedatum='".$geboortedatum."'";
	$res2 = mysql_query($sql2)or die(mysql_error());
	if(mysql_num_rows($res2) < 1) {
		echo "Sorry,<br><br>Er is iets fout gegaan. Een of meerdere gegevens zijn fout, klik <a href='?p=wwvergeten'>hier</a> om het nog eens te proberen.<br>
		Als je geen account heb kan je je <a href='?p=registreren'>hier</a> registreren.";
		}else{
			$row = mysql_fetch_assoc($res2);
			mysql_query("UPDATE leden SET wachtwoord='".$wachtwoordmd5."' WHERE gebruikersnaam='".$gebruikersnaam."'");
			$headers = "Content-type: text/html";
			mail($row['email'],"Wachtwoord vergeten - ".SITENAAM,"
			Hoi ".$gebruikersnaam.",<br><br>Iemand heeft op de pagina Wachtwoord vergeten jou email + gebruikersnaam ingevuld. Hierbij sturen we je dus een nieuw wachtwoord <br><br>
			Je nieuwe wachtwoord is: <strong>".$wachtwoord."</strong> <br>
			<br>
			Het is verstandig om je wachtwoord te wijzigen zodat je deze niet vergeet.
			<br>
			<a href='".SITELINK."/'>Log hier in op Habbo Bak!</a>
			<br>
			<br>
			Groeten,<br>Habbo Bak<br><strong><a href='".SITELINK."'>".SITELINK."</a></strong><br><br><i>Let op: stuur geen reactie op deze mail. Er word niet op gereageerd.",$headers);  // stuur de email
			echo "De mail is gestuurd. Open de mail en zoek je nieuwe wachtwoord.<br />
				Daarmee kan je inloggen vanaf nu.<br />
				Zodra je bent ingelogd is het verstandig om hem te veranderen."; // leuk uitlegje
		}
	}else{
	?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=wwvergeten" method="post">
		<table width="350">
			
			<tr>
				<td><font face="Verdana" size="1">Gebruikersnaam</font></td>
				<td><input type="text" name="gebruikersnaam" <?php if(isset($_POST['naam'])) { echo "value='".$_POST['naam']."'"; } ?> maxlength="255">
				<?php if(isset($_POST['submit']) && empty($_POST['naam'])) { echo "<br> Vul een gebruikersnaam in."; } ?>
					</td>
					</tr>
					<tr>
				<td><font face="Verdana" size="1">Email</font></td>
				<td><input type="text" name="email" <?php if(isset($_POST['email'])) { echo "value='".$_POST['email']."'"; } ?> maxlength="255">
				<?php if(isset($_POST['submit']) && empty($_POST['email'])) { echo "<br> Vul een email in."; } ?>
					</td>
			</tr>
					<tr>
				<td><font face="Verdana" size="1">Geboortedatum*</font></td>
				<td><input type="text" name="geboortedatum" <?php if(isset($_POST['geboortedatum'])) { echo "value='".$_POST['geboortedatum']."'"; } ?> maxlength="255">
				<?php if(isset($_POST['submit']) && empty($_POST['geboortedatum'])) { echo "<br> Vul een geboortedatum in."; } ?>
					</td>
			</tr>

			<tr>
				<th colspan="2"><input type="submit" name="submit" value="Verstuur"></th>
			</tr>

		</table>
					
	</form>
	<font face="Verdana" size="1">* Vul het zo in: DD-MM-YYYY (voorbeeld: 12-11-1993).<br><I>Let op:</i> Indien je dag maar een getal is (onder de 10) en/of de maand maar een getal is (onder de 10) dan moet je (bijvoorbeeld) dit in typen: 6-9-1992.</font>
	
	<?php
	};
	?>