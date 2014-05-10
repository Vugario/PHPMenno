<?php
if(isset($_SESSION['admin']) || isset($_SESSION['moderator'])) {
function randomwachtwoord($length)
{
    $tekens = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $key  = $tekens{rand(0,60)};
    for($i=1;$i<$length;$i++)
    {
        $key .= $tekens{rand(0,60)};
    }
    return $key;
}

if (isset($_POST['submit']) && !empty($_POST['nieuwsbrief']))
 {
 
 	$gebruikersnaam = mysql_real_escape_string(substr($_POST['gebruikersnaam'],0,255));
 	$nieuwsbrief = mysql_real_escape_string(substr($_POST['nieuwsbrief'],0,255));
	$email = mysql_real_escape_string(substr($_POST['email'],0,255));
	$geboortedatum = mysql_real_escape_string(substr($_POST['geboortedatum'],0,255));
	$wachtwoord = randomwachtwoord(8); 
	$wachtwoordmd5 = md5($wachtwoord);
	
	$sql2 = "SELECT gebruikersnaam,email,muntjes FROM leden WHERE member_id='1'";
	$res2 = mysql_query($sql2)or die(mysql_error());
	if(mysql_num_rows($res2) < 1) {
		echo "Sorry,<br><br>Er is iets fout gegaan. De nieuwsbrief is NIET verzonden.";
		}else{
			while($row = mysql_fetch_assoc($res2)) {
			$headers = "Content-type: text/html";
			mail($row['email'],"Nieuwsbrief - ".SITENAAM,"
			".$nieuwsbrief."<br><br><i>Let op: stuur geen reactie op deze mail. Er word niet op gereageerd.",$headers);  // stuur de email
			echo "De nieuwsbrief is verstuurd."; // leuk uitlegje
		}
	}
	}else{
	?>
	<script language="JavaScript" type="text/javascript" src="wysiwyg/wysiwyg.js"></script>
	<form method="post">
		<table width="350">
			
			<tr>
				<td><font face="Verdana" size="1">Nieuwsbrief</font></td>
				<td><textarea width="321" id="nieuwsbrief" name="nieuwsbrief" style="background:#FFFFFF;" cols="60" rows="20"><?php echo $_POST['nieuwsbrief']; ?></textarea></td>
				<?php if(isset($_POST['submit']) && empty($_POST['nieuwsbrief'])) { echo "<br> Vul iets in."; } ?>
					</td>
					</tr>

			<tr>
				<th colspan="2"><input type="submit" name="submit" value="Verstuur"></th>
			</tr>

		</table>
					
	</form>
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
        theme_advanced_buttons1_add_before : "save,newdocument,separator",
        theme_advanced_buttons1_add : "fontselect,fontsizeselect",
        theme_advanced_buttons2_add : "seperator,insertdate,inserttime,preview,separator,forecolor,backcolor",
        theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
        theme_advanced_buttons3_add_before : "tablecontrols,separator",
        theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,spellchecker,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking",
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
				<script language="javascript">
				generate_wysiwyg('nieuwsbrief');
				</script>
	
	<?php
		}
	};
	?>