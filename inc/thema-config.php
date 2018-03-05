<?php

if ( ! function_exists( 'zet_thema_ondersteuning' ) ) :

	$thema_ondersteuning = array(
	'post-thumbnails',
	'automatic-feed-links',
	'title-tag',
	'html5' => array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ),
	'custom-logo' => array(
		   'height'      => 101,
		   'width'       => 387,
		   'flex-width' => true,
		)
	);

	global $kind_config;

	if ($kind_config and count($kind_config)) {
		foreach ($kind_config as $k=>$w) {
			$thema_ondersteuning[$k] = $w;
		}
	}

	function zet_thema_ondersteuning(){
		global $thema_ondersteuning;
		if (count($thema_ondersteuning) > 0) {
			foreach ($thema_ondersteuning as $s=>$w) {
				if (is_array($w)) {
					add_theme_support($s, $w);
				} else {
					add_theme_support($w);
				}
			}
		}
	}
endif;

if ( ! function_exists( 'sjerpbouwtsites_setup' ) ) :
	function sjerpbouwtsites_setup() {

		// @TODO registratie menu's in één functie

		//load_theme_textdomain( 'sjerpbouwtsites', get_template_directory() . '/languages' );
		zet_thema_ondersteuning();
		register_nav_menus( array('kop' => esc_html__( 'kop', 'sjerpbouwtsites' ),) );
		register_nav_menus( array('footer' => esc_html__( 'footer', 'sjerpbouwtsites' ),) );

		global $kind_menus;
		if ($kind_menus and count($kind_menus)) : foreach ($kind_menus as $km) :
			register_nav_menus( array($km => esc_html__( $km, 'sjerpbouwtsites' ),) );
		endforeach; endif;

	}

endif;

add_action( 'after_setup_theme', 'sjerpbouwtsites_setup' );