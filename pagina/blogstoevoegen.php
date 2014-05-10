<?php

if(isset($_SESSION['id'])) {
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
	if($_GET['a'] == "blog" && isset($_GET['s'])) {
		if($_GET['s'] == "toevoegen") {
			if(isset($_POST['toevoegen'])) {
			
				echo $blogs->blogsToevoegen($_POST['titel'],$_POST['bericht'],$_POST['actief']);
				
			}else{
				?>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=blogs&a=blog&s=toevoegen" method="post">
					<table width="300">
						<tr>
							<td>Titel</td>
							<td><input type="text" name="titel" maxlength="75" /></td>
						</tr>
						<tr>
							<td colspan="2">Kort bericht (soort inleiding)</td>
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
		}
	}
}else{
	echo "&raquo; <a href=\"?p=blogs&a=blog&s=toevoegen\">Blog(s) Toevoegen</a><br />";
}
}else{
	echo "Je moet wel ingelogd zijn.<br /><a href='#' onclick='history.go(-1)'>Ga terug</a>";
}
?>