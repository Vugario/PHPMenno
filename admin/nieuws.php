<?php

if(isset($_SESSION['admin']) || isset($_SESSION['nieuwsreporter'])) {
	?>
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
        theme_advanced_buttons1_add : "fontsizeselect",
        theme_advanced_buttons2_add : "fontselect,separator,insertdate,inserttime",
        theme_advanced_buttons3_add : "preview,separator,forecolor,backcolor",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_path_location : "bottom",
        content_css : "example_data/example_word.css",
        plugin_insertdate_dateFormat : "%Y-%m-%d",
        plugin_insertdate_timeFormat : "%H:%M:%S",
        extended_valid_elements : "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
        external_link_list_url : "example_data/example_link_list.js",
        external_image_list_url : "example_data/example_image_list.js",
        flash_external_list_url : "example_data/example_flash_list.js",
        file_browser_callback : "mcFileManager.filebrowserCallBack",
        paste_auto_cleanup_on_paste : true,
        paste_convert_headers_to_strong : true
    });
</script>
<?php

if(isset($_GET['a'])) {
	if($_GET['a'] == "nieuws" && isset($_GET['s'])) {
		if($_GET['s'] == "toevoegen") {
			if(isset($_POST['toevoegen'])) {
			
				echo $nieuws->nieuwsToevoegen($_POST['titel'],$_POST['bericht'],$_POST['actief']);
				
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_nieuws&a=nieuws&s=toevoegen" method="post">
					<table width="300">
						<tr>
							<td>Titel</td>
							<td><input type="text" name="titel" maxlength="25" /></td>
						</tr>
						<tr>
							<td colspan="2">Bericht</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="bericht" name="bericht" style="background:#FFFFFF;" cols="60" rows="20"></textarea></td>
						</tr>
						<tr>
							<td>Aan of uit?</td>
							<td><input type="radio" checked="checked" name="actief" value="aan" /> Aan <input type="radio" name="actief" value="uit" /> Uit </td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" value="Toevoegen" name="toevoegen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}
		}elseif($_GET['s'] == "wijzigen") {
			if(isset($_POST['wijzigen'])) {
				echo $nieuws->nieuwsWijzigen($_POST['titel'],$_POST['bericht'],$_POST['actief'],$_POST['nieuws_id']);
			}elseif(isset($_GET['nid'])) {
				$nid = mysql_real_escape_string(substr($_GET['nid'],0,30));
				$sql = mysql_query("SELECT * FROM  nieuws_berichten WHERE nieuws_id='".$nid."'");
				$row = mysql_fetch_assoc($sql);
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_nieuws&a=nieuws&s=wijzigen" method="post">
					<input type="hidden" name="nieuws_id" value="<?php echo $_GET['nid']; ?>" />
					<table width="300">
						<tr>
							<td>Titel</td>
							<td><input type="text" name="titel" <?php echo "value=\"".stripslashes($row['titel'])."\""; ?> maxlength="25" /></td>
						</tr>
						<tr>
							<td colspan="2">Bericht</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="bericht" name="bericht" style="background:#FFFFFF;" cols="30" rows="20"><?php echo stripslashes($row['bericht']); ?></textarea></td>
						</tr>
						<tr>
							<td>Aan of uit?</td>
							<td><input type="radio" <?php if($row['actief'] == "aan") echo "checked=\"checked\""; ?> name="actief" value="aan" /> Aan <input type="radio" <?php if($row['actief'] == "uit") echo "checked=\"checked\""; ?> name="actief" value="uit" /> Uit </td>
						</tr>
						<tr>
							<th colspan="2"><input type="submit" value="Wijzigen" name="wijzigen" /></th>
						</tr>
					</table>
				</form>
				<?php
			}else{
				$sql = mysql_query("SELECT * FROM nieuws_berichten");
				echo "<table width=\"700\">
						<tr>
							<td>Titel</td>
							<td>Bericht</td>
							<td>Actief</td>
							<td>Wijzigen/verwijderen</td>
						</tr>";
				while($row = mysql_fetch_assoc($sql)) {
					echo "<tr>
							<td>".$row['titel']."</td>
							<td>".substr($row['bericht'],0,30)."</td>
							<td>".$row['actief']."</td>
							<td><a href='?p=admin_nieuws&a=nieuws&s=wijzigen&nid=".$row['nieuws_id']."'>Wijzigen</a><br />
								<a href='?p=admin_nieuws&a=nieuws&s=verwijderen&nid=".$row['nieuws_id']."'>Verwijderen</a>
							</td>
						</tr>";
				}
				echo "</table>";
			}
		}elseif($_GET['s'] == "verwijderen") {
			if(isset($_POST['verwijderen'])) {
				echo $nieuws->nieuwsVerwijderen($_POST['nieuws_id']);
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=admin_nieuws&a=nieuws&s=verwijderen" method="post">
					<input type="hidden" value="<?php echo $_GET['nid'] ?>" name="nieuws_id" />
					<input type="submit" value="Verwijderen" name="verwijderen" />
				</form>
				<?php
			}
		}
	}
}else{
	echo "&raquo; <a href=\"?p=admin_nieuws&a=nieuws&s=toevoegen\">Nieuws Toevoegen</a><br />
		&raquo; <a href=\"?p=admin_nieuws&a=nieuws&s=wijzigen\">Nieuws Wijzigen/Verwijderen</a><br />";
}
}else{
	echo "Zou wel leuk zijn als je admin was.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>