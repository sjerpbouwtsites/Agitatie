<?php
if (!function_exists('archief_generiek_loop')) : function archief_generiek_loop($post, $afb_formaat = 'lijst', $exc_lim_o = false){

	switch (POST_TYPE_NAAM) {
		default:
			$m_art = new Article_c( array('exc_lim' => $exc_lim_o ? $exc_lim_o : 230 ), $post);
			break;
	}

	if (isset($m_art)) {
		$m_art->afb_formaat	= $afb_formaat;
		$m_art->print();
	}

} endif;

if (!function_exists('archief_intro_ctrl')) : function archief_intro_ctrl($post_type = '', $tax_waarde = '') {
	if ($archief_intro = archief_intro_model($post_type, $tax_waarde)){
		echo apply_filters('the_content', $pag_intro);
	}
} endif;

if (!function_exists('archief_titel_ctrl')) : function archief_titel_ctrl () {

	global $wp_query;
	$archief_titel = $wp_query->queried_object->label . ($tax_waarde = gezocht_naar_tax_waarde_model() !== '' ? "<span>".$tax_waarde."</span>" : "");
	echo "<h1>$archief_titel</h1>";

} endif;


if(!function_exists('archief_content_ctrl')) : function archief_content_ctrl() {
	global $post;
	echo "<div id='archief-lijst' class='tekstveld'>";
		if ( have_posts() ) : while ( have_posts() ) : the_post();

			//maakt post type objs aan en print @ controllers
			archief_generiek_loop($post);

		endwhile; endif;
	echo "</div>";
} endif;

if(!function_exists('archief_footer_ctrl')) : function archief_footer_ctrl() {
	//indien er gezocht is op een tax val, geef dan knop terug naar archief algemeen.
	if ($tax_waarde = gezocht_naar_tax_waarde_model() !== '') :
		echo "<footer>";
		$terug = new Knop(array(
			'class' 	=> 'in-wit ikoon-links',
			'link' 		=> get_post_type_archive_link(POST_TYPE_NAAM),
			'tekst'		=> 'Alle '.$wp_query->queried_object->label,
			'ikoon'		=> 'arrow-left-thick'
		));

		$terug->print();

		echo "<footer>";
	endif; //als tax
} endif;