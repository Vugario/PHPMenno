<?php

class nieuws {
	function nieuwsToevoegen($titel,$bericht,$actief) {
		$titel = mysql_real_escape_string(substr($titel,0,25));
		$bericht = mysql_real_escape_string(substr($bericht,0,5000));
		$actief = mysql_real_escape_string(substr($actief,0,3));
		
		setlocale(LC_ALL, 'nl_NL');
		
		mysql_query("INSERT INTO nieuws_berichten (titel,bericht,actief,datum,member_id) VALUES ('".$titel."','".$bericht."','".$actief."','".date("y-m-d H:i:s")."','".$_SESSION['id']."')");
		if(mysql_error() == "") {
			echo "Er is succesvol een nieuwsitem aangemaakt.<br /><strong>".$titel."</strong><br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			echo "Deze titel komt al voor in het nieuws archief.<br />Kies een andere.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}
	}
	
	function nieuwsWijzigen($titel,$bericht,$actief,$nieuws_id) {
		$titel = mysql_real_escape_string(substr($titel,0,25));
		$bericht = mysql_real_escape_string(substr($bericht,0,5000));
		$actief = mysql_real_escape_string(substr($actief,0,3));
		$nieuws_id = mysql_real_escape_string(substr($nieuws_id,0,30));
		
		mysql_query("UPDATE nieuws_berichten SET titel='".$titel."',bericht='".$bericht."',actief='".$actief."' WHERE nieuws_id='".$nieuws_id."'");
		if(mysql_error() == "") {
			echo "Dit nieuwsitem is succesvol gewijzigd.<br /><strong>".$titel."</strong><br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			echo "Deze titel komt al voor in het nieuws archief.<br />Kies een andere.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}
	}
	
	function nieuwsVerwijderen($nieuws_id) {
		$nieuws_id = mysql_real_escape_string(substr($nieuws_id,0,30));
		
		mysql_query("DELETE FROM nieuws_berichten WHERE nieuws_id='".$nieuws_id."'");
		if(mysql_error() == "") {
			echo "Dit nieuwsitem is succesvol verwijderd.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan, Misschien bestaat hij niet meer.<br><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	// nieuwe function
}

$nieuws = new nieuws();

?>