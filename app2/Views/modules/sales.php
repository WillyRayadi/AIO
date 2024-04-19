<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<form method="post" action="<?= base_url('sales/manifest/print') ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Pilih Data Penjualan</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 

                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="number">Data Penjualan 1</label>
                        <select class="custom-select select2bs4-modalAdd" name="number1" id="sale" required>
                            <option>-- Pilih Penjualan --</option>
                            <?php foreach ($sales as $sale):
                            ?>
                                <option value="<?= $sale->id ?>"><?= $sale->contact_name." "."($sale->sale_number)" ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="number">Data Penjualan 2</label>
                        <select class="custom-select select2bs4-modalAdd" name="number2" id="sales" required>
                            <option>-- Pilih Penjualan --</option>
                           <?php foreach ($sales as $sale):
                            ?>
                                <option value="<?= $sale->id ?>"><?= $sale->contact_name." "."($sale->sale_number)" ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                </div>

            </div>
        </div>
    </div>
</form> 

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Penjualan (SO)</h5>
        <button type="submit" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modalAdd">
            <i class='fa fa-print'></i> Cetak Manifest
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="datatables-default">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal Transaksi</th>
                    <th class="text-center">Nama Sales</th>
                    <th class="text-center">Nama Pelanggan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($sales as $sale) {
                ?>
                <tr>
                    <td class="text-center"><?= $sale->sale_number ?></td>
                    <td class="text-center"><?= $sale->transaction_date ?></td>
                    <td class="text-center"><?= $sale->admin_name ?></td>
                    <td class="text-center"><?= $sale->contact_name ?></td>
                    <td class="text-center"><span class="badge badge-<?= config("App")->orderStatusColor[$sale->status] ?>"><?= config("App")->orderStatuses[$sale->status] ?></span></td>
                    <td class='text-center'>
                        <a href="<?= base_url('sales/'.$sale->id.'/manage') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
                            <i class='fa fa-cog'></i>
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

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>