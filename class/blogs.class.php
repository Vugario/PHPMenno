<?php

class blogs {
	function blogsToevoegen($titel,$bericht,$actief) {
		$titel = mysql_real_escape_string(substr(htmlspecialchars($titel,0,75)));
		$bericht = mysql_real_escape_string(substr(htmlspecialchars($bericht,0,5000)));
		$actief = mysql_real_escape_string(substr(htmlspecialchars($actief,0,3)));
		
		setlocale(LC_ALL, 'nl_NL');
		
		mysql_query("INSERT INTO blogs_berichten (titel,bericht,actief,datum,member_id) VALUES ('".$titel."','".$bericht."','".$actief."','".date("y-m-d H:i:s")."','".$_SESSION['id']."')");
		if(mysql_error() == "") {
			echo "Er is succesvol een blog gemaakt.<br /><strong>".$titel."</strong><br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			echo "Deze titel komt al voor in het blog archief.<br />Kies een andere.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}
	}
	
	function blogsWijzigen($titel,$bericht,$actief,$blogs_id) {
		$titel = mysql_real_escape_string(substr(htmlspecialchars($titel,0,75)));
		$bericht = mysql_real_escape_string(substr(htmlspecialchars($bericht,0,5000)));
		$actief = mysql_real_escape_string(substr(htmlspecialchars($actief,0,3)));
		$blogs_id = mysql_real_escape_string(substr(htmlspecialchars($blogs_id,0,30)));
		
		mysql_query("UPDATE blogs_berichten SET titel='".$titel."',bericht='".$bericht."',actief='".$actief."' WHERE blogs_id='".$blogs_id."'");
		if(mysql_error() == "") {
			echo "Deze blog is succesvol gewijzigd.<br /><strong>".$titel."</strong><br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}elseif(eregi("Duplicate",mysql_error())) {
			echo "Deze titel komt al voor in het blog archief.<br />Kies een andere.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}
	}
	
	function blogsVerwijderen($blogs_id) {
		$blogs_id = mysql_real_escape_string(substr($blogs_id,0,30));
		
		mysql_query("DELETE FROM blogs_berichten WHERE blogs_id='".$blogs_id."'");
		if(mysql_error() == "") {
			echo "Deze blog is succesvol verwijderd.<br /><a href=\"javascript:history.go(-2)\">Ga terug</a>";
		}else{
			echo "Er is iets fout gegaan, Misschien bestaat hij niet meer.<br><a href=\"javascript:history.go(-1)\">Ga terug</a>";
		}
	}
	
	// nieuwe function
}

$blogs = new blogs();

?>