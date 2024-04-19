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
                        <label for="phone">No. Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="No. Telepon" required>
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

<?php
$saleReady = 1;
foreach($items as $item){
    $saleReady = $saleReady * $item->ready;
}
?>

<div class="row">
    <div class="col-md-9">
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
                                <input type='text' value="<?= $sale->number ?>" readonly class='form-control' placeholder="<?= "SO/".date("y")."/".date("m")."/[auto]" ?>">
                            </div>                            
                        </div>  

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Sales</label>
                                <input type="text" class="form-control" value="<?= config("Login")->loginName ?>" readonly>
                            </div>
                        </div>     

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cabang Toko</label>
                                <input type="text" id="cabangField" name="cabang_id" class="form-control" placeholder="Lokasi Cabang Toko">
                            </div>
                        </div> 
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Pelanggan
                                    <a href="javascript:void(0)" data-toggle='modal' data-target='#modalAdd'>
                                        <i class='fa fa-plus'></i>
                                        Tambah Kontak
                                    </a>
                                </label>
                                <select name='contact' id='contactSelect' required class='form-control select2bs4'>
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
                                <label>Alamat Pelanggan</label>
                                <textarea class='form-control' id="addressField" placeholder="Alamat Pelanggan" required name='invoice_address'><?= $sale->invoice_address ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Area Pengiriman</label>
                                 <select name='location_id' required class='form-control select2bs4'>
                                    <option value="">--Pilih Area--</option>
                                    <?php 
                                    foreach($locations as $location){
                                        if($location->id == $sale->location_id){
                                            $selectedLocation = "selected";
                                        }else{
                                            $selectedLocation = "";
                                        }
                                        echo"<option value='".$location->id."' $selectedLocation>".$location->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>    
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select name='payment' id='paymentSelect' required class='form-control'>
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
                            <!-- <div class="form-group">
                                <label>Gudang</label>
                                <select name='warehouse' class='form-control'>
                                    <?php
                                    //foreach($warehouses as $warehouse){
                                       // echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                                    //}
                                    ?>
                                </select>
                            </div> -->
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
                                <input type="text" name="sales_notes" class='form-control' placeholder="Memo / Catatan" value="<?= $sale->sales_notes  ?>">
                                <!-- <textarea class='form-control' placeholder="Memo / Catatan" required name='sales_notes'><?= $sale->sales_notes ?></textarea> -->
                            </div>

                            <div class="form-group">
                                <label>Order ID (Penjualan Online)</label>
                                <input type="text" class="form-control" name="order_id" value="<?= $sale->order_id ?>">
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
                    
                    <a href="<?= base_url('sales/sales/'.$sale->id.'/delete') ?>" onclick="return confirm('Yakin hapus penjualan (SO).?')" class='btn btn-danger float-right ml-2'>
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
                                    foreach($products as $product){
                                        // $itemExist = $db->table("sale_items");
                                        // $itemExist->where("sale_id",$sale->id);
                                        // $itemExist->where("product_id",$product->id);
                                        // $itemExist = $itemExist->get();
                                        // $itemExist = $itemExist->getResultObject();
                                        
                                        // if($itemExist == NULL){
                                        // }else{
                                        // }
                                        echo "<option value='".$product->id."'>".$product->name."</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                            
                            <div class="form-group">
                                <b>Stok Persediaan</b>
                                <div id='productStockPreview'></div>
                            </div>

                            <div class="form-group">
                                <b>Stok Display</b>
                                <div id='productStockDisplay'></div>
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

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tulis Harga (Custom)</label>
                                <input type='number' name='custom_price' id="customPrice" readonly="true" class='form-control' placeholder='Pilih Barang Terlebih Dahulu'>                            
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Promo / Gift</label>
                                <select name='promo' id="productPromoSelect" class='form-control'>
                                    <option value="">--Pilih Barang Terlebih Dahulu--</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>PPN</label>
                                <select class="form-control" name='tax'>
                                    <option value='0'>Tidak Termasuk</option>
                                    <option value='<?= config("App")->ppn ?>'>Termasuk</option>
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
                <div class="table-responsive"> 
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class='text-center'>Barang</th>
                                <th class='text-center'>Kuantitas</th>
                                <th class='text-center'>Harga</th>
                                <th class='text-center'>Promo</th>
                                <!-- <th class='text-center'>Diskon</th> -->
                                <!-- <th class='text-center'>Pajak</th> -->
                                <th class='text-center'>Jumlah</th>
                                <th class='text-center'>Opsi</th>
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
                                    <td><?= $thisProduct->name ?>
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

                                    <td class='text-right'>
                                        <?= $item->quantity ?> <?= $thisProduct->unit ?>
                                        &nbsp;
                                        <?php
                                        $itemNameForEditQty = str_replace("'","`",$thisProduct->name);
                                        $itemNameForEditQty = str_replace("\"","``",$itemNameForEditQty);
                                        ?>
                                        <?php if($item->need_approve == 0) : ?>
                                        <?php else : ?>
                                            <?php if($item->approve_status == 1) : ?>
                                            <?php else : ?>
                                            <a href="javascript:void(0)"  onclick="editQty('<?= $item->id ?>','<?= $item->product_id ?>','<?= $itemNameForEditQty ?>','<?= $item->quantity ?>')" data-toggle="modal" data-target="#modalEditQtyItem" class='text-success'>
                                                <i class='fa fa-edit'></i>
                                            </a>
                                            <?php endif ?>
                                        <?php endif ?>

                                        <?php
                                        $bundlings = $db->table("sale_item_bundlings");
                                        $bundlings->select("sale_item_bundlings.quantity as quantity");
                                        $bundlings->select("products.name as product_name");
                                        $bundlings->join("products","sale_item_bundlings.product_id=products.id");
                                        $bundlings->where("sale_item_bundlings.sale_item_id",$item->id);
                                        $bundlings = $bundlings->get();
                                        $bundlings = $bundlings->getResultObject();

                                        $rumus = $db->table('product_prices')->where('id',$product->price_id)->get()->getFirstRow();

                                        $margins = ([
                                            0, 
                                            $rumus->plus_one,
                                            $rumus->plus_two,
                                            $rumus->plus_three,
                                            $rumus->plus_four,
                                            $rumus->plus_five,
                                            $rumus->plus_six,
                                            $rumus->plus_seven,
                                            $rumus->plus_eight,
                                            $rumus->plus_nine,
                                            $rumus->plus_ten,
                                        ]);

                                        if($bundlings != NULL){
                                            echo "<hr>";
                                            foreach($bundlings as $bundling){
                                                echo $bundling->quantity." Unit";
                                            }
                                        }
                                        ?>
                                    </td>

                                    <td class='text-right'>
                                       (<?= $item->price_level ?>) Rp. <?= number_format($item->price,0,",",".") ?>

                                       <?php
                                        $bundlings = $db->table("sale_item_bundlings");
                                        $bundlings->select("sale_item_bundlings.price as price");
                                        $bundlings->select("products.name as product_name");
                                        $bundlings->join("products","sale_item_bundlings.product_id=products.id");
                                        $bundlings->where("sale_item_bundlings.sale_item_id",$item->id);
                                        $bundlings = $bundlings->get();
                                        $bundlings = $bundlings->getResultObject();

                                        if($bundlings != NULL){
                                            echo "<hr>";
                                            echo "Bundlings :";
                                            echo "<ul>";
                                        
                                        foreach($bundlings as $bundling){
                                            echo "<li>".$bundling->price."</li>";
                                        }
                                            echo"</ul>";
                                        }
                                        ?>
                                    </td>

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

                                        echo $thisPromo->code;                                    
                                    }
                                    ?>

                                    </td>

                                    <td class='text-right'>
                                        <?php
                                        $thisPriceCount = $item->price * $item->quantity;
                                        $discountCalculate = $thisPriceCount * $item->discount / 100;
                                        $sumDiscountCalculate = $thisPriceCount - $discountCalculate;
                                        $taxCalculate = $sumDiscountCalculate * $item->tax / 100;
                                        $sumPriceCalculate = $sumDiscountCalculate;
    
                                        echo "Rp. ".number_format($sumPriceCalculate,0,",","."); 
                                        $sumPrice += $sumPriceCalculate; 
                                        ?>
                                    <hr>
                                        <?php
                                        $bundlings = $db->table("sale_item_bundlings");
                                        $bundlings->select("sale_item_bundlings.price");
                                        $bundlings->select("sale_item_bundlings.product_id");
                                        $bundlings->select("sale_item_bundlings.price_level");
                                        $bundlings->select("sale_item_bundlings.quantity as quantity");
                                        $bundlings->select("products.name as product_name");
                                        $bundlings->join("products","sale_item_bundlings.product_id=products.id");
                                        $bundlings->where("sale_item_bundlings.sale_item_id",$item->id);
                                        $bundlings = $bundlings->get();
                                        $bundlings = $bundlings->getFirstRow();

        
                                        
                                        ?>
                                    </td>                                    
                                    <td class='text-center'>                                    
                                        <a href="<?= base_url('sales/sales/'.$sale->id.'/item/'.$item->id.'/delete') ?>" class='btn btn-danger btn-sm' onclick="return confirm('Yakin hapus <?= $itemNameForEditQty ?> dari daftar penjualan.?')" title="Hapus">
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
        url : "<?= base_url('sales/ajax/sales/add/contact/data') ?>",
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
        url : "<?= base_url('sales/ajax/sales/add/expired/data') ?>",
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
        url: "<?= base_url('sales/ajax/sale/product/stocks') ?>",
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
        url: "<?= base_url('sales/ajax/sale/products/stocks/display') ?>",
        type: "post",
        data: {
            product     : $(this).val(),
            warehouse   : <?= $sale->warehouse_id ?>,
        },

        success: function(html) {
            // console.log(html);
            myText = html.split("~");
            display = parseInt(myText[0])
            

            $("#productStockDisplay").html(display+" "+myText[1])

        }
    })

    $.ajax({
        url: "<?= base_url('sales/ajax/sale/product/prices') ?>",
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
        url: "<?= base_url('sales/ajax/sale/product/promos') ?>",
        type: "post",
        data: {
            product     : $(this).val(), price_level : $("#productPriceSelect").val()
        },
        success: function(html) {
            // console.log(html);
            $("#productPromoSelect").html(html)
        }
    })

    $.ajax({
        url: "<?= base_url('sales/ajax/sale/bundling') ?>",
        type: "post",
        data: {
            product     : $(this).val(), 
            price_level : $("#productPriceSelect").val()            
        },

        success: function(html) {
            // console.log(html);
            $("#productBundlingSelect").html(html)
        }
    })

    $("#customPrice").attr("readonly",false)
    $("#customPrice").attr("placeholder","Silahkan tulis harga di sini")
})

$("#productPriceSelect").change(function(){    
    $.ajax({
        url: "<?= base_url('sales/ajax/sale/product/promos') ?>",
        type: "post",
        data: {
            product     : $("#productSelect").val(), price_level : $(this).val()
        },
        success: function(html) {
            // console.log(html);
            $("#productPromoSelect").html(html)
        }
    }) 
    $("#customPrice").attr("readonly",false)
    $("#customPrice").attr("placeholder","Silahkan tulis harga di sini")
})

function editQty(item, product, name, qty){
    $("#editItemID").val(item)
    $("#editItemProductID").val(product)
    $("#textEditItemName").html(name)
    $("#editItemQty").val(qty)
}

</script> 
<?= $this->endSection() ?>