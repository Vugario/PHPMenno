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
    $s_aantal = mysql_query("SELECT COUNT(id) FROM bezonline");  
    $aantal = mysql_num_rows($s_aantal); 
    
    if ($aantal > 1)  {
        echo "Er zijn <b>".$aantal."</b> bezoekers aanwezig!";  
    }else {
        echo "Er is <b>1</b> bezoeker aanwezig.";  
    }
    
?>