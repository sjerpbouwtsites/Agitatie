<?php

class Array_constr {
	function __construct($a = array()) {
		if (is_array($a)) {
			foreach ($a as $k=>$v) {
				$this->$k = $v;
			}
		} else {
			$this->naam = $a;
		}
	}
}

class Knop extends Array_constr{

	public $class, $link, $tekst, $extern, $schakel, $html;

	public function __construct ($a = array()) {
		parent::__construct($a);
	}

	public function nalopen () {
		if (!cp_truthy('ikoon', $this)) $this->ikoon = "arrow-right-thick";
		if (!cp_truthy('link', $this)) $this->link = "#";
	}

	public function maak() {
		$this->nalopen();
		$e = $this->extern ? " target='_blank' " : "";
		$this->html = "<a {$e}
				class='knop {$this->class}'
				href='{$this->link}'
				{$this->schakel}
			><span>{$this->tekst}</span><i class='mdi mdi-{$this->ikoon}'></i></a>";
		return $this->html;
	}

	public function print () {
		$this->maak();
		echo $this->html;
	}
}

class Widget_M extends Array_constr {

	public $naam, $verp_open, $verp_sluit, $gemaakt, $css_klassen, $vernietigd;

	public function __construct ($a) {
		parent::__construct($a);
	}

	public function maak() {

		if (!$this->css_klassen) $this->css_klassen = preg_replace('~[^\p{L}\p{N}]++~u', '', strtolower($this->naam));
		$this->extra_voor_verp();
		$this->verp_open = "<section class='widget $this->css_klassen'>";
		$this->verp_sluit = "</section>";
		$this->zet_inhoud();
		$this->gemaakt = true;

	}

	public function zet_inhoud() {
		$this->inhoud = "lege widget";
	}

	public function extra_voor_verp (){
		//voor kinderen om na te bewerken
	}

	public function vernietig() {
		$this->vernietigd = true;
	}

	public function print(){

		if ($this->vernietigd) return;

		if (!$this->inhoud || $this->inhoud === '') return;

		if (!$this->gemaakt) $this->maak();

		echo $this->verp_open;
		echo
		"<header><h2>{$this->naam}</h2></header>
			<div class='blok'>
			{$this->inhoud}
			</div>
		";

		echo $this->verp_sluit;
	}
}

class Zijbalk_Posts extends Widget_M {

	public function __construct ($a = array()) {
		parent::__construct($a);
	}

	public function zet_inhoud () {

		//

	}
}

class Article_c extends Array_constr{

	public $art, $gecontroleerd, $data_src;

	public function __construct ($config, $post) {
		parent::__construct($config);
		$this->art = $post;
	}

	public function test() {
		return "test";
	}

	public function controleer () {
		if ($this->gecontroleerd) return;

		//initialiseer negatieve waarden hier
		$c = array('is_categorie', 'geen_afb', 'geen_tekst', 'class');
		foreach ($c as $cc) {
			$this->$cc = property_exists($this, $cc) ? $this->$cc : false;
		}

		$this->zet_permalink();
		$this->maak_titel();

		$this->htype = cp_truthy('htype',$this) ? $this->htype : "3";
		$this->exc_lim = cp_truthy('exc_lim',$this) ? $this->exc_lim : "300";
		$this->afb_formaat = cp_truthy('afb_formaat',$this) ? $this->afb_formaat : "lijst";
	}

	public function maak_titel () {
		if ($this->is_categorie) {
			$this->art->post_title = $this->art->cat_name;
		} else {
			$this->art->post_title = beperk_woordental(30, $this->art->post_title);
		}
	}


	public function zet_permalink() {
		if ($this->is_categorie) {
			$this->permalink = get_category_link( $this->art->term_id );
		} else {
			$this->permalink = get_permalink($this->art->ID);
		}
	}

	public function print_afb () {
		if ($this->is_categorie) {
			$img_id = get_field('cat_afb', 'category_'.$this->art->term_id);
			$img = wp_get_attachment_image($img_id, $this->afb_formaat);
		} else {
			$img = get_the_post_thumbnail($this->art, $this->afb_formaat);
		}

		echo $img;

	}

