<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Data Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Data Barang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>


<div class="container-fluid mt-4">    
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Nomor SKU</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 0;
                            foreach ($products as $product) {
                                $d++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= $d ?></td>
                                    <td>
                                        <?php
                                        $qCode = $db->query("select * from codes where id='" . $product->code_id . "' limit 0,1");
                                        $dCode = $qCode->getFirstRow();
                                        echo $dCode->name;
                                        ?>
                                    </td>
                                    <td><?= $product->sku_number ?></td>
                                    <td>
                                        <?php
                                        $qCategory = $db->query("select * from categories where id='" . $product->category_id . "' limit 0,1");
                                        $dCategory = $qCategory->getFirstRow();
                                        echo $dCategory->name;
                                        ?>
                                    </td>
                                    <td><?= $product->name ?></td>
                                    <!-- <td class="text-center">
                                        <?php
                                        $qSum = $db->query("select sum(debit) as 'sum_in', sum(credit) as 'sum_out' from stocks where product_id='" . $product->id . "'");
                                        $rSum = $qSum->getFirstRow();
                                        $dSumIn = $rSum->sum_in;
                                        $dSumOut = $rSum->sum_out;
                                        ?>
                                        <?php
                                        $sumGoodStock = $dSumIn - $dSumOut;
                                        ?>
                                        <?= $sumGoodStock; ?>
                                        <?= $product->unit ?>
                                    </td> -->
                                    <td><?= $product->unit ?></td>
                                    <td><?= $product->details ?></td>
                                    <td class='text-center'>
                                        <a href="<?= base_url('spv/grosir/products/'.$product->id.'/manage') ?>" title="Kelola" class="btn btn-success btn-sm text-white">
                                            <i class='fa fa-cog'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container-fluid -->


<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>