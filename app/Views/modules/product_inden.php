<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Barang Inden
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Barang Inden</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

    <div class="card">
        <div class="card-header bg-primary">
            <h5 class="card-title">Data Barang Inden</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class="text-center">SKU Barang</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Nomer Penjualan</th>
                            <th class="text-center">Nama Sales</th>
                            <th class="text-center">Tanggal Transaksi</th>
                            <th class="text-center">Status Penjualan</th>
                            <th class="text-center">Lokasi</th>
                            <th class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $key => $value): 
                            $admin = $db->table('administrators');
                            $admin->select('administrators.name');
                            $admin->where('administrators.id', $value->admin_id);
                            $admin = $admin->get();
                            $admin = $admin->getFirstRow();
                        ?>
                            <tr>
                                <td class="text-center"><?= $value->sku_number ?></td>
                                <td class="text-center"><?= $value->product_name ?></td>
                                <td class="text-center"><?= $value->sale_number ?></td>
                                <td class="text-center"><?= $admin->name ?></td>
                                <td class="text-center"><?= $value->transaction_date ?></td>
                                <td class="text-center"><span class="badge badge-<?= config("App")->orderStatusColor[$value->sale_status] ?>"><?= config("App")->orderStatuses[$value->sale_status] ?></span></td>
                                <td class="text-center"><?= $value->warehouse_name ?></td>
                                <td class="text-center"><?= $value->sale_qtys ?> Unit</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>