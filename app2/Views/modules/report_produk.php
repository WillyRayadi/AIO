<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Reports
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report Data Produk</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>


<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Data Produk</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('product/export_dataproduct') ?>" method="get" target="_blank">
                <div class="row">

                    <div class="col form-group">
                        <label class="font-weight-bold">Nama Produk</label>
                        <select name="productname" id="productname" class="form-control select2bs4">  
                             <?php foreach($brand as $item){ ?>
                                <option value="<?= $item->brand_name ?>"><?= $item->brand_name ?></option>
                             <?php } ?>
                        </select>
                    </div> 

                    <button class="col btn btn-success"style="width: 50%; height: 50%; margin-top: 32px;">
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