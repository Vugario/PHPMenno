<script type="text/javascript">
function addSmilie(code) {
    document.form1.bericht.value+=code;
    document.form1.bericht.focus();
}
</script>
<?php
include('class/smiley.class.php');


if(isset($_GET['nid']) && !empty($_GET['nid']) && is_numeric($_GET['nid'])) {

	$nid = mysql_real_escape_string(substr($_GET['nid'],0,30));

	// Toevoegen van reacties //
	if(isset($_POST['submit']) && !empty($_POST['bericht'])) {
	
		if(isset($_SESSION['id'])) {
			$timeoutseconds = 15;
			$timestamp = time();
			$timeout = $timestamp-$timeoutseconds;
			mysql_query("DELETE FROM blogs_reacties_ip WHERE moment<$timeout AND ip='".$_SERVER['REMOTE_ADDR']."'");
			
			$sql_spam = mysql_query("SELECT * FROM blogs_reacties_ip WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
	
			if(mysql_num_rows($sql_spam) == 1) {
				echo "<span style='color: red; font-weight: bold;'>Je mag maar 1 keer in de 15 seconde een reactie posten.<br /><a href='javascript:history.go(-1)'>Ga terug</a></span>";
			}else{
				$bericht = mysql_real_escape_string(substr($_POST['bericht'],0,200));
				mysql_query("INSERT INTO blogs_reacties (blogs_id,ip,member_id,bericht,datum) 
							VALUES ('".$nid."','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['id']."','".$bericht."',NOW())");
				mysql_query("INSERT INTO blogs_reacties_ip (ip,moment) VALUES ('".$_SERVER['REMOTE_ADDR']."','".$timestamp."')");
				mysql_query("UPDATE leden SET muntjes=muntjes + ".$bedragperreactie." WHERE member_id='".$_SESSION['id']."'");	
							
				if(mysql_error() == "") {
					echo "<span style='color: green; font-weight: bold;'>Reactie is succesvol toegevoegd.<br>Je hebt hiermee ".$bedragperreactie." muntjes verdient.</span>";
				}else{
					echo "<span style='color: red; font-weight: bold;'>Reactie is niet toegevoegd, er is iets fout gegaan.<br>Misschien heeft iemand hetzelfde bericht gepost<br></span>";
				}
			}
		}else{
			echo "Je moet ingelogd zijn om een reactie te posten.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
		}
	}
	
	// Eind van reacties //
	
	$sql = mysql_query("SELECT * FROM blogs_berichten WHERE blogs_id = '".$nid."'");
	
	$row = mysql_fetch_assoc($sql);	
	
	if($row['actief'] == "aan") {
		
		$sql_member = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id = '".$row['member_id']."'");
		$row_member = mysql_fetch_assoc($sql_member);
		$bericht = $row['bericht'];
		$bericht = str_replace("<script","",$bericht);
		$bericht = str_replace("<javascript","",$bericht);
		$bericht = str_replace("noscript","",$bericht);
		$bericht = str_replace("alert(","",$bericht);
		$bericht = str_replace("window.","",$bericht);
		$langbericht = $row['langbericht'];
		$langbericht = str_replace("<script","",$langbericht);
		$langbericht = str_replace("<javascript","",$langbericht);
		$langbericht = str_replace("noscript","",$langbericht);
		$langbericht = str_replace("alert(","",$langbericht);
		$langbericht = str_replace("window.","",$langbericht);
		
		//// Laat blogs zien ////
		
		?>
		<table width='100%' cellpadding='0' cellspacing='0'>
			<tr>
				<td width='100%'><b>&nbsp;&nbsp;<?php echo stripslashes(htmlspecialchars($row['titel'])); ?></b></td>
			</tr>
			<tr>
				<td><i>Gepost door <strong><?php echo $row_member['gebruikersnaam']; ?></strong> op <strong><?php echo $row['datum']; ?></strong></i><br></td>
			</tr>
			<tr>
				<td><?php echo stripslashes($bericht); ?></td>
			</tr>
			<tr>
				<td><?php echo stripslashes($langbericht); ?></td>
			</tr>
		</table>
		<?php
		
		/// Reacties ///
		
		$sql_reacties = mysql_query("SELECT * FROM blogs_reacties WHERE blogs_id = '".$nid."' ORDER BY datum DESC");
		while($row = mysql_fetch_assoc($sql_reacties)) {
			if($row['member_id'] != "") {
	
				$sql_member = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id = '".$row['member_id']."'");
				$row_member = mysql_fetch_assoc($sql_member);
				$bericht = $row['bericht'];
				$bericht = str_replace("<script","",$bericht);
				$bericht = str_replace("<javascript","",$bericht);
				$bericht = str_replace("noscript","",$bericht);
				$bericht = str_replace("alert(","",$bericht);
				$bericht = str_replace("window.","",$bericht);
				?><br>
	
				<table width='100%' cellpadding='0' cellspacing='0'>
					<tr>
						<td width='100%'><strong>Er is gereageerd door <a href='?p=profiel&mid=<?php echo $row['member_id']; ?>'><?php echo $row_member['gebruikersnaam']; ?></a>!</strong></td>
					</tr>
					<tr>
						<td><img src="http://www.habbo.nl/habbo-imaging/avatarimage?user=<?php echo $row_member['gebruikersnaam']; ?>&action=sit,wav,crr=3&direction=2&head_direction=3&gesture=sml&size=s&img_format=gif" border="0" align="left" /><?php echo wordwrap(stripslashes(nl2br(addSmiley($bericht))),150,"\n",1); ?></td>
					</tr>
					<tr>
						<td><i>Geplaatst op <?php echo $row['datum']; ?></i></td>
					</tr>
				</table>
				<?php
			}
		}
		
		// Toevoegen van reactie //
		
		?>
		<?php 
		if(isset($_SESSION['id'])) { ?>
			<form name="form1" action="<?php echo $_SERVER['PHP_SELF'] ?>?p=blogs&nid=<?php echo $nid; ?>" method="post">
                <hr style="color:#000000; height:1px"><br /><strong> Post een reactie</strong><br><img src="images/icons/bold.gif"  alt="Dikgedrukt" onclick="javascript:addSmilie('[b]je dikgedrukte tekst[/b]')" />
                                  <img src="images/icons/italics.gif" alt="Schuingedrukt" onclick="javascript:addSmilie('[i]je schuingedrukte tekst[/i]')" />
                                  <img src="images/icons/underline.gif" alt="Onderstreept" onclick="javascript:addSmilie('[u]je onderstreepte tekst[/u]')" />
                                  <img src="images/icons/strikethrough.gif" alt="Doorstreept" onclick="javascript:addSmilie('[s]je onderstreepte tekst[/s]')" />
                                  <img src="images/icons/justify_center.gif" alt="Tekst in het midden" onclick="javascript:addSmilie('[c]je tekst in het midden[/c]')" />
                                  <img src="images/icons/copy_on.gif" alt="QUOTE" onclick="javascript:addSmilie('[quote]<?php echo wordwrap(stripslashes(nl2br(addSmiley(htmlspecialchars($row['bericht'])))),150,"\n",1); ?>[/quote]')" /><br />
                <textarea cols="30" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; border:1px solid #000000; background:url(images/stripes.png); width:429; height:100;" name="bericht" rows="8"></textarea><br>
                <input style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; border:1px solid #000000;" type="submit" name="submit" value="Reageren">
             <br /><?php echo Smileys(); ?></form>

			<?php
		}else{
			echo "<strong>Log in om een reactie te plaatsen.</strong>";
		}
	}else{
		echo "Deze blog staat momenteel uit.<br>";
	}
}else{
	echo "Je heb geen ID opgegeven.<br><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}

?>