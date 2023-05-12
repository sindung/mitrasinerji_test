<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_det extends CI_Controller
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

    public function ajax_list($kode)
    {
        $list = $this->model_sales_det->get_datatables($kode);
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        $subtotal = 0;
        $total_bayar = 0;
        foreach ($list as $sales) {
            $no++;
            $row = array();
            //add html for action
            $html = '<div class="btn-group btn-group-sm" role="group" aria-label="Button action">';
            $html .= '<a class="btn btn-sm btn-outline-info ubah-data" href="javascript:void(0)" title="Edit" data-id="' . $sales->id . '"><i class="fas fa-edit"></i></a>';
            $html .= '<a class="btn btn-sm btn-outline-danger hapus-data" href="javascript:void(0)" title="Hapus" data-id="' . $sales->id . '"><i class="fas fa-trash"></i></a>';
            $html .= '</div>';

            $row[] = $html;
            $row[] = '<input type="checkbox" class="data-check" value="' . $sales->id . '">';
            $row[] = $no;
            $row[] = $sales->barang_id;
            $row[] = $sales->barang_id;
            $row[] = $sales->qty;
            $row[] = number_format($sales->harga_bandrol, 0, '', '');
            $row[] = $sales->diskon_pct;
            $row[] = $sales->diskon_nilai;
            $row[] = number_format($sales->harga_diskon, 0, '', '');
            $row[] = number_format($sales->total, 0, '', '');

            $data[] = $row;
            $subtotal += $sales->total;
        }

        $total_bayar = $subtotal;

        $extra = array(
            "subtotal" => $subtotal,
            "total_bayar" => $total_bayar,
        );

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_sales_det->count_all(),
            "recordsFiltered" => $this->model_sales_det->count_filtered(),
            "data" => $data,
            "extra" => $extra
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->model_sales_det->get_by_id($id);
        $data->harga_bandrol = number_format($data->harga_bandrol, 0, '', '');
        $data->harga_diskon = number_format($data->harga_diskon, 0, '', '');
        $data->total = number_format($data->total, 0, '', '');

        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('sales_id'),
            'sales_id' => $this->input->post('sales_id'),
            'barang_id' => $this->input->post('barang_id'),
            'harga_bandrol' => $this->input->post('barang_harga'),
            'qty' => $this->input->post('qty'),
            'diskon_pct' => $this->input->post('diskon_pct'),
            'diskon_nilai' => $this->input->post('diskon_nilai'),
            'harga_diskon' => $this->input->post('harga_diskon'),
            'total' => $this->input->post('total')
        );

        $sales_det = $this->model_sales_det->get_by_kode_and_barang($data['kode'], $data['barang_id']);
        $sales_row = $sales_det->row();
        $row_qty = $sales_row->qty;

        if ($sales_det->num_rows() > 0) {
            $harga_diskon = (float) $data['harga_bandrol'] - (float) ($data['diskon_nilai']) - ((float) $data['diskon_pct'] / 100 * (float) $data['harga_bandrol']);
            $qty = (int) $data['qty'] + (int) $row_qty;

            $update = $this->model_sales_det->update(array(
                'kode' => $data['kode'],
                'barang_id' => $data['barang_id']
            ), array(
                'harga_bandrol' => $data['harga_bandrol'],
                'qty' => $qty,
                'diskon_pct' => $data['diskon_pct'],
                'diskon_nilai' => $data['diskon_nilai'],
                'harga_diskon' => $harga_diskon,
                'total' => $harga_diskon * $qty
            ));
        } else {
            $insert = $this->model_sales_det->save($data);
        }

        echo json_encode(array("status" => true));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'kode' => $this->input->post('sales_id'),
            'sales_id' => $this->input->post('sales_id'),
            'barang_id' => $this->input->post('barang_id'),
            'harga_bandrol' => $this->input->post('barang_harga'),
            'qty' => $this->input->post('qty'),
            'diskon_pct' => $this->input->post('diskon_pct'),
            'diskon_nilai' => $this->input->post('diskon_nilai'),
            'harga_diskon' => $this->input->post('harga_diskon'),
            'total' => $this->input->post('total')
        );

        $update = $this->model_sales_det->update(array('id' => $this->input->post('id')), $data);

        echo json_encode(array("status" => true));
    }

    public function ajax_delete($id)
    {
        $this->model_sales_det->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete()
    {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_sales_det->delete_by_id($id);
        }
        echo json_encode(array("status" => true));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('sales_id') == '') {
            $data['inputerror'][] = 'sales_id';
            $data['error_string'][] = 'Sales ID tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('barang_id') == '') {
            $data['inputerror'][] = 'barang_id';
            $data['error_string'][] = 'Barang ID tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('barang_harga') == '') {
            $data['inputerror'][] = 'barang_harga';
            $data['error_string'][] = 'Harga Bandrol tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('qty') == '') {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'Qty tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('harga_diskon') == '') {
            $data['inputerror'][] = 'harga_diskon';
            $data['error_string'][] = 'Harga Diskon tidak boleh kosong';
            $data['status'] = false;
        }

        if ($this->input->post('total') == '') {
            $data['inputerror'][] = 'total';
            $data['error_string'][] = 'Total tidak boleh kosong';
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
