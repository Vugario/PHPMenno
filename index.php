<?php
	/// Is het systeem al geinstalleerd? Zo nee, link door naar de instalatie. (verwijder dit niet!) ///
	if(file_get_contents("config.php") == "") {
		include('INSTALL/index.php');
		die();
	}else{
		require_once('functions/head_function.php');
	}
	/// Hier stopt de controle ///
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>PHPMenno V6</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />	
	<meta http-equiv="content-style-type" content="text/css" />
	<link rel="stylesheet" href="<?php echo $root; ?>style.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo $root; ?>ckeditor/ckeditor.js"></script>
	<script src="<?php echo $root; ?>ckeditor/_samples/sample.js" type="text/javascript"></script>
	<link href="<?php echo $root; ?>ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />
</head> 
<body> 
	<div id="container">
		<div id="inntercontent">
			<?php include ('pagina/balk.php');?>
			<div id="leftrow">
				<div id="left">
					<?php include('menu.php'); ?>
                    <?php include('online.php'); ?>
				</div>
			</div>	
	
			<div id="centerrow">
				<div id="center">
					<?php
						if(isset($_SESSION['msg'])) {
							echo $_SESSION['msg'];
							unset($_SESSION['msg']);
						}
						if(isset($_GET['u'])) {
							$url = explode('/', $_GET['u']);
							if(file_exists('pagina/' . $url[0] . '.php')) {
								$page = 'pagina/' . $url[0] . '.php';
							}else{
							     if(file_exists('masons/' . $url[0] . '.php')) {
							         $page = 'masons/' . $url[0] . '.php';
                                }else{
                                    header('Location:'.$root.'pagina-niet-gevonden');
                                }
							}
						} else {
							$page = 'pagina/home.php';
						}
						include($page);
					?>
				</div>
			</div>			
		</div>
	</div>
	<?php echo file_get_contents(''.$versioncheck.''.$version.''); ?>  
</body> 
</html> 