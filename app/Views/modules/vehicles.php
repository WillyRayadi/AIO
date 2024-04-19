<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Kendaraan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Kendaraan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("vehicles/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kendaraan</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addName">Merek</label>
                        <input type="text" class="form-control" id="addName" name="brand" placeholder="merek" required>
                    </div>
                    <div class='form-group mt-4'>
                        <label for="addTipe">Tipe</label>
                        <input type="text" class="form-control" id="addTipe" name="type" placeholder="tipe" required>
                    </div>
                    <div class="form-group">
                        <label for="addNumber">Nomor</label>
                        <input type="text" class="form-control" id="addNumber" name="number" placeholder="nomor" required>
                    </div>
                    <div class="form-group">
                        <label for="addCapacity">Kapasitas</label>
                        <input type="number" min="1" class="form-control" id="addCapacity" name="capacity" placeholder="kapasitas" required>
                    </div>
                    <div class="form-group">
                        <label for="addDetails">Detail</label>
                        <textarea class="form-control" name="details" id="addDetails" rows="3" placeholder="detail" required></textarea>
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
<form method="post" action="<?= base_url("vehicles/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kendaraan</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editVehicle">
                    <div class="form-group">
                        <label for="editBrand">Merek</label>
                        <input type="text" class="form-control" id="editBrand" name="brand" placeholder="merek" required>
                    </div>
                    <div class='form-group mt-4'>
                        <label for="editType">Tipe</label>
                        <input type="text" class="form-control" id="editType" name="type" placeholder="tipe" required>
                    </div>
                    <div class="form-group">
                        <label for="editNumber">Nomor</label>
                        <input type="text" class="form-control" id="editNumber" name="number" placeholder="nomor" required>
                    </div>
                    <div class="form-group">
                        <label for="editCapacity">Kapasitas</label>
                        <input type="text" min="1" class="form-control" id="editCapacity" name="capacity" placeholder="kapasitas" required>
                    </div>
                    <div class="form-group">
                        <label for="editDetails">Detail</label>
                        <textarea class="form-control" name="details" id="editDetails" rows="3" placeholder="detail" required></textarea>
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
                Tambah Kendaraan
            </button>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Kendaraan</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Merek</th>
                                <th>Tipe</th>
                                <th>Nomor</th>
                                <th>Kapasitas</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 0;
                            foreach ($vehicles as $vehicle) {
                                $d++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= $d ?></td>
                                    <td><?= $vehicle->brand ?></td>
                                    <td><?= $vehicle->type ?></td>
                                    <td><?= $vehicle->number ?></td>
                                    <td><?= $vehicle->capacity ?></td>
                                    <td><?= $vehicle->details ?></td>
                                    <td class='text-center'>
                                        <a href="javascript:void(0)" title="Edit" onclick="edit('<?= $vehicle->id ?>', '<?= $vehicle->brand ?>', '<?= $vehicle->type ?>','<?= $vehicle->number ?>','<?= $vehicle->capacity ?>','<?= $vehicle->details ?>')" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm text-white">
                                            <i class='fa fa-edit'></i>
                                        </a>
                                        <a href="<?= base_url('vehicles') . '/' . $vehicle->id . '/delete' ?>" title="Hapus" onclick="return confirm('Yakin hapus kendaraan nomor : <?= $vehicle->number ?> ?')" class='btn btn-sm btn-danger text-white'>
                                            <i class='fa fa-trash'></i>
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

    <script type="text/javascript">
        function edit(id, brand, type, number, capacity, details) {
            $("#editVehicle").val(id)
            $("#editBrand").val(brand)
            $("#editType").val(type)
            $("#editNumber").val(number)
            $("#editCapacity").val(capacity)
            $("#editDetails").html(details)
        }
    </script>

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>