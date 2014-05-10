<?php
if(isset($_SESSION['id'])) {
	error_reporting(0);
	?>
	<style type="text/css">

	</style>
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




class habboClass
{

    var $data;
    var $habboname;
    var $hotel;
    var $private;

    function habboClass($habboname, $hotel)
    {
        $this->habboname = $habboname;
        $this->hotel = $hotel;
        $this->data = file_get_contents("http://habbo." . $hotel . "/home/" . $habboname);
    }

    function online()
    {
        if (eregi("habbo_online_anim.gif", $this->data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function banned()
    {
        if (eregi("This page is not available anymore", $this->data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function actual()
    {
        if (eregi('<div id="page-headline-text">Habbo Homes</div>', $this->data))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function pageprivate()
    {
        if (eregi("marked this page as private.", $this->data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function motto()
    {
        $motto = explode('<div class="profile-motto">', $this->data);
		if(isset($motto[1])) {
			$motto = explode('</div>', $motto[1]);
			$motto = trim($motto[0]);
			$motto = str_replace('        <div class="clear">', '', $motto);
			if(strlen($motto) > 0) {
				return $motto;
			}else{
				$motto = "";
				return $motto;
			}
		}else{
			$motto = "";
			return $motto;
		}
    }

    function badge()
    {
        if (eregi("c_images/album1584/", $this->data))
        {
            $badge = explode('http://images.habbohotel.' . $this->hotel .
                '/c_images/album1584/', $this->data);
            $badge = explode('.gif', $badge[1]);
            $badge = trim($badge[0]);
            $badge = "http://images.habbohotel." . $this->hotel . "/c_images/album1584/" . $badge .
                ".gif";
            return $badge;
        }
        else
        {
            return false;
        }
    }

    function figure()
    {
        $figure = "http://campaigns.habbo.com/0702/app/habboimage.php?habboname=".$this->habboname."&site=http://www.habbo.".$this->hotel;
        return $figure;
    }

    function birthdate()
    {
        $birthdate = explode('<div class="birthday date">', $this->data);
        $birthdate = explode('</div>', $birthdate[1]);
        $birthdate = trim($birthdate[0]);
        return $birthdate;
    }

    function normal()
    {
        if (!$this->banned() and !$this->pageprivate() and $this->actual())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function name()
    {
        $name = explode('<span class="name-text">', $this->data);
        $name = explode('</span>', $name[1]);
        $name = trim($name[0]);
        return $name;
    }

}


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
	
	$sql = mysql_query("SELECT member_id FROM profiel WHERE member_id='".$_SESSION['id']."'");
	
	echo "<center>";
	echo "<a href='?p=profiel&a=zoeken'>Zoek Profielen</a> | ";
	if(mysql_num_rows($sql) == 0) {
		echo "<a href='?p=profiel&a=aanmaken'>Aanmaken</a> | ";
	}else{
	echo "
		<a href='?p=profiel&a=wijzigen'>Wijzigen</a> | 
		<a href='?p=profiel&a=wijzigen_grootprofiel'>Groot Profiel Wijzigen</a> | 
		<a href='?p=profiel&a=rang'>Rang aanpassen</a> | 
		<a href='?p=profiel&a=avatar'>Avatar aanpassen</a> | 
		<a href='?p=profiel&mid=".$_SESSION['id']."'>Bekijk Mijn Profiel</a> | ";
	}
	echo "</center><br /><br /><br />";
	
	
	
	if(isset($_GET['a'])) {
		if($_GET['a'] == "aanmaken") {
			if(isset($_POST['aanmaken'])) {
				echo $profiel->nieuwProfiel($_POST['naam'],$_POST['achternaam'],$_POST['woonplaats'],$_POST['hobby'],$_POST['website'],$_POST['favo_fansite'],$_POST['favo_kamer'],$_POST['land']);
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=aanmaken" method="post">
					Alle velden zijn niet verplicht in te vullen.
					<table width="300">
						<tr>
							<td>Naam</td>
							<td><input type="text" name="naam" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Achternaam</td>
							<td><input type="text" name="achternaam" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Woonplaats</td>
							<td><input type="text" name="woonplaats" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Hobby</td>
							<td><input type="text" name="hobby" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Homepage</td>
							<td><input type="text" name="website" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Favoriete  Fansite</td>
							<td><input type="text" name="favo_fansite" value="<?php echo $row['favo_fansite']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Favoriete  Kamer</td>
							<td><input type="text" name="favo_kamer" value="<?php echo $row['favo_kamer']; ?>" maxlength="255" /></td>
						</tr>
						<input type="hidden" name="land" value="nl" />
						<tr>
							<th colspan="2"><input type="submit" name="aanmaken" value="Aanmaken" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "wijzigen") {
			if(isset($_POST['wijzigen'])) {
				
				echo $profiel->wijzigenProfiel($_POST['naam'],$_POST['achternaam'],$_POST['woonplaats'],$_POST['hobby'],$_POST['website'],$_POST['favo_fansite'],$_POST['favo_kamer'],$_POST['land']);
			}else{
				$sql = mysql_query("SELECT * FROM profiel WHERE member_id='".$_SESSION['id']."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=wijzigen" method="post">
					<table width="300">
						<tr>
							<td>Naam</td>
							<td><input type="text" name="naam" value="<?php echo $row['naam']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Achternaam</td>
							<td><input type="text" name="achternaam" value="<?php echo $row['achternaam']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Woonplaats</td>
							<td><input type="text" name="woonplaats" value="<?php echo $row['woonplaats']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Hobby</td>
							<td><input type="text" name="hobby" value="<?php echo $row['hobby']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Homepage</td>
							<td><input type="text" name="website" value="<?php echo $row['website']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Favoriete  Fansite</td>
							<td><input type="text" name="favo_fansite" value="<?php echo $row['favo_fansite']; ?>" maxlength="255" /></td>
						</tr>
						<tr>
							<td>Favoriete  Kamer</td>
							<td><input type="text" name="favo_kamer" value="<?php echo $row['favo_kamer']; ?>" maxlength="255" /></td>
						</tr>
						<input type="hidden" name="land" value="nl" />
						<tr>
							<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['a'] == "wijzigen_grootprofiel") {
			if(isset($_POST['wijzigen'])) {
				
				echo $profiel->wijzigGrootprofiel($_POST['grootprofiel']);
			}else{
				$sql = mysql_query("SELECT grootprofiel FROM profiel WHERE member_id='".$_SESSION['id']."'");
				$row = mysql_fetch_assoc($sql);
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
					WYSIWYG.attach('grootprofiel',small); // default setup
				</script>
				<form onsubmit="return submitForm();" action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=wijzigen_grootprofiel" method="post">
					<table width="300">
						<tr>
							<td><textarea id="grootprofiel" name="grootprofiel"><?php echo $row['grootprofiel']; ?></textarea></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="wijzigen" value="Wijzigen" /></th>
						</tr>
					</table>
				</form>
				<script language="javascript1.2">
				generate_wysiwyg('grootprofiel');
				</script>
				<?php
			}
		}elseif($_GET['a'] == "zoeken") {
			include('pagina/zoeken.php');
		}elseif($_GET['a'] == "stemmen") {
			if($instellingen['stemmen'] == "uit") {
				echo "Stemmen staat uit.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}else{
				if(isset($_POST['member_id']) && isset($_POST['cijfer'])) {
					if($_POST['member_id'] == $_SESSION['id']) {
						echo "Je kan niet op jezelf stemmen.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						echo $doe->stemmen($_POST['member_id'],$_POST['cijfer']);
					}
				}else{
					echo "De member id of cijfer is niet aanwezig.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					echo "<br />".$_POST['member_id']."<br />".$_POST['cijfer'];
				}
			}
		}elseif($_GET['a'] == "rang") {
			if(isset($_POST['aanpassen']) && !empty($_POST['rang_id'])) {
				if($_POST['rang_id'] == "habbo") {
					mysql_query("UPDATE leden SET rang='Habbo' WHERE member_id='".$_SESSION['id']."'");
					if(mysql_error() == "") {
						echo "Je rang is succesvol aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						return mysql_error();
					}
				}elseif($_POST['rang_id'] == "clublid"){
		mysql_query("UPDATE leden SET rang='Club Lid' WHERE member_id='".$_SESSION['id']."'");
				echo "Je rang is succesvol aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}else{
					echo $doe->rangAanpassen($_POST['rang_id']);
				}
			}else{
				$sql = mysql_query("SELECT * FROM gekochte_rangen WHERE member_id='".$_SESSION['id']."'");
				if(mysql_num_rows($sql) < 1) {
					echo "Je hebt nog geen rangen gekocht in de shop<br />
					<a href='?p=shop&a=shop'>Koop hier rangen</a>";
				}else{
					?>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=rang" method="post">
						Pas hier je profiel rank aan.<br />
						Deze rang kan je zien op je profiel pagina.<br /><br />
						<select name="rang_id">
							<option value="lid">Lid</option>
							<?php
							while($row = mysql_fetch_assoc($sql)) {
								$sql_rang = mysql_query("SELECT titel FROM shop_rangen WHERE rang_id='".$row['rang_id']."'");
								$row_rang = mysql_fetch_assoc($sql_rang);
								?>
								<option value="<?php echo $row['rang_id']; ?>"><?php echo $row_rang['titel']; ?></option>
								<?php
							}
							$sql_clublid = mysql_query("SELECT * FROM clublid WHERE member_id='".$_SESSION['id']."'");
							if(mysql_num_rows($sql_clublid) == 1) {
							echo "<option value=\"clublid\">Club Lid</option>";
							}
							?>
						</select><br />
						<br />
						<input type="submit" name="aanpassen" value="Aanpassen" />
					</form>
					<?php
				}
			}
		}elseif($_GET['a'] == "avatar") {
			if(isset($_POST['aanpassen'])) {
				if($_POST['soort'] == "upload") {
					$toegestane_grootte = 250*1024;
					$toegestane_mimetypes = array("image/jpeg","image/jpg","image/gif","image/png");
					$uploadmap = 'uploads/avatars/';
					list($width, $height, $type, $attr) = getimagesize($_FILES['avatar']['tmp_name']);
					$errors = array(
					   0=>"Bestand succesvol geupload.",
					   1=>"De grootte van het bestand overschrijdt de upload_max_filesize (".ini_get("upload_max_filesize").") in php.ini.",
					   2=>"De grootte van het bestand overschrijdt de MAX_FILE_SIZE (".$toegestane_grootte." bytes) die opgegeven is in het HTML formulier",
					   3=>"Het bestand is slecht gedeeltelijk geupload.",
					   4=>"Geen bestand geupload.",
					   6=>"Kan de tijdelijke map niet vinden."
					);
					 
					if($_SERVER['REQUEST_METHOD'] == 'POST') {
					   $mimetype = strtolower($_FILES['avatar']['type']);
					   if(!is_uploaded_file($_FILES['avatar']['tmp_name']))
						  die("Er is een vreemd probleem opgetreden, <em>".$_FILES['avatar']['name']."</em>.");
					   elseif($height > 150 || $width > 150) {
					      echo ("Je avatar is helaas te groot, hij mag maar 150px bij 150px groot zijn.<br /><a href='javascript:history.go(-1)'>Ga terug</a>");
						  
					   }elseif($_FILES['avatar']['error'] != 0)
						  echo("<strong>Error:</strong><br />".$errors[$_FILES['avatar']['error']]);
					   elseif($_FILES['avatar']['size'] > $toegestane_grootte)
						  echo("Het bestand is te groot");
					   elseif(!in_array($mimetype,$toegestane_mimetypes))
						  echo("U gebruikt een ongeldig bestandstype!");
					   else{
						  $bestand_nieuw = $uploadmap . basename($_FILES['avatar']['name']);
						  if (move_uploaded_file($_FILES['avatar']['tmp_name'], $bestand_nieuw)) {
						  	$avatar = "uploads/avatars/".$_FILES['avatar']['name'];
							$hand = mysql_real_escape_string($_POST['handtekening']);
							mysql_query("UPDATE leden SET avatar='".$avatar."',handtekening='".$hand."' WHERE member_id='".$_SESSION['id']."'");
							echo "Je avatar is aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
						  }else{
							 echo "Er is een fout opgetreden tijdens het uploaden, Mogelijk is de map uploads/avatars/ niet geCHMOD naar 777.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
						  }
					   }
					}
				}elseif($_POST['soort'] == "http") {
			
					$avatar = mysql_real_escape_string($_POST['avatarlink']);
					$hand = mysql_real_escape_string($_POST['handtekening']);
					list($width, $height, $type, $attr) = getimagesize($avatar);
					if(!empty($width) && !empty($height) && $width <= 150 && $height <= 150) {
						mysql_query("UPDATE leden SET avatar='".$avatar."',handtekening='".$hand."' WHERE member_id='".$_SESSION['id']."'");
						echo "Je avatar is aangepast.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}else{
						echo "Het plaatje is te groot.<br />Hij mag maar 150px bij 150px zijn.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
					}
				}else{
					echo "Je hebt geen soort aangeklikt.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
				}
			}else{
				$sql = mysql_query("SELECT avatar,handtekening FROM leden WHERE member_id='".$_SESSION['id']."'");
				$row = mysql_fetch_assoc($sql);
				$toegestane_grootte = 250*1024;
				?>
				<form name='uploadform' enctype='multipart/form-data' action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=avatar" method="post">
				<input type='hidden' name='MAX_FILE_SIZE' value='<?php echo $toegestane_grootte; ?>' />
					<img src="<?php if($row['avatar'] == "") { echo "images/noavatar.gif"; }else{ echo $row['avatar']; } ?>" /><br />
					<table width="400">
						<tr>
							<td width="30%"><input type="radio" name="soort" value="upload" />Avatar upload</td>
							<td><input type="file" name="avatar" style="width:250px;" /></td>
						</tr>
						<tr>
							<td width="30%"><input checked="checked" type="radio" name="soort" value="http" />Avatar link</td>
							<td><input type="text" name="avatarlink" style="width:250px;" value="<?php echo $row['avatar']; ?>" /></td>
						</tr>
						<tr>
							<td colspan="2" width="30%">Handtekening</td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="handtekening" style="width:100%; height:200px;"><?php echo $row['handtekening']; ?></textarea></td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" name="aanpassen" value="Aanpassen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}
	}elseif(isset($_GET['mid'])) {
		error_reporting(0);
		$instellingen = mysql_fetch_assoc(mysql_query("SELECT * FROM instellingen WHERE instellingen_id='1'"));
		$mid = addslashes(substr($_GET['mid'],0,30));
		$sql_bannen = mysql_query("SELECT ip FROM leden WHERE member_id='".$mid."'");
		$row_bannen = mysql_fetch_assoc($sql_bannen);
		$sql_ip = mysql_query("SELECT ip FROM ipban WHERE ip = '".$row_bannen['ip']."'");
		if(mysql_num_rows($sql_ip) != 0) {
			echo "Dit account is helaas verbannen, Omdat de gebruiker de regels heeft overtreden.<br />";
		}else{
			$sql = mysql_query("SELECT * FROM profiel WHERE member_id='".$mid."'");
			$sql_leden = mysql_query("SELECT * FROM leden WHERE member_id='".$mid."'");
			if(mysql_num_rows($sql) == 1) {
				$row = mysql_fetch_assoc($sql);
				$row_leden = mysql_fetch_assoc($sql_leden);
				?>
					<table style="border: 1px solid #000000;" cellpadding="1" cellspacing="1" width="100%">
						<tr>
							<td rowspan="99" width="10%" style="text-align: center; background: #0091a7">
								<?php if($instellingen['habbo'] == "nee") {
									if($row_leden['avatar'] == "") {
										echo "<br /><img width='80' height='80' src='images/noavatar.gif' />";
									}else{
										echo "<br /><img src='".$row_leden['avatar']."' />";
									}					
								}else{ ?>
									<img src="http://www.habbo.nl/habbo-imaging/avatarimage?user=<?php echo htmlspecialchars($row_leden['gebruikersnaam']); ?>&action=none&direction=2&head_direction=2&gesture=smile&size=l" border="0" alt="" />
								<?php } ?>
							</td>
							<?php if($row['naam'] != "") { ?>
								<td width="20%"><b>Naam:</b></td>
								<td width="70%" style="background: #0091a7;"><?php echo $row['naam']; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<?php if($row['achternaam'] != "") { ?>
								<td width="20%"><b>Achternaam:</b></td>
								<td width="70%" style="background: #0091a7;"><?php echo $row['achternaam']; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<?php if($row['woonplaats'] != "") { ?>
								<td width="20%"><b>Woonplaats:</b></td>
								<td width="70%" style="background: #0091a7;"><?php echo $row['woonplaats']; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<?php if($row['hobby'] != "") { ?>
								<td width="20%"><b>Hobby:</b></td>
								<td width="70%" style="background: #0091a7;"><?php echo $row['hobby']; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<?php if($row['website'] != "") { ?>
								<td width="20%"><b>Homepage:</b></td>
								<td width="70%" style="background: #0091a7;"><a target="_blank" href='<?php
								if(eregi("http:",$row['website']) == false) {
									echo "http://";
								} echo stripslashes(htmlspecialchars($row['website'])); ?>'><?php echo $row['website']; ?></a></td>
							<?php } ?>
						</tr>
						<tr>
							<?php if($row['favo_fansite'] != "") { ?>
								<td width="20%"><b>Favoriete fansite:</b></td>
								<td width="70%" style="background: #0091a7;"><a target="_blank" href='<?php
								if(eregi("http:",$row['favo_fansite']) == false) {
									echo "http://";
								}
								 echo stripslashes(htmlspecialchars($row['favo_fansite'])); ?>'><?php echo $row['favo_fansite']; ?></a></td>
							<?php } ?>
						</tr>
						<tr>
							<?php if($row['favo_kamer'] != "") { ?>
								<td width="20%"><b>Favoriete kamer:</b></td>
								<td width="70%" style="background: #0091a7;"><?php echo $row['favo_kamer']; ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td width="20%"><b>Gebruikersnaam:</b></td>
							<td width="70%" style="background: #0091a7;"><?php echo $row_leden['gebruikersnaam']; ?></td>
						</tr>
						<tr>
							<td width="20%"><b>Punten:</b></td>
							<td width="70%" style="background: #0091a7;"><?php echo $row_leden['punten']; ?></td>
						</tr>
						<tr>
							<td width="20%"><b>Munten:</b></td>
							<td width="70%" style="background: #0091a7;"><?php echo $row_leden['muntjes']; ?></td>
						</tr>
						<tr>
							<td width="20%"><b>Rang:</b></td>
							<td width="70%" style="background: #0091a7;"><?php 
							if($row_leden['rang'] == "habbo" && $instellingen['habbo'] == "nee") {  
								echo "Lid";
							}else{
								echo $row_leden['rang'];
							}?></td>
						</tr>
						<tr>
							<td width="20%"><b>Online:</b></td>
							<td width="70%" style="background: #0091a7;">
								<?php
								$sql = "SELECT member_id FROM leden WHERE DATE_SUB(NOW(),INTERVAL 5 MINUTE) <= lastonline AND member_id='".$mid."'";
								$query = mysql_query($sql);
								$tellen = mysql_num_rows($query);
								if($tellen == 1) {
									echo "<font color='darkgreen'>Online</font>";
								}else{
									echo "<font color='darkred'>Offline</font>";
								}
								?>
							</td>
						</tr>
							<td width="20%"><b>Grootprofiel:</b></td>
							<td width="70%" style="background: #0091a7;">
								<?php
								$sql = mysql_query("SELECT grootprofiel FROM profiel WHERE member_id='".$mid."'");
								$row = mysql_fetch_assoc($sql);
								if($row['grootprofiel'] != "") {
									echo "<a href=\"?p=grootprofiel&mid=".$mid."\">Open grootprofiel</a>";
								}else{
									echo "Geen profiel";
								}
								?>
							</td>
						</tr>
						<tr>
							<td width="20%"><b>Vrienden:</b></td>
							<td width="70%" style="background: #0091a7;"><a href="?p=vriend_toevoegen&vid=<?php echo $mid; ?>">Verzoek sturen</a></td>
						</tr>
						<tr>
							<td width="20%"><b>Bericht:</b></td>
							<td width="70%" style="background: #0091a7;"><a href="?p=bericht&a=versturen&aan=<?php echo $row_leden['gebruikersnaam']; ?>">Bericht sturen</a></td>
						</tr>
						<?php
						$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
						$sql_lid = mysql_query("SELECT * FROM guild_leden WHERE member_id='".$mid."'");
						if(mysql_num_rows($sql) ==  1 && mysql_num_rows($sql_lid) ==  0) { ?>
							<tr>
								<td width="20%"><b>Guild:</b></td>
								<td width="70%" style="background: #0091a7;"><a href="?p=guildverzoeken&a=verzoeken&id=<?php echo $mid; ?>">Verzoek sturen</a></td>
							</tr>
						<?php
						}elseif(mysql_num_rows($sql_lid) ==  1) {
							$row_lid = mysql_fetch_assoc($sql_lid);
							$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$row_lid['guild_id']."'");
							$row = mysql_fetch_assoc($sql);
							?>
							<tr>
								<td width="20%"><b>Guild:</b></td>
								<td width="70%" style="background: #0091a7;"><a href="?p=guildoverzicht&id=<?php echo $row['id']; ?>"><?php echo $row['naam']; ?></a></td>
							</tr>
							<?php
						}
							
						if($instellingen['habbo'] == "ja") { 
							$habbo = new habboClass($row_leden['gebruikersnaam'],"nl");
						?>
						<tr>
							<td width="20%"><b>Habbo Online:</b></td>
							<td width="70%" style="background: #0091a7;"><?php if($habbo->online() == true) { echo "Online"; } else { echo "Offline"; } ?></td>
						</tr>
						<tr>
							<td width="20%"><b>Habbo Missie:</b></td>
							<td width="70%" style="background: #0091a7;"><?php if(strlen($habbo->motto()) != "") { echo str_replace('
<div class="clear">',' ',$habbo->motto()); } ?></td>
						</tr>
						<tr>
							<td width="20%"><b>Habbo Sinds:</b></td>
							<td style="background: #0091a7;"><?php echo htmlspecialchars($habbo->birthdate()); ?></td>
						</tr>
						<tr>
							<td width="20%"><b>Habbo Badge:</b></td>
							<td style="background: #0091a7;">
								<?php
								$habbo_badge = $habbo->badge();
								if(!empty($habbo_badge)) { echo "<img src=\"".$habbo->badge()."\" alt=\"Habbo Badge\" />"; }
								?>
							</td>
						</tr>
						<?php } ?>
					</table><br /><br />
					
					<?php
					if($instellingen['stemmen'] == "aan") {
						/////// STEMMEN GEDEELTE /////////
						?>
						
						<table width="100%" style="border:1px solid #000000;" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background: #0091a7; border-bottom: 1px solid #000000;"><b>Stemmen</b></td>
							</tr>
							<tr>
								<td><br />
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=profiel&a=stemmen" method="post">
									<input type="hidden" name="member_id" value="<?php echo $mid; ?>" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey1.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="1" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey2.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="2" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey3.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="3" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey4.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="4" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey5.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="5" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey6.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="6" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey7.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="7" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey8.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="8" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey9.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="9" />
									<input type="submit" name="cijfer" style="background: url('http://habsterdam.nl/Images/stickeys/stikey10.gif'); border: 0px; height: 48px; width: 48px; font-size:0px;" value="10" />
									</form>
									<br />
								</td>
							</tr>
						</table><br /><br />
						<?php
						///////// EINDE STEMMEN GEDEELTE //////////
					}
					
					if($instellingen['shop'] == "aan") {
						//////// 	BADGES GEDEELTE //////
						?>
						<table width="100%" style="border:1px solid #000000;" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background: #0091a7; border-bottom: 1px solid #000000;"><b>Badges</b></td>
							</tr>
							<tr>
								<td>
						<?php
						$sql = mysql_query("SELECT * FROM gekochte_badges WHERE member_id='".$mid."'");
						$sql_speciale = mysql_query("SELECT * FROM speciale_badges_members WHERE member_id='".$mid."'");
						if(mysql_num_rows($sql) >= 1 || mysql_num_rows($sql_speciale) >= 1 ) {
							
							while($row = mysql_fetch_assoc($sql)) {
								$sql_badge = mysql_query("SELECT * FROM shop_badges WHERE badge_id='".$row['badge_id']."'");
								if(mysql_num_rows($sql_badge) >= 1) {
									$row_badge = mysql_fetch_assoc($sql_badge);
									echo "<a href='?p=badges&bid=".$row['badge_id']."'><img border=\"0\" src='".$row_badge['plaatje']."' /></a> ";
						 }
							}
							
							while($row = mysql_fetch_assoc($sql_speciale)) {
								$sql_badge = mysql_query("SELECT * FROM speciale_badges WHERE badge_id='".$row['badge_id']."'");
								if(mysql_num_rows($sql_badge) >= 1) {
									$row_badge = mysql_fetch_assoc($sql_badge);
									echo "<img src='".$row_badge['plaatje']."' /> ";
								}
							}
								
						}
						$sql_club = mysql_query("SELECT * FROM clublid WHERE member_id='".$_SESSION['id']."'");
						$row_club = mysql_fetch_assoc($sql_club);
						if(mysql_num_rows($sql_club) == 1) {
							echo "<img src='images/clublid.gif' alt='Club Lid badge'>";
						}
						if(mysql_num_rows($sql_club) == 0 && mysql_num_rows($sql) == 0 && mysql_num_rows($sql_speciale) == 0) {
							echo "<br />Je hebt nog geen badges in je bezit.<br />";
						}
						include ("pagina/badges_functie.php");
						?>
								</td>
							</tr>
						</table><br /><br />
					<?php 
					///////// EINDE BADGES GEDEELTE /////////
					
					
					if($instellingen['meubi'] == "aan") {
						//////// 	MEUBI GEDEELTE //////
						$sql = mysql_query("SELECT * FROM gekochte_meubi WHERE member_id='".$mid."'");
						if(mysql_num_rows($sql) >= 1) {
							
							while($row = mysql_fetch_assoc($sql)) {
								$sql_badge = mysql_query("SELECT * FROM shop_meubi WHERE meubi_id='".$row['meubi_id']."'");
								if(mysql_num_rows($sql_badge) >= 1) {
						?>
						<table width="100%" style="border:1px solid #000000;" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background: #0091a7; border-bottom: 1px solid #000000;"><b>Meubels</b></td>
							</tr>
							<tr>
								<td>
									<?php
						
									$row_badge = mysql_fetch_assoc($sql_badge);
									echo "<img border=\"0\" src='".$row_badge['plaatje']."' />";
								
									?>
								</td>
							</tr>
						</table>
					<?php }
							}
						}
						///////// EINDE MEUBI GEDEELTE /////////
					}
					?>
				<?php } if($instellingen['gastenboek'] == "aan") { ?>
					<?php
						function br2nl($tekst) {
							$tekst = str_replace("<br>","\n",$tekst);
							$tekst = str_replace("<br />","\n",$tekst);
							$tekst = str_replace("<br/>","\n",$tekst);
							return $tekst;
						}
						//////////// GASTENBOEK //////////////////
					$sql_gastenboek = mysql_query("SELECT * FROM gastenboek WHERE member_id='".$mid."'");
					if(mysql_num_rows($sql_gastenboek) == 1) {
						?>
						<table width="100%" style="border:1px solid #000000;" cellpadding="0" cellspacing="0">
							<tr>
								<td style="background: #0091a7; border-bottom: 1px solid #000000;"><b>Gastenboek</b></td>
							</tr>
							<tr>
								<td>
							<?php
						$row_gastenboek = mysql_fetch_assoc($sql_gastenboek);
						$sql_berichten = mysql_query("SELECT * FROM gastenboek_berichten WHERE gastenboek_id='".$row_gastenboek['gastenboek_id']."' ORDER BY datum DESC LIMIT 4");
						echo '<table width="100%">';
						while($row_berichten = mysql_fetch_assoc($sql_berichten)) {
							$sql_leden = mysql_query("SELECT avatar FROM leden WHERE gebruikersnaam='".$row_berichten['habbonaam']."'");
							$row_leden = mysql_fetch_assoc($sql_leden);
							?>
								<tr>
									<td valign="top" rowspan="5">
									<?php
									if($row_berichten['habbonaam'] == "Systeem") {
										if($instelligen['habbo'] == "ja") {
											echo "<img src='https://www.habbo.nl/deliver/images.habbohotel.nl/c_images/album1358/frank_thumbup.gif?h=3bf5998d019ae5e63b3eec53a20bc20f' align='left' />";
										}
									}else{
										if($instelligen['habbo'] == "ja") {
											echo '<img src="http://www.habbo.nl/habbo-imaging/avatarimage?user='.htmlspecialchars($row_berichten['habbonaam']).'&action=hallo&frame=1&direction=4&head_direction=3&gesture=smile&size=b&img_format=gif" align="left" />';
										}else{
											echo '<img src="'.$row_leden['avatar'].'" align="left" />';
										}
									}
									?></td>
								</tr>
								<tr>
									<td><strong>Gebruikersnaam</strong></td>
								</tr>
								<tr>
									<td valign="top"><?php echo htmlspecialchars($row_berichten['habbonaam']); ?></td>
								</tr>
								<tr>
									<td colspan="2"><strong>Bericht</strong></td>
								</tr>
								<tr>
									<td colspan="2" valign="top"><?php echo htmlspecialchars(br2nl(wordwrap($row_berichten['bericht'],60,"\n",1))); ?></td>
								</tr>
								<tr>
									<td colspan="2"><hr /></td>
								</tr>
							<?php
						}
						echo "</table>";
						if(mysql_num_rows($sql_berichten) == 0) {
							echo "Er staan geen berichten in dit gastenboek.";
						}
						?>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=gastenboek&a=posten" method="post">
							<input type="hidden" name="gastenboek_id" value="<?php echo $row_gastenboek['gastenboek_id']; ?>" />
							<table width="100%">
								<tr>
									<td><strong>Bericht</strong></td>
								</tr>
								<tr>
									<td><textarea name="bericht" style="width:250px; height:100px;"></textarea></td>
								</tr>
								<tr>
									<td><input type="submit" name="posten" value="Posten" /></th>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
			<?php
					}
					//// EINDE GASTENBOEK GEDEELTE ////
				 } if($instellingen['poll'] == "aan") {
				
					//////////////// POLL //////////////////////////
					$mid = addslashes(substr($_GET['mid'],0,30));
					$sql_poll = mysql_query("SELECT * FROM poll WHERE member_id='".$mid."'");
					if(mysql_num_rows($sql_poll) == 1) {
					?><br />
					<table width="100%" style="border:1px solid #000000;" cellpadding="0" cellspacing="0">
						<tr>
							<td style="background: #0091a7; border-bottom: 1px solid #000000;"><b>Poll</b></td>
						</tr>
						<tr>
							<td>
				<?php
						$row_poll = mysql_fetch_assoc($sql_poll);
						$sql_ip = mysql_query("SELECT * FROM poll_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."' AND poll_id='".$row_poll['poll_id']."'");
						if(mysql_num_rows($sql_ip) == 0) {
							?>
							<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=poll&a=stemmen" method="post">
								<input type="hidden" name="poll_id" value="<?php echo $row_poll['poll_id']; ?>" />
								<table width="100%">
									<tr>
										<td colspan="2">Vraag : <strong><?php echo stripslashes(htmlspecialchars($row_poll['vraag'])); ?></strong></td>
									</tr>
									<tr>
										<td width="4%"><input type="radio" name="ant" value="aantal1" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant1'])); ?></td>
									</tr>
									<tr>
										<td><input type="radio" name="ant" value="aantal2" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant2'])); ?></td>
									</tr>
									<tr>
										<td><input type="radio" name="ant" value="aantal3" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant3'])); ?></td>
									</tr>
									<tr>
										<td><input type="radio" name="ant" value="aantal4" /></td>
										<td><?php echo stripslashes(htmlspecialchars($row_poll['ant4'])); ?></td>
									</tr>
									<tr>
										<th colspan="2"><input type="submit" name="stemmen" value="Stemmen" /></th>
									</tr>
								</table>
							</form>
							<?php
						}else{
							?>
							<table width="100%">
								<tr>
									<td colspan="2"><?php echo stripslashes(htmlspecialchars($row_poll['vraag'])); ?></td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant1']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal1'])); ?>X gestemd</td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant2']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal2'])); ?>X gestemd</td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant3']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal3'])); ?>X gestemd</td>
								</tr>
								<tr>
									<td width="70%"><?php echo $row_poll['ant4']; ?></td>
									<td><?php echo stripslashes(htmlspecialchars($row_poll['aantal4'])); ?>X gestemd</td>
								</tr>
							</table>
							<?php
						}
					//// EINDE POLL GEDEELTE ////
					?>
				</td>
			</tr>
		</table>
	
	<?php } ?><br /><br />
			<table width="100%" style="border:1px solid #000000;" cellpadding="0" cellspacing="0">
				<tr>
					<td style="background: #0091a7; border-bottom: 1px solid #000000;"><b>Vrienden</b></td>
				</tr>
				<tr>
					<td><br />
	<?php
					
					/// Begin van vrienden gedeelte ////
					$sql_vrienden = mysql_query("SELECT * FROM vrienden WHERE member_id='".$mid."' AND actief='actief'");
					$sql_vv = mysql_query("SELECT * FROM vrienden WHERE member_id='".$mid."' AND actief='dood'");
					
					echo "<h3 style='margin: 0px;'>Vrienden</h3>";
					echo "<table width='200'>";
					while($row_vrienden = mysql_fetch_assoc($sql_vrienden)) {
						$row_vrienden_naam = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row_vrienden['vriend_id']."'"));
						echo "
							<tr>
								<td><a href='?p=profiel&mid=".$row_vrienden['vriend_id']."'>".stripslashes(htmlspecialchars($row_vrienden_naam['gebruikersnaam']))."</a></td>
							</tr>";
					}
					echo "</table>";
					if(mysql_num_rows($sql_vrienden) == 0) {
						echo "Deze gebruiker heeft nog geen vrienden.<br />";
					}
					
					echo "<br /><h3 style='margin: 0px;'>Vrienden Verzoeken</h3>";
					echo "<table width='200'>";
					while($row_vv = mysql_fetch_assoc($sql_vv)) {
						$row_vv_naam = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row_vv['vriend_id']."'"));
						echo "
							<tr>
								<td><a href='?p=profiel&mid=".$row_vv['vriend_id']."'>".stripslashes(htmlspecialchars($row_vv_naam['gebruikersnaam']))."</a></td>
							</tr>";
					}
					echo "</table>";
					if(mysql_num_rows($sql_vv) == 0) {
						echo "Deze gebruiker heeft nog geen vrienden verzoeken.<br />";
					}
					/// Einde van vrienden gedeelte ///
				?>
				</td>
			</tr>
		</table><br /><br />
				<?php
				}

			}else{
				echo "Dit persoon heeft geen profiel gemaakt.";
			}
		}
	}else{
		echo "Selecteer een optie in het submenu hierboven.";
	}
}else{
	echo "Je bent helemaal niet ingelogd.<br /><a href=\"javascript:history.go(-1)\">Ga terug</a>";
}
?>
