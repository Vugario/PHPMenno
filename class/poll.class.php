<?php

class poll {
	function pollAanmaken ($vraag,$ant1,$ant2,$ant3,$ant4) {
		$vraag = mysql_real_escape_string(substr($vraag,0,255));
		$ant1 = mysql_real_escape_string(substr($ant1,0,255));
		$ant2 = mysql_real_escape_string(substr($ant2,0,255));
		$ant3 = mysql_real_escape_string(substr($ant3,0,255));
		$ant4 = mysql_real_escape_string(substr($ant4,0,255));
		
		mysql_query("INSERT INTO poll (member_id,vraag,ant1,ant2,ant3,ant4,aantal1,aantal2,aantal3,aantal4)
				VALUES ('".$_SESSION['id']."','".$vraag."','".$ant1."','".$ant2."','".$ant3."','".$ant4."','0','0','0','0')");
		if(mysql_error() == "") {
			return "Je poll is succesvol aangemaakt.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			return "Je hebt al een actieve poll, verwijder deze eerst voordat je een ander kan toevoegen.";
		}else{
			return mysql_error();
		}
	}
	function pollVerwijderen () {
		$sql = mysql_query("SELECT * FROM poll WHERE member_id='".$_SESSION['id']."'");
		if(mysql_num_rows($sql) == 1) {
			$row = mysql_fetch_assoc($sql);
			mysql_query("DELETE FROM poll WHERE member_id='".$_SESSION['id']."'");
			mysql_query("DELETE FROM poll_ip WHERE poll_id='".$row['poll_id']."'");
			if(mysql_error() == "") {
				return "Hij is succesvol verwijderd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
			}else{
				return mysql_error();
			}
		}else{
			return "Er is geen poll die van jou is met dit nummer.";
		}
	}
	function pollVeranderen ($vraag,$ant1,$ant2,$ant3,$ant4) {
		$vraag = mysql_real_escape_string(substr($vraag,0,255));
		$ant1 = mysql_real_escape_string(substr($ant1,0,255));
		$ant2 = mysql_real_escape_string(substr($ant2,0,255));
		$ant3 = mysql_real_escape_string(substr($ant3,0,255));
		$ant4 = mysql_real_escape_string(substr($ant4,0,255));
		
		mysql_query("UPDATE poll SET vraag='".$vraag."',ant1='".$ant1."',ant2='".$ant2."',ant3='".$ant4."' WHERE member_id='".$_SESSION['id']."'");
		if(mysql_error() == "") {
			return "Je poll is succesvol aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function pollStemmen ($ant,$poll_id) {
		$poll_id = mysql_real_escape_string(substr($poll_id,0,30));
		$ant = mysql_real_escape_string(substr($ant,0,255));
		$sql = mysql_query("SELECT * FROM poll_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."' AND poll_id='".$poll_id."'");
		if(mysql_num_rows($sql) == 1) {
			return "Je hebt al gestemd op deze poll, Je moet helaas wachten tot hij een nieuwe poll maakt.";
		}else{
			mysql_query("UPDATE poll SET ".$ant."=".$ant."+1 WHERE poll_id='".$poll_id."'");
			mysql_query("INSERT INTO poll_ip (ip,poll_id) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$poll_id."')");
			if(mysql_error() == "") {
				return "Je hebt succesvol gestemd op deze poll.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				return "Je hebt waarschijnlijk al op dit lid zijn poll gestemd in de laatste 24 uur.<br />Zo niet, dat is er iets onbekends mis gegaan.<br /><a href='#' onclick='history.go(-1)'>Probeer gerust opnieuw.</a>";
			}
		}
	}
}
$poll = new poll();

?>