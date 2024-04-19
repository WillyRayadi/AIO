<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Penjualans (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/sales/grosir/sales'); ?>">Penjualan</a></li>
<li class="breadcrumb-item active">Kelola Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<form method="post" action="<?= base_url("sales/comment/add") ?>">
    <input type='hidden' name='sale_id' value="<?= $sale->id ?>">
    <input type='hidden' name='admin_id' value="<?= $sale->admin_id ?>">
    <input type='hidden' name='customer' value="<?= $sale->contact_id ?>">
    <input type='hidden' name='status' value='<?= $sale->status ?>'>

    <div class="modal fade" id="modalAddContact" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Perubahan Status</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="number">Nomer SO</label>
                        <input type="text" class="form-control" name="sale_id" value="<?= $sale->number ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" value="<?= $contact->name ?>" disabled class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Nama Produk</label>
                        <select id="select" name="product_id" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php
                            foreach ($goods as $good) {
                                echo "<option value='" . $good->id . "'>" . $good->product_name . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="qty_edit">Ubah Qty</label>
                        <input type="number" name="qty_edit" class="form-control" placeholder="optional">
                    </div>

                    <div class="form-group">
                        <label for="harga_edit">Ubah Harga</label>
                        <input type="number" name="harga_edit" class="form-control" placeholder="optional">
                    </div>

                    <div class="form-group">
                        <label for="alasan_status">Alasan</label>
                        <input type="text" class="form-control" name="alasan_status" placeholder="Alasan Perubahan">
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>

            </div>
        </div>
    </div>
</form>



<div class="row">
    <div class="col-md-12">
        <div class="alert alert-<?= config("App")->orderStatusColor[$sale->status] ?>">
            <?= config("App")->orderStatuses[$sale->status] ?>
            <a class="float-right btn btn-sm btn-success" style="text-decoration: none;" data-target="#modalAddContact" data-toggle="modal">Edit Data</a>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No. Transaksi</label>
                            <br>
                            <?= $sale->number ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Sales</label>
                        <br>
                        <?= $admin->name ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pelanggan (Kontak)</label>
                            <br>
                            <?= $contact->name ?> | <?= $contact->phone ?>
                        </div>
                        <div class="form-group">
                            <label>Alamat Pelanggan</label>
                            <br>
                            <?= nl2br($sale->invoice_address) ?>
                        </div>
                        <div class="form-group">
                            <label>Memo / Catatan (Sales)</label>
                            <br>
                            <?= nl2br($sale->sales_notes) ?>
                        </div>
                        <div class="form-group">
                            <label>Memo / Catatan (Gudang)</label>
                            <br>
                            <?= nl2br($sale->warehouse_notes) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tgl. Transaksi</label>
                            <br>
                            <?= date("d-m-Y", strtotime($sale->transaction_date)) ?>
                        </div>
                        <div class="form-group">
                            <label>Tgl. Jatuh Tempo</label>
                            <br>
                            <?= date("d-m-Y", strtotime($sale->expired_date)) ?>
                        </div>
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <br>
                            <?= $payment->name ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tag</label>
                            <br>
                            <?= $sale->tags ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Barang Pada Penjualan Ini</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class='text-center'>Barang</th>
                            <th class='text-center'>Lokasi</th>
                            <th class='text-center'>Kuantitas</th>
                            <th class='text-center'>Harga</th>
                            <th class='text-center'>Promo</th>
                            <th class='text-center'>Diskon</th>
                            <th class='text-center'>Status</th>
                            <th class='text-center'>Jumlah</th>
                            <th class='text-center'>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sumPrice = 0;
                        foreach ($items as $item) {
                            $thisProduct = $db->table("products");
                            $thisProduct->where("products.id", $item->product_id);
                            $thisProduct = $thisProduct->get();
                            $thisProduct = $thisProduct->getFirstRow();

                            $thisWarehouse = $db->table('product_stocks');
                            $thisWarehouse->select('warehouses.name');
                            $thisWarehouse->join('warehouses', 'product_stocks.warehouse_id = warehouses.id', 'left');
                            $thisWarehouse->where("product_stocks.sale_item_id", $item->id);
                            $thisWarehouse = $thisWarehouse->get();
                            $thisWarehouse = $thisWarehouse->getFirstRow();

                            $QtyKeluar = empty($item->QtyKeluar) ? 0 : $item->QtyKeluar;

                            $QtySO = $item->quantity;

                            if (($QtySO - $QtyKeluar) == 0) {
                                $statusSODetail = 'Dikirim';
                                $aksi = '<a href="' . base_url('sales/sale/retur') . '" class="btn btn-sm btn-success"><i class="fas fa-exchange-alt"></i></a>';
                            } elseif (($QtySO - $QtyKeluar) > 0) {
                                $statusSODetail = 'Dikirim Sebagian';
                                $aksi = '<a href="' . base_url('sales/sale/retur') . '" class="btn btn-sm btn-success"><i class="fas fa-exchange-alt"></i></a>';
                            }

                            if (($QtySO - $QtyKeluar) == $QtySO) {
                                $statusSODetail = 'Disetujui';
                                $aksi = '<a href="' . base_url('sale/sales/' . $sale->id . '/item/' . $item->id . '/deletes') . '" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                            }

                        ?>
                            <tr>
                                <td class='text-center'>
                                    <?= $thisProduct->name ?>
                                    <?php
                                    $products =  $db->table('return_item');
                                    $products->select('sale_items.product_id');
                                    $products->where('return_item.sale_item_id', $item->id);
                                    $products->join('sale_items', 'return_item.sale_item_id = sale_items.id', 'left');
                                    $products = $products->get();
                                    $products = $products->getResultObject();

                                    if ($products != NULL) {
                                        echo "<hr>";
                                        echo "Retur :";
                                        echo "<ul>";
                                        foreach ($products as $product) {
                                            $datas = $db->table('products');
                                            $datas->select('products.name as product_name');
                                            $datas->where('products.id', $product->product_id);
                                            $datas = $datas->get();
                                            $datas = $datas->getFirstRow();

                                            echo "<li>" . $datas->product_name . "</li>";
                                        }
                                        echo "</ul>";
                                    }
                                    ?>
                                </td>
                                <td class='text-center'>
                                    <?= $thisWarehouse->name ?>

                                    <?php
                                    $warehouses = $db->table('return_item');
                                    $warehouses->select('warehouses.name as warehouse_name');
                                    $warehouses->where('return_item.sale_item_id', $item->id);
                                    $warehouses->join('warehouses', 'return_item.warehouse_id = warehouses.id', 'left');
                                    $warehouses = $warehouses->get();
                                    $warehouses = $warehouses->getFirstRow();

                                    if ($warehouses != NULL) {
                                        echo "<hr>";
                                        echo $warehouses->warehouse_name;
                                    }

                                    ?>
                                </td>

                                <td class='text-center'>
                                    <?= $item->quantity ?> <?= $thisProduct->unit ?>
                                    <?php
                                    $returs = $db->table('return_item');
                                    $returs->select('return_item.quantity');
                                    $returs->where('return_item.sale_item_id', $item->id);
                                    $returs = $returs->get();
                                    $returs = $returs->getResultObject();

                                    if ($returs != NULL) {
                                        echo "<br> <br>";
                                        echo "<hr>";
                                        foreach ($returs as $retur) {
                                            echo $retur->quantity . " Unit";
                                        }
                                    }
                                    ?>
                                </td>
                                <td class='text-center'>Rp. <?= number_format($item->price, 0, ",", ".") ?> (<?= $item->price_level ?>)</td>
                                <td class='text-center'>
                                    <?php
                                    if ($item->promo_id == 0) {
                                        echo "--Tanpa Promo--";
                                        $discountItem = 0;
                                    } else {
                                        $thisPromo = $db->table("promos");
                                        $thisPromo->where("id", $item->promo_id);
                                        $thisPromo = $thisPromo->get();
                                        $thisPromo = $thisPromo->getFirstRow();

                                        echo "(" . $thisPromo->code . ") &nbsp;" . $thisPromo->details;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($item->discount <= 100) : ?>
                                        <?php echo $item->discount ?>%
                                    <?php elseif ($item->discount >= 100) : ?>
                                        Rp.<?php echo number_format($item->discount, 0, ",", ".") ?>
                                    <?php endif ?>

                                    <?php if (!empty($item->gift)) : ?>
                                        <?php echo $item->gift ?>
                                    <?php endif ?>

                                </td>
                                <td class="text-center"><?= $statusSODetail ?></td>
                                <td class='text-center'>
                                    <?php if ($item->discount <= 100) : ?>
                                        <?php
                                        $thisPriceCount = $item->price * $item->quantity;
                                        $discountCalculate = $thisPriceCount * $item->discount / 100;
                                        $sumDiscountCalculate = $thisPriceCount - $discountCalculate;
                                        $taxCalculate = $sumDiscountCalculate * $item->tax / 100;
                                        $sumPriceCalculate = $sumDiscountCalculate;

                                        echo "Rp. " . number_format($sumPriceCalculate, 0, ",", ".");

                                        $sumPrice += $sumPriceCalculate;
                                        ?>
                                    <?php elseif ($item->discount >= 100) : ?>
                                        <?php
                                        $thisPriceCount = $item->price * $item->quantity;
                                        $discountCalculate = ($item->discount < $thisPriceCount) ? $item->discount : $thisPriceCount;
                                        $sumDiscountCalculate = $thisPriceCount - $discountCalculate;
                                        $taxCalculate = $sumDiscountCalculate * $item->tax / 100;
                                        $sumPriceCalculate = $sumDiscountCalculate + $taxCalculate;

                                        echo "Rp. " . number_format($sumPriceCalculate, 0, ",", ".");

                                        $sumPrice += $sumPriceCalculate;
                                        ?>

                                    <?php endif ?>
                                </td>
                                <td class="text-center">
                                    <?= $aksi ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class='text-right' colspan='8'>TOTAL</th>
                            <th class='text-right'>Rp. <?= number_format($sumPrice, 0, ",", ".") ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>


<?= $this->endSection() ?>