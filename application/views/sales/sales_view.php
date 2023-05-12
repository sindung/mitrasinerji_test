<script>
    window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');
</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<div class="card bg-primary mb-3">
    <div class="card-body">
        <form action="#" id="formSales" class="form-horizontal" method="POST">
            <div class="card border-primary mb-3">
                <div class="card-header">
                    <span class="card-title">Transaksi</span>
                </div>
                <div class="card-body">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-form-label col-md-1" for="kode">No.</label>
                            <div class="col-md">
                                <input id="kode" name="kode" placeholder="Nomor Transaksi" class="form-control" type="text" value="<?= $nomor_transaksi ?>" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-1" for="tgl">Tanggal</label>
                            <div class="col-md-3">
                                <input id="tgl" name="tgl" placeholder="Tanggal" class="form-control" type="date" value="<?= date('Y-m-d') ?>">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary mb-3">
                <div class="card-header">
                    <span class="card-title">Customer</span>
                </div>
                <div class="card-body">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-form-label col-md-1" for="cust_id">Kode</label>
                            <div class="col-md-4">
                                <input id="cust_id" name="cust_id" placeholder="ID Customer" class="form-control cursor-pointer" type="text" readonly title="Klik untuk membuka pop-up Customer">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-1" for="cust_name">Nama</label>
                            <div class="col-md">
                                <input id="cust_name" name="cust_name" placeholder="Nama Customer" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-1" for="cust_telp">Telp.</label>
                            <div class="col-md">
                                <input id="cust_telp" name="cust_telp" placeholder="Telp" class="form-control" type="tel" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary mb-3">
                <div class="card-body">
                    <h5>Tabel Barang</h5>
                    <hr />
                    <button type="button" class="btn btn-outline-success" id="tambah_sales"><i class="fas fa-fw fa-plus-circle"></i> Tambah</button>
                    <button type="button" class="btn btn-outline-secondary" id="reload_table"><i class="fas fa-fw fa-sync"></i> Segarkan</button>
                    <button type="button" class="btn btn-outline-danger" id="bulk_delete"><i class="fas fa-fw fa-trash"></i> Hapus Centang</button>

                    <hr />

                    <div class="table-responsive">
                        <table id="table" class="table table-striped content-responsive">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"><input type="checkbox" id="check-all"></th>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode Barang</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Harga Bandrol</th>
                                    <th scope="col">Diskon %</th>
                                    <th scope="col">Diskon (Rp)</th>
                                    <th scope="col">Harga Diskon</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="11"></td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Sub Total</td>
                                    <td>
                                        <input id="footer_subtotal" name="footer_subtotal" placeholder="Subtotal" class="form-control footer_hitung_total" type="number" min="0" readonly>
                                        <span class="help-block"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td class="align-middle">Diskon</td>
                                    <td>
                                        <input id="footer_diskon" name="footer_diskon" placeholder="Diskon" class="form-control footer_hitung_total" type="number" min="0">
                                        <span class="help-block"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td class="align-middle">Ongkir</td>
                                    <td>
                                        <input id="footer_ongkir" name="footer_ongkir" placeholder="Ongkir" class="form-control footer_hitung_total" type="number" min="0">
                                        <span class="help-block"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9"></td>
                                    <td>Total Bayar</td>
                                    <td>
                                        <input id="footer_total_bayar" name="footer_total_bayar" placeholder="Total Bayar" class="form-control footer_hitung_total" type="number" min="0" readonly>
                                        <span class="help-block"></span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button type="button" id="btnSaveSales" class="btn btn-light"><i class="fas fa-fw fa-save"></i> Simpan</button>
        <button type="button" id="btnCancelSales" class="btn btn-danger"><i class="fas fa-fw fa-minus-circle"></i> Batal</button>
    </div>
