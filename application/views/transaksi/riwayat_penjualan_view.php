<script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<!-- Select2 -->
<?= link_tag(base_url('assets/select2/dist/css/select2.css'), 'stylesheet', 'text/css') ?>
<?= link_tag(base_url('assets/select2/dist/css/select2-bootstrap.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/select2/dist/js/select2.min.js') ?>"></script>

<div class="card border-primary mb-3 d-print-none">
    <div class="card-body">
        <button class="btn btn-outline-secondary" id="reload_table"><i class="fas fa-fw fa-sync"></i> Segarkan</button>

        <hr/>

        <h5>Tabel Riwayat Penjualan</h5>
        <div class="table-responsive">
            <table id="table" class="table table-striped content-responsive" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col" style="width: 5%;">No</th>
                        <th scope="col" style="width: 10%;">Kode</th>
                        <th scope="col" style="width: 10%;">Nomor Nota</th>
                        <th scope="col" style="width: 15%;">Total Bayar</th>
                        <th scope="col" style="width: 15%;">Total Harga</th>
                        <th scope="col" style="width: 10%;">Kasir</th>
                        <th scope="col" style="width: 20%;">Tanggal Cetak</th>
                        <th scope="col" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nomor Nota</th>
                        <th scope="col">Total Bayar</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Kasir</th>
                        <th scope="col">Tanggal Cetak</th>
                        <th scope="col"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Detail <span id="nomorNota"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="table_detail" class="table table-striped content-responsive" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 5%;">No</th>
                                <th scope="col" style="width: 35%;">Nama Produk</th>
                                <th scope="col" style="width: 20%;">Harga</th>
                                <th scope="col" style="width: 10%;">Qty</th>
                                <th scope="col" style="width: 25%;">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th scope="col" colspan="4" class="text-right">Total Harga</th>
                                <th scope="col" class="text-right">
                                    <div class="col p-0">
                                        <span id="total_harga">0</span>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="4" class="text-right">Total Bayar</th>
                                <th scope="col" class="text-right">
                                    <div class="col p-0">
                                        <span id="total_bayar">0</span>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="4" class="text-right">Total Diskon</th>
                                <th scope="col" class="text-right">
                                    <div class="col p-0">
                                        <span id="diskon">0</span>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="4" class="text-right">Tunai</th>
                                <th scope="col" class="text-right">
                                    <span id="tunai">0</span>
                                </th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="4" class="text-right">Kembali</th>
                                <th scope="col" class="text-right">
                                    <div class="col p-0">
                                        <span id="kembali">0</span>
                                    </div>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Oke</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var table, table_detail;

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
    function detail(nomor_nota, user_id) {
        $('#staticBackdrop').modal('show');
        $('#nomorNota').html(nomor_nota);

        //datatables
        table_detail = $('#table_detail').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('transaksi/ajax_list_detail') ?>",
                "type": "POST",
                "data": {
                    "nomor_nota": nomor_nota,
                    "user_id": user_id,
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column
                    "orderable": false //set not orderable
                },
                {
                    "targets": [-1], //last column
                    "orderable": false //set not orderable
                }
            ],
            "bDestroy": true
        });

        //deskripsi
        $.ajax({
            url: "<?= site_url('riwayat_transaksi/ajax_by_nomor_nota') ?>",
            type: 'POST',
            data: {
                nomor_nota: nomor_nota,
                "user_id": user_id,
            },
            dataType: 'json',
            beforeSend: function (xhr) {
                $('#total_harga').html('<i class="fa fa-spin fa-spinner fa-pulse"></i>');
                $('#total_bayar').html('<i class="fa fa-spin fa-spinner fa-pulse"></i>').removeClass('text-primary');
                $('#diskon').html('<i class="fa fa-spin fa-spinner fa-pulse"></i>');
                $('#tunai').html('<i class="fa fa-spin fa-spinner fa-pulse"></i>').removeClass('text-primary');
                $('#kembali').html('<i class="fa fa-spin fa-spinner fa-pulse"></i>').removeClass('text-primary');
            },
            success: function (data, textStatus, jqXHR) {
                $('#total_harga').html(data.total_harga);
                $('#total_bayar').html(data.total_bayar).addClass('text-primary');
                $('#diskon').html(data.diskon);
                $('#tunai').html(data.tunai).addClass('text-primary');
                $('#kembali').html(data.kembali).addClass('text-primary');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            }
        });
    }

    $(document).ready(function () {
        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('riwayat_transaksi/ajax_list') ?>",
                "type": "POST",
                "data": {}
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column
                    "orderable": false //set not orderable
                },
                {
                    "targets": [-1], //last column
                    "orderable": false //set not orderable
                }
            ],
            "drawCallback": function( settings ) {
                $('.detail').click(function () {
                    let nomor_nota = $(this).data('nomor');
                    let user_id = $(this).data('user');
                    console.log(nomor_nota);
                    console.log(user_id);
                    detail(nomor_nota, user_id);
                });
            }
        });
        
        $('#reload_table').click(function () {
            reload_table();
        });
    });
</script>