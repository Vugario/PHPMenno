<?php

function Checklogin($url) {
	if(isset($_SESSION['id'])) {
		include($url);
	}else{
		echo "Je moet ingelogd zijn voor deze pagina.";
	}
}
if(isset($_GET['gebruikersnaam'])) {
	$gebruikersnaam = mysql_real_escape_string($_GET['gebruikersnaam']);
	$sql = mysql_query("SELECT member_id FROM leden WHERE gebruikersnaam = '".$gebruikersnaam."'");
	$row = mysql_fetch_assoc($sql);
	echo '<META HTTP-EQUIV="refresh" content="0;URL=index.php?p=profiel&mid='.$row['member_id'].'">';
}elseif(isset($_GET['p'])) {
	
	switch($_GET['p']) {
		// admin //
		case "admin":
			include('admin/index.php');
			break;
		case "admin_banners":
			include('admin/banners.php');
			break;
		case "admin_gebruikers":
			include('admin/gebruikers.php');
			break;
		case "admin_shop":
			include('admin/shop.php');
			break;
		case "admin_nieuwsbrief":
			include('admin/nieuwsbrief.php');
			break;
		case "admin_askamod":
			include('admin/askamod.php');
			break;
		case "admin_forum":
			include('admin/forum.php');
			break;
		case "admin_badges":
			include('admin/badges.php');
			break;
		case "admin_geven":
			include('admin/geven.php');
			break;
		case "admin_cms":
			include('admin/cms.php');
			break;
		case "admin_faq":
			include('admin/faq.php');
			break;
		case "admin_muntjes":
			include('admin/erbij.php');
			break;
		case "admin_tijd":
			include('admin/admin_tijd.php');
			break;
		case "admin_nieuws":
			include('admin/nieuws.php');
			break;
		case "admin_alert":
			include('admin/alertsturen.php');
			break;
		case "admin_massaalert":
			include('admin/admin_massaalert.php');
			break;
		case "admin_berichtenbalk":
			include('admin/berichtenbalk.php');
			break;
		
		// normale pagina's //
		case "pagina":
			if(isset($_GET['pid'])) {
				$pid = mysql_real_escape_string($_GET['pid']);
				$sql = mysql_query("SELECT content FROM content WHERE paginaid='".$pid."'");
				$row = mysql_fetch_assoc($sql);
				echo stripslashes($row['content']);
			}else{
				echo "er is geen pagina opgegeven.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
			}
			break;
		case "login":
			include('pagina/login.php');
			break;
		case "registreren":
			include('pagina/registreren.php');
			break;
		case "steenpapierschaar":
			include('pagina/steenpapierschaar.php');
			break;
		case "blogs":
			if(isset($_GET['nid'])) {
				include('pagina/blogsbekijken.php');
			}else{
				include('pagina/blogstoevoegen.php');
			}
			break;
		case "badges":
			include('pagina/badge.php');
			break;
		case "gegevensveranderen":
			include('pagina/gegevensveranderen.php');
			break;
		case "nieuws":
			if(isset($_GET['nid'])) {
				include('pagina/nieuwsbekijken.php');
			}else{
				include('pagina/nieuws.php');
			}
			break;
		case "wwveranderen":
			include("pagina/wwveranderen.php");
			break;
		case "faq":
			include("pagina/faq.php");
			break;
		case "askamod":
			include("pagina/askamod.php");
			break;
		case "kluis":
			include("pagina/kluis.php");
			break;
		case "ledenlijst":
			Checklogin("pagina/ledenlijst.php");
			break;
		case "berichtenbalk":
			include('pagina/berichtenbalk.php');
			break;
		case "habbo":
			Checklogin('pagina/habbo.php');
			break;
		case "beveiligdepagina":
			Checklogin('pagina/beveiligdepagina.php');
			break;
		case "uitloggen":
			Checklogin('pagina/uitloggen.php');
			break;
		case "wwvergeten":
			include('pagina/wachtwoordvergeten.php');
			break;
		case "habboprofiel":
			Checklogin('pagina/habboprofiel.php');
			break;
		case "statistieken":
			Checklogin("pagina/statistieken.php");
			break;
		case "ipban":
			include('admin/ipbannen.php');
			break;
		case "bericht":
			include('pagina/bericht.php');
			break;
		case "profiel":
			include('pagina/profiel.php');
			break;
		case "gastenboek":
			include('pagina/gastenboek.php');
			break;
		case "poll":
			include('pagina/poll.php');
			break;
		case "shop":
			include('pagina/shop.php');
			break;
		case "forum":
			include('pagina/forum.php');
			break;
			case "3xkans":
			include("pagina/redblackwhite.php");
			break;
		case "vriend_toevoegen":
			include('pagina/vriend_toevoegen.php');
			break;
		case "vriend_beheren":
			include('pagina/vriend_beheren.php');
			break;
		case "vriend_bekijken":
			include('pagina/vrienden_bekijken.php');
			break;
		case "pollindex":
			include('pagina/pollindex.php');
			break;
		case "poll_admin":
			include('admin/poll_admin.php');
			break;
		case "pollstemmen":
			include('pagina/pollstemmen.php');
			break;
		case "overschrijven":
			include("pagina/overschrijven.php");
			break;
		case "profiel2":
			include('pagina/profiel2.php');
			break;
		default:
			if(isset($_GET['p'])) {
				if(file_exists('pagina/'.$_GET['p'].'.php')) {
					include('pagina/'.$_GET['p'].'.php');
				}else{
					include('pagina/home.php');
				}
			}
			break;
		}
}else{
	include('pagina/home.php');
}
?>