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




	////////////////
	////LIGHTBOX////
	////////////////
	
	// add empty lightbox
	jQuery('body').append('<div id="gon_lightbox" style="display:none;"><div class="container text-center"><div class="inner"><div id="exit" class="text-right">close</div><img><p class="lightbox-caption"></p><span id="prev">&#x2039;</span><span id="next">&#x203a;</span></div></div></div>');
	
	//add attributes to all gallery items
	var i = 0;
	jQuery('.blocks-gallery-item').each(function(){
		i++;
		jQuery(this).attr('data-slide-index',i);
	})
	var totalSlides = i;
	console.log(totalSlides);

	//setup variable
	var escape = jQuery("#gon_lightbox #exit");
	var lightboxVisible = false;
	var nextHandle = jQuery("#gon_lightbox #next");
	var prevHandle = jQuery("#gon_lightbox #prev");


	jQuery('.blocks-gallery-item a').click(function(e){
		lightboxVisible = !lightboxVisible;//toggle visible variable
		var imgSrc = jQuery(this).children('img').attr('src');
		var currentSlide = jQuery(this).closest('li.blocks-gallery-item').data('slide-index');
		e.preventDefault();
		jQuery("#gon_lightbox").show();
		jQuery("#gon_lightbox .inner").children('img').attr('src',imgSrc);
		if(jQuery(this).siblings('figcaption').length){ 
			var text = jQuery(this).siblings('figcaption').html();
			jQuery("#gon_lightbox .lightbox-caption").html(text); 
		} else {
			jQuery("#gon_lightbox .lightbox-caption").html(''); 
		}
		jQuery("#gon_lightbox").attr('data-current',currentSlide);
	})

	nextHandle.click(next);
	prevHandle.click(prev);

	escape.click(function(){
		if(lightboxVisible){
			lightboxVisible = !lightboxVisible;
			jQuery("#gon_lightbox").hide();
		}
	})

	function next(){
		nextIndex = parseInt(jQuery("#gon_lightbox").attr('data-current'))+1;
		if(nextIndex>totalSlides){ nextIndex = 1; }
		else if (nextIndex==0){ nextIndex = totalSlides; }
		jQuery("#gon_lightbox").attr('data-current',nextIndex);
		newImg = jQuery('.blocks-gallery-item[data-slide-index='+nextIndex+'] a img').attr('src');
		jQuery("#gon_lightbox .inner").children('img').attr('src',newImg);
		if(jQuery('.blocks-gallery-item[data-slide-index='+nextIndex+'] a').siblings('figcaption').length){ 
			var text = jQuery('.blocks-gallery-item[data-slide-index='+nextIndex+'] a').siblings('figcaption').html();
			jQuery("#gon_lightbox .lightbox-caption").html(text); 
		} else {
			jQuery("#gon_lightbox .lightbox-caption").html(''); 
		}
	}

	function prev(){
		nextIndex = parseInt(jQuery("#gon_lightbox").attr('data-current'))-1;
		if(nextIndex>totalSlides){ nextIndex = 1; }
		else if (nextIndex==0){ nextIndex = totalSlides; }
		jQuery("#gon_lightbox").attr('data-current',nextIndex);
		newImg = jQuery('.blocks-gallery-item[data-slide-index='+nextIndex+'] a img').attr('src');
		jQuery("#gon_lightbox .inner").children('img').attr('src',newImg);
		if(jQuery('.blocks-gallery-item[data-slide-index='+nextIndex+'] a').siblings('figcaption').length){ 
			var text = jQuery('.blocks-gallery-item[data-slide-index='+nextIndex+'] a').siblings('figcaption').html();
			jQuery("#gon_lightbox .lightbox-caption").html(text); 
		} else {
			jQuery("#gon_lightbox .lightbox-caption").html(''); 
		}
	}





});

jQuery(document).keyup(function(e) {
	if (e.keyCode === 27) jQuery('#gon_lightbox #exit').click();
	else if (e.keyCode === 37) jQuery('#gon_lightbox #prev').click();
	else if (e.keyCode === 39) jQuery('#gon_lightbox #next').click();
});
