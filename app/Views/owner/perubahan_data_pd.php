<?= $this->extend("general/template") ?>
<?= $this->section("page_title") ?>
Data Persetujuan PD
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
                            <th class="text-center">Nomer PD</th>
                            <th class="text-center">Nama Admin</th>
                            <th class="text-center">Nama Pemasok</th>
                            <th class="text-center">Alasan Merubah Data</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $no = 0;
                        foreach($alasan as $alas){
                            $no++;
                        ?>
                        <tr>
                            <td class="text-center">
                               <a href="<?= base_url('owner/perubahan/data/manage/'.$alas->id) ?>"><?= $alas->buy_number ?></a> 
                            </td>
                            <td class="text-center"><?= $alas->admin_name ?></td>
                            <td class="text-center"><?= $alas->contact_name ?></td>
                            <td class="text-center"><?= $alas->alasan_perubahan ?></td>
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