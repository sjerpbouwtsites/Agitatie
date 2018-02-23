<?php
get_header();

set_query_var('klassen_bij_primary', "zoeken verpakking marginveld");
set_query_var('titel_hoog', "<h1>".($_GET['s'] !== '' ? "Je zocht: ".$_GET['s'] : "Wat zoek je?")."</h1>");
get_template_part('/sja/open-main');

get_search_form();

if (have_posts()) : while (have_posts()) : the_post();

	$art = new Article_c(
		array(
			'class' => "in-lijst blok",
			'htype' => 2,
			'exc_lim' => 180
		),
	$post);

	$art->print();

	endwhile;

else :

	echo "<p>Niets gevonden! Sorry.</p>";

	$voorpagina = new Knop(array(
		'tekst'		=> 'Terug naar voorpagina',
		'link'		=> SITE_URI,
		'class'		=> 'in-wit',
	));
	$voorpagina->print();

endif;

$r = paginering_ctrl();

get_template_part('/sja/sluit-main');
get_footer();
