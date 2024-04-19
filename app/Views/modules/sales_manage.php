<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/sales'); ?>">Penjualan</a></li>
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

<?php
$saleReady = 1;
foreach($items as $item){
    $saleReady = $saleReady * $item->ready;
}
?>

<div class="row">
    <div class="col-md-9">
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
                        <label>Pembuat Penjualan (SO)</label>
                        <br>
                        <?= $admin->name ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pelanggan (Kontak)</label>
                            <br>
                            <?php if($sale->contact_id == NULL) : ?>
                            <?php else : ?>
                                <?= $contact->name ?> | <?= $contact->phone ?>
                            <?php endif ?>
                        </div>
                        <div class="form-group">
                            <label>Alamat Pelanggan</label>
                            <br>
                            <?= nl2br($sale->invoice_address) ?>
                        </div>                        
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <br>
                            <?php if($sale->payment_id == NULL) : ?>
                            <?php else : ?>
                            <?= $payment->name ?>
                            <?php endif ?>
                        </div>
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
                    </div>
                    <div class="col-md-3">
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
                        
                        <div class="form-group">
                            <label>Pajak PPN</label>
                            <br>
                            <?php
                                if($sale->tax == 1){
                                    echo "Tidak Termasuk";
                                }else{
                                    echo "Termasuk";
                                }
                                ?>
                        </div>
                        
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tag</label>
                            <br>
                            <?php
                            $thisSaleTagsExplode = explode("#",$sale->tags);
                            foreach($thisSaleTagsExplode as $tag) {
                                if($tag == NULL){
                                            
                                }else{
                                    echo "#".$tag." ";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= base_url('sales/'.$sale->id.'/invoice/print') ?>" class='btn btn-info' target="_blank">
                    <i class='fa fa-print'></i>
                    Cetak Invoice
                </a>
                <?php if($sale->sent_date != NULL) : ?>
                    
                    <a href="<?= base_url('sales/'.$sale->id.'/drive_letter/print') ?>" class='btn btn-info' target="_blank">
                        <i class='fa fa-print'></i>
                        Cetak Surat Jalan (All Item)
                    </a>
                            
                    <?php if(count($deliveries) > 0) : ?>                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-info"><i class='fa fa-print'></i> Cetak Surat Jalan</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <?php $d = 0; ?>
                                <?php foreach($deliveries as $delivery) : ?>
                                    <?php $d++; ?>
                                    <a class="dropdown-item" href="<?= base_url('warehouse/sales/'.$sale->id.'/deliveries/'.$delivery->id.'/print') ?>" target="_blank">Ke-<?= $d ?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif ?>
                <?php else : ?>                    
                    <?php if(count($deliveries) > 0) : ?>                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-info"><i class='fa fa-print'></i> Cetak Surat Jalan</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <?php $d = 0; ?>
                                <?php foreach($deliveries as $delivery) : ?>
                                    <?php $d++; ?>
                                    <a class="dropdown-item" href="<?= base_url('warehouse/sales/'.$sale->id.'/deliveries/'.$delivery->id.'/print') ?>" target="_blank">Ke-<?= $d ?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <!--<button type='button' class='btn btn-default'>-->
                        <!--    Data Surat Jalan Belum Lengkap-->
                        <!--</button>-->
                    <?php endif ?>
                <?php endif ?>
                
                <?php if($sale->shipping_receipt_file != NULL) : ?>
                    <div class="btn-group">
                            <button type="button" class="btn btn-info"><i class='fa fa-print'></i> Lihat Berkas Pengirimans</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" align="center">
                                <?php $d = 0; ?>
                                <?php foreach($deliveries as $delivery) : ?>
                                    <?php $d++; ?>
                                   <a class="dropdown-item" href="<?= base_url('public/shipping_receipts/'.$delivery->shipping_receipt_file) ?>" target="_blank">
                                        Pengiriman Ke-<?= $d ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Pengaturan Status</h5>
            </div>
            <div class="card-body text-center">

            <?php if($sale->status == 2) : ?>
                <?php if($sale->sent_date != NULL) : ?>
                    <a href="<?= base_url('sales/'.$sale->id.'/status/4/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[4] ?>.?')" class="btn btn-<?= config('App')->orderStatusColor[4] ?>"><?= config("App")->orderStatuses[4] ?></a>
                         <a href="<?= base_url('sales/'.$sale->id.'/status/5/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[5] ?>.?')" class="btn btn-<?= config("App")->orderStatusColor[5] ?>"><?= config("App")->orderStatuses[5] ?></a>
                <?php else : ?>

                <?php if(count($deliveries) > 0) : ?>
                    <a href="<?= base_url('sales/'.$sale->id.'/status/4/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[4] ?>.?')" class="btn btn-<?= config("App")->orderStatusColor[4] ?>"><?= config("App")->orderStatuses[4] ?></a><br><br>
                     <a href="<?= base_url('sales/'.$sale->id.'/status/5/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[5] ?>.?')" class="btn btn-<?= config("App")->orderStatusColor[5] ?>"><?= config("App")->orderStatuses[5] ?></a>
                <?php else : ?>
                <?php endif ?>
            <?php endif ?>
        <?php endif ?>


         <?php if($sale->status == 4) : ?>
                <?php if($sale->shipping_receipt_file != NULL) : ?>
                    <a href="<?= base_url('sales/'.$sale->id.'/status/5/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[5] ?>.?')" class="btn btn-<?= config('App')->orderStatusColor[5] ?>"><?= config("App")->orderStatuses[5] ?></a>
                <?php else : ?>

                <?php if(count($deliveries) > 0) : ?>
                    <a href="<?= base_url('sales/'.$sale->id.'/status/5/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[5] ?>.?')" class="btn btn-<?= config("App")->orderStatusColor[5] ?>"><?= config("App")->orderStatuses[5] ?></a>
                <?php else : ?>
                <?php endif ?>
            <?php endif ?>
        <?php endif ?>

        <?php if($sale->status >= 5) : ?>
        
            <?php if($delivery): ?>
            
            <?php if($delivery->shipping_receipt_file != NULL) : ?>
                 <?php
                  if($sale->status >= 6){
                    ?>
                    <div class='alert alert-dark'>
                    <?= config("App")->orderStatuses[6] ?>
                    </div>
                    <?php
                    }else{
                        ?>
                        <a href="<?= base_url('sales/'.$sale->id.'/status/6/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[6] ?>.?')" class='btn btn-<?= config("App")->orderStatusColor[6] ?>'>
                            <i class='fa fa-check'></i>
                            <?= config("App")->orderStatuses[6] ?>
                            </a>
                            <?php
                        }
                        ?>
                    <?php else : ?>
                        <div class='alert alert-warning'>
                            Berkas Pengiriman Belum Diupload
                        </div>
                    <?php endif ?>
                <?php else : ?>
                
            <?php endif; ?>
         <?php endif ?>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Barang Pada Penjualan Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class='text-center'>Barangs</th>
                            <th class='text-center'>Kuantitas</th>
                            <th class='text-center'>Lokasi</th>
                            <th class='text-center'>Harga</th>
                            <th class='text-center'>Promo</th>
                            <th class='text-center'>Diskon</th>
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
                            
                            $thisWarehouse = $db->table('product_stocks');
                            $thisWarehouse->select('warehouses.name');
                            $thisWarehouse->join('warehouses','product_stocks.warehouse_id = warehouses.id','left');
                            $thisWarehouse->where("product_stocks.sale_item_id",$item->id);
                            $thisWarehouse = $thisWarehouse->get();
                            $thisWarehouse = $thisWarehouse->getFirstRow();

                            ?>
                            <tr>
                                
                                <td><?= $thisProduct->name ?></td>
                                <td class='text-right'><?= $item->quantity ?> <?= $thisProduct->unit ?></td>
                                <td class='text-right'><?= $thisWarehouse ? $thisWarehouse->name : ""; ?></td>
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

                                    echo "(".$thisPromo->code.") &nbsp;".$thisPromo->details;                                    
                                }
                                ?>
                                </td>
                                <td class='text-right'>
                                    <?php if ($item->discount <= 100): ?>
                                        <?php echo $item->discount ?>%
                                        <?php elseif($item->discount >= 100): ?>
                                            Rp.<?php echo number_format($item->discount, 0, ",", ".") ?>
                                    <?php endif ?>

                                </td>
                                
                                <td class='text-right'>
                                        <?php if ($item->discount <= 100): ?>
                                            <?php
                                            $thisPriceCount = $item->price * $item->quantity;
                                            $discountCalculate = $thisPriceCount * $item->discount / 100;
                                            $sumDiscountCalculate = $thisPriceCount - $discountCalculate;
                                            $taxCalculate = $sumDiscountCalculate * $item->tax / 100;
                                            $sumPriceCalculate = $sumDiscountCalculate;
        
                                            echo "Rp. ".number_format($sumPriceCalculate,0,",",".");
        
                                            $sumPrice += $sumPriceCalculate;
                                            ?>
                                        <?php elseif($item->discount >= 100): ?>
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
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class='text-right' colspan='6'>TOTAL</th>
                            <th class='text-right'>Rp. <?= number_format($sumPrice,0,",",".") ?></th>
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