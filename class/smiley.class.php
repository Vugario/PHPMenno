<?php

function addSmiley($bericht) {
	$smiles = array( ':poop:'=>'001_9898',
	':kiss:'=>'001_icon16',
	':1eye:'=>'1eye',
	':2guns:'=>'2guns',
	':alien:'=>'alien',
	':alucard:'=>'alucard',
	':angel:'=>'angel',
	':a'=>'angel',
	':A'=>'angel',
	':arabia:'=>'arabia',
	':balloon:'=>'balloon',
	':ban:'=>'ban',
	':batman:'=>'batman',
	':beta1:'=>'beta1',
	':boat:'=>'boat',
	':censored:'=>'censored',
	':chef:'=>'chef',
	':chinese:'=>'chinese',
	':pirate:'=>'chris',
	':clap:'=>'clap',
	'applaus'=>'clap',
	':clover:'=>'clover',
	':clown:'=>'clown',
	':+'=>'clown',
	':cool2:'=>'cool2',
	'8)'=>'cool2',
	':cowboy:'=>'cowboy',
	':detective:'=>'detective',
	':devil:'=>'devil',
	':devil2:'=>'devil2',
	':donatello:'=>'donatello',
	':dots:'=>'dots',
	':eek:'=>'eek',
	':euro:'=>'euro',
	':flowers:'=>'flowers',
	':gunsmilie:'=>'gunsmilie',
	':hammer:'=>'hammer',
	':happybday:'=>'happybday',
	':O'=>'helpsmilie',
	':help:'=>'helpsmilie',
	':innocent:'=>'innocent',
	':kiss1:'=>'kiss',
	':ninja:'=>'ninja',
	':('=>'no',
	':-('=>'no',
	':no:'=>'nono',
	':nono:'=>'nono',
	':nuke:'=>'nuke',
	':offtopic:'=>'offtopic',
	':online2long:'=>'online2long',
	':oops:'=>'oops',
	'oops'=>'oops',
	':ph34r:'=>'ph34r',
	':phono:'=>'phone',
	':pinch:'=>'pinch',
	'rockon'=>'rockon',
	':rockon:'=>'rockon',
	':rolleyes:'=>'rolleyes',
	':eyes:'=>'rolleyes',
	'--'=>'shifty',
	':shifty:'=>'shifty',
	':sleep1:'=>'sleep1',
	'zzz'=>'sleep1',
	':zzz:'=>'sleeping',
	':student:'=>'smartass',
	':smartass:'=>'smartass',
	':sorcerer:'=>'sorcerer',
	':stuart:'=>'stuart',
	':stupid:'=>'stupid',
	':surrender:'=>'surrender',
	':sweatdrop:'=>'sweatdrop',
	':tooth:'=>'tooth',
	':love:'=>'tt1',
	':P'=>'tt2',
	':p'=>'tt2',
	'=]'=>'turned',
	':]'=>'turned',
	':wacko:'=>'wacko',
	':S'=>'wacko',
	':s'=>'wacko',
	':walkman:'=>'walkman',
	':music:'=>'walkman',
	':whistling:'=>'whistling',
	':winkiss:'=>'winkiss',
	':wub:'=>'wub',
	':yawn:'=>'yawn',
	'yes'=>'yes',
	':yes:'=>'yes',
	':yinyang:'=>'yinyang');
	
	 $text = array('[bold]'=>'<strong>',
	'[/bold]'=>'</strong>',
	'[underlined]'=>'<u>',
	'[/underlined]'=>'</u>',
	'[italic]'=>'<i>',
	'[/italic]'=>'</i>',
	'[b]'=>'<strong>',
	'[/b]'=>'</strong>',
	'[u]'=>'<u>',
	'[/u]'=>'</u>',
	'<noscript>'=>' ',
	'<script>'=>' ',
	'[i]'=>'<i>',
	'[/i]'=>'</i>',
	'[c]'=>'<center>',
	'<script'=>' ',
	'<div'=>' ',
	'<div>'=>' ',
	'<script'=>' ',
	'<php'=>' ',
	'<php>'=>' ',
	'?>'=>' ',
	'[/c]'=>'</center>',
	'&#'=>' ',
	'<DIV'=>' ',
	'/DIV>'=>' ',
	'//'=>' ',
	'\\'=>' ',
	'<meta'=>' ',
	'[center]'=>'<center>',
	'[color=red]'=>'<font color="#ff0000">',
	'[/color]'=>'</font>',
 	'[colour=red]'=>'<font color="#ff0000">',
	'[/colour]'=>'</font>',
	'[/center]'=>'</center>');
	foreach($smiles as $smile=>$image)
	{
		$bericht = str_replace($smile,"<img src=images/smilies/".$image.".gif>", $bericht);
	}
	foreach($text as $text=>$text1)
	{
		$bericht = str_replace($text,$text1, $bericht);
	}
	return $bericht;
}

