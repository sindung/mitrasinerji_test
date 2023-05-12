<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_logged_in();
    }

    public function index() {
        $this->riwayat_penjualan();
    }

    public function riwayat_penjualan() {
        $array = array();
        $data = array(
            'app_title' => 'Mitrasinerji Test - Transaksi',
            'app_heading' => 'Riwayat Penjualan',
            'app_content' => $this->parser->parse('transaksi/riwayat_penjualan_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $list = $this->model_riwayat_transaksi->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        $total_harga = 0;
        foreach ($list as $nota) {
            $no++;
            $row = array();
            $nomor_nota_ = get_nomor_nota($nota->nomor_nota, $nota->print_at);

            $user_ = $this->model_user->get_by_user_id($nota->user_id);
            $nama_user_ = $user_->nama;

            $row[] = $no;
            $row[] = $nomor_nota_;
            $row[] = $nota->nomor_nota;
            $row[] = '<p class="text-right">' . number_format($nota->total_bayar, 0, '', '.') . '</p>';
            $row[] = '<p class="text-right">' . number_format($nota->total_harga, 0, '', '.') . '</p>';
            $row[] = '<p class="text-right">' . $nama_user_ . '</p>';
            $row[] = date('d F Y H:i:s', strtotime($nota->create_at));
            $row[] = '<button type="button" class="btn btn-sm btn-outline-info detail" data-nomor="' . $nomor_nota_ . '" data-user="' . $nota->user_id . '">Detail</button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_riwayat_transaksi->count_all(),
            "recordsFiltered" => $this->model_riwayat_transaksi->count_filtered(),
            "data" => $data,
            "total_harga" => $total_harga,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_by_nomor_nota() {
        $this->load->helper('url');

        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));
        $total_harga = 0;
        $total_bayar = 0;
        $diskon = 0;
        $tunai = 0;
        $kembali = 0;

        $nota = $this->model_riwayat_transaksi->ajax_by_nomor_nota($nomor_nota);

        if ($nota) {
            $total_harga = $nota->total_harga;
            $total_bayar = $nota->total_bayar;
            $diskon = $nota->diskon;
            $tunai = $nota->tunai;
            $kembali = $nota->kembali;
        }

        $output = array(
            "total_harga" => number_format($total_harga, 0, '', '.'),
            "total_bayar" => number_format($total_bayar, 0, '', '.'),
            "diskon" => number_format($diskon, 0, '', '.'),
            "tunai" => number_format($tunai, 0, '', '.'),
            "kembali" => number_format($kembali, 0, '', '.'),
        );
        //output to json format
        echo json_encode($output);
    }

}
