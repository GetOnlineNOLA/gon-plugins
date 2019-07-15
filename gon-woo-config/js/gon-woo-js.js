//init swipebox
jQuery(document).ready(function(){
	console.log('gon woocommerce swipebox initiated. If the swipebox isnt working, make sure it is set in the responsive lightbox settings');
	jQuery(".single-product a[href$='.jpg'], .single-product a[href$='.png'], .single-product a[href$='.jpeg'], .single-product a[href$='.gif']").swipebox();
});