<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pembelian Barang (PD)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active"> Pembelian Barang (PD)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- End Of Modal Add Contact --> 

<div class='row'>
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Pembelian Barang (PD)</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-hover" id="datatables-default">
                    
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Nomer Transaksi</th>
                            <th class='text-center'>Pemasok</th>
                            <th class='text-center'>Gudang</th>
                            <th class='text-center'>Tanggal</th>
                            <th class='text-center'>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $d = 0;
                        ?>
                        <?php foreach ($good_buys as $good_buy) : ?>
                            <?php $d++ ?>
                            <tr>
                                <td class="text-center"><?= $d ?></td>
                                <td><?= $good_buy->number ?></td>
                                <td><?= $good_buy->contact_name ?></td>
                                <td><?= $good_buy->warehouse_name ?></td>
                                <td><?= $good_buy->date ?></td>
                                <td><?= $good_buy->notes ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('audit/product_buys_manage') . '/' . $good_buy->id ?>" title="Kelola" class="btn btn-success btn-sm text-white">
                                        <i class='fa fa-cog'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>