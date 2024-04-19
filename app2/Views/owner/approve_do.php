<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Pengajuan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan pengajuan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<div class="row">
    <div class="col-lg">
    <div class="card">
        <div class="card-header bg-info">
            <h5 class="card-title">Persetujuan Print Ulang</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="datatables-default">
                <thead>
                    <tr>
                        <th class="text-center">Nama User</th>
                        <th class="text-center">Tanggal Pengajuan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($stages as $stage){ ?>
                        <tr>   
                            <td class="text-center"><?= $stage->admin_name ?></td>
                            <td class="text-center"><?= $stage->submit_date ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('approve/do/manage/'.$stage->id) ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

<?= $this->endSection() ?>