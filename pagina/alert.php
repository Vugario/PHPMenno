<?php

$sql = mysql_query("SELECT * FROM alert WHERE member_id='".$_SESSION['id']."' AND gelezen='Nee'");


if(mysql_num_rows($sql) >= 1) {
	$row = mysql_fetch_assoc($sql);
	mysql_query("UPDATE alert SET gelezen='Ja' WHERE alert_id='".$row['alert_id']."'");
	?>
	<html>
	
	<head>
	<meta http-equiv="Content-Language" content="nl">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Let op! U heeft een alert ontvangen..</title>
	</head>
	
	<body background="images/bg.gif" style="background-attachment: fixed">
	
	&nbsp;<div align="center">
		<table cellSpacing="0" cellPadding="0" width="370">
			<!-- MSTableType="nolayout" -->
			<tr>
				<td width="290" background="images/balk.gif" colSpan="3" height="20">
				<font face="Verdana" size="1">
				<img border="0" src="images/info.gif" width="32" height="32" align="left"><br>
				<br>
	&nbsp;</font></td>
			</tr>
			<tr>
				<td width="5" background="images/zijkant.gif" height="13">&nbsp;</td>
				<td width="355" bgColor="#ffffff" height="13">
				<font class="logintekst"><font face="Verdana" size="1"><b>Deze alert 
				is alleen naar jou toe gestuurd:</b><i><br>
				</i>
				<br>
				<?php echo $row['reden']; ?><br>
				<br>
				<b>Dit bericht is door 	
						<?php
							$sql = mysql_query("SELECT member_id FROM leden WHERE gebruikersnaam='".$row['door']."'");
							$row_id = mysql_fetch_assoc($sql);
						?>
						<a href="?p=profiel&mid=<?php echo $row_id['member_id']; ?>"><?php echo $row['door']; ?></a> gemaakt op <?php echo $row['datum']; ?>.</b></font></font><font face="Verdana"><b><font size="1">
				</font></b></font></td>
				<td width="10" background="images/zijkant.gif" height="13">&nbsp;</td>
			</tr>
			<tr>
				<td width="370" background="images/balk.gif" colSpan="3" height="35">
				<center><b><font color="#ffffff" face="Verdana" size="1"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">[ Sluit 
				alert ]</a></font></b></center></td>
			</tr>
		</table>
	</div>
	<font face="Verdana" size="1">
	<embed name="midi" src="muziek/nieuw%5Fbericht%5Fconsole.mp3" width="22" height="16" hidden="true" type="audio/x-wav" loop="false">
	</font>
	<p align="center">&nbsp;</p>
	
	</body>
	
	</html>
	<?php
	die();
}
?>