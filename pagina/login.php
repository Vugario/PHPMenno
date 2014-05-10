<?php

if(isset($_POST['inloggen']) && !empty($_POST['gebruikersnaam']) && !empty($_POST['wachtwoord'])) {

	echo $doe->inloggen($_POST['gebruikersnaam'],$_POST['wachtwoord']);
	
}else{
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">
		<table width="350">
			<tr>
				<td rowspan="4"><img src="https://www.habbo.nl/deliver/images.habbohotel.nl/c_images/album1358/frank_thumbup.gif?h=3bf5998d019ae5e63b3eec53a20bc20f" align="left" /></td>
			</tr>
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
	<?php
}
?>