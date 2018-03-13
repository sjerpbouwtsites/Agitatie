<?php


if(!function_exists('ag_kop_links')) : function ag_kop_links() {

	echo "<div class='stek-kop-links'>";
		ag_logo_ctrl();
	echo "</div><!--koplinks-->";

} endif;

add_action('ag_kop_links_action', 'ag_kop_links', 10);



if (!function_exists('ag_kop_rechts')) : function ag_kop_rechts () {

	echo "<div class='stek-kop-rechts'>";
		ag_kop_menu_ctrl('horizontaal menu');
		echo "<a href='#' class='schakel kopmenu-mobiel' data-toon='#menu-kopmenu'>Menu ".mdi('menu', false).mdi('close', false)."</a>";
	echo "</div>";

} endif;

add_action('ag_kop_rechts_action', 'ag_kop_rechts', 10);