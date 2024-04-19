<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Laporan Penjualan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report SO</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>


<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Data Penjualan Per Status</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('sales/export_status') ?>" method="get" target="_blank">
                <div class="row">
                    
                    <div class="col form-group">
                        <label class="font-weight-bold">Pilih Status Penjualan</label>
                        <select name="status" class="form-control select2bs4">
                            <option value="2">Disetujui</option>
                            <option value="4">Dikirim Sebagian</option>
                            <option value="5">Dikirim</option>
                            <option value="6">Selesai</option>
                        </select>
                    </div>

                    <div class="col form-group">
                        <label class="font-weight-bold">Mulai Tanggal</label>
                        <input class="form-control" name="tanggalawal" type="date" required></input>
                    </div>

                    <div class="col form-group">
                        <label class="font-weight-bold font-weight-italic">Sampai Tanggal</label>
                        <input class="form-control" name="tanggalakhir" type="date" required=""></input>
                    </div>

                    <button class="col btn btn-success" onclick="<?= base_url('sales/reports') ?>" style="width: 50%; height: 50%; margin-top: 32px;">
                        <i class="fas fa-file"></i>&nbsp; Cetak Laporan
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