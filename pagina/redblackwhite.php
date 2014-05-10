<?php

if(isset($_SESSION['id'])) {

if(isset($_POST['submit']) && !empty($_POST['inzet']) && is_numeric($_POST['inzet']) && !empty($_POST['antwoord'])) {
$inzet = mysql_real_escape_string($_POST['inzet']);

$sql = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
$row = mysql_fetch_assoc($sql);
if($row['muntjes'] - $inzet < 0) {
echo "Je hebt hier helemaal niet genoeg muntjes voor.";
}elseif($inzet < 10) {
echo "Je moet wel minstens 10 muntjes inzetten!.<br>";
}else{
mysql_query("UPDATE leden SET muntjes=muntjes-".$inzet." WHERE member_id='".$_SESSION['id']."'");
mysql_query("UPDATE leden SET muntjes=muntjes-".$inzet." WHERE member_id='".$_SESSION['id']."'");
$rand = rand(1,2);
if($rand == 1) {
$gantwoord = "rood";
}elseif($rand == 1) {
$gantwoord = "zwart";
}else{
$gantwoord = "wit";
}
echo "Het is ".$gantwoord." geworden, jij hebt gegokt op <strong>".$_POST['antwoord']."</strong><br><br>";
if($_POST['antwoord'] == $gantwoord) {
echo "Je hebt gewonnen, je hebt <strong>".$inzet."+".$inzet."</strong> muntjes verdiend.<br><a href='java script:history.go(-1)'>Ga terug</a>";
mysql_query("UPDATE leden SET muntjes= muntjes+".$inzet." WHERE member_id='".$_SESSION['id']."'");
mysql_query("UPDATE leden SET muntjes= muntjes+".$inzet." WHERE member_id='".$_SESSION['id']."'");
mysql_query("UPDATE leden SET muntjes= muntjes+".$inzet." WHERE member_id='".$_SESSION['id']."'");
mysql_query("UPDATE leden SET muntjes= muntjes+".$inzet." WHERE member_id='".$_SESSION['id']."'");
}else{
echo "Nee, hoe kan dat nou, het antwoord is niet goed.<br>Probeer het nog een keer.<br> <a href='java script:history.go(-1)'>Ga terug</a>";
}
}
}else{
?>
<font face="Verdana" size=1">Bij het 3x kans spel krijg je meer EN minder kans op veel muntjes. Het werkt simpel, je zet iets in (bijvoorbeeld 10) en kiest de kleur wit. Als je wint krijg je geen 10 maar 20 muntjes, maar als je verliest... dan gaan er ook 20 muntjes af. Het dubbele dus!</font>
<form action="<?php $_SERVER['PHP_SELF'] ?>?p=3xkans" method="POST">
<table>
<tr>
<td>Inzet</td>
<td><input type="text" name="inzet" maxlength="10"></td>
</tr>
<tr>
<td>Antwoord</td>
<td>
<select name="antwoord">
<option value="zwart">Zwart</option>
<option value="rood">Rood</option>
<option value="wit">Wit</option>
</select>
</td>
</tr>
<tr>
<th colspan="2"><input type="submit" name="submit" value="Gokken"></th>
</tr>
</table>
</form>
<?php
}
}
?>