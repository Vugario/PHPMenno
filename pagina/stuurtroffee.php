<?php
$goud = GOUD;
$zilver = ZILVER;
$brons = BRONS;
$select_data = mysql_query("SELECT * FROM leden WHERE member_id = '".mysql_real_escape_string($_SESSION['id'])."'");
$get_userdata = mysql_fetch_assoc($select_data);
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
if(isset($_POST['submit'])) {
if($_POST['bericht'] == ''){
			echo'<font color="red"><b>Je hebt geen bericht ingevuld</b></font><br>Je wordt doorgestuurd';
			echo "<meta http-equiv='refresh' content='2;URL=index.php?p=stuurtroffee' />";
}else
if($_POST['troffee'] == goud && $get_userdata['muntjes'] <$goud) {
echo'<font color="red"><b>Je hebt teweinig muntjes voor de goude troffee</b></font><br>Je wordt doorgestuurd';
echo "<meta http-equiv='refresh' content='2;URL=index.php?p=stuurtroffee' />";
}else
if($_POST['troffee'] == zilver && $get_userdata['muntjes'] <$zilver) {
echo'<font color="red"><b>Je hebt teweinig muntjes voor de zilvere troffee</b></font><br>Je wordt doorgestuurd';
echo "<meta http-equiv='refresh' content='2;URL=index.php?p=stuurtroffee' />";
}else
if($_POST['troffee'] == brons && $get_userdata['muntjes'] <$brons) {
echo'<font color="red"><b>Je hebt teweinig muntjes voor de bronze troffee</b></font><br>Je wordt doorgestuurd';
echo "<meta http-equiv='refresh' content='2;URL=index.php?p=stuurtroffee' />";
		}else{
	$bericht = mysql_real_escape_string(htmlspecialchars($_POST['bericht']));
	$naar = mysql_real_escape_string(htmlspecialchars($_POST['naar']));
	$troffee = mysql_real_escape_string(htmlspecialchars($_POST['troffee']));
if($_POST['troffee'] == brons) {
mysql_query("INSERT INTO cadeau (van,naar,bericht,troffee) VALUES ('".$get_userdata['gebruikersnaam']."','".$naar."','".$bericht."','".$troffee."')")or die (mysql_error());
mysql_query("UPDATE leden SET muntjes= muntjes - ".$brons." WHERE gebruikersnaam='".$get_userdata['gebruikersnaam']."'");
		echo "Je cadeau is verstuurt";
		echo "<meta http-equiv='refresh' content='2;URL=index.php?p=stuurtroffee' />";
}elseif($_POST['troffee'] == zilver) {
mysql_query("INSERT INTO cadeau (van,naar,bericht,troffee) VALUES ('".$get_userdata['gebruikersnaam']."','".$naar."','".$bericht."','".$troffee."')")or die (mysql_error());
mysql_query("UPDATE leden SET muntjes= muntjes - ".$zilver." WHERE gebruikersnaam='".$get_userdata['gebruikersnaam']."'");
		echo "Je cadeau is verstuurt";
		echo "<meta http-equiv='refresh' content='2;URL=index.php?p=stuurtroffee' />";
}elseif($_POST['troffee'] == goud) {
mysql_query("INSERT INTO cadeau (van,naar,bericht,troffee) VALUES ('".$get_userdata['gebruikersnaam']."','".$naar."','".$bericht."','".$troffee."')")or die (mysql_error());
mysql_query("UPDATE leden SET muntjes= muntjes - ".$goud." WHERE gebruikersnaam='".$get_userdata['gebruikersnaam']."'");
		echo "Je cadeau is verstuurt";
		echo "<meta http-equiv='refresh' content='2;URL=index.php?p=stuurtroffee' />";
		}}
}else{
	?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=stuurtroffee" method="post">
		<table>
		<tr>
				<td>Naar:<br>
<?php
                $sql = mysql_query("SELECT * FROM leden ORDER BY gebruikersnaam ASC");
                echo'<select name="naar">';
                while($user = mysql_fetch_assoc($sql)){
                    echo'<option value="'.$user['gebruikersnaam'].'">'.htmlspecialchars($user['gebruikersnaam']).'</option>';
                }
                echo'</select>';
            ?></td>
			</tr>
			<tr>
				<td>Bericht:<br>
				<textarea rows="3" name="bericht" cols="26"></textarea></td>
			</tr>
			<tr>
				<td>Welke troffee<br>
				<input type="radio" value="goud" name="troffee" checked><img border="0" src="images/goud.gif"> <?php echo $goud; ?> muntjes<br>
				<input type="radio" value="zilver" name="troffee"><img border="0" src="images/zilver.gif"> <?php echo $zilver; ?> muntjes<br>
				<input type="radio" value="brons" name="troffee"><img border="0" src="images/brons.gif"> <?php echo $brons; ?> muntjes</td>
			</tr>
			<tr>
				<th><input type="submit" name="submit" value="Versturen"></th>
			</tr>
		</table>
	</form>
	<?php
}
?>