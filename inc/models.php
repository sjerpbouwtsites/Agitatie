<?php

//nee het niet is niet echt mvc. Weet ik. thx. stfu. bai.
if(!function_exists('logo_model')) : function logo_model($heading) {
	ob_start();
	the_custom_logo();
	$logo = ob_get_clean();
	$logo = str_replace('</a>', '', $logo);

    $is_front = is_front_page();

    if ($is_front && $heading) $logo = "<h1>" . $logo;
	$logo .= "</a>";
    if ($is_front && $heading) $logo .= "</h1>";
	return $logo;
} endif;

if(!function_exists('paginering_model')) : function paginering_model() {

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
} endif;

if(!function_exists('agenda_filter_model')) : function agenda_filter_model(){

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
} endif;

if(!function_exists('agenda_art_meta')) : function agenda_art_meta($post) {
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
} endif;

if(!function_exists('gezocht_naar_tax_waarde_model')) : function gezocht_naar_tax_waarde_model() {
    $tax_waarde = '';
    $t = 0;

    //alleen eerste GET pakken
    if (count($_GET)) : foreach ($_GET as $n => $w) :

        $tax_waarde = str_replace('-', ' ', $w);
        if ($t > 0) break;
        $t++;
    endforeach; endif;
    return $tax_waarde;
} endif;

if (!function_exists('archief_intro_model')) : function archief_intro_model($post_type = '', $tax_waarde = '') {
    //@TODO
    return false;
} endif;

if (!function_exists('post_naam_model')) : function post_naam_model() {
    global $wp_query;

    //is query op post type?
    if (array_key_exists('post_type', $wp_query->query)) {
        return $wp_query->query['post_type'];
    } else { //neem aan: query op tax
        return $wp_query->posts[0]->post_type;
    }
} endif;