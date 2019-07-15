var isSlideshowPage = jQuery('#gon-video-slideshow');
if(isSlideshowPage.length > 0){


var gonWinWidth = jQuery(window).width();
var mobile = false;
if ( gonWinWidth < 768 ){
	mobile = true;
}

/////////////////////////////////////////
/////////////////////////////////////////
////////////*VIDEO SLIDESHOW*////////////
/////////////////////////////////////////
/////////////////////////////////////////

if(!mobile){

//identify all of the youtube slides and put them in an array
var youtubeVids = document.getElementsByClassName('youtube');
var ytVidIds = [];
for(i = 0; i < youtubeVids.length;i++) {
  	ytVidIds[i] = jQuery(youtubeVids[i]).attr('id');
}

var panningImgDivs = document.getElementsByClassName('kenburns-true');
var panningImages = [];
for(i = 0; i < panningImgDivs.length;i++) {
  	panningImages[i] = jQuery(panningImgDivs[i]).attr('id');
}
console.log(panningImages);


//set the height of the youtube video to the correct aspect ratio, based upon the width of the slideshow
var containerWidth = jQuery('.swiper-container').width();
var ytVidHeight = containerWidth*(9/16);


// global variable for the player
if( ytVidIds.includes('slide_0') ){
	var player0; 
	var vid0 = document.getElementById('slide_0');
	var VidId0 = vid0.dataset.source;
}
if( ytVidIds.includes('slide_1') ){ 
	var player1;
	var vid1 = document.getElementById('slide_1');
	var VidId1 = vid1.dataset.source;
}
if( ytVidIds.includes('slide_2') ){ 
	var player2;
	var vid2 = document.getElementById('slide_2');
	var VidId2 = vid2.dataset.source;
}

// this function gets called when API is ready to use
window.onYouTubePlayerAPIReady = function() {

	console.log('yt script ready');

  // create the global player from the specific iframe (#video)
  if( ytVidIds.includes('slide_0') ){
	  console.log('youtube vid init');
	  player0 = new YT.Player('video0', {
		  videoId: VidId0,
		  width: '100%',
		  height: ytVidHeight,
          playerVars: { 'autoplay': 1, 'controls': 1, 'loop': 1, 'rel': 0, 'playlist': VidId0 },
		  events: {
			  'onReady': firstPlayerMute,
			  'onStateChange': onPlayerStateChange0,
		  }
	  });
  }
  if( ytVidIds.includes('slide_1') ){
	  console.log('youtube vid init');
	  player1 = new YT.Player('video1', {
		  videoId: VidId1,
		  width: '100%',
		  height: ytVidHeight,
          playerVars: { 'autoplay': 1, 'controls': 1, 'loop': 1, 'rel': 0, 'playlist': VidId1 },
		  events: {
			  'onReady': playerMute,
			  'onStateChange': onPlayerStateChange1,
		  }
	  });
  }
  if( ytVidIds.includes('slide_2') ){
	  console.log('youtube vid init');
	  player2 = new YT.Player('video2', {
		  videoId: VidId2,
		  width: '100%',
		  height: ytVidHeight,
          playerVars: { 'autoplay': 1, 'controls': 1, 'loop': 1, 'rel': 0, 'playlist': VidId2 },
		  events: {
			  'onReady': playerMute,
			  'onStateChange': onPlayerStateChange2,
		  }
	  });
  }

	//initialize swiper slideshow
	var swiper = new Swiper('.swiper-container', {
		spaceBetween: 30,
		autoplay: 7000,
		autoplayDisableOnInteraction: false,
		effect: "fade",
		onInit: function(swiper){
			console.log('swiper init');
			//mute all non-youtube videos
			var nonYoutubeVids = document.getElementsByClassName('not-youtube');
			var ii = 0;
			for(ii = 0; ii < nonYoutubeVids.length;ii++) {
				jQuery(nonYoutubeVids[ii]).prop('muted',true);
				console.log(nonYoutubeVids[ii]+'muted');
			}
		}
	});


	//pause previous slide, play current slide
	jQuery(document).ready(function() {
		"use strict";	
		swiper.on('slideChangeStart', function () {
			
			/////////////////setup variables////////////////
			
			var prevSlide = swiper.previousIndex;
			var currentSlide = swiper.activeIndex;
			
			var prevVid = document.getElementById('video'+prevSlide);
			var currentVid = document.getElementById('video'+currentSlide);
			
			var prevVidId = 'slide_'+prevSlide; 
			var currentVidId = 'slide_'+currentSlide;
			
			var playSlideFunction = 'playSlide'+currentSlide;
			var pauseSlideFunction = 'pauseSlide'+prevSlide;
			
			//////////////pause previous play next//////////////
			
			if(ytVidIds.includes(currentVidId)){
				window[playSlideFunction]();
				console.log('current vid youtube');
			} else if(currentVid) {
				console.log('current vid not youtube');
				currentVid.play();
				
			}
			
			if(ytVidIds.includes(prevVidId)){
				window[pauseSlideFunction]();
				console.log('previous vid youtube');
			} else if(prevVid) {
				console.log('previous vid not youtube');
				prevVid.pause();
				prevVid.currentTime = 0;
				
			}

			if(panningImages.includes(currentVidId)){
				jQuery('.kenburns-true img').removeClass('kenburns');
				jQuery('.kenburns-true.swiper-slide-active img').addClass('kenburns');
			} else {
				jQuery('.kenburns-true img').removeClass('kenburns');
			}
			
			
		});
		
		//update img src
		jQuery('.slider-image').each(function(){
			var newSrc = jQuery(this).data('desktop');
			jQuery(this).attr('src',newSrc);
		})

		//ensure all images and videos cover entire slide
		var slideRatio = jQuery("#gon-video-slideshow").height()/jQuery("#gon-video-slideshow").width();
		jQuery('.slider-image, .video-poster, .slider-video').each(function(){
			var imgRatio = jQuery(this).height()/jQuery(this).width();
			console.log(this,'imgRatio'+imgRatio,'slideRatio'+slideRatio);
			if(imgRatio>slideRatio){
				jQuery(this).addClass('stretch-horz');
			} else {
				jQuery(this).addClass('stretch-vert');
			}
		});
	});
}


//mute each player on init
function playerMute(event) {
  event.target.mute();
  event.target.pauseVideo();
}
function firstPlayerMute(event){
  event.target.mute();
  player0.seekTo(0);
  // player0.playVideo();
}
	
//setup youtube pause and play functions
function playSlide0(){
	player0.playVideo();
}
function playSlide1(){
	player1.playVideo();
	//console.log('slide1 fired');
}
function playSlide2(){
	player2.playVideo();
	//console.log('slide2 fired');
}

function pauseSlide0(){
	player0.pauseVideo();
	player0.seekTo(0);
}
function pauseSlide1(){
	player1.pauseVideo();
	player1.seekTo(0);
	//console.log('slide1 paused');
}
function pauseSlide2(){
	player2.pauseVideo();
	player2.seekTo(0);
	//console.log('slide2 paused');
}

//replace video with poster while video is buffering, and back to video when it loads
function onPlayerStateChange0(event) {
  switch (event.data) {
    case YT.PlayerState.PLAYING:
      jQuery('#slide_0').removeClass('buffering');
      break;
    case YT.PlayerState.BUFFERING:
	  jQuery('#slide_0').addClass('buffering');
      break;
  }
}
	
function onPlayerStateChange1(event) {
  switch (event.data) {
    case YT.PlayerState.PLAYING:
      jQuery('#slide_1').removeClass('buffering');
      break;
    case YT.PlayerState.BUFFERING:
	  jQuery('#slide_1').addClass('buffering');
      break;
  }
}
	
function onPlayerStateChange2(event) {
  switch (event.data) {
    case YT.PlayerState.PLAYING:
      jQuery('#slide_2').removeClass('buffering');
      break;
    case YT.PlayerState.BUFFERING:
	  jQuery('#slide_2').addClass('buffering');
      break;
  }
}


// Inject YouTube API script
var tag = document.createElement('script');
tag.src = "http://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
console.log('yt script added');



	
/////////////////////////////////////////
/////////////////////////////////////////
////////*MOBILE STATIC SLIDESHOW*////////
/////////////////////////////////////////
/////////////////////////////////////////
	

} else {

	var swiper = new Swiper('.swiper-container', {
		spaceBetween: 0,
		autoplay: 6000,
		autoplayDisableOnInteraction: false,
		loop: true,
		onInit: function(mobileSwiper){
		console.log('swiper init');
		//mute all non-youtube videos
		var nonYoutubeVids = document.getElementsByClassName('not-youtube');
		var ii = 0;
		for(ii = 0; ii < nonYoutubeVids.length;ii++) {	
			jQuery(nonYoutubeVids[ii]).prop('muted',true);
			console.log(nonYoutubeVids[ii]+'muted');
			}
		}
	});

	jQuery('.video-poster').each(function(){
		var newSrc = jQuery(this).data('mobile');
		jQuery(this).attr('src',newSrc);
	})

	//correct image sizes
	if(gonWinWidth>481){
		jQuery('.slider-image').each(function(){
			var newSrc = jQuery(this).data('tablet');
			jQuery(this).attr('src',newSrc);
		})
	} else {
		jQuery('.slider-image').each(function(){
			var newSrc = jQuery(this).data('mobile');
			jQuery(this).attr('src',newSrc);
		})
	}

	// var swiper = new Swiper('.swiper-container', {
	// 	spaceBetween: 0,
	// 	autoplay: 6000,
	// 	autoplayDisableOnInteraction: false,
	// 	loop: true,
	// });  



}
	


}

//https://developers.google.com/youtube/iframe_api_reference