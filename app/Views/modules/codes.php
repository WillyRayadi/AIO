<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Kode
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Kode</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Edit -->
<form method="post" action="<?= base_url("codes/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kode</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editIDcode">
                    <div class="form-group">
                        <label for="editNamecode">Nama</label>
                        <input type="text" class="form-control" id="editNamecode" name="name" autocomplete="off" required>
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
                    <h3 class="card-title">Tambah Kode</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url("codes/add"); ?>">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" autocomplete="off" name="name" placeholder="Masukan nama . . ." required>
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
                    <h3 class="card-title">Data Kode</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 0;
                            foreach ($codes as $code) {
                                $d++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= $d ?></td>
                                    <td><?= $code->name ?></td>
                                    <td class='text-center'>
                                        <a href="javascript:void(0)" title="Edit" onclick="edit('<?= $code->id ?>','<?= $code->name ?>')" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm text-white">
                                            <i class='fa fa-edit'></i>
                                        </a>
                                        <a href="<?= base_url('codes') . '/' . $code->id . '/delete' ?>" title="Hapus" onclick="return confirm('Yakin hapus kode : <?= $code->name ?> ?')" class='btn btn-sm btn-danger text-white'>
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
        function edit(id, name) {
            $("#editIDcode").val(id)
            $("#editNamecode").val(name)
        }
    </script>

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>