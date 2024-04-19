<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('owner/sales'); ?>">Penjualan</a></li>
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

                    <div class="form-group">
                        <label>Order ID(Online)</label>
                        <br>
                        <?= $sale->order_id ?>
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
                            <?= $contact->name ?> | <?= $contact->phone ?>
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
                            <?= $payment->name ?>
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

                        <div class="form-group">
                            <label>Gudang</label>
                            <br>
                            <?= $warehouse->name ?>
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
                        Cetak Surat Jalan
                    </a>                    
                <?php else : ?>
                    <button type='button' class='btn btn-default'>
                        Data Surat Jalan Belum Lengkap
                    </button>
                <?php endif ?>
                <?php if($sale->shipping_receipt_file != NULL) : ?>
                    <a href="<?= base_url('public/shipping_receipts/'.$sale->shipping_receipt_file) ?>" target="_blank" class='btn btn-info'>
                        <i class='fa fa-file'></i>
                        Lihat Berkas Pengiriman
                    </a>
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
                        <a href="<?= base_url('sales/'.$sale->id.'/status/4/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[4] ?>.?')" class='btn btn-<?= config("App")->orderStatusColor[4] ?>'>
                            <?= config("App")->orderStatuses[4] ?>
                        </a>
                    <?php else : ?>
                        <div class='alert alert-warning'>
                            Data Surat Jalan Belum Lengkap
                        </div>
                    <?php endif ?>                                        
                <?php endif ?>
                <?php if($sale->status >= 4) : ?>
                    <?php if($sale->shipping_receipt_file != NULL) : ?>
                        <?php
                        if($sale->status >= 5){
                            ?>
                            <div class='alert alert-dark'>
                                <?= config("App")->orderStatuses[5] ?>
                            </div>
                            <?php
                        }else{
                            ?>
                            <a href="<?= base_url('sales/'.$sale->id.'/status/5/set') ?>" onclick="return confirm('Yakin Penjualan (SO) <?php echo config("App")->orderStatuses[5] ?>.?')" class='btn btn-<?= config("App")->orderStatusColor[5] ?>'>
                                <i class='fa fa-check'></i>
                                <?= config("App")->orderStatuses[5] ?>
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
                <?php endif ?>
            </div>
            <div class="card-footer"></div>
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
            <div class="table-responsive">
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class='text-center'>Tipe</th>
                            <th class='text-center'>Harga</th>
                            <!--<th class='text-center'>Harga</th>
                            <th class='text-center'>Promo</th>
                            <th class='text-center'>Diskon</th>
                            <th class='text-center'>Pajak</th>
                            <th class='text-center'>Jumlah</th>-->
                            <th class='text-center'>Status</th>
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
                                <td><?= $thisProduct->name ?> (<?= $item->quantity ?> unit)
                                    <?php
                                        $bundlings = $db->table("sale_item_bundlings");
                                        $bundlings->select("products.name as product_name");
                                        $bundlings->join("products","sale_item_bundlings.product_id=products.id");
                                        $bundlings->where("sale_item_bundlings.sale_item_id",$item->id);
                                        $bundlings = $bundlings->get();
                                        $bundlings = $bundlings->getResultObject();

                                        if($bundlings != NULL){
                                            echo "<hr>";
                                            echo "Bundlings / Gifts :";
                                            echo "<ul>";
                                            foreach($bundlings as $bundling){
                                                echo "<li>".$bundling->product_name."</li>";
                                            }
                                            echo"</ul>";
                                        }
                                    ?>
                                </td>
                                <td>Rp. <?= number_format($item->price,0,",",".") ?> (<?= $item->price_level ?>) </td>
                               
                                <td class='text-center'>
                                    <?php if($item->need_approve <= 2) : ?>
                                        <?php
                                        echo"<span class='badge badge-".config("App")->product_price_status_colors[$item->approve_status]."'>".config("App")->product_price_statuses[$item->approve_status]." <br>".config("App")->needApprovers[$item->need_approve]."</span>";
                                        ?>
                                    <?php endif ?>
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