<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Rumus Harga Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Rumus Harga Barang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-4">
        <form method="post" action="<?= base_url('products/prices/add') ?>">
            <div class="card">
                <div class="card-header bg-info">
                    <h5 class="card-title">Tambah Rumus</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Kode Rumus</label>
                        <input type='text' name='code' placeholder='Kode Rumus' required class='form-control'>
                        <small class='text-help'>Berikan kode untuk masing - masing rumus harga</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type='submit' class='btn btn-info'>
                        <i class='fa fa-plus'></i>
                        Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Rumus</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>Kode Rumus</th>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($prices as $price) : ?>
                        <tr>
                            <td class='text-center'><?= $price->code ?></td>
                            <td class='text-center'>
                                <a href="<?= base_url('products/prices/'.$price->id.'/manage') ?>" class='btn btn-success btn-sm' title="Kelola">
                                    <i class='fa fa-edit'></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>