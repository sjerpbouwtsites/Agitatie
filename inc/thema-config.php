<?php

$thema_ondersteuning = array(
'post-thumbnails',
'automatic-feed-links',
'title-tag',
'html5' => array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ),
'custom-logo' => array(
	   'height'      => 101,
	   'width'       => 387,
	   'flex-width' => true,
	),
	'thumbnail_formaten' => array() //in thumbnails
);


if ( ! function_exists( 'agitatie_setup' ) ) :
	function agitatie_setup() {

		global $thema_ondersteuning;
		global $kind_menus;
		global $kind_config;

		register_nav_menus( array(
			'kop' => esc_html__( 'kop', 'agitatie' ),
			'voorpagina' => esc_html__( 'voorpagina', 'agitatie' ),
		) );


		if ($kind_menus and count($kind_menus)) : foreach ($kind_menus as $km) :
			register_nav_menus( array($km => esc_html__( $km, 'agitatie' ),) );
		endforeach; endif;


		if ($kind_config and count($kind_config)) {
			foreach ($kind_config as $k=>$w) {
				$thema_ondersteuning[$k] = $w;
			}
		}

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

add_action( 'after_setup_theme', 'agitatie_setup' );


function ag_registreer_sidebars() {
    register_sidebar( array(
        'name' 			=> __( 'footer', 'agitatie' ),
        'id' 			=> 'footer-sidebar',
        'description' 	=> __( 'Widgets worden in de footer gezet', 'agitatie' ),
        'before_widget' => '<section id="%1$s" class="footer-section %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
    ) );
}

add_action( 'widgets_init', 'ag_registreer_sidebars' );