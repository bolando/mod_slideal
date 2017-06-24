<?php
// blokowanie bezpośredniego uruchomienia
defined('_JEXEC') or die;

//wlaczenie klasy modelu
require_once dirname(__FILE__) . '/helper.php';

//wywolanie metody modelu pobierajacej parametry
$images = modSlidealHelper::getImages($params);


//pobranie parametrow innych
$sW = $params->get('slidewidth');
$sH = $params->get('slideheight');
$timeout = $params->get('timeinterval');
$speed = $params->get('speed');
$direction = $params->get('direction');
$jQueryOn = false;
if($params->get('jqison') == 'T') {
	$jQueryOn = true;
}

$doc =& JFactory::getDocument();

//wlaczenie domyslnego layoutu
require JModuleHelper::getLayoutPath('mod_slideal');
