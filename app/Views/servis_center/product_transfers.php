<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Transfer Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Transfer Barang</li>
<?= $this->endSection() ?> 
<?= $this->section("page_content") ?>

<form action="<?= base_url('warehouse/transfers/insert_data_awal') ?>" method="post">
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-2">
                                <label>No. Dokumen</label>
                                <input type="text" class="form-control" required readonly name="number" placeholder="<?= "TF/".date("y")."/".date("m")."/[auto]" ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class='form-label'>Asal Gudang</label>
                                <select name='from_warehouse' class='select2bs4'>
                                    <option>-- Pilih Gudang --</option>
                                    <?php
                                    foreach($warehouses as $warehouse){
                                        echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class='mb-2'>
                                <label class="form-label">Tujuan Gudang</label>
                                <select name='to_warehouse' class='form-control' id="warehouseSelect">
                                    <option>-- Pilih Gudang --</option>
                                    <option value="2">Cirebon - Kalijaga</option>
                                    <option value="3">Cirebon - ASS</option>
                                    <option value="8">Cirebon - Premium</option>
                                    <option value="4">Gudang Bandung</option>
                                    <option value="1">Gudang Cirebon</option>
                                    <option value="5">Gudang Tasikmalaya</option>
                                    <option value="6">Inden</option>
                                    <option value="7">Service Center Cirebon</option>
                                    <option value="10">Service Center Tasik</option>
                                    <option value="9">Tasikmalaya - Pasar Wetan</option>
                                </select>
                            </div>

                            <div class="mb-2" id="indenLocation">
                                <label class="form-label">Lokasi Inden</label>
                                <select name="inden_warehouse_id" class="form-control" id="warehouseInden">
                                    <option value="2">Cirebon - Kalijaga</option>
                                    <option value="3">Cirebon - ASS</option>
                                    <option value="8">Cirebon - Premium</option>
                                    <option value="4">Gudang Bandung</option>
                                    <option value="1">Gudang Cirebon</option>
                                    <option value="5">Gudang Tasikmalaya</option>
                                    <option value="9">Tasikmalaya - Pasar Wetan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class='mb-2'>
                                <label class="form-label">Admin</label>
                                <select name="admin_id" class="form-control" required>
                                   <?php
                                    foreach($admins as $admin){
                                        echo"<option value='".$admin->id."'>".$admin->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class='mb-2'> 
                                <div class="form-group">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="date" class="form-control">
                                </div>
                            </div>

                            <div class='mb-2'>
                               <div class="form-group">
                                <label>Catatan / Keterangan</label>
                                    <textarea class='form-control' name='details' placeholder="Tulis Catatan / Keterangan Di Sini" required></textarea>
                                </div>
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


<div class="row">
    <div class="col-md-12">
    <a href="<?= base_url('warehouse/transfers/add') ?>" class='btn btn-primary float-right mb-2' data-toggle="modal" data-target="#modalAdd">
        <i class='fa fa-plus'></i> Tambah</a>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Transfer Barang</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatables-default">

                        <thead>
                            <tr>
                                <th class='text-center'>Nomer Dokumen</th>
                                <th class='text-center'>Nama Admin</th>
                                <th class='text-center'>Tanggal</th>
                                <th class='text-center'>Asal Gudang</th>
                                <th class='text-center'>Tujuan Gudang</th>
                                <th class='text-center'>Opsi</th>
                            </tr> 
                        </thead> 

                        <?php  
                        foreach($data_transfers as $transfer){ 
                        ?>
                            
                            <?php 
 
                            $fromWarehouse = $db->table("warehouses"); 
                            $fromWarehouse->where("id",$transfer->warehouse_from_id); 
                            $fromWarehouse = $fromWarehouse->get(); 
                            $fromWarehouse = $fromWarehouse->getFirstRow(); 
  
                            $toWarehouse = $db->table("warehouses"); 
                            $toWarehouse->where("id",$transfer->warehouse_to_id);
                            $toWarehouse = $toWarehouse->get(); 
                            $toWarehouse = $toWarehouse->getFirstRow(); 
                            ?> 
 
                            <tr>  
                                <td class='text-center'><?= $transfer->number ?></td> 
                                <td class='text-center'> 
                                   <?php
                                    $admin = $db->table("administrators");
                                    $admin->where("id",$transfer->admin_id);
                                    $admin = $admin->get();
                                    $admin = $admin->getFirstRow();
                                    echo $admin->name;
                                   ?> 
                                </td>  
                                <td class='text-right'><?= date("d-m-Y",strtotime($transfer->date)) ?></td> 
                                <td><?= $fromWarehouse->name ?></td> 
                                <td><?= $toWarehouse->name ?></td>       
                                <td class='text-center'> 
                                    <a href="<?= base_url('warehouse/transfers/manage') . '/' . $transfer->id ?>" title="Kelola" class="btn btn-success btn-sm text-white">
                                        <i class='fa fa-cog'></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section("page_script")?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var indenLocation = document.getElementById('indenLocation');
        var toWarehouseSelect = document.getElementById('warehouseSelect');
        var indenWarehouseSelect = document.getElementById('warehouseInden');

        // Sembunyikan elemen awalnya
        indenWarehouseSelect.style.display = 'none';
        indenLocation.style.display = 'none';

        toWarehouseSelect.addEventListener('change', function () {
            // Periksa apakah nilai yang dipilih adalah 6
            if (toWarehouseSelect.value == 6) {
                // Tampilkan elemen jika nilai sama dengan 6
                indenLocation.style.display = 'block';
                indenWarehouseSelect.style.display = 'block';
            } else {
                // Sembunyikan elemen jika nilai tidak sama dengan 6
                indenLocation.style.display = 'none';
                indenWarehouseSelect.style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>