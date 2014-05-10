<?php
if(!isset($_SESSION['id'])) {
    echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
    die();
}
?><?php

if(isset($_GET['vid'])) {
    if(!is_numeric($_GET['vid'])) {
        echo "Vrienden id is meer dan alleen nummers.<br />Dit is niet toegestaan.<br /><a href='java script:history.go(-1)'>Ga terug</a>";
    }elseif($_GET['vid'] == $_SESSION['id']) {
        echo "Je kan niet jezelf als vriend toevoegen";
    }else{
        $vid = mysql_real_escape_string($_GET['vid']);
        $check_bestaan_vriend = mysql_query("SELECT * FROM vrienden WHERE member_id='".$_SESSION['id']."' AND vriend_id='".$vid."'");
        $check_bestaan_lid = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$vid."'");
        if(mysql_num_rows($check_bestaan_vriend) >= 1) {
            echo "Deze gebruiker is al jou vriend.<br />Het kan zijn dat hij jou nog moet accepteren als vriend.<br /><a href='java script:history.go(-1)'>Ga terug</a>";
        }elseif(mysql_num_rows($check_bestaan_lid) < 1) {
            echo "Deze gebruiker bestaat helemaal niet, Er is iets foutgegaan.<br /><a href='java script:history.go(-1)'>Ga terug</a>";
        }elseif(mysql_num_rows($check_bestaan_lid) >= 1) {
            $row_bestaan_lid = mysql_fetch_assoc($check_bestaan_lid);

                if(isset($_GET['a'])) {
                    if($_GET['a'] == "verwijderen") {
                        $check_van_jou = mysql_query("SELECT * FROM vrienden WHERE member_id='".$_SESSION['id']."' AND vriend_id='".$_GET['vid']."'");
                        if(mysql_num_rows($check_van_jou) != 1) {
                            echo "Deze vriend is niet van jou, Je hebt geprobeert het systeem te kraken.<br /><a href='java script:history.go(-1)'>Ga terug</a>";
                        }else{
                            $datum = date("d-m-y H:i:s");
                            mysql_query("DELETE FROM vrienden WHERE member_id='".$_SESSION['id']."' AND vriend_id='".$_GET['vid']."'");
                            // er is een bericht gestuurd naar de vriend die is verwijderd
                            echo "De vriend is verwijderd uit je vriendenlijst.<br /><a href='java script:history.go(-1)'>Ga terug</a>";
                        }
                    }elseif($_GET['a'] == "accepteren") {
                        $check_van_jou = mysql_query("SELECT * FROM vrienden WHERE member_id='".$_SESSION['id']."' AND vriend_id='".$_GET['vid']."'");
                        if(mysql_num_rows($check_van_jou) != 1) {
                            echo "Deze vriend is niet van jou";
                        }else{
                            mysql_query("UPDATE vrienden SET actief='actief' WHERE vriend_id='".$_GET['vid']."' AND member_id='".$_SESSION['id']."'");
                            echo "De vriend is succesvol geaccepteerd.<br />Je zal hem zometeen zien in je vriendenlijst.<br /><a href='java script:history.go(-1)'>Ga terug</a>";
                        }
                    }
                }else{
                    mysql_query("INSERT INTO vrienden (member_id,vriend_id,actief) VALUES ('".$_SESSION['id']."','".$_GET['vid']."','dood')");
                    mysql_query("INSERT INTO vrienden (vriend_id,member_id,actief) VALUES ('".$_SESSION['id']."','".$_GET['vid']."','dood')");
                    echo "De gebruiker is toegevoegd aan jou vrienden.<br />Zodra hij heeft geaccepteerd heb jij hem ook als vriend";
                }
            
        }
    }
}else{
    echo "Er is geen vrienden id opgegeven";
}
?>