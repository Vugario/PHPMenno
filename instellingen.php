<?php

$bedragperreactie = 1;  // hoeveel muntjes krijgt een lid per geposte reactie?

define("GOUD",100);// de kosten van het sturen van een gouden troffee
define("ZILVER",75);// in welke taal wil je dit systeem hebben? de taal moet als bestand in de map language staan
define("BRONS",50);// in welke taal wil je dit systeem hebben? de taal moet als bestand in de map language staan
define("GUILDMAXLEDEN",150);// het maximale aantal leden dat een guild kan hebben
define("GUILDMEERLEDEN",40);// kosten voor de mogelijkheid om 20 nieuwe leden bij je guild te krijgen
define("GUILDKOSTEN",40);// kosten voor een guild
define("EMAIL","noreply@website.nl");// jou emailadres , voor het versturen van de automatische emails
define("SITENAAM","Habbo Sitenaam");// site naam
define("MAXTEKSTINBERICHTENBALK",30);// Het maximale aantal letters dat je in de berichtenbalk mag plaatsen
define("ACCOUNTPERIP","nee"); // Mag je maar 1 account per ip adres?   ja of nee
define("MUNTJESBIJREGISTRATIE",60); // hoeveel muntjes je bij registratie krijgt
define("SITELINK","http://www.habbosite.nl/"); // Zorg dat dit begint met http://  en eindigt met een /
define("ONDERHOUDTEKST","Beste Habbo's<br />Wij zijn tijdelijk even in onderhoud.<br />We krijgen een geheel nieuw systeem en een nieuwe layout.<br />Wij hopen aankomende woensdag weer open te gaan.<br /><br />Excusus voor het ongemak, Managment<br /><br />(deze tekst is aan te passen in instellingen.php)"); // je tekst die je ziet als je in onderhoud bent

if(isset($_SESSION['id'])) {
	$get = mysql_fetch_assoc(mysql_query("SELECT * FROM leden WHERE member_id='".$_SESSION['id']."'"));
	mysql_query("UPDATE leden SET lastonline = NOW() WHERE member_id='".$_SESSION['id']."'");
}
?>