jQuery(document).ready(function(){
	//accrodion section
	jQuery(".faq-pair .faq-answer").css({"display":"none"});
	jQuery("a .faq-title").click(function(e){
		e.preventDefault();
		jQuery(this).children('.plus').toggle();
		jQuery(this).children('.minus').toggle();
		jQuery(this).parent().siblings(".faq-answer").slideToggle(600, 'swing', function(){console.log('i put this here to signal something');});
		jQuery(this).toggleClass("active");
	});
})