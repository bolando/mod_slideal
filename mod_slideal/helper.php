<?php
// blokowanie bezpośredniego uruchomienia
defined('_JEXEC') or die;


class modSlidealHelper {
	
	const SLIDES_COUNT = 15;	
	
	static function getImages($params) {
		$images = array();
		for($i = 1; $i <= self::SLIDES_COUNT; $i++) {
			$key = sprintf('img%02d', $i);
			$imgPath = $params->get($key);
			if(!empty($imgPath)) {
				array_push($images, $imgPath);
			}
		}
		return $images;
	}
	
	static function getSlides(&$params) {
		$db = JFactory::getDbo();
		$sql = 'SELECT id FROM #__content';
		$db->setQuery($sql);
		$db->query($sql);
		return $db->getNumRows();
	}
}
