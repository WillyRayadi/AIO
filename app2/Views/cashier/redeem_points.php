<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Redeem Point
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Redeem Point</li>
<?= $this->endSection() ?>
<?= $this->section("page_content") ?>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Data Redeem</h5>
        <button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-plus"></i> Tambah Data
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatables-default">
                <thead>
                    <tr>
                        <th class="text-center">Nomer Redeem</th>
                        <th class="text-center">Nama Pelanggan</th>
                        <th class="text-center">Tanggal Redeem</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($value as $values) { ?>
                    <tr>
                        <td class="text-center"><?= $values->number ?></td>
                        <td class="text-center"><?= $values->contact_name ?></td>
                        <td class="text-center"><?= $values->dates ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('cashier/user/redeem/manage/'.$values->id) ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-cog"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>