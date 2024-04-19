<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Returs
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kelola Data Retur</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>  

<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body"> 
                <h4>
                    Data Retur
                    <a href="<?= base_url('sales/sale/retur/print/'.$good_retur->id) ?>" class="btn btn-info btn-sm float-right"><i class="fas fa-print"></i></a>
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