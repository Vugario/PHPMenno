<?php
/// Start van installatie check ///
if(!isset($var) && file_get_contents("config.php") == "") {
	include('pagina/maakconfig.php');
	die();
}else{
	require_once('class/head.class.php');
}
/// Einde van installatie check ///
?>
<strong>Menu</strong><br />
<?php include('menu.php'); ?><br />
<strong>Pagina</strong><br />
<?php include('pagina.php'); ?>
