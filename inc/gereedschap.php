<?php
if(!function_exists('pre_dump')) : function pre_dump($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
} endif;

if(!function_exists('maak_excerpt')) : function maak_excerpt($post, $lim = 300){

	if (property_exists($post, 'post_excerpt') and $post->post_excerpt !== "") {
		return beperk_woordental($lim, $post->post_excerpt);
	} else if (property_exists($post, 'post_content')) {
		return strip_tags(beperk_woordental($lim, $post->post_content));
	} else if (property_exists($post, 'description')) {
		return strip_tags(beperk_woordental($lim, $post->description));
	} else {
		return '';
	}
} endif;

if(!function_exists('beperk_woordental')) : function beperk_woordental($lim = 300, $tekst = ''){

	$charlength = $lim;
	$r = "";

	if ( mb_strlen( $tekst ) > $charlength ) {
		$subex = mb_substr( $tekst, 0, $charlength - 3 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$r.= mb_substr( $subex, 0, $excut );
		} else {
			$r.= $subex;
		}
		$r = rtrim($r);
		$r.= '...';

		return $r;
	} else {
		return $tekst;
	}
} endif;

if(!function_exists('appendChildBefore')) : function appendChildBefore($orig, $child) {
	//werk alleen bij HTML één niveau diep.
    $expl = explode('>', $orig);
    $tag_naam = substr($expl[0], 1);
	return $expl[0] . ">$child</$tag_naam>";
} endif;

if(!function_exists('array_naar_queryvars')) : function array_naar_queryvars($ar = array()) {
	foreach ($ar as $naam => $waarde) {
		set_query_var($naam, $waarde);
	}
} endif;

if(!function_exists('pak_template_naam')) : function pak_template_naam() {
	$n = get_page_template();
	return str_replace('.php', '', str_replace(THEME_DIR . "/", '', $n));
} endif;

if(!function_exists('underscore_naar_spatie_met_hoofdletter')) : function underscore_naar_spatie_met_hoofdletter($str) {
	$r = str_replace('_', " ", $str);
	return ucfirst($r);
} endif;

if(!function_exists('cp_truthy')) : function cp_truthy ($eigenschap, $klas) {
	if (!property_exists($klas, $eigenschap)) {
		return false;
	} else if (empty($klas->$eigenschap)) {
		return false;
	} else {
		return true;
	}
} endif;

if(!function_exists('apostrophe_weg')) : function apostrophe_weg ($a) {
	$r = str_replace("'", '&apos;', $a);
	$r = str_replace('"', '&apos;', $r);
	return $r;
} endif;

if(!function_exists('voeg_attr_in')) : function voeg_attr_in ($orig='', $invoeging='') {

	$e = explode(' ', $orig);
	$e[0] = $e[0] . " " . $invoeging;
	return implode(' ', $e);

} endif;

if(!function_exists('mooie_cpt_url')) : function mooie_cpt_url($url){
	$e = explode('?', $url);
	$e2 = explode('=', $e[1]);
	$post_type = $e2[0];

	return str_replace("?$post_type=", "$post_type/", $url);
} endif;


if(!function_exists('maak_slug')) : function maak_slug($str){
    return strtolower(preg_replace('/[^A-Za-z0-9]/', "", $str));
} endif;

if(!function_exists('mdi')) : function mdi($a = '', $echo = true) {
	$r = "<i class='mdi mdi-$a'></i>";
	if ($echo) {
		echo $r;
	} else {
		return $r;
	}
} endif;

if(!function_exists('naar_rgb')) : function naar_rgb($hex = '#FFFFFF') {
	list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
	return array($r, $g, $b);
} endif;

if(!function_exists('haal_uit_get')) :

	function haal_uit_get($sleutel = '', $geef_waarde = false) {
		if (!array_key_exists($sleutel, $_GET) or $_GET[$sleutel] === '') {
			return false;
		} else {
			if ($geef_waarde) {
				return $_GET[$sleutel];
			} else {
				return true;
			}
		}
	}
endif; // functie bestaat niet