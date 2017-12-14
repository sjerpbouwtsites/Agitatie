<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700,900,900i" rel="stylesheet">
<link href="<?=THEME_URI?>/lettertypen/materialdesignicons.css" media="all" rel="stylesheet" type="text/css" />
<?php wp_head(); ?>
<link rel="stylesheet" href="<?=THEME_URI?>/style.css">
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
			<div class='stek-kop-rechts flex'>
				<nav id='kop-nav' class='stek-nav'>
					<p class='menu-stuk'><a href='<?=$nav_b?>#ingredienten' class='<?=$scr?>'>Ingredi&euml;nten</a></p>
					<p class='menu-stuk'><a href='<?=$nav_b?>#portfolio' class='<?=$scr?>'>Portfolio</a></p>
					<p class='menu-stuk'><a href='<?=$nav_b?>#vp-contact' class='<?=$scr?>'>Contact</a></p>
				</nav>

			</div>

		</div><!--verpakking-->

	</div>
</header>


