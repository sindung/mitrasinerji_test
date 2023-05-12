<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_logged_in();
    }

    public function index() {
        $this->penjualan();
    }

    public function penjualan() {
        // cek apakah ada nota yang belum dicetak
        $this->db->query("SET sql_mode = '' ");
        $query = $this->db->get_where('nota', array('print_at' => null, 'user_id' => $this->session->userdata('user_id')));
        $row = $query->row();

        if (!isset($row)) {
            // buat nomor nota
            $data = array(
                'nomor_nota' => '',
                'create_at' => date('Y-m-d H:i:s'),
                'print_at' => null,
                'session' => $this->session->session_id,
                'user_id' => $this->session->userdata('user_id')
            );

            $this->db->insert('nota', $data);
        }

        $nomor_nota = '';
        // baca nomor nota yang belum dicetak
        $query = $this->db->get_where('nota', array('print_at' => null, 'user_id' => $this->session->userdata('user_id')));
        foreach ($query->result() as $value) {
            $nomor_nota = $value->nomor_nota;
        }

        $array = array(
            'nomor_nota' => $nomor_nota,
            'unique' => 'KSK' . $nomor_nota . '-' . date('ymd')
        );

        $data = array(
            'app_title' => 'Mitrasinerji Test - Transaksi',
            'app_heading' => 'Penjualan',
            'app_content' => $this->parser->parse('transaksi/penjualan_view', $array, true)
        );

        $this->parser->parse('app_template', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));
        $user_id = $this->session->userdata('user_id');
        $list = $this->model_transaksi->get_datatables($user_id, $nomor_nota);
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        $total_harga = 0;
        foreach ($list as $transaksi) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check mr-1" value="' . $transaksi->id . '"><br/>'
                    . '<a href="javascript:void(0)" data-id="' . $transaksi->id  . '" class="btn btn-sm btn-outline-danger hapus-produk"><i class="fas fa-trash"></i></a>';

            $row[] = $no;
            $row[] = $transaksi->nama_produk;
            $row[] = '<p class="text-right">' . number_format($transaksi->harga, 0, '', '.') . '</p>';
            $row[] = '<p class="text-right">' . $transaksi->qty . '</p>';
            $row[] = '<p class="text-right">' . number_format($transaksi->sub_total, 0, '', '.') . '</p>';
            $total_harga += $transaksi->sub_total;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_transaksi->count_all($user_id, $nomor_nota),
            "recordsFiltered" => $this->model_transaksi->count_filtered($user_id, $nomor_nota),
            "data" => $data,
            "total_harga" => $total_harga,
            "nomor_nota" => $nomor_nota
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_detail() {
        $this->load->helper('url');

        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));
        $user_id = $this->input->post('user_id');
        $list = $this->model_transaksi->get_datatables($user_id, $nomor_nota);
        $data = array();
        $no = filter_input(INPUT_POST, 'start');
        $total_harga = 0;
        foreach ($list as $transaksi) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $transaksi->nama_produk;
            $row[] = '<p class="text-right">' . number_format($transaksi->harga, 0, '', '.') . '</p>';
            $row[] = '<p class="text-right">' . $transaksi->qty . '</p>';
            $row[] = '<p class="text-right">' . number_format($transaksi->sub_total, 0, '', '.') . '</p>';
            $total_harga += $transaksi->sub_total;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_transaksi->count_all($user_id, $nomor_nota),
            "recordsFiltered" => $this->model_transaksi->count_filtered($user_id, $nomor_nota),
            "data" => $data,
            "total_harga" => $total_harga,
            "nomor_nota" => $nomor_nota
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_add() {
        $this->_validate();

        $nomor_nota = $this->input->post('nomor_nota');
        $user_id = $this->session->userdata('user_id');
        $id_produk = $this->input->post('id_produk');
        $qty_ = $this->input->post('qty');
        $subtotal_ = $this->input->post('subtotal');

        $data = array(
            'nomor_nota' => $nomor_nota,
            'id_produk' => $id_produk,
            'nama_produk' => $this->input->post('nama_produk'),
            'harga' => $this->input->post('harga'),
            'qty' => $qty_,
            'sub_total' => $subtotal_,
            'user_id' => $user_id
        );

        // check if data exist then add qty
        $exist_ = $this->model_transaksi->get_transaksi_by_produk_($user_id, $nomor_nota, $id_produk);
        $row = $exist_->row();
        $num_rows_ = $exist_->num_rows();
        if ($num_rows_ > 0) {
            $where = array(
                'nomor_nota' => $nomor_nota,
                'user_id' => $user_id,
                'id_produk' => $id_produk,
            );
            $data = array(
                'qty' => $row->qty + (int) $qty_,
                'sub_total' => $row->sub_total + (int) $subtotal_,
            );

            $update = $this->model_transaksi->update($where, $data);
        } else {
            // if not exist then insert
            $insert = $this->model_transaksi->save($data);
            //update stok
            //$update = $this->model_produk->update_stok($data);
        }

        echo json_encode(array(
            "status" => true
        ));
    }

    public function ajax_delete($id) {
        $this->model_transaksi->delete_by_id($id);
        echo json_encode(array("status" => true));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->model_transaksi->delete_by_id($id);
        }
        echo json_encode(array("status" => true));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('id_produk') == '') {
            $data['inputerror'][] = 'id_produk';
            $data['error_string'][] = 'Nama tidak boleh kosong';
            $data['status'] = false;
        }
        if ($this->input->post('harga') == '') {
            $data['inputerror'][] = 'harga';
            $data['error_string'][] = 'Harga tidak boleh kosong';
            $data['status'] = false;
        }
        if ($this->input->post('qty') == '') {
            $data['inputerror'][] = 'qty';
            $data['error_string'][] = 'Qty tidak boleh kosong';
            $data['status'] = false;
        }
        if ($this->input->post('subtotal') == '') {
            $data['inputerror'][] = 'subtotal';
            $data['error_string'][] = 'Subtotal tidak boleh kosong';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

    public function ajax_total_harga() {
        $user_id = $this->session->userdata('user_id');
        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));

        $result = $this->model_transaksi->get_transaksi_($user_id, $nomor_nota);
        $total_harga = 0;
        $status = ($result->row() !== null) ? true : false;

        foreach ($result->result() as $value) {
            $total_harga += $value->sub_total;
        }

        $response = array(
            'status' => $status,
            'total_harga' => $total_harga
        );
        echo json_encode($response);
    }

    public function cetak($param) {
        $nomor_nota = nomor_nota($param);
        //echo $nomor_nota;
        $query_nota = $this->db->get_where('nota', array('nomor_nota' => $nomor_nota, 'user_id' => $this->session->userdata('user_id')));
        $row_nota = $query_nota->row();

        if (isset($row_nota)) {
            $query_transaksi = $this->db->get_where('transaksi', array('nomor_nota' => $nomor_nota, 'user_id' => $this->session->userdata('user_id')));
            $row_transaksi = $query_transaksi->row();
            if (isset($row_nota)) {
                $no = 1;
                foreach ($query_transaksi->result() as $key => $value) {
                    $tr_ .= '<tr>
                                        <td style="width: 5%;">' . $no . '</td>
                                        <td style="width: 50%;">
                                            ' . $value->nama_produk . '
                                            <span style="float: right;"></span>
                                        </td>
                                        <td style="width: 25%;">
                                            @' . $value->qty . '&times;' . $value->harga . '
                                        </td>
                                        <td style="width: 5%;">Rp.</td>
                                        <td style="text-align: right;">' . $value->sub_total . '</td>
                                    </tr>';
                    $total_harga = 0;
                    $no++;
                }
            }

            $table_ = '<table border="0" style="width: 300px;" cellpadding="6" cellspacing="0">
                        <thead>
                            <tr>
                                <th colspan="5">Nama Toko</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    Nomor Nota : ' . $param . '
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    Dicetak pada : ' . date('Y-m-s H:i:s') . '
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"><hr/></td>
                            </tr>
                            <?php
                            echo $tr_;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align: right;">Total Harga</th>
                                <th>Rp.</th>
                                <th style="text-align: right;"><?= $row_nota->total_harga ?></th>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align: right;">Diskon</th>
                                <th>Rp.</th>
                                <th style="text-align: right;"><?= $row_nota->diskon ?></th>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align: right;">Tunai</th>
                                <th>Rp.</th>
                                <th style="text-align: right;"><?= $row_nota->tunai ?></th>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align: right;">Kembali</th>
                                <th>Rp.</th>
                                <th style="text-align: right;"><?= $row_nota->kembali ?></th>
                            </tr>
                            <tr>
                                <td colspan="5"><hr/></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: center;">Terimakasih</td>
                            </tr>
                        </tfoot>
                    </table>';

            // update print_at
            $set = array('print_at' => date('Y-m-d H:i:s'));
            $where = array(
                'user_id' => $this->session->userdata('user_id'),
                'nomor_nota' => $nomor_nota
            );
            $this->db->update('nota', $set, $where);
        }

        echo '<html>
            <head>
                <title>Cetak Nota</title>
            </head>
            <body>
            ' . $table_ . '
                <script>
                    //print();
                </script>
            </body>
        </html>';
    }

    public function export() {
        $file = "file.xls";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=' . $file);
        echo '<table border="0" style="width: 300px;" cellpadding="4" cellspacing="4">
            <thead>
                <tr>
                    <th colspan="4">Nama Toko</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">
                        ' . date('Y-m-s H:i:s') . '
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;">1</td>
                    <td style="width: 50%;">Nama produk</td>
                    <td style="width: 10%;">Rp.</td>
                    <td style="text-align: right;">5000</td>
                </tr>
                <tr>
                    <td style="width: 10%;">2</td>
                    <td style="width: 50%;">Nama produk</td>
                    <td style="width: 10%;">Rp.</td>
                    <td style="text-align: right;">15000</td>
                </tr>
                <tr>
                    <td style="width: 10%;">3</td>
                    <td style="width: 50%;">Nama produk</td>
                    <td style="width: 10%;">Rp.</td>
                    <td style="text-align: right;">25000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align: right;">Total Harga</th>
                    <th>Rp.</th>
                    <th style="text-align: right;">45000</th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: right;">Total Diskon</th>
                    <th>Rp.</th>
                    <th style="text-align: right;">5000</th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: right;">Tunai</th>
                    <th>Rp.</th>
                    <th style="text-align: right;">50000</th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: right;">Kembali</th>
                    <th>Rp.</th>
                    <th style="text-align: right;">10000</th>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center;">Terimakasih</td>
                </tr>
            </tfoot>
        </table>';
    }

    public function ajax_update_total_bayar() {
        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));

        $set = array('total_bayar' => (int) $this->input->post('total_bayar'));
        $where = array(
            'user_id' => $this->session->userdata('user_id'),
            'nomor_nota' => $nomor_nota
        );
        $this->db->query("SET sql_mode = '' ");
        $this->db->update('nota', $set, $where);
        echo json_encode(array('status' => true));
    }

    public function ajax_update_diskon() {
        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));

        $where = array(
            'user_id' => $this->session->userdata('user_id'),
            'nomor_nota' => $nomor_nota
        );
        $set = array('diskon' => (int) $this->input->post('diskon'));

        $this->db->query("SET sql_mode = '' ");
        $this->db->update('nota', $set, $where);
        echo json_encode(array('status' => true));
    }

    public function ajax_update_total_harga() {
        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));

        $set = array('total_harga' => (int) $this->input->post('total_harga'));
        $where = array(
            'user_id' => $this->session->userdata('user_id'),
            'nomor_nota' => $nomor_nota
        );
        $this->db->query("SET sql_mode = '' ");
        $this->db->update('nota', $set, $where);
        echo json_encode(array('status' => true));
    }

    public function ajax_update_tunai() {
        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));

        $this->db->query("SET sql_mode = '' ");
        $set = array('tunai' => (int) $this->input->post('tunai'));
        $where = array(
            'user_id' => $this->session->userdata('user_id'),
            'nomor_nota' => $nomor_nota
        );
        $this->db->query("SET sql_mode = '' ");
        $this->db->update('nota', $set, $where);
        echo json_encode(array('status' => true));
    }

    public function ajax_update_kembali() {
        $nomor_nota = nomor_nota($this->input->post('nomor_nota'));

        $set = array('kembali' => (int) $this->input->post('kembali'));
        $where = array(
            'user_id' => $this->session->userdata('user_id'),
            'nomor_nota' => $nomor_nota
        );
        $this->db->query("SET sql_mode = '' ");
        $this->db->update('nota', $set, $where);
        echo json_encode(array('status' => true));
    }

}
