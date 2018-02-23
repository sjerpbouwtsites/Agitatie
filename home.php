<?php

get_header();
set_query_var('klassen_bij_primary', "home verpakking");
get_template_part('/sja/open-main');


echo "<div class='marginveld'>";

echo "<h1>Nieuws</h1>";

if (have_posts()) : while (have_posts()) : the_post();

	print_lijst_ctrl($post, '2', 140);

endwhile; endif;

echo "</div>"; //marginveld

get_template_part('/sja/sluit-main');
get_footer();
