<?php

/*
template name: cat overzicht */

get_header();
set_query_var('klassen_bij_primary', "cats");
set_query_var('titel_hoog', "<h1>".$post->post_title."</h1>");
get_template_part('/sja/open-main');

categorie_ctrl();

get_template_part('/sja/sluit-main');
get_footer();
