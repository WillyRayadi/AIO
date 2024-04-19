<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Tambah Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/sales/grosir/sales'); ?>">Penjualan</a></li>
<li class="breadcrumb-item active">Tambah Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <form method="post" action="<?= base_url('/sales/grosir/sales/insert') ?>">
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
                                <label>Pelanggan (Kontak)</label>
                                <select name='contact' id='contactSelect' class='form-control'>
                                    <option value="">--Pilih Pelanggan--</option>
                                    <?php
                                    foreach($contacts as $contact){
                                        echo"<option value='".$contact->id."'>".$contact->name." | ".$contact->phone."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat Penagihan</label>
                                <textarea class='form-control' id="addressField" placeholder="Alamat Penagihan" required name='invoice_address'></textarea>
                            </div>
                            <div class="form-group">
                                <label>No. Referensi Pelanggan</label>
                                <input type='text' readonly id="referenceField" name='reference' class='form-control'>
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
                                <input type='date' readonly id="dateField" value="<?= date("Y-m-d") ?>" name='transaction_date' class='form-control' required>
                            </div>
                            <div class="form-group">
                                <label>Tgl. Jatuh Tempo</label>
                                <input type='date' readonly id="expiredField" name='expired_date' class='form-control' required>
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
        url : "<?= base_url('sales/grosir/ajax/sales/add/contact/data') ?>",
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
        url : "<?= base_url('sales/grosir/ajax/sales/add/expired/data') ?>",
        data : { id : id },
        type : "POST",
        success : function(response){
            $("#expiredField").val(response)
        }
    })
})

</script>


<?= $this->endSection() ?>