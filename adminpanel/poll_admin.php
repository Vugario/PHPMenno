<?php

if(isset($_SESSION['admin'])) {
    echo "<a href=\"?p=poll_admin&a=reset\">Reset IP's</a><br><br>";
    if(isset($_GET['a']) && $_GET['a'] == "wijzigen") {
        if(isset($_POST['submit']) && !empty($_POST['antwoord']) && !empty($_POST['id'])) {
            mysql_query("UPDATE poll_ant SET antwoord = '".mysql_real_escape_string(htmlspecialchars($_POST['antwoord']))."' WHERE id='".mysql_real_escape_string($_POST['id'])."'");
            if(mysql_error() == "") {
                echo "Hij is gewijzigd.<br /><a href=\"?p=poll_admin\">Terug naar admin</a>";
            }else{
                echo "Er is iets fout gegaan.";
            }
        }else{
            if(isset($_GET['id'])) {
                $sql = mysql_query("SELECT * FROM poll_ant WHERE id='".mysql_real_escape_string($_GET['id'])."'");
                $row = mysql_fetch_assoc($sql);
                ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>?p=poll_admin&a=wijzigen" method="POST">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                Antwoord:<br />
                <input type="text" value="<?php echo $row['antwoord']; ?>" name="antwoord" maxlength="255" /><br />
                <input type="submit" name="submit" value="Wijzigen!" />
                </form>
                <?php
            }
        }
    }elseif(isset($_GET['a']) && $_GET['a'] == "reset") {
        if(isset($_POST['submit'])) {
            mysql_query("DELETE FROM poll_ip");
            if(mysql_error() == "") {
                echo "Alles is nu gewist, Iedereen kan weer stemmen.<br /><a href=\"?p=poll_admin\">Terug naar admin</a>";
            }else{
                echo "Er is iets fout gegaan.";
            }
        }else{
            ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>?p=poll_admin&a=reset" method="POST">
            Weet je zeker dat je alle ip's wilt wissen?<br>
            Dan kan iedereen weer opnieuw stemmen.<br>
            <input type="submit" name="submit" value="wissen!" />
            </form>
            <?php
        }
    }else{
        $sql = mysql_query("SELECT * FROM poll_ant");
        echo "<table width=\"100%\">";
        while($row = mysql_fetch_assoc($sql)) {
            echo "<tr>
                    <td><strong>".$row['antwoord']."</strong></td>
                    <td><a href=\"?p=poll_admin&a=verwijderen&id=".$row['id']."\">Verwijderen</a>
                    </td>
                </tr>";
        }
        echo "</table>";
    }
}else{
    echo "Je bent geen admin";
}
?>