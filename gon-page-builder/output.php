<?php

//create global variable
$combine_with_next_section = false;

//random string function
if( ! function_exists('generateRandomString') ){
	function generateRandomString($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}

//define html output functions

///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////ONE COLUMN MODULE/////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////


//one column
function one_column_section_function(){

	global $combine_with_next_section;

	//advanced variables
	$sect_ID = get_sub_field('section_id');
	$sect_class = get_sub_field('section_class');
	$row_class = get_sub_field('row_class');
	$content_width = get_sub_field('content_width');
	$column_class = get_sub_field('column_class');
	$container_class = get_sub_field('container_class');
	$column_min_height = get_sub_field('column_minimum_height');
	
	//content variables
	$column_width = get_sub_field('column_one_width');
	$column_offset = round((12-$column_width)/2,0,PHP_ROUND_HALF_DOWN);
	
	//styling variables
	$column_handle = generateRandomString();

	$style_template = get_sub_field('styling_template');
	
	if(get_sub_field('background_color')){
		$bg_color = get_sub_field('background_color');
	} else {
		$bg_color = '';
	}
	
	if(get_sub_field('background_image')){
		$bg_image = get_sub_field('background_image');
		$bg_size = get_sub_field('background_image_size');
		$bg_position = get_sub_field('background_image_position');
		$bg_repeat = get_sub_field('background_image_repeat');
	} else {
		$bg_image = '';
		$bg_size = '';
		$bg_position = '';
		$bg_repeat = '';
	}	
	if(get_sub_field('custom_text_color')){
		$header_color = get_sub_field('header_colors');
		$paragraph_color = get_sub_field('paragraph_color');
		$button_text_color = get_sub_field('button_text_color');
		$button_background = get_sub_field('button_background');
	} else {
		$header_color = '';
		$paragraph_color = '';
		$button_text_color = '';
		$button_background = '';
	}
		
	if(!$combine_with_next_section){ ?>
		<section 
			id='<?php echo $sect_ID; ?>' 
			class='page-builder <?php echo $style_template." ".$sect_class; ?>'
			<?php if($bg_color!==''||$bg_image!==''){ ?> 
				style='
				<?php if($bg_image!==""){ ?>
				background-image: url(<?php echo $bg_image["url"]; ?>);
				background-size:<?php echo $bg_size; ?>;
				background-position:<?php echo $bg_position_x." ".$bg_position_y; ?>;				
				<?php } ?>
				<?php if($bg_color!==""){ ?>
				background-color:<?php echo $bg_color; ?>;
				<?php } ?>'

			<?php } ?>
		>
	<?php }
	$combine_with_next_section = get_sub_field('combine_with_next'); ?>
	
	<style type="text/css">
		<?php if($header_color!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle; ?> h4 {
			color: <?php echo $header_color; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> p,
		section.page-builder .col-id-<?php echo $column_handle; ?> a,
		section.page-builder .col-id-<?php echo $column_handle; ?> li {
			color: <?php echo $paragraph_color; ?>;
		}
		<?php } ?>
		<?php if($button_text_color!==''&&$button_background!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle; ?> a.popupaoc-button {
			color: <?php echo $button_text_color; ?>;
			border-color: <?php echo $button_text_color; ?>;
			background-color: <?php echo $button_background; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color; ?>;
			color: <?php echo $button_background; ?>;
		}
		<?php } ?>
	</style>
	
	<div class='<?php echo $content_width; echo " ".$container_class; ?>'>
		<div class='row <?php echo $row_class; ?>'>
			<div class='pb-column entry-content col-id-<?php echo $column_handle; ?> col-sm-<?php echo $column_width; ?> col-sm-offset-<?php echo $column_offset; ?> <?php echo $column_class; ?>'>
				<?php the_sub_field('column_content'); ?>
			</div>
		</div>
	</div>
	
	<?php
	if(!$combine_with_next_section){ ?>
		</section>
	<?php }

}

///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////TWO COLUMN MODULE/////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////

function two_column_section_function(){

	global $combine_with_next_section;

	//advanced variables
	$sect_ID = get_sub_field('section_id');
	$sect_class = get_sub_field('section_class');
	$row_class = get_sub_field('row_class');
	$content_width = get_sub_field('content_width');
	$column_one_class = get_sub_field('column_one_class');
	$column_two_class = get_sub_field('column_two_class');
	$container_class = get_sub_field('container_class');
	
	//content variables
	$column_one_width = get_sub_field('column_one_width');
	$column_two_width = get_sub_field('column_two_width');
	$column_one_content = get_sub_field('column_one_content');
	$column_two_content = get_sub_field('column_two_content');
	
	//styling variables
	$column_handle1 = generateRandomString();
	$column_handle2 = generateRandomString();

	$style_template = get_sub_field('styling_template');

	if(get_sub_field('background_color')){
			$bg_color = get_sub_field('background_color');
		} else {
			$bg_color = '';
	}
	
	if(get_sub_field('background_image')){
		$bg_image = get_sub_field('background_image');
		$bg_position = get_sub_field('background_image_position');
		$bg_size = get_sub_field('background_image_size');
		$bg_repeat = get_sub_field('background_image_repeat');
	} else {
		$bg_image = '';
		$bg_position = '';
		$bg_size = '';
		$bg_repeat = '';
	}

	//col 1 custom styles
	if(have_rows('column_one_styling')): 
		while(have_rows('column_one_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color1 = get_sub_field("header_colors");
				$paragraph_color1 = get_sub_field("paragraph_colors");
				$button_text_color1 = get_sub_field("button_text_color");
				$button_background_color1 = get_sub_field("button_background_color");
				$column_background_color1 = get_sub_field("column_background_color");
				$column_background_image1 = get_sub_field("column_background_image");
				$background_image_size1 = get_sub_field("background_image_size");
				$background_image_position1 = get_sub_field("background_image_position");
				$background_image_repeat1 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color1 = '';
		$paragraph_color1 = '';
		$button_text_color1 = '';
		$button_background_color1 = '';
		$column_background_color1 = '';
		$column_background_image1 = '';
		$background_image_size1 = '';
		$background_image_position1 = '';
		$background_image_repeat1 = '';
	endif;

	//col 2 custom styles
	if(have_rows('column_two_styling')): 
		while(have_rows('column_two_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color2 = get_sub_field("header_colors");
				$paragraph_color2 = get_sub_field("paragraph_colors");
				$button_text_color2 = get_sub_field("button_text_color");
				$button_background_color2 = get_sub_field("button_background_color");
				$column_background_color2 = get_sub_field("column_background_color");
				$column_background_image2 = get_sub_field("column_background_image");
				$background_image_size2 = get_sub_field("background_image_size");
				$background_image_position2 = get_sub_field("background_image_position");
				$background_image_repeat2 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color2 = '';
		$paragraph_color2 = '';
		$button_text_color2 = '';
		$button_background_color2 = '';
		$column_background_color2 = '';
		$column_background_image2 = '';
		$background_image_size2 = '';
		$background_image_position2 = '';
		$background_image_repeat2 = '';
	endif;

	
	if(!$combine_with_next_section){ ?>
		<section 
			id='<?php echo $sect_ID; ?>' 
			class='page-builder <?php echo $style_template." ".$sect_class; ?>'
			<?php if($bg_color!==''||$bg_image!==''){ ?> 
				style='
				<?php if($bg_image!==''){ ?>background-image: url(<?php echo $bg_image["url"]; ?>);background-size:<?php echo $bg_size; ?>;background-position:<?php echo $bg_position; ?>;background-repeat:<?php echo $bg_repeat; ?>;<?php } ?>
				<?php if($bg_color!==''){ ?>background-color:<?php echo $bg_color; ?>;<?php } ?>'
			<?php } ?>
		>
	<?php }
	$combine_with_next_section = get_sub_field('combine_with_next'); ?>
	
	<style type="text/css">
		/*column 1*/
		<?php if($column_background_color1 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> {
			background-color: <?php echo $column_background_color1; ?>;
		}
		<?php } ?>
		<?php if($column_background_image1 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> {
			background-image: url(<?php echo $column_background_image1; ?>);
			background-size: <?php echo $background_image_size1; ?>;
			background-position: <?php echo $background_image_position1; ?>;
			background-repeat: <?php echo $background_image_repeat1; ?>;
		}
		<?php } ?>
		<?php if($header_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h4 {
			color: <?php echo $header_color1; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> p,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a,
		section.page-builder .col-id-<?php echo $column_handle1; ?> li {
			color: <?php echo $paragraph_color1; ?>;
		}
		<?php } ?>
		<?php if($button_text_color1!==''&&$button_background_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.popupaoc-button {
			color: <?php echo $button_text_color1; ?>;
			border-color: <?php echo $button_text_color1; ?>;
			background-color: <?php echo $button_background_color1; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color1; ?>;
			color: <?php echo $button_background_color1; ?>;
		}
		<?php } ?>
		/*column 2*/
		<?php if($column_background_color2 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> {
			background-color: <?php echo $column_background_color2; ?>;
		}
		<?php } ?>
		<?php if($column_background_image2 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> {
			background-image: url(<?php echo $column_background_image2; ?>);
			background-size: <?php echo $background_image_size2; ?>;
			background-position: <?php echo $background_image_position2; ?>;
			background-repeat: <?php echo $background_image_repeat2; ?>;
		}
		<?php } ?>
		<?php if($header_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h4 {
			color: <?php echo $header_color2; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> p,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a,
		section.page-builder .col-id-<?php echo $column_handle2; ?> li {
			color: <?php echo $paragraph_color2; ?>;
		}
		<?php } ?>
		<?php if($button_text_color2!==''&&$button_background_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.popupaoc-button {
			color: <?php echo $button_text_color2; ?>;
			border-color: <?php echo $button_text_color2; ?>;
			background-color: <?php echo $button_background_color2; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color2; ?>;
			color: <?php echo $button_background_color2; ?>;
		}
		<?php } ?>
	</style>
	
	<div class='<?php echo $content_width; echo " ".$container_class; ?>'>
		<div class='row flex <?php echo $row_class; ?>'>
			<div class='pb-column entry-content col-sm-<?php echo $column_one_width; echo " ".$column_one_class; ?> col-id-<?php echo $column_handle1; ?>'>
				<?php the_sub_field('column_one_content'); ?>
				<?php the_field('col_one_customs'); ?>
			</div>
			<div class='pb-column entry-content col-sm-<?php echo $column_two_width; echo " ".$column_two_class; ?> col-id-<?php echo $column_handle2; ?>'>
				<?php the_sub_field('column_two_content'); ?>
			</div>
		</div>
	</div>
	
	<?php
	if(!$combine_with_next_section){ ?>
		</section>
	<?php }

}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////THREE COLUMN MODULE/////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

function three_column_section_function(){

	global $combine_with_next_section;

	//advanced variables
	$sect_ID = get_sub_field('section_id');
	$sect_class = get_sub_field('section_class');
	$row_class = get_sub_field('row_class');
	$content_width = get_sub_field('content_width');
	$column_one_class = get_sub_field('column_one_class');
	$column_two_class = get_sub_field('column_two_class');
	$column_three_class = get_sub_field('column_three_class');
	$container_class = get_sub_field('container_class');
	
	//content variables
	$column_one_width = get_sub_field('column_one_width');
	$column_two_width = get_sub_field('column_two_width');
	$column_three_width = get_sub_field('column_three_width');
	$column_one_content = get_sub_field('column_one_content');
	$column_two_content = get_sub_field('column_two_content');
	$column_three_content = get_sub_field('column_three_content');
	
	//styling variables
	$column_handle1 = generateRandomString();
	$column_handle2 = generateRandomString();
	$column_handle3 = generateRandomString();

	$style_template = get_sub_field('styling_template');

	if(get_sub_field('background_color')){
			$bg_color = get_sub_field('background_color');
		} else {
			$bg_color = '';
	}
	
	if(get_sub_field('background_image')){
		$bg_image = get_sub_field('background_image');
		$bg_position = get_sub_field('background_image_position');
		$bg_size = get_sub_field('background_image_size');
		$bg_repeat = get_sub_field('background_image_repeat');
	} else {
		$bg_image = '';
		$bg_position = '';
		$bg_size = '';
		$bg_repeat = '';
	}

	//col 1 custom styles
	if(have_rows('column_one_styling')): 
		while(have_rows('column_one_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color1 = get_sub_field("header_colors");
				$paragraph_color1 = get_sub_field("paragraph_colors");
				$button_text_color1 = get_sub_field("button_text_color");
				$button_background_color1 = get_sub_field("button_background_color");
				$column_background_color1 = get_sub_field("column_background_color");
				$column_background_image1 = get_sub_field("column_background_image");
				$background_image_size1 = get_sub_field("background_image_size");
				$background_image_position1 = get_sub_field("background_image_position");
				$background_image_repeat1 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color1 = '';
		$paragraph_color1 = '';
		$button_text_color1 = '';
		$button_background_color1 = '';
		$column_background_color1 = '';
		$column_background_image1 = '';
		$background_image_size1 = '';
		$background_image_position1 = '';
		$background_image_repeat1 = '';
	endif;

	//col 2 custom styles
	if(have_rows('column_two_styling')): 
		while(have_rows('column_two_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color2 = get_sub_field("header_colors");
				$paragraph_color2 = get_sub_field("paragraph_colors");
				$button_text_color2 = get_sub_field("button_text_color");
				$button_background_color2 = get_sub_field("button_background_color");
				$column_background_color2 = get_sub_field("column_background_color");
				$column_background_image2 = get_sub_field("column_background_image");
				$background_image_size2 = get_sub_field("background_image_size");
				$background_image_position2 = get_sub_field("background_image_position");
				$background_image_repeat2 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color2 = '';
		$paragraph_color2 = '';
		$button_text_color2 = '';
		$button_background_color2 = '';
		$column_background_color2 = '';
		$column_background_image2 = '';
		$background_image_size2 = '';
		$background_image_position2 = '';
		$background_image_repeat2 = '';
	endif;

	//col 3 custom styles
	if(have_rows('column_three_styling')): 
		while(have_rows('column_three_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color3 = get_sub_field("header_colors");
				$paragraph_color3 = get_sub_field("paragraph_colors");
				$button_text_color3 = get_sub_field("button_text_color");
				$button_background_color3 = get_sub_field("button_background_color");
				$column_background_color3 = get_sub_field("column_background_color");
				$column_background_image3 = get_sub_field("column_background_image");
				$background_image_size3 = get_sub_field("background_image_size");
				$background_image_position3 = get_sub_field("background_image_position");
				$background_image_repeat3 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color3 = '';
		$paragraph_color3 = '';
		$button_text_color3 = '';
		$button_background_color3 = '';
		$column_background_color3 = '';
		$column_background_image3 = '';
		$background_image_size3 = '';
		$background_image_position3 = '';
		$background_image_repeat3 = '';
	endif;

	
	if(!$combine_with_next_section){ ?>
		<section 
			id='<?php echo $sect_ID; ?>' 
			class='page-builder <?php echo $style_template." ".$sect_class; ?>'
			<?php if($bg_color!==''||$bg_image!==''){ ?> 
				style='
				<?php if($bg_image!==''){ ?>background-image: url(<?php echo $bg_image["url"]; ?>);background-size:<?php echo $bg_size; ?>;background-position:<?php echo $bg_position; ?>;background-repeat:<?php echo $bg_repeat; ?>;<?php } ?>
				<?php if($bg_color!==''){ ?>background-color:<?php echo $bg_color; ?>;<?php } ?>'
			<?php } ?>
		>
	<?php }
	$combine_with_next_section = get_sub_field('combine_with_next'); ?>
	
	<style type="text/css">
		/*column 1*/
		<?php if($column_background_color1 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> {
			background-color: <?php echo $column_background_color1; ?>;
		}
		<?php } ?>
		<?php if($column_background_image1 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> {
			background-image: url(<?php echo $column_background_image1; ?>);
			background-size: <?php echo $background_image_size1; ?>;
			background-position: <?php echo $background_image_position1; ?>;
			background-repeat: <?php echo $background_image_repeat1; ?>;
		}
		<?php } ?>
		<?php if($header_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h4 {
			color: <?php echo $header_color1; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> p,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a,
		section.page-builder .col-id-<?php echo $column_handle1; ?> li {
			color: <?php echo $paragraph_color1; ?>;
		}
		<?php } ?>
		<?php if($button_text_color1!==''&&$button_background_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.popupaoc-button {
			color: <?php echo $button_text_color1; ?>;
			border-color: <?php echo $button_text_color1; ?>;
			background-color: <?php echo $button_background_color1; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color1; ?>;
			color: <?php echo $button_background_color1; ?>;
		}
		<?php } ?>
		/*column 2*/
		<?php if($column_background_color2 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> {
			background-color: <?php echo $column_background_color2; ?>;
		}
		<?php } ?>
		<?php if($column_background_image2 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> {
			background-image: url(<?php echo $column_background_image2; ?>);
			background-size: <?php echo $background_image_size2; ?>;
			background-position: <?php echo $background_image_position2; ?>;
			background-repeat: <?php echo $background_image_repeat2; ?>;
		}
		<?php } ?>
		<?php if($header_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h4 {
			color: <?php echo $header_color2; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> p,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a,
		section.page-builder .col-id-<?php echo $column_handle2; ?> li {
			color: <?php echo $paragraph_color2; ?>;
		}
		<?php } ?>
		<?php if($button_text_color2!==''&&$button_background_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.popupaoc-button {
			color: <?php echo $button_text_color2; ?>;
			border-color: <?php echo $button_text_color2; ?>;
			background-color: <?php echo $button_background_color2; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color2; ?>;
			color: <?php echo $button_background_color2; ?>;
		}
		<?php } ?>
		/*column 3*/
		<?php if($column_background_color3 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> {
			background-color: <?php echo $column_background_color3; ?>;
		}
		<?php } ?>
		<?php if($column_background_image3 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> {
			background-image: url(<?php echo $column_background_image3; ?>);
			background-size: <?php echo $background_image_size3; ?>;
			background-position: <?php echo $background_image_position3; ?>;
			background-repeat: <?php echo $background_image_repeat3; ?>;
		}
		<?php } ?>
		<?php if($header_color3!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle3; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle3; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle3; ?> h4 {
			color: <?php echo $header_color3; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color3!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> p,
		section.page-builder .col-id-<?php echo $column_handle3; ?> a,
		section.page-builder .col-id-<?php echo $column_handle3; ?> li {
			color: <?php echo $paragraph_color3; ?>;
		}
		<?php } ?>
		<?php if($button_text_color3!==''&&$button_background_color3!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.popupaoc-button {
			color: <?php echo $button_text_color3; ?>;
			border-color: <?php echo $button_text_color3; ?>;
			background-color: <?php echo $button_background_color3; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color3; ?>;
			color: <?php echo $button_background_color3; ?>;
		}
		<?php } ?>
	</style>
	
	<div class='<?php echo $content_width; echo " ".$container_class; ?>'>
		<div class='row flex <?php echo $row_class; ?>'>
			<div class='pb-column entry-content col-sm-<?php echo $column_one_width; echo " ".$column_one_class; ?> col-id-<?php echo $column_handle1; ?>'>
				<?php the_sub_field('column_one_content'); ?>
			</div>
			<div class='pb-column entry-content col-sm-<?php echo $column_two_width; echo " ".$column_two_class; ?> col-id-<?php echo $column_handle2; ?>'>
				<?php the_sub_field('column_two_content'); ?>
			</div>
			<div class='pb-column entry-content col-sm-<?php echo $column_three_width; echo " ".$column_three_class; ?> col-id-<?php echo $column_handle3; ?>'>
				<?php the_sub_field('column_three_content'); ?>
			</div>
		</div>
	</div>
	
	<?php
	if(!$combine_with_next_section){ ?>
		</section>
	<?php }

}

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////FOUR COLUMN MODULE/////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////

function four_column_section_function(){

	global $combine_with_next_section;

	//advanced variables
	$sect_ID = get_sub_field('section_id');
	$sect_class = get_sub_field('section_class');
	$row_class = get_sub_field('row_class');
	$content_width = get_sub_field('content_width');
	$column_one_class = get_sub_field('column_one_class');
	$column_two_class = get_sub_field('column_two_class');
	$column_three_class = get_sub_field('column_three_class');
	$column_four_class = get_sub_field('column_four_class');
	$container_class = get_sub_field('container_class');
	
	//content variables
	$column_one_content = get_sub_field('column_one_content');
	$column_two_content = get_sub_field('column_two_content');
	$column_three_content = get_sub_field('column_three_content');
	$column_four_content = get_sub_field('column_four_content');
	
	//styling variables
	$column_handle1 = generateRandomString();
	$column_handle2 = generateRandomString();
	$column_handle3 = generateRandomString();
	$column_handle4 = generateRandomString();

	$style_template = get_sub_field('styling_template');

	if(get_sub_field('background_color')){
			$bg_color = get_sub_field('background_color');
		} else {
			$bg_color = '';
	}
	
	if(get_sub_field('background_image')){
		$bg_image = get_sub_field('background_image');
		$bg_position = get_sub_field('background_image_position');
		$bg_size = get_sub_field('background_image_size');
		$bg_repeat = get_sub_field('background_image_repeat');
	} else {
		$bg_image = '';
		$bg_position = '';
		$bg_size = '';
		$bg_repeat = '';
	}

	//col 1 custom styles
	if(have_rows('column_one_styling')): 
		while(have_rows('column_one_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color1 = get_sub_field("header_colors");
				$paragraph_color1 = get_sub_field("paragraph_colors");
				$button_text_color1 = get_sub_field("button_text_color");
				$button_background_color1 = get_sub_field("button_background_color");
				$column_background_color1 = get_sub_field("column_background_color");
				$column_background_image1 = get_sub_field("column_background_image");
				$background_image_size1 = get_sub_field("background_image_size");
				$background_image_position1 = get_sub_field("background_image_position");
				$background_image_repeat1 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color1 = '';
		$paragraph_color1 = '';
		$button_text_color1 = '';
		$button_background_color1 = '';
		$column_background_color1 = '';
		$column_background_image1 = '';
		$background_image_size1 = '';
		$background_image_position1 = '';
		$background_image_repeat1 = '';
	endif;

	//col 2 custom styles
	if(have_rows('column_two_styling')): 
		while(have_rows('column_two_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color2 = get_sub_field("header_colors");
				$paragraph_color2 = get_sub_field("paragraph_colors");
				$button_text_color2 = get_sub_field("button_text_color");
				$button_background_color2 = get_sub_field("button_background_color");
				$column_background_color2 = get_sub_field("column_background_color");
				$column_background_image2 = get_sub_field("column_background_image");
				$background_image_size2 = get_sub_field("background_image_size");
				$background_image_position2 = get_sub_field("background_image_position");
				$background_image_repeat2 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color2 = '';
		$paragraph_color2 = '';
		$button_text_color2 = '';
		$button_background_color2 = '';
		$column_background_color2 = '';
		$column_background_image2 = '';
		$background_image_size2 = '';
		$background_image_position2 = '';
		$background_image_repeat2 = '';
	endif;

	//col 3 custom styles
	if(have_rows('column_three_styling')): 
		while(have_rows('column_three_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color3 = get_sub_field("header_colors");
				$paragraph_color3 = get_sub_field("paragraph_colors");
				$button_text_color3 = get_sub_field("button_text_color");
				$button_background_color3 = get_sub_field("button_background_color");
				$column_background_color3 = get_sub_field("column_background_color");
				$column_background_image3 = get_sub_field("column_background_image");
				$background_image_size3 = get_sub_field("background_image_size");
				$background_image_position3 = get_sub_field("background_image_position");
				$background_image_repeat3 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color3 = '';
		$paragraph_color3 = '';
		$button_text_color3 = '';
		$button_background_color3 = '';
		$column_background_color3 = '';
		$column_background_image3 = '';
		$background_image_size3 = '';
		$background_image_position3 = '';
		$background_image_repeat3 = '';
	endif;

	//col 4 custom styles
	if(have_rows('column_four_styling')): 
		while(have_rows('column_four_styling')): the_row();
			if(get_sub_field("use_custom_styles")){
				$header_color4 = get_sub_field("header_colors");
				$paragraph_color4 = get_sub_field("paragraph_colors");
				$button_text_color4 = get_sub_field("button_text_color");
				$button_background_color4 = get_sub_field("button_background_color");
				$column_background_color4 = get_sub_field("column_background_color");
				$column_background_image4 = get_sub_field("column_background_image");
				$background_image_size4 = get_sub_field("background_image_size");
				$background_image_position4 = get_sub_field("background_image_position");
				$background_image_repeat4 = get_sub_field("background_image_repeat");
			} 
		endwhile;
	else:
		$header_color4 = '';
		$paragraph_color4 = '';
		$button_text_color4 = '';
		$button_background_color4 = '';
		$column_background_color4 = '';
		$column_background_image4 = '';
		$background_image_size4 = '';
		$background_image_position4 = '';
		$background_image_repeat4 = '';
	endif;

	
	if(!$combine_with_next_section){ ?>
		<section 
			id='<?php echo $sect_ID; ?>' 
			class='page-builder <?php echo $style_template." ".$sect_class; ?>'
			<?php if($bg_color!==''||$bg_image!==''){ ?> 
				style='
				<?php if($bg_image!==''){ ?>background-image: url(<?php echo $bg_image["url"]; ?>);background-size:<?php echo $bg_size; ?>;background-position:<?php echo $bg_position; ?>;background-repeat:<?php echo $bg_repeat; ?>;<?php } ?>
				<?php if($bg_color!==''){ ?>background-color:<?php echo $bg_color; ?>;<?php } ?>'
			<?php } ?>
		>
	<?php }
	$combine_with_next_section = get_sub_field('combine_with_next'); ?>
	
	<style type="text/css">
		/*column 1*/
		<?php if($column_background_color1 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> {
			background-color: <?php echo $column_background_color1; ?>;
		}
		<?php } ?>
		<?php if($column_background_image1 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> {
			background-image: url(<?php echo $column_background_image1; ?>);
			background-size: <?php echo $background_image_size1; ?>;
			background-position: <?php echo $background_image_position1; ?>;
			background-repeat: <?php echo $background_image_repeat1; ?>;
		}
		<?php } ?>
		<?php if($header_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle1; ?> h4 {
			color: <?php echo $header_color1; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> p,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a,
		section.page-builder .col-id-<?php echo $column_handle1; ?> li {
			color: <?php echo $paragraph_color1; ?>;
		}
		<?php } ?>
		<?php if($button_text_color1!==''&&$button_background_color1!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.popupaoc-button {
			color: <?php echo $button_text_color1; ?>;
			border-color: <?php echo $button_text_color1; ?>;
			background-color: <?php echo $button_background_color1; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle1; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color1; ?>;
			color: <?php echo $button_background_color1; ?>;
		}
		<?php } ?>
		/*column 2*/
		<?php if($column_background_color2 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> {
			background-color: <?php echo $column_background_color2; ?>;
		}
		<?php } ?>
		<?php if($column_background_image2 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> {
			background-image: url(<?php echo $column_background_image2; ?>);
			background-size: <?php echo $background_image_size2; ?>;
			background-position: <?php echo $background_image_position2; ?>;
			background-repeat: <?php echo $background_image_repeat2; ?>;
		}
		<?php } ?>
		<?php if($header_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle2; ?> h4 {
			color: <?php echo $header_color2; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> p,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a,
		section.page-builder .col-id-<?php echo $column_handle2; ?> li {
			color: <?php echo $paragraph_color2; ?>;
		}
		<?php } ?>
		<?php if($button_text_color2!==''&&$button_background_color2!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.popupaoc-button {
			color: <?php echo $button_text_color2; ?>;
			border-color: <?php echo $button_text_color2; ?>;
			background-color: <?php echo $button_background_color2; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle2; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color2; ?>;
			color: <?php echo $button_background_color2; ?>;
		}
		<?php } ?>
		/*column 3*/
		<?php if($column_background_color3 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> {
			background-color: <?php echo $column_background_color3; ?>;
		}
		<?php } ?>
		<?php if($column_background_image3 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> {
			background-image: url(<?php echo $column_background_image3; ?>);
			background-size: <?php echo $background_image_size3; ?>;
			background-position: <?php echo $background_image_position3; ?>;
			background-repeat: <?php echo $background_image_repeat3; ?>;
		}
		<?php } ?>
		<?php if($header_color3!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle3; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle3; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle3; ?> h4 {
			color: <?php echo $header_color3; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color3!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> p,
		section.page-builder .col-id-<?php echo $column_handle3; ?> a,
		section.page-builder .col-id-<?php echo $column_handle3; ?> li {
			color: <?php echo $paragraph_color3; ?>;
		}
		<?php } ?>
		<?php if($button_text_color3!==''&&$button_background_color3!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.popupaoc-button {
			color: <?php echo $button_text_color3; ?>;
			border-color: <?php echo $button_text_color3; ?>;
			background-color: <?php echo $button_background_color3; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle3; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color3; ?>;
			color: <?php echo $button_background_color3; ?>;
		}
		<?php } ?>
		/*column 4*/
		<?php if($column_background_color4 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle4; ?> {
			background-color: <?php echo $column_background_color4; ?>;
		}
		<?php } ?>
		<?php if($column_background_image4 !== ''){ ?>
		section.page-builder .col-id-<?php echo $column_handle4; ?> {
			background-image: url(<?php echo $column_background_image4; ?>);
			background-size: <?php echo $background_image_size4; ?>;
			background-position: <?php echo $background_image_position4; ?>;
			background-repeat: <?php echo $background_image_repeat4; ?>;
		}
		<?php } ?>
		<?php if($header_color4!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle4; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle4; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle4; ?> h4,
		section.page-builder .col-id-<?php echo $column_handle4; ?> h4 {
			color: <?php echo $header_color4; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color4!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle4; ?> p,
		section.page-builder .col-id-<?php echo $column_handle4; ?> a,
		section.page-builder .col-id-<?php echo $column_handle4; ?> li {
			color: <?php echo $paragraph_color4; ?>;
		}
		<?php } ?>
		<?php if($button_text_color4!==''&&$button_background_color4!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle4; ?> a.button,
		section.page-builder .col-id-<?php echo $column_handle4; ?> a.popupaoc-button {
			color: <?php echo $button_text_color4; ?>;
			border-color: <?php echo $button_text_color4; ?>;
			background-color: <?php echo $button_background_color4; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle4; ?> a.button:hover,
		section.page-builder .col-id-<?php echo $column_handle4; ?> a.popupaoc-button:hover {
			background-color: <?php echo $button_text_color4; ?>;
			color: <?php echo $button_background_color4; ?>;
		}
		<?php } ?>
	</style>
	
	<div class='<?php echo $content_width; echo " ".$container_class; ?>'>
		<div class='row flex <?php echo $row_class; ?>'>
			<div class='pb-column entry-content col-sm-3 <?php echo $column_one_class; ?> col-id-<?php echo $column_handle1; ?>'>
				<?php the_sub_field('column_one_content'); ?>
			</div>
			<div class='pb-column entry-content col-sm-3 <?php echo $column_two_class; ?> col-id-<?php echo $column_handle2; ?>'>
				<?php the_sub_field('column_two_content'); ?>
			</div>
			<div class='pb-column entry-content col-sm-3 <?php echo $column_three_class; ?> col-id-<?php echo $column_handle3; ?>'>
				<?php the_sub_field('column_three_content'); ?>
			</div>
			<div class='pb-column entry-content col-sm-3 <?php echo $column_four_class; ?> col-id-<?php echo $column_handle4; ?>'>
				<?php the_sub_field('column_four_content'); ?>
			</div>
		</div>
	</div>
	
	<?php
	if(!$combine_with_next_section){ ?>
		</section>
	<?php }

}


/*MEET THE TEAM MODULE*/
function meet_the_team_module_function(){

	global $combine_with_next_section;
	if($combine_with_next_section){ ?>
		</section>
	<?php }

	$mtt_posts = get_sub_field('mtt_team_members');

	?>

	<section class='page-builder' id="gon_meet_the_team">

		<div class='container'>
			<h2 class='section-title'><?php the_sub_field('section_title'); ?></h2>
			<div class='row'>
				<div class='swiper-container' id='mtt_slider'>
					<div id='swiper-kill'>x</div>
					<div class='swiper-wrapper'>
						<?php if($mtt_posts):
							foreach( $mtt_posts as $p ){ ?>
								<div class='swiper-slide'>
									<div class='slide-content-container'>
										<div class='col-md-4 text-center'>
											<?php 
												echo get_the_post_thumbnail( $p->ID, 'medium' );
												echo '<h3 class="mtt_employee">'.get_the_title( $p->ID ).'</h3>'; 
												echo '<h4 class="mtt_job_title">'.get_field('degination',$p->ID).'</h4>';
											?>
										</div>
										<div class='col-md-8'>
											<?php 
											echo apply_filters('the_content', get_post_field('post_content', $p->ID));
											//echo get_post_field('post_content', $p->ID); ?>
										</div>
									</div>
								</div>
								<?php
							}
						endif; ?>
					</div>
					<div class="swiper-button-prev"></div>
    				<div class="swiper-button-next"></div>
				</div>
				<div id='mtt_tiles'>
					<?php if($mtt_posts): $i=0;
						foreach( $mtt_posts as $p ){ ?>

							<a href="#/" class='mtt_link' data-slide-index='<?php echo $i; ?>'>
								<div class='gon-square-tile'>
									<?php echo get_the_post_thumbnail( $p->ID , 'headshot'); ?>
									<div class='gon-square-tile-inner'>
										<div class='team-inner'>
											<h4><?php echo get_the_title( $p->ID ); ?></h4>
											<p><?php the_field('degination',$p->ID); ?></p>
											<img src='<?php echo get_template_directory_uri() ?>/images/mttplus.png'>
										</div>
									</div>
								</div>
							</a>

							<?php $i++;
						}
					endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/*CASE STUDIES GRID MODULE*/
function two_column_section_with_grid_function(){

	global $combine_with_next_section;

	//advanced variables
	$sect_ID = get_sub_field('section_id');
	$sect_class = get_sub_field('section_class');
	$row_class = get_sub_field('row_class');
	$content_width = get_sub_field('content_width');
	$column_class = get_sub_field('column_class');
	$grid_class = get_sub_field('grid_class');
	$container_class = get_sub_field('container_class');
	
	//content variables
	$column_width = get_sub_field('column_width');
	$grid_width = get_sub_field('grid_width');
	$column_content = get_sub_field('column_content');
	if( have_rows('grid_content') ): 
		while( have_rows('grid_content') ): the_row();
			$grid_content = true;
			$tl_img = get_sub_field('top_left_image');
			$tr_img = get_sub_field('top_right_image');
			$bl_img = get_sub_field('bottom_left_image');
			$br_img = get_sub_field('bottom_right_image');
			$tl_background = get_sub_field('top_left_background');
			$tr_background = get_sub_field('top_right_background');
			$bl_background = get_sub_field('bottom_left_background');
			$br_background = get_sub_field('bottom_right_background');
			$tl_text = get_sub_field('top_left_text');
			$tr_text = get_sub_field('top_right_text');
			$bl_text = get_sub_field('bottom_left_text');
			$br_text = get_sub_field('bottom_right_text');
		endwhile; 
		else: $grid_content = false; endif;
	
	//styling variables
	$column_handle = generateRandomString();

	$style_template = get_sub_field('styling_template');

	if(get_sub_field('background_color')){
			$bg_color = get_sub_field('background_color');
		} else {
			$bg_color = '';
	}
	
	if(get_sub_field('background_image')){
		$bg_image = get_sub_field('background_image');
	} else {
		$bg_image = '';
	}

	if(get_sub_field('custom_text_color')){
		$header_color = get_sub_field('header_colors');
		$paragraph_color = get_sub_field('paragraph_color');
		$button_text_color = get_sub_field('button_text_color');
		$button_background = get_sub_field('button_background');
	} else {
		$header_color = '';
		$paragraph_color = '';
		$button_text_color = '';
		$button_background = '';
	}
	
	if(!$combine_with_next_section){ ?>
		<section 
			id='<?php echo $sect_ID; ?>' 
			class='page-builder <?php echo $style_template." ".$sect_class; ?>'
			<?php if($bg_color!==''||$bg_image!==''){ ?> 
				style='
				<?php if($bg_image!==''){ ?>background-image: url(<?php echo $bg_image["url"]; ?>);<?php } ?>
				<?php if($bg_color!==''){ ?>background-color:<?php echo $bg_color; ?>;<?php } ?>'
			<?php } ?>
		>
	<?php }
	$combine_with_next_section = get_sub_field('combine_with_next'); ?>
	
	<style type="text/css">
		<?php if($header_color!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle; ?> h4 {
			color: <?php echo $header_color; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> p,
		section.page-builder .col-id-<?php echo $column_handle; ?> a,
		section.page-builder .col-id-<?php echo $column_handle; ?> li {
			color: <?php echo $paragraph_color; ?>;
		}
		<?php } ?>
		<?php if($button_text_color!==''&&$button_background!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> a.button {
			color: <?php echo $button_text_color; ?>;
			border-color: <?php echo $button_text_color; ?>;
			background-color: <?php echo $button_background; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle; ?> a.button:hover {
			background-color: <?php echo $button_text_color; ?>;
			color: <?php echo $button_background; ?>;
		}
		<?php } ?>
	</style>
	
	<div class='<?php echo $content_width; echo " ".$container_class; ?>'>
		<div class='row flex <?php echo $row_class; ?>'>
			<div class='pb-column entry-content col-sm-<?php echo $column_width; echo " ".$column_class; ?> col-id-<?php echo $column_handle; ?>'>
				<?php the_sub_field('column_content'); ?>
			</div>
			<div class='pb-column entry-content pb-grid-column col-sm-<?php echo $grid_width; echo " ".$grid_class; ?> col-id-<?php echo $column_handle; ?>'>
				<?php if($grid_content){ ?>
					<div class="row flex">
						<div class='gon-grid-tl gon-grid-tile' style='<?php if($tl_background){ echo "background-color:" . $tl_background . ";"; } ?>'>
							<?php if($tl_img){ ?><img src='<?php echo $tl_img["sizes"]["medium-square-crop"]; ?>'><?php } ?>
							<div class='grid-tile-inner'><?php if($tl_text){ echo $tl_text; } ?></div>
						</div>
						<div class='gon-grid-tr gon-grid-tile' style='<?php if($tr_background){ echo "background-color:" . $tr_background . ";"; } ?>'>
							<?php if($tr_img){ ?><img src='<?php echo $tr_img["sizes"]["medium-square-crop"]; ?>'><?php } ?>
							<div class='grid-tile-inner'><?php if($tr_text){ echo $tr_text; } ?></div>
						</div>
					</div>
					<div class="row flex">
						<div class='gon-grid-bl gon-grid-tile' style='<?php if($bl_background){ echo "background-color:" . $bl_background . ";"; } ?>'>
							<?php if($bl_img){ ?><img src='<?php echo $bl_img["sizes"]["medium-square-crop"]; ?>'><?php } ?>
							<div class='grid-tile-inner'><?php if($bl_text){ echo $bl_text; } ?></div>
						</div>
						<div class='gon-grid-br gon-grid-tile' style='<?php if($br_background){ echo "background-color:" . $br_background . ";"; } ?>'>
							<?php if($br_img){ ?><img src='<?php echo $br_img["sizes"]["medium-square-crop"]; ?>'><?php } ?>
							<div class='grid-tile-inner'><?php if($br_text){ echo $br_text; } ?></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<?php
	if(!$combine_with_next_section){ ?>
		</section>
	<?php }

}



function repeatable_qa_function(){

	global $combine_with_next_section;

	//advanced variables
	$sect_ID = get_sub_field('section_id');
	$sect_class = get_sub_field('section_class');
	$row_class = get_sub_field('row_class');
	$content_width = get_sub_field('content_width');
	$column_class = get_sub_field('column_class');
	$container_class = get_sub_field('container_class');
	$column_min_height = get_sub_field('column_minimum_height');
	
	//content variables
	$column_width = get_sub_field('column_one_width');
	$column_offset = round((12-$column_width)/2,0,PHP_ROUND_HALF_DOWN);
	
	//styling variables
	$column_handle = generateRandomString();

	$style_template = get_sub_field('styling_template');
	
	if(get_sub_field('background_color')){
		$bg_color = get_sub_field('background_color');
	} else {
		$bg_color = '';
	}
	
	if(get_sub_field('background_image')){
		$bg_image = get_sub_field('background_image');
		$bg_size = get_sub_field('background_image_size');
		$bg_position = get_sub_field('background_image_position');
		$bg_repeat = get_sub_field('background_image_repeat');
	} else {
		$bg_image = '';
		$bg_size = '';
		$bg_position = '';
		$bg_repeat = '';
	}	
	if(get_sub_field('custom_text_color')){
		$header_color = get_sub_field('header_colors');
		$paragraph_color = get_sub_field('paragraph_color');
		$button_text_color = get_sub_field('button_text_color');
		$button_background = get_sub_field('button_background');
	} else {
		$header_color = '';
		$paragraph_color = '';
		$button_text_color = '';
		$button_background = '';
	}
		
	if(!$combine_with_next_section){ ?>
		<section 
			id='<?php echo $sect_ID; ?>' 
			class='page-builder <?php echo $style_template." ".$sect_class; ?>'
			<?php if($bg_color!==''||$bg_image!==''){ ?> 
				style='
				<?php if($bg_image!==""){ ?>
				background-image: url(<?php echo $bg_image["url"]; ?>);
				background-size:<?php echo $bg_size; ?>;
				background-position:<?php echo $bg_position_x." ".$bg_position_y; ?>;				
				<?php } ?>
				<?php if($bg_color!==""){ ?>
				background-color:<?php echo $bg_color; ?>;
				<?php } ?>'

			<?php } ?>
		>
	<?php }
	$combine_with_next_section = get_sub_field('combine_with_next'); ?>
	
	<style type="text/css">
		<?php if($header_color!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> h1,
		section.page-builder .col-id-<?php echo $column_handle; ?> h2,
		section.page-builder .col-id-<?php echo $column_handle; ?> h3,
		section.page-builder .col-id-<?php echo $column_handle; ?> h4 {
			color: <?php echo $header_color; ?>;
		}
		<?php } ?>
		<?php if($paragraph_color!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> p,
		section.page-builder .col-id-<?php echo $column_handle; ?> a,
		section.page-builder .col-id-<?php echo $column_handle; ?> li {
			color: <?php echo $paragraph_color; ?>;
		}
		<?php } ?>
		<?php if($button_text_color!==''&&$button_background!==''){ ?>
		section.page-builder .col-id-<?php echo $column_handle; ?> a.button {
			color: <?php echo $button_text_color; ?>;
			border-color: <?php echo $button_text_color; ?>;
			background-color: <?php echo $button_background; ?>;
		}
		section.page-builder .col-id-<?php echo $column_handle; ?> a.button:hover {
			background-color: <?php echo $button_text_color; ?>;
			color: <?php echo $button_background; ?>;
		}
		<?php } ?>
	</style>
	
	<div class='<?php echo $content_width; echo " ".$container_class; ?>'>
		<div class='row <?php echo $row_class; ?>'>
			<div class='pb-column entry-content col-id-<?php echo $column_handle; ?> col-sm-<?php echo $column_width; ?> col-sm-offset-<?php echo $column_offset; ?> <?php echo $column_class; ?>'>

				<?php if(have_rows('repeatable_qa')): while(have_rows('repeatable_qa')): the_row(); ?>
					<div class="gon-faq faq-pair">
		                <a href="#/" style="text-decoration:none;">
		                	<h2 class="entry-title faq-title faq-question">
				                <span class="plus">+</span><span class="minus" style="display:none;">-</span>
				                <?php the_sub_field('qa_title'); ?>
				            </h2>
				        </a>
						<div class="faq-answer">
							<?php the_sub_field('qa_answer'); ?>
						</div>
					</div>
				 <?php endwhile; endif; ?>

			</div>
		</div>
	</div>
	
	<?php
	if(!$combine_with_next_section){ ?>
		</section>
	<?php }
}















