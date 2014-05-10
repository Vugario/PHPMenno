Wat vind je van deze site?

<?php

$ip = $_SERVER['REMOTE_ADDR'];
$query = "SELECT * FROM poll_ip WHERE ip='".$ip."'";
$result = mysql_query($query) or die ("FOUT: ".mysql_error());
$aantal = mysql_num_rows($result);
if ($aantal == 0){
    echo("<form action=\"?p=pollstemmen\" method=\"post\">");
    $query = "SELECT * FROM poll_ant ORDER BY id ASC";
    $result = mysql_query($query) or die ("FOUT: ".mysql_error());
    $teller = 1;
    while ($rij = mysql_fetch_assoc($result)){
        echo("<input type=\"radio\" name=\"poll\" value=\"".$teller."\" style=\"border : 0px;\">".$rij["antwoord"]."<br>");
        $teller++;
    }
    echo("<input type=\"submit\" value=\"Stem!\"></form>");
}else{
    $query = "SELECT * FROM poll_ant ORDER BY id ASC";
    $result = mysql_query($query) or die ("FOUT: ".mysql_error());
    $aantal = mysql_num_rows($result);
    $teller = 1;
    while ($teller <= $aantal){
        $query = "SELECT * FROM poll_ant WHERE id='".$teller."' ORDER BY id ASC";
        $result = mysql_query($query) or die ("FOUT: ".mysql_error());
        $rij = mysql_fetch_assoc($result);
        echo $rij["antwoord"]."<br>";
        $query = "SELECT * FROM poll_ip";
        $result = mysql_query($query) or die ("FOUT: ".mysql_error());
        $totaal_hoeveel = mysql_num_rows($result);
        $query = "SELECT * FROM poll_ip WHERE poll_id='".$teller."'";
        $result = mysql_query($query) or die ("FOUT: ".mysql_error());
        $ant_hoeveel = mysql_num_rows($result);
        if ($ant_hoeveel != 0){
            $nummer = $totaal_hoeveel / 100;
            $nummer = $ant_hoeveel / $nummer;
        }else{
            $nummer = 0;
        }
        $procent = substr($nummer, 0, 5);
        echo("<img src=\"images/poll.gif\" border=\"0\" width=\"".$nummer."\" height=\"10\">");
        echo(" ".$procent."%<br>");
        $teller++;
    }
    $query = "SELECT * FROM poll_ip";
    $result = mysql_query($query) or die ("FOUT: ".mysql_error());
    $aantalstemmen = mysql_num_rows($result);
    echo("<br>Stemmen: ".$aantalstemmen."<br>");
}
?>