<?php
if(!function_exists("file_put_contents")) {
   function file_put_contents($url, $data) {
      $filehandle = fopen($url, 'a');
      fwrite($filehandle, $data);
      fclose($filehandle);
   }
}

?>
<img src="images/installatie.gif" /><br>
<br>
<span style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
<?php

chmod('config.php', 0777);

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
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<h2 style="margin:0px;">Vul hier uw MySQL gegevens in</h2>
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
	<?php
}
?>
</span>