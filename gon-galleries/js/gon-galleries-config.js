jQuery(document).ready(function(){
	console.log('hello, isi ti me youre looking for?');
	//colorbox initialization for in-the-wild galleries
	//jQuery("a.colorbox").colorbox({rel:"group1", transition:"fade", width:"75%", height:"95%"});
	
	jQuery(".masonry-wrapper").imagesLoaded(function () {
		jQuery(".masonry-wrapper").masonry({
		  // options
		  itemSelector: ".masonry-target",
		  //columnWidth: 200
		});


	});
	if(jQuery('.wp-block-gallery.masonry').length){
		jQuery('.wp-block-gallery.masonry').imagesLoaded(function () {
			jQuery(".wp-block-gallery.masonry").masonry({
			  // options
			  itemSelector: ".blocks-gallery-item",
			  //columnWidth: 200
			});
		});
	}
	
	
	if(jQuery('.wp-block-gallery.slideshow').length){
		console.log('dsjn');
		jQuery('.wp-block-gallery.slideshow').cycle({
			speed: 600,
			slides: '> li',
			autoHeight: 'calc',
			fx: 'fade'
		})
	}
});
