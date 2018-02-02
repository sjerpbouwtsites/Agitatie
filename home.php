<?php

get_header();
set_query_var('klassen_bij_primary', "home verpakking");
get_template_part('/sja/open-main');


echo "<div class='marginveld'>";

echo "<h1>Nieuws</h1>";


if (have_posts()) : while (have_posts()) : the_post();

	if (!isset($a)) {
		$a = new Article_c(array(
			'class' 	=> 'blok in-lijst',
			'htype'		=> 2,
			'exc_lim'	=> 140
		), $post);
	} else {
		$a->art = $post;
	}


	$a->print();

endwhile; endif;

echo "</div>";

get_template_part('/sja/sluit-main');
get_footer();
