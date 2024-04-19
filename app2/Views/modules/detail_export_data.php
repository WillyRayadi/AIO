<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
<h1>Kelola Data</h1>
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"></li>
<li class="breadcrumb-item active">Kelola Data</li>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Data Produk</h3>
                <a href="<?= base_url('product/export'); ?>" class="float-right btn btn-sm btn-success"><i class='fas fa-export-excel'></i> Export Data</a>
            </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="datatables-default">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Produk</th>
                            <th class="text-center">SKU Produk</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Harga Utama</th>
                            <th class="text-center">Harga Ke-2</th>
                            <th class="text-center">Harga Ke-3</th>
                            <th class="text-center">Harga Ke-4</th>
                            <th class="text-center">Harga Ke-5</th>
                            <th class="text-center">Harga Ke-6</th>
                            <th class="text-center">Harga Ke-7</th>
                            <th class="text-center">Harga Ke-8</th>
                            <th class="text-center">Harga Ke-9</th>
                            <th class="text-center">Harga Ke-10</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dataproducts as $product){ 
                            $harga = ([
                                $product->plus_one,
                                $product->plus_two,
                                $product->plus_three,
                                $product->plus_four,
                                $product->plus_five,
                                $product->plus_six,
                                $product->plus_seven,
                                $product->plus_eight,
                                $product->plus_nine,
                                $product->plus_ten
                            ]);

                            $basePrice = $product->product_price;
                        ?> 
                            <tr>
                                <td><?= $product->product_name ?></td>
                                <td class="text-center"><?= $product->sku_number ?></td>
                                <td class="text-left"><?= $product->category_name ?></td>
                                <?php
                                    for ($p = 0; $p < 10; $p++){
                                        $basePrice += $harga[$p];
                                        echo '<td class="text-center">Rp.' . number_format($basePrice, 0, ",", ".") . '</td>';
                                    }
                                ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection()?>