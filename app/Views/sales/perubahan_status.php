<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Perubahan Status
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/perubahan_status'); ?>">Perubahan Status</a></li>
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
                            <th>No</th>
                            <th>Nomer SO</th>
                            <th>Nama Pelanggan</th>
                            <th>Status Awal</th>
                            <th>Alasan Merubah Status</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $no = 0;
                        foreach($alasan as $alas){
                            $no++;
                        ?>
                        <tr>
                            <td><?= $no;?></td>
                            
                            <?php
                                $sale = $db->table('sales');
                                $sale->where('sales.id',$alas->sale_id);
                                $sale->orderBy('sales.id','desc');
                                $sale = $sale->get();
                                $sale = $sale->getFirstRow();
                            ?>

                            <td>
                                <a href=""><?= $alas->sale_number ?></a>
                            </td>
                            <td><?= $alas->contact_name ?></td>
                            <td><?= config("App")->orderStatuses[$alas->status_awal] ?></td>
                            <td><?= $alas->alasan ?></td>
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