<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Gudang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Gudang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("warehouses/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Gudang</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="code">Kode</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="kode" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="nama" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="alamat" required></textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="details">Detail</label>
                        <textarea class="form-control" name="details" id="details" rows="3" placeholder="detail" required></textarea>
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

<!-- Modal edit -->
<form method="post" action="<?= base_url("warehouses/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Gudang</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editIDwarehouse">
                    <div class="form-group">
                        <label for="editcodewarehouse">Kode</label>
                        <input type="text" class="form-control" id="editcodewarehouse" name="code" placeholder="kode" required>
                    </div>
                    <div class="form-group">
                        <label for="editNamewarehouse">Nama</label>
                        <input type="text" class="form-control" id="editNamewarehouse" name="name" placeholder="nama" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="editAddresswarehouse">Alamat</label>
                        <textarea class="form-control" name="address" id="editAddresswarehouse" rows="3" placeholder="alamat" required></textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="editdetailswarehouse">Detail</label>
                        <textarea class="form-control" name="details" id="editdetailswarehouse" rows="3" placeholder="detail" required></textarea>
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
<!-- End Of Modal edit -->


<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-3">

            <button type="button" class="btn btn-primary float-right" style="margin-left:20px;" data-toggle="modal" data-target="#modalAdd">
                <i class='fa fa-plus'></i>
                Tambah Gudang
            </button>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Gudang</h3>
                </div>
                <div class="card-body">
                    <div class='table-responsive'>
                        <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Gudang</th>
                                    <th>Nama</th>
                                    <th>Alias</th>
                                    <!-- <th>Alamat</th> -->
                                    <th>Detail</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $d = 0;
                                foreach ($warehouses as $warehouse) {
                                    $d++;
                                ?>
                                    <tr>
                                        <td class='text-center'><?= $d ?></td>
                                        <td><?= $warehouse->code ?></td>
                                        <td><?= $warehouse->name ?></td>
                                        <td><?= $warehouse->initials ?></td>
                                        <!-- <td><?= $warehouse->address ?></td> -->
                                        <td><?= $warehouse->details ?></td>
                                        <td class='text-center'>
                                            <a href="javascript:void(0)" title="Edit" onclick="edit('<?= $warehouse->id ?>','<?= $warehouse->name ?>','<?= $warehouse->code ?>','<?= $warehouse->details ?>','<?= $warehouse->address ?>')" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm text-white">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                            <a href="<?= base_url('warehouses') . '/' . $warehouse->id . '/delete' ?>" title="Hapus" onclick="return confirm('Yakin hapus pemasok : <?= $warehouse->name ?> ?')" class='btn btn-sm btn-danger text-white'>
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
    </div>

    <script type="text/javascript">
        function edit(id, name, code, details, address) {
            $("#editIDwarehouse").val(id)
            $("#editNamewarehouse").val(name)
            $("#editcodewarehouse").val(code)
            $("#editdetailswarehouse").html(details)
            // $("#editAddresswarehouse").html(address)
        }
    </script>

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>