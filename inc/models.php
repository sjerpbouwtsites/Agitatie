<?php

//nee het niet is niet echt mvc. Weet ik. thx. stfu. bai.
function logo_model($heading) {
	ob_start();
	the_custom_logo();
	$logo = ob_get_clean();
	$logo = str_replace('</a>', '', $logo);

    $is_front = is_front_page();

    if ($is_front && $heading) $logo = "<h1>" . $logo;
	$logo .= "</a>";
    if ($is_front && $heading) $logo .= "</h1>";
	return $logo;
}

function paginering_model() {

    if( is_singular() && !is_search()) return false;
    global $wp_query;
    if( $wp_query->max_num_pages <= 1 ) return false;

    $m = array(
        'pagi_paged' => get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
        'pagi_max'  => intval( $wp_query->max_num_pages ),
        'pagi_links' => array()
    );

    /** Add current page to the array */
    if ( $m['pagi_paged'] >= 1 )
        $m['pagi_links'][] = $m['pagi_paged'];

    /** Add the pages around the current page to the array */
    if ( $m['pagi_paged'] >= 3 ) {
        $m['pagi_links'][] = $m['pagi_paged'] - 1;
        $m['pagi_links'][] = $m['pagi_paged'] - 2;
    }

    if ( ( $m['pagi_paged'] + 2 ) <= $m['pagi_max'] ) {
        $m['pagi_links'][] = $m['pagi_paged'] + 2;
        $m['pagi_links'][] = $m['pagi_paged'] + 1;
    }

    sort( $m['pagi_links'] );


    $m['pagi_prev_link'] = get_previous_posts_link();

    if ($m['pagi_prev_link']) $m['pagi_prev_link_res'] = appendChildBefore($m['pagi_prev_link'], "<i class='mdi mdi-arrow-left-thick'></i>");

    $m['pagi_volgende_link'] = get_next_posts_link();

    if ($m['pagi_volgende_link']) $m['pagi_volgende_link_res'] = appendChildBefore($m['pagi_volgende_link'], "<i class='mdi mdi-arrow-right-thick'></i>");

    return $m;
}

function agenda_filter_model(){

    $agenda_taxen = get_terms(array('soort', 'locatie'));
    $filters_inst = array();

    $archief = array_key_exists('archief', $_GET);

    $datum_vergelijking = ($archief ? '<' : '>=' );

    $datum_sortering = ($archief ? 'DESC' : 'ASC');

    foreach ($agenda_taxen as $at) {

        if (!array_key_exists($at->taxonomy, $filters_inst)) $filters_inst[$at->taxonomy] = array();

        $test_posts = get_posts(array(
            'posts_per_page'    => -1,
            'post_type'         => 'agenda',
            $at->taxonomy       =>  $at->slug,
           'meta_key'          => 'datum',
            'orderby'           => 'meta_value',
            'order'             => $datum_sortering,
            'meta_query'        => array(
                array(
                    'key' => 'datum',
                    'value' => date('Ymd'),
                    'type' => 'DATE',
                    'compare' => $datum_vergelijking
                )
            ),
        ));

        $print[] = array($at->taxonomy."-".$at->slug => count($test_posts));

        $test_count = count($test_posts);

        //geen lege taxen.
        if ($test_count > 0) {
            $filters_inst[$at->taxonomy][] = array(
                'slug' => $at->slug,
                'name' => ucfirst($at->name),
                'count' => $test_count
            );
        }

    }

    $filters_actief = false;

    foreach ($filters_inst as $n => $w) {
        if (array_key_exists($n, $_POST)) {
            $filters_actief = true;
            break;
        }
    }

    return array(
        'filters_actief' => $filters_actief,
        'filters_inst' => $filters_inst,
    );
}

function agenda_art_meta($post) {
    ob_start();
    $ID = $post->ID;

    ?>

    <div class="onder-afb">
        <div class="agenda-data blok artikel-meta">
            <h1><?=$post->post_title?></h1>
            <span class="datum"><?php the_field('datum', $ID);?></span>
            <span class="datum"><?php the_field('adres_tekst', $ID);?></span>
        </div>

    </div>
<?php return ob_get_clean();
}

function post_type_mv_model(){

    if (!defined('POST_TYPE_NAAM')) {
        global $post;
        define('POST_TYPE_NAAM', $post->post_type);
    }

    switch (POST_TYPE_NAAM) {
        case 'menu':
            $pt_mv = 'menu\'s';
            break;
        case 'gerecht':
            $pt_mv = 'gerechten';
            break;
        case 'vacature':
            $pt_mv = 'vacatures';
            break;
        default:
            $pt_mv = 'berichten';
            break;
    }
    return $pt_mv;
}

function gezocht_naar_tax_waarde_model() {
    $tax_waarde = '';
    $t = 0;

    //alleen eerste GET pakken
    if (count($_GET)) : foreach ($_GET as $n => $w) :

        $tax_waarde = str_replace('-', ' ', $w);

        if ($t > 0) break;
        $t++;
    endforeach; endif;
}