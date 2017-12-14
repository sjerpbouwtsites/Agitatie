<?php

// print
function logo_contr($print = true, $heading = true) {
	if ($print) {
		echo logo_model($heading);
	} else {
		return logo_model($heading);
	}
}

function paginering_ctrl() {

	$m = paginering_model();
	if (!$m) {
        return; //zie model
    } else {
        array_naar_queryvars($m);
        get_template_part('sja/paginering');
    }
    return $m;
}

function agenda_filter_ctrl() {

	$m = agenda_filter_model();

	array_naar_queryvars($m);

	get_template_part('sja/agenda-filter');

	return $m;

}

