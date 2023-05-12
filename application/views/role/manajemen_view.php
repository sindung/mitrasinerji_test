<script>window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<div class="card border-primary mb-3">
    <div class="card-body">
        <button class="btn btn-outline-success" id="tambah_role"><i class="fas fa-fw fa-plus-circle"></i> Tambah</button>
        <button class="btn btn-outline-secondary" id="reload_table"><i class="fas fa-fw fa-sync"></i> Segarkan</button>
        <button class="btn btn-outline-danger" id="bulk_delete"><i class="fas fa-fw fa-trash"></i> Hapus Centang</button>

        <hr/>

        <h5>Tabel</h5>
        <div class="table-responsive">
            <table id="table" class="table table-striped content-responsive">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="check-all"></th>
                        <th scope="col">Nama</th>
                        <th scope="col">Akses Nota</th>
                        <th scope="col">Akses Superadmin</th>
                        <th scope="col">Akses Riwayat</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var base_url = '<?= base_url(); ?>';

    $(document).ready(function () {
        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('role/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                },
            ],
            "drawCallback": function( settings ) {
                $('.ubah-data').click(function () {
                    let id = $(this).data('id');
                    console.log(id);
                    ubah_role(id);
                });
                $('.hapus-data').click(function () {
                    let id = $(this).data('id');
                    console.log(id);
                    hapus_role(id);
                });
            }
        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $('input[type="text"]').change(function () {
            trigger_change($(this));
        });
        $('input[type="checkbox"]').change(function () {
//            trigger_change($(this));
        });
        $('textarea').change(function () {
            trigger_change($(this));
        });
        $('select').change(function () {
            trigger_change($(this));
        });

        //check all
        $("#check-all").click(function () {
            $(".data-check").prop('checked', $(this).prop('checked'));
        });
        
        $('#tambah_role').click(function () {
            tambah_role();
        });
        $('#reload_table').click(function () {
            reload_table();
        });
        $('#bulk_delete').click(function () {
            bulk_delete();
        });
        
    });

    function trigger_change(elem) {
        if (elem.val() == '' || !elem.is(':checked')) {
            elem.addClass('is-invalid').removeClass('is-valid').after('');
        } else {
            elem.addClass('is-valid').removeClass('is-invalid').after('');
        }
    }
    function tambah_role()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Role'); // Set Title to Bootstrap modal title
    }
    function ubah_role(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('role/ajax_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="id"]').val(data.id);
                $('[name="name"]').val(data.name);
                $('[name="akses_nota"]').attr('checked', false);
                $('[name="akses_super"]').attr('checked', false);
                $('[name="akses_history"]').attr('checked', false);
                if (data.nota == '1') {
                    $('[name="akses_nota"]').attr('checked', true);
                }
                if (data.super == '1') {
                    $('[name="akses_super"]').attr('checked', true);
                }
                if (data.history == '1') {
                    $('[name="akses_history"]').attr('checked', true);
                }

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Role'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    function reload_table()
    {
        table.ajax.reload(null, false); //reload datatable ajax
    }
    function save()
    {
        $('#btnSave').text('Menyimpan ...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable
        var url;

        if (save_method === 'add') {
            url = "<?php echo site_url('role/ajax_add') ?>";
        } else {
            url = "<?php echo site_url('role/ajax_update') ?>";
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
            success: function (data)
            {
                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                } else
                {
                    for (var i = 0; i < data.inputerror.length; i++)
                    {
                        var currentElem = $('[name="' + data.inputerror[i] + '"]');
                        currentElem.nextAll('.invalid-feedback').remove();
                        if (currentElem.nextAll('.invalid-feedback').length <= 0) {
                            currentElem.addClass('is-invalid').after('<div class="invalid-feedback">' + data.error_string[i] + '</div>');
                        }
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable
            }
        });
    }
    function hapus_role(id)
    {
        if (confirm('Yakin ingin menghapus data ?'))
        {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('role/ajax_delete') ?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
    function bulk_delete()
    {
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
                    url: "<?php echo site_url('role/ajax_bulk_delete') ?>",
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
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Form Role</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="akses_nota" name="akses_nota" value="1">
                                <label class="custom-control-label" for="akses_nota">Akses Nota</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="akses_super" name="akses_super" value="1">
                                <label class="custom-control-label" for="akses_super">Akses Super</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="akses_history" name="akses_history" value="1">
                                <label class="custom-control-label" for="akses_history">Akses History</label>
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