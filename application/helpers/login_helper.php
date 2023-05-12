<?php

function is_logged_in() {
    $ci = get_instance();
    if (!$ci->session->userdata('user_id')) {
        redirect('auth');
    }
}

function is_user_id() {
    $ci = get_instance();
    if (!$ci->session->userdata('user_id')) {
        return false;
    } else {
        return true;
    }
}

function get_nota() {
    $ci = get_instance();
    return $ci->session->userdata('is_nota');
}

function get_super() {
    $ci = get_instance();
    return $ci->session->userdata('is_super');
}

function get_history() {
    $ci = get_instance();
    return $ci->session->userdata('is_history');
}

function is_nota() {
    $is_nota_ = (get_nota() == '1') ? true : false;
    return $is_nota_;
}

function is_super() {
    $is_super_ = (get_super() == '1') ? true : false;
    return $is_super_;
}

function is_history() {
    $is_history_ = (get_history() == '1') ? true : false;
    return $is_history_;
}
