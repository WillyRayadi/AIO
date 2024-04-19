<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Kategori Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Kategori Barang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Edit -->
<form method="post" action="<?= base_url("products/categories/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kategori Barang</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editIDproducts_category">
                    <div class="form-group">
                        <label for="editNameproducts_category">Nama</label>
                        <input type="text" class="form-control" id="editNameproducts_category" name="name" required>
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
<!-- End Of Modal Edit -->

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kategori Barang</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url("products/categories/add"); ?>">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-primary">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Kategori Barang</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 0;
                            foreach ($products_categories as $products_category) {
                                $d++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= $d ?></td>
                                    <td><?= $products_category->name ?></td>
                                    <td class='text-center'>
                                        <?php
                                        if ($products_category->name == "Tidak Berkategori") {
                                        } else {
                                        ?>
                                            <a href="javascript:void(0)" title="Edit" onclick="edit('<?= $products_category->id ?>','<?= $products_category->name ?>')" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm text-white">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                            <a href="<?= base_url('products/categories') . '/' . $products_category->id . '/delete' ?>" title="Hapus" onclick="return confirm('Yakin hapus kategori Barang : <?= $products_category->name ?> ?')" class='btn btn-sm btn-danger text-white'>
                                                <i class='fa fa-trash'></i>
                                            </a>
                                        <?php
                                        }
                                        ?>
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
        function edit(id, name) {
            $("#editIDproducts_category").val(id)
            $("#editNameproducts_category").val(name)
        }
    </script>

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>