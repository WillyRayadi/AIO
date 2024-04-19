<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Laporan Stok Per Gudang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report Per Gudang</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Laporan Stok Per Gudang</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url("product/export_per_warehouse") ?>" method="POST">
            <div class="row">
                <div class="col-sm">
                    <label>Pilih Gudang</label>
                    <select name="warehouse[]" id="warehouses" class="form-control select2bs4" multiple required>
                        <?php foreach ($warehouses as $warehouse) : ?>
                            <option value="<?= $warehouse->id ?>"><?= $warehouse->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm">
                    <button class="col btn btn-success" style="margin-top:31px;">
                        <i class="fas fa-file"></i>&nbsp; Cetak Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>