	public function maak_tekst (){
		return "<p>". maak_excerpt($this->art, $this->exc_lim) . "</p>";
	}

	public function maak_artikel () {

		if (!$this->gecontroleerd) $this->controleer();

		ob_start();

		?>

		<article class="flex art-c <?=$this->class?>" <?=$this->data_src?> >

			<?php if (!$this->geen_afb) : ?>
			<div class='art-links'>
				<a href='<?=$this->permalink?>'>
					<?php $this->print_afb(); ?>
				</a>
			</div>
			<?php endif;?>

			<div class='art-rechts'>
				<a class='tekst-wit' href='<?=$this->permalink?>'>
					<h<?=$this->htype?> class='tekst-zijkleur'>
					<?=$this->art->post_title?>
					</h<?=$this->htype?>>

					<?php if (!$this->geen_tekst) :
						echo $this->maak_tekst();
					endif;  ?>
				</a>
			</div>

		</article>
		<?php
		return ob_get_clean();
	}

	public function print () {
		echo $this->maak_artikel();
	}
}



class Agenda extends Array_constr {

	public $omgeving;

	public function __construct ($a = array()) {
		parent::__construct($a);
		//filter, /omgeving, etc.
	}

	public function zet_is_widget(){
		$this->is_widget = $this->omgeving === "widget";
	}

	public function in_pagina_queryarg (){


		$this->console = [];

		$archief = array_key_exists('archief', $_POST) || array_key_exists('archief', $_GET);

		$datum_vergelijking = ($archief ? '<' : '>=' );

		$datum_sortering = ($archief ? 'DESC' : 'ASC');

		$args = array(
		    'post_type' 		=> 'agenda',
		    'post_status' 		=> 'publish',
		    'meta_key' 			=> 'datum',
			'orderby'			=> 'meta_value',
			'order'				=> $datum_sortering,
			'meta_query' 		=> array(
				array(
					'key' => 'datum',
					'value' => date('Ymd'),
					'type' => 'DATE',
					'compare' => $datum_vergelijking
				)
			),
		);

		$tax_query = array();
		$tax_namen = array('locatie', 'soort',);

		foreach ($tax_namen as $t) {
			if (array_key_exists($t, $_POST) && $_POST[$t] !== '') {
				$tax_query[] = array(
		           'taxonomy' => $t,
		           'field'    => 'slug',
		           'terms'    => $_POST[$t],
				);
			}
		}

		if (count($tax_query)) {
			$args['tax_query'] = $tax_query;
		}

		$args_paged = $args;

		$args['posts_per_page'] = -1;
		$args_paged['posts_per_page'] = $this->aantal;

		$this->query_args = array($args_paged, $args);
	}

	public function widget_queryarg () {

		$args = array(
		    'post_type' 		=> 'agenda',
		    'post_status' 		=> 'publish',
		    'posts_per_page'	=> $this->aantal,
		    'meta_key' 			=> 'datum',
			'orderby'			=> 'meta_value',
			'order'				=> 'ASC',
			'meta_query' 		=> array(
				array(
					'key' => 'datum',
					'value' => date('Ymd'),
					'type' => 'DATE',
					'compare' => '>='
				)
			),
		);

		$this->query_args = array($args, $args);
	}

	public function zet_agendastukken() {

		$this->is_widget ? $this->widget_queryarg() : $this->in_pagina_queryarg();

		$this->console[] = $this->is_widget;
		$this->console[] = $this->query_args[0];

		$this->agendastukken = get_posts($this->query_args[0]);

		$this->is_widget ? NULL : $this->zet_totaal_aantal();
	}

	public function nalopen () {
		if (!cp_truthy('aantal', $this)) $this->aantal = 5;
		if (!cp_truthy('agenda_link', $this)) $this->agenda_link = get_post_type_archive_link('agenda');
	}

