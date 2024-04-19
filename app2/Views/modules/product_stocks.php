<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Penyesuaian Persedian Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Penyesuaian Persedian Barang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content"); ?>

<div class="row">
    <div class="col-md-12">
        <a href="<?= base_url('products/stocks/add') ?>" class='btn btn-primary float-right'>
            <i class='fa fa-plus'></i>
            Tambah
        </a>
        <div class="clearfix"></div>
        <div class="card mt-2">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penyesuaian Persediaan Barang</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-hover" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center' rowspan='2'>No</th>
                            <th class='text-center' rowspan='2'>Gudang</th>
                            <th class='text-center' rowspan='2'>Nama Barang</th>
                            <th class='text-center' rowspan='2'>Tgl</th>
                            <th class='text-center' colspan='3'>Jumlah</th>
                            <th class='text-center' rowspan='2'>Catatan / Ket</th>
                            <th class='text-center' rowspan='2'></th>
                        </tr>
                        <tr>
                            <th class='text-center'>Tercatat</th>
                            <th class='text-center'>Sebenarnya</th>
                            <th class='text-center'>Penyesuaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stockNo = 0;
                        foreach ($stocks as $stock){
                            $stockNo++;
                            ?>
                            <tr>
                                <td class='text-center'><?= $stockNo ?></td>
                                <td><?= $stock->warehouse_name ?></td>
                                <td><?= $stock->product_name ?></td>
                                <td class='text-right'><?= date("d-m-Y",strtotime($stock->stock_date)) ?></td>
                                <td class='text-right'><?= $stock->stock_qty_recorded ?> <?= $stock->product_unit ?></td>
                                <td class='text-right'><?= $stock->stock_qty_real ?> <?= $stock->product_unit ?></td>
                                <td class='text-right'><?= $stock->stock_qty ?> <?= $stock->product_unit ?></td>
                                <td><?= nl2br($stock->stock_details) ?></td>
                                <td class='text-center'>
                                    <a href="<?= base_url('products/stocks/'.$stock->stock_id.'/delete') ?>" class='btn btn-danger btn-sm' onclick="return confirm('Yakin hapus.?')" title="Hapus">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>