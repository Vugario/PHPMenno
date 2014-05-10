<?php

class habboClass
{

    var $data;
    var $habboname;
    var $hotel;
    var $private;

    function habboClass($habboname, $hotel)
    {
        $this->habboname = $habboname;
        $this->hotel = $hotel;
        $this->data = file_get_contents("http://habbo." . $hotel . "/home/" . $habboname);
    }

    function online()
    {
        if (eregi("habbo_online_anim.gif", $this->data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function banned()
    {
        if (eregi("This page is not available anymore", $this->data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function actual()
    {
        if (eregi('<div id="page-headline-text">Habbo Homes</div>', $this->data))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function pageprivate()
    {
        if (eregi("marked this page as private.", $this->data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function motto()
    {
        $motto = explode('<div class="profile-motto">', $this->data);
		if(isset($motto[1])) {
			$motto = explode('</div>', $motto[1]);
			$motto = trim($motto[0]);
			$motto = str_replace('        <div class="clear">', '', $motto);
			if(strlen($motto) > 0) {
				return $motto;
			}else{
				$motto = "";
				return $motto;
			}
		}else{
			$motto = "";
			return $motto;
		}
    }

    function badge()
    {
        if (eregi("c_images/album1584/", $this->data))
        {
            $badge = explode('http://images.habbohotel.' . $this->hotel .
                '/c_images/album1584/', $this->data);
            $badge = explode('.gif', $badge[1]);
            $badge = trim($badge[0]);
            $badge = "http://images.habbohotel." . $this->hotel . "/c_images/album1584/" . $badge .
                ".gif";
            return $badge;
        }
        else
        {
            return false;
        }
    }

    function figure()
    {
        $figure = "http://campaigns.habbo.com/0702/app/habboimage.php?habboname=".$this->habboname."&site=http://www.habbo.".$this->hotel;
        return $figure;
    }

    function birthdate()
    {
        $birthdate = explode('<div class="birthday date">', $this->data);
        $birthdate = explode('</div>', $birthdate[1]);
        $birthdate = trim($birthdate[0]);
        return $birthdate;
    }

    function normal()
    {
        if (!$this->banned() and !$this->pageprivate() and $this->actual())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function name()
    {
        $name = explode('<span class="name-text">', $this->data);
        $name = explode('</span>', $name[1]);
        $name = trim($name[0]);
        return $name;
    }

}


?> 