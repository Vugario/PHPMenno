<?php
    if(!isset($_SESSION['id'])) {
        $_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je moet ingelogd zijn voor deze pagina.</div>';
        header('Location:login');
    }
?>
<img src="http://www.habbo.nl/habbo-imaging/avatarimage?user=<?php echo $_SESSION['gebruikersnaam']; ?>&gesture=sml&direction=4&head_direction=3&size=b" align="right"/>
<h3>Welkom op <?php echo $sitenaam; echo " "; echo ucfirst($_SESSION['gebruikersnaam']); ?>!</h3>
<strong>Jouw persoonlijk paneel</strong><br />
<a href="<?php echo $root; ?>ledenlijst">Ledenlijst</a><br />
<a href="<?php echo $root; ?>wachtwoordvergeten">Wachtwoord Veranderen</a><br>
<?php
	if(isset($_SESSION['admin'])) {
		echo "<a href='admin'>Admin Panel</a><br>";
	}
?>
<a href="<?php echo $root; ?>uitloggen">Uitloggen</a><br>