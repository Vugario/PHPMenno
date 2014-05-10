<?php

class forum {
	function categorieToevoegen($titel,$uitleg) {
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$uitleg = mysql_real_escape_string(substr($uitleg,0,255));
		
		mysql_query("INSERT INTO forum_categorie (titel,uitleg) VALUES ('".$titel."','".$uitleg."')");
		if(mysql_error() == "") {
			return "De categorie is toegevoegd.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function categorieWijzigen($categorie_id,$titel,$uitleg) {
		$categorie_id = mysql_real_escape_string(substr($categorie_id,0,30));
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$uitleg = mysql_real_escape_string(substr($uitleg,0,255));
		
		mysql_query("UPDATE forum_categorie SET titel='".$titel."',uitleg='".$uitleg."' WHERE categorie_id='".$categorie_id."'");
		if(mysql_error() == "") {
			return "De categorie is gewijzigd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function berichtWijzigen($bericht_id,$titel,$bericht,$categorie) {
		$bericht_id = mysql_real_escape_string(substr($bericht_id,0,30));
		$titel = mysql_real_escape_string(substr($titel,0,255));
		$bericht = mysql_real_escape_string($bericht);
		$categorie = mysql_real_escape_string(substr($categorie,0,255));
		
		mysql_query("UPDATE forum_berichten SET titel='".$titel."',bericht='".$bericht."',categorie='".$categorie."' WHERE bericht_id='".$bericht_id."'");
		if(mysql_error() == "") {
			return "Het bericht is gewijzigd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function reactieWijzigen($reactie_id,$bericht) {
		$reactie_id = mysql_real_escape_string(substr($reactie_id,0,30));
		$bericht = mysql_real_escape_string($bericht);
		
		mysql_query("UPDATE forum_reacties SET bericht='".$bericht."' WHERE reactie_id='".$reactie_id."'");
		if(mysql_error() == "") {
			return "De reactie is gewijzigd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function berichtVerwijderen($bericht_id) {
		$bericht_id = mysql_real_escape_string($bericht_id);
		
		mysql_query("DELETE FROM forum_berichten WHERE bericht_id='".$bericht_id."'");
		if(mysql_error() == "") {
			return "Het bericht is verwijderd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function reactieVerwijderen($reactie_id) {
		$reactie_id = mysql_real_escape_string($reactie_id);
		
		mysql_query("DELETE FROM forum_reacties WHERE reactie_id='".$reactie_id."'");
		if(mysql_error() == "") {
			return "De reactie is verwijderd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
	function categorieVerwijderen($categorie_id) {
		$categorie_id = mysql_real_escape_string($categorie_id);
		
		mysql_query("DELETE FROM forum_categorie WHERE categorie_id='".$categorie_id."'");
		if(mysql_error() == "") {
			return "De categorie is verwijderd.<br /><a href='javascript:history.go(-2)'>Ga terug</a>";
		}else{
			return mysql_error();
		}
	}
}
$forum = new forum();
?>