    <?= $this->extend("general/template") ?>

    <?= $this->section("page_title") ?>
    <h1>Redeem Member</h1>
    <?= $this->endSection() ?>

    <?= $this->section("page_breadcrumb") ?>
    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
    <li class="breadcrumb-item active">Redeem Member</li>
    <?= $this->endSection() ?>

    <?= $this->section('page_content') ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addModalLabel">Redeem Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('add/customer/redeem')?>">
                    <div class="form-group">
                        <label for="label-nomer">Nomer Redeem</label>
                        <input type="text" class="form-control" name="redeem_number" value="RDM00000" readonly="true">
                    </div>

                    <div class="form-group">
                        <label for="label-product">Nama Pelanggan</label>
                        <select name="customers" class="select2bs4" id='customerSelect'>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($user as $data) { ?>
                                <option value="<?= $data->contact_id ?>"><?= $data->contact_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class='label-dates'>Tanggal Redeem</label>
                        <input type="date" class='form-control' name='dates'>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class='btn btn-success'>
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header bg-info">
            <h5 class="card-title">Point User</h5>
            <a href="#" data-toggle="modal" data-target="#addModal" class="float-right btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered" id="datatables-default">
                <thead>
                    <tr>
                        <th class="text-center">Number</th>
                        <th class="text-center">Nama Pelanggan</th>
                        <th class="text-center">Tanggal Redeem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($value as $datas){ ?>
                    <tr>
                        <td class="text-center"><a href="<?= base_url('user/redeem/manage/'.$datas->id) ?>"><?= $datas->number ?></a></td>
                        <td class="text-center"><?= $datas->contact_name ?></td>
                        <td class="text-center"><?= $datas->dates ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?= $this->endSection()?>