<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Retur
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kelola Data Retur</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<form action="<?= base_url('sales/return/add/items')?>" method="post"> 
    <input type="hidden" name="retur_id" value="<?= $good_retur->id ?>">
     <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-col-md-7">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Item / Barang</label>
                        <select name='sale_item_id' class='form-control' required id="itemSelect">
                            <option>-- Pilih Data Barang --</option>
                            <?php
                            foreach($items as $item){
                                echo"<option value='".$item->id."'>".$item->product_name."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Retur</label>
                        <select name='warehouses' class='form-control'>
                            <?php
                            foreach($warehouses as $warehouse){
                                echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Retur</label>
                        <input type='date' class='form-control' required name='date' value="<?= $good_retur->retur_date ?>">
                    </div>

                    <div class="mb-1">
                        <label>Stok Dipesan</label>
                        <label class="float-right" style="margin-right: 35px;">Jumlah Yang Ingin Diretur</label>
                        <div class='row'>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type='number' readonly id="qtyField" value='0' class='form-control' required placeholder="Jumlah Di Dalam Gudang">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                   <input type='number' name='quantity' class='form-control' placeholder="Kuantitas Barang" required>
                                </div>
                            </div>

                        </div>                            
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class='fa fa-plus'></i>
                        Tambah
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
                    Data Retur
                    <a href="<?= base_url('sales/sale/retur/print/'.$good_retur->id) ?>" class="btn btn-sm btn-success float-right"><i class="fas fa-print"></i></a> 
                </h4>  

                <hr>

                <b>Nomer Retur</b>
                <br>
                <p><?= $good_retur->retur_number ?></p>

                <b>Nomer Invoice</b>
                <br>
                <p><?= $good_retur->sales_number ?></p>

                <b>Nama Sales</b>
                <br>
                <p><?= $good_retur->admin_name ?></p>

                <b>Nama Pelanggan</b>
                <br>
                <p>
                <?php
                $contacts = $db->table('contacts');
                $contacts->where('contacts.id', $good_retur->contact_id);
                $contacts = $contacts->get();
                $contacts = $contacts->getFirstRow();

                echo $contacts->name;
                ?>
                </p> 

                <b>Keterangan</b> 
                <p>
                    <?= $good_retur->alasan ?>
                </p>
                <br>  

          </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">                                                           
            <div class="card-body">
                <h4> 
                    Daftar Barang
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalAdd"> 
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
                                <th class="text-center">Lokasi Retur</th>
                                <th class="text-center">Opsi</th> 
                            </tr> 
                        </thead> 
                        <tbody>
                            <?php 
                            $no = 0;
                            foreach ($retur_item as $value) {
                            $no++; 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td class="text-center"><?= $value->product_name ?></td>
                                <td class="text-center"><?= $value->quantity ?></td>
                                <td class="text-center">
                                    <?= $value->warehouse_name ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('sales/sale/retur/delete/'.$good_retur->id.'/items/'.$value->id) ?>" onclick="return confirm('Yakin ingin menghapus <?= $value->product_name ?> dari data retur.?')" class="btn btn-danger text-white btn-sm" title="delete Purchase">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
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

$("#itemSelect").change(function(){
    item = $(this).val();

    $.ajax({
        url : "<?= base_url('products/returns/ajax/sale/item/qty') ?>",
        type : "POST",
        data : { id : item },
        success : function(response){
            $("#qtyField").val(response);
        }
    })
})

function edit(id){
    $.ajax({
        url : "<?= base_url('products/returns/ajax/edit') ?>",
        type : "POST",
        data : { id : id },
        success: function(response){
            response = JSON.parse(response)
            $("#editID").val(response.return_id)
            $("#textEditPD").html(response.buy_number)
            $("#textEditItem").html(response.product_name)
            $("#textEditWarehouse").html(response.warehouse_name)
            $("#editDate").val(response.return_date)
            $("#editQty").val(response.return_quantity)
            $("#editQty").attr("max",response.buy_item_quantity)
            $("#editDetails").html(response.return_details)
        }
    })
}

</script>

<?= $this->endSection() ?>