<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_logged_in();
    }

    public function index() {
        $this->beranda();
    }

    public function beranda() {
        $array = array();

        $data = array(
            'app_title' => 'Mitrasinerji Test',
            'app_heading' => 'Beranda',
            'app_content' => $this->parser->parse('pages/beranda_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

}
