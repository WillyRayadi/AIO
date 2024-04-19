<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Brand
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Brand</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("brand/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Brands</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="brand_code">Kode Brand</label>
                        <input type="text" class="form-control" name="brand_code" placeholder="Masukan Kode Brand" required="true">
                    </div>
                    <div class="form-group">
                        <label for="brand_name">Nama Brand</label>
                        <input type="text" class="form-control" name="brand_name" placeholder="Masukan Nama Brand" required="true">
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

<!-- Modal Add -->
<form method="post" action="<?= base_url("contacts/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editBrand">
                    <div class="form-group">
                        <label for="editName">Kode Brand</label>
                        <input type="text" class="form-control" name="brand_code" id="editName">
                    </div>
                    <div class="form-group">
                        <label for="editName">Nama Brand</label>
                        <input type="text" class="form-control" name="brand_name" id="edit_name">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Add -->


<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-3">

            <button type="button" class="btn btn-primary float-right" style="margin-left:20px;" data-toggle="modal" data-target="#modalAdd">
                <i class='fa fa-plus'></i>
                Tambah Data
            </button>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Brand</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kode Brand</th>
                                <th class="text-center">Nama Brand</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php
                         $d = 0;
                         foreach ($brands as $brand) {
                            $d++;
                            ?>
                            <tr>
                               <td><?= $d ?></td>
                               <td><?= $brand->brand_code ?></td>
                               <td><?= $brand->brand_name ?></td>
                               <td class="text-center">
                                <a href="<?= base_url('brand/delete/'.$brand->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus <?= $brand->brand_name ?> ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div> 

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>