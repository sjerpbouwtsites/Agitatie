<?php

get_header();

define('POST_TYPE_NAAM', $wp_query->query['post_type']);

set_query_var('klassen_bij_primary', "menu bg-warm");
get_template_part('/sja/open-main');

$pt_arch_link = get_post_type_archive_link(POST_TYPE_NAAM);

//meervoud van huidige post type @ models
$pt_mv = post_type_mv_model();

//bv category -> mediterraans @ models
$tax_waarde = gezocht_naar_tax_waarde_model();
$archief_titel = $pt_mv . ($tax_waarde !== '' ? "<span>$tax_waarde</span>" : "");

//ACF option pagina
$pag_intro = get_field(POST_TYPE_NAAM.'_pagina_intro', 'option');
$promo_t = get_field(POST_TYPE_NAAM.'_promotie_titel', 'option');
$promo_p = get_field(POST_TYPE_NAAM.'_promotie', 'option');

echo "<div class='verpakking'>";
echo "<h1>$archief_titel</h1>";

echo apply_filters('the_content', $pag_intro);

//als niet op algemene archief pagina maar op archief + tax, dan geen promo
if ($promo_t && $promo_p && $promo_t !== '' && $promo_p !== '' && count($_GET) < 2) {
	echo "<section class='menu-gerecht-promo'>";
	echo "<h2>$promo_t</h2>";
	//maakt post type objs aan en print @ controllers
	archief_generiek_loop($promo_p, 'hele-breedte');
	echo "</section>";
}

//generiek taxonomy blok @ klassen
$tax_blok = new Tax_blok(array(
	'post'		=> $post,
	'titel'		=> "Vind jouw ".$pt_mv,
	'basis'		=> $pt_arch_link,
));
$tax_blok->print();

echo "<div id='archief-lijst' class='tekstveld'>";
	if ( have_posts() ) : while ( have_posts() ) : the_post();

		//maakt post type objs aan en print @ controllers
		archief_generiek_loop($post);

	endwhile; endif;
echo "</div>";

// @ controller
paginering_ctrl();

//indien er gezocht is op een tax val, geef dan knop terug naar archief algemeen.
if ($tax_waarde !== '') :
	echo "<footer>";
	$terug = new Knop(array(
		'class' 	=> 'in-wit ikoon-links',
		'link' 		=> $pt_arch_link,
		'tekst'		=> 'Alle '.$pt_mv,
		'ikoon'		=> 'arrow-left-thick'
	));

	$terug->print();

	echo "<footer>";
endif; //als tax
echo "</div>";

get_template_part('/sja/sluit-main');
get_footer();
