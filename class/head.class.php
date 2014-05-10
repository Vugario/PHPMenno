<?php

require_once('config.php');
require_once('instellingen.php');
require_once("class/admin.class.php");
require_once("class/habbo.class.php");
require_once("class/ubb.class.php");
require_once("pagina/ipban.php");
require_once("class/pb.class.php");
require_once("class/profiel.class.php");
require_once("class/gastenboek.class.php");
require_once("class/poll.class.php");
require_once("class/shop.class.php");
require_once("class/forum.class.php");
require_once("class/nieuws.class.php");
require_once("pagina/inlogcheck.php");
if(isset($_SESSION['id'])) {
	require_once('pagina/alert.php');
}

class profielen {
		function registeren($gebruikersnaam,$wachtwoord,$dag,$maand,$jaar,$email) {
		// Eerst halen we alle rare tekens eruit EN hakken we bij de 255 letters/cijfers de rest eraf, Maximale lengte is 255
		$gebruikersnaam = mysql_real_escape_string(substr($gebruikersnaam,0,25));
		$wachtwoord = mysql_real_escape_string(substr($wachtwoord,0,255));
		$geboortedatum = mysql_real_escape_string(substr($dag."-".$maand."-".$jaar,0,255));
		$email = mysql_real_escape_string(substr($email,0,60));
		
		if(ACCOUNTPERIP != "nee") {
			$sql = mysql_query("SELECT ip FROM leden WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
			if(mysql_num_rows($sql) >= 1) {
				echo "Je hebt al een account, <a href='#' onclick='history.go(-1)'>Ga terug</a>";
				die();
			}
		}
		// checken of ip al bestaat
		
		// nu gaan we hem erin stoppen
		$sql = mysql_query("INSERT INTO leden (gebruikersnaam,wachtwoord,geboortedatum,email,level,regdatum,ip,punten,muntjes,avatar,rang) VALUES ('".$gebruikersnaam."','".md5($wachtwoord)."','".$geboortedatum."','".$email."','0',NOW(),'".$_SERVER['REMOTE_ADDR']."','0','".MUNTJESBIJREGISTRATIE."','','habbo')");
		
		$sql_member_id = mysql_query("SELECT member_id FROM leden WHERE gebruikersnaam='".$gebruikersnaam."' AND email='".$email."' AND geboortedatum='".$geboortedatum."' LIMIT 1");
		$row_member_id = mysql_fetch_assoc($sql_member_id);
		
		mysql_query("INSERT INTO profiel (member_id,naam,achternaam,woonplaats,hobby,website,favo_fansite,favo_kamer,grootprofiel)
						VALUES ('".$row_member_id['member_id']."','','','','','','','','')");
		if(eregi("Duplicate",mysql_error())) {
			return "De gebruikersnaam of email die je hebt ingevuld is al van een van onze andere leden.<br />
			Kies dus een andere.<br />
			<a href='javascript:history.go(-1)'>Ga terug</a>.";
		}elseif(mysql_error() != "") {
			return "Er is een fout opgetreden.<br />Waarschijnlijk bestaat deze gebruikersnaam of email al.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}else{
			/// de gegevens worden gemaild ///
			$headers = "Content-type: text/html";
			mail($email,SITENAAM,"Beste ".$gebruikersnaam.",<br /><br />Je hebt net op ".SITENAAM." een account gemaakt.<br>
			Hierbij mailen wij je de gegevens.<br />
			Gebruikersnaam : <strong>".$gebruikersnaam."</strong><br>
			Wachtwoord : <strong>".$wachtwoord."</strong><br>
			<br>
			Je kan meteen inloggen via <a href='".SITELINK."'>".SITELINK."</a>",$headers);  /// Dit is de hele mail code
			return "<h3>".$gebruikersnaam."</h3>
			Je account is succesvol aangemaakt.<br>
			Je hebt een email gekregen met je gegevens.<br>
			Je kan <a href='?p=login'>hier</a> meteen al inloggen.";
		}
	}
	
	
	
	
	function inloggen($gebruikersnaam,$wachtwoord) {
		// rare tekens verwijderen
		$gebruikersnaam = mysql_real_escape_string(substr($gebruikersnaam,0,25));
		$wachtwoord = mysql_real_escape_string(substr($wachtwoord,0,255));
		$sql = mysql_query("SELECT member_id,gebruikersnaam,level,rang FROM leden WHERE gebruikersnaam='".$gebruikersnaam."' AND wachtwoord='".md5($wachtwoord)."'");
		if(mysql_num_rows($sql) < 1) {
			return "De gegevens die je hebt ingevult is fout.<br>
			Probeer het nog een keer.<br>
			<a href='javascript:history.go(-1)'>Ga terug</a>.";
		}else{
			$row = mysql_fetch_assoc($sql);
			if($row['rang'] != "verbannen") {
				// als je level 6 is krijg je een speciale session zodat je admin bent
				if($row['level'] == 6) {
					$_SESSION['admin'] = 1;
				}
				if($row['level'] == 2) {
					$_SESSION['nieuwsreporter'] = 1;
				}
				if($row['level'] == 3) {
					$_SESSION['forumbeheerder'] = 1;
				}
				$_SESSION['id'] = $row['member_id'];
				$_SESSION['gebruikersnaam'] = $row['gebruikersnaam'];
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				// HASH //
				$sessdata = $_SESSION['id'];
				
				$sessdata_str = serialize($sessdata);
				$md5hash = md5($sessdata_str);
				$_SESSION['hash'] = $md5hash;
				// HASH //
				mysql_query("INSERT INTO sessies (member_id,hash,ip,date) VALUES ('".$row['member_id']."','".$md5hash."','".$_SERVER['REMOTE_ADDR']."',NOW())");
				if(mysql_error() != "") {
					echo "Er is een fout in de sessies database, check je database";
					die();
				}
				return "<strong>".$gebruikersnaam."</strong>, Je bent nu succesvol ingelogd.<br>
				Moment gedult, je wrodt nu doorverwezen.
				<meta http-equiv='refresh' content='1;URL=index.php?p=beveiligdepagina' />";
			}else{
				echo "Je account is verbannen van deze website.<br />Je kan daarom niet inloggen.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
			}
		}
	}
	function wachtwoordAanpassen($wachtwoordoud,$wachtwoordnieuw)  {
		$wachtwoordoud = mysql_real_escape_string(substr($wachtwoordoud,0,255));
		$wachtwoordnieuw = mysql_real_escape_string(substr($wachtwoordnieuw,0,255));
		$sql = mysql_query("SELECT wachtwoord FROM leden WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		if($row['wachtwoord'] == md5($wachtwoordoud)) {
			mysql_query("UPDATE leden SET wachtwoord='".md5($wachtwoordnieuw)."' WHERE member_id='".$_SESSION['id']."'");
			if(mysql_error() == "") {
				return "Je wachtwoord is succesvol geupdate.<br />Je kunt nu verder gaan.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				return mysql_error();
			}
		}else{
			return "Je oude wachtwoord is niet goed.<br /><a href='javascript:history.go(-1)'>Ga terug.</a>";
		}
	}
	function rangAanpassen($rang_id) {
		$sql = mysql_query("SELECT * FROM gekochte_rangen WHERE member_id='".$_SESSION['id']."' AND rang_id='".$rang_id."'");
		if(mysql_num_rows($sql) == 1) {
			$sql_rangen = mysql_query("SELECT titel FROM shop_rangen WHERE rang_id='".$rang_id."'");
			$row_rangen = mysql_fetch_assoc($sql_rangen);
			mysql_query("UPDATE leden SET rang='".$row_rangen['titel']."' WHERE member_id='".$_SESSION['id']."'");
			if(mysql_error() == "") {
				return "Je rang is succesvol aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				return mysql_error();
			}
		}else{
			return "Dit is niet jou rang.";
		}
	}
	function stemmen($member_id,$cijfer) {
		$cijfer = mysql_real_escape_string(substr($cijfer,0,2));
		$member_id = mysql_real_escape_string(substr($member_id,0,30));
		if($cijfer > 10) {
			return "Je kan niet hoger stemmen dan een 10";
		}elseif($cijfer < 1) {
			return "Je kan niet lager stemmen dan een 1";
		}elseif(is_numeric($cijfer)) {
			$timeoutseconds = 86400;
			$timestamp = time();
			$timeout = $timestamp-$timeoutseconds;
			mysql_query("DELETE FROM stemmen_ip WHERE moment<$timeout AND ip='".$_SERVER['REMOTE_ADDR']."' AND member_id='".$member_id."'");
			$timeoutseconds1 = 300;
			$timestamp1 = time();
			$timeout1 = $timestamp1-$timeoutseconds1;
			mysql_query("DELETE FROM stemmen_ip WHERE moment<$timeout1 AND ip='".$_SERVER['REMOTE_ADDR']."' AND member_id != '".$member_id."'");
			
			$sql_spam = mysql_query("SELECT * FROM stemmen_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
			if(mysql_num_rows($sql_spam) == 0) {
				mysql_query("UPDATE leden SET punten=punten+".$cijfer.", muntjes=muntjes+".$cijfer." WHERE member_id='".$member_id."'");
				mysql_query("INSERT INTO stemmen_ip (ip,moment,member_id) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$timestamp."','".$member_id."')");
				if(mysql_error() == "") {
					return "Je hebt succesvol gestemd.<br />
					Je kan over 24 uur pas weer op dit profiel stemmen.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}else{
					if(eregi("Duplicate",mysql_error())) {
						return "Je hebt al op dit lid in de afgelopen 24 uur gestemd.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						return "Je hebt waarschijnlijk al op dit lid gestemd in de laatste 24 uur.<br />Zo niet, dat is er iets onbekends mis gegaan.<br /><a href='#' onclick='history.go(-1)'>Probeer gerust opnieuw.</a>";
					}
				}
			}else{
				return "Je hebt al gestemd deze 5 minuten.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}
		}else{
			return "Het cijfer dat je hebt ingevult is geen echt cijfer.";
		}
	}// begin hier eventueel een nieuwe function
}

$doe = new profielen();

$sql_instellingen = mysql_query("SELECT * FROM instellingen WHERE instellingen_id='1'");
$instellingen = mysql_fetch_assoc($sql_instellingen);


######## FILE_GET_CONTENTS ##############
if(!function_exists('file_get_contents')) {
function file_get_contents($filename, $use_include_path, $context) {

            $file_array = file($filename, $use_include_path, $context);

      $file_string = implode('', $file_array);

  return $file_string;
}
}

########## FILE_PUT_CONTENTS ############

if(!function_exists('file_put_contents')) {
	if(!defined(FILE_APPEND)) {
	define('FILE_APPEND', 1);
	}
	function file_put_contents($filename, $data, $flag = false) {
		$mode = ($flag == FILE_APPEND || strtoupper($flag) == 'FILE_APPEND') ? 'a' : 'w';
		$f = @fopen($n, $mode);
		if ($f === false) {
			return 0;
		} else {
			if (is_array($d)) $d = implode($d);
			$bytes_written = fwrite($f, $d);
			fclose($f);
			return $bytes_written;
		}
	}
}

#//Onderhouds Pagina\\#
$sql = mysql_query("SELECT status FROM instellingen WHERE instellingen_id=1");

$row = mysql_fetch_assoc($sql);
if($row['status'] == "uit" && !isset($_SESSION['admin'])) {
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Habbo - Mededeling</title>

<style type="text/css">

body {
	background: url(images/bg.gif);
}

.onderhoud_bg {
	background:url(images/onderhoud_bg.gif) repeat-y;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	padding-left: 90px;
	padding-right: 90px;
	text-align: left;
}

.onderhoud_top {
	background:url(images/onderhoud_top.gif) no-repeat;
	color:#FFFFFF;
	text-align: center;
	height:112px;
	width: 320px;
}

#habbotext {
	font-family:Georgia, Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color:#FFFFFF;
	text-align: center;
	width: 700px;
}
</style>
</head>

<body>

<center>
	<table width="700" cellpadding="0" cellspacing="0">
		<tr>
			<td class="onderhoud_top"><div id="habbotext" align="center">'.SITENAAM.'</div>
			</td>
		</tr>
		<tr>
			<td class="onderhoud_bg">'.ONDERHOUDTEKST.'
		        <br />
				<br /><br /><br />
	          <strong>Admin login</strong><br /> ';
              include("pagina/login.php"); 
			  echo'<br />
					<br /></td>
		</tr>
		<tr>
			<td><img src="images/onderhoud_bottom.gif" /></td>
		</tr>
	</table>
</center>
</body>
</html>
';
die();
}
#\\End of onderhouds pagina//#



// Nieuw Bericht? //
if(isset($_SESSION['id'])) {
	$sql = mysql_query("SELECT * FROM berichten WHERE gelezen='nee' AND aan='".$_SESSION['id']."'");
	if(mysql_num_rows($sql) >= 1) {
		$row = mysql_fetch_assoc($sql);
		
		mysql_query("UPDATE berichten SET gelezen='ja' WHERE bericht_id='".$row['bericht_id']."'");
		?>
		<!--- Nieuw Bericht ----->
		<style type="text/css">
		div.error_top
		{
			background-image:url(images/messagebox_top.gif);
			overflow:hidden;
			width:448px;
			height:24px;
			padding:1px;
			font-weight:bold;
			color:#111111;
			text-align:center;
			cursor:move;
		}
		
		div.error_venster {
			color:#000000;
		}
		div.error_mdl
		{
			background-image:url(images/messagebox_middle.png);
			overflow:hidden;
			width:430px;
			color: #000000;
			text-align:left;
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 12px;
			
		}
		div.error_dwn
		{
			background-image:url(images/messagebox_down.gif);
			overflow:hidden;
			width:450px;
			height:24px;
		}
		p.base_name
		{
			font-size:13px;
			color:#EEEEEE;
			font-family: Verdana, Arial, Helvetica, sans-serif;
		}
		a.berichtbekijken, a.berichtbekijken:visited {
			color: #990000;
		}
		a.berichtbekijken:hover {
			color:#FF9900;
		}
		</style>
		<script language="javascript" type="text/javascript" src="js/actions.js"></script>
		<div id="error_venster" style="display: block; position:fixed; left:300px; top:60px;"><div class="error_top" onMouseDown="dragStart(event, 'error_venster')">
			<table width="320">
				<tr>
					<td width="10"></td>
					<td width="310" align="center"><p class="base_name">Je hebt een nieuw bericht</p></td>
					<td valign="top"><a href="#" onClick="sluitDiv('error_venster')">Sluiten</a>
				</tr>
			</table>
			</div>
			<div class="error_mdl" id="error_melding" style="padding-left: 20px;">
				<?php echo $row['bericht']; ?><br />
				<a class="berichtbekijken" href="?p=bericht&bid=<?php echo $row['bericht_id']; ?>">Bericht Bekijken</a>
			</div>
			
			<div class="error_dwn"></div>
		</div>
		<!---- Einde nieuw bericht --->
		<?php
	}
}
// Einde nieuw bericht //

// Begin van online bezoekers //
$s_aantal = mysql_query("SELECT Count(id) FROM bezonline WHERE ip = '".$_SERVER['REMOTE_ADDR']."'") or die(mysql_error());  

if (!mysql_result($s_aantal, 0)) 
    mysql_query("INSERT INTO bezonline (ip, tijd) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".time()."')") or die(mysql_error()); 
else {  
    mysql_query("UPDATE bezonline SET tijd = '".time()."' WHERE ip = '".$_SERVER['REMOTE_ADDR']."'") or die(mysql_error()); 
    mysql_query("DELETE FROM bezonline WHERE tijd < ".time()." - 60*5") or die(mysql_error()); 
}
// Einde van online bezoekers //

?>
<script type="text/javascript" language="javascript">
function faq(div)
{
        var thisLevel = document.getElementById(div);

        if (thisLevel.style.display == "none")
        {
                thisLevel.style.display = "block";
        }
        else
        {
                var thisLevel = document.getElementById(div);
                thisLevel.style.display = "none";
        }
}
</script>