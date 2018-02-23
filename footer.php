<?php $voet_velden = get_field('footervelden', 'option'); if ($voet_velden and count($voet_velden)) : ?>
<footer id='stek-voet'>
	<div class='verpakking'>
		<?php

		do_action('footer_voor_velden_ctrl');

		foreach ($voet_velden as $v) :

			if (array_key_exists('titel', $v) and $v['titel'] !== '' ) {
				echo "<section  class='footer-section'>
					<h3>{$v['titel']}</h3>
					".apply_filters('the_content', $v['veld'])."
				</section>";
			} else {
				echo "<div class='footer-section'>
					".apply_filters('the_content', $v['veld'])."
				</div>";
			}

		endforeach;

		do_action('footer_voor_velden_ctrl');

		?>
	</div>
</footer>
<?php
endif;
wp_footer();
?>

<script>
var BASE_URL = "<?=SITE_URI?>",
	TEMPLATE_URL = "<?=THEME_URI?>",
	IMG_URL = "<?=IMG_URI?>",
	AJAX_URL = BASE_URL + "/wp-admin/admin-ajax.php";
</script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
  </script>
</body>
</html>
