<?php

	/*
	PHPMenno V6 - Simpel, Snel en Beter
	---------------------------------------------------
	Copyright (c) 2009, Menno Wolvers 'Menno'
	Copyright (c) 2010, Jeroen van de Weerd 'Jeroen262'
	http://www.jeroenvdweerd.nl
	---------------------------------------------------
	This program is free software: you can redistribute 
	it and/or modify it under the terms of the 
	GNU General Public License as published by the Free 
	Software Foundation, either version 6 of the 
	License, or	(at your option) any later version.
	*/
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
    	$savewachtwoord = hash('sha512', $wachtwoord);
    	
    	$sql2 = "SELECT gebruikersnaam,email FROM leden WHERE gebruikersnaam='".$gebruikersnaam."' AND email='".$email."' AND geboortedatum='".$geboortedatum."'";
    	$res2 = mysql_query($sql2)or die(mysql_error());
    	if(mysql_num_rows($res2) < 1) {
    		echo "Sorry,<br><br>Er is iets fout gegaan. Een of meerdere gegevens zijn fout, klik <a href='?p=wwvergeten'>hier</a> om het nog eens te proberen.<br>
    		Als je geen account heb kan je je <a href='?p=registreren'>hier</a> registreren.";
    		}else{
    			$row = mysql_fetch_assoc($res2);
    			mysql_query("UPDATE leden SET wachtwoord='".$savewachtwoord."' WHERE gebruikersnaam='".$gebruikersnaam."'");
    			
    			$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je wachtwoord is succesvol aangepast naar '.$wachtwoord.'!</div>';
                header('Location:login');
            }
    }else{
?>

    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">	
        <table class="data">
            <tr>
                <td>Gebruikersnaam</td>
                <td><input type="text" name="gebruikersnaam"/></td>
            </tr>
            <tr>
                <td>Email adres</td>
                <td><input type="text" name="email"/></td>
            </tr>
            <tr>
                <td>Geboortedatum*</td>
                <td><input type="text" name="geboortedatum"/></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" name="submit" value="Verstuur"/></th>
            </tr>
        </table>
        <font face="Verdana" size="1">
            <br />* Vul het zo in: DD-MM-YYYY (voorbeeld: 12-11-1993).
            <br/><i>Let op:</i> Indien je dag of maand maar één getal is (onder de 10) moet je (bijvoorbeeld) dit in typen: 6-9-1992.
        </font>
    </form>

<?php } ?>