<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Produk Transfers
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('sales/products_transfers') ?>">Produk Transfers</a></li>
<li class="breadcrumb-item active">Kelola Transfer Produk</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>  

<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body">
                <h4>Gudang Transfer</h4>  

                <hr>

                <b>No. Transaksi</b>
                <br>
                <p id="warehouseSelect"><?= $good_transfers->number ?>
                </p> 
                <b>Nama Admin</b>
                <br>
                <p id="warehouseSelect"><?= $good_transfers->admin_name ?></p>

                <b>Asal Gudang</b>
                <br>
                <p id="warehouseSelect">
                    <?php
                        $asal_gudang = $db->table('warehouses');
                        $asal_gudang->where('warehouses.id', $good_transfers->warehouse_from_id);
                        $asal_gudang = $asal_gudang->get();
                        $asal_gudang = $asal_gudang->getFirstRow();

                        echo $asal_gudang->name;
                    ?>
                </p> 

                <b>Tujuan Gudang</b>
                <br>
                <p id="warehouseSelect">
                    <?php 
                        $tujuan_gudang = $db->table('warehouses');
                        $tujuan_gudang->where('warehouses.id', $good_transfers->warehouse_to_id);
                        $tujuan_gudang = $tujuan_gudang->get();
                        $tujuan_gudang = $tujuan_gudang->getFirstRow();

                        echo $tujuan_gudang->name; 
                    ?>
                </p>

                <b>Catatan</b> 
                <p id="warehouseSelect"><?= $good_transfers->details ?> </p>
                <br>  

          </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">                                                           
            <div class="card-body">
                <h4>Daftar Barang Yang Ingin Di Transfer</h4> 
                <hr> 
                <div class="table-responsive"> 
                    <table class="table table-striped table-bordered table-hover"> 
                        <thead>
                            <tr>
                                <th class='text-center'>No</th>
                                <th class='text-center'>Nama Barang</th>
                                <th class='text-center'>Kuantitas</th>
                                <!-- <th class= "text-center">Opsi</th>  -->
                            </tr> 
                        </thead> 
                        <tbody>
                            <?php 
                            $no = 0;
                            foreach ($good_transfers_items as $value) { 
                            $no++; 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td class="text-center"><?= $value->product_name ?></td>
                                <td class="text-center"><?= $value->quantity ?></td>
                            </tr>
                            <?php
                             }
                            ?>
                        </tbody>
                    </table> 
                    <!-- End table data -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<script type="text/javascript">
    $(function () {
        $('.select2bs4-BuyItemAdd').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modalBuyItemAdd'),
        })
    })
</script>

<script type="text/javascript">
$("#productSelect").change(function(){
    $.ajax({
        url: "<?= base_url('products/stocks/add/ajax/qty_recorded') ?>",
        type: "post",
        data: {
            product     : $("#productSelect").val(),
            warehouse   : $("#warehouseSelect").val(),
        },

        success: function(html) {
            // console.log(html);
            html = parseInt(html)
            $("#recordedQty").val(html)
            $("#realQty").val("0")
        }

    })
})

$("#warehouseSelect").change(function(){
    $.ajax({
        url: "<?= base_url('products/stocks/add/ajax/qty_recorded') ?>",
        type: "post",
        data: {
            product     : $("#productSelect").val(),
            warehouse   : $("#warehouseSelect").val(),
        },
        success: function(html) {
            // console.log(html);
            html = parseInt(html)
            $("#recordedQty").val(html)
            $("#realQty").val("0")
        }
    })
})

</script>
<?= $this->endSection() ?>