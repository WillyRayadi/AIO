<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Transfer Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Transfer Barang</li>
<?= $this->endSection() ?> 
<?= $this->section("page_content") ?>


<div class="row">
    <div class="col-md-12">
   <!--  <a href="<?= base_url('sales/transfers/add') ?>" class='btn btn-primary float-right mb-2' data-toggle="modal" data-target="#modalAdd">
        <i class='fa fa-plus'></i> Tambah</a> -->
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

                                <td class='text-right'><?= date("d-m-Y",strtotime($transfer->date))?></td>
                                <td><?= $fromWarehouse->name ?></td> 
                                <td><?= $toWarehouse->name ?></td>      
                                <td class='text-center'> 

                                    <a href="<?= base_url('audit/transfers_manage').'/'.$transfer->id ?>" title="Kelola" class="btn btn-success btn-sm text-white">
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