<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Retur Pemasok 
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Barang Return</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("returns/pemasok/add") ?>">
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
                        <select class="custom-select select2bs4-modalAdd" name="contact_id">
                            <option>-- Pilih Pemasok --</option>
                            <?php  
                            foreach ($pemasok as $value) {
                                echo "<option value='".$value->id."'>".$value->name."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Lokasi</label>
                        <select class="form-control" name="warehouse_id">
                            <option value="">-- Pilih Lokasi --</option>
                            <option value="7">Servis Center Cirebon</option>
                            <option value="10">Servis Center Tasik</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Return</label>
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
<!-- End Of Modal Add -->

<div class="row">
    <div class="col-md-12">        
        <div class="card">
            <div class="card-header bg-info">
               <h5 class="card-title">Data Retur Pemasok</h5>
                <button type='button' class='btn btn-success float-right' data-toggle='modal' data-target='#modalAdd'>
                    <i class='fa fa-plus'></i>Tambah
                </button>
            </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered" id="datatables-default">
                <thead>
                    <tr>
                        <th class="text-center">Nomer Retur</th>
                        <th class="text-center">Lokasi</th>
                        <th class="text-center">Nama Pelanggan</th>
                        <th class="text-center">Tanggal Retur</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($returns as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><?= $value->number_retur ?></td>
                            <td class="text-center"><?= $value->warehouse_name ?></td>
                            <td class="text-center"><?= $value->contact_name ?></td>
                            <td class="text-center"><?= $value->retur_date ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('returns/manage/'.$value->id) ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-cog"></i>
                                </a>
                                
                                <a href="<?= base_url('returns/pemasok/delete/'.$value->id) ?>" class="btn btn-sm btn-danger">
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