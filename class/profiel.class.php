<?php

class profiel {
	
	function nieuwProfiel($naam,$achternaam,$woonplaats,$hobby,$website,$favo_fansite,$favo_kamer,$land) {
		$naam = mysql_real_escape_string(substr($naam,0,255));
		$achternaam = mysql_real_escape_string(substr($achternaam,0,255));
		$woonplaats = mysql_real_escape_string(substr($woonplaats,0,255));
		$hobby = mysql_real_escape_string(substr($hobby,0,255));
		$website = mysql_real_escape_string(substr($website,0,255));
		$favo_fansite = mysql_real_escape_string(substr($favo_fansite,0,255));
		$favo_kamer = mysql_real_escape_string(substr($favo_kamer,0,255));
		$land = mysql_real_escape_string(substr($land,0,255));
		
		$check = mysql_query("SELECT member_id FROM profiel WHERE member_id='".$_SESSION['id']."'");
		if(mysql_num_rows($check) == 1) {
			return "Je hebt al een profiel aangemaakt.";
		}else{
			mysql_query("INSERT INTO profiel (land,member_id,naam,achternaam,woonplaats,hobby,website,favo_fansite,favo_kamer,grootprofiel)
						VALUES ('".$land."','".$_SESSION['id']."','".$naam."','".$achternaam."','".$woonplaats."','".$hobby."','".$website."','".$favo_fansite."','".$favo_kamer."','')");
			if(mysql_error() == "") {
				return "Je profiel is succesvol aangemaakt.<br>Je ziet zometeen een nieuwe link in je menu verschijnen met daarin de mogelijkheid om je profiel aan te passen.";
			}else{
				return mysql_error();
			}
		}
	}
	function wijzigenProfiel($naam,$achternaam,$woonplaats,$hobby,$website,$favo_fansite,$favo_kamer,$land) {
		$naam = mysql_real_escape_string(substr($naam,0,255));
		$achternaam = mysql_real_escape_string(substr($achternaam,0,255));
		$woonplaats = mysql_real_escape_string(substr($woonplaats,0,255));
		$hobby = mysql_real_escape_string(substr($hobby,0,255));
		$website = mysql_real_escape_string(substr($website,0,255));
		$favo_fansite = mysql_real_escape_string(substr($favo_fansite,0,255));
		$favo_kamer = mysql_real_escape_string(substr($favo_kamer,0,255));
		$land = mysql_real_escape_string(substr($land,0,255));
		
		mysql_query("UPDATE profiel SET land='".$land."',naam='".$naam."',achternaam='".$achternaam."',woonplaats='".$woonplaats."',hobby='".$hobby."',website='".$website."',favo_fansite='".$favo_fansite."',favo_kamer='".$favo_kamer."' WHERE member_id='".$_SESSION['id']."'");
		
		if(mysql_error() == "") {
			return "Je profiel is geupdate, Je kan je veranderde profiel op je profiel pagina bekijken.<br>
			<a href='?p=profiel&mid=".$_SESSION['id']."'>Ga naar je profiel pagina</a>";
		}else{
			return mysql_error();
		}
	}
	function wijzigGrootprofiel ($grootprofiel) {
		
		mysql_query("UPDATE profiel SET grootprofiel='".$grootprofiel."' WHERE member_id='".$_SESSION['id']."'");
		
		if(mysql_error() == "") {
			return "Je groot profiel is aangepast.<br>Bekijk hem <a href='?p=profiel&mid=".$_SESSION['id']."'>hier</a>";
		}else{
			return mysql_error();
		}
	}
	// nieuw functie
}
$profiel = new profiel();

?>