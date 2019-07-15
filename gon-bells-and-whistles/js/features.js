jQuery(document).ready(function(){


	// mouseTracker();
    //backgroundParallax();
    if(jQuery('body').hasClass('home')){
        if(jQuery('body.fade-sections').length){ scrollFade(); }
        if(jQuery('body.slide-columns').length){ slideLrt(); }
        if(jQuery('body.parallax-slideshow').length){ slideshowParallax(); }       
    }

    if(jQuery('#header.slide-in').length){ headerSlideDown(); }

})


////////////////////
//define functions//
////////////////////

/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////MOUSE TRACKER////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

//mouse tracker effect
function mouseTracker(){
	if(jQuery('#mouse-tracker-wrap').length){
		document.querySelector('#mouse-tracker-wrap').onmousemove = (e) => {
			const x = e.pageX - e.target.offsetLeft
			const y = e.pageY - e.target.offsetTop

			var y1 = e.pageY;
			var y2 = e.target.offsetTop;
			console.log(x);
			console.log(y);

			e.target.style.setProperty('--x', `${ x }px`)
			e.target.style.setProperty('--y', `${ y }px`)
		}
	}	
}


//Detect Closest Edge
function closestEdge(x,y,w,h) {
    var topEdgeDist = distMetric(x,y,w/2,0);
    var bottomEdgeDist = distMetric(x,y,w/2,h);
    var leftEdgeDist = distMetric(x,y,0,h/2);
    var rightEdgeDist = distMetric(x,y,w,h/2);
    var min = Math.min(topEdgeDist,bottomEdgeDist,leftEdgeDist,rightEdgeDist);
    switch (min) {
        case leftEdgeDist:
            return "left";
        case rightEdgeDist:
            return "right";
        case topEdgeDist:
            return "top";
        case bottomEdgeDist:
            return "bottom";
    }
}

//Distance Formula
function distMetric(x,y,x2,y2) {
    var xDiff = x - x2;
    var yDiff = y - y2;
    return (xDiff * xDiff) + (yDiff * yDiff);
}


/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////SCROLL FADE IN///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////


jQuery.fn.isInViewport = function() {
  var elementTop = jQuery(this).offset().top;
  var elementBottom = elementTop + jQuery(this).outerHeight();

  var viewportTop = jQuery(window).scrollTop();
  var viewportBottom = viewportTop + jQuery(window).height();

  return elementBottom > viewportTop && elementTop < viewportBottom - 200;

  

};



function scrollFade(){

    //initially hide sections
    jQuery('#main-content > section:not(:first-child) .row').each(function() {
        jQuery(this).css({'opacity':'0'});
        jQuery(this).css({'transition':'.4s linear transform','transform': 'scale(1.3)'});
    })

    //fade in on scroll
    jQuery(window).on('resize scroll', function() {
      jQuery('#main-content > section:not(:first-child) .row, footer').each(function() {
        if (jQuery(this).isInViewport()) {
            console.log(jQuery(this));
            var scrollme = jQuery(this);
            scrollme.css({'transform': 'scale(1)'}).animate({opacity:"1"},500);
        } 
      });
    });
};



//////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////SLIDE IN LTR//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

        
function slideLrt(){

    var columnsRowOne = jQuery('#home-columns > div > .row:first-child');
    var columnsRowTwo = jQuery('#home-columns > div > .row:nth-child(2)');
    var colOneFired = false;
    var colTwoFired = false;
    var delayOne = 0;
    var delayTwo = 0;

    //hide columns and offset them to the left
    jQuery('#home-columns [class*="col-"]').each(function(){
        jQuery(this).css({'opacity':'0','transform':'translateX(-90px)','transition':'.3s all ease'});
    })

    jQuery(window).on('resize scroll', function() {

        if(columnsRowOne.isInViewport()) {
            columnsRowOne.find("[class*='col-']").each(function(){
                jQuery(this).delay(delayOne).queue(function(){
                    jQuery(this).css({'opacity':'1','transform':'translateX(0)'});
                })
                delayOne += 150;
            })
        }
        if(columnsRowTwo.isInViewport()) {
            columnsRowTwo.find("[class*='col-']").each(function(){
                jQuery(this).delay(delayTwo).queue(function(){
                    jQuery(this).css({'opacity':'1','transform':'translateX(0)'});
                })
                delayTwo += 150;
            })
        }
    });

}


/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////SLIDE IN HEADER//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////


function headerSlideDown(){
    jQuery(window).on('resize scroll', function() {
        //adjust position of extra header if user is logged in
        if(jQuery('body').hasClass('logged-in')){
            var adjust = jQuery('#wpadminbar').outerHeight();
            jQuery('#header.slide-in').css('top',adjust);
        }

        //position controlled by CSS class
        if(jQuery(window).scrollTop() > 400){
            jQuery('#header.slide-in').addClass('animated-in');
        } else {
            jQuery('#header.slide-in').removeClass('animated-in');
        }
    });

}



/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////PARALLAX BACKGROUND//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////


function backgroundParallax(){
    //parallax only on desktop
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    } else {
        jQuery(window).scroll(function() {
            
            jQuery('.parallax').each(function(){
            //higher scroll speed = closer to fixed positioning, lower = closer to reltive positioning

                var scroll_speed = 5;
                var current = jQuery(this);
              

                var parallax_object = jQuery(this).position().top;
                var parallax_window = jQuery(window).scrollTop() + jQuery(window).height();  
                
                console.log(parallax_object, parallax_window); 

                if(parallax_object<parallax_window)  {
                
                  var bgScroll = (jQuery(window).scrollTop() - current.offset().top)/scroll_speed;
                  var bgPosition = 'center '+ bgScroll + 'px';
                  console.log(current.offset().top, jQuery(window).scrollTop() , bgScroll);
                  current.css({ backgroundPosition: bgPosition });              

                }       


          });
      });
    }
}

function slideshowParallax(){
    jQuery('.slideshow').each(function(){
      var img = jQuery(this);
      var imgParent = jQuery(this).parent();
      function parallaxImg () {
        var speed = -0.5;
        var imgY = imgParent.offset().top;
        var winY = jQuery(this).scrollTop();
        var winH = jQuery(this).height();
        var parentH = imgParent.innerHeight();


        // The next pixel to show on screen      
        var winBottom = winY + winH;

        console.log(imgY, winY, parentH);

        // only begin parallax effect if top of slideshow is beggining to scroll offscreen
        if (winY > imgY) {
          // Max number of pixels until block disappear
          var diff = (winY - imgY)/25;
        } else {
          var diff = 0;
        }
        img.css({
          transform: 'translate(0%, ' + diff + '%)'
        });
      }
      jQuery(document).on({
        scroll: function () {
          parallaxImg();
        }, ready: function () {
          parallaxImg();
        }
      });
    });
}








