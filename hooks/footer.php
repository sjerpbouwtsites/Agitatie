<?php
if (!function_exists('logo_in_footer_hook')) :function logo_in_footer_hook() {
	ag_logo_ctrl();
}
endif;
add_action('footer_voor_velden_action','logo_in_footer_hook', 10);