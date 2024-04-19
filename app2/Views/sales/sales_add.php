<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Tambah Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/sales/sales'); ?>">Penjualan</a></li>
<li class="breadcrumb-item active">Tambah Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("sales/contacts/add/direct_sales_add") ?>">
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

<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?= base_url('/sales/sales/insert') ?>">
            <div class="card mt-2">
                <div class="card-header bg-primary">
                    Tambah Penjualan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Transaksi</label>
                                <input type='text' readonly class='form-control' placeholder="<?= "SO/".date("y")."/".date("m")."/[auto]" ?>">
                            </div>                            
                        </div>                        
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Pelanggan (Kontak)
                                    <a href="javascript:void(0)" data-toggle='modal' data-target='#modalAdd'>
                                        <i class='fa fa-plus'></i>
                                        Tambah Kontak
                                    </a>
                                </label>
                                <select name='contact' id='contactSelect' class='form-control select2bs4'>
                                    <option value="">--Pilih Pelanggan--</option>
                                    <?php
                                    foreach($contacts as $contact){
                                        echo"<option value='".$contact->id."'>".$contact->name." | ".$contact->phone."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat Pelanggan</label>
                                <textarea class='form-control' id="addressField" placeholder="Alamat Pelanggan" required name='invoice_address'></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Metode Pembayaran</label>
                                <select name='payment' id='paymentSelect' class='form-control'>
                                    <option value="">--Pilih Metode Pembayaran--</option>
                                    <?php
                                    foreach($payments as $payment){
                                        echo"<option value='".$payment->id."'>".$payment->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Transaksi</label>
                                <input type='date' id="dateField" value="<?= date("Y-m-d") ?>" name='transaction_date' class='form-control' required>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Jatuh Tempo</label>
                                <input type='date' id="expiredField" name='expired_date' class='form-control' required>
                            </div>                            
                        </div>                        
                        <div class="col-md-4">                            
                            <div class="form-group">
                                <label>Gudang</label>
                                <select name='warehouse' class='form-control'>
                                    <?php
                                    foreach($warehouses as $warehouse){
                                        echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tag</label>
                                <select name='tags[]' class="select2bs4" id="tagSelect" multiple="multiple" style="width: 100%;">
                                <?php
                                foreach($tags as $tag){
                                    echo"<option value='".$tag->name."'>".$tag->name."</option>";
                                }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Memo / Catatan</label>
                                <textarea class='form-control' placeholder="Memo / Catatan" required name='sales_notes'></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type='submit' class='btn btn-success float-right'>
                        <i class='fa fa-plus'></i>
                        Buat Penjualan (SO)
                    </button>
                </div>
            </div>
        </form>
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
            // $("#referenceField").val(response.no_reference)
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


<?= $this->endSection() ?>