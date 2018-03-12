<?php

if (!function_exists('kop_rechts')) : function kop_rechts () {
	echo "<div class='stek-kop-rechts'>";
		kop_menu_ctrl('horizontaal menu');
		echo "<a href='#' class='schakel kopmenu-mobiel' data-toon='#menu-kopmenu'>Menu ".mdi('menu', false).mdi('close', false)."</a>";
	echo "</div>";
} endif;

add_action('kop_rechts_action', 'kop_rechts');

if (!function_exists('ag_generieke_titel')) : function ag_generieke_titel () {

	global $post;
	global $wp_query;

	if ($wp_query->is_home) {
		echo "<h1>".get_the_title( get_option('page_for_posts', true) )."</h1>";
	} else if ($wp_query->is_search) {
		echo $_GET['s'] !== '' ? "Je zocht: ".$_GET['s'] : "Wat zoek je?";
	} else {
		echo "<h1>".$post->post_title."</h1>";
	}

}

endif;

add_action('ag_pagina_titel', 'ag_generieke_titel', 10);

if (!function_exists('ag_singular_taxonomieen')) : function ag_singular_taxonomieen () {

	global $post;
	global $wp_query;

	$lijst = get_object_taxonomies($post);

	$terms = wp_get_post_terms($post->ID, $lijst);

	$overslaan = array('Geen categorie');

	$tax_verz = array();

	$vervang = array(
		'category'	=> 'categorie',
		'post_tag'	=> 'tag',
		'post'		=> 'bericht'
	);


	if (count($terms)) :

		echo "<div class='marginveld verpakking bericht-tekst verpakking-klein onder-artikel-taxonomieen'>";

		$pt_n = (array_key_exists($post->post_type, $vervang) ? $vervang[$post->post_type] : $post->post_type);

		echo "<h2><span>Dit $pt_n zit in:</span></h2>";

		foreach ( $terms as $term ) :

			if (in_array($term->name, $overslaan)) continue;

			if (array_key_exists($term->taxonomy, $tax_verz)) {
				$tax_verz[$term->taxonomy][] = $term;
			} else {
				$tax_verz[$term->taxonomy] = array($term);
			}

		endforeach;

		foreach ($tax_verz as $tax_naam => $tax_groep) {

			$p = ucfirst((array_key_exists($tax_naam, $vervang) ? $vervang[$tax_naam] : $tax_naam)).": ";

			foreach ($tax_groep as $tax_waarde) {

				if (in_array($tax_waarde->name, $overslaan)) continue;

				$href = get_term_link($tax_waarde->term_id);

				$p .= "<a href='$href'>{$tax_waarde->name}</a>, ";

			}

			$p = rtrim($p, ', ');

			echo "<p class='tax tekst-zwart'>$p</p>";
		}

		echo "</div>";

	endif; //als count terms

}

endif;

add_action('ag_singular_na_artikel', 'ag_singular_taxonomieen', 10);