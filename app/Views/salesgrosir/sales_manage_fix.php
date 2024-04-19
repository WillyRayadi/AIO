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
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body">
                <input type='hidden' name='id' value="<?= $sale->id ?>">
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Transaksi</label>
                                <input type='text' readonly class='form-control' placeholder="<?= "SO/".date("y")."/".date("m")."/[auto]" ?>">
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
                                        echo"<option value='".$contact->id."'>".$contact->name." | ".$contact->phone."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat Penagihan</label>
                                <textarea class='form-control' id="addressField" placeholder="Alamat Penagihan" required name='invoice_address'></textarea>
                            </div>
                            <div class="form-group">
                                <label>No. Referensi Pelanggan</label>
                                <input type='text' readonly id="referenceField" name='reference' class='form-control'>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select name='payment' id='paymentSelect' class='form-control'>
                                    <option value="">--Pilih Metode Pembayaran--</option>
                                    <?php
                                    foreach($payments as $payment){
                                        echo"<option value='".$payment->id."'>".$payment->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Transaksi</label>
                                <input type='date' readonly id="dateField" value="<?= date("Y-m-d") ?>" name='transaction_date' class='form-control' required>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Jatuh Tempo</label>
                                <input type='date' readonly id="expiredField" name='expired_date' class='form-control' required>
                            </div>                            
                        </div>                        
                        <div class="col-md-4">                            
                            <div class="form-group">
                                <label>Gudang</label>
                                <select name='warehouse' class='form-control'>
                                    <?php
                                    foreach($warehouses as $warehouse){
                                        echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tag</label>
                                <select name='tags[]' class="select2bs4" id="tagSelect" multiple="multiple" style="width: 100%;">
                                <?php
                                foreach($tags as $tag){
                                    echo"<option value='".$tag->name."'>".$tag->name."</option>";
                                }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Memo / Catatan</label>
                                <textarea class='form-control' placeholder="Memo / Catatan" required name='sales_notes'></textarea>
                            </div>
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
            <div class="card-body">
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class='text-center'>Barang</th>
                            <th class='text-center'>Kuantitas</th>
                            <th class='text-center'>Harga</th>
                            <th class='text-center'>Promo</th>
                            <th class='text-center'>Pajak (%)</th>
                            <th class='text-center'>Jumlah</th>
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
                                    $thisItemPrice = $item->price * $item->quantity;
                                    $discountCalculate = $thisItemPrice * $discountItem / 100;
                                    $sumDiscountCalculate = $thisItemPrice - $discountCalculate;
                                    $taxCalculate = $sumDiscountCalculate * $item->tax / 100;
                                    $sumPriceCalculate = $sumDiscountCalculate + $taxCalculate;

                                    echo "Rp. ".number_format($sumPriceCalculate,0,",",".");

                                    $sumPrice += $sumPriceCalculate;
                                    ?>
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
})

</script>


<?= $this->endSection() ?>