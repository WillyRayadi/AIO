<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pembelian Barangs (PD)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active"> Pembelian Barang (PD)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<form action="<?= base_url('products/buy/add') ?>" method="post">
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pembelians</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class='form-label'>No. Transaksi</label>
                                <input type='text' name='invoice_number' class='form-control' readonly placeholder="<?= "PD/".date("y")."/".date("m")."/[auto]" ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class='form-label'>Pemasok</label>
                                <select class="custom-select select2bs4-modalAdd" name="supplier" id="supplier" required>
                                    <?php foreach ($suppliers as $supplier) : ?>
                                        <option value="<?= $supplier->id ?>"><?= $supplier->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class='mb-2'>
                                <label class='form-label'>Tanggal</label>
                                <input type="date" class='form-control' name='date' required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class='form-label'>Gudang</label>
                                <select class="custom-select" name="warehouse" id="warehouse" required>
                                    <?php foreach ($warehouses as $warehouse) : ?>
                                        <option value="<?= $warehouse->id ?>"><?= $warehouse->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class='mb-2'>
                                <label class='form-label'>Keterangan / Catatan</label>
                                <textarea name="notes" class="form-control" placeholder="Keterangan / Catatan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-primary'>
                        <i class='fa fa-plus'></i> Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal Import Data -->
<form method='post' action="#">
    <div class="modal fade" id="modalImportData" data-backdrop="static" data-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden='true'>
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Header Modal Bootstraps -->
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Import Data Pembelian</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- End Header Modal Bootstrap -->

                <!-- Body Modal Bootstrap -->
                <div class="modal-body">
                    <div class="form-group">
                        <label>Import Data</label>
                    </div>
                </div>
                <!-- End Body Modal Bootstrap -->

            </div>
        </div>
    </div>
</form>

<!-- Modal Add Contact -->
<form method="post" action="<?= base_url("contacts/add/direct_buy_add") ?>">
    <div class="modal fade" id="modalAddContact" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kontak</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="nama" required>
                    </div>

                    <div class='form-group mt-4'>
                        <label>Tipe</label>
                        <br>
                        <label class="mx-2">
                            <input type='radio' name='type' value="1" checked>
                            Pemasok
                        </label>
                        <label class="mx-2">
                            <input type='radio' name='type' value="2">
                            Pelanggan
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="phone">No. Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="No. Telepon" required>
                    </div>

                    <!-- <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                    </div> -->
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="alamat" required></textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label for="phone">No. Referensi</label>
                        <input type="text" class="form-control" id="reference" name="reference" placeholder="No. Referensi" required>
                    </div> -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- End Of Modal Add Contact --> 

<?php
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if($roles->purchase_order_buat != NULL): ?>
<div class='row mb-2'>
      <div class='col-md-12'>
        <button type="button" class="btn btn-primary float-right ml-2" data-toggle="modal" data-target="#modalAddContact">
            <i class='fa fa-plus'></i>
            Tambah Pemasok
        </button>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAdd">
            <i class='fa fa-plus'></i>
            Tambah Pembelian
        </button>
    </div>
</div>

<?php endif ?>

<div class='row'>
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Pembelian Barang (PD)</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-hover" id="datatables-default">
                    
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Nomer Transaksi</th>
                            <th class='text-center'>Pemasok</th>
                            <th class='text-center'>Gudang</th>
                            <th class='text-center'>Tanggal</th>
                            <th class='text-center'>Keterangan</th>
                            <?php
                            $this->db = \Config\Database::connect();
                            $session = \Config\Services::session(); 
                            $admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
                            $roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

                            if($roles->purchase_order_edit != NULL): ?>
                            <th class="text-center">Aksi</th>
                            
                            <?php endif ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $d = 0;
                        ?>
                        <?php foreach ($good_buys as $good_buy) : ?>
                            <?php $d++ ?>
                            <tr>
                                <td class="text-center"><?= $d ?></td>
                                <td><?= $good_buy->number ?></td>
                                <td><?= $good_buy->contact_name ?></td>
                                <td><?= $good_buy->warehouse_name ?></td>
                                <td><?= $good_buy->date ?></td>
                                <td><?= $good_buy->notes ?></td>
                                <?php
                                $this->db = \Config\Database::connect();
                                $session = \Config\Services::session(); 
                                $admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
                                $roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

                                if($roles->purchase_order_edit != NULL): ?>
                                <td class="text-center">
                                    <a href="<?= base_url('products/buy/manage') . '/' . $good_buy->id ?>" title="Kelola" class="btn btn-success btn-sm text-white">
                                        <i class='fa fa-cog'></i>
                                    </a>
                                </td>
                                
                                <?php endif ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>