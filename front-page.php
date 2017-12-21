<?php

get_header();
set_query_var('klassen_bij_primary', "voorpagina");
get_template_part('/sja/open-main');

$vp_kontekst_logo = get_field('logo-vp');
$vp_leus = get_field('leus');
$vp_afb_1 = get_field('afbeelding1');
$vp_afb_2 = get_field('afbeelding2');
$vp_afb_3 = get_field('afbeelding3');
$vp_vid = get_field('video');
$vp_poster = get_field('video_poster');

?>

<div class='bg-geel' id='vp-boven'>
	<div class='verpakking'>
		<div class='flex'>
			<img id='vp-kontekst-logo' src='<?=$vp_kontekst_logo['sizes']['large']?>' alt='Studio vlaflip animaties illustraties' width='406' height='106' />
			<p id='vp-leus'><?=$vp_leus?></p>
			<div id='vp-boven-drie-afb'>
				<a class='' href='<?=SITE_URI?>/?_soort=animatie#tax-blok'>
					<img
						class='vp-boven-drie-afb-img'
						src='<?=$vp_afb_1['sizes']['medium']?>'
						alt='<?=$vp_afb_1['alt']?>'
						width='<?=$vp_afb_1['sizes']['medium-width']?>'
						height='<?=$vp_afb_1['sizes']['medium-height']?>'
						title='Bekijk mijn animaties'
					/>
				</a>
				<a class='' href='<?=SITE_URI?>/?_soort=illustratie#tax-blok'>
					<img
						class='vp-boven-drie-afb-img'
						src='<?=$vp_afb_2['sizes']['medium']?>'
						alt='<?=$vp_afb_2['alt']?>'
						width='<?=$vp_afb_2['sizes']['medium-width']?>'
						height='<?=$vp_afb_2['sizes']['medium-height']?>'
						title='Bekijk mijn illustraties'
					/>
				</a>
				<a class='' href='<?=SITE_URI?>/?_soort=infographic#tax-blok'>
					<img
						class='vp-boven-drie-afb-img'
						src='<?=$vp_afb_3['sizes']['medium']?>'
						alt='<?=$vp_afb_3['alt']?>'
						width='<?=$vp_afb_3['sizes']['medium-width']?>'
						height='<?=$vp_afb_3['sizes']['medium-height']?>'
						title='Bekijk mijn infographics'
					/>
				</a>
			</div>
		</div>
	</div>
</div>

<?php
$ingredienten = get_field('ingredienten');
ob_start();
?>

<section>
	<h2><?=get_field('vid_titel')?></h2>
	<div class='flex'>
		<?php if ($ingredienten and count($ingredienten)) : foreach ($ingredienten as $i) : ?>
			<article>
				<h3><?=$i['titel']?></h3>
				<?=apply_filters('the_content', $i['tekst'])?>
			</article>
		<?php endforeach; endif;?>
	</div>
</section>

<?php $vid_onder = ob_get_clean();

//config voor viddoos
array_naar_queryvars(array(
	'doos_id'	=> 'ingredienten',
	'vid_id'	=> 'vp-vid',
	'vid'		=> $vp_vid,
	'poster'	=> $vp_poster['sizes']['hele-breedte'],
	'vid_attr'	=> 'preload autoplay muted loop',
	'vid_onder'	=> $vid_onder
));
get_template_part('sja/viddoos');

echo "<div id='portfolio'>";
echo "<div class='verpakking'>";

$pqa = array(
	'post_type' 	=> 'portfolio',
	'post_per_page'	=> -1,
);

if (array_key_exists('_soort', $_GET)) {
	$pqa['tax_query'] = array(
		array(
			'taxonomy'	=> 'soort',
			'field'		=> 'slug',
			'terms'		=> $_GET['_soort']
		)
	);
}

$port_query = new WP_Query($pqa);

$port_init = false;

if ($port_query->have_posts()) :

	while ($port_query->have_posts()) : $port_query->the_post();

		if (!$port_init) :
			$port_init = true;
			$tax_blok = new Vla_tax_blok(array(
				'post'			=> $post,
				'titel'			=> "Portfolio" . (array_key_exists('_soort', $_GET) ? " - " . $_GET['_soort'] : ""),
				'basis'			=> site_url(),
				'archief' 	 	=> false
			));
			$tax_blok->print();

			echo "</div><div id='port-arts'>"; //einde verpakking

			$port_c = new Vla_port(array(
				'afb_formaat' => "large"
			), $post);

		endif;

		$port_c->art = $post;
		$port_c->print();

	endwhile;

endif;

wp_reset_query();
?></div>

</div><!--verpakking-->
</div>
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

</div><!--verpakking-->

<?php
get_template_part('/sja/sluit-main');
get_footer();