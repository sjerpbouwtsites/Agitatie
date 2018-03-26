<?php


if(!function_exists('ag_print_datum_ctrl')) : function ag_print_datum_ctrl() {

	global $post;

	if ($post->post_type !== 'page') {
		get_template_part('sja/datum');
	}

} endif;

add_action('ag_pagina_voor_tekst', 'ag_print_datum_ctrl', 10);