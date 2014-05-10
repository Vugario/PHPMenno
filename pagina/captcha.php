<?PHP

function captcha_generator ($code) {
	error_reporting (E_ALL); // fouten weergeven
	
	$code = $code;
	$image = imagecreatetruecolor (300, 60); // maakt de image met de groote van 300px breed, en 60px hoog
	$aFonts = array ('font/font1.ttf', 'font/font2.ttf', 'font/font3.ttf', 'font/font4.ttf'); // zet alle beschikbare fonts in een array
	$aCode = str_split ($code); // zet alle karakters apart in een array
	
	for ($i = 0; $i < count ($aCode); $i++) // een for-lus maken voor het aantal karakters dat de $aCode array bevat
	{
	   $fontcolor = imagecolorallocate ($image, // kleurencombinatie maken voor de image variabel ($image)
		  rand (190, 255), // rood,
		  rand (190, 255), // groen,
		  rand (190, 255)); // blauw, deze geven de nieuwe kleur per karakter
	   if (count ($aCode) == 4) // de volgende locaties (x-as) aanmaken voor een code van 4 karakters lang
	   {
		  $pos[0] = rand (15, 55); // locatie aanmaken (x-as) voor de eerste karakter
		  $pos[1] = rand (80, 120); // locatie aanmaken (x-as) voor de tweede karakter
		  $pos[2] = rand (145, 185); // locatie aanmaken (x-as) voor de derde karakter
		  $pos[3] = rand (210, 250); // locatie aanmaken (x-as) voor de vierde karakter
	   }
	   if (count ($aCode) == 5) // de volgende locaties (x-as) aanmaken voor een code van 5 karakters lang
	   {
		  $pos[0] = rand (10, 45); // locatie aanmaken (x-as) voor de eerste karakter
		  $pos[1] = rand (65, 100); // locatie aanmaken (x-as) voor de tweede karakter
		  $pos[2] = rand (120, 155); // locatie aanmaken (x-as) voor de derde karakter
		  $pos[3] = rand (175, 210); // locatie aanmaken (x-as) voor de vierde karakter
		  $pos[4] = rand (230, 265); // locatie aanmaken (x-as) voor de vijfde karakter
	   }
	   imagettftext ($image, // image voorbereiden voor de image variabel ($image)
	   rand (14, 18), // fontgrootte, willekeurig getal laten kiezen tussen de 13 en 19
	   rand (-30, 30), // draaihoek, willekeur getal laten kiezen tussen de -31 en de 31
	   $pos[$i], // karakter positie breedte toewijzen, hebben we al voorbereid ($pos[])
	   rand (50, 20), // karakter positie hoogte, kiezen tussen de 51 en de 19
	   $fontcolor, // fontkleur toewijzen, hebben we al voorbereid ($fontcolor)
	   $aFonts[rand(0, 3)], // font, willekeurig font toewijzen uit de array ($aFonts)
	   $aCode[$i]); // code toewijzen, op volgorde van de array
	}
	imagepng ($image, 'captcha.png'); // de .png image aanmaken als captcha.png
	imagedestroy ($image); // de handel afronden, en klaar!
}
?> 