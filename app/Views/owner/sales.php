<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Penjualan (SO)</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="datatables-default">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal Transaksi</th>
                    <th class="text-center">Nama Sales</th>
                    <th class="text-center">Nama Pelanggan</th>
                    <th class="text-center">Tag sales</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($sales as $sale) {
                ?>
                <tr>
                    <td class="text-center"><?= $sale->sale_number ?></td>
                    <td class="text-center"><?= $sale->transaction_date ?></td>
                    <td class="text-center"><?= $sale->admin_name ?></td>
                    <td class="text-center"><?= $sale->contact_name ?></td>
                    <td class='text-center'><?= $sale->tag_name ?></td>
                    <td class="text-center"><a href="<?= base_url('owner/sales/'.$sale->id.'/manage') ?>" class="btn btn-sm btn-success"><i class="fas fa-cog"></i></a>
                    </td>
                </tr> 
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>