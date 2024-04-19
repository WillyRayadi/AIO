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
                            <th class='text-center'>No</th>
                            <th class='text-center'>Tgl. Transaksi</th>
                            <!--<th class='text-center'>Tgl. Jatuh Tempo</th>-->
                            <?php
                            $session = \Config\Services::session();
                            if ($session->login_id != 98) : ?>
                                <th class='text-center'>Sales</th>
                            <?php endif ?>
                            <th class='text-center'>Pelanggan</th>
                            <th class='text-center'>Status</th>
                            <th class='text-center'>Tags</th>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($sales as $sale) {
                        ?>
                            <tr>
                                <td class='text-center'><?= $sale->number ?></td>
                                <td class='text-right'><?= date("d-m-Y", strtotime($sale->transaction_date)) ?></td>
                                <!-- <td class='text-right'><?= date("d-m-Y", strtotime($sale->expired_date)) ?></td> -->
                                <?php
                                $session = \Config\Services::session();
                                if ($session->login_id != 98) : ?>
                                    <td>
                                        <?php
                                        $admin = $db->table("administrators");
                                        $admin->where("id", $sale->admin_id);
                                        $admin = $admin->get();
                                        $admin = $admin->getFirstRow();

                                        echo $admin->name;
                                        ?>
                                    </td>
                                <?php endif ?>
                                <td>
                                    <?php
                                    if ($sale->contact_id == NULL) {
                                    } else {
                                        $contact = $db->table("contacts");
                                        $contact->where("id", $sale->contact_id);
                                        $contact->where("type", 2);
                                        $contact = $contact->get();
                                        $contact = $contact->getFirstRow();

                                        if (!empty($contact->name)) {
                                            echo $contact->name . " | " . $contact->phone;
                                        } else {
                                            echo "-";
                                        }
                                    }
                                    ?>
                                </td>
                                <td class='text-center'>
                                    <span class="badge badge-<?= config("App")->orderStatusColor[$sale->status] ?>"><?= config("App")->orderStatuses[$sale->status] ?></span>
                                </td>
                                <td><?= $sale->tags ?></td>
                                <td class='text-center'>
                                    <a href="<?= base_url('warehouse/sales/' . $sale->id . '/manage') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
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
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>