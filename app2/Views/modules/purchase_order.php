<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>

<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Purchase Order</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("purchase/order/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-col-md-8">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama Pemasok</label>
                        <select class="custom-select select2bs4-modalAdd" name="suppliers">
                            <option>-- Pilih Pemasok --</option>
                            <?php  
                            foreach ($suppliers as $value) {
                                echo "<option value='".$value->id."'>".$value->name."</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Tanggal PO</label>
                        <input type='date' class='form-control' required name='dates' value="<?= date("Y-m-d") ?>">
                    </div>  

                    <div class="form-group">
                        <label>Keterangan / Catatan</label>
                        <textarea class="form-control" required name='keterangan' placeholder="Silahkan tuliskan keterangan / catatan di sini"></textarea>
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
 
<div class="row">
    <div class="col-lg">        
        <div class="card">
            <div class="card-header bg-info">
             <h5 class="card-title">Data Purchase Order</h5>
             <buttoh type='button' class='btn btn-success float-right' data-toggle='modal' data-target='#modalAdd'>
                <i class='fa fa-plus'></i>
                Tambah
            </buttoh>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered" id="datatables-default">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nomer Purchase Order</th>
                        <th class="text-center">Nama Supplier</th>
                        <th class="text-center">Tanggal Purchase Order</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach($purchases as $purchase){
                        $no++;
                        ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center"><?= $purchase->po_number ?></td>
                        <td class="text-center"><?= $purchase->contact_name ?></td>
                        <td class="text-center"><?= $purchase->date ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('purchase/order/manage/'.$purchase->id) ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-cog"></i>
                            </a>
                            <a href="<?= base_url('purchase/order/delete/'.$purchase->id) ?>" onclick="return confirm('Apakah kamu yakin ingin menghapus <?= $purchase->po_number ?>.?')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
</div>

<?= $this->endSection() ?> 