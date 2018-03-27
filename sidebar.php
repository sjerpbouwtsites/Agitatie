<?php


	echo "<div id='sticky-sidebar' class='verpakking verpakking-klein'>";
	echo "<div class='sticky-binnen'>";
	if (is_active_sidebar('sticky-sidebar')) {
		dynamic_sidebar('sticky-sidebar');
	}
	echo "</div>";
	echo "</div>";
