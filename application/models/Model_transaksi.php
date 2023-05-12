<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_transaksi extends CI_Model {

    public $table = 'transaksi';
    public $column_order = array(null, null, 'nama_produk', 'harga', 'qty', 'sub_total'); //set column field database for datatable orderable
    public $column_search = array('nama_poduk', 'harga'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    public $order = array('id' => 'desc'); // default order

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($user_id, $nomor_nota) {

        $this->db->from($this->table);
        $this->db->where(array(
            'user_id' => $user_id,
            'nomor_nota' => $nomor_nota
        ));

        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) { //last loop
                    $this->db->group_end();
                }
                //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($user_id, $nomor_nota) {
        $this->db->query("SET sql_mode = '' ");
        $this->_get_datatables_query($user_id, $nomor_nota);
        $input_length = filter_input(INPUT_POST, 'length');
        $input_start = filter_input(INPUT_POST, 'start');
        if ($input_length != -1) {
            $this->db->limit($input_length, $input_start);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($user_id, $nomor_nota) {
        $this->_get_datatables_query($user_id, $nomor_nota);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($user_id, $nomor_nota) {
        $this->db->from($this->table);
        $this->db->where(array(
            'user_id' => $user_id,
            'nomor_nota' => $nomor_nota,
        ));
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        $this->db->query("SET sql_mode = '' ");
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data) {
        $this->db->query("SET sql_mode = '' ");
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data) {
        $this->db->query("SET sql_mode = '' ");
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id) {
        $this->db->query("SET sql_mode = '' ");
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

    public function _get_produk($id = '') {
        $this->db->query("SET sql_mode = '' ");
        $this->db->from($this->table);
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_transaksi_($user_id, $nomor_nota) {
        $this->db->query("SET sql_mode = '' ");
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array(
            'user_id' => $user_id,
            'nomor_nota' => $nomor_nota,
        ));
        return $this->db->get();
    }

    public function get_transaksi_by_produk_($user_id, $nomor_nota, $id) {
        $this->db->query("SET sql_mode = '' ");
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array(
            'user_id' => $user_id,
            'nomor_nota' => $nomor_nota,
            'id_produk' => $id,
        ));
        return $this->db->get();
    }

}
