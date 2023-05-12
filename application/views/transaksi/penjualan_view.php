<script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<!-- Select2 -->
<?= link_tag(base_url('assets/select2/dist/css/select2.css'), 'stylesheet', 'text/css') ?>
<?= link_tag(base_url('assets/select2/dist/css/select2-bootstrap.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/select2/dist/js/select2.min.js') ?>"></script>

<!--<div class="alert alert-warning alert-dismissible fade show d-print-none " role="alert">
    <strong>Selamat Datang!</strong> Halaman ini masih dalam tahap pembuatan.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>-->

<div class="card border-primary mb-3 d-print-none">
    <div class="card-header">
        <h5 class="card-title mb-0">Nomor nota : {unique}</h5>
    </div>
    <div class="card-body">
        <form class="mb-3" id="form_penjuaan_transaksi">
            <input type="hidden" id="nomor_nota" name="nomor_nota" value="{nomor_nota}" readonly hidden>
            <div class="form-row">
                <div class="col-md-12 col-lg-5 mb-3">
                    <select class="form-control js-example-basic-single" id="id_produk" name="id_produk" placeholder="Nama Barang" style="width: 100%;">
                        <option value="AL">Teh Panas</option>
                        <option value="AY">Ayam</option>
                        <option value="NS">Nasi</option>
                    </select>
                    <div class="invalid-tooltip">
                        Mohon diisi.
                    </div>
                </div>
                <div class="col-md-12 col-lg-2 mb-3">
                    <input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" min="1" max="100">
                    <div class="invalid-feedback">
                        Mohon diisi.
                    </div>
                </div>
                <div class="col-md-12 col-lg-auto mb-3">
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga" min="0" readonly="readonly">
                    <div class="invalid-feedback">
                        Mohon diisi.
                    </div>
                </div>
                <div class="col-md-12 col-lg-auto mb-3">
                    <input type="number" class="form-control" id="subtotal" name="subtotal" placeholder="Sub Total" min="0" readonly="readonly">
                    <div class="invalid-feedback">
                        Mohon diisi.
                    </div>
                </div>
            </div>
            <div class="custom-switch mb-3">
                <input type="checkbox" class="custom-control-input" id="auto_clear_input" name="auto_clear_input" checked="checked">
                <label class="custom-control-label" for="auto_clear_input">Hapus input otomatis</label>
            </div>
            <div class="form-row">
                <div class="col-md-auto mb-3">
                    <button class="btn btn-outline-primary btn-block" type="button" id="reload_table"><i class="fas fa-fw fa-sync"></i> Segarkan</button>
                </div>
                <div class="col-md-auto col-lg-3 mb-3">
                    <button class="btn btn-outline-success btn-block" type="submit"><i class="fas fa-fw fa-save"></i> Simpan</button>
                </div>
                <div class="col-md-auto mb-3">
                    <button class="btn btn-outline-danger btn-block" type="button" id="clearInput"><i class="fas fa-fw fa-backspace"></i> Clear / Hapus Input</button>
                </div>
                <div class="col-md-auto mb-3">
                    <button class="btn btn-outline-danger btn-block" type="button" id="bulk_delete"><i class="fas fa-fw fa-eraser"></i> Clear / Hapus Tabel</button>
                </div>
                <div class="col-md-auto col-lg-3 mb-3">
                    <button id="btnCetak" class="btn btn-outline-primary btn-block" type="button" disabled><i class="fas fa-fw fa-print"></i> Cetak Nota</button>
                </div>
            </div>
        </form>

        <hr/>
        <h5>Tabel</h5>
        <div class="table-responsive">
            <div class="text-right mb-2 content-responsive d-none">
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" name="diskonRadio" class="custom-control-input" value="1" checked>
                        <label class="custom-control-label" for="customRadio1">Umum</label>
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio2" name="diskonRadio" class="custom-control-input" value="2">
                        <label class="custom-control-label" for="customRadio2">Khusus</label>
                    </div>
                </div>
            </div>

            <table id="table" class="table table-striped content-responsive">
                <thead>
                    <tr>
                        <th scope="col" style="width: 15%;"><input type="checkbox" id="check-all"></th>
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
                        <td colspan="6" class="p-0">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr class="bg-white">
                                        <th scope="col" class="text-right" style="width: 25%;">Total Harga</th>
                                        <th scope="col" style="width: 40%;">
                                            <div class="col p-0">
                                                <label class="sr-only" for="total_harga">Rp.</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                                                    <input type="number" class="form-control" id="total_harga" name="total_harga" placeholder="0" min="0" readonly="readonly">
                                                </div>
                                            </div>
                                        </th>
                                        <th class="d-none" scope="col" style="width: 35%;">
                                            <div class="col p-0">
                                                <label class="sr-only" for="persen_diskon">Diskon (%)</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Diskon (%)</div>
                                                    </div>
                                                    <input type="number" class="form-control" id="persen_diskon" name="persen_diskon" placeholder="0" min="0" max="100">
                                                </div>
                                            </div>
                                        </th>

                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3" class="text-right">Total Bayar</th>
                        <th scope="col" colspan="3">
                            <div class="col p-0">
                                <label class="sr-only" for="total_bayar">Rp.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" class="form-control" id="total_bayar" name="total_bayar" placeholder="0" min="0" readonly="readonly">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr class="d-none">
                        <th scope="col" colspan="3" class="text-right">Total Diskon</th>
                        <th scope="col" colspan="3">
                            <div class="col p-0">
                                <label class="sr-only" for="total_diskon">Rp.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" class="form-control" id="total_diskon" name="total_diskon" placeholder="0" min="0" readonly="readonly">
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3" class="text-right">Tunai</th>
                        <th scope="col" colspan="3">
                            <div class="col p-0">
                                <label class="sr-only" for="tunai">Rp.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" class="form-control" id="tunai" name="tunai" placeholder="0" min="0" autocomplete="off">
                                    <div class="invalid-feedback">
                                        <i class="fas fa-fw fa-exclamation-triangle"></i> Uang Tunai kurang
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="3" class="text-right">Kembali</th>
                        <th scope="col" colspan="3">
                            <div class="col p-0">
                                <label class="sr-only" for="kembali">Rp.</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp.</div>
                                    </div>
                                    <input type="number" class="form-control" id="kembali" name="kembali" placeholder="0" min="0" readonly="readonly">
                                </div>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?= base_url(); ?>';

    function get_nama_produk() {
        $.ajax({
            url: "<?= site_url('produk/get_nama_produk') ?>",
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                //code
                $('#id_produk').html('Sedang mengambil produk...');
            },
            success: function (data, textStatus, jqXHR) {
                //code
                var option = '';
                $.each(data, function (index, value) {
                    option += value;
                });
                $('#id_produk').html(option);
            }
        });
    }
    function get_detail_produk(id) {
        $.ajax({
            url: "<?= site_url('produk/get_detail_produk') ?>",
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            beforeSend: function (xhr) {
                //code
            },
            success: function (data, textStatus, jqXHR) {
                //code
                //console.log(data);
                if (data.stok == 0) {
                    alert('Stok habis!');
                }

                $('#qty').attr('max', parseInt(data.stok));
                $('#qty').attr('data-stok', parseInt(data.stok));
                $('#harga').val(data.harga);
                hitungQty('');
            }
        });
    }
    function hitungQty(qty = '') {
        var qty;
        if (qty == '') {
            qty = '1';
            $('#qty').val(qty);
        } else {
            qty = qty.val();
        }

        var harga = $('#harga').val();
        var subtotal = harga * qty;

        $('#subtotal').val(subtotal);
    }
    function clearInput() {
        $('#form_penjuaan_transaksi')[0].reset();
    }
    function clearKalkulasi() {
        $('[name="total_bayar"]').val(0);
        $('[name="persen_diskon"]').val(0);
        $('[name="total_harga"]').val(0);
        $('[name="total_diskon"]').val(0);
        $('[name="kembali"]').val(0);
    }
    function autoClearInput() {
        var auto = $('[name="auto_clear_input"]:checked').val();
        if (auto === 'on') {
            clearInput();
        }
        //console.log(auto);
    }

    $(document).ready(function () {
        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('transaksi/ajax_list') ?>",
                "type": "POST",
                "data": {
                    "nomor_nota": "{unique}"
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
            "drawCallback": function( settings ) {
                $('.hapus-produk').click(function () {
                    let id = $(this).data('id');
                    console.log(id);
                    hapus_produk(id);
                });
            }
        });

        $('.js-example-basic-single').select2({
            theme: "bootstrap"
        });

        get_nama_produk();

        $('#id_produk').change(function (evt) {
            var id = $(this).val();
            get_detail_produk(id);

            console.log(id);
        });
        $('#harga').change(function (evt) {
            hitungQty($('#qty'));
        });
        $('#qty').change(function (evt) {
            var stok = $('#qty').attr('data-stok');
            console.log(stok);
            if (stok < parseInt($(this).val())) {
                $(this).val(stok);
            }

            hitungQty($(this));
        });
        $('#form_penjuaan_transaksi').submit(function (evt) {
            evt.preventDefault();

            var formData = $(this).serialize() + 'nama=' + $("#id_produk option:selected").text();

            var harga = parseInt($('#harga').val());
            var subtotal = parseInt($('#subtotal').val());

            if (harga > 0 || subtotal > 0) {
                tambah_produk();
                save();
            } else {
                alert('Stok habis!');
            }
        });
        
        $('#reload_table').click(function () {
            reload_table();
        });
        $('#clearInput').click(function () {
            clearInput();
        });
        $('#bulk_delete').click(function () {
            bulk_delete();
        });
        $('#cetakNota').click(function () {
            cetakNota();
        });
    });

    //awal hitung area
    function diskonToggle() {
        var diskon_rad = $('[name="diskonRadio"]:checked').val();

        switch (diskon_rad) {
            case '1':
                //$('[name="persen_diskon"]').attr('readonly', 'readonly');
                $('[name="total_diskon"]').attr('readonly', 'readonly');
                hitungBayar();
                break;
            case '2':
                //$('[name="persen_diskon"]').removeAttr('readonly');
                $('[name="total_diskon"]').removeAttr('readonly');
                hitungBayar();
                break;
        }
    }

    $('[name="diskonRadio"]').change(function (evt) {
        diskonToggle();
    });
    $('[name="persen_diskon"]').val('0').change(function (evt) {
        hitungBayar();

        ajaxUpdateDiskon();
    });
    $('[name="tunai"]').change(function (evt) {
        hitungBayar();

        ajaxUpdateTunai();
        enableCetak();
    });
    $('[name="total_diskon"]').change(function (evt) {
        hitungBayar();

        ajaxUpdateDiskon();
    });

    function ajaxUpdateTotalBayar() {
        $.ajax({
            url: "<?= site_url('transaksi/ajax_update_total_bayar') ?>",
            type: 'POST',
            data: {
                nomor_nota: {nomor_nota},
                total_bayar: $('[name="total_bayar"]').val()
            }
        });
    }
    function ajaxUpdateTotalHarga() {
        $.ajax({
            url: "<?= site_url('transaksi/ajax_update_total_harga') ?>",
            type: 'POST',
            data: {
                nomor_nota: {nomor_nota},
                total_harga: $('[name="total_harga"]').val()
            }
        });
    }
    function ajaxUpdateDiskon() {
        $.ajax({
            url: "<?= site_url('transaksi/ajax_update_diskon') ?>",
            type: 'POST',
            data: {
                nomor_nota: {nomor_nota},
                diskon: $('[name="total_diskon"]').val()
            }
        });
    }
    function ajaxUpdateTunai() {
        $.ajax({
            url: "<?= site_url('transaksi/ajax_update_tunai') ?>",
            type: 'POST',
            data: {
                nomor_nota: {nomor_nota},
                tunai: $('[name="tunai"]').val()
            }
        });
    }
    function ajaxUpdateKembali() {
        $.ajax({
            url: "<?= site_url('transaksi/ajax_update_kembali') ?>",
            type: 'POST',
            data: {
                nomor_nota: {nomor_nota},
                kembali: $('[name="kembali"]').val()
            }
        });
    }
    function hitungBayar() {
        var diskon_rad = $('[name="diskonRadio"]:checked').val();
        var diskon_before = $('[name="total_diskon"]').val();

        var diskon_auto = 0;
        var total_harga = $('[name="total_harga"]');
        var persen_diskon = $('[name="persen_diskon"]');
        var total_bayar = $('[name="total_bayar"]');

        if (total_bayar > 1000000) {
            diskon_auto += 25000;
            //console.log('diskon ' + diskon_auto);
        }

        //max diskon 500 ribu

        var total_diskon = 0;

        switch (diskon_rad) {
            case '1': // umum
                total_diskon = $('[name="total_diskon"]').val((total_harga.val() * (persen_diskon.val() / 100)).toFixed(0));
                break;
            case '2': // khusus
                total_diskon = $('[name="total_diskon"]').val(diskon_before);
                break;
        }

        var max_diskon = 500000;
        total_bayar.val((total_harga.val() - total_diskon.val()).toFixed(0));
        var tunai = $('[name="tunai"]');
        var kembali = $('[name="kembali"]');

        var hitung_kembalian = ((tunai.val() - total_bayar.val()).toFixed(0));
        if (hitung_kembalian > 0) {
            kembali.val(hitung_kembalian);
            tunai.removeClass('is-invalid');
            tunai.addClass('is-valid');
        } else {
            tunai.removeClass('is-valid');
            tunai.addClass('is-invalid');
            kembali.val(0);
        }

        ajaxUpdateTotalBayar();
        ajaxUpdateTotalHarga();
        ajaxUpdateKembali();
    }
    hitungBayar();
    function getTotalHarga() {
        $.ajax({
            url: "<?= site_url('transaksi/ajax_total_harga') ?>",
            type: 'POST',
            data: {
                nomor_nota: {nomor_nota}
            },
            dataType: 'json',
            beforeSend: function (xhr) {
                //code
            },
            success: function (data, textStatus, jqXHR) {
                //code
                if (data.status) {
                    $('[name="total_harga"]').val(data.total_harga);
                    hitungBayar();
                } else {
                    clearKalkulasi();
                }
            }
        });
    }
    getTotalHarga();
    //akhir hitung area

    //check all
    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    function tambah_produk() {
        save_method = 'add';
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
    }
    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
        getTotalHarga();
    }
    function save() {
        $('#btnSave').text('Menyimpan ...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable
        var url;

        if (save_method === 'add') {
            url = "<?php echo site_url('transaksi/ajax_add') ?>";
        }

        // ajax adding data to database
        var formData = new FormData($('#form_penjuaan_transaksi')[0]);
        formData.append('nama_produk', $("#id_produk option:selected").text());

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data) {
                //console.log(data);
                if (data.status) //if success close modal and reload ajax table
                {
                    reload_table();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error');
                        $('[name="' + data.inputerror[i] + '"]').next().next().text(data.error_string[i]);
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
                autoClearInput();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            }
        });
    }
    function hapus_produk(id) {
        if (confirm('Yakin ingin menghapus data ?'))
        {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('transaksi/ajax_delete') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
    function bulk_delete() {
        var list_id = [];
        $(".data-check:checked").each(function () {
            list_id.push(this.value);
        });
        if (list_id.length > 0)
        {
            if (confirm('Yakin ingin menghapus ' + list_id.length + ' data ?'))
            {
                $.ajax({
                    type: "POST",
                    data: {id: list_id},
                    url: "<?php echo site_url('transaksi/ajax_bulk_delete') ?>",
                    dataType: "JSON",
                    success: function (data)
                    {
                        if (data.status)
                        {
                            reload_table();
                        } else
                        {
                            alert('Gagal hapus data yang di centang\nHarap hubungi administrator.');
                        }
                        $('#check-all').prop('checked', false);
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
            }
        } else
        {
            alert('Tidak ada data yang dicentang');
        }
    }
    function reset_form() {
        $('#form_penjuaan_transaksi')[0].reset(); // reset form
    }
    function cetakNota() {
        //var siteUrl = '<!?= site_url('transaksi/cetak/{unique}') ?>';
        // var siteUrl = '<!?= site_url('pdf/cetak/{unique}') ?>';
        var siteUrl = '<?= site_url('pdf/nota/{unique}') ?>';
        var frame = 'cetak_nota';
        var winop = window.open(siteUrl, frame);
        
        winop.focus(); // necessary for IE >= 10
        winop.print();
        setInterval(function () {
            // winop.close();
            window.location.reload();
        }, 2000);

//
//        setInterval(function () {
//        }, 1000);
//        if (winop.location.href !== 'about:blank') {
//        }
    }
    function enableCetak() {
        $('#btnCetak').removeAttr('disabled');
        $('#btnCetak').click(function () {
            cetakNota();
        });
    }

    window.onbeforeprint = function () {
        console.log("Printing started...");
    };
    window.onafterprint = function () {
        console.log("Printing completed...");
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Form Produk</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="nama">Nama Produk</label>
                            <div class="col-md">
                                <input id="nama" name="nama" placeholder="Nama Produk" class="form-control" type="number" maxlength="128" min="3">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Harga</label>
                            <div class="col-md">
                                <input id="harga" name="harga" placeholder="Harga" class="form-control" type="number">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-minus-circle"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Bootstrap modal -->