	public function zet_totaal_aantal() {
		$query_voor_tellen = get_posts($this->query_args[1]);
		//echo count($query_voor_tellen) . " / " . $this->aantal . " = " . $wp_query->max_num_pages;
		global $wp_query;
	   	$wp_query->max_num_pages = ceil(count($query_voor_tellen) / $this->aantal);
	}

	public function tax_string ($post, $str = '') {
		$obj = wp_get_post_terms( $post->ID, $str);
		$r = '';
		if (count($obj)) {
			foreach ($obj as $t) {
				$r .= $t->name . ", ";
			}
		}
		$r = substr($r, 0, strlen($r) -2); //laatste ', ' eraf
		return $r;
	}

	public function print () {

		$this->zet_is_widget();
		$this->zet_agendastukken();
		$this->nalopen();

		$verpakking_el = $this->is_widget ? "section" : "div";

		?>
		<<?=$verpakking_el?> class='agenda <?=$this->omgeving?>'>
			<?=($this->omgeving==="widget" ? "<h2>Agenda</h2>" : "")?>

			<div class=''>
				<ul>
					<?php

						foreach ($this->agendastukken as $a) :

							if (!$this->is_widget) {
								$content = maak_excerpt($a, 320);
								$this->rechts = "<div class='agenda-rechts'><span>".$content."</span></div>";
							} else {
								$this->rechts = '';
							}

							$stad = $this->tax_string($a, 'locatie');
							$soort = $this->tax_string($a, 'soort');

							$afb = wp_get_attachment_image_src( get_post_thumbnail_id( $a->ID ), 'large' );


							echo
							"<li>

								<a class='flex' href='".get_the_permalink($a->ID)."'>

									<div class='agenda-links'>
										".$this->format_datum(get_field('datum', $a->ID))."
									</div>

									<div class='agenda-midden flex'>

										<span
											class='locatie'>
											$stad ".
											($this->is_widget ? "" : " - $soort") ."
										</span>

										<span class='titel' >".$a->post_title."</span>
									</div>

									{$this->rechts}

								</a>
							</li>";
						endforeach; //agendastukken

					?>

				</ul>


				<?php

				if ($this->is_widget) {
					echo "<footer>";

					$agenda_knop = new Knop(array(
						'class'=> 'in-kleur',
						'link' => $this->agenda_link,
						'tekst'=> 'Hele agenda'
					));
					$agenda_knop->print();
					echo "</footer>";
				}


				?>


			</div>
		</<?=$verpakking_el?>>
		<?php
	}

	public function format_datum ($datum) {
		//if (!$this->is_widget) return $datum;

		// 0 = dag
		// 1 = maand
		// 2 = jaar
		// 3 = tijd

		$ma_ = array(
			'jan' => '01',
			'feb' => '02',
			'mrt' => '03',
			'apr' => '04',
			'mei' => '05',
			'jun' => '06',
			'jul' => '07',
			'aug' => '08',
			'sep' => '09',
			'okt' => '10',
			'nov' => '11',
			'dec' => '12'
		);

		$expl = explode(' ', $datum);

		$expl[1] = substr($expl[1], 0, 3);

		if ($expl[1] === 'maa') $expl[1] === 'mrt';

		$jaar_en_tijd = '';

		$dt_str = $expl[2]."-".$ma_[$expl[1]]."-".$expl[0]."T".$expl[3];
		$datetime = "<time
						itemprop='startDate'
						dateTime='$dt_str'
						>$dt_str
					</time>";

		if (!$this->is_widget) {
			return "$datetime<span><span>".$expl[0]." ".$expl[1]."</span> <span>".$expl[2]."</span><span class='met-streepje'>".$expl[3]."</span></span>";
		} else {
			return "$datetime<span><span>".$expl[0] . "</span> <span>" . $expl[1] . "</span></span>";
		}

	}
}

class Pag_fam extends Zijbalk_Posts{

	public $inhoud;

	public function __construct ($a = array()) {
		parent::__construct($a);
	}

	public function extra_voor_verp () {
		$this->css_klassen = $this->css_klassen . " pag-fam";
	}

