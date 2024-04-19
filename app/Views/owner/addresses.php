<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Alamat IP
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Target Penjualan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>


<!-- Modal Add -->
<form method="post" action="<?= base_url("owner/addresses/save") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Alamat IP</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type='hidden' name='id' id="editID">
                    <div class="form-group">
                        <label>Nama Pemilik IP</label>
                        <input type='text' name='name' id="editName" placeholder='Nama Pemilik IP' required class='form-control'>
                    </div>
                    <div class="form-group">
                        <label>Alamat IP</label>
                        <input type='text' name='ip' id="editIP" placeholder='Alamat IP' required class='form-control'>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class='fa fa-save'></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Edit -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="IPContainer" style='font-size:25px'></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <form action="<?= base_url("owner/addresses/add") ?>" method="post">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Tambah Alamat IP</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Pemilik IP</label>
                    <input type='text' name='name' placeholder='Nama Pemilik IP' required class='form-control'>
                </div>
                <div class="form-group">
                    <label>Alamat IP</label>
                    <input type='text' name='ip' placeholder='Alamat IP' required class='form-control'>
                </div>
            </div>
            <div class="card-footer">
                <button type='submit' class='btn btn-info'>
                    <i class='fa fa-plus'></i>
                    Tambah Alamat IP
                </button>
            </div>
        </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info">
                Data Alamat IP
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>Nama Pemilik IP</th>
                            <th class='text-center'>Alamat IP</th>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($addresses as $address) : ?>
                        <tr>
                            <td><?= $address->name ?></td>
                            <td class='text-center'><?= $address->address ?></td>
                            <td class='text-center'>
                                <a href="javascript:void(0)" onclick="edit('<?= $address->id ?>','<?= $address->name ?>','<?= $address->address ?>')" class='btn btn-success btn-sm' data-toggle="modal" data-target="#modalEdit" title="Edit">
                                    <i class='fa fa-edit'></i>
                                </a>
                                <a href="<?= base_url('owner/addresses/'.$address->id.'/delete') ?>" class='btn btn-sm btn-danger' title="Hapus" onclick="return confirm('Yakin hapus alamat IP <?= $address->address ?>?')">
                                    <i class='fa fa-trash'></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<script type="text/javascript">
function edit(id,name,address){
    $("#editID").val(id)
    $("#editName").val(name)
    $("#editIP").val(address)
}
</script>

<!-- Axios -->
<script type="text/javascript" src="<?= base_url('public/axios.min.js') ?>"></script>

<script type="text/javascript">
    async function getIpClient() {
        try {
            const response = await axios.get('https://api.ipify.org?format=json');
            // console.log(response);
            $("#IPContainer").html("IP Kamu : "+response.data.ip)
        }catch (error) {
            // console.error(error);
        }
    }
    getIpClient();
</script>

<?= $this->endSection() ?>