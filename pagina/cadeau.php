<?php
if(isset($_SESSION['id'])){
if($_GET['act']=="bekijken") {
$rr = mysql_query("SELECT * FROM cadeau WHERE geopend='Ja' AND id='".$_GET['id']."'");
if(mysql_num_rows($rr) != 1) {
echo'De troffee dat je wilde bekijken is nog niet opengemaakt of deze bestaat niet';
}else{
$row = mysql_fetch_assoc($rr);
$naam = mysql_real_escape_string(htmlspecialchars($row['van']));
$lid = mysql_query("SELECT * FROM leden WHERE gebruikersnaam = '".$naam."'");
$gebruiker = mysql_fetch_assoc($lid);
if($row['troffee']=="brons") {
?>
<html>
<center><table width="294" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="294" height="22" colspan="3" background="images/brons_01.gif"></td>
	</tr>
	<tr>
		<td width="5" background="images/brons_02.gif" rowspan="3"></td>
		<td width="285" bgcolor="#B87834" valign="top"><?php echo htmlspecialchars($row['bericht']);?></td>
		<td width="4" background="images/brons_04.gif" rowspan="3"></td>
	</tr>
	<tr>
		<td width="285" bgcolor="#B87834" align="center" height="8"><img border="0" src="images/brons_06.gif" width="252" height="4"></td>
	</tr>
	<tr>
		<td width="285" bgcolor="#B87834" valign="top">Gekregen van: <a href="?p=profiel&mid=<?php echo $gebruiker['member_id'];?>"><?php echo htmlspecialchars($row['van']);?></a></td>
	</tr>
	<tr>
		<td width="294" height="14" colspan="3" background="images/brons_05.gif"></td>
	</tr>
</table>
</center>
<?php
}elseif($row['troffee']=="zilver") {
?>
<center><table width="294" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="294" height="22" colspan="3" background="images/zilver_01.gif"></td>
	</tr>
	<tr>
		<td width="5" background="images/zilver_02.gif" rowspan="3"></td>
		<td width="285" bgcolor="#C9BDCC" valign="top"><?php echo htmlspecialchars($row['bericht']);?></td>
		<td width="4" background="images/zilver_04.gif" rowspan="3"></td>
	</tr>
	<tr>
		<td width="285" bgcolor="#C9BDCC" align="center" height="8"><img border="0" src="images/zilver_06.gif" width="252" height="4"></td>
	</tr>
	<tr>
		<td width="285" bgcolor="#C9BDCC" valign="top">Gekregen van: <a href="?p=profiel&mid=<?php echo $gebruiker['member_id'];?>"><?php echo htmlspecialchars($row['van']);?></a></td>
	</tr>
	<tr>
		<td width="294" height="14" colspan="3" background="images/zilver_05.gif"></td>
	</tr>
</table>
</center>
<?php
}elseif($row['troffee']=="goud") {
?>
<center><table width="294" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="294" height="22" colspan="3" background="images/goud_01.gif"></td>
	</tr>
	<tr>
		<td width="5" background="images/goud_02.gif" rowspan="3"></td>
		<td width="285" bgcolor="#ECC547" valign="top"><?php echo htmlspecialchars($row['bericht']);?></td>
		<td width="4" background="images/goud_04.gif" rowspan="3"></td>
	</tr>
	<tr>
		<td width="285" bgcolor="#ECC547" align="center" height="8"><img border="0" src="images/goud_06.gif" width="252" height="4"></td>
	</tr>
	<tr>
		<td width="285" bgcolor="#ECC547" valign="top">Gekregen van: <a href="?p=profiel&mid=<?php echo $gebruiker['member_id'];?>"><?php echo htmlspecialchars($row['van']);?></a></td>
	</tr>
	<tr>
		<td width="294" height="14" colspan="3" background="images/goud_05.gif"></td>
	</tr>
</table></center>
<?php
}}
}else{
?>
<table width='500'><tr>
      <td><span style="font-weight: bold;">Van</span></td>
      <td><span style="font-weight: bold;">Naar</span></td>
      <td><span style="font-weight: bold;">Troffee</span></td>
      <td><span style="font-weight: bold;"> X </span></td>
</tr>
<?php
$query = mysql_query("SELECT * FROM cadeau WHERE geopend='Ja'") or die (mysql_error());
if(mysql_num_rows($query) == 0){
echo '<b><font color="red">Er zijn nog geen cadeaus geopend</font></f>';
}else
while($rij = mysql_fetch_array($query)){
$naam = mysql_real_escape_string(htmlspecialchars($rij['van']));
$lid = mysql_query("SELECT * FROM leden WHERE gebruikersnaam = '".$naam."'");
$gebruiker = mysql_fetch_assoc($lid);
$naam2 = mysql_real_escape_string(htmlspecialchars($rij['naar']));
$lid2 = mysql_query("SELECT * FROM leden WHERE gebruikersnaam = '".$naam2."'");
$gebruiker2 = mysql_fetch_assoc($lid2);
?>
<tr>
<td><a href="?p=profiel&mid=<?php echo $gebruiker['member_id'];?>"><?php echo htmlspecialchars($rij['van']);?></a></td>
<td><a href="?p=profiel&mid=<?php echo $gebruiker2['member_id'];?>"><?php echo htmlspecialchars($rij['naar']);?></a></td>
<td><img src="images/<?php echo $rij['troffee']; ?>.gif" /></td>
<td><a href="?p=cadeau&act=bekijken&id=<?php echo htmlspecialchars($rij['id']);?>">Troffee bekijken</a></td></tr>
<?php
	}
?><?php
}
?><?php
}else{
	echo "Je bent niet ingelogd.";
}
?>