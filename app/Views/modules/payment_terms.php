<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Metode Pembayaran
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Metode Pembayaran</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Edit -->
<form method="post" action="<?= base_url("payment/terms/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Metode Pembayaran</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idBuyTerms" id="editIDasset_category">
                    <div class="form-group">
                        <label for="editNameasset_category">Nama</label>
                        <input type="text" class="form-control" id="editNameasset_category" name="name" required>
                    </div>
                    <div class="form-group">
                            <label>Jumlah Hari Jatuh Tempo</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editDue" name="due_date" value='0' required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">hari</div>
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="editDetail">Detail</label>
                        <textarea class="form-control" name="detail" id="editDetail" rows="3" placeholder="Detail" required></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                    <h3 class="card-title">Tambah Metode Pembayaran</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url("payment/terms/add"); ?>">
                        <div class="form-group">
                            <label for="editNameSupplier">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Hari Jatuh Tempo</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="due_date" value='0' required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">hari</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="addDetail">Detail</label>
                            <textarea class="form-control" name="detail" id="addDetail" rows="3" placeholder="Detail" required></textarea>
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
                    <h3 class="card-title">Data Metode Pembayaran</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped mb-3" id="datatables-default">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jatuh Tempo</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 1;
                            foreach ($buy_terms as $asset_category) {
                            ?>
                                <tr>
                                    <td class='text-center'><?= $d++; ?></td>
                                    <td><?= $asset_category->name ?></td>
                                    <td class='text-right'><?= $asset_category->due_date ?> hari</td>
                                    <td><?= $asset_category->details ?></td>
                                    <td class='text-center'>
                                        <a href="javascript:void(0)" title="Edit" onclick="edit('<?= $asset_category->id ?>','<?= $asset_category->name ?>','<?= $asset_category->due_date ?>','<?= $asset_category->details ?>')" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm text-white">
                                            <i class='fa fa-edit'></i>
                                        </a>
                                        <a href="<?= base_url('payment/terms/delete') . '/' . $asset_category->id  ?>" title="Delete" onclick="return confirm('Yakin ingin menghapus <?= $asset_category->name ?> ?')" class='btn btn-sm btn-danger text-white'>
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
        function edit(id, name, due, detail) {
            $("#editIDasset_category").val(id)
            $("#editNameasset_category").val(name)
            $("#editDue").val(due)
            $("#editDetail").val(detail)
        }
    </script>

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>