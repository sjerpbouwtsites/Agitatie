<?php

if(!function_exists('registreer_sidebars')) : function registreer_sidebars(){
	register_sidebar(array(
	    'name'          => __( 'footer' ),
	    'id'            => 'footer',
	    'description'   => __( 'Voeg hier widgets toe om ze te laten verschijnen in de footer. Als je niet resultaten ziet van opslaan: herladen'),
	    'before_widget' => '<section class="widget %2$s">',
	    'after_widget'  => '</section>',
	    'before_title'  => '<h3 class="widget-title">',
	    'after_title'   => '</h3>',
	));
} endif;

//add_action( 'widgets_init', 'registreer_sidebars' );

/*class Agenda_w extends WP_Widget {

    function __construct() {

    parent::__construct(
        	// Base ID of your widget
	        'agenda',

	        // Widget name will appear in UI
	        __('agenda', 'agenda_domain'),

	        // Widget description
	        array( 'description' => __( 'Zet de agenda erin.', 'krant-carousel_domain' ), )
        );

    }

    // Frontend
    public function widget($args, $instance) {

		$agenda = new Agenda(array(
			'aantal' => 5,
			'omgeving' => 'widget'
		));
		$agenda->print();


    }

    // Backend
    public function form($instance) {

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		return $instance;
	}
}

class Pag_familie_w extends WP_Widget {

    function __construct() {

    parent::__construct(
        	// Base ID of your widget
	        'Pag_familie_w',

	        // Widget name will appear in UI
	        __('pagina familie', 'pagina_familie_domain'),

	        // Widget description
	        array( 'description' => __( 'als een pagina onderdeel van een familie is wordt deze widget actief.', 'pagina_familie_domain' ), )
        );

    }

    // Frontend
    public function widget($args, $instance) {

    	$fam = new Pag_fam('Lees verder');
    	$fam->maak();
		$fam->print();

    }

    // Backend
    public function form($instance) {

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		return $instance;
	}
}


// Register and load the widget
function widget_wrap() {
    register_widget( 'agenda_w' );
    register_widget( 'pag_familie_w' );
}

add_action( 'widgets_init', 'widget_wrap' );
*/

