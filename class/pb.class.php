<?php

class pb {
	function berichtVersturen($aan,$titel,$bericht) {
		$aan = mysql_real_escape_string(substr($aan,0,255));
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$bericht = mysql_real_escape_string(nl2br(substr($bericht,0,255)));	
		mysql_query("INSERT INTO berichten (aan,door,titel,bericht,gelezen,datum) VALUES
					('".$aan."','".$_SESSION['id']."','".$titel."','".$bericht."','nee',NOW())");
		mysql_query("INSERT INTO berichten_verzonden (aan,door,titel,bericht,gelezen,datum) VALUES
					('".$aan."','".$_SESSION['id']."','".$titel."','".$bericht."','nee',NOW())");
		if(mysql_error() == "") {
			return "Je bericht is succesvol verstuurd.<br />Wil je nog een bericht versturen?<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			echo mysql_error();
		}
	}
	function berichtVerwijderen($bericht_id) {
		mysql_query("DELETE FROM berichten WHERE bericht_id='".$bericht_id."' AND aan='".$_SESSION['id']."'");
		if(mysql_error() == "") {
			return "Je hebt succesvol dit bericht verwijderd.<br />Wil je er nog 1 verwijderen?<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
			mysql_error();
		}
	}
	function berichtOpslaan ($bericht_id) {
		$sql = mysql_query("SELECT * FROM berichten WHERE bericht_id='".$bericht_id."' AND aan='".$_SESSION['id']."'");
		$row = mysql_fetch_assoc($sql);
		mysql_query("INSERT INTO berichten_opgeslagen (bericht_id,aan,door,titel,bericht,gelezen,datum) VALUES 
					('".$bericht_id."','".$row['aan']."','".$row['door']."','".$row['titel']."','".$row['bericht']."','".$row['gelezen']."','".$row['datum']."')");
		if(mysql_error() == "") {
			return "Je hebt dit bericht succesvol opgeslagen.<br>Wil je nog een bericht opslaan?<br><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
			mysql_error();
		}
	}
	function berichtOpslaanVerwijderen ($opgeslagen_id) {
		$opgeslagen_id = mysql_real_escape_string(substr($opgeslagen_id,0,255));
		mysql_query("DELETE FROM opgeslagen_berichten WHERE opgeslagen_id='".$opgeslagen_id."'");
		if(mysql_error() == "") {
			return "Je hebt succesvol dit bericht verwijderd uit je opgeslagen berichten.<br>Wil je nog iets verwijderen?<br><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
			mysql_error();
		}
	}
}
$pb = new pb();

?>