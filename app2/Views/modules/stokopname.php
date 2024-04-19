<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?> 
Stok Opname
<?= $this->endSection() ?> 

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Stok Opname</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("stokOpname/first/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="brand_code">Number</label>
                        <input type="text" class="form-control" name="number" placeholder="<?= "SOP/".date("y")."/".date("m")."/[auto]" ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Gudang</label>
                        <select class="form-control" name="warehouses">
                           <option>-- Pilih Gudang --</option>
                           <?php
                           foreach($warehouses as $warehouse){
                            echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand_name">Tanggal</label>
                    <input type="date" class="form-control" name="date"required="true" required>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>
</form>
<!-- End Of Modal Add --> 

<div class="container-fluid mt-4">
    <?php
    $this->db = \Config\Database::connect();
    $session = \Config\Services::session(); 
    $admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
    $roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

    if($roles->stokopname_buat != NULL): ?>
    <div class="row">
        <div class="col-12 mb-3">
            
            <button type="button" class="btn btn-primary float-right" style="margin-left:20px;" data-toggle="modal" data-target="#modalAdd">
                <i class='fa fa-plus'></i>
                Tambah Data
            </button>

        </div>
    </div>
    
    <?php endif ?>


    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Stok Opname</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nomer Dokumen</th>
                                <th class="text-center">Tanggal Stok Opname</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 0;
                            foreach ($stokOpname as $SOP) {
                                $d++;
                                ?>
                                <tr>
                                   <td class="text-center"><?= $d ?></td>
                                   <td class="text-center"><?= $SOP->number ?></td>
                                   <td class="text-center"><?= $SOP->date ?></td>
                                   <td class="text-center"><?= $SOP->name ?></td>
                                   <td class="text-center">
                                    <?php
                                    $this->db = \Config\Database::connect();
                                    $session = \Config\Services::session(); 
                                    $admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
                                    $roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

                                    if($roles->stokopname_buat != NULL): ?>
                                    <a href="<?= base_url('stok_opname/manage/'.$SOP->id)?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <?php endif ?>
                                    
                                    <?php
                                    $this->db = \Config\Database::connect();
                                    $session = \Config\Services::session(); 
                                    $admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
                                    $roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

                                    if($roles->stokopname_hapus != NULL): ?>
                                    <a href="<?= base_url('stok/opname/delete/'.$SOP->id)?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus <?= $SOP->number ?> ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    
                                    <?php endif ?>
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

</div>
<?= $this->endSection() ?>