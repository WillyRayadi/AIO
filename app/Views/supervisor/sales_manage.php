<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('supervisor/sales'); ?>">Penjualan</a></li>
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
                            <?php
                            if($sale->payment_id != NULL){
                                echo $contact->name." | ".$contact->phone;
                            }
                            ?>
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
                            <?php
                            if($sale->payment_id != NULL){
                                echo $payment->name;
                            }
                            ?>
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
                    </div>
                </div>
            </div>
            <div class="card-footer">
                    <a href="<?= base_url('supervisor/sales/'.$sale->id.'/delete') ?>" onclick="return confirm('Yakin hapus penjualan (SO).?')" class='btn btn-danger float-right ml-2'>
                        <i class='fa fa-trash'></i>
                        Hapus
                    </a>
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
                            <th class='text-center'>Kuantitas</th>
                            <th class='text-center'>Harga</th>
                            <th class='text-center'>Promo</th>
                            <th class='text-center'>Diskon</th>
                            <th class='text-center'>Pajak</th>
                            <!-- <th class='text-center'>Jumlah</th> -->
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
                           <td class='text-right'>
                               <?php if ($item->discount <= 100): ?>
                                    <?php echo $item->discount ?>%
                                        <?php elseif($item->discount >= 100): ?>
                                        Rp.<?php echo number_format($item->discount, 0, ",", ".") ?>
                                    <?php endif ?>
                           </td>
                            <td class='text-right'>
                                    <?php
                                    if($item->tax == 0){
                                        echo "Tidak Termasuk";
                                    }else{
                                        echo "Termasuk";
                                    }
                                    ?>
                                </td>
                               <!--  <td class='text-right'>
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
                                </td> -->
                                <td class='text-center'>
                                    <?php
                                        $itemNameForEditQty = str_replace("'","`",$thisProduct->name);
                                        $itemNameForEditQty = str_replace("\"","``",$itemNameForEditQty);
                                        ?>
                                    <?php if($item->need_approve <= 2) : ?>
                                        <?php if($item->approve_status == 0) : ?>
                                            <a href="<?=base_url("supervisor/sales/".$sale->id.'/item/'.$item->id.'/approve') ?>" onclick="return confirm('Yakin setujui.?')" class='btn btn-success btn-sm' title="Setujui">
                                                <i class='fa fa-check'></i>
                                            </a>
                                  
                                            <a href="<?=base_url("supervisor/sales/".$sale->id.'/item/'.$item->id.'/unapprove') ?>" onclick="return confirm('Yakin tidak setujui.?')" class='btn btn-danger btn-sm' title="Tidak Disetujui">
                                                <i class='fa fa-times'></i>
                                            </a>
                                             
                                        <?php else : ?>
                                            <?php
                                            echo"<span class='badge badge-".config("App")->product_price_status_colors[$item->approve_status]."'>".config("App")->product_price_statuses[$item->approve_status]." <br>".config("App")->needApprovers[$item->need_approve]."</span>";
                                            ?>
                                        <?php endif ?>
                                    <?php elseif($item->need_approve == 3) : ?>
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
                    <tfoot>
                        <tr>
                            <th class='text-right' colspan='6'>TOTAL</th>
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