<?php
function logo_in_footer_hook() {
	ag_logo_ctrl();
}

add_action('footer_voor_velden_action','logo_in_footer_hook');