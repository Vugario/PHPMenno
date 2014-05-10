<?php

class gastenboek {
	function gastenboekAanmaken () {
		if(isset($_SESSION['id'])) {
			mysql_query("INSERT INTO gastenboek (member_id) VALUES ('".$_SESSION['id']."')");
			$sql = mysql_query("SELECT gastenboek_id FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
			$row = mysql_fetch_assoc($sql);
			mysql_query("INSERT INTO gastenboek_berichten (gastenboek_id,habbonaam,bericht,datum) VALUES ('".$row['gastenboek_id']."','Systeem','Gefeliciteerd met je gastenboek<br>Dit is het eerste bericht.<br>Je kan deze verwijder via de menulink Gastenboek.<br><br>Groeten, Managment',NOW())");
			if(mysql_error() == "") {
				return "Je gastenboek is succesvol aangemaakt.<br /><a href='?p=profiel&mid=".$_SESSION['id']."'>Bekijk hem hier</a>";
			}else{
				if(eregi("Duplicate",mysql_error())) {
					return "Je hebt al een gastenboek op je profiel.<br />Je kan er natuurlijk maar 2 maken";
				}else{
					return mysql_error();
				}
			}
		}else{
			return "Je bent niet ingelogd";
		}
	}
	function gastenboekBerichttoevoegen ($bericht,$gastenboek_id) {
		$gastenboek_id = mysql_real_escape_string(substr($gastenboek_id,0,255));
		$bericht = mysql_real_escape_string(nl2br($bericht));
		// Spam beveiliging start //
		$timeoutseconds = 300;
		$timestamp = time();
		$timeout = $timestamp-$timeoutseconds;
		mysql_query("DELETE FROM gastenboek_ip WHERE moment<$timeout AND ip='".$_SERVER['REMOTE_ADDR']."'");
		
		$sql_spam = mysql_query("SELECT * FROM gastenboek_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
		if(mysql_num_rows($sql_spam) == 1) {
			return "Je mag maar 1 keer in de 5 minuten een bericht posten in een gastenboek.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
		
			/// spam beveiliging einde //
			$row = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$_SESSION['id']."'"));
			mysql_query("INSERT INTO gastenboek_ip (ip,moment) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$timestamp."')");
			mysql_query("INSERT INTO gastenboek_berichten (gastenboek_id,habbonaam,bericht,datum) VALUES ('".$gastenboek_id."','".$row['gebruikersnaam']."','".$bericht."',NOW())");
			if(mysql_error() == "") {
				return "Je hebt succesvol een bericht geplaatst in het gastenboek.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				return mysql_error();
			}
		}
	}
	function gastenboekBerichtverwijderen ($bericht_id) {
		$bericht_id = mysql_real_escape_string(substr($bericht_id,0,30));
		$sql = mysql_query("SELECT gastenboek_id FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		$sql_insert = mysql_query("DELETE FROM gastenboek_berichten WHERE bericht_id='".$bericht_id."' AND gastenboek_id='".$row['gastenboek_id']."'");
		if(mysql_error() == "") {
			return "Het bericht is succesvol verwijderd.";
		}else{
			return mysql_error();
		}
	}
	function gastenboekBerichtaanpassen ($habbonaam,$bericht,$bericht_id) {
		$bericht_id = mysql_real_escape_string(substr($bericht_id,0,30));
		$bericht = mysql_real_escape_string($bericht);
		$habbonaam = mysql_real_escape_string(substr($habbonaam,0,255));
		$sql = mysql_query("SELECT gastenboek_id FROM gastenboek WHERE member_id='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		
		$sql_insert = mysql_query("UPDATE gastenboek_berichten SET habbonaam='".$habbonaam."',bericht='".$bericht."' WHERE gastenboek_id='".$row['gastenboek_id']."' AND bericht_id='".$bericht_id."'");
		if(mysql_error() == "") {
			return "Het bericht is succesvol aangepast.<br><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
}
$gastenboek = new gastenboek();

?>