<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Harga Barang Yang Perlu Persetujuan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Harga Barang Yang Perlu Persetujuan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                Data Harga Barang Yang Perlu Persetujuan
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hovered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Kode Barang</th>
                            <th class='text-center'>No. SKU Barang</th>
                            <th class='text-center'>Kategori Barang</th>
                            <th class='text-center'>Nama Barang</th>
                            <th class='text-center'>Harga Ke-</th>
                            <th class='text-center'>Nominal Harga</th>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pno = 0;
                        foreach($prices as $price){
                            $pno++;
                            ?>
                            <tr>
                                <td class='text-center'><?= $pno ?></td>
                                <td class='text-center'><?= $price->code_name ?></td>
                                <td class='text-center'><?= $price->product_sku_number ?></td>
                                <td><?= $price->category_name ?></td>
                                <td><?= $price->product_name ?></td>
                                <td class='text-center'><?= $price->price_level ?></td>
                                <td class='text-right'>
                                    <?php
                                    $priceThisLevel = $price->product_price + ($price->product_price * $price->price_percentage / 100);
                                    $priceThisLevel = round(($priceThisLevel + config("App")->priceRound / 2) / config("App")->priceRound) * config("App")->priceRound;
                                    echo "Rp. ".number_format($priceThisLevel,2,",",".");
                                    ?>
                                </td>
                                <td class='text-center'>
                                    <a href="<?= base_url('spv/grosir/products/'.$price->product_id.'/manage') ?>" title="Kelola" class="btn btn-success btn-sm text-white">
                                        <i class='fa fa-edit'></i>
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

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>