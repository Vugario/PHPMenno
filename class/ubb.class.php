<?php
// Highlight functies
function phphighlite_replace($code) {
    $code = trim(str_replace("\\\"", "\"", $code));
    if(empty($code)) {
        return " ";
    } else {
        array_push($GLOBALS['phphighlite'], $code);
        return "".(count($GLOBALS['phphighlite'])-1)."";
    }
}

function phphighlite($id, $fixed=1) {
    $code = $GLOBALS['phphighlite'][$id];
    $splitted = explode("\n", $code);
    $grootte = count($splitted)+1;
    if(!strpos($code,"<?") && substr($code,0,2)!="<?") {
        $code="<?".trim($code)."?>";
        $addedtags=1;
    }
    ob_start();
    $oldlevel=error_reporting(0);
    highlight_string($code);
    error_reporting($oldlevel);
    $buffer = ob_get_contents();
    ob_end_clean();
    if(!empty($addedtags)) {
        $openingpos = strpos($buffer,'&lt;?');
        $closingpos = strrpos($buffer, '?');
        $buffer = substr($buffer, 0, $openingpos).substr($buffer, $openingpos+5, $closingpos-($openingpos+5)).substr($buffer, $closingpos+5);
    }
    $page_popup = "";

  $return = $buffer;
    return $return;
}
// UBB functie
function ubb($bericht) {
 // Code
 $GLOBALS['phphighlite'] = array("dummy");
 $bericht = preg_replace("_<\?(.*?)\?>_ise","phphighlite_replace('<? \\1 ?>')",$bericht);
 // HTML wegwerken
 $bericht = htmlspecialchars($bericht);
 // Enters maken
 $bericht = nl2br($bericht);
 // URLs met tags maken
 $bericht = preg_replace("#\[url\](http|ftp)(.+?)\[/url\]#is","<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>",$bericht);
 $bericht = preg_replace("#\[url\](mailto:)(.+?)\[/url]#is","<a href=\"\\1\\2\" target=\"_blank\">\\2</a>",$bericht);
 $bericht = preg_replace("#\[mail\](.+?)\[/mail\]#is","\\1",$bericht);
 $bericht = preg_replace("#\[url\](.+?)\[/url\]#is","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$bericht);
 $bericht = preg_replace("#\[url=(http|ftp|mailto)(.+?)\](.+?)\[/url\]#is","<a href=\"\\1\\2\" target=\"_blank\">\\3</a>",$bericht);
 $bericht = preg_replace("#\[url=(.+?)\](.+?)\[/url\]#is","<a href=\"http://\\1\" target=\"_blank\">\\2</a>",$bericht);
 // Automatisch URLs
 $bericht = eregi_replace("(^|[ \n\r\t])((http(s?)://)(www\.)?([a-z0-9_-]+(\.[a-z0-9_-]+)+)(/[^/ \n\r]*)*)","\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $bericht);
 $bericht = eregi_replace("(^|[ \n\r\t])((ftp://)(www\.)?([a-z0-9_-]+(\.[a-z0-9_-]+)+)(/[^/ \n\r]*)*)","\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $bericht);
 $bericht = eregi_replace("([a-z_-][a-z0-9\._-]*@[a-z0-9_-]+(\.[a-z0-9_-]+)+)","<a href=\"mailto:\\1\">\\1</a>", $bericht);
 $bericht = eregi_replace("(^|[ \n\r\t])(www\.([a-z0-9_-]+(\.[a-z0-9_-]+)+)(/[^/ \n\r]*)*)","\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $bericht);
 $bericht = eregi_replace("(^|[ \n\r\t])(ftp\.([a-z0-9_-]+(\.[a-z0-9_-]+)+)(/[^/ \n\r]*)*)","\\1<a href=\"ftp://\\2\" target=\"_blank\">\\2</a>", $bericht);
 // Cursief
 $bericht = preg_replace("#\[i\](.+?)\[/i\]#is","<i>\\1</i>",$bericht);
 // Onderstreept
 $bericht = preg_replace("#\[u\](.+?)\[/u\]#is","<u>\\1</u>",$bericht);
 // Vetgedrukt
 $bericht = preg_replace("#\[b\](.+?)\[/b\]#is","<b>\\1</b>",$bericht);
 // Doorstreept
 $bericht = preg_replace("#\[s\](.+?)\[/s\]#is","<s>\\1</s>",$bericht);
 // Quote
 $bericht = preg_replace("#\[quote\](.+?)\[/quote\]#is","<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"3%\">&nbsp;</td><td><small>Quote</small></td></tr><tr><td width=\"3%\">&nbsp;</td><td style=\"border: 1px solid #232850;\"><table><tr><td>\\1</td></tr></table></td></tr></table>",$bericht);
 

 // MOD
 $bericht = preg_replace("#\[mod\](.+?)\[/mod\]#is","<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"3%\">&nbsp;</td><td><small>Quote</small></td></tr><tr><td width=\"3%\">&nbsp;</td><td style=\"border: 1px solid #232850;\"><table><tr><td>\\1</td></tr></table></td></tr></table>",$bericht);

 $bericht = preg_replace("#\[quote=(.+?)\](.+?)\[/quote\]#is","<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"3%\">&nbsp;</td><td><small>Quote: <b>\\1</b></small></td></tr><tr><td width=\"3%\">&nbsp;</td><td style=\"border: 1px solid #232850;\"><table><tr><td>\\2</td></tr></table></td></tr></table>",$bericht);
 // Plaatjes
 $bericht = preg_replace("#\[img\](http)(.+?)\[/img\]#is","<img src=\"\\1\\2\" alt=\"Plaatje\" />",$bericht);
 $bericht = preg_replace("#\[img\](.+?)\[/img\]#is","<img src=\"http://\\1\" alt=\"Plaatje\" />",$bericht);
 // Kleur
 $bericht = preg_replace("#\[color=(.+?)\](.+?)\[/color\]#is","<font color=\"\\1\">\\2</font>",$bericht);
 // Grootte
 $bericht = preg_replace("#\[size=(.+?)\](.+?)\[/size\]#is","<font size=\"\\1\">\\2</font>",$bericht);
 // Code
 $bericht = preg_replace("_\[code\]([0-9])\[/code\]_ise", "phphighlite('\\1')", $bericht);
 
 return $bericht;
}

?>