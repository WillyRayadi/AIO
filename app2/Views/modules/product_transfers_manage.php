<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Produk Transfers
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('products/transfers') ?>">Produk Transfers</a></li>
<li class="breadcrumb-item active">Kelola Transfer Produk</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<form action="<?= base_url('products/transfers/items')?>" method="post"> 
    <div class="modal fade" id="modalBuyItemAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <input type="hidden" name="warehouse_transfers_id" value="<?= $good_transfers->id ?>"> 
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header bg-primary"> 
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang </h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                        <span aria-hidden="true">&times;</span> 
                    </button> 
                </div> 
                <div class="modal-body"> 
                    <div class='mb-2'>
                        <label class='form-label'>Barang</label>
                        <select id="productSelect" class='custom-select select2bs4-BuyItemAdd' name="product_id" required>
                            <?php
                                foreach($products as $product){    
                                    echo "<option value='".$product->id."'>".$product->name."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-1">
                        <label>Stok Tersedia</label>
                        <label class="float-right" style="margin-right: 132px;">Jumlah Transfer</label>
                        <div class='row'>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type='number' readonly id="recordedQty" value='0' name='qty_recorded' class='form-control' required placeholder="Jumlah Di Dalam Gudang">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                   <input type='number' name='quantity' class='form-control' placeholder="Kuantitas Barang" required>
                                </div>
                            </div>

                        </div>                            
                    </div>

                    <div class="mb-2">
                        <div class="form-group">
                            <label class='form-label' id='date'>Tanggal</label>
                            <input name='date' type="date" class='form-control' value="<?= $good_transfers->date ?>" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="form-group">
                                <label>Asal Gudang</label>
                                <select name='from_warehouse' class='form-control' id="warehouseSelect">
                                    <?php
                                    foreach($warehouses as $warehouse){
                                        if($warehouse->id == $good_transfers->warehouse_from_id) {
                                            $selectedWarehouse = "selected";
                                        }else{
                                            $selectedWarehouse = "";
                                        }

                                        echo "
                                        <option value='" . $warehouse->id . "' $selectedWarehouse>" . $warehouse->name . "</option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </div>
                    </div>

                    <div class="mb-2">
                        <div class="form-group">
                            <label>Tujuan Gudang</label>
                            <select name='to_warehouse' class='form-control' id="warehouseSelect">
                                    <?php
                                    foreach($warehouses as $warehouse){
                                        if($warehouse->id == $good_transfers->warehouse_to_id) {
                                            $selectedWarehouse = "selected";
                                        }else{
                                            $selectedWarehouse = "";
                                        }
                                         echo "
                                        <option value='" . $warehouse->id . "' $selectedWarehouse>" . $warehouse->name . "</option>
                                        ";
                                    }
                                    ?>
                            </select> 
                        </div>
                    </div>

                    <input type="hidden" value="0" class='form-control' placeholder="Harga per barang" name='price' required>
                    <!-- <div class='mb-2'>
                        <label class='form-label'>Haraga</label>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-primary'>
                        <i class='fa fa-plus'></i> Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- END MODAL ADD TRANSFERS ITEMS --> 

<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body"> 
                <h4>
                    Gudang Transfer 
                    
                    <a href="<?= base_url('products/transfers/'.$data_transfers->id.'/print/'.$good_transfers->id) ?>" class="btn btn-info btn-sm float-right"><i class="fas fa-print"></i></a>
                   
                </h4>  

                <hr>

                <b>No. Transaksi</b>
                <br>
                <p id="warehouseSelect"><?= $good_transfers->number ?></p>

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
                <h4> 
                    Daftar Barang
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalBuyItemAdd"> 
                        <i class='fa fa-plus'></i> 
                    </button> 
                </h4> 
                <hr> 
                <div class="table-responsive"> 
                    <table class="table table-striped table-bordered table-hover"> 
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Kuantitas</th>
                                <?php
                                $session = \Config\Services::session(); 
                                if (isset($session->login_id) && ($session->login_id == 9 || $session->login_id == 83 || $session->login_id == 12)):
                                ?>
                                <th class="text-center">Opsi</th> 
                                <?php endif; ?>
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
                                <?php
                                $session = \Config\Services::session(); 
                                if (isset($session->login_id) && ($session->login_id == 9 || $session->login_id == 83 || $session->login_id == 12)):
                                ?>
                                <td class="text-center">
                                    <a href="<?= base_url('products/transfers/delete/'.$good_transfers->id.'/items/'.$value->id) ?>"onclick="return confirm('Yakin ingin menghapus <?= $value->product_name ?> dari daftar transfer barang.?')" class="btn btn-danger text-white btn-sm" title="delete Purchase">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                                <?php endif; ?>
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