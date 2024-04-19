<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <a href="<?= base_url('sales/retail/sales/add') ?>" class='btn btn-primary float-right'>
            <i class='fa fa-plus'></i>
            Tambah
        </a>
        <div class="clearfix"></div>
        <div class="card mt-2">
            <div class="card-header bg-info">
                Data Penjualan
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Tgl. Transaksi</th>
                            <th class='text-center'>Tgl. Jatuh Tempo</th>
                            <th class='text-center'>Pelanggan</th>
                            <th class='text-center'>Status</th>
                            <th class='text-center'>Tags</th>
                            <th class='text-center'>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($sales as $sale){
                            ?>
                            <tr>
                                <td class='text-center'><?= $sale->number ?></td>
                                <td class='text-right'><?= date("d-m-Y",strtotime($sale->transaction_date)) ?></td>
                                <td class='text-right'><?= date("d-m-Y",strtotime($sale->expired_date)) ?></td>
                                <td>
                                    <?php
                                    $contact = $db->table("contacts");
                                    $contact->where("id",$sale->contact_id);
                                    $contact->where("type",2);
                                    $contact = $contact->get();
                                    $contact = $contact->getFirstRow();

                                    echo $contact->name." | ".$contact->phone;
                                    ?>
                                </td>
                                <td class='text-center'>
                                <span class="badge badge-<?= config("App")->orderStatusColor[$sale->status] ?>"><?= config("App")->orderStatuses[$sale->status] ?></span>
                                </td>
                                <td><?= $sale->tags ?></td>
                                <td class='text-center'>
                                    <a href="<?= base_url('sales/retail/sales/'.$sale->id.'/manage') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
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