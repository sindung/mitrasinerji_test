<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $result_id = $this->model_sales->get_new_id()->result();
        $customer_list = $this->model_customer->_get_customer()->result();
        $barang_list = $this->model_barang->_get_barang()->result();

        $new_id = $result_id[0]->new_id;
        $nomor_transaksi = date('Ym') . "-" . str_pad($new_id, 5, '0', STR_PAD_LEFT);

        $array = array(
            "new_id" => $new_id,
            "nomor_transaksi" => $nomor_transaksi,
            "customer_list" => $customer_list,
            "barang_list" => $barang_list,
        );

        $data = array(
            'app_title' => 'Mitrasinerji Test - Sales',
            'app_heading' => 'Manajemen Sales',
            'app_content' => $this->parser->parse('sales/sales_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function daftar_transaksi()
    {
        $result_id = $this->model_sales->get_new_id()->result();
        $customer_list = $this->model_customer->_get_customer()->result();
        $barang_list = $this->model_barang->_get_barang()->result();

        $new_id = $result_id[0]->new_id;
        $nomor_transaksi = date('Ym') . "-" . str_pad($new_id, 5, '0', STR_PAD_LEFT);

        $array = array(
            "new_id" => $new_id,
            "nomor_transaksi" => $nomor_transaksi,
            "customer_list" => $customer_list,
            "barang_list" => $barang_list,
        );

        $data = array(
            'app_title' => 'Mitrasinerji Test - Daftar Transaksi',
            'app_heading' => 'Daftar Transaksi',
            'app_content' => $this->parser->parse('sales_det/sales_det_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list()
    {
        $list = $this->model_sales->get_datatables();
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        $grand_total = 0;
        foreach ($list as $sales) {
            $no++;
            $row = array();

            // $customer_list = $this->model_customer->_get_customer()->result();
            // $barang_list = $this->model_barang->_get_barang()->result();
            // $jumlah_barang = $this->model_sales_det->count_by_kode($sales->kode);

            $row[] = $no;
            $row[] = $sales->kode;
            $row[] = date('d-M-Y', strtotime($sales->tgl));
            $row[] = $sales->customer_name;
            $row[] = $sales->count_barang;
            $row[] = number_format($sales->subtotal, 0, '', '');
            $row[] = number_format($sales->diskon, 0, '', '');
            $row[] = number_format($sales->ongkir, 0, '', '');
            $row[] = number_format($sales->total_bayar, 0, '', '');

            $data[] = $row;
            $grand_total += $sales->total_bayar;
        }

        $total_bayar = $grand_total;

        $extra = array(
            "grand_total" => $grand_total
        );

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_sales->count_all(),
            "recordsFiltered" => $this->model_sales->count_filtered(),
            "data" => $data,
            "extra" => $extra
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->model_sales->get_by_id($id);
        $data->harga_bandrol = number_format($data->harga_bandrol, 0, '', '');
        $data->harga_diskon = number_format($data->harga_diskon, 0, '', '');
        $data->total = number_format($data->total, 0, '', '');

        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('kode'),
            'tgl' => $this->input->post('tgl'),
            'cust_id' => $this->input->post('cust_id'),
            'subtotal' => $this->input->post('footer_subtotal'),
            'diskon' => $this->input->post('footer_diskon'),
            'ongkir' => $this->input->post('footer_ongkir'),
            'total_bayar' => $this->input->post('footer_total_bayar')
        );

        $insert = $this->model_sales->save($data);

        echo json_encode(array("status" => true));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('kode'),
            // 'tgl' => date('Y-m-d'),
            'cust_id' => $this->input->post('cust_id'),
            'subtotal' => $this->input->post('footer_subtotal'),
            'diskon' => $this->input->post('footer_diskon'),
            'ongkir' => $this->input->post('footer_total_bayar'),
            'total_bayar' => $this->input->post('footer_total_bayar')
        );

        $update = $this->model_sales->update(array('id' => $this->input->post('id')), $data);

        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id)
    {
        $this->model_sales->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_sales->delete_by_id($id);
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

        if ($this->input->post('cust_id') == '') {
            $data['inputerror'][] = 'cust_id';
            $data['error_string'][] = 'Customer ID tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('footer_subtotal') == '' || $this->input->post('footer_subtotal') == '0') {
            $data['inputerror'][] = 'footer_subtotal';
            $data['error_string'][] = 'Subtotal tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('footer_total_bayar') == '' || $this->input->post('footer_total_bayar') == '0') {
            $data['inputerror'][] = 'footer_total_bayar';
            $data['error_string'][] = 'Total Bayar tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function get_nama_sales()
    {
        $list = $this->model_sales->_get_sales()->result();

        $row = array();
        $row[] = "<option value=\"\">Pilih nama Sales</option>";
        foreach ($list as $sales) {
            $row[] = "<option value=\"" . $sales->id . "\">" . $sales->nama . "</option>";
        }

        echo json_encode($row);
    }

    public function get_detail_sales()
    {
        $id = $this->input->post('id');

        $result = $this->model_sales->_get_sales($id);
        $row = $result->row();

        if (isset($row)) {
            $data['harga'] = number_format($row->harga, 0, '', '');
        }


        echo json_encode($data);
    }
}
