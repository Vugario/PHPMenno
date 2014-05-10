<?php

define('BR',"\r\n");
$paginaid         = 1;
$referentieid     = 1;

if(isset($_SESSION['admin']) && isset($_SESSION['ip']) && isset($_SESSION['id']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) {
	
	if(isset($_GET['actie']) && !empty($_GET['actie']))
	{
	?>
	<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript">
	tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			plugins : "spellchecker,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
			theme_advanced_buttons1_add_before : "save,newdocument,separator",
			theme_advanced_buttons1_add : "fontselect,fontsizeselect",
			theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
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
	<?php
		$acties = array('verhogen','verlagen','verwijderen','toevoegen','wijzigen');
		
		if(in_array($_GET['actie'],$acties))
		{
			$actie = mysql_real_escape_string($_GET['actie']);
		
			switch($actie)
			{
				case 'toevoegen':
					if(isset($_GET['volgordeid']) && !empty($_GET['volgordeid']))
					{
						if(is_numeric($_GET['volgordeid']))
						{
								$volgordeid = mysql_real_escape_string($_GET['volgordeid']);
								
								$query         = "INSERT INTO content (volgordeid, titel, content) VALUES (".$volgordeid.",'voorbeeld titel','voorbeeld content')";
								$resultaat     = mysql_query($query);
								
								if($resultaat && mysql_affected_rows() == 1)
								{
									$paginaid = mysql_insert_id();
									
									echo '<p>De pagina is succesvol toegevoegd! Hieronder kunt u hem aanpassen.</p>'.BR;
								}else{
									echo '<p>Sorry, er ging iets mis bij het toevoegen van een nieuwe pagina.</p>'.BR;
								}         
						}else{
							echo '<p>Sorry, de variabele volgordeid hoort numeriek te zijn!</p>'.BR;
						}
					}else{
						echo '<p>Sorry, ik verwacht op zijn minst iets van een volgordeid!</p>'.BR;
					}
				break;
			
				case 'wijzigen':
					if(isset($_GET['paginaid']) && !empty($_GET['paginaid']))
					{
						if(is_numeric($_GET['paginaid']))
						{
							$paginaid = mysql_real_escape_string($_GET['paginaid']);
							
							if($_SERVER['REQUEST_METHOD'] == 'POST')
							{
								if(isset($_POST['titel']) && !empty($_POST['titel']))
								{
									$titel = mysql_real_escape_string($_POST['titel']);
								}else{
									$titel = 'voorbeeld titel';
								}
								
								if(isset($_POST['content']) && !empty($_POST['content']))
								{
									$content = mysql_real_escape_string($_POST['content']);
								}else{
									$content = 'voorbeeld content';
								}
								
								$query         = "UPDATE content SET titel = '".$titel."', content = '".$content."', datum = NOW() WHERE paginaid = ".$paginaid."";
								$resultaat     = mysql_query($query);
								
								if($resultaat && mysql_affected_rows() == 1)
								{
									echo '<p>De pagina is succesvol geupdate.</p>'.BR;
								}else{
									echo '<p>Sorry, de pagina kon niet geupdate worden!</p>'.BR;
								}
							}                    
						}else{
							echo '<p>Sorry, de variabele paginaid hoort numeriek te zijn!</p>'.BR;
						}
					}else{
						echo '<p>Sorry, ik verwacht op zijn minst iets van een paginaid!</p>'.BR;
					}
				break;
			
				case 'verwijderen':
					if(isset($_GET['paginaid']) && !empty($_GET['paginaid']))
					{
						if(is_numeric($_GET['paginaid']))
						{
							$paginaid     = mysql_real_escape_string($_GET['paginaid']);
							
							$query         = "DELETE FROM content WHERE paginaid = ".$paginaid."";
							$resultaat     = mysql_query($query);
							
							if($resultaat && mysql_affected_rows() == 1)
							{
								echo '<p>Deze pagina is succesvol verwijderd!</p>'.BR;
							}else{
								echo '<p>Sorry, ik kon deze pagina niet verwijderen!</p>'.BR;
							} 
						}else{
							echo '<p>Sorry, de variabele paginaid hoort numeriek te zijn!</p>'.BR;
						}
					}else{
						echo '<p>Sorry, ik verwacht op zijn minst iets van een paginaid!</p>'.BR;
					}
				break;
				
				case 'verhogen' || 'verlagen':
					if(isset($_GET['volgordeid']) && !empty($_GET['volgordeid']))
					{
						if(is_numeric($_GET['volgordeid']))
						{
							$volgordeid = mysql_real_escape_string($_GET['volgordeid']);
				
							switch($actie)
							{
								case 'verhogen':
									$query         = "SELECT paginaid, volgordeid FROM content WHERE volgordeid <= ".$volgordeid." ORDER by volgordeid DESC LIMIT 2";
									$resultaat     = mysql_query($query);
								break;
									
								case 'verlagen':
									$query         = "SELECT paginaid, volgordeid FROM content WHERE volgordeid >= ".$volgordeid." ORDER by volgordeid ASC LIMIT 2";
									$resultaat     = mysql_query($query);
								break;    
							}
					
							if($resultaat && mysql_num_rows($resultaat) == 2)
							{
								$paginaid     = array();
								$volgordeid = array();
								
								while($rij = mysql_fetch_array($resultaat))
								{
									$paginaid[]     = $rij['paginaid'];
									$volgordeid[]     = $rij['volgordeid'];
								}            
							
								$query         = "UPDATE content SET volgordeid = ".$volgordeid[0]." WHERE paginaid = ".$paginaid[1]."";
								$resultaat     = mysql_query($query);
									
								$query         = "UPDATE content SET volgordeid = ".$volgordeid[1]." WHERE paginaid = ".$paginaid[0]."";
								$resultaat     = mysql_query($query);
														
							}else{
								echo '<p>Sorry, maar deze actie is voor mij onmogelijk!</p>'.BR;
							}
						}else{
							echo '<p>Sorry, de variabele volgordeid hoort numeriek te zijn!</p>'.BR;
						}
					}else{
						echo '<p>Sorry, ik verwacht op zijn minst iets van een volgordeid!</p>'.BR;
					}
				break;    
			}        
		}
	}
	?>
	
	<div id="adminmenu">
	<b>Menuitems</b>:<br><br>
	
	<?php
	$query         = "SELECT titel, paginaid, volgordeid FROM content ORDER BY volgordeid";
	$resultaat     = mysql_query($query);
	
	$menuvolgordeid = 0;
	
	if($resultaat && mysql_num_rows($resultaat) >= 1)
	{
		while($rij = mysql_fetch_array($resultaat))
		{
			$menupaginaid     = $rij['paginaid'];
			$menutitel         = $rij['titel'];
			$menuvolgordeid    = $rij['volgordeid'];
			
			if(strlen($menutitel) > 20)
			{
				$menutitel         = substr($menutitel, 0, 17);
				$menutitel        .= "...";
			}
					
			echo '<a href="?p=admin_cms&actie=verhogen&amp;volgordeid='.$menuvolgordeid.'"><img src="images/omhoog.gif" border="0" title="Verhogen" alt="Verhogen"></a> <a href="?p=admin_cms&actie=verlagen&amp;volgordeid='.$menuvolgordeid.'"><img src="images/omlaag.gif" title="Verlagen" border="0" alt="Verhogen"></a> <a href="?p=admin_cms&actie=verwijderen&amp;paginaid='.$menupaginaid.'"><img src="images/paginaverwijderen.gif" border="0" title="Pagina verwijderen" alt="Verhogen"></a> <a href="?p=admin_cms&actie=wijzigen&amp;paginaid='.$menupaginaid.'">'.ucfirst($menutitel).'</a><br>'.BR;
		}
	}    
	
	echo '<br><a href="?p=admin_cms&actie=toevoegen&amp;volgordeid='.($menuvolgordeid +1).'">Pagina toevoegen</a><br><br><br>'.BR;
	?>
	
	</div>
	
	
	<?php
	if(isset($actie) && ($actie == 'toevoegen' || $actie == 'wijzigen'))
	{
		$query         = "SELECT titel, content FROM content WHERE paginaid = ".$paginaid."";
		$resultaat     = mysql_query($query);
		
		if($resultaat && mysql_num_rows($resultaat) == 1)
		{
			$rij         = mysql_fetch_array($resultaat);
			
			$titel        = stripslashes($rij['titel']);
			$content     = stripslashes($rij['content']);
			
	?>
	
	<div id="content">
	<form name="formulier" action="" method="post">
	Titel: <input type="text" id="titel" name="titel" size="35" value="<?php echo $titel; ?>" title="De gewenste titel."><br><br>
	<textarea name="content" rows="20" style="width: 100%;" id="content" title="De gewenste content"><?php echo $content; ?></textarea><br>
	<input type="submit" name="versturen" value="Versturen" id="versturen"> <INPUT type="reset" id="wissen" name="wissen" value="Wissen">
	</form>
	</div>
		
	<?php    
		}else{
			echo '<p>Sorry, er gaat hier iets mis wat eigenlijk niet fout kan gaan...</p>'.BR;
		}
	}
}
?>