<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<style>
    .contacts{
        text-align: left !important;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class='table table-striped table-bordered' id="data-penjualan">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tgl. Transaksi</th>
                            <th>Sales</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>Tags</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        
        $('#data-penjualan').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= base_url("ajax/sales") ?>',
            order: [],
            columns: [
                {data: "number"},
                {data: "transaction_date"},
                {data: "admin_name"},
                {
                    data: null,
                    render: function(data, type, row){
                        return "<p class='contacts'>"+ row.contact_name + " | " + row.contact_phone +"</p>";
                    }
                },
                {
                    data: null,
                    render: function(data, type, row){
                        const status = row.status;
                        
                        if(status == 1){
                            return '<span class="badge badge-warning">Menunggu Persetujuan</span>';
                        }else if(status == 2){
                            return '<span class="badge badge-success">Disetujui</span>';
                        }else if(status == 3){
                            return '<span class="badge badge-danger">Dibatalkan</span>';
                        }else if(status == 4){
                            return '<span class="badge badge-primary">Dikirim Sebagian</span>';
                        }else if(status == 5){
                            return '<span class="badge badge-info">Dikirim</span>';
                        }else if(status == 6){
                            return '<span class="badge badge-dark">Selesai</span>';
                        }
                    }
                },
                {data: "tags"},
                {
                    data: null,
                    render: function(data, type, row){
                        return '<a href="<?= base_url('sales') ?>/' + row.id + '/manage" class="btn btn-success btn-sm" title="Kelola Pesanan Penjualan"><i class="fa fa-cog"></i></a>';
                    }
                }
            ]
        });
    });
</script>

<?= $this->endSection() ?>