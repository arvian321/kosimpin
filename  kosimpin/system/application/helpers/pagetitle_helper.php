<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

if (!function_exists('get_pagetitle')) {
	function get_pagetitle($uri) {
		$menu = array(
					"1" => array("name" => "Home", "parent" => 0), 
					"2" => array("name" => "Events", "parent" => 0), 
					"3" => array("name" => "Tracking", "parent" => 0), 
					"4" => array("name" => "Plan and Develop", "parent" => 0), 
					"5" => array("name" => "Diary", "parent" => 0), 
					"6" => array("name" => "Logistic", "parent" => 0), 
					"7" => array("name" => "Doctrine", "parent" => 0), 
					"8" => array("name" => "MIS", "parent" => 0), 
					"9" => array("name" => "Personnel", "parent" => 0), 
					"10" => array("name" => "Admin", "parent" => 0), 
					
					"11" => array("name" => "Team and Devices", "parent" => 3), 
					"12" => array("name" => "Live Tracking", "parent" => 3), 
					"13" => array("name" => "History Playback", "parent" => 3), 
					"14" => array("name" => "Polling", "parent" => 3), 
					
					"15" => array("name" => "Roster", "parent" => 4), 
					"16" => array("name" => "FDE", "parent" => 4), 
					"17" => array("name" => "Movement", "parent" => 4), 
					"18" => array("name" => "Planning", "parent" => 4), 
					"19" => array("name" => "Request", "parent" => 4), 
					"20" => array("name" => "SMS", "parent" => 4), 
					
					"21" => array("name" => "Station Diary Entries", "parent" => 5), 
					"22" => array("name" => "Station Diary Assignment", "parent" => 5), 
					"23" => array("name" => "Incident Report", "parent" => 5), 
					
					"24" => array("name" => "SOS Log", "parent" => 8), 
					
					"25" => array("name" => "Personnel", "parent" => 9), 
					"26" => array("name" => "VIP", "parent" => 9), 
					
					"27" => array("name" => "User Account", "parent" => 10), 
					"28" => array("name" => "User Role", "parent" => 10), 
					"29" => array("name" => "Access Control", "parent" => 10), 
					"30" => array("name" => "Blocked Personnel", "parent" => 10), 
					"31" => array("name" => "Audit Trail", "parent" => 10), 
					"32" => array("name" => "Workflow", "parent" => 10) 
				);
				
		$idx = 0;
		$controller = explode("/", $uri);
		
		switch($controller[1]) {
			case 'home': 
				$idx = 1; 
				break;
			case 'event': 
				$idx = 2; 
				break;
			case 'tracking': {
				if($controller[2] == "teams" || $controller[2] == "devices") $idx = 11;
				else if($controller[2] == "live") $idx = 12;
				else if($controller[2] == 'history') $idx = 13;
				else if($controller[2] == 'polling') $idx = 14;
				else if($controller[2] == 'sos') $idx = 24;
				break;
			}
			case 'roster': 
				$idx = 15; 
				break;
			case 'fde': 
				$idx = 16; 
				break;
			case 'movement': 
				$idx = 17; 
				break;
			case 'planning': {
				if($controller[2] == "ib") $idx = 18;
				else if($controller[2] == "main") $idx = 32;
				break;
			}
			case 'request': 
				$idx = 19; 
				break;
			case 'sms': 
				$idx = 20; 
				break;
			case 'diary': {
				if($controller[2] == "sd" || $controller[2] == "sd_add" || $controller[2] == "sd_view") $idx = 21;
				else if($controller[2] == "book" || $controller[2] == "book_add" || $controller[2] == "book_edit") $idx = 22;
				else if($controller[2] == 'ir' || $controller[2] == 'ir_add' || $controller[2] == 'ir_view' || $controller[2] == 'ir_draft') $idx = 23;
				break;
			}
			case 'personnel': 
				$idx = 25; 
				break;
			case 'vip': 
				$idx = 26; 
				break;
			case 'admin': {
				if($controller[2] == "account") $idx = 27;
				else if($controller[2] == "roles") $idx = 28;
				else if($controller[2] == 'matrix') $idx = 29;
				else if($controller[2] == 'personnel') $idx = 30;
				break;
			}			
		}
		
		if(isset($menu[$idx])) {
			$self = $menu[$idx]['name'];
			$parent = '';
			if($menu[$idx]['parent'] != 0) {
				$parentIdx = $menu[$idx]['parent'];
				$parent = $menu[$parentIdx]['name'];
			}
			
			$title['headTitle'] = ($parent == '') ? 'Seccom | '.$self : 'Seccom | '.$parent;
			$title['contentTitle'] = ($parent == '') ? $self : $parent." &raquo; ".$self;
		}
		else {
			$title['headTitle'] = 'Seccom';
			$title['contentTitle'] = '';
		}
		
		return $title;
	}
}
/* EOF */