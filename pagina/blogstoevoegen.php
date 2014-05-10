<?php

if(isset($_SESSION['id'])) {


class blogs {
    function blogsToevoegen($titel,$bericht,$actief) {
        $titel = mysql_real_escape_string(substr(htmlspecialchars($titel),0,75));
        $bericht = mysql_real_escape_string(substr($bericht,0,5000));
        $actief = mysql_real_escape_string(substr(htmlspecialchars($actief),0,3));
		
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



if(isset($_GET['a'])) {
	if($_GET['a'] == "blog" && isset($_GET['s'])) {
		if($_GET['s'] == "toevoegen") {
			if(isset($_POST['toevoegen']) && !empty($_POST['titel']) && !empty($_POST['bericht']) && !empty($_POST['actief'])) {
			
				echo $blogs->blogsToevoegen($_POST['titel'],$_POST['bericht'],$_POST['actief']);
				
			}else{
			?>
				<script type="text/javascript" src="editor/scripts/wysiwyg.js"></script>
				<script type="text/javascript" src="editor/scripts/wysiwyg-settings.js"></script>
				<!-- 
					Attach the editor on the textareas
				-->
				<script type="text/javascript">
					// Use it to attach the editor to all textareas with full featured setup
					//WYSIWYG.attach('all', full);
					
					// Use it to attach the editor directly to a defined textarea
					WYSIWYG.attach('bericht',small); // default setup
				</script>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=blogs&a=blog&s=toevoegen" onclick="return submitForm();" method="post">
					<table width="300">
						<tr>
							<td>Titel</td>
							<td><input type="text" name="titel" maxlength="75" /></td>
						</tr>
						<tr>
							<td colspan="2">Kort bericht</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="bericht" name="bericht"></textarea></td>
						</tr>
						<tr>
							<td>Aan of uit?</td>
							<td><input type="radio" checked="checked" name="actief" value="aan" /> Aan <input type="radio" name="actief" value="uit" /> Uit </td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" value="Toevoegen" name="toevoegen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}
	}
}else{
	echo "&raquo; <a href=\"?p=blogs&a=blog&s=toevoegen\">Blog(s) Toevoegen</a><br />";
}
}else{
	echo "Je moet wel ingelogd zijn.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>