</div>

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?= base_url(); ?>';

    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('sales_det/ajax_list/') . $nomor_transaksi ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0], //first column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [1],
                    "orderable": false, //set not orderable
                },
            ],
            "drawCallback": function(settings) {
                $('.ubah-data').click(function() {
                    let id = $(this).data('id');
                    console.log(id);
                    ubah_sales(id);
                });
                $('.hapus-data').click(function() {
                    let id = $(this).data('id');
                    console.log(id);
                    hapus_sales(id);
                });

                let json = settings.json;
                let extra = json.extra;
                $('[name="footer_subtotal"]').val(extra.subtotal);
                footer_hitung_total();
            },
            "initComplete": function(settings, json) {}
        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $("input").on({
            'click': function() {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            },
            'change': function() {
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            },
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });

        //check all
        $("#check-all").click(function() {
            $(".data-check").prop('checked', $(this).prop('checked'));
        });

        $('#tambah_sales').click(function() {
            tambah_sales();
        });
        $('#reload_table').click(function() {
            reload_table();
        });
        $('#bulk_delete').click(function() {
            bulk_delete();
        });
        $('#btnSave').click(function() {
            save();
        });
        $('#btnSaveSales').click(function() {
            saveSales();
        });

        $('#cust_id').click(function() {
            pilih_cust();
        });
        $('#modal_cust .list-group-item-action').click(function() {
            let data = $(this).data();
            $('[name="cust_id"]').val(data.kode);
            $('[name="cust_name"]').val(data.name);
            $('[name="cust_telp"]').val(data.telp);
        });
        $('#modal_form [name="barang_nama"]').change(function() {
            let data = $(this).find(':selected').data();
            $('[name="barang_id"]').val(data.id);
            $('[name="barang_harga"]').val(data.harga);
        });
        $('.hitung_total').on({
            'change': function() {
                hitung_total();
            },
            'keyup': function() {
                hitung_total();
            },
        });
        $('.footer_hitung_total').on({
            'change': function() {
                footer_hitung_total();
            },
            'keyup': function() {
                footer_hitung_total();
            },
        });
    });

    function tambah_sales() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Barang'); // Set Title to Bootstrap modal title
    }

    function ubah_sales(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('sales_det/ajax_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id"]').val(data.id);
                $('[name="sales_id"]').val(data.kode);
                $('[name="barang_nama"]').val(data.barang_id).change();
                $('[name="qty"]').val(data.qty);
                $('[name="diskon_pct"]').val(data.diskon_pct);
                $('[name="diskon_nilai"]').val(data.diskon_nilai);
                $('[name="harga_diskon"]').val(data.harga_diskon);
                // $('[name="total"]').val(data.total);
                hitung_total();
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function save() {
        $('#btnSave').text('Menyimpan ...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable
        var url;

        if (save_method === 'add') {
            url = "<?php echo site_url('sales_det/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('sales_det/ajax_update') ?>";
        }

        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            }
        });
    }

    function saveSales() {
        var url = "<?php echo site_url('sales/ajax_add') ?>";

        // ajax adding data to database
        var formData = new FormData($('#formSales')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    window.open('<?= site_url('sales') ?>', '_self');
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
            }
        });
    }

    function hapus_sales(id) {
        if (confirm('Yakin ingin menghapus data ?')) {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('sales_det/ajax_delete') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }

    function bulk_delete() {
        var list_id = [];
        $(".data-check:checked").each(function() {
            list_id.push(this.value);
        });
        if (list_id.length > 0) {
            if (confirm('Yakin ingin menghapus ' + list_id.length + ' data ?')) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: list_id
                    },
                    url: "<?php echo site_url('sales_det/ajax_bulk_delete') ?>",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            reload_table();
                        } else {
                            alert('Gagal hapus data yang di centang\nHarap hubungi administrator.');
                        }
                        $('#check-all').prop('checked', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            }
        } else {
            alert('Tidak ada data yang dicentang');
        }
    }

    function pilih_cust() {
        $('#modal_cust').modal('show'); // show bootstrap modal
    }

    function hitung_total() {
        let harga_barang = $('[name="barang_harga"]').val();
        let qty = $('[name="qty"]').val();
        let diskon_pct = $('[name="diskon_pct"]').val() || 0;
        let diskon_nilai = $('[name="diskon_nilai"]').val() || 0;

        harga_barang = parseFloat($.trim(harga_barang));
        qty = parseInt($.trim(qty));
        diskon_pct = parseFloat($.trim(diskon_pct));
        diskon_nilai = parseFloat($.trim(diskon_nilai));

        let harga_diskon = harga_barang - diskon_nilai - (diskon_pct / 100 * harga_barang);
        let total = harga_diskon * qty;

        $('[name="harga_diskon"]').val(harga_diskon);
        $('[name="total"]').val(total);
    }

    function footer_hitung_total() {
        let footer_subtotal = $('[name="footer_subtotal"]').val() || 0;
        let footer_diskon = $('[name="footer_diskon"]').val() || 0;
        let footer_ongkir = $('[name="footer_ongkir"]').val() || 0;

        footer_subtotal = parseFloat($.trim(footer_subtotal));
        footer_diskon = parseFloat($.trim(footer_diskon));
        footer_ongkir = parseFloat($.trim(footer_ongkir));

        let footer_total_bayar = footer_subtotal - footer_diskon - footer_ongkir;

        $('[name="footer_total_bayar"]').val(footer_total_bayar);
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Form Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="sales_id">Sales ID</label>
                            <div class="col-md">
                                <input id="sales_id" name="sales_id" placeholder="Sales ID" class="form-control" type="text" value="<?= $nomor_transaksi ?>" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="barang_nama">Nama Barang</label>
                            <div class="col-md">
                                <span class="help-block"></span>
                                <select id="barang_nama" name="barang_nama" class="custom-select">
                                    <option selected disabled value="">Pilih...</option>
                                    <?php
                                    foreach ($barang_list as $barang) {
                                    ?>
                                        <option value="<?= $barang->kode ?>" data-id="<?= $barang->kode ?>" data-harga="<?= $barang->harga ?>"><?= $barang->nama ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="barang_id">Kode Barang</label>
                            <div class="col-md">
                                <input id="barang_id" name="barang_id" placeholder="Kode Barang" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="barang_harga">Harga Bandrol</label>
                            <div class="col-md">
                                <input id="barang_harga" name="barang_harga" placeholder="Harga Bandrol" class="form-control" type="number" min="0" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga">Qty</label>
                            <div class="col-md">
                                <input id="qty" name="qty" placeholder="Qty" class="form-control hitung_total" type="number" min="1">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="diskon_pct">Diskon %</label>
                            <div class="col-md">
                                <input id="diskon_pct" name="diskon_pct" placeholder="Diskon %" class="form-control hitung_total" type="number" min="0">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="diskon_nilai">Diskon Rp</label>
                            <div class="col-md">
                                <input id="diskon_nilai" name="diskon_nilai" placeholder="Diskon Rp" class="form-control hitung_total" type="number" min="0">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="harga_diskon">Harga Diskon</label>
                            <div class="col-md">
                                <input id="harga_diskon" name="harga_diskon" placeholder="Harga Diskon" class="form-control hitung_total" type="number" min="0" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="total">Total</label>
                            <div class="col-md">
                                <input id="total" name="total" placeholder="Total" class="form-control hitung_total" type="number" min="0" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-minus-circle"></i> Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_cust" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">List Customer</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <div class="list-group">
                    <?php
                    foreach ($customer_list as $key => $value) {
                    ?>
                        <a class="list-group-item list-group-item-action" data-kode="<?= $value->kode ?>" data-name="<?= $value->name ?>" data-telp="<?= $value->telp ?>"><?= $value->name ?></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-minus-circle"></i> Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End Bootstrap modal -->