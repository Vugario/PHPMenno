<?php
/*
Steen papier schaar - WMCity
*/
if(isset($_SESSION['id'])) {
	if(!is_writable("steenpapierschaar.txt")) {
		chmod("steenpapierschaar.txt",0777);
	}
	$ntekst = file('steenpapierschaar.txt');
	if(array_search($_SESSION['id']." - ".date("d-m-y"), $ntekst) > 3) {
		echo "Steen Papier Schaar mag je maar 3x per dag spelen, Anders verdien je wel erg snel muntjes<br>Je moet dus nog even wachten tot morgen.<br><a href='#' onclick='history.go(-1)'>Ga terug</a>";
	}else{
		$object[1] = "Steen";
		$object[2] = "Papier";
		$object[3] = "Schaar";
		
		$random = rand(1, count($object));
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		$jij = $_POST['jij'];
		
					  if ($jij == $object[$random]) {
						echo("<b>Je kiest:</b> " . $jij . "<br />\n");
						 echo("<b>De computer kiest:</b> $object[$random]<br />\n");
						 echo("Het is gelijk spel!<br /><br />\n");
						 // gelijk
						 // loggen
						 $tekst = file_get_contents("steenpapierschaar.txt");
						 file_put_contents("steenpapierschaar.txt", $tekst."\n".$_SESSION['id']." - ".date("d-m-y"));
						 // einde loggen
						 
						 echo("<a href=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">Nog een keer</a>");
					} elseif ($jij == 'Steen' AND $object[$random] == 'Schaar') {
						  echo("<b>Je kiest:</b> " . $jij . "<br />\n");
						 echo("<b>De computer kiest:</b> $object[$random]<br />\n");
						 echo("Jij hebt gewonnen!<br /><br />\n");
						 // gewonnen
						 // loggen
						 $tekst = file_get_contents("steenpapierschaar.txt");
						 file_put_contents("steenpapierschaar.txt", $tekst."\n".$_SESSION['id']." - ".date("d-m-y"));
						 mysql_query("UPDATE leden SET muntjes=muntjes+".MUNTJESVOORSTEEN." WHERE member_id='".$_SESSION['id']."'");
						 // einde loggen
						  echo("<a href=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">Nog een keer</a>");
				  } elseif ($jij == 'Papier' AND $object[$random] == 'Schaar') {
						  echo("<b>Je kiest:</b> " . $jij . "<br />\n");
						 echo("<b>De computer kiest:</b> $object[$random]<br />\n");
						 echo("Jij hebt verloren!<br /><br />\n");
						 // verloren
						 // loggen
						 $tekst = file_get_contents("steenpapierschaar.txt");
						 file_put_contents("steenpapierschaar.txt", $tekst."\n".$_SESSION['id']." - ".date("d-m-y"));
						 // einde loggen
						  echo("<a href=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">Nog een keer</a>");
					} elseif ($jij == 'Steen' AND $object[$random] == 'Papier') {
						  echo("<b>Je kiest:</b> " . $jij . "<br />\n");
						 echo("<b>De computer kiest:</b> $object[$random]<br />\n");
						 echo("Je hebt gewonnen!<br /><br />\n");
						 // gewonnen
						 // loggen
						 $tekst = file_get_contents("steenpapierschaar.txt");
						 file_put_contents("steenpapierschaar.txt", $tekst."\n".$_SESSION['id']." - ".date("d-m-y"));
						 mysql_query("UPDATE leden SET muntjes=muntjes+".MUNTJESVOORSTEEN." WHERE member_id='".$_SESSION['id']."'");
						 // einde loggen
						  echo("<a href=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">Nog een keer</a>");
					} elseif ($jij == 'Schaar' AND $object[$random] == 'Papier') {
						  echo("<b>Je kiest:</b> " . $jij . "<br />\n");
						 echo("<b>De computer kiest:</b> $object[$random]<br />\n");
						 echo("Jij hebt gewonnen!<br /><br />\n");
						 // gewonnen
						 // loggen
						 $tekst = file_get_contents("steenpapierschaar.txt");
						 file_put_contents("steenpapierschaar.txt", $tekst."\n".$_SESSION['id']." - ".date("d-m-y"));
						 mysql_query("UPDATE leden SET muntjes=muntjes+".MUNTJESVOORSTEEN." WHERE member_id='".$_SESSION['id']."'");
						 // einde loggen
						  echo("<a href=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">Nog een keer</a>");
					} elseif ($jij == 'Papier' AND $object[$random] == 'Steen') {
						  echo("<b>Je kiest:</b> " . $jij . "<br />\n");
						 echo("<b>De computer kiest:</b> $object[$random]<br />\n");
						 echo("Jij hebt gewonnen!<br /><br />\n");
						 // gewonnen
						 // loggen
						 $tekst = file_get_contents("steenpapierschaar.txt");
						 file_put_contents("steenpapierschaar.txt", $tekst."\n".$_SESSION['id']." - ".date("d-m-y"));
						 mysql_query("UPDATE leden SET muntjes=muntjes+".MUNTJESVOORSTEEN." WHERE member_id='".$_SESSION['id']."'");
						 // einde loggen
						  echo("<a href=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">Nog een keer</a>");
					} elseif ($jij == 'Schaar' AND $object[$random] == 'Steen') {
					echo("<b>Je kiest:</b> " . $jij . "<br />\n");
						 echo("<b>De computer kiest:</b> $object[$random]<br />\n");
						echo("Jij hebt gewonnen!<br /><br />\n");
						// gewonnen
						 // loggen
						 $tekst = file_get_contents("steenpapierschaar.txt");
						 file_put_contents("steenpapierschaar.txt", $tekst."\n".$_SESSION['id']." - ".date("d-m-y"));
						 mysql_query("UPDATE leden SET muntjes=muntjes+".MUNTJESVOORSTEEN." WHERE member_id='".$_SESSION['id']."'");
						 // einde loggen
						 echo("<a href=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">Nog een keer</a>");
					} else {
					   echo("Je moet wel een keuze maken tussen steen, papier of schaar!\n");
				  }
		} else {
		echo("<form name=\"steenpapierschaar\" method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "?p=steenpapierschaar\">\n");
		echo("<b>Maak je keuze:</b>\n");
		echo("<br /><br />\n");
		echo("<select name=\"jij\">\n<option selected>Maak je keuze...</option>\n<option value=\"Steen\">Steen</option>\n<option value=\"Papier\">Papier</option>\n<option value=\"Schaar\">Schaar</option>\n</select>\n<br />\n");
		echo("<br />\n");
		echo("<input type=\"submit\" name=\"submit\" value=\"Speel!\">\n");
		echo("</form>\n");
		}
	}
}
?> 