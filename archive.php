<?php

get_header();

define('POST_TYPE_NAAM', ag_post_naam_model());

set_query_var('klassen_bij_primary', "archief verpakking archief-".POST_TYPE_NAAM);
get_template_part('/sja/open-main');

echo "<div class='marginveld veel'>";

	do_action('ag_archief_titel_action');

	do_action('ag_archief_intro_action');

	do_action('ag_archief_content_action');

	do_action('ag_archief_na_content_action');

	do_action('ag_archief_footer_action');

echo "</div>";


get_template_part('/sja/sluit-main');

get_footer();
