<?php


/***********************************************************************************************
 *    thumbnail formaat instellingen
 *
 */

if(!function_exists('mk_tmb_frm')) : function mk_tmb_frm($naam, $breedte, $hoogte, $crop = true){
    return array(
        'naam'             => $naam,
        'breedte'          => $breedte,
        'hoogte'           => $hoogte,
        'crop'             => $crop,
    );
} endif;

//thumbnailformaten normaal alleen opvraagbaar via query. Dit maakt ze beschikbaar.
//naam //breedte //hoogte //crop

$thumbnail_formaten = array(
    'lijst'                     => mk_tmb_frm( 'lijst', 750, 416 ),
    'hele-breedte'              => mk_tmb_frm( 'hele-breedte', 2000, 1400),
    'bovenaan_art'              => mk_tmb_frm( 'bovenaan_art', 2000, 700),
    'portfolio'                 => mk_tmb_frm( 'portfolio', 600, 600),
);

$thumbnail_formaten = array_merge($thumbnail_formaten, $kind_thumbs);

if(!function_exists('thumbnail_init')) : function thumbnail_init() {

    global $thumbnail_formaten;

    foreach ($thumbnail_formaten as $tf) {
        add_image_size($tf['naam'], $tf['breedte'], $tf['hoogte'], $tf['crop']);
    }

}
add_action( 'after_setup_theme', 'thumbnail_init' );
endif;

