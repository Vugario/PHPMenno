<?php 

	/*
	PHPMenno V6 - Simpel, Snel en Beter
	---------------------------------------------------
	Copyright (c) 2009, Menno Wolvers 'Menno'
	Copyright (c) 2010, Jeroen van de Weerd 'Jeroen262'
	http://www.jeroenvdweerd.nl
	---------------------------------------------------
	This program is free software: you can redistribute 
	it and/or modify it under the terms of the 
	GNU General Public License as published by the Free 
	Software Foundation, either version 6 of the 
	License, or	(at your option) any later version.
	*/        
	if(isset($url[1])) {
        if($url[1] == "aanmaken") {
        	if(!isset($_SESSION['id'])) {
        		$_SESSION['msg'] = '<div id="msg" onclick="javascript:document.getElementById(\'msg\').style.display=\'none\'">Je moet ingelogd zijn om een Blog aan te maken.</div>';
        		header('Location:../login');
        	}
            if(isset($_POST['toevoegen']) && !empty($_POST['titel']) && !empty($_POST['bericht']) && !empty($_POST['actief'])) {
    				echo blogsToevoegen($_POST['titel'],$_POST['bericht'],$_POST['actief']);	
            }else{
                
?>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" onclick="return submitForm();" method="post">
                    <table width="300" class="data">
                        <tr>
                            <td>Titel</td>
                            <td><input type="text" name="titel" maxlength="75" /></td>
                        </tr>
                        <tr>
                            <td>Blog bericht</td>
                            <td><textarea class='ckeditor' id='bericht' name='bericht' style='background:#FFFFFF;'></textarea></td>
                                <script type='text/javascript'>
    										CKEDITOR.replace( 'bericht',
    											{
    												height : '130px',
    												extraPlugins : 'uicolor',
    												toolbar :
    												[
    													[ 'Preview', 'Image', 'Smiley', '-', 'Bold', 'Italic', 'Underline', '-', 'Link', 'Unlink' ]
    												]
    											});
    							</script>
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
               
        if($url[1] == "bekijken") {
            $sql = mysql_query("SELECT * FROM blogs_berichten ORDER BY datum DESC LIMIT 6");
            while($row = mysql_fetch_assoc($sql)) {
            	$row_member = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
            	$aantal_reacties = mysql_num_rows(mysql_query("SELECT reactie_id FROM blogs_reacties WHERE blogs_id='".$row['blogs_id']."'"));
            	echo "
                	<h4><a href='bericht/".$row['url']."'>".$row['titel']."</a></h4>
                	<div style='overflow: hidden; margin-bottom: 5px;'>".$row['bericht']."</div>
                	<i>Bericht gepost op ".$row['datum']." door ".$row_member['gebruikersnaam'].".</i><br /><br />	
            	";
            }
            if(mysql_num_rows($sql) == 0) {
            	echo "Er zijn nog geen blogs geplaatst.";
            }    
        }
        
        if(isset($url[2])) {    
            if($url[1] == "bericht") {
    			$mid = mysql_real_escape_string(substr($url[2],0,255));
    			$sql = mysql_query("SELECT * FROM blogs_berichten WHERE url='".$mid."'");
    			$row = mysql_fetch_assoc($sql);
                $row_member = mysql_fetch_assoc(mysql_query("SELECT gebruikersnaam FROM leden WHERE member_id='".$row['member_id']."'"));
    			
    			echo "
                    <h4>".$row['titel']."</h4>
        			<div style='overflow: hidden; margin-bottom: 5px;'>".$row['bericht']."</div>
                    <i>Bericht gepost op ".$row['datum']." door ".$row_member['gebruikersnaam'].".</i><br /><br />
        			<h4>Reacties</h4>
                ";
    		}
        }
    }
    
?>