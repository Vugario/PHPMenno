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
					<td>Oude wachtwoord</td>
					<td><input type="password" name="wachtwoordoud" maxlength="255" /></td>
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
		<?php
	}
}else{
	echo "Je moet ingelogd zijn voor deze pagina.";
}
?>