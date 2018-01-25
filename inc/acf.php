<?php
//

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}


function my_acf_google_map_api( $api ){

	$api['key'] = 'AIzaSyBDW__wSO7mbHOr5VkRoqNR01dXY2exje0';

	return $api;

}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5a2a87f4a85e0',
	'title' => 'Footer',
	'fields' => array(
		array(
			'key' => 'field_5a2a87ff30e07',
			'label' => 'footervelden',
			'name' => 'footervelden',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5a2a881c30e08',
					'label' => 'veld',
					'name' => 'veld',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
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
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options',
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