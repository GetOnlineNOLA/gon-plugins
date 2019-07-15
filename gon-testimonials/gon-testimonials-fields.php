<?php

//gutenberg block
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
  'key' => 'group_5d2cd6deb9bd6',
  'title' => 'Testimonials Block',
  'fields' => array(
    array(
      'key' => 'field_5d2cd6e4291b1',
      'label' => 'Include images?',
      'name' => 'include_image',
      'type' => 'true_false',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => '',
      'default_value' => 0,
      'ui' => 0,
      'ui_on_text' => '',
      'ui_off_text' => '',
    ),
  ),
  'location' => array(
    array(
      array(
        'param' => 'block',
        'operator' => '==',
        'value' => 'acf/testimonials-block',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
  'active' => true,
  'description' => '',
));

endif;

//custom fields for review author and review source
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
  'key' => 'group_58bf07d2d12fc',
  'title' => 'Review Meta',
  'fields' => array (
    array (
      'key' => 'field_58bf07df893a3',
      'label' => 'Review Author',
      'name' => 'review_author',
      'type' => 'text',
      'instructions' => 'Who wrote this review?',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
    ),
    array (
      'key' => 'field_58c057e32f70d',
      'label' => 'Review Source',
      'name' => 'review_source',
      'type' => 'repeater',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'collapsed' => '',
      'min' => 1,
      'max' => 1,
      'layout' => 'row',
      'button_label' => '',
      'sub_fields' => array (
        array (
          'key' => 'field_58c058182f70e',
          'label' => 'Review Platform',
          'name' => 'review_platform',
          'type' => 'text',
          'instructions' => 'ex: Facebook, Yelp, etc...',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_58c058542f70f',
          'label' => 'Review Source Link',
          'name' => 'review_source_link',
          'type' => 'text',
          'instructions' => 'Copy and paste the URL of your business\'s page on whatever platform this review was written on. Ex: https://www.facebook.com/my-restaurant/',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'maxlength' => '',
        ),
      ),
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'gon_testimonials',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
  'active' => 1,
  'description' => '',
));

endif;