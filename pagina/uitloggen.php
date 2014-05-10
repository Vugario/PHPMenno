<table id="table1" width="98%" height="49" border="0" cellpadding="0" cellspacing="0">

	<tr>
		<td width="8" height="25">
			<img src="images/vakje_01.gif" width="8" height="25" alt=""></td>
		<td height="25" background="images/vakje_02.gif">
			<font face="Verdana" size="1"><b><img src="http://habbo-elements.nl/lettergen/testgen.php?message=Uitloggen"></b></td>
<td width="8" height="25">
			<img src="images/vakje_03.gif" width="8" height="25" alt=""></td>
	</tr>
	<tr>

		<td width="8" height="15" background="images/vakje_04.gif">
	  </td>
	  <td height="15" bgcolor="#FFFFFF" valign="top">


<?php
if(!isset($_SESSION['id'])) {
	echo "Je bent niet ingelogd, <a href='index.php'>Ga terug</a>.";
	die();
}
?><?php

if(isset($_SESSION['id'])) {
	
	session_destroy();
	echo "Je bent nu succesvol uitgelogd.<br />
	Je wordt in 2 seconden doorgelinkt.";
	echo '<meta http-equiv="refresh" content="2;URL=index.php" />';
	
}else{
	echo "Je was nog niet ingelogd dus je kan ook niet uitloggen.";
}

?>


          </td>
	  <td width="8" height="15" background="images/vakje_06.gif">
	  </td>
	</tr>
	<tr>
		<td width="8" height="9">
			<img src="images/vakje_07.gif" width="8" height="9" alt=""></td>
		<td height="9" background="images/vakje_08.gif">
			</td>

		<td width="8" height="9">
			<img src="images/vakje_09.gif" width="8" height="9" alt=""></td>
	</tr>
</table>