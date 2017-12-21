<?php

get_header('sectie');
set_query_var('klassen_bij_primary', "los-bericht strak-tegen-header");
get_template_part('/sja/open-main');

?>

<article class='bericht'>

		<?php

		$htype = "2";

			$thumb_id = get_post_thumbnail_id();
			$thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);

		if ((!$vid = get_field('video')) || $vid === '') {
			set_query_var('overschrijf_thumb_grootte', 'full');
			get_template_part('sja/uitgelichte-afbeelding-buiten');

		} else {

			$htype = '1';

			$verder = new Knop(array(
				'tekst'		=> 'Lees verder',
				'class'		=> 'schakel scroll',
				'link'		=> '#single-hoofd'
			));

			array_naar_queryvars(array(
				'vid'		=> $vid,
				'poster'	=> $thumb_url[0],
				'vid_attr'	=> 'preload autoplay muted loop',
			));
			get_template_part('sja/viddoos');

		}

		while ( have_posts() ) : the_post();

			$gallerij = get_field('gallerij');

			$gallerij_actief = $gallerij and count($gallerij);

			echo "<div id='single-hoofd' class='verpakking tekstveld flex ".($gallerij_actief?"met-gallerij":"zonder-gallerij")."'>";

				if ($gallerij_actief) :

					echo "<div class='links gallerij'>";

						$speelknop = new Knop(array(
							'class'		=> 'speel-video',
							'tekst'		=> 'speel',
							'ikoon'		=> 'play'
						));

						if ($gallerij) : foreach ($gallerij as $g) :

							$m = $g['mime_type'];

							if ($m === "image/jpeg" || $m === "image/png" || $m === "image/gif") {
								echo "<img src='{$g['sizes']['medium_large']}' alt='{$g['alt']}' title='{$g['title']}' width='{$g['sizes']['medium_large-width']}' height='{$g['sizes']['medium_large-height']}'/>";
							} else {
								array_naar_queryvars(array(
									'vid'		=> $g,
									'vid_attr'	=> 'loop',
									'poster'	=> $thumb_url[0],
									'vid_onder'	=> $speelknop->maak()
								));
								get_template_part('sja/viddoos');
							}


						endforeach; endif;


					echo "</div>"; //links

				endif;

				echo "<article class='".($gallerij_actief ? "rechts " : "")." single-article'><div class='single-article-sticky'>";

					if ($gallerij_actief) echo "<h$htype>".get_the_title()."</h$htype>";
					?>

					<div class='single-meta'>
						<span><strong>Datum: </strong><?=get_field('datum')?></span>
						<span><strong>Klant: </strong><?=get_field('klant')?></span>
					</div>

					<div class='single-art-hoofd'>
						<strong>Opdracht: </strong>
						<?php the_content(); ?>
					</div>


					<?php

			echo "<footer>";

			$terug_naar_overzicht = new Knop(array(
					'class' 	=> 'in-wit',
					'link'		=> site_url() . "#portfolio",
					'tekst'		=> "Terug naar overzicht",
			));

			$terug_naar_overzicht->print();

			echo "</footer>";

			echo "</div></article>"; //rechts

			echo "</div>";

		 endwhile; // End of the loop.
		?>
</article>

<?php
get_template_part('/sja/sluit-main');
get_footer();
