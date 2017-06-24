<?php
// blokowanie bezpośredniego uruchomienia
defined('_JEXEC') or die;
if($jQueryOn) {
	$doc->addScript('modules/mod_slideal/js/jquery-1.6.1.min.js');
}
$doc->addStyleSheet('modules/mod_slideal/css/slideal.css');

$slidesCount = 0;
if(!empty($images)) {
	$slidesCount = count($images);
	$leftHide = ($sW + 10);
?>
<script type="text/javascript">
var slidesCount = <?php echo $slidesCount; ?>;
var currentSlide = 0;
var leftPosHide = <?php echo $leftHide; ?>;
var leftPos = <?php echo $sW; ?>;
var topPos = <?php echo $sH; ?>;
var currentPosLeft = leftPos;
var currentPosTop = topPos;
var animationSpeed = <?php echo '\'' . $speed . '\''; ?>;
var animationDirection = <?php echo '\'' . $direction . '\''; ?>;
var animationDirRand = <?php echo '\'' . $direction . '\''; ?>;
var animationTimeout = 'slideal';
var breakAnimation = false;

function animationSlideal(cuId, neId) {
	if(breakAnimation == false) {
		var animationInterval = 14;
		var deltaPos = 6;
		if(animationSpeed == 'F') {
			animationInterval = 5;
			deltaPos = 8;
		}

		var posTmp = '';
		if(animationDirection == 'L') {
			currentPosLeft = (currentPosLeft - deltaPos);
			if(currentPosLeft <= 0) {
				currentPosLeft = 0;
				breakAnimation = true;
			}
			posTmp = '' + currentPosLeft + 'px';
			jQuery('#' + neId).css('left', posTmp);
		} else if (animationDirection == 'R') {
			currentPosLeft = (currentPosLeft + deltaPos);
			if(currentPosLeft >= 0) {
				currentPosLeft = 0;
				breakAnimation = true;
			}
			posTmp = '' + currentPosLeft + 'px';
			jQuery('#' + neId).css('left', posTmp);
		} else if (animationDirection == 'T') {
			currentPosTop = (currentPosTop - deltaPos);
			if(currentPosTop <= 0) {
				currentPosTop = 0;
				breakAnimation = true;
			}
			posTmp = '' + currentPosTop + 'px';
			jQuery('#' + neId).css('top', posTmp);
		} else if (animationDirection == 'B') {
			currentPosTop = (currentPosTop + deltaPos);
			if(currentPosTop >= 0) {
				currentPosTop = 0;
				breakAnimation = true;
			}
			posTmp = '' + currentPosTop + 'px';
			jQuery('#' + neId).css('top', posTmp);
		}

		if(breakAnimation == true) {
			posTmp = '' + leftPosHide + 'px';
			jQuery('#' + cuId).css('left', posTmp);
		}

		animationTimeout = setTimeout(function(){animationSlideal(cuId, neId)}, animationInterval);
	} else {
		if(animationTimeout != 'slideal') {
			clearTimeout(animationTimeout);
		}
	}
}

function moveSlideal(cuId, neId) {
	var leftStart = '';
	var topStart = '';
	if(animationDirection == 'L') {
		leftStart = '' + leftPos + 'px';
		topStart = '0px';
		currentPosLeft = leftPos;
		currentPosTop = 0;
	} else if (animationDirection == 'R') {
		leftStart = '-' + leftPos + 'px';
		topStart = '0px';
		currentPosLeft = (-1 * leftPos);
		currentPosTop = 0;
	} else if (animationDirection == 'T') {
		leftStart = '0px';
		topStart = '' + topPos + 'px';
		currentPosLeft = 0;
		currentPosTop = topPos;
	} else if (animationDirection == 'B') {
		leftStart = '0px';
		topStart = '-' + topPos + 'px';
		currentPosLeft = 0;
		currentPosTop = (-1 * topPos);
	}
	jQuery('#' + cuId).css('z-index', '1');
	jQuery('#' + neId).css('z-index', '10');
	jQuery('#' + neId).css('left', leftStart);
	jQuery('#' + neId).css('top', topStart);
	//animacja
	breakAnimation = false;
	animationTimeout = 'slideal';
	animationSlideal(cuId, neId);
}

function showSlideal() {
	if(currentSlide == 0) {
		currentSlide = 1;
	} else {
		//losowanie kierunku
		if(animationDirRand == 'D') {
			var randDirs = ['L', 'R', 'T', 'B'];
			var randDir = Math.floor(((Math.random() * 40) / 10));
			if(randDir < 0 || randDir > 3) {
				randDir = 0;
			}
			animationDirection = randDirs[randDir];
		}
		var nextSlide = (currentSlide + 1);
		if(nextSlide > slidesCount) {
			nextSlide = 1;
		}
		var currentId = '';
		if(currentSlide > 9) {
			currentId = 'slidealimg' + currentSlide;
		} else {
			currentId = 'slidealimg0' + currentSlide;
		}
		var nextId = '';
		if(nextSlide > 9) {
			nextId = 'slidealimg' + nextSlide;
		} else {
			nextId = 'slidealimg0' + nextSlide;
		}
		moveSlideal(currentId, nextId);
		currentSlide = nextSlide;
	}
	setTimeout(function(){showSlideal()}, <?php echo $timeout; ?>);
}

jQuery(document).ready(function() {
	showSlideal();
});



</script>

<?php
	$mediaQuery = '<style> @media (max-device-width: 979px) {.slidealMainContainer{display: none;}} @media (max-width: 979px) {.slidealMainContainer{display: none;}} </style>';
	echo $mediaQuery;	
	echo '<div class="slidealMainContainer" style="width:' . $sW . 'px; height:' . $sH . 'px;">';
	$imgNum = 0;
	foreach($images as $imgSrc) {
		$imgId = sprintf('slidealimg%02d', ($imgNum + 1));
		$imgClass = 'slidealImg';
		$imgStyle = 'width:' . $sW . 'px; height:' . $sH . 'px; z-index: 1; left: 0px;';
		if($imgNum > 0) {
			$imgStyle = 'width:' . $sW . 'px; height:' . $sH . 'px; z-index: 1; left: ' . $leftHide . 'px;';
		} 
		$imgNum++;
		echo '<img id="' . $imgId . '" src="' . $imgSrc . '" width="' . $sW . '" height="' . $sH . '" class="' . $imgClass . '" style="' . $imgStyle . '" />';
	}
	echo '</div>';
}
?>

