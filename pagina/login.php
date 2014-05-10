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
	if(isset($_POST['inloggen']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord'])) {
		echo inloggen($_POST['gebruikersnaam'],$_POST['wachtwoord']);	
	}else{
?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<table class="data">
			<tr>
				<td>Gebruikersnaam</td>
				<td><input type="text" name="gebruikersnaam" maxlength="255" /></td>
			</tr>
			<tr>
				<td>Wachtwoord</td>
				<td><input type="password" name="wachtwoord" maxlength="255" /></td>
			</tr>
			<tr>
				<th colspan="2"><input type="submit" name="inloggen" value="Inloggen"></th>
			</tr>
		</table>
	</form>
<?php } ?>