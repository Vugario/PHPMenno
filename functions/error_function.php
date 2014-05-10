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
    // Gaat er wat fout? Dan laten we de error pagina zien
    function error($error) {
        global $version;
    	$tmp = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    	<html>
    		<head>
    			<title>Error</title>
    			<style>
    				* {
    					margin:0;
    					padding:0;
    				}
    				
    				body {
    					background:#ffc8c8;
    					font:11px Arial;
    				}
    				
    				#error { 
    					width:200px;
    					background:#f77979;
    					border:1px solid #9b0202;
    					margin:100px auto 0 auto;
    					color:#ffffff;
    					padding:20px;
    				}

    				#menno { 
    					width:200px;
    					margin:auto auto 0 auto;
    					color:#ffffff;
                        text-align: right;
    				}
    				
    				h1 {
    					margin:0 0 10px 0;
    				}
    				
    				p {
    					margin:0 0 8px 0;
    				}
    			</style>
    			<body>
    				%error%</div>
                    <div id="menno">PHPMenno '.$version.'</div>
    			</body>
    		</head>
    	</html>';
    	
    	return str_replace('%error%', '<div id="error"><h1>Oeps</h1>' . $error, $tmp);
    }
	
?>