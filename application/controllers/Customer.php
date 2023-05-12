<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
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
            'app_title' => 'Mitrasinerji Test - Customer',
            'app_heading' => 'Manajemen Customer',
            'app_content' => $this->parser->parse('customer/customer_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->model_customer->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $customer) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $customer->id . '">';
            $row[] = $customer->kode;
            $row[] = $customer->name;
            $row[] = $customer->telp;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-outline-info mr-1 ubah-data" href="javascript:void(0)" title="Edit" data-id="' . $customer->id . '"><i class="fas fa-edit"></i></a>'
                . '<a class="btn btn-sm btn-outline-danger hapus-data" href="javascript:void(0)" title="Hapus" data-id="' . $customer->id . '"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_customer->count_all(),
            "recordsFiltered" => $this->model_customer->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->model_customer->get_by_id($id);

        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('kode'),
            'name' => $this->input->post('name'),
            'telp' => $this->input->post('telp')
        );

        $insert = $this->model_customer->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('kode'),
            'name' => $this->input->post('name'),
            'telp' => $this->input->post('telp')
        );

        $update = $this->model_customer->update(array('id' => $this->input->post('id')), $data);

        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id)
    {
        $this->model_customer->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_customer->delete_by_id($id);
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

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Nama tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('telp') == '') {
            $data['inputerror'][] = 'telp';
            $data['error_string'][] = 'Telp tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function get_nama_customer()
    {
        $list = $this->model_customer->_get_customer()->result();

        $row = array();
        $row[] = "<option value=\"\">Pilih nama Customer</option>";
        foreach ($list as $customer) {
            $row[] = "<option value=\"" . $customer->id . "\">" . $customer->nama . "</option>";
        }

        echo json_encode($row);
    }

    public function get_detail_customer()
    {
        $id = $this->input->post('id');

        $result = $this->model_customer->_get_customer($id);
        $row = $result->row();

        if (isset($row)) {
            $data['telp'] = $row->telp;
        }


        echo json_encode($data);
    }
}
