<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Pengiriman (DO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>"></a></li>
<li class="breadcrumb-item"><a href="<?= base_url('sales/sales_warehou'); ?>">Pengiriman</a></li>
<li class="breadcrumb-item active">Kelola Pengiriman (DO)</li>
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
    <div class="col-md-7">
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
                <?php if($sale->sent_date != NULL) : ?>
                    <!--
                    <a href="<?= base_url('warehouse/sales/'.$sale->id.'/drive_letter/print') ?>" class='btn btn-info' target="_blank">
                        <i class='fa fa-print'></i>
                        Cetak Surat Jalan
                    </a>
                -->

            <?php else : ?>

                    <!--
                    <button type='button' class='btn btn-default'>
                        Data Surat Jalan Belum Lengkap
                    </button>
                -->
            <?php endif ?>

        </div>

    </div>
</div>

<div class="col-md-5">
    <div class="card">
        <div class="card-header bg-info">
            <h5 class="card-title">Data Barang Pada Penjualan Ini</h5>
        </div>
        <div class="card-body table-responsive">

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class='text-center'>Barang</th>
                        <th class='text-center'>Dipesan</th>
                        <th class='text-center'>Terkirim</th>
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
                            <td class='text-right'>
                                <?= $item->quantity?> <?= $thisProduct->unit ?></td>   

                            <td class='text-right'>
                                <?php
                                $sumDeliveryItem = $db->table("delivery_items");
                                $sumDeliveryItem->selectSum("quantity");
                                $sumDeliveryItem->where("sale_item_id",$item->id);
                                $sumDeliveryItem = $sumDeliveryItem->get();
                                $sumDeliveryItem = $sumDeliveryItem->getFirstRow();
                                ?>
                                <?= ($sumDeliveryItem->quantity == NULL) ? "0" : $sumDeliveryItem->quantity ?>
                                <?= $thisProduct->unit ?>
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

    <div class="clearfix"></div> 

    <div class="card">

        <div class="card-header bg-info">
            <h5 class="card-title">Berkas Surat Jalans</h5>
        </div>

        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="deliver-tabs" role="tablist">
                    <?php $f = 0; ?>
                    <?php foreach($deliveries as $delivery) : ?>
                        <?php $f++; ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($f == 1) ? "active" : "" ?>" id="deliver-tabs-<?= $f ?>" data-toggle="pill" href="#deliver-tabs-<?= $f ?>-content" role="tab">
                                Ke-<?= $f ?>
                            </a>
                        </li>
                    <?php endforeach ?>

                    <?php if($sale->sent_date != NULL) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($f == 0) ? "active" : "" ?>" id="deliver-tabs-0" data-toggle="pill" href="#deliv-tabs-0-content" role="tab">
                                Ke-0
                            </a>
                        </li>
                    <?php endif ?>           
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content" id="deliver-tabs-content">
                <?php $f = 0; ?>
                <?php foreach($deliveries as $delivery): ?>
                    <?php $f++; ?>
                    <div class="tab-pane fade <?= ($f == 1) ? "show active" : "" ?>" id="deliver-tabs-<?= $f ?>-content" role="tabpanel">

                <?php
                    if($sale->status < 5){
                ?>
                    <div class='alert alert-warning'>
                        Upload dilakukan setelah status penjualan <b>Dikirim</b>
                    </div>
                <?php
                }else if($sale->status >= 6){
                ?>
                <?php
                if($delivery->shipping_receipt_file != NULL){
                    ?>
                    <a href="<?= base_url('public/shipping_receipts/'.$delivery->shipping_receipt_file) ?>" target="_blank" class='btn btn-success btn-block'>
                        <i class='fa fa-file'></i>
                        Lihat Berkas
                    </a>
                    <?php
                }
                ?>
                <?php
                    }else{
                ?>

                        <?php
                        if($delivery->shipping_receipt_file != NULL){
                            ?>
                            
                            <a href="<?= base_url('public/shipping_receipts/'.$delivery->shipping_receipt_file) ?>" target="_blank" class='btn btn-success'>
                                <i class='fa fa-file'></i>
                                Lihat Berkas
                            </a>

                            <a href="<?= base_url('warehouse/sales/'.$delivery->id.'/delete/'.$sale->id.'/shipping_receipt') ?>" class='btn btn-danger' onclick="return confirm('Yakin hapus berkas.?')">
                                <i class='fa fa-trash'></i>
                                Hapus Berkas
                            </a>
                            
                            <?php
                        }
                        ?>

                    </div>
                    <div class="form-group">
                        <small class='form-text text-muted'>
                            Catatan : 
                            <br>
                            Apabila anda upload berkas ulang, maka berkas sebelumnya akan tertimpa
                        </small>
                    </div>
                </form>
                <?php
            }
            ?> 

                    </div>                        
                <?php endforeach ?>
            </div>
 
        </div> 
 
    </div> 
</div> 
</div> 

<div class="clearfix"></div>

<?php
if ($sale->status < 5) {
?>
<div class="row">
    <div class="col-md-7">
        <div class="card card-default card-tabs">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Pengiriman</h5>
            </div>

            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="delivery-tabs-list" role="tablist">
                    <?php $d = 0; ?>
                    <?php foreach($deliveries as $delivery) : ?>
                        <?php $d++; ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($d == 1) ? "active" : "" ?>" id="delivery-tabs-<?= $d ?>" data-toggle="pill" href="#delivery-tabs-<?= $d ?>-content" role="tab">
                                Ke-<?= $d ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                    <?php if($sale->sent_date != NULL) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($d == 0) ? "active" : "" ?>" id="delivery-tabs-0" data-toggle="pill" href="#delivery-tabs-0-content" role="tab">
                                Ke-0
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="delivery-tabs-content">
                
                    <div class="form-group">
                        <label>Kendaraan</label>
                        <input type="text" name="vehicle" class="form-control" value="-" disabled>
                    </div>

                    <div class="form-group">
                        <label>Nama Supir</label>
                        <input type="text" name="driver" class="form-control" value="-" disabled>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Dikirim</label>
                        <input type="text" name="sent_date" class="form-control" value="-" disabled>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<?php } ?>
<!-- End card-body -->

<?php if ($sale->status > 4) {
?>
<div class="row" style="margin-top: -10px;">
    <div class="col-lg">
        <div class="card card-default card-tabs">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Pengiriman</h5>
            </div>

            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="delivery-tabs-list" role="tablist">
                    <?php $d = 0; ?>
                    <?php foreach($deliveries as $delivery) : ?>
                        <?php $d++; ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($d == 1) ? "active" : "" ?>" id="delivery-tabs-<?= $d ?>" data-toggle="pill" href="#delivery-tabs-<?= $d ?>-content" role="tab">
                                Ke-<?= $d ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                    <?php if($sale->sent_date != NULL) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($d == 0) ? "active" : "" ?>" id="delivery-tabs-0" data-toggle="pill" href="#delivery-tabs-0-content" role="tab">
                                Ke-0
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="delivery-tabs-content">  
                  <?php $d = 0; ?>
                    <?php foreach($deliveries as $delivery) : ?>
                        <?php $d++; ?>
                        <div class="tab-pane fade <?= ($d == 1) ? "show active" : "" ?>" id="delivery-tabs-<?= $d ?>-content" role="tabpanel">
                            <form method="post" action="<?= base_url('warehouse/deliveries/save') ?>">
                                <input type='hidden' name='id' value="<?= $delivery->id ?>">
                                <input type='hidden' name='sale' value="<?= $sale->id ?>">

                                <div class='form-group'>
                                    <label>Kendaraan</label>
                                    <select name='vehicle' style="background-color: white;" class='form-control' <?php if($sale->status > 4){ echo"disabled"; } ?>>

                                        <?php foreach($vehicles as $vehicle) : ?>

                                            <?php if($vehicle->id == $delivery->vehicle_id) : ?>
                                                <option value="<?= $vehicle->id ?>" selected> <?= $vehicle->brand ?> <?= $vehicle->type ?> (<?= $vehicle->number ?>)</option>

                                            <?php else : ?>
                                                <option value="<?= $vehicle->id ?>"><?= $vehicle->type ?> | Nomer Kendaraan: <?= $vehicle->number ?> | Kubikasi: <?= $vehicle->capacity ?></option>
                                            <?php endif ?>

                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Supir</label>
                                    <input type='text' style="background-color: white;" value="<?= $delivery->driver_name ?>" name='driver' class='form-control' required placeholder="Nama Supir" <?php if($sale->status > 4){ echo"disabled"; } ?>>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Dikirim</label>
                                    <input type='date' style="background-color: white;" value="<?= $delivery->sent_date ?>" name='sent_date' class='form-control' required <?php if($sale->status > 4){ echo"disabled"; } ?>> 
                                </div> 

                                <div class="form-group"> 
                                    <label>Keterangan / Catatan</label>   
                                    <textarea style="background-color: white;" name='warehouse_notes' placeholder="Tulis Keterangan / Catatan Di Sini" required class='form-control' <?php if($sale->status > 4){ echo"disabled"; } ?>><?= $delivery->warehouse_notes ?></textarea>
                                </div>

                            </form>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>

        </div>
    </div>
</div>
<?php }
?>


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