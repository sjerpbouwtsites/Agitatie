<?php

get_header('sectie');
set_query_var('klassen_bij_primary', "los-bericht strak-tegen-header");
get_template_part('/sja/open-main');


echo "hier komt de single template";

get_template_part('/sja/sluit-main');
get_footer();
