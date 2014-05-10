<br />
<strong>Hoofd Menu</strong><br />
	&raquo; <a href="?p=nieuws">Nieuws</a><br />
	<?php

######## Menu.php ##########

## Hier kan je de <a href="?p=PAGINA"> Menu titel </a>  aanpassen


// Hieronder komen de links van het CMS systeem, Dus de pagina's die je aanmaakt via het admin panel //

$sql = mysql_query("SELECT * FROM content ORDER BY volgordeid");
while($row = mysql_fetch_assoc($sql)) {
	?>
	&raquo; <a href="?p=pagina&pid=<?php echo $row['paginaid']; ?>"><?php echo $row['titel']; ?></a><br />
	<?php
}

// Hieronder zie je het leden systeem menu
?><br />
<strong>Leden Systeem</strong><br />

<?php

if(!isset($_SESSION['id'])) {    // Dit betekent, Als de gebruiker niet is ingelogd. ?>

	&raquo; <a href="?p=registreren">Registeren</a><br />
	&raquo; <a href="?p=login">Inloggen</a><br />
	&raquo; <a href="?p=wwvergeten">Wachtwoord Vergeten</a><br />

<?php }else{ // Dit betekent, Als de gebruiker WEL is ingelogd. ?><br />
	&raquo; <a href="?p=statistieken">Statistieken</a><br />
	&raquo; <a href="?p=shop&a=shop">Shop</a><br />
	&raquo; <a href="?p=bank">Bank</a><br />
	&raquo; <a href="?p=faq">Algemene Poll</a><br />
	&raquo; <a href="?p=youtube&a=lijst">Youtube</a><br />
	<br />
	<strong>Games</strong><br />
	&raquo; <a href="?p=kluis">Kraak de kluis</a><br />
	&raquo; <a href="?p=3xkans">Red Black White</a><br />
	<br />
	<strong>Profiel</strong><br />
	&raquo; <a href="?p=wwveranderen">Wachtwoord Veranderen</a><br />
	&raquo; <a href="?p=overschrijven">Overschrijven</a><br />
	&raquo; <a href="?p=gastenboek">Gastenboek</a><br />
	&raquo; <a href="?p=overzicht&mid=<?php echo $_SESSION['id']; ?>">Waarschuwingen en Infracties</a><br />
	&raquo; <a href="?p=muntjesperdag">Muntjes per dag</a><br />
	&raquo; <a href="?p=vriend_bekijken">Vrienden</a><br />
	&raquo; <a href="?p=gegevensveranderen">Gegevens Veranderen</a><br />
	&raquo; <a href="?p=poll">Poll</a><br />
	&raquo; <a href="?p=profiel">Profiel</a><br />
	&raquo; <a href="?p=cadeau">Cadeau's</a><br />
	&raquo; <a href="?p=stuurtroffee">Stuur troffee</a><br />
	&raquo; <a href="?p=bericht">Berichten</a><br />
	<br />
	<strong>Overige</strong><br />
	&raquo; <a href="?p=blogs&a=blog&s=toevoegen">Blog Toevoegen</a><br />
	&raquo; <a href="?p=alleblogs">Blogs Bekijken</a><br />
	&raquo; <a href="?p=askamod">Ask a mod</a><br />
	&raquo; <a href="?p=forum">Forum</a><br />
	&raquo; <a href="?p=faq">F.A.Q.</a><br />
	<br />
	&raquo; <a href="?p=uitloggen">Uitloggen</a><br /><br />
	<?php } 
	echo "<strong>Guild</strong><br />";
	if(isset($_SESSION['id'])) {
		$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
		if(mysql_num_rows($sql) ==  1) {
			?>
			&raquo; <a href="?p=guildwijzigen">Wijzigen</a><br />
			&raquo; <a href="?p=guildbeheren">Beheren</a><br />
			<?php
		}
		$sql = mysql_query("SELECT * FROM guild_leden WHERE member_id='".$_SESSION['id']."'");
		if(mysql_num_rows($sql) ==  1) { ?>
			&raquo; <a href="?p=guildleden">Leden</a><br />
			<?php
		}else{
			echo "&raquo; <a href='?p=guildmaken'>Aanmaken</a><br />";
		}
		echo "&raquo; <a href='?p=guildverzoeken'>Verzoeken</a><br />";
		echo "&raquo; <a href='?p=guildzoeken'>Zoeken</a><br /><br />";
	}
if(isset($_SESSION['admin'])) { // Dit betekent, Als je als admin bent ingelogd. ?>
	<strong>Admin Panel</strong><br />
	&raquo; <a href="?p=admin_gebruikers">Leden Beheren</a><br />
	&raquo; <a href="?p=admin_tijd">Tijd Verbannen</a><br />
	&raquo; <a href="?p=admin&a=instellingen">Instellingen Veranderen</a><br />
	&raquo; <a href="?p=admin_gebruikers">Leden Verbannen</a><br />
	&raquo; <a href="?p=admin_blogs">Blogs beheren</a><br />
	&raquo; <a href="?p=admin_reacties">Reacties beheren</a><br />
	&raquo; <a href="?p=admin_faq">F.A.Q. Beheren</a><br />
	&raquo; <a href="?p=admin_askamod">Ask a mod beheren</a><br />
	&raquo; <a href="?p=admin_berichtenbalk">Berichtenbalk Beheren</a><br />
	&raquo; <a href="?p=admin_muntjes">Muntjes geven</a><br />
	&raquo; <a href="?p=admin_alert">Waarschuwingen Geven</a><br />
	&raquo; <a href="?p=admin_banners">Banners beheren</a><br />
	&raquo; <a href="?p=admin_geven">Badges/Rangen Geven</a><br />
	&raquo; <a href="?p=admin_nieuws">Nieuws Toevoegen / Beheren</a><br />
	&raquo; <a href="?p=ipban">IP's bannen</a><br />
	&raquo; <a href="?p=admin_shop">Shop items</a><br />
	&raquo; <a href="?p=admin_forum">Forum Beheren</a><br />
	&raquo; <a href="?p=admin_cms">Pagina's Beheren</a><br /><br>
	&raquo; <a href="?p=admin_infractie">Infracties geven</a><br />
	&raquo; <a href="?p=admin_waarschuwing">Waarschuwingen geven</a><br />
<?php }elseif(isset($_SESSION['nieuwsreporter'])) { // Dit zie je als je nieuws reporter bent , level 2 ?>
		&raquo; <a href="?p=admin_nieuws">Nieuws Toevoegen / Beheren</a><br />
<?php }elseif(isset($_SESSION['forumbeheerder'])) { // Dit zie je als je forum beheerder bent , level 3 ?>
	&raquo; <a href="?p=admin_forum">Forum Beheren</a><br />
<?php } ?>