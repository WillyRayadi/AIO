<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Histori Pengiriman
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Laporan)</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>
<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Data Histori Pengiriman</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('AdminSub/export_histori_pengiriman') ?>" method="get" target="_blank">
                <div class="row">
                    
                    <div class="col form-group">
                        <label class="font-weight-bold font-weight-italic">Role Akun</label>
                        <select class="form-control" name="roles">
                            <option value="3">Sales Grosir</option>
                            <option value="2">Sales Retail</option>
                        </select>
                    </div>

                    <div class="col form-group"> 
                        <label class="font-weight-bold">Mulai Tanggal</label>
                        <input class="form-control" name="tanggalawal" type="date"></input>
                    </div> 

                    <div class="col form-group">
                        <label class="font-weight-bold font-weight-italic">Sampai Tanggal</label>
                        <input class="form-control" name="tanggalakhir" type="date"></input>
                    </div> 

                    <button class="col btn btn-success" onclick="<?= base_url('sales/reports') ?>" style="width: 50%; height: 50%; margin-top: 32px;">
                        <i class="fas fa-download"></i>&nbsp; Cetak Laporan
                    </button>

                </div>
            </form>
        </div>
    </div>

    <br>
</div>

<script>
    $(document).ready(function() {
        $('#datatables-default').DataTable( {
            dom: 'Bfrtip',
            "bPaginate": false,
            "bInfo": false,
        } );
    } );
</script>

<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>