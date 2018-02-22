<?php

get_header();

set_query_var('klassen_bij_primary', "voorpagina marginveld");
get_template_part('/sja/open-main');

tekstveld_ctrl(array(
	'formaat'		=> 'klein',
	'titel' 		=> $post->post_title,
	'titel_el'		=> 'h1'
));

voorpagina_na_tekst_ctrl();

get_template_part('/sja/sluit-main');
get_footer();