<?php

get_header();

define('POST_TYPE_NAAM', post_naam_model());

set_query_var('klassen_bij_primary', "archief verpakking archief-".POST_TYPE_NAAM);
get_template_part('/sja/open-main');

echo "<div class='marginveld veel'>";

	archief_titel_ctrl(POST_TYPE_NAAM);

	archief_intro_ctrl();

	//op post type archief tax blok boven, anders onder.

	archief_content_ctrl();

	paginering_ctrl();

	$tax_blok = new Tax_blok(array(
		'post'		=> $post,
		'titel'		=> 'Zoek sneller',
		'reset'		=> false
	));
	$tax_blok->print();


	archief_footer_ctrl();

echo "</div>";


get_template_part('/sja/sluit-main');

get_footer();
