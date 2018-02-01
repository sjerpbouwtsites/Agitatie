<?php get_template_part('head');?>

<body <?php body_class(); ?>>
<header id='stek-kop'>
	<div class='rel'>
		<div class='verpakking'>
			<div class='stek-kop-links'>

				<?php logo_contr(); ?>

			</div><!--koplinks-->

			<?php
				$fp = is_front_page();
				$nav_b = $fp ? "" : SITE_URI;
				$scr = $fp ? "schakel scroll" : "";
			?>
			<?php kop_menu_ctrl(); ?>

		</div><!--verpakking-->

	</div>
</header>


