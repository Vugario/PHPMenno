<?php
function Checknaam($naam) {
   return ereg("[:alnum:]",$naam);
}

if(isset($_SESSION['id'])) {
	$sql = mysql_query("SELECT * FROM guild WHERE member_id='".$_SESSION['id']."'");
	if(mysql_num_rows($sql) ==  1) {
		echo "Je hebt al een guild in je bezit.<br><a href='javascript:history.go(-1)'>Ga terug</a>";
	}else{
		if(isset($_POST['submit']) && !empty($_POST['naam']) && !empty($_POST['beschrijving']) && eregi("http://",$_POST['logo'])) {
		
		$naam = substr(mysql_real_escape_string(str_replace("'","",str_replace(trim('\ '),"",$_POST['naam']))),0,255);
		$logo = mysql_real_escape_string(substr($_POST['logo'],0,255));
		$beschrijving = substr(mysql_real_escape_string($_POST['beschrijving']),0,255);
		list($width, $height, $type, $attr) = getimagesize($_POST['logo']);
		if($height == NULL || $height > 200 || $width > 200) {
			echo "Je gekozen avatar is helaas te groot, Hij mag maximaal 200px bij 200px zijn.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}elseif($get['muntjes'] - GUILDKOSTEN < 0) {
			echo "Je hebt helaas niet genoeg munten.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
		}elseif(Checknaam($_POST['naam']) == false) {
			echo "Je hebt ongeldige tekens in je naam gebruikte, alleen (hoofd)letters en cijfers zijn toegestaan.<br />
			<a href='javascript:history.go(-1)'>Ga terug</a><br />";
		}else{
			mysql_query("UPDATE leden SET muntjes=muntjes-".GUILDKOSTEN." WHERE member_id='".$_SESSION['id']."'");
			mysql_query("INSERT INTO guild (naam,member_id,datum,beschrijving,maxleden,logo) VALUES ('".$naam."','".$_SESSION['id']."',NOW(),'".$beschrijving."','20','".$logo."')");
			$guild_id = mysql_insert_id();
			mysql_query("INSERT INTO guild_info (guild_id,info,datum) VALUES ('".$guild_id."','De guild <strong>".$naam."</strong> is opgericht.',NOW())");
			mysql_query("INSERT INTO guild_rangen (guild_id,naam) VALUES ('".$guild_id."','Guild master')");
			$guildmaster = mysql_insert_id();
			mysql_query("INSERT INTO guild_rangen (guild_id,naam) VALUES ('".$guild_id."','General')");
			mysql_query("INSERT INTO guild_rangen (guild_id,naam) VALUES ('".$guild_id."','Commander')");
			mysql_query("INSERT INTO guild_rangen (guild_id,naam) VALUES ('".$guild_id."','Member')");
			mysql_query("INSERT INTO guild_rangen (guild_id,naam) VALUES ('".$guild_id."','Starter')");
			mysql_query("INSERT INTO guild_leden (guild_id,member_id,datum,rang_id) VALUES ('".$guild_id."','".$_SESSION['id']."',NOW(),'".$guildmaster."')");
			if(mysql_error() == "") {
				$naam = substr(mysql_real_escape_string(str_replace("'","",str_replace(trim('\ '),"",$_POST['naam']))),0,255);
				echo "Je guild is succesvol aangemaakt.<br>
				<strong>".stripslashes($naam)."</strong><br>
				Je krijgt een nieuw menu te zien waarin je je guild kan beheren.<br><a href='javascript:history.go(-2)'>Ga terug</a>";
			}else{
				echo "Er is een onbekende fout opgetreden.<br /><a href='javascript:history.go(-1)'>Ga terug</a>";
			}
		}
		
		}else{
			if(isset($_POST['submit']) && !eregi("http://",$_POST['logo'])) {
				echo "<strong>Het ingevulde logo is helaas ongeldig, het moet beginnen met http://</strong><br><br>";
			}
			?>
			Hier kan je je eigen guild maken.<br />
			Een guild is een groep waarin je mensen kan uitnodigen en kan promoten.<br />
			Een eigen guild kost <?php echo GUILDKOSTEN; ?> munten<br />
			<br />
			* Guild logo mag maximaal 200 bij 200 pixels zijn<br />
			<br />
			<form action="?p=guildmaken" method="post">
				<table width="100%">
					<tr>
						<td width="20%">Guild Naam</td>
						<td><input type="text" maxlength="255" name="naam" value="<?php echo $_POST['naam']; ?>" maxlength="255" /></td>
					</tr>
					<tr>
						<td>Guild logo link*</td>
						<td><input type="text" maxlength="255" name="logo" style="width: 386px;" value="<?php echo $_POST['logo']; ?>" maxlength="255" /></td>
					</tr>
					<tr>
						<td valign="top">Beschrijving</td>
						<td><textarea cols="45" rows="12" name="beschrijving"><?php echo $_POST['beschrijving']; ?></textarea></td>
					</tr>
					<tr>
						<th colspan="3"><input class="submit" type="submit" name="submit" value="Maak Guild"></th>
					</tr>
				</table>
			</form>
			<?php
		}
	}
}else{
	echo "Je moet ingelogd zijn voor deze pagina.";
}
?>