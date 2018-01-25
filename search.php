<?php
get_header();

$titel = ($_GET['s'] !== '' ? "Je zocht: ".$_GET['s'] : "Wat zoek je?");


set_query_var('klassen_bij_primary', "zoeken");
set_query_var('titel_hoog', "<h1>$titel</h1>");
get_template_part('/sja/open-main');
?>

<div class='niet-volle-breedte'>

	<!-- @TODO echte zoekwidget gebruiken -->
	<div class="widget widget_search">
		<form role="search" method="get" class="search-form" action="<?php echo site_url()?>">
			<label>
				<span class="screen-reader-text">Zoeken naar:</span>
				<input class="search-field" placeholder="Zoekterm …" value="<?=$_GET['s']?>" name="s" type="search">
			</label>
			<input class="search-submit" value="Zoeken" type="submit">
		</form>
	</div>

	<?php
	// @TODO niet hier maar via filters toevoegen aan search query
	$zoek_query_arg = array(
		'posts_per_page' => 10,
		'post_type'		=> array('post', 'page', 'menu', 'gerecht'),
	);

	if (array_key_exists('s', $_GET) and $_GET['s'] !== '') $zoek_query_arg['s'] = $_GET['s'];
	if ($paged = get_query_var( 'paged', 1 )) $zoek_query_arg['paged'] = $paged;

	$zoek_query = new WP_Query($zoek_query_arg);

	if ( $zoek_query->have_posts() ) :

		$art = new Article_c(
			array(
				'class' => "in-lijst blok",
				'htype' => 2,
				'exc_lim' => 300
			),
		$post);

		while ( $zoek_query->have_posts() ) : $zoek_query->the_post();

			$art->art = $post;
			$art->print();

		endwhile;

		paginering_ctrl();

	else :

		echo "<p>Niets gevonden! Sorry.</p>";

		$voorpagina = new Knop(array(
			'tekst'		=> 'Terug naar voorpagina',
			'link'		=> SITE_URI,
			'class'		=> 'in-wit',
		));
		$voorpagina->print();

	endif; ?>
</div>
<?php
get_template_part('/sja/sluit-main');
get_footer();
