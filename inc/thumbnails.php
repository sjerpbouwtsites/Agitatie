<?php


/***********************************************************************************************
 *    thumbnail formaat instellingen
 *
 */

function mk_tmb_frm($naam, $breedte, $hoogte, $crop = true){
    return array(
        'naam'             => $naam,
        'breedte'          => $breedte,
        'hoogte'           => $hoogte,
        'crop'             => $crop,
    );
}

//thumbnailformaten normaal alleen opvraagbaar via query. Dit maakt ze beschikbaar.
//naam //breedte //hoogte //crop

$thumbnail_formaten = array(
    'lijst'                     => mk_tmb_frm( 'lijst', 500, 275 ),
    'hele-breedte'              => mk_tmb_frm( 'hele-breedte', 2000, 1400),
    'portfolio'              => mk_tmb_frm( 'portfolio', 400, 400),
);

function thumbnail_init() {

    global $thumbnail_formaten;

    foreach ($thumbnail_formaten as $tf) {
        add_image_size($tf['naam'], $tf['breedte'], $tf['hoogte'], $tf['crop']);
    }

};

add_action( 'after_setup_theme', 'thumbnail_init' );