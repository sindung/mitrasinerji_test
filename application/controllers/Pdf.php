<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

    function __construct() {
        parent::__construct();
        is_logged_in();
    }

    public function nota($param) {
        $this->load->library('Pdf_lib');

        // create new PDF document
        $pdf = new Pdf_lib(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('H-Soft');
        $pdf->SetTitle('Cetak Nota');
        $pdf->SetSubject('H-Soft');
        $pdf->SetKeywords('PDF');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set margins
        $pdf->SetMargins(1, 2, 1);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set page format (read source code documentation for further information)
        // MediaBox - width = urx - llx = 210 (mm), height = ury - lly = 297 (mm) this is A4
        $page_format = array(
            'MediaBox' => array('llx' => 0, 'lly' => 0, 'urx' => $pdf->getPageHeight(), 'ury' => 58),
            //'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
            //'BleedBox' => array ('llx' => 5, 'lly' => 5, 'urx' => 205, 'ury' => 292),
            //'TrimBox' => array ('llx' => 10, 'lly' => 10, 'urx' => 200, 'ury' => 287),
            //'ArtBox' => array ('llx' => 15, 'lly' => 15, 'urx' => 195, 'ury' => 282),
            'Dur' => 3,
            'trans' => array(
                'D' => 1.5,
                'S' => 'Split',
                'Dm' => 'V',
                'M' => 'O'
            ),
            'Rotate' => 0,
            'PZ' => 1,
        );
        // Check the example n. 29 for viewer preferences
        // add a page
        $pdf->AddPage('P', $page_format, false, false);

        $nomor_nota = nomor_nota($param);

        $table = '';
        $this->db->query("SET sql_mode = '' ");
        $query_nota = $this->db->get_where('nota', array('nomor_nota' => $nomor_nota, 'user_id' => $this->session->userdata('user_id')));
        $row_nota = $query_nota->row();

        $tr = '';
        $nama_kasir = 'Nama Kasir';
        $sess_ = $this->session->userdata();
        if ($sess_) {
            $nama_kasir = $sess_['user_nama'];
        }
        if (isset($row_nota)) {
            $query_transaksi = $this->db->get_where('transaksi', array('nomor_nota' => $nomor_nota, 'user_id' => $this->session->userdata('user_id')));
            $row_transaksi = $query_transaksi->row();
            if (isset($row_nota)) {
                $no = 1;
                foreach ($query_transaksi->result() as $key => $value) {
                    $tr .= '<tr>'
                            . '<td style="width: 5%;">' . $no . '</td>'
                            . '<td style="width: 25%;">' . $value->nama_produk . '<span style="float: right;"></span>' . '</td>'
                            . '<td style="width: 25%;">' . '@' . number_format($value->harga, 0, '', '.') . br(1) . $value->qty . '&times;' . '</td>'
                            . '<td style="width: 10%;">Rp.</td>'
                            . '<td style="width: 35%;text-align: right;">' . number_format($value->sub_total, 0, '', '.') . '</td>'
                            . '</tr>';

                    //update stok
                    $this->db->query("SET sql_mode = '' ");
                    $this->db->set('stok', 'stok - ' . $value->qty, false);
                    $this->db->where('id', $value->id_produk);
                    $this->db->update('produk');

                    $no++;
                }
            }
            $table .= '<table border="0" style="" cellpadding="2" cellspacing="0">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center;">
                            Rumah Makan<br/>"Kampung Bambu Kedungkebo (KBK)"
                            <br/>
                            Kedungkebo, Karangdadap, Pekalongan
                            <br/>
                            HP. : 085697891499
                            <br/>
                            kampungbambukedungkebo@gmail.com
                            <div style="text-align: right;">Kasir : ' . $nama_kasir . '</div>
                            -----------------------------------------------------
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="5">Nomor Nota : ' . $nomor_nota . '<br/>Kode : ' . $param . '</td></tr>
                    <tr><td colspan="5">Dicetak pada : ' . date('Y-m-d H:i:s') . '</td></tr>
                    ' . $tr . '
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" style="text-align: right;">Total Harga</th>
                        <th>Rp.</th>
                        <th style="text-align: right;">' . number_format($row_nota->total_harga, 0, '', '.') . '</th>
                    </tr>
                    <!--tr>
                        <th colspan="3" style="text-align: right;">Diskon</th>
                        <th>Rp.</th>
                        <th style="text-align: right;">' . number_format($row_nota->diskon, 0, '', '.') . '</th>
                    </tr-->
                    <tr>
                        <th colspan="3" style="text-align: right;">Tunai</th>
                        <th>Rp.</th>
                        <th style="text-align: right;">' . number_format($row_nota->tunai, 0, '', '.') . '</th>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align: right;">Kembali</th>
                        <th>Rp.</th>
                        <th style="text-align: right;">' . number_format($row_nota->kembali, 0, '', '.') . '</th>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: center;">
                            -----------------------------------------------------
                            Terimakasih
                            <br/>
                            Enak bilang teman
                            <br/>
                            Tidak enak bilang kami
                            <br/>
                            kami tunggu kunjungan anda kembali
                        </td>
                    </tr>
                </tfoot>
            </table>';
        }

        // update print_at
        $set = array('print_at' => date('Y-m-d H:i:s'));
        $where = array(
            'user_id' => $this->session->userdata('user_id'),
            'nomor_nota' => $nomor_nota
        );
        $this->db->update('nota', $set, $where);

        $html = '<html>'
                . '<head>'
                . '<title>Cetak Nota</title>'
                . '</head>'
                . '<body style="font-size:8pt;">'
                . $table
                . '</body>'
                . '</html>';

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Print a table
        // ---------------------------------------------------------
        $pdf->IncludeJS("print(true);");
        //Close and output PDF document
        $pdf->Output('nota-' . $param . '.pdf', 'I');
    }

    public function cetak($unique) {
        $data = array(
            'app_title' => 'Mitrasinerji Test',
            'app_heading' => 'Cetak Nota',
            'unique' => $unique,
        );

        $this->parser->parse('cetak/nota', $data);
    }

}
