<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Barang Return
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Barang Return</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("sales/return/add") ?>">
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
                        <label>Nomer SO</label>
                        <select class="custom-select select2bs4-ReturItemAdd" name="sale_id" buy>
                            <option>-- Pilih Penjualan (SO) --</option>
                            <?php  
                            foreach ($sales as $sale) {
                                echo "<option value='".$sale->id."'>".$sale->number."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Return</label>
                        <input type='date' class='form-control' required name='date' value="<?= date("Y-m-d") ?>">
                    </div> 

                    <div class="form-group">
                        <label>Keterangan / Catatan</label>
                        <textarea class="form-control" required name='alasan' placeholder="Silahkan tuliskan keterangan / catatan di sini"></textarea>
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
<!-- End Of Modal Add -->
 
<div class="row">
    <div class="col-md-12">
        <buttoh type='button' class='btn btn-primary float-right' data-toggle='modal' data-target='#modalAdd'>
            <i class='fa fa-plus'></i>
            Tambah
        </buttoh>
        <div class="clearfix"></div>
        <div class="card mt-2">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Retur Penjualan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Nomer SO</th>
                            <th class='text-center'>Tanggal Retur</th>
                            <th class='text-center'>Keterangan</th>
                            <th class='text-center'>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $number = 0;
                            foreach ($stocks as $stok): 
                            $number++;
                        ?> 
                        <tr>
                            <td class='text-center'><?= $number ?></td>
                            <td class='text-center'><?= $stok->sale_number ?></td>
                            <td class='text-center'><?= $stok->date ?></td>
                            <td class='text-center'><?= $stok->alasan ?></td>
                            <td class='text-center'>
                                <a href="<?= base_url('sales/sale/retur/manage') . '/' . $stok->id ?>" class="btn btn-success btn-sm"><i class="fas fa-cog"></i></a>
                                <a href="<?= base_url('sales/sale/retur/delete') . '/' . $stok->id ?> " class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr> 
                        <?php endforeach ?>
                    </tbody> 
                </table> 
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?> 
<script type="text/javascript">
    $(function () {
        $('.select2bs4-ReturItemAdd').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modalAdd'),
        })
    })
</script>

<?= $this->endSection() ?>