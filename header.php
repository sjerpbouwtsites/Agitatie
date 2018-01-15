<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="<?=THEME_URI?>/lettertypen/materialdesignicons.css" media="all" rel="stylesheet" type="text/css" />
<?php wp_head(); ?>
<link rel="stylesheet" href="<?=THEME_URI?>/style.css">
<?php get_template_part('sja/header/google-fonts'); ?>
<meta name="format-detection" content="telephone=no"/>
</head>

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


