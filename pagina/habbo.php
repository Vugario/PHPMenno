<?php

$naam = htmlspecialchars( $_GET['habbo'] );

function setHome($Hotel, $HabboName) //Set a variable has data from the Habbo Home
{
    if (!$Hotel || !$HabboName)
    {
        return false;
    }
    else
    {
        $homeData = @file_get_contents("http://www.habbo." . $Hotel . "/home/" . $HabboName);
        return $homeData;
    }
}

// ################################################################################
#########################

function isBanned($Home) //Check if a habbo is banned
{
    if (!$Home)
    {
        return false;
    }
    else
    {
        if (eregi("Pagina kan niet worden getoond</div>", $Home))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

// ################################################################################
#########################

function isPrivate($Home) //Check if a Habbo Home is private
{
    if (!$Home)
    {
        return false;
    }
    else
    {
        if (eregi("Pagina is afgeschermd</div>", $Home))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

// ################################################################################
#########################

function habboExists($Home) //See if a Habbo exists
{
    if (!$Home)
    {
        return false;
    }
    else
    {
        if (eregi('<div id="page-headline-text">Habbo Homes</div>', $Home))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

// ################################################################################
#########################

function getHabboFigure($Home) //Get the Habbos Figure
{
    if (!$Home)
    {
        return false;
    }
    else
    {
        $figureStart = explode('<div class="profile-figure">', $Home);
        $figureEnd = explode('</div>', $figureStart[1]);
        $figureTrim = trim($figureEnd[0]);
        $figure = preg_replace('/<img alt=\"(.*?)\" src=\"(.*?)\" \/>/', '$2', $figureTrim);
        $hotelStart = explode('<div id="habbologo"><a href="', $Home);
        $hotelEnd = explode('/"></a></div>', $hotelStart[1]);
        $hotel = trim($hotelEnd[0]);
        $figure = $hotel . $figure;
        return $figure;
    }
}

// ################################################################################
#########################

$home = setHome(nl, $naam);
$output = getHabboFigure($home);

if (!$output || isBanned($home) || isPrivate($home) || habboExists($home)) {

Header ( "location:http://www.habsterdam.nl/Images/onbekend.gif" );

} else {

Header ( "location:$output" );

}

?>