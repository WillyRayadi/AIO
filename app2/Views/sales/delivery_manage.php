<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Pengiriman (DO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
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
            <h5 class="card-title">Berkas Surat Jalan</h5>
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
                    <div class="form-group">
                        <?php
                        if($delivery->shipping_receipt_file != NULL){
                            ?> 
                            <a href="<?= base_url('public/shipping_receipts/'.$delivery->shipping_receipt_file) ?>" target="_blank" class='btn btn-success'>
                                <i class='fa fa-file'></i>
                                Lihat Berkas
                            </a>

                            <?php
                        }
                        ?>

                    </div>
            <?php
            }
            ?> 

                    </div>                        
                <?php endforeach ?>
            </div>

        </div>

        <!-- Commentar for card footer -->
        <div class="card-footer"></div>

    </div>
</div>
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-lg">
        <div class="card card-defau card-tabs">
           
            <div class="card-header bg-info">
                <h5 class="card-title">
                    Data Pengiriman
                </h5>
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

                                <div class='form-group'>
                                    <label>Kendaraan</label>
                                    <select name='vehicle' class='form-control' <?php if($sale->status > 5){ echo"disabled"; } ?>>

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
                                    <input type='text' value="<?= $delivery->driver_name ?>" name='driver' class='form-control' required placeholder="Nama Supir" <?php if($sale->status > 5){ echo"disabled"; } ?>>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Dikirim</label>
                                    <input type='date' value="<?= $delivery->sent_date ?>" name='sent_date' class='form-control' required <?php if($sale->status > 5){ echo"disabled"; } ?>> 
                                </div> 

                                <div class="form-group"> 
                                    <label>Keterangan / Catatan</label>   
                                    <textarea name='warehouse_notes' placeholder="Tulis Keterangan / Catatan Di Sini" required class='form-control' <?php if($sale->status > 5){ echo"disabled"; } ?>><?= $delivery->warehouse_notes ?></textarea>
                                </div>

                            <div class="table-responsive">
                                <div class="card-header bg-info">
                                    <h5 class="card-title">Item Penjualan</h5>
                                </div>
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th class='text-center'>No</th>
                                            <th class='text-center'>Item</th>
                                            <th class='text-center'>Dipesan</th>
                                            <th class='text-center'>Dikirim</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $delivery_items = $db->table("delivery_items");
                                        $delivery_items->where("delivery_id",$delivery->id);
                                        $delivery_items = $delivery_items->get();
                                        $delivery_items = $delivery_items->getResultObject();
                                        $di = 0;
                                        foreach($delivery_items as $item){
                                           
                                            $di++;
                                            $thisSaleItem = $db->table("sale_items");
                                            $thisSaleItem->where("id",$item->sale_item_id);
                                            $thisSaleItem = $thisSaleItem->get();
                                            $thisSaleItem = $thisSaleItem->getFirstRow();

                                            $thisProduct = $db->table("products");
                                            $thisProduct->where("id",$thisSaleItem->product_id);
                                            $thisProduct = $thisProduct->get();
                                            $thisProduct = $thisProduct->getFirstRow();
                                            
                                            ?>
                                                <tr>
                                                    <td class='text-center'><?= $di ?></td>
                                                    <td>
                                                        <?= $thisProduct->name ?>
                                                    </td>
                                                    <td>
                                                        <?= $item->quantity?> <?= $thisProduct->unit ?>
                                                    </td>
                                                    <td>
                                                        <?= $item->quantity?> <?= $thisProduct->unit ?>
                                                    </td> 
                                            </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>  
                        </div>
                    </div>
                <?php endforeach ?>

                <?php if($sale->sent_date != NULL) : ?>
                    <div class="tab-pane fade <?= ($d == 0) ? "show active" : "" ?>" id="delivery-tabs-0-content" role="tabpanel">
                        <b>Data Pengiriman</b>
                        <hr>
                            <div class='form-group'>
                                <label>Kendaraan</label>
                                <select name='vehicle' class='form-control' <?php if($sale->status > 5){ echo"disabled"; } ?>>
                                    <?php foreach($vehicles as $vehicle) : ?>
                                        <?php if($vehicle->id == $sale->vehicle_id) : ?>
                                            <option value="<?= $vehicle->id ?>" selected>[<?= $vehicle->number ?>] <?= $vehicle->brand ?> <?= $vehicle->type ?></option>
                                        <?php else : ?>
                                            <option value="<?= $vehicle->id ?>">[<?= $vehicle->number ?>] <?= $vehicle->brand ?> <?= $vehicle->type ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sopir</label>
                                <input type='text' name='driver' <?php if($sale->status > 5){ echo"disabled"; } ?> class='form-control' required value="<?= $sale->driver_name ?>" placeholder="Nama Sopir">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Dikirim</label>
                                <input type='date' value="<?= date("Y-m-d") ?>" name='sent_date' <?php if($sale->status > 5){ echo"disabled"; } ?> class='form-control' value="<?= $sale->sent_date ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Keterangan / Catatan</label>
                                <textarea name='warehouse_notes' <?php if($sale->status > 5){ echo"disabled"; } ?> placeholder="Tulis Keterangan / Catatan Di Sini" required class='form-control'><?= $sale->warehouse_notes; ?></textarea>
                            </div>

                            <div class="form-group">
                                <?php if($sale->status > 5) : ?>
                                <?php else : ?>
                                    <button type='submit' class='btn btn-success'>
                                        <i class='fa fa-save'></i>
                                        Simpan
                                    </button>
                                <?php endif ?>
                                <a href="<?= base_url('warehouse/sales/'.$sale->id.'/drive_letter/print') ?>" class='btn btn-info' target="_blank">
                                    <i class='fa fa-print'></i>
                                    Cetak Surat Jalan
                                </a>
                            </div>
                    </div>
                <?php endif ?>

                <div class="tab-pane fade <?= ($d == 0 && $sale->sent_date == NULL) ? "show active" : "" ?>" id="delivery-tabs-add-content" role="tabpanel">
                       Data Pengiriman <b>Belum Dibuat</b>
                </div>
            </div>
        </div>
    </div>
</div>
</div> 
<?= $this->endSection() ?> 
<?= $this->section("page_script") ?> 
<?= $this->endSection() ?>