<?php

if (!function_exists('kop_rechts')) : function kop_rechts () {
	echo "<div class='stek-kop-rechts'>";
	kop_menu_ctrl('horizontaal menu'); 
	echo "</div>";	
} endif;

add_action('kop_rechts_ctrl', 'kop_rechts');


