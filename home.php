<?php

get_header();
set_query_var('klassen_bij_primary', "home verpakking");
get_template_part('/sja/open-main');


echo "<div class='marginveld veel'>";

echo "<h1>Nieuws</h1>";

echo "<div class='art-lijst'>";

if (have_posts()) : while (have_posts()) : the_post();

	print_lijst_ctrl($post, '3', 140);

endwhile; endif;

echo "</div>";//art-lijst

		//@ TODO @OPLEVERING ?

		$tax_blok = new Tax_blok(array(
			'post'		=> $post,
			'titel'		=> 'Zoek sneller',
		));
		$tax_blok->print();

paginering_ctrl();

echo "</div>"; //marginveld

get_template_part('/sja/sluit-main');
get_footer();
