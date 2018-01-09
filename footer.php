<?php $voet_velden = get_field('footervelden', 'option'); if ($voet_velden and count($voet_velden)) : ?>
<footer id='stek-voet'>
	<div class='verpakking'>
		<?php
		foreach ($voet_velden as $v) :
			echo "<span>{$v['veld']}</span>";
		endforeach;?>
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
