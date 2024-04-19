<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/sales/grosir/sales'); ?>">Penjualan</a></li>
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
            <form method="post" action="<?= base_url('sales/grosir/sales/save') ?>">
                <div class="card-header bg-info">
                    <h5 class="card-title">Data Penjualan</h5>
                </div>
                <div class="card-body">
                    <input type='hidden' name='id' value="<?= $sale->id ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Transaksi</label>
                                <input type='text' value="<?= $sale->number ?>" readonly class='form-control' placeholder="<?= "SO/".date("y")."/".date("m")."/[auto]" ?>">
                            </div>                            
                        </div>                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pelanggan (Kontak)</label>
                                <select name='contact' id='contactSelect' class='form-control'>
                                    <option value="">--Pilih Pelanggan--</option>
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
                            <div class="form-group">
                                <label>Alamat Penagihan</label>
                                <textarea class='form-control' id="addressField" placeholder="Alamat Penagihan" required name='invoice_address'><?= $sale->invoice_address ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>No. Referensi Pelanggan</label>
                                <input type='text' value="<?= $thisContact->no_reference ?>" readonly id="referenceField" name='reference' class='form-control'>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select name='payment' id='paymentSelect' class='form-control'>
                                    <option value="">--Pilih Metode Pembayaran--</option>
                                    <?php
                                    foreach($payments as $payment){
                                        if($payment->id == $sale->payment_id){
                                            $paymentSelected = "selected";
                                        }else{
                                            $paymentSelected = "";
                                        }
                                        echo"<option value='".$payment->id."' $paymentSelected>".$payment->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Transaksi</label>
                                <input type='date' readonly id="dateField" value="<?= $sale->transaction_date ?>" name='transaction_date' class='form-control' required>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Jatuh Tempo</label>
                                <input type='date' readonly value="<?= $sale->expired_date ?>" id="expiredField" name='expired_date' class='form-control' required>
                            </div>                            
                        </div>                        
                        <div class="col-md-4">                            
                            <div class="form-group">
                                <label>Gudang</label>
                                <input type='text' readonly value="<?= $warehouse->name ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tag</label>
                                <select name='tags[]' class="select2bs4" id="tagSelect" multiple="multiple" style="width: 100%;">
                                <?php
                                foreach($tags as $tag){
                                    $saleTagsExplode = explode("#",$sale->tags);

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
                                <label>Memo / Catatan</label>
                                <textarea class='form-control' placeholder="Memo / Catatan" required name='sales_notes'><?= $sale->sales_notes ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <?php if(count($items) <= 0) : ?>
                        <a href="<?= base_url('sales/grosir/sales/'.$sale->id.'/delete') ?>" onclick="return confirm('Yakin hapus penjualan (SO).?')" class='btn btn-danger float-right ml-2'>
                            <i class='fa fa-trash'></i>
                            Hapus Penjualan (SO)
                        </a>
                    <?php else : ?>
                    <?php endif ?>
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
                <form method="post" action="<?= base_url('sales/grosir/sale/item/add') ?>">
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
                            <select required name='price' class='form-control' id='productPriceSelect'>
                                <option value=''>--Pilih Barang Terlebih Dahulu--</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Promo / Gift</label>
                                <select name='promo' id="productPromoSelect" required class='form-control'>
                                    <option value="">--Pilih Barang Terlebih Dahulu--</option>                                    
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
                                <button id="addItemBtn" type='submit' class='btn btn-info'>
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
                            <th class='text-center'>Status</th>
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
                                <td class='text-right'>(<?= $item->price_level ?>) Rp. <?= number_format($item->price,0,",",".") ?></td>                                
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

                                    echo "(".$thisPromo->code.") &nbsp;".$thisPromo->details;
                                }
                                ?>
                                </td>
                                <td class='text-right'><?= $item->tax ?>%</td>
                                <td class='text-right'>
                                    <?php
                                    $discountCalculate = $item->price * $item->quantity;
                                    $sumDiscountCalculate = $discountCalculate;
                                    $taxCalculate = $sumDiscountCalculate * $item->tax / 100;
                                    $sumPriceCalculate = $sumDiscountCalculate + $taxCalculate;

                                    echo "Rp. ".number_format($sumPriceCalculate,0,",",".");

                                    $sumPrice += $sumPriceCalculate;
                                    ?>
                                </td>
                                <td class='text-center'>
                                    <?php
                                    if($item->need_approve != 0){
                                        echo"<span class='badge badge-warning'>Menunggu Persetujuan <br>".config("App")->needApprovers[$item->need_approve]."</span>";
                                    }
                                    ?>
                                </td>
                                <td class='text-center'>                                    
                                    <a href="<?= base_url('sales/grosir/sales/'.$sale->id.'/item/'.$item->id.'/delete') ?>" class='btn btn-danger btn-sm' onclick="return confirm('Yakin hapus <?= $thisProduct->name ?> dari daftar penjualan.?')" title="Hapus">
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
                            <th class='text-right'>Rp. <?= number_format(0,0,",",".") ?></th>
                            <th></th>
                            <th></th>
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

<script type="text/javascript">

$("#contactSelect").change(function(){
    id = $(this).val()

    $.ajax({
        url : "<?= base_url('sales/grosir/ajax/sales/add/contact/data') ?>",
        data : { id : id },
        type : "POST",
        success : function(response){
            response = JSON.parse(response)
            $("#addressField").html(response.address)
            $("#referenceField").val(response.no_reference)
        }
    })
})

$("#paymentSelect").change(function(){
    id = $(this).val()

    $.ajax({
        url : "<?= base_url('sales/grosir/ajax/sales/add/expired/data') ?>",
        data : { id : id },
        type : "POST",
        success : function(response){
            $("#expiredField").val(response)
        }
    })
})

</script>

<script>

$("#productSelect").change(function(){
    $.ajax({
        url: "<?= base_url('sales/grosir/ajax/sale/product/stocks') ?>",
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
            $("#productQtyInput").attr("min",1)
            
            if(stocks <= 0){
                $("#addItemBtn").attr("disabled",true)
                $("#productQtyInput").val(0)
            }else{
                $("#addItemBtn").attr("disabled",false)                
                $("#productQtyInput").val(1)
            }

            if(stocks > 10){
                stocks = "10+"
            }else{
                stocks = stocks
            }

            $("#productStockPreview").html(stocks+" "+myText[1])

        }
    })
    $.ajax({
        url: "<?= base_url('sales/grosir/ajax/sale/product/prices') ?>",
        type: "post",
        data: {
            product     : $(this).val(),
        },
        success: function(html) {
            // console.log(html);
            $("#productPriceSelect").html(html)
        }
    })
    $.ajax({
        url: "<?= base_url('sales/grosir/ajax/sale/product/promos') ?>",
        type: "post",
        data: {
            product     : $(this).val(),
        },
        success: function(html) {
            // console.log(html);
            $("#productPromoSelect").html(html)
        }
    })
})

</script>


<?= $this->endSection() ?>