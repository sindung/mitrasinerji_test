<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $array = array();

        $data = array(
            'app_title' => 'Mitrasinerji Test - Barang',
            'app_heading' => 'Manajemen Barang',
            'app_content' => $this->parser->parse('barang/barang_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->model_barang->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $barang) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $barang->id . '">';
            $row[] = $barang->kode;
            $row[] = $barang->nama;
            $row[] = number_format($barang->harga, 0, '', '');

            //add html for action
            $row[] = '<a class="btn btn-sm btn-outline-info mr-1 ubah-data" href="javascript:void(0)" title="Edit" data-id="' . $barang->id . '"><i class="fas fa-edit"></i></a>'
                . '<a class="btn btn-sm btn-outline-danger hapus-data" href="javascript:void(0)" title="Hapus" data-id="' . $barang->id . '"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_barang->count_all(),
            "recordsFiltered" => $this->model_barang->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->model_barang->get_by_id($id);
        $data->harga = number_format($data->harga, 0, '', '');

        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga')
        );

        $insert = $this->model_barang->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('kode'),
            'nama' => $this->input->post('nama'),
            'harga' => $this->input->post('harga')
        );

        $update = $this->model_barang->update(array('id' => $this->input->post('id')), $data);

        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id)
    {
        $this->model_barang->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_barang->delete_by_id($id);
        }
        echo json_encode(array("status" => true));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('kode') == '') {
            $data['inputerror'][] = 'kode';
            $data['error_string'][] = 'Kode tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('nama') == '') {
            $data['inputerror'][] = 'nama';
            $data['error_string'][] = 'Nama tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('harga') == '') {
            $data['inputerror'][] = 'harga';
            $data['error_string'][] = 'Harga tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function get_nama_barang()
    {
        $list = $this->model_barang->_get_barang()->result();

        $row = array();
        $row[] = "<option value=\"\">Pilih nama Barang</option>";
        foreach ($list as $barang) {
            $row[] = "<option value=\"" . $barang->id . "\">" . $barang->nama . "</option>";
        }

        echo json_encode($row);
    }

    public function get_detail_barang()
    {
        $id = $this->input->post('id');

        $result = $this->model_barang->_get_barang($id);
        $row = $result->row();

        if (isset($row)) {
            $data['harga'] = number_format($row->harga, 0, '', '');
        }


        echo json_encode($data);
    }
}
