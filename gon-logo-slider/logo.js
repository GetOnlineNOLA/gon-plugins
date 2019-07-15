jQuery(document).ready( function(){
	'use strict';
	
	//console.log('is this crazy maze working??????');
	var winWidth = jQuery(window).width();
	if(winWidth>800){
		//desktop
		var gonVisible = 3;
	} else if (winWidth>480) {
		//tablet
		var gonVisible = 2;
	} else {
		//mobile
		var gonVisible = 1;
	}
	
	jQuery('.logo-slideshow').cycle({
        fx: 'carousel',
		timeout: 4000,
		pauseOnHover: true,
		next: '#foot-next',
        prev: '#foot-prev',
		slides: "> a",
		carouselFluid: true,
		carouselVisible: gonVisible,
    });
});
