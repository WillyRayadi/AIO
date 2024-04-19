<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Data Kapasitas Produk
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Data Kapasitas Produk</li>
<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info"> <a href="<?= base_url("products/add/capacity") ?>" data-toggle="modal" data-target="#exampleModal" class="btn btn-success"><i class="fas fa-plus-square"> Tambah</i></a></div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id='datatables-default'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kapasitas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0;
                        foreach ($Kapasitas as $item) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $item->kapasitas ?></td>
                                <td><a data-toggle="modal" data-target="#deleteModal<?= $item->id ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kapasitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('products/add/capacity') ?>" method="POST">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Kapasitas</label>
                        <input type="text" class="form-control" name="kapasitas" placeholder="Kapasitas" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="Submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php foreach($Kapasitas as $data): ?>
<div class="modal fade" id="deleteModal<?= $data->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin menghapus <?= $data->kapasitas ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('products/capacity/'.$data->id.'/delete') ?>">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
                    <button type="Submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>

<?= $this->endSection() ?>