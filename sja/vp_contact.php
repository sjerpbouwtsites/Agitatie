<section id='vp-contact'>
	<div class='verpakking'>
		<div class='links'>
			<h2><?=get_field('onderblok_titel')?></h2>
			<?=apply_filters('the_content', get_field('onderblok_tekst'))?>
			<?php if ($vp_soc_m = get_field('soc_media') and count($vp_soc_m)) :
				echo "<div class='soc-media-links'>";
				foreach ($vp_soc_m as $m) :
					$l = $m['logo'];
					echo
					"<a href='{$m['link']}' target='_blank'>
						<img src='{$l['sizes']['thumbnail']}' alt='{$l['alt']}' width='150' height='150' />
					</a>";
				endforeach;
				echo "</div>";
			endif; ?>

		</div>
		<div class='rechts'>
			<?php $marjolein = get_field('foto_van_marjolein');
			echo "<img src='{$marjolein['sizes']['large']}' alt='{$marjolein['alt']}' width='{$marjolein['sizes']['large-width']}' height='{$marjolein['sizes']['large-height']}' />";
			?>
		</div>
	</div>
</section>