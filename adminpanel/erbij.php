<?php

if(!isset($_SESSION['admin'])) {
	echo "Je bent geen admin.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
	die();
}

if(isset($_POST['toevoegen'])) {
	if($_POST['som'] == "af") {
		$aantal = mysql_real_escape_string(substr($_POST['aantal'],0,10));
		$member_id = mysql_real_escape_string($_POST['member_id']);
		mysql_query("UPDATE leden SET muntjes= muntjes - ".$aantal." WHERE member_id='".$member_id."'");
		if(mysql_error() == "") {
			echo "<font color=\"green\"><b>Succesvol bijgewerkt!</b></font>";
		}else{
			echo "<font color=\"red\"><b>Niet bijgewerkt!</b></font>";
		}
	}elseif($_POST['som'] == "bij") {
		$aantal = mysql_real_escape_string(substr($_POST['aantal'],0,10));
		$member_id = mysql_real_escape_string($_POST['member_id']);
		mysql_query("UPDATE leden SET muntjes = muntjes + ".$aantal." WHERE member_id='".$member_id."'");
		if(mysql_error() == "") {
			echo "<font color=\"green\"><b>Succesvol bijgewerkt!</b></font>";
		}else{
			echo "<font color=\"red\"><b>Niet bijgewerkt!</b></font>";
		}
	}
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=admin_muntjes" method="post">
<table>
    <tr>
        <td>Naam:</td>
        <td>
            <?php
                $sql = mysql_query("SELECT * FROM leden ORDER BY gebruikersnaam ASC");
                echo'<select name="member_id">';
                while($user = mysql_fetch_assoc($sql)){
                    echo'<option value="'.$user['member_id'].'">'.htmlspecialchars($user['gebruikersnaam']).'</option>';
                }
                echo'</select>';
            ?>
        </td>
    </tr>
    <tr>
        <td>Credits</td>
        <td><select name="som"><option value="af">Eraf</option><option value="bij" selected="selected">Erbij</option></select></td>
    </tr>
    <tr>
            </select>
        </td>
    </tr>
    <tr>
        <td>Aantal:</td>
        <td><input type="text" name="aantal" value="200"></td>
    </tr>
    <tr>
        <td> </td>
        <td><input type="submit" name="toevoegen" value="Verzend"></td>
    </tr>
</table>
</form>