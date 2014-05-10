<?php
$beschrijving = "
<strong>PHPMenno Versie 5</strong><br />
Versie 5 is een onwijs uitgebreide versie.<br />
Er zijn onwijs veel nieuwe functies en mogelijkheden.<br />
En als dat nog niet genoeg is, Wanneer je ergens niet uitkomt, is er volle support op Habbers.nl.<br />Hier is een apart sub-forum opgericht voor PHPMenno<br />
<br />";

if(!function_exists("file_put_contents")) {
   function file_put_contents($url, $data) {
      $filehandle = fopen($url, 'a');
      fwrite($filehandle, $data);
      fclose($filehandle);
   }
}

?>
<span style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
<div style="background: url(images/banner_bg.gif); height:78px;">

	<div style="float:left; text-align:center;height:78px;">
	<center>
	<img src="images/banner.gif"><img src="images/stap1.gif">
	</center>
	</div>
</div>
<div style="width: 783px; text-align: left;">
	<div style="float:left; height:455px; padding-right: 10px; width: 207px;background:url(images/links_bg.gif);">
		<?php echo $beschrijving; ?>
	</div>
	<div style="float:left;width: 546px; padding-left: 20px; padding-top: 20px;">
<?php

if(is_writable("config.php") == false) {
	echo "<strong>Foutje opgetreden</strong><br />
		config.php moet schrijfbaar zijn, Maak zijn permissions 777<br />
		Weet je niet hoe dit moet? <a target='_blank' href='http://www.worldnet.nl/helpdesk/hosting/chmod.htm'>CHMOD, lees hier</a><br />";
		die();
}
?>
<?php

if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['host']) && !empty($_POST['database']) && mysql_connect($_POST['host'],$_POST['username'],$_POST['password']) == true && mysql_select_db($_POST['database']) == true) {

	file_put_contents("config.php",'<?php
$mysql_host = "'.$_POST['host'].'"; // dit is meestal localhost
$mysql_user = "'.$_POST['username'].'"; // voer hier je username van mysql in
$mysql_password = "'.$_POST['password'].'"; // voer hier je mysql wachtwoord in
$mysql_database = "'.$_POST['database'].'"; // hier vul je de naam van je database in
if(mysql_connect($mysql_host,$mysql_user,$mysql_password) == false && mysql_select_db($mysql_database) == false) {
	echo "De connectie met je database is niet correct, open config.php en verander de mysql gegevens, Die je van je host hebt gekregen.";
	die();
}else{
	mysql_connect($mysql_host,$mysql_user,$mysql_password);
	mysql_select_db($mysql_database);
}
$var = "ja";

session_start();
?>');
	if(file_exists("config.php")) {
		echo "De MySQL config.php is succesvol aangemaakt.<br />U kunt nu verder gaan met de installatie.<br /><a href=\"install.php\">Installeren</a><br />";
	}else{
		echo 'Het lukt niet om config.php aan te maken.<br />Probeer hem zelf aan te maken, Maak in de hoofd map <i>(dus in de map waar index.php in staat)</i> een bestand aan genaamd config.php met deze inhoud:<br />
		<br /><br />
<?php
$mysql_host = "'.$_POST['host'].'"; // dit is meestal localhost
$mysql_user = "'.$_POST['username'].'"; // voer hier je username van mysql in
$mysql_password = "'.$_POST['password'].'"; // voer hier je mysql wachtwoord in
$mysql_database = "'.$_POST['database'].'"; // hier vul je de naam van je database in
if(mysql_connect($mysql_host,$mysql_user,$mysql_password) == false && mysql_select_db($mysql_database) == false) {
	echo "De connectie met je database is niet correct, open config.php en verander de mysql gegevens, Die je van je host hebt gekregen.";
	die();
}else{
	mysql_connect($mysql_host,$mysql_user,$mysql_password);
	mysql_select_db($mysql_database);
}

session_start();
?>';
	}
}else{
	if(isset($_POST['submit'])) {
		if(mysql_connect($_POST['host'],$_POST['username'],$_POST['password']) == false || mysql_select_db($_POST['database']) == false) {
			echo "Er zijn wat gegevens die niet kloppen, Want er kan geen connectie met de database gelegd worden.<br>";
		}
	}
	?>
	<h2>Installatie PHPMenno</h2>
	Welkom bij de installatie van PHPMenno.<br />
	Bij deze installatie moet je een aantal gegevens invullen zodat het systeem zich kan installeren.<br />
	<br />
	Vul hieronder uw MySQL Gegevens in.<br />
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		Host (meestal localhost)<br />
		<input type="text" name="host" /><br />
		Database naam<br />
		<input type="text" name="database" /><br />
		Username<br />
		<input type="text" name="username" /><br />
		Password<br />
		<input type="password" name="password" /><br />
		<input type="submit" name="submit" value="Installeer MySQL"><br>
	</form>
	<br />
	<br />
	<strong>Wat is dit?</strong><br />
	MySQL gegevens zijn de gegevens naar je database.<br />
	Als je een websitehost hebt, kan je inloggen op je host.<br />
	Wanneer je dat hebt gedaan kan je een MySQL Database aanmaken en een MySQL gebruiker en een wachtwoord.<br />
	Deze gegevens moet je hierboven invullen.<br />
	<br />
	<?php
}
?>
	</div>
</div>
</span>