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
			if (preg_match("#habbo_online_anim.gif#i", $this->data))
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
			if (preg_match("#This page is not available anymore#i", $this->data))
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
			if (preg_match('#<div id="page-headline-text">Habbo Homes</div>#i', $this->data))
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
			if (preg_match("/marked this page as private./i", $this->data))
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
			if (preg_match("#c_images/album1584/#i", $this->data))
			{
				$badge = explode('http://images.habbo.com/c_images/album1584/', $this->data);
				$badge = explode('.gif', $badge[1]);
				$badge = trim($badge[0]);
				$badge = "http://images.habbo.com/c_images/album1584/" . $badge .
					".gif";
				return $badge;
			}
			else
			{
				return false;
			}
		}
		
		function groupbadge()
		{
			if (preg_match("#habbo-imaging/badge/#i", $this->data))
			{
				$badge = explode('/habbo-imaging/badge/', $this->data);
				$badge = explode('.gif', $badge[1]);
				$badge = trim($badge[0]);
				$badge = "http://habbo.com/habbo-imaging/badge/" . $badge .
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