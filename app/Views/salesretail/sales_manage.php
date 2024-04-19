<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/sales/retail/sales'); ?>">Penjualan</a></li>
<li class="breadcrumb-item active">Kelola Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

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
            <form method="post" action="<?= base_url('sales/retail/sales/save') ?>">
                <div class="card-header bg-info">
                    <h5 class="card-title">Data Penjualan</h5>
                </div>
                <div class="card-body">
                    <input type='hidden' name='id' value="<?= $sale->id ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pelanggan (Kontak)</label>
                                <select name='contact' class='form-control'>
                                    <?php
                                    foreach($contacts as $contact){
                                        if($contact->id == $sale->contact_id){
                                            $selectedContact = "selected";
                                        }else{
                                            $selectedContact = "";
                                        }
                                        echo"<option value='".$contact->id."' $selectedContact>".$contact->name." | ".$contact->phone."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Alamat Penagihan</label>
                                <textarea class='form-control' placeholder="Alamat Penagihan" required name='invoice_address'><?= $sale->invoice_address ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Memo / Catatan</label>
                                <textarea class='form-control' placeholder="Memo / Catatan" name='sales_notes'><?= $sale->sales_notes ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tgl. Transaksi</label>
                                <input type='date' value="<?= $sale->transaction_date ?>" name='transaction_date' class='form-control' required>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Jatuh Tempo</label>
                                <input type='date' name='expired_date' value="<?= $sale->expired_date ?>" class='form-control' required>
                            </div>
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select name='payment' class='form-control'>
                                    <?php
                                    foreach($payments as $payment){
                                        if($payment->id == $sale->payment_id){
                                            $selectedPayment = "selected";
                                        }else{
                                            $selectedPayment = "";
                                        }
                                        echo"<option value='".$payment->id."' $selectedPayment>".$payment->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>No. Transaksi</label>
                                <input type='text' readonly class='form-control' value="<?= $sale->number ?>">
                            </div>
                            <div class="form-group">
                                <label>No. Referensi Pelanggan</label>
                                <input type='text' name='reference' value="<?= $sale->customer_reference_code ?>" class='form-control'>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tag</label>
                                <select name='tags[]' class="select2bs4" id="tagSelect" multiple="multiple" style="width: 100%;">
                                <?php
                                foreach($tags as $tag){
                                    $saleTagsExplode = explode(", ",$sale->tags);

                                    $thisTagSelected = "";
                                    foreach($saleTagsExplode as $saleTag){
                                        if($tag->name == $saleTag){
                                            $thisTagSelected = "selected";
                                        }else{
                                            if($thisTagSelected === "selected"){
                                                $thisTagSelected = "selected";
                                            }else{
                                                $thisTagSelected = "";
                                            }
                                        }
                                    }
                                    echo"<option value='".$tag->name."' $thisTagSelected>".$tag->name."</option>";
                                }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Gudang</label>
                                <input type='text' readonly value="<?= $warehouse->name ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type='submit' class='btn btn-success float-right'>
                        <i class='fa fa-save'></i>
                        Simpan Data Penjualan (SO)
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
                <form method="post" action="<?= base_url('sales/retail/sale/item/add') ?>">
                    <input type='hidden' name='warehouse' value="<?= $sale->warehouse_id ?>">
                    <input type='hidden' name='sale' value="<?= $sale->id ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Barang</label>
                                <select name='product' required class="select2bs4" id="productSelect" style="width: 100%;">
                                    <option value="">--Pilih Barang--</option>
                                    <?php
                                    foreach($products as $product){
                                        $itemExist = $db->table("sale_items");
                                        $itemExist->where("sale_id",$sale->id);
                                        $itemExist->where("product_id",$product->id);
                                        $itemExist = $itemExist->get();
                                        $itemExist = $itemExist->getResultObject();
                                        
                                        if($itemExist == NULL){
                                            echo "<option value='".$product->id."'>".$product->name."</option>";
                                        }else{
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <b>Persediaan</b><br>
                                <div id="productStockPreview"></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Kuantitas</label>
                                <input type='number' value='0' name='qty' id='productQtyInput' class='form-control' required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Harga</label>
                            <select required name='price' class='form-control' id='productPriceSelect'></select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Promo / Gift</label>
                                <select name='promo' class='form-control'>
                                    <option value="">--Tanpa Promo--</option>
                                    <?php
                                    foreach($promos as $promo){
                                        echo"<option value='".$promo->id."'>[".$promo->code."] ".$promo->details."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>PPN</label>
                                <select class="form-control" name='tax'>
                                    <option value='0'>Non PPN (0%)</option>
                                    <option value='<?= config("App")->ppn ?>'>PPN (<?= config("App")->ppn ?>%)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type='submit' class='btn btn-info'>
                                    <i class='fa fa-plus'></i>
                                    Tambah Barang Ke Dalam Penjualan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class='text-center'>Barang</th>
                            <th class='text-center'>Kuantitas</th>
                            <th class='text-center'>Harga</th>
                            <th class='text-center'>Promo</th>
                            <th class='text-center'>Pajak (%)</th>
                            <th class='text-center'>Jumlah</th>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sumPrice = 0;
                        foreach($items as $item){
                            $thisProduct = $db->table("products");
                            $thisProduct->where("id",$item->product_id);
                            $thisProduct = $thisProduct->get();
                            $thisProduct = $thisProduct->getFirstRow();
                            ?>
                            <tr>
                                <td><?= $thisProduct->name ?></td>
                                <td class='text-right'><?= $item->quantity ?> <?= $thisProduct->unit ?></td>
                                <td class='text-right'>Rp. <?= number_format($item->price,0,",",".") ?></td>                                
                                <td>
                                <?php
                                if($item->promo_id == 0){
                                    echo "--Tanpa Promo--";
                                    $discountItem = 0;
                                }else{
                                    $thisPromo = $db->table("promos");
                                    $thisPromo->where("id",$item->promo_id);
                                    $thisPromo = $thisPromo->get();
                                    $thisPromo = $thisPromo->getFirstRow();

                                    echo "(".$thisPromo->code.") &nbsp;";

                                    if($thisPromo->type == 1){
                                        $discountItem = $thisPromo->percentage;
                                        echo config("App")->promoTypes[$thisPromo->type]." ".$thisPromo->percentage."%";
                                    }else{
                                        $discountItem = 0;
                                        echo config("App")->promoTypes[$thisPromo->type]." ".$thisPromo->details;
                                    }

                                }
                                ?>
                                </td>
                                <td class='text-right'><?= $item->tax ?>%</td>
                                <td class='text-right'>
                                    <?php
                                    $discountCalculate = $item->price * $discountItem / 100;
                                    $sumDiscountCalculate = $item->price - $discountCalculate;
                                    $taxCalculate = $sumDiscountCalculate * $item->tax / 100;
                                    $sumPriceCalculate = $sumDiscountCalculate + $taxCalculate;

                                    echo "Rp. ".number_format($sumPriceCalculate,0,",",".");

                                    $sumPrice += $sumPriceCalculate;
                                    ?>
                                </td>
                                <td class='text-center'>
                                    <!-- <a href="#" class='btn btn-success btn-sm'>
                                        <i class='fa fa-edit'></i>
                                    </a> -->
                                    <a href="<?= base_url('sales/retail/sales/'.$sale->id.'/item/'.$item->id.'/delete') ?>" class='btn btn-danger btn-sm' onclick="return confirm('Yakin hapus <?= $thisProduct->name ?> dari daftar penjualan.?')" title="Hapus">
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
                            <th class='text-right' colspan='5'>TOTAL</th>
                            <th class='text-right'>Rp. <?= number_format($sumPrice,0,",",".") ?></th>
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

<script>

$("#productSelect").change(function(){
    $.ajax({
        url: "<?= base_url('sales/retail/ajax/sale/product/stocks') ?>",
        type: "post",
        data: {
            product     : $(this).val(),
            warehouse   : <?= $sale->warehouse_id ?>,
        },
        success: function(html) {
            // console.log(html);
            myText = html.split("~");
            stocks = parseInt(myText[0])

            $("#productQtyInput").attr("max",stocks)
            $("#productQtyInput").attr("min",0)

            if(stocks > 10){
                stocks = "10+"
            }else{
                stocks = stocks
            }

            $("#productStockPreview").html(stocks+" "+myText[1])

        }
    })
    $.ajax({
        url: "<?= base_url('sales/retail/ajax/sale/product/prices') ?>",
        type: "post",
        data: {
            product     : $(this).val(),
        },
        success: function(html) {
            // console.log(html);
            $("#productPriceSelect").html(html)
        }
    })
})

</script>


<?= $this->endSection() ?>