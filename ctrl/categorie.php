<?php

if(!function_exists('categorie_ctrl')) : function categorie_ctrl() {
	$cats = get_categories();

	foreach ($cats as $c) {
		if ($c->term_id === 1 || $c->count === 0) continue;

		//maskeren als post
		$a = new Article_c(array(
			'is_categorie' => true,
			'class' 	=> 'blok in-lijst',
			'htype'	=> 2,
		), $c);

		$a->print();

	}
} endif;