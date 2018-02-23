<?php

get_header();

define('POST_TYPE_NAAM', post_naam_model());

set_query_var('klassen_bij_primary', "archief archief-".POST_TYPE_NAAM);
get_template_part('/sja/open-main');

echo "<div class='verpakking'>";

	archief_titel_ctrl();

	archief_intro_ctrl();

	//generiek taxonomy blok @ klassen
	$tax_blok = new Tax_blok(array(
		'post'		=> $post,
		'titel'		=> $wp_query->queried_object->label,
		'basis'		=> get_post_type_archive_link(POST_TYPE_NAAM),
	));
	$tax_blok->print();

	archief_content_ctrl();

	paginering_ctrl();

	archief_footer_ctrl();

echo "</div>";

get_template_part('/sja/sluit-main');

get_footer();
