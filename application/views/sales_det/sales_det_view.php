<script>
    window.jQuery || document.write('<script src="<?= base_url('assets/jquery/js/jquery.min.js') ?>"><\/script>');
</script>

<!-- DataTable -->
<?= link_tag(base_url('assets/datatables/datatables.min.css'), 'stylesheet', 'text/css') ?>
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<div class="card border-primary mb-3">
    <div class="card-body">
        <div class="table-responsive">
            <table id="table" class="table table-striped content-responsive">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">No. Transaksi</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nama Customer</th>
                        <th scope="col">Jumlah Barang</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">Diskon</th>
                        <th scope="col">Ongkir</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="2" class="text-right">Grand Total</td>
                        <td><span id="footer_grand_total" class="footer_grand_total"></span></td>
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

    $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('sales/ajax_list')  ?>",
                "type": "POST"
            },
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
                $('#footer_grand_total').text(extra.grand_total);
            },
            "initComplete": function(settings, json) {}
        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
</script>