<?php get_template_part('head');?>

<body <?php body_class(); ?>>
<header id='stek-kop'>
	<div class='rel'>
		<div class='verpakking'>
			<div class='stek-kop-links'>

				<?php logo_ctrl(); ?>

			</div><!--koplinks-->

			<?php do_action('kop_rechts_ctrl'); ?>



		</div><!--verpakking-->

	</div>
</header>


