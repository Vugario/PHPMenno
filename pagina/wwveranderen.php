<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?><?php

if(isset($_SESSION['id'])) {
	if(isset($_POST['veranderen']) && !empty($_POST['wachtwoordoud']) && !empty($_POST['wachtwoordnieuw']) && !empty($_POST['wachtwoordnieuw2'])  && $_POST['wachtwoordnieuw'] == $_POST['wachtwoordnieuw2']) {
	
		echo $doe->wachtwoordAanpassen($_POST['wachtwoordoud'],$_POST['wachtwoordnieuw']);
	
	}else{
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=wwveranderen" method="post">
			<table width="350">
				<tr>
					<td rowspan="4"><img src="https://www.habbo.nl/deliver/images.habbohotel.nl/c_images/album1358/frank_thumbup.gif?h=3bf5998d019ae5e63b3eec53a20bc20f" align="left" /></td>
				</tr>
				<tr>
					<td>Oud wachtwoord</td>
					<td><input type="password" name="wachtwoordoud" maxlength="255" /></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input type="email" name="email" maxlength="255" /></td>
				</tr>
				<tr>
					<td>* Geboortedatum</td>
					<td><input type="geboortedatum" name="geboortedatum" maxlength="255" /></td>
				</tr>
				<tr>
					<td>Wachtwoord Nieuw</td>
					<td><input type="password" name="wachtwoordnieuw" maxlength="255" /></td>
				</tr>
				<tr>
					<td>Wachtwoord Nieuw</td>
					<td><input type="password" name="wachtwoordnieuw2" maxlength="255" /></td>
				</tr>
				<tr>
					<th colspan="3"><input type="submit" name="veranderen" value="Veranderen"></th>
				</tr>
			</table>
		</form>
<font face="Verdana" size="1">* Vul het zo in: DD-MM-YYYY (voorbeeld: 12-11-1993).<br><I>Let op:</i> Indien je dag maar een getal is (onder de 10) en/of de maand maar een getal is (onder de 10) dan moet je (bijvoorbeeld) dit in typen: 6-9-1992.</font>
		<?php
	}
}else{
	echo "Je moet ingelogd zijn voor deze pagina.";
}
?>