<?php

if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    if(isset($_POST['submit']) && !empty($_POST['muntjes']) && !empty($_POST['member_id']) && !empty($_POST['bericht']) && is_numeric($_POST['muntjes']) && is_numeric($_POST['member_id']) && $_POST['muntjes'] >= 0) {
        $muntjes = mysql_real_escape_string(substr(round($_POST['muntjes'],0),0,30));
        $member_id = mysql_real_escape_string($_POST['member_id']);
        $bericht = mysql_real_escape_string(substr(htmlspecialchars($_POST['bericht']),0,255));
        
        $sql = mysql_query("SELECT muntjes FROM leden WHERE member_id='".$_SESSION['id']."'");
        $row = mysql_fetch_assoc($sql);
        if($row['muntjes'] - $muntjes < 0) {
            echo "Je hebt niet genoeg muntjes.";
        }else{
        
            mysql_query("UPDATE leden SET muntjes=muntjes-".$muntjes." WHERE member_id='".$_SESSION['id']."'");
            
            mysql_query("UPDATE leden SET muntjes=muntjes+".$muntjes." WHERE member_id='".$member_id."'");
            
            mysql_query("INSERT INTO overschrijvingen (muntjes,naar_id,van_id,datum,bericht)
                        VALUES ('".$muntjes."','".$member_id."','".$_SESSION['id']."',NOW(),'".$bericht."')");
            if(mysql_error() == "") {
                echo "Het is succesvol overgeschreven, Wil je nog iets overschrijven?<br /><a href=\"?p=overschrijven\">Nog een keer overschrijven</a>";
            }else{
                echo "Er is iets mis gegaan, Probeer het opnieuw.";
            }
        }
    }else{
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=overschrijven" method="POST">
        <strong>Overschrijven</strong><br>
        Naar wie<br>
        <select name="member_id">
        <?php
        $sql = mysql_query("SELECT gebruikersnaam,member_id FROM leden ORDER BY gebruikersnaam ASC");
        while($row = mysql_fetch_assoc($sql)) {
            echo "<option value=\"".$row['member_id']."\">".$row['gebruikersnaam']."</option>";
        }
        ?>
        </select><br>
        <br>
        Bedrag<br>
        <input type="text" width="40" style="width: 40px;" name="muntjes"><br>
        <br>
        Bericht<br>
        <input type="text" name="bericht"><br>
        <br>
        <input type="submit" name="submit" value="Overschrijven">
        <br>
        </form><br><br><br>
        <?php
        echo "<strong><u>Jou laatste 10 overschrijvingen</u></strong>";
        echo "<br><br>
        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>#</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Naar</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Bedrag</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Datum</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Bericht</strong></td>
            </tr>";
        $sql = mysql_query("SELECT * FROM overschrijvingen WHERE van_id='".$_SESSION['id']."' ORDER BY datum DESC LIMIT 10");
        $i = 1;
        while($row = mysql_fetch_assoc($sql)) {
            $sql_naam = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['naar_id']."'");
            $row_naam = mysql_fetch_assoc($sql_naam);
            echo "
            <tr>
                <td>".$i."</td>
                <td>".$row_naam['gebruikersnaam']."</td>
                <td>".$row['muntjes']."</td>
                <td>".$row['datum']."</td>
                <td>".$row['bericht']."</td>
            </tr>";
            $i++;
        }
        
        echo "</table>";
        if(mysql_num_rows($sql) == 0) {
            echo "Er zijn geen overschrijven van jou<br><br>";
        }
        echo "<strong><u>laatste 10 overschrijvingen naar jou</u></strong>";
        echo "<br><br>
        <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
            <tr>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>#</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Van</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Bedrag</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Datum</strong></td>
                <td style=\"border-bottom: 1px solid #000000;\"><strong>Bericht</strong></td>
            </tr>";
        $sql = mysql_query("SELECT * FROM overschrijvingen WHERE naar_id='".$_SESSION['id']."' ORDER BY datum DESC LIMIT 10");
        $i = 1;
        while($row = mysql_fetch_assoc($sql)) {
            $sql_naam = mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['van_id']."'");
            $row_naam = mysql_fetch_assoc($sql_naam);
            echo "
            <tr>
                <td>".$i."</td>
                <td>".$row_naam['gebruikersnaam']."</td>
                <td>".$row['muntjes']."</td>
                <td>".$row['datum']."</td>
                <td>".$row['bericht']."</td>
            </tr>";
            $i++;
        }
        echo "</table>";
        if(mysql_num_rows($sql) == 0) {
            echo "Er zijn geen overschrijven naar jou";
        }
    }
}else{
    echo "Zou je niet eerst inloggen?";
}
?>