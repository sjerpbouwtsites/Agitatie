<div class='uitgelichte-afbeelding-buiten'>
	<?php
		get_template_part('sja/afb/post-afb-met-desc');
		echo "<h1>".get_the_title()."</h1>";

		$verder = new Knop(array(
			'tekst'		=> 'Lees verder',
			'class'		=> 'schakel scroll',
			'link'		=> '#single-hoofd'
		));

		echo "<div id='single-knop'>";
			$verder->print();
		echo "</div>";
	?>
</div>