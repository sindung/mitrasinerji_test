<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

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
            'app_heading' => 'Manajemen Role',
            'app_content' => $this->parser->parse('role/manajemen_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $list = $this->model_role->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        foreach ($list as $role) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $role->id . '">';
            $row[] = $role->name;
            $row[] = ($role->nota == '1' ? 'Yes' : 'No');
            $row[] = ($role->super == '1' ? 'Yes' : 'No');
            $row[] = ($role->history == '1' ? 'Yes' : 'No');

            //add html for action
            $row[] = '<a class="btn btn-sm btn-outline-info mr-1 ubah-data" href="javascript:void(0)" title="Edit" data-id="' . $role->id . '"><i class="fas fa-edit"></i></a>'
                    . '<a class="btn btn-sm btn-outline-danger hapus-data" href="javascript:void(0)" title="Hapus" data-id="' . $role->id . '"><i class="fas fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_role->count_all(),
            "recordsFiltered" => $this->model_role->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->model_role->get_role($id)->row();

        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();

        $data = array(
            'name' => htmlspecialchars($this->input->post('name', true)),
            'nota' => htmlspecialchars($this->input->post('akses_nota', true)),
            'super' => htmlspecialchars($this->input->post('akses_super', true)),
            'history' => htmlspecialchars($this->input->post('akses_history', true)),
        );

        $insert = $this->model_role->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update() {
        $this->_validate();

        $data = array(
            'name' => htmlspecialchars($this->input->post('name', true)),
            'nota' => htmlspecialchars($this->input->post('akses_nota', true)),
            'super' => htmlspecialchars($this->input->post('akses_super', true)),
            'history' => htmlspecialchars($this->input->post('akses_history', true)),
        );

        $update = $this->model_role->update(array('id' => $this->input->post('id')), $data);

        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id) {
        $this->model_role->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_role->delete_by_id($id);
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

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function get_role() {
        $status = false;
        $opt = array();

        $r_role = $this->model_role->get_role();

        if ($r_role) {
            $status = true;
            foreach ($r_role->result() as $key => $value) {
                $opt[] = $value;
            }
        }

        $response = array(
            'status' => $status,
            'opt' => $opt,
        );
        echo json_encode($response);
    }

}
