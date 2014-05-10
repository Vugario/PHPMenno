<?php

$sql = mysql_query("SELECT ip,reden FROM ipban WHERE ip='".$_SERVER['REMOTE_ADDR']."'");
if(mysql_num_rows($sql) >= 1) {
	$row = mysql_fetch_assoc($sql);
	echo "
	<html>
	<head>
	<title>Verbannen!</title>
	</head>
	<body style='background: #47839D;'>
	<center>
	<table width='296' cellpadding='0' cellspacing='0'>
		<tr>
			<td style='font-family:verdana;font-size:12px;color:#FFFFFF;text-align:center;height:20px;font-weight:bold;background:url(http://aycu15.webshots.com/image/24454/2004790782852168927_rs.jpg);width:296px;'>Je bent verbannen</td>
		</tr>
			<td style='background:url(http://aycu05.webshots.com/image/22924/2004701392876807873_rs.jpg); width:296px;'>		
				<img src='https://www.habbo.nl/deliver/images.habbohotel.nl/c_images/album1358/frank_shocked.gif?h=ae1d32f98204afef7f919c156b43922f' align='left' />
				<span style='font-family:verdana;font-size:12px;'>Je bent verbannen van deze site.<br />Je hebt de regels overtreden.<br />
				De reden van de ban:<br /><br />
				<strong>".$row['reden']."</strong>
			</td>
		</tr>
		<tr>
			<td style='background:url(http://aycu20.webshots.com/image/26099/2004721638951282190_rs.jpg);width:296px;height:6px;'></td>
		</tr>
	</table>
	</center>
	</body>
	</html>";/// dit is de echo die de bericht box ,die habbo.nl altijd heeft, overneemt en als verban message laat zien :)
	die;
}

if(isset($_SESSION['id'])) {
	$sql = mysql_query("SELECT reden,tijd FROM tijd_bannen WHERE member_id='".$_SESSION['id']."'");
	if(mysql_num_rows($sql) >= 1) {
	$row = mysql_fetch_assoc($sql);
	
	$dag = date("d");
	$uur = date("H");
	$minuut = date("i");
	$datum = $dag."-".$uur.":".$minuut;
		if($row['tijd'] > $datum) {
		echo "
		<html>
		<head>
		<title>Verbannen!</title>
		</head>
		<body style='background: #47839D;'>
		<center>
		<table width='296' cellpadding='0' cellspacing='0'>
			<tr>
				<td style='font-family:verdana;font-size:12px;color:#FFFFFF;text-align:center;height:20px;font-weight:bold;background:url(http://aycu15.webshots.com/image/24454/2004790782852168927_rs.jpg);width:296px;'>Je bent verbannen</td>
			</tr>
				<td style='background:url(http://aycu05.webshots.com/image/22924/2004701392876807873_rs.jpg); width:296px;'>		
					<img src='https://www.habbo.nl/deliver/images.habbohotel.nl/c_images/album1358/frank_shocked.gif?h=ae1d32f98204afef7f919c156b43922f' align='left' />
					<span style='font-family:verdana;font-size:12px;'>Je bent verbannen van deze site.<br />Je hebt de regels overtreden.<br />
					De reden van de ban:<br /><br />
					<strong>".$row['reden']."</strong>
				</td>
			</tr>
			<tr>
				<td style='background:url(http://aycu20.webshots.com/image/26099/2004721638951282190_rs.jpg);width:296px;height:6px;'></td>
			</tr>
		</table>
		</center>
		</body>
		</html>";/// dit is de echo die de bericht box ,die habbo.nl altijd heeft, overneemt en als verban message laat zien :)
		die;
		}else{
			mysql_query("DELETE FROM tijd_bannen WHERE member_id='".$_SESSION['id']."'");
		}
	}
}
?>