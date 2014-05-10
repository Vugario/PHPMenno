<center><?php

$sql_laatste_5_nieuwsberichten = mysql_query("SELECT level,gebruikersnaam,member_id FROM leden WHERE level = 6");
echo "<strong>Administrators:</strong><br />";
while($row = mysql_fetch_assoc($sql_laatste_5_nieuwsberichten)) {
$text[1]="667";
$text[2]="1";
$text[3]="2";
$text[4]="3";
$text[5]="5";
$text[6]="6";
$text[7]="9";
$text[8]="667";
$text[9]="1";
$text[10]="2";
$text[11] ="3";
$text[12]="5";
$text[13]="6";
$text[14]="9";
$random = rand(1, count($text));




$ttext[1]="srp";
$ttext[2]="sml";
$ttext[3]="sad";
$ttext[4]="eyb";
$ttext[5]="nrm";
$ttext[6]="agr";
$ttext[7]="spk";
$ttext[8]="srp";
$ttext[9]="sml";
$ttext[10]="sad";
$ttext[11]="eyb";
$ttext[12]="nrm";
$ttext[13]="agr";
$ttext[14]="spk";
$rrandom = rand(1, count($ttext));



$tttext[1]="wav";
$tttext[2]="wlk";
$tttext[3]="nrm";
$tttext[4]="nrm";
$tttext[5]="wlk";
$tttext[6]="wlk,wav";
$tttext[7]="wav";
$tttext[8]="wlk";
$tttext[9]="wav";
$tttext[10]="nrm";
$tttext[11]="wlk,wav";
$rrrandom = rand(1, count($tttext));
	echo "<a href='?p=profiel&mid=".$row['member_id']."'><img src='http://www.habbo.nl/habbo-imaging/avatarimage?user=".$row['gebruikersnaam']."&action=".$tttext[$rrrandom].",crr=".$text[$random]."&direction=3&head_direction=3&gesture=".$ttext[$rrandom]."' border='0' alt='".$row['gebruikersnaam']."'></a> ";
}

?></center>
<br>
<center>
<?php

$sql_laatste_5_nieuwsberichten = mysql_query("SELECT level,gebruikersnaam,member_id FROM leden WHERE level = 2");
echo "<strong>Nieuwsreporters:</strong><br />";
while($row = mysql_fetch_assoc($sql_laatste_5_nieuwsberichten)) {
$text[1]="667";
$text[2]="1";
$text[3]="2";
$text[4]="3";
$text[5]="5";
$text[6]="6";
$text[7]="9";
$text[8]="667";
$text[9]="1";
$text[10]="2";
$text[11] ="3";
$text[12]="5";
$text[13]="6";
$text[14]="9";
$random = rand(1, count($text));





$ttext[1]="srp";
$ttext[2]="sml";
$ttext[3]="sad";
$ttext[4]="eyb";
$ttext[5]="nrm";
$ttext[6]="agr";
$ttext[7]="spk";
$ttext[8]="srp";
$ttext[9]="sml";
$ttext[10]="sad";
$ttext[11]="eyb";
$ttext[12]="nrm";
$ttext[13]="agr";
$ttext[14]="spk";
$rrandom = rand(1, count($ttext));



$tttext[1]="wav";
$tttext[2]="wlk";
$tttext[3]="nrm";
$tttext[4]="nrm";
$tttext[5]="wlk";
$tttext[6]="wlk,wav";
$tttext[7]="wav";
$tttext[8]="wlk";
$tttext[9]="wav";
$tttext[10]="nrm";
$tttext[11]="wlk,wav";
$rrrandom = rand(1, count($tttext));
	echo "<a href='?p=profiel&mid=".$row['member_id']."'><img src='http://www.habbo.nl/habbo-imaging/avatarimage?user=".$row['gebruikersnaam']."&action=".$tttext[$rrrandom].",crr=".$text[$random]."&direction=3&head_direction=3&gesture=".$ttext[$rrandom]."' border='0' alt='".$row['gebruikersnaam']."'></a> ";
}

?></center>