	public function zet_inhoud () {

		$post = $GLOBALS['post'];

		if ($post->post_type !== 'page') {
			return;
		}

		$this->is_kind = $post->post_parent !== 0;
		if ($this->is_kind) {
			$this->ouder = $post->post_parent;
		} else {
			$this->ouder = $post->ID;
		}

		$pagina_query = new WP_Query();
		$alle_paginas = $pagina_query->query(array('post_type' => 'page', 'posts_per_page' => '-1'));
		$this->kinderen = get_page_children( $this->ouder, $alle_paginas );

		//als er geen kinderen zijn (0 of alleen zichzelf) dan zit deze pagina niet in een familie.
		if (count($this->kinderen) < 2)  {
			$this->vernietig();
			return;
		}

		ob_start();

		$hui = ($this->ouder === $post->ID ? 'huidige' : '');

		$art = new Article_c(
			array(
				'class' => "in-lijst blok zijbalk $hui",
				'htype' => 3,
				'geen_tekst' => true,
				'in_zijbalk' => true
			),
		get_post($this->ouder));

		$art->print();


		foreach ($this->kinderen as $k) {

			$hui = ($k->ID === $post->ID ? 'huidige' : "");

			$art = new Article_c(
				array(
					'class' => "in-lijst blok zijbalk $hui",
					'htype' => 3,
					'geen_afb'	=> true,
					'geen_tekst' => true,
					'in_zijbalk' => true
				),
			get_post($k));

			$art->print();
		}

		$this->inhoud .= ob_get_clean();

	}
}

class Tax_blok extends Array_constr {

	public function __construct ($a = array()) {
		parent::__construct($a);
	}

	public function nalopen () {
		if (!cp_truthy('post', $this)) die();
		if (!cp_truthy('titel', $this)) $this->titel = "";
		if (!cp_truthy('html', $this)) $this->html = "";
		if (!cp_truthy('basis', $this)) $this->basis = $this->zet_basis();
		if (!cp_truthy('reset', $this)) $this->reset = true;
		if (!cp_truthy('archief', $this)) $this->archief = is_archive();
		if (!cp_truthy('heeft_hash', $this)) {
			$this->hash = '';
		} else {
			$this->hash = '#tax-blok';
		}
	}


	public function zet_basis() {
		$this->basis = get_post_type_archive_link($this->post->post_type);
	}

	public function verwerk_tax_naam($a) {
		if ($this->archief) {
			return $a;
		} else {
			return "_$a";
		}
	}

	public function maak_li ($tax_term, $naam){

		$href = $this->basis.$this->verwerk_tax_naam($naam)."=".$tax_term->slug."#tax-blok";
		return "<li class='$tax_term->slug'><a href='$href'>$tax_term->name</a></li>";
	}

	public function maak() {

		$this->nalopen();

		$titel = $this->titel !== '' ? "<h2>{$this->titel}</h2>" : "";

		$taxs = get_object_taxonomies($this->post, 'objects');
		$tax_en_terms = array();

		foreach ($taxs as $t) :
			$tax_en_terms[$t->name] = get_terms( $t->name, array('hide_empty' => true,) );
		endforeach;

		$linkblokken = '';

		foreach ($tax_en_terms as $naam => $waarden) :
			$linkblokken .= "<section>";
			if (count($tax_en_terms) > 1) {
				$linkblokken .= "<h3>$naam</h3>";
			}
			if (count($waarden)) :
				$linkblokken .= "<ul class='reset'>";
				if ($this->reset) {
					$linkblokken .= "<li><a href='{$this->basis}{$this->hash}'>Alles</a></li>";
				}
				foreach ($waarden as $tax_term) {
					$linkblokken .= $this->maak_li($tax_term, $naam);
				}
				$linkblokken .= "</ul>";
			endif;
			$linkblokken .= "</section>";
		endforeach;

		if ($linkblokken !== '') {
			$this->html = "

				<nav id='tax-blok'>

					$titel
					$linkblokken

				</nav>

			";
		}



	}

	public function print() {
		if (!cp_truthy('html', $this)) {
			$this->maak();
		}
		echo $this->html;
	}

}

