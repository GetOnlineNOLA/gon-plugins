// jQuery(document).ready(function(){

//   if( jQuery(window).width() < 481 ){
//     var initialRatio = jQuery('#img-container').height()/jQuery('#img-container').width();
//     console.log(initialRatio);
//     var containerWidth = jQuery(window).width()-30;
//     var containerHeight = initialRatio*containerWidth;
//     jQuery('.img img').css({'width':containerWidth,'height':containerHeight});
//     jQuery('#img-container').css({'width':containerWidth,'height':containerHeight});
//     jQuery('#mask div').css({'width':containerWidth,'height':containerHeight,'margin-top':-containerHeight});
//   }

//   jQuery('.img img').attr('draggable', false);
  
//   jQuery('#drag').on('mousedown', function(e){
//       var jQuerydragable = jQuery('#img-top'),
//           startWidth = jQuerydragable.width(),
//           pX = e.pageX;
//           jQuery('.img span').fadeOut(100);
      
//       jQuery(document).on('mouseup', function(e){
//           jQuery(document).off('mouseup').off('mousemove');
//           jQuery('.img span').fadeIn(100);
//       });
      
//   jQuery(document).on('mousemove', function(me){
//           var mx = (me.pageX - pX);          
  
//           jQuerydragable.css({
//               width: startWidth + mx,
//           });
    
    
//     var l = jQuery('.fa-arrow-left');
//     var r = jQuery('.fa-arrow-right');
    
//     if(startWidth + mx > 500){
//       r.fadeOut(100);
//       r.css('float', 'none'); 
//     }else{
//       r.fadeIn(100);        
//       r.css('float', 'right');
//     }
    
//     if(startWidth + mx < 0){
//       l.fadeOut(100);
//     }else{
//       l.fadeIn(100);  
//     }
      
//       });  
//   });
//   jQuery('#drag').on('taphold', function(e){
//     console.log('ss');
//   })

// })


jQuery(window).load(function() {
  if( jQuery(window).width() < 481 ){
    var initialRatio = jQuery('#container1').height()/jQuery('#container1').width();
    console.log(initialRatio);
    var containerWidth = jQuery(window).width()-30;
    var containerHeight = initialRatio*containerWidth;
    jQuery('#container1 img').css({'width':containerWidth,'height':containerHeight});
    jQuery('#container1').css({'width':containerWidth,'height':containerHeight});
    //jQuery('#mask div').css({'width':containerWidth,'height':containerHeight,'margin-top':-containerHeight});
  }

  jQuery("#container1").twentytwenty();
  // jQuery('twentytwenty-container')
});













