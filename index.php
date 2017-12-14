<?php

get_header();
set_query_var('klassen_bij_primary', "index");
get_template_part('/sja/open-main');

get_template_part('/sja/ga-weg');

get_template_part('/sja/sluit-main');
get_footer();
