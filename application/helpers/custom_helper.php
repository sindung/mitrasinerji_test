<?php

function kode_nota() {
    return 'KSK';
}

function nomor_nota($param) {
    $unique = explode('-', $param);
    $nomor_nota = str_replace(kode_nota(), '', $unique[0]);

    return $nomor_nota;
}

function get_nomor_nota($nomor_nota, $print_at = '') {
    $print_at = ($print_at == '') ? date('ymd') : date('ymd', strtotime($print_at));

    return kode_nota() . $nomor_nota . '-' . $print_at;
}

function set_nomor_nota($nomor_nota) {
    return kode_nota() . $nomor_nota . '-' . date('ymd');
}
