<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengiriman (DO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengiriman (DO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">        
        <div class="card">
            <div class="card-header bg-info">
                Pilih Penjualan (SO) Untuk Dibuatkan Data Pengiriman Barang (DO)
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Transaksi</th>
                            <th class="text-center">Nama Pelanggan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($sales as $sale){
                            ?>
                            <tr>
                                <td class="text-center"><?= $sale->sale_number ?></td>
                                <td class="text-center"><?= $sale->transaction_date ?></td>
                                <td class="text-center"><?= $sale->contact_name ?></td>
                                <td class="text-center"><span class="badge badge-<?= config("App")->orderStatusColor[$sale->status] ?>"><?= config("App")->orderStatuses[$sale->status] ?></span></td>
                                <?php
                                $this->db = \Config\Database::connect();
                                $session = \Config\Services::session(); 
                                $admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
                                $roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();
                                if($roles->delivery_order_lihat != NULL): ?>
                                <td class='text-center'>
                                    <a href="<?= base_url('sales/manage/'.$sale->id.'/warehouse') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
                                        <i class='fa fa-cog'></i>
                                    </a>
                                </td>
                                <?php endif ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>