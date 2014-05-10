<?php

function randomwachtwoord($length)
{
    $tekens = "1234567890abcdefghijklmnopqrstuvwxyz";
    $key  = $tekens{rand(0,35)};
    for($i=1;$i<$length;$i++)
    {
        $key .= $tekens{rand(0,35)};
    }
    return $key;
}

if (isset($_POST['submit']) && !empty($_POST['gebruikersnaam']))
 {
 
 	$gebruikersnaam = mysql_real_escape_string(substr($_POST['gebruikersnaam'],0,255));
	$wachtwoord = randomwachtwoord(10); 
	$wachtwoordmd5 = md5($wachtwoord);
	
	$sql2 = "SELECT email FROM leden WHERE gebruikersnaam='".$gebruikersnaam."'";
	$res2 = mysql_query($sql2)or die(mysql_error());
	if(mysql_num_rows($res2) < 1) {
		echo "Er bestaat geen account met deze gebruikersnaam. Misschien heb je een typefout gemaakt, klik <a href='?p=wwvergeten'>hier</a> om het nog eens te proberen /n
		Als je geen account heb kan je <a href='?p=registreren'>hier</a> registreren.";
		}else{
			$row = mysql_fetch_assoc($res2);
			mysql_query("UPDATE leden SET wachtwoord='".$wachtwoordmd5."' WHERE gebruikersnaam='".$gebruikersnaam."'");
			$headers = "Content-type: text/html";
			mail($row['email'],"Wachtwoord ".SITENAAM,"
			
			Je nieuwe wachtwoord is: <strong>".$wachtwoord."</strong> <br>
			<br>
			Het is verstandig om nu je wachtwoord te wijzigen.
			<br>
			<a href='".SITELINK."/'>Log hier in</a>
			<br>
			<br>
			Groeten <strong><a href='".SITELINK."'>".SITELINK."</a></strong>.",$headers);  // stuur de email
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
				<th colspan="2"><input type="submit" name="submit" value="Verstuur"></th>
			</tr>

		</table>
					
	</form>
	
	<?php
	};
	?>