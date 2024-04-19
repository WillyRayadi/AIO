<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Pelanggan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Pelanggan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("customers/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Pelanggan</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="No. Telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
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

<!-- Modal Add -->
<form method="post" action="<?= base_url("customers/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Pelanggan</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editIDcustomer">
                    <div class="form-group">
                        <label for="editNamecustomer">Nama</label>
                        <input type="text" class="form-control" id="editNamecustomer" name="name" placeholder="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="editPhonecustomer">No. Telepon</label>
                        <input type="text" class="form-control" id="editPhonecustomer" name="phone" placeholder="No. Telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmailcustomer">Email</label>
                        <input type="email" class="form-control" id="editEmailcustomer" name="email" placeholder="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddresscustomer">Alamat</label>
                        <textarea class="form-control" name="address" id="editAddresscustomer" rows="3" placeholder="alamat" required></textarea>
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
                Tambah Pelanggan
            </button>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Pelanggan</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No. Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 0;
                            foreach ($customers as $customer) {
                                $d++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= $d ?></td>
                                    <td><?= $customer->name ?></td>
                                    <td><?= $customer->phone ?></td>
                                    <td><?= $customer->email ?></td>
                                    <td><?= $customer->address ?></td>
                                    <td class='text-center'>
                                        <a href="javascript:void(0)" title="Edit" onclick="edit('<?= $customer->id ?>','<?= $customer->name ?>','<?= $customer->phone ?>','<?= $customer->email ?>','<?= $customer->address ?>')" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm text-white">
                                            <i class='fa fa-edit'></i>
                                        </a>
                                        <a href="<?= base_url('customers') . '/' . $customer->id . '/delete' ?>" title="Hapus" onclick="return confirm('Yakin hapus pemasok : <?= $customer->name ?> ?')" class='btn btn-sm btn-danger text-white'>
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
        function edit(id, name, phone, email, address) {
            $("#editIDcustomer").val(id)
            $("#editNamecustomer").val(name)
            $("#editPhonecustomer").val(phone)
            $("#editEmailcustomer").val(email)
            $("#editAddresscustomer").html(address)
        }
    </script>

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>