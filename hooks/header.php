<?php


if(!function_exists('kop_links')) : function kop_links() {

	echo "<div class='stek-kop-links'>";
		logo_ctrl();
	echo "</div><!--koplinks-->";

} endif;

add_action('kop_links_action', 'kop_links', 10);



if (!function_exists('kop_rechts')) : function kop_rechts () {

	echo "<div class='stek-kop-rechts'>";
		kop_menu_ctrl('horizontaal menu');
		echo "<a href='#' class='schakel kopmenu-mobiel' data-toon='#menu-kopmenu'>Menu ".mdi('menu', false).mdi('close', false)."</a>";
	echo "</div>";

} endif;

add_action('kop_rechts_action', 'kop_rechts', 10);