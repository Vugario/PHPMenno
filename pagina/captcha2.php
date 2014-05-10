<?PHP

require_once("captcha.php");

function code_generator($length)
{
    $generated_key = "";
    while (strlen($generated_key) < $length)
    {
        $generate = mt_rand(48, 90);
        if ($generate < 58 || $generate > 64) $generated_key .= strtolower(chr($generate));
    }
    return $generated_key;
}



?>
<?PHP

if ($_SERVER['REQUEST_METHOD'] != "POST") // Controleren of er niet ergens is gedrukt op een knop
{
   // er is nergens op een knop gedrukt, maar gewoon handmatig gerefreshed..
   $_SESSION['code'] = ""; // de $_SESSION['code'] leeg gooien
   $code = code_generator(rand (4,5)); // een nieuwe key maken
}
if (empty ($_SESSION['code'])) // controleren of de sessie leeg is
{
   // de sessie is leeg, de code toewijzen aan de sessie
   $code = code_generator(rand (4,5)); // een nieuwe key maken
   $_SESSION['code'] = $code;
	captcha_generator ($_SESSION['code']); // het genereren van de image
	echo '<img src="captcha.png" alt="">'; // captcha image weergeven
	?> 
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_cms&actie=toevoegen&volgordeid=1" method="post">
	Code<br>
	<input type="text" name="code">
	
	<input type="submit" value="OK" name="submit">
	</form>
	<?php
}elseif($_POST['code'] == $_SESSION['code']) {
	echo "goedzo";
}
?>