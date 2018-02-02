<?php

get_header();

define('POST_TYPE_NAAM', post_naam_model());

$pt_mv = $wp_query->queried_object->label;

echo "<script>console.dir(".json_encode($pt_mv).")</script>";

set_query_var('klassen_bij_primary', "archief archief-".POST_TYPE_NAAM);
get_template_part('/sja/open-main');

$pt_arch_link = get_post_type_archive_link(POST_TYPE_NAAM);

//bv category -> mediterraans @ models
$tax_waarde = gezocht_naar_tax_waarde_model();

$archief_titel = $pt_mv . ($tax_waarde !== '' ? "<span>$tax_waarde</span>" : "");

echo "<div class='verpakking'>";
echo "<h1>$archief_titel</h1>";

//@TODO STANDAARD TEKST NEERKNALLEN
archief_intro_ctrl();

//generiek taxonomy blok @ klassen
$tax_blok = new Tax_blok(array(
	'post'		=> $post,
	'titel'		=> $pt_mv,
	'basis'		=> $pt_arch_link . '?',
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
