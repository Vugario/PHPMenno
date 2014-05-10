<ul>
	<li><a href="<?php echo $root; ?>home">Home</a></li>
	<li><a href="<?php echo $root; ?>nieuws/overzicht">Nieuws</a></li>
	<li><a href="<?php echo $root; ?>medewerkers">Medewerkers</a></li>
	<li><a href="<?php echo $root; ?>statistieken">Statistieken</a></li>
	<br />
	
	<!-- Is de gebruiker niet ingelogd? Weergeef dan het volgende menu. -->
		<?php if(!isset($_SESSION['id'])) { ?>
		<li><a href="<?php echo $root; ?>login">Inloggen</a></li>
		<li><a href="<?php echo $root; ?>registreren">Registreren</a></li><br />
		<?php } ?>
	<!-- Einde niet ingelogd menu -->
	
	<li><a href="<?php echo $root; ?>blog/bekijken">Blogs</a></li>
	<?php if(isset($_SESSION['id'])) { ?><li><a href="<?php echo $root; ?>blog/aanmaken">Blog aanmaken</a></li><?php } ?>
	<br />
	
	<!-- Is de gebruiker ingelogd? Weergeef dan het volgende menu. -->
	<?php if(isset($_SESSION['id'])) { ?>		
		<li><a href="<?php echo $root; ?>beveiligdepagina">Mijn pagina</a></li>
		<?php $sql = mysql_query("SELECT member_id FROM profiel WHERE member_id='".$_SESSION['id']."'"); if(mysql_num_rows($sql) == 0) { echo "<li><a href='".$root."profiel/aanmaken'>Profiel beheer</a></li>"; }else{ echo "<li><a href='".$root."profiel/gebruiker/".$_SESSION['gebruikersnaam']."'>Profiel beheer</a></li>"; } ?>
		<?php if($winkel != "uit") { ?><li><a href="<?php echo $root; ?>winkel/habbo">Winkel</a></li><?php } ?>
		<li><a href="<?php echo $root; ?>bank">Bank</a></li>
		<li><a href="<?php echo $root; ?>zoeken">Zoek leden</a></li><br />
		
		<li><a href="<?php echo $root; ?>uitloggen">Uitloggen</a></li>
	<?php } ?>
	<!-- Einde ingelogd menu -->
	
	<!-- Is de gebruiker ingelogd en admin? Weergeef dan het volgende menu. -->
		<?php if(isset($_SESSION['admin'])) { ?><br /><br /><br/ >
		<strong>Admin</strong>
		<li><a href="<?php echo $root; ?>admin/leden/overzicht">Beheer leden</a></li>
		<li><a href="<?php echo $root; ?>admin/nieuws/overzicht">Beheer nieuws</a></li>
		<li><a href="<?php echo $root; ?>admin/winkel/overzicht">Beheer de winkel</a></li>
		<li><a href="<?php echo $root; ?>admin/instellingen">Instellingen</a></li>
		<?php } ?>
	<!-- Einde admin menu -->
</ul>