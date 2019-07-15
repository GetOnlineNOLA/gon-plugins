jQuery(document).ready(function(){
	
	//if is mobile and a sidebar form exists
	var winWidth = jQuery(window).width();
	var form = jQuery('.services-menu-sidebar form');
	
	//move for below content
	if (winWidth < 769 && form.length > 0 ){
		jQuery('article.gon_services_menu .entry-content').append(form);
	}
	
});