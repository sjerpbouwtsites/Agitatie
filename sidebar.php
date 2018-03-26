<?php

if (is_active_sidebar('sticky-sidebar')) {
	echo "<div class='verpakking'>";
		dynamic_sidebar('sticky-sidebar');
	echo "</div>";
}