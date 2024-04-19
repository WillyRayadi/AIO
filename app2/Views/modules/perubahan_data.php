<?= $this->extend("general/template") ?>
<?= $this->section("page_title") ?>
Data Persetujuan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/perubahan_status'); ?>">Persetujuan</a></li>
<li class="breadcrumb-item active"></li>
<?= $this->endSection() ?>
<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-lg">
    <div class="card">
        <div class="card-header" style="background-color: #007bff;">
            <h3 class="card-title text-white">Data Perubahan</h3>
        </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id="datatables-default">
                    <thead>
                        <tr>
                            <th>Nomer PD</th>
                            <th>Nama Admin</th>
                            <th>Nama Pemasok</th>
                            <th>Alasan Merubah Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($alasan as $alas){
                        ?>
                        <tr>
                            <td><a href="<?= base_url('perubahan/data/manages/'.$alas->status_id) ?>"><?= $alas->buy_number ?></a></td>
                            <td><?= $alas->admin_name ?></td>
                            <td><?= $alas->contact_name ?></td>
                            <td><?= $alas->alasan?></td>
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

<?= $this->endSection() ?>
<?= $this->section("page_script") ?>
<?= $this->endSection() ?>