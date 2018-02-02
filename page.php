<?php

get_header();
set_query_var('klassen_bij_primary', "page strak-tegen-header");
get_template_part('/sja/open-main');

echo "<article class='bericht'>";

get_template_part('sja/uitgelichte-afbeelding-buiten');
	while ( have_posts() ) : the_post();
		echo "<div class='verpakking marginveld'>";
			the_content();
		echo "</div>";
	endwhile; // End of the loop.
echo "</article>";

get_template_part('/sja/sluit-main');
get_footer();
