<?php

// print
if(!function_exists('logo_contr')) : function logo_contr($print = true, $heading = true) {
	if ($print) {
		echo logo_model($heading);
	} else {
		return logo_model($heading);
	}
} endif;

if(!function_exists('paginering_ctrl')) : function paginering_ctrl() {

	$m = paginering_model();
	if (!$m) {
        return; //zie model
    } else {
        array_naar_queryvars($m);
        get_template_part('sja/paginering');
    }
    return $m;
} endif;

if(!function_exists('paginering_ctrl')) : function agenda_filter_ctrl() {

	$m = agenda_filter_model();

	array_naar_queryvars($m);

	get_template_part('sja/agenda-filter');

	return $m;

} endif;


if(!function_exists('kop_menu_ctrl')) :  function kop_menu_ctrl(){
	get_template_part('sja/header/dummy_menu');
} endif;

if(!function_exists('foto_video_gallery_ctrl')) :  function foto_video_gallery_ctrl($css_class = '') {
	echo "<div class='$css_class gallerij'>";

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


	echo "</div>";
} endif;

if(!function_exists('tekstveld_ctrl')) :  function tekstveld_ctrl($invoer = array()){

	//als tekst leeg
	if(!array_key_exists('tekst', $invoer)) {
		global $post;
		$invoer['tekst'] = $post->post_content;
	}

	//terugval opties
	$basis_waarden = array(
		'formaat'	=> 'groot',
		'titel'		=> false,
		'titel_el'	=> 'h2'
	);

	//er in zetten
	foreach ($basis_waarden as $k => $v) {
		if (!array_key_exists($k, $invoer)) {
			$invoer[$k] = $v;
		}
	}

	if ($invoer['titel']) {
		$id = preg_replace('/[^a-zA-Z0-9\']/', '-', $invoer['titel']);
		$id = str_replace("'", '', $id);
		$id = str_replace('"', '', $id);
		$id = strtolower(rtrim($id, '-'));
		$id = "id='$id'";
	} else {
		$id = '';
	}

	$invoer['tv_id'] = $id;

	//afgeleide gegevens
	$toevoeving = array();

	if (!$invoer['titel']) {
		$toevoeving['veld_element'] = "div";
		$toevoeving['header'] = '';
	} else {
		$toevoeving['veld_element'] = "section";
		$toevoeving['header'] = "<{$invoer['titel_el']}>{$invoer['titel']}</{$invoer['titel_el']}>";
	}

	//
	$invoer['verwerkte_tekst'] = apply_filters('the_content', $invoer['tekst']);

	$template_args = array_merge($invoer, $toevoeving);

	array_naar_queryvars($template_args);

	get_template_part('sja/tekstveld');


} endif;