<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_logged_in();
    }

    public function index() {
        $this->manajemen();
    }

    public function manajemen() {
        $array = array();

        $data = array(
            'app_title' => 'Mitrasinerji Test',
            'app_heading' => 'Manajemen User',
            'app_content' => $this->parser->parse('user/manajemen_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $r_role = $this->model_role->get_role();
        $row_role = $r_role->row();

        $list = $this->model_user->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $produk) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $produk->id . '">';
            $row[] = $produk->nama;
            $row[] = $produk->user_id;
//            $row[] = $produk->is_active;

            $r_role = $this->model_role->get_role($produk->role_id);
            $row_role = $r_role->row();

            $row[] = $row_role->name;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-outline-info mr-1 ubah-data" href="javascript:void(0)" title="Edit" data-id="' . $produk->id . '"><i class="fas fa-edit"></i></a>'
                    . '<a class="btn btn-sm btn-outline-danger hapus-data" href="javascript:void(0)" title="Hapus" data-id="' . $produk->id . '"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_user->count_all(),
            "recordsFiltered" => $this->model_user->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->model_user->get_by_id($id);

        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'nama' => htmlspecialchars($this->input->post('name', true)),
            'user_id' => htmlspecialchars($this->input->post('user_id', true)),
            'gambar' => 'default.jpg',
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => htmlspecialchars($this->input->post('role_select', true)),
            'is_active' => 1,
            'create_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->model_user->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update() {
        $this->_validate();

        $data = array(
            'nama' => htmlspecialchars($this->input->post('name', true)),
            'user_id' => htmlspecialchars($this->input->post('user_id', true)),
            'role_id' => htmlspecialchars($this->input->post('role_select', true)),
        );

        $update = $this->model_user->update(array('id' => $this->input->post('id')), $data);

        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id) {
        $this->model_user->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_user->delete_by_id($id);
        }
        echo json_encode(array("status" => true));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Nama tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('user_id') == '') {
            $data['inputerror'][] = 'user_id';
            $data['error_string'][] = 'User ID tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('password1') == '') {
            $data['inputerror'][] = 'password1';
            $data['error_string'][] = 'Password tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('password2') == '') {
            $data['inputerror'][] = 'password2';
            $data['error_string'][] = 'Password tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('password1') != $this->input->post('password2')) {
            $data['inputerror'][] = 'password1';
            $data['inputerror'][] = 'password2';
            $data['error_string'][] = 'Konfirmasi password berbeda';
            $data['error_string'][] = '';
            $data['status'] = false;
        }

        if ($this->input->post('role_select') == '') {
            $data['inputerror'][] = 'role_select';
            $data['error_string'][] = 'Role Select Kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

}