function Smileys() {
	?>
	<img src="images/smilies/001_icon16.gif" alt=":)" onclick="javascript:addSmilie(':kiss:')" />
	<img src="images/smilies/1eye.gif" alt=";d" title=":d" onclick="javascript:addSmilie(':1eye:')" />
	<img src="images/smilies/2guns.gif" alt=":o" title=":o" onclick="javascript:addSmilie(':2guns:')" />
	<img src="images/smilies/alien.gif" alt=";+" title=":+" onclick="javascript:addSmilie(':alien:')" />
	<img src="images/smilies/alucard.gif" alt=":(" title=":(" onclick="javascript:addSmilie(':alucard:')" />
	<img src="images/smilies/angel.gif" alt=";)" title=";)" onclick="javascript:addSmilie(':A')" />
	<img src="images/smilies/arabia.gif" alt=":h" title=":h" onclick="javascript:addSmilie(':arabia:')" />
	<img src="images/smilies/balloon.gif" alt=":e" title=":e" onclick="javascript:addSmilie(':balloon:')" />
	<img src="images/smilies/batman.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':batman:')" />
	<img src="images/smilies/boat.gif" alt=":g" title=":g" onclick="javascript:addSmilie(':boat:')" />
	<img src="images/smilies/censored.gif" alt=":x" title=":x" onclick="javascript:addSmilie(':censored:')" />
	<img src="images/smilies/chef.gif" alt=":w" title=":w" onclick="javascript:addSmilie(':chef:')" />
	<img src="images/smilies/chinese.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':chinese:')" />
	<img src="images/smilies/chris.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':pirate:')" />
	<img src="images/smilies/clap.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':clap:')" />
	<img src="images/smilies/clover.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':clover:')" />
	<img src="images/smilies/clown.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':+')" />
	<img src="images/smilies/cool2.gif" alt=":li" title=":li" onclick="javascript:addSmilie('8)')" />
	<img src="images/smilies/cowboy.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':cowboy:')" />
	<img src="images/smilies/detective.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':detective:')" />
	<img src="images/smilies/devil.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':devil:')" />
	<img src="images/smilies/devil2.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':devil2:')" />
	<img src="images/smilies/donatello.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':donatello:')" />
	<img src="images/smilies/eek.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':eek:')" />
	<img src="images/smilies/euro.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':euro:')" />
	<img src="images/smilies/excl.gif" alt=":li" title=":li" onclick="javascript:addSmilie('!')" />
	<img src="images/smilies/flowers.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':flowers:')" />
	<img src="images/smilies/gunsmilie.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':gunsmilie:')" />
	<img src="images/smilies/hammer.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':hammer:')" />
	<img src="images/smilies/helpsmilie.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':help:')" />
	<img src="images/smilies/innocent.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':innocent:')" />
	<img src="images/smilies/kiss.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':kiss1:')" />
	<img src="images/smilies/ninja.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':ninja:')" />
	<img src="images/smilies/no.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':(')" />
	<img src="images/smilies/nono.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':nono:')" />
	<img src="images/smilies/nuke.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':nuke:')" />
	<img src="images/smilies/online2long.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':online2long:')" />
	<img src="images/smilies/ph34r.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':ph34r:')" />
	<img src="images/smilies/phone.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':phone:')" />
	<img src="images/smilies/pinch.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':pinch:')" />
	<img src="images/smilies/rolleyes.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':rolleyes:')" />
	<img src="images/smilies/shifty.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':shifty:')" />
	<img src="images/smilies/sleep1.gif" alt=":li" title=":li" onclick="javascript:addSmilie('zzz')" />
	<img src="images/smilies/sleeping.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':zzz:')" />
	<img src="images/smilies/smartass.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':smartass:')" />
	<img src="images/smilies/sorcerer.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':sorcerer:')" />
	<img src="images/smilies/stuart.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':stuart:')" />
	<img src="images/smilies/surrender.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':surrender:')" />
	<img src="images/smilies/sweatdrop.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':sweatdrop:')" />
	<img src="images/smilies/tooth.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':tooth:')" />
	<img src="images/smilies/tt1.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':love:')" />
	<img src="images/smilies/tt2.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':P')" />
	<img src="images/smilies/turned.gif" alt=":li" title=":li" onclick="javascript:addSmilie('=]')" />
	<img src="images/smilies/wacko.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':S')" />
	<img src="images/smilies/walkman.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':walkman:')" />
	<img src="images/smilies/whistling.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':whistling:')" />
	<img src="images/smilies/winkiss.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':winkiss:')" />
	<img src="images/smilies/wub.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':wub:')" />
	<img src="images/smilies/yawn.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':yawn:')" />
	<img src="images/smilies/yes.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':yes:')" />
	<img src="images/smilies/yinyang.gif" alt=":li" title=":li" onclick="javascript:addSmilie(':yinyang:')" />
	<?php
}		 
?>