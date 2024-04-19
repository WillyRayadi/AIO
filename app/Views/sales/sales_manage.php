<?= $this->extend("general/template") ?>
<?= $this->section("page_title") ?>
Kelola Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/sales/sales'); ?>">Penjualan</a></li>
<li class="breadcrumb-item active">Kelola Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("sales/contacts/add/direct_sales_manage") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kontak</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type='hidden' name='sale' value="<?= $sale->id ?>">
                    <div class="form-group">
                        <label for="phone">No. Telepon</label>
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="No. Telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="nama" required>
                    </div>
                    <div class='form-group mt-4'>
                        <label>Tipe</label>
                        <br>
                        <label class="mx-2">
                            <input type='radio' name='type' value="1">
                            Pemasok
                        </label>
                        <label class="mx-2">
                            <input type='radio' name='type' value="2" checked>
                            Pelanggan
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="alamat" required></textarea>
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
<!-- End Of Modal Add -->

<!-- Modal Edit Qty Item -->
<form method="post" action="<?= base_url("sales/item/edit/qty") ?>">
    <div class="modal fade" id="modalEditQtyItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kuantitas Item</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type='hidden' name='sale' value="<?= $sale->id ?>">
                    <input type='hidden' name='warehouse' value="<?= $sale->warehouse_id ?>">
                    <input type='hidden' name='item' id="editItemID">
                    <input type='hidden' name='product' id="editItemProductID">

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <div id="textEditItemName"></div>
                    </div>
                    <div class="form-group">
                        <label>Kuantitas</label>
                        <input type='number' name='qty' id="editItemQty" class='form-control' placeholder="Kuantitas" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Add -->

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-<?= config("App")->orderStatusColor[$sale->status] ?>">
            <?= config("App")->orderStatuses[$sale->status] ?>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form method="post" action="<?= base_url('sales/sales/save') ?>">
                <div class="card-header bg-info">
                    <h5 class="card-title">Data Penjualan</h5>
                </div>
                <div class="card-body">
                    <input type='hidden' name='id' value="<?= $sale->id ?>">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No. Transaksi</label>
                                <input type='text' value="<?= $sale->number ?>" readonly class='form-control' placeholder="<?= "SO/" . date("y") . "/" . date("m") . "/[auto]" ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cabang Toko</label>
                                <input type="text" name="cabang_id" class="form-control text-uppercase" value="<?= $sale->cabang_id ?>" placeholder="Lokasi Cabang Toko">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tag</label>
                                <select name='tags[]' class="select2bs4 text-uppercase" id="tagSelect" multiple="multiple" style="width: 100%;">
                                    <?php
                                    foreach ($tags as $tag) {
                                        $saleTagsExplode = explode("#", $sale->tags);

                                        $thisTagSelected = "";
                                        foreach ($saleTagsExplode as $saleTag) {
                                            if ($tag->name == $saleTag) {
                                                $thisTagSelected = "selected";
                                            } else {
                                                if ($thisTagSelected === "selected") {
                                                    $thisTagSelected = "selected";
                                                } else {
                                                    $thisTagSelected = "";
                                                }
                                            }
                                        }
                                        echo "<option value='" . $tag->name . "' $thisTagSelected>" . $tag->name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Pelanggan (Kontak)
                                    <a href="javascript:void(0)" data-toggle='modal' data-target='#modalAdd'>
                                        <i class='fa fa-plus'></i>
                                        Tambah Kontak
                                    </a>
                                </label>
                                <select name='contact' id='contactSelect' required class='form-control text-uppercase select2bs4'>
                                    <option value="">--Pilih Pelanggan--</option>
                                    <?php
                                    foreach ($contacts as $contact) {
                                        if ($contact->id == $sale->contact_id) {
                                            $selectedContact = "selected";
                                        } else {
                                            $selectedContact = "";
                                        }
                                        echo "<option value='" . $contact->id . "' $selectedContact>" . $contact->name . " | " . $contact->phone . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat Pelanggan</label>
                                <textarea class='form-control text-uppercase' id="addressField" placeholder="Alamat Pelanggan" required name='invoice_address'><?= $sale->invoice_address ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Area Pengiriman</label>
                                <select name='location_id' required class='form-control select2bs4 text-uppercase'>
                                    <option value="">--Pilih Area--</option>
                                    <?php
                                    foreach ($locations as $location) {
                                        if ($location->id == $sale->location_id) {
                                            $selectedLocation = "selected";
                                        } else {
                                            $selectedLocation = "";
                                        }
                                        echo "<option value='" . $location->id . "' $selectedLocation>" . $location->name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select name='payment' id='paymentSelect' required class='form-control text-uppercase'>
                                    <option value="">--Pilih Metode Pembayaran--</option>
                                    <?php
                                    foreach ($payments as $payment) {
                                        if ($payment->id == $sale->payment_id) {
                                            $paymentSelected = "selected";
                                        } else {
                                            $paymentSelected = "";
                                        }
                                        echo "<option value='" . $payment->id . "' $paymentSelected>" . $payment->name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tgl. Transaksi</label>
                                <input type='date' id="dateField" value="<?= $sale->transaction_date ?>" name='transaction_date' class='form-control' required>
                            </div>

                            <div class="form-group">
                                <label>Tgl. Jatuh Tempo</label>
                                <input type='date' value="<?= $sale->expired_date ?>" id="expiredField" name='expired_date' class='form-control' required>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="form-label">Jenis Transaksi</label>
                                <select class="form-control select2bs4" name="transaction_type" required>
                                    <option value="">-- PILIH JENIS TRANSAKSI --</option>
                                    <option value="GROSIR" <?php echo ($sale->transaction_type == 'GROSIR') ? 'selected' : ''; ?>>GROSIR</option>
                                    <option value="ONLINE" <?php echo ($sale->transaction_type == 'ONLINE') ? 'selected' : ''; ?>>ONLINE</option>
                                    <option value="RETAIL" <?php echo ($sale->transaction_type == 'RETAIL') ? 'selected' : ''; ?>>RETAIL</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Order ID (Penjualan Online)</label>
                                <input class="form-control text-uppercase" type="text" name="order_id" value="<?= $sale->order_id ?>"></input>
                            </div>

                            <div class="form-group">
                                <label>Pajak (PPN)</label>
                                <select class="form-control text-uppercase" name='tax'>
                                    <option value='1' <?php if ($sale->tax == 1) echo 'selected'; ?>>TIDAK TERMASUK</option>
                                    <option value='<?= config("App")->ppn ?>' <?php if ($sale->tax == config("App")->ppn) echo 'selected'; ?>>TERMASUK</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Memo / Catatan</label>
                                <input class="form-control text-uppercase" placeholder="Memo / Catatan" name="sales_notes" value="<?= $sale->sales_notes ?>">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <?php if ($sale->contact_id != NULL) : ?>
                        <a href="<?= base_url('sales/' . $sale->id . '/manifest/print') ?>" class="btn btn-info">
                            <i class="fas fa-print"></i> Cetak Manifest
                        </a>
                    <?php endif ?>

                    <a href="<?= base_url('sales/sales/' . $sale->id . '/delete') ?>" onclick="return confirm('Yakin hapus penjualan (SO).?')" class='btn btn-danger float-right ml-2'>
                        <i class='fa fa-trash'></i>
                        Hapus
                    </a>
                    <button type='submit' class='btn btn-success float-right'>
                        <i class='fa fa-save'></i>
                        Simpan
                    </button>
                </div>
            </form>
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
            <div class="card-body">
                <form method="post" action="<?= base_url('sales/sale/item/add') ?>">
                    <input type='hidden' name='warehouse' value="<?= $sale->warehouse_id ?>">
                    <input type='hidden' name='sale' value="<?= $sale->id ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Barang</label>
                                <select name='product' required class="select2bs4" id="productSelect" style="width: 100%;">
                                    <option value="">--Pilih Barang--</option>
                                    <?php
                                    foreach ($products as $product) {
                                        echo "<option value='" . $product->id . "'>" . $product->name . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!--
                            <div class="form-group">
                                <b>Bundling Product</b>
                                <div id='ProductBundlingSelect'></div>
                            </div> -->

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Gudang</label>
                                <select name='warehouse' class='form-control' id="warehouse" required>
                                    <option value="">--Pilih Gudang--</option>
                                    <?php
                                    // foreach($warehouses as $warehouse){
                                    //     if($warehouse->id == $sale->warehouse_id){
                                    //         $selectedwarehouse = "selected";
                                    //     }else{
                                    //         $selectedwarehouse = "";
                                    //     }
                                    //     echo"<option value='".$warehouse->id."' $selectedwarehouse>".$warehouse->name."</option>";
                                    // }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kuantitas</label>
                                <input type='number' value='0' name='qty' id='productQtyInput' class='form-control' required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Pilih Harga</label>
                                <select required name='price' class='form-control' id='productPriceSelect'>
                                    <option value=''>--Pilih Barang Terlebih Dahulu--</option>
                                </select>
                            </div>
                        </div>


                    </div>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tulis Harga (Custom)</label>
                                <input type='number' name='custom_price' id="customPrice" readonly="true" class='form-control' placeholder='Pilih Barang Terlebih Dahulu'>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Promo / Gift</label>
                                <select name='promo' id="productPromoSelect" class='form-control'>
                                    <option value="">--Pilih Barang Terlebih Dahulu--</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Diskon Barang</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nominal atau Persen" name="discount">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php if ($sale->contact_id == NULL) : ?>
                                <?php else : ?>
                                    <button id="addItemBtn" type='submit' class='btn btn-info'>
                                        <i class='fa fa-plus'></i>
                                        Tambah Barang Ke Dalam Penjualan
                                    </button>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class='text-center'>Barang</th>
                                <th class='text-center'>Lokasi</th>
                                <th class='text-center'>Kuantitas</th>
                                <th class='text-center'>Harga</th>
                                <th class='text-center'>Promo</th>
                                <th class='text-center'>Diskon</th>
                                <th class='text-center'>Jumlah</th>
                                <th class='text-center'>Status</th>
                                <th class='text-center'>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sumPrice = 0;
                            foreach ($items as $item) {
                                $thisProduct = $db->table("products");
                                $thisProduct->where("id", $item->product_id);
                                $thisProduct = $thisProduct->get();
                                $thisProduct = $thisProduct->getFirstRow();

                                $thisWarehouse = $db->table('product_stocks');
                                // $thisWarehouse->select('warehouses.name');
                                $thisWarehouse->join('warehouses', 'product_stocks.warehouse_id = warehouses.id', 'left');
                                $thisWarehouse->where("product_stocks.sale_item_id", $item->id);
                                $thisWarehouse = $thisWarehouse->get();
                                $thisWarehouse = $thisWarehouse->getFirstRow();

                            ?>
                                <tr>
                                    <td><?= $thisProduct->name ?></td>
                                    <td class='text-center'>
                                        <?php if ($thisWarehouse->inden_warehouse_id != NULL && $thisWarehouse->inden_warehouse_id != 0) : ?>
                                            <?php
                                            $warehouses = $db->table('warehouses');
                                            $warehouses->where('warehouses.id', $thisWarehouse->inden_warehouse_id);
                                            $warehouses = $warehouses->get();
                                            $warehouses = $warehouses->getFirstRow();
                                            echo 'Inden ' . $warehouses->name;
                                            ?>
                                        <?php else : ?>
                                            <?php
                                            $warehouses = $db->table('warehouses');
                                            $warehouses->where('warehouses.id', $thisWarehouse->warehouse_id);
                                            $warehouses = $warehouses->get();
                                            $warehouses = $warehouses->getFirstRow();

                                            echo $warehouses->name;
                                            ?>
                                        <?php endif ?>
                                    </td>
                                    <td class='text-right'>
                                        <?= $item->quantity ?> <?= $thisProduct->unit ?>
                                        &nbsp;
                                        <?php
                                        $itemNameForEditQty = str_replace("'", "`", $thisProduct->name);
                                        $itemNameForEditQty = str_replace("\"", "``", $itemNameForEditQty);
                                        ?>
                                        <?php if ($item->need_approve == 0) : ?>
                                        <?php else : ?>
                                            <?php if ($item->approve_status == 1) : ?>
                                            <?php else : ?>
                                                <a href="javascript:void(0)" onclick="editQty('<?= $item->id ?>','<?= $item->product_id ?>','<?= $itemNameForEditQty ?>','<?= $item->quantity ?>')" data-toggle="modal" data-target="#modalEditQtyItem" class='text-success'>
                                                    <i class='fa fa-edit'></i>
                                                </a>
                                            <?php endif ?>
                                        <?php endif ?>
                                    </td>
                                    <td class='text-right'>(<?= $item->price_level ?>) Rp. <?= number_format($item->price, 0, ",", ".") ?></td>
                                    <td>
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
                                    <td class='text-right'>
                                        <?php if ($item->discount <= 100) : ?>
                                            <?php echo $item->discount ?>%
                                        <?php elseif ($item->discount >= 100) : ?>
                                            Rp.<?php echo number_format($item->discount, 0, ",", ".") ?>
                                        <?php endif ?>

                                        <?php if (!empty($item->gift)) : ?>
                                            <?php echo $item->gift ?>
                                        <?php endif ?>
                                    </td>
                                    <td class='text-right'>
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
                                    <td class='text-center'>
                                        <?php
                                        if ($item->need_approve != 0) {
                                            if ($item->approve_status == 0) {
                                                echo "<span class='badge badge-warning'>Menunggu Persetujuan <br>" . config("App")->needApprovers[$item->need_approve] . "</span>";
                                            } else {
                                                echo "<span class='badge badge-" . config("App")->product_price_status_colors[$item->approve_status] . "'>" . config("App")->product_price_statuses[$item->approve_status] . " <br>" . config("App")->needApprovers[$item->need_approve] . "</span>";
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class='text-center'>
                                        <a href="<?= base_url('sales/sales/' . $sale->id . '/item/' . $item->id . '/delete') ?>" class='btn btn-danger btn-sm' onclick="return confirm('Yakin hapus <?= $itemNameForEditQty ?> dari daftar penjualan.?')" title="Hapus">
                                            <i class='fa fa-trash'></i>
                                        </a>
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
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<script type="text/javascript">
    $("#contactSelect").change(function() {
        id = $(this).val()

        $.ajax({
            url: "<?= base_url('sales/ajax/sales/add/contact/data') ?>",
            data: {
                id: id
            },
            type: "POST",
            success: function(response) {
                response = JSON.parse(response)
                $("#addressField").html(response.address)
                $("#referenceField").val(response.no_reference)
            }
        })
    })

    $("#paymentSelect").change(function() {
        id = $(this).val()

        $.ajax({
            url: "<?= base_url('sales/ajax/sales/add/expired/data') ?>",
            data: {
                id: id
            },
            type: "POST",
            success: function(response) {
                $("#expiredField").val(response)
            }
        })
    })
</script>


<script>
    $("#productSelect").change(function() {
        $.ajax({
            url: "<?= base_url('sales/ajax/sale/product/stocks') ?>",
            type: "post",
            data: {
                product: $(this).val(),
            },
            success: function(html) {
                // console.log(html);
                myText = html.split("~");
                stocks = parseInt(myText[0])

                // $("#productQtyInput").attr("max",stocks)
                $("#productQtyInput").attr("min", 1)

                // if(stocks <= 0){
                //     $("#addItemBtn").attr("disabled",true)
                //     $("#productQtyInput").val(0)
                // }else{
                //     $("#addItemBtn").attr("disabled",false)                
                //     $("#productQtyInput").val(1)
                // }

                if (stocks > 10) {
                    stocks = "10+"
                } else {
                    stocks = stocks
                }

                $("#productStockPreview").html(stocks + " " + myText[1])

            }
        })

        load_warehouse($(this).val(), '');

        $.ajax({
            url: "<?= base_url('sales/ajax/sale/product/prices') ?>",
            type: "post",
            data: {
                product: $(this).val(),
            },
            success: function(html) {
                // console.log(html);
                $("#productPriceSelect").html(html)
            }
        })

        $.ajax({
            url: "<?= base_url('sales/ajax/sale/product/promos') ?>",
            type: "post",
            data: {
                product: $("#productSelect").val(),
                price_level: $(this).val()
            },
            success: function(html) {
                // console.log(html);
                $("#productPromoSelect").html(html)
            }
        })

        $("#customPrice").attr("readonly", false)
        $("#customPrice").attr("placeholder", "Silahkan tulis harga di sini")
    })

    $("#productPriceSelect").change(function() {
        $.ajax({
            url: "<?= base_url('sales/ajax/sale/product/promos') ?>",
            type: "post",
            data: {
                product: $("#productSelect").val(),
                price_level: $(this).val()
            },
            success: function(html) {
                // console.log(html);
                $("#productPromoSelect").html(html)
            }
        })

        $("#customPrice").attr("readonly", false)
        $("#customPrice").attr("placeholder", "Silahkan tulis harga di sini")
    })

    function editQty(item, product, name, qty) {
        $("#editItemID").val(item)
        $("#editItemProductID").val(product)
        $("#textEditItemName").html(name)
        $("#editItemQty").val(qty)
    }

    function load_warehouse(id_product, warehouse_id) {
        $.ajax({
            url: "<?= base_url('sales/ajax/sale/product/all') ?>",
            type: "post",
            data: {
                product: id_product,
                warehouse_id: warehouse_id,
            },
            success: function(html) {


                $("#warehouse").html(html)

                // console.log(html);

            }
        })
    }
</script>
<script>
    var nameInput = document.getElementById("name");

    nameInput.addEventListener("input", function() {
        // Mengubah nilai input menjadi huruf besar (uppercase)
        this.value = this.value.toUpperCase();
    });
</script>


<?= $this->endSection() ?>