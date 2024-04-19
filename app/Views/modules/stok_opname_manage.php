<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Stok Opname
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('stok_opname') ?>">Stok Opname</a></li>
<li class="breadcrumb-item active">Kelola Data</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<form action="<?= base_url('stok/opname/item')?>" method="post"> 
    <div class="modal fade" id="modalBuyItemAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
        <input type="hidden" name="id_stok_opname" value="<?= $stokOpname->id ?>"> 
        <div class="modal-dialog"> 
            <div class="modal-content"> 
                <div class="modal-header bg-primary"> 
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang </h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                        <span aria-hidden="true">&times;</span> 
                    </button> 
                </div> 
                <div class="modal-body"> 
                    <div class="mb-2">
                        <label class="form-label">Barang</label>
                        <select id="productSelect" class="custom-select select2bs4-BuyItemAdd" name="product_id" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product->id ?>"><?= $product->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!--<div class="mb-2">-->
                    <!--    <label class="form-label">Stok di aplikasi</label>-->
                    <!--    <div class="row">-->

                    <!--        <div class="col-md-6">-->
                    <!--            <select class='form-control' disabled id="warehouseSelect">-->
                   
                    <!--            </select>-->
                    <!--        </div>-->

                    <!--        <div class="col-md-6">-->
                    <!--            <input type="number" readonly id="recordedQty" value="0" name="qty_recorded" class="form-control" required placeholder="Jumlah Di Dalam Gudang">-->
                    <!--        </div>-->
                            
                    <!--    </div>-->
                    <!--</div> -->
                    

                    <div class="mb-2">
                        <label class="form-label">Jumlah digudang Barang</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Kuantitas Barang" required>
                    </div> 

                    <!-- <div class='mb-2'>
                        <label class='form-label'>Harga</label>
                        <input type='number' name='harga_barang' class='form-control' placeholder='Harga Barang' required>
                    </div> -->

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah
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
                    Stok Opname  
                    
                    <a href="<?= base_url('stok_opname/export/' . $stokOpname->id) ?>" class="btn btn-success btn-sm float-right"><i class="fas fa-file-excel"></i> Export data</a>
                   
                </h4>  

                <hr>

                <b>No. Dokumen</b>
                <br>
                <p><?= $stokOpname->number_document?></p>

                <b>Nama Admin</b>
                <br>
                <p><?= $stokOpname->admin_name ?></p>

                <b>Lokasi </b>
                <br>
                <p>
                    <?= $stokOpname->warehouse_name ?>
                </p>  
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
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Kuantitas</th>
                                <th class="text-center">Opsi</th> 
                            </tr> 
                        </thead> 
                        <tbody>
                           <?php foreach ($stokOpname_items as $key => $value): ?>
                               <tr>
                                   <td><?= $value->product_name ?></td>
                                   <td class="text-center"><?= $value->quantity ?></td>
                                   <td class="text-center">
                                       <a href="<?= base_url('stok/opname/item/'.$stokOpname->id.'/delete/'.$value->id) ?>" onclick="return confirm('Yakin ingin menghapus data <?= $value->product_name ?>?')" class="btn btn-sm btn-danger">
                                           <i class="fas fa-trash"></i>
                                       </a>
                                   </td>
                               </tr>
                           <?php endforeach ?>
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