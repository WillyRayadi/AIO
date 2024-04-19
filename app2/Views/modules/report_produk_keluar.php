<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Laporan Barang Keluar
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report Products</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?> 
<div class="card"> 
    <div class="card-header bg-info"> 
        <h5 class="card-title">Report Data Barang Keluar</h5>
    </div> 

    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('product/export_product_barang_keluar') ?>" method="get" target="_blank">
                <div class="row">

                    <div class="col form-group">
                        <label class="font-weight-bold">Nama Brand</label>
                        <select name='productname' class="select2bs4" id="productSelect" style="width: 100%;">
                             <option>Pilih Barang</option>
                             <option value="AQUA">AQUA</option>
                             <option value="ARISTON">ARISTON</option>
                             <option value="AVARO">AVARO</option>
                             <option value="BERVIN">BERVIN</option>
                             <option value="CHANGHONG">CHANGHONG</option>
                             <option value="COOCAA">COOCAA</option>
                             <option value="COSMOS">COSMOS</option>
                             <option value="DAIKIN">DAIKIN</option>
                             <option value="GEA">GEA</option>
                             <option value="GMC">GMC</option>
                             <option value="GREE">GREE</option>
                             <option value="HISENSE">HISENSE</option>
                             <option value="KANGAROO">KANGAROO</option>
                             <option value="LG">LG</option>
                             <option value="MIDEA">MIDEA</option>
                             <option value="MITO">MITO</option>
                             <option value="MITSUBISHI">MITSUBISHI</option>
                             <option value="MIYAKO">MIYAKO</option>
                             <option value="MODENA">MODENA</option>
                             <option value="PANASONIC">PANASONIC</option>
                             <option value="POLYTRON">POLYTRON</option>
                             <option value="RINNAI">RINNAI</option>
                             <option value="RSA">RSA</option>
                             <option value="SAMSUNG">SAMSUNG</option>
                             <option value="SHARP">SHARP</option>
                             <option value="STEKO">STEKO</option>
                             <option value="TCL">TCL</option>
                             <option value="ZEBRA">ZEBRA</option>
                        </select>
                    </div>
                    


                    <div class="col form-group">
                        <label class="font-weight-bold">Mulai Tanggal</label>
                        <input class="form-control" name="tanggalawal" type="date" required></input>
                    </div>

                    <div class="col form-group">
                        <label class="font-weight-bold font-weight-italic">Sampai Tanggal</label>
                        <input class="form-control" name="tanggalakhir" type="date" required=""></input>
                    </div>

                    <button class="col btn btn-success" style="width: 50%; height: 50%; margin-top: 32px;">
                        <i class="fas fa-file"></i>&nbsp; Cetak Laporan
                    </button> 
                </div>
            </form>
        </div>
    </div>

 <br>
</div>

<script>
        $(document).ready(function() {
            $('#datatables-default').DataTable( {
                dom: 'Bfrtip',
                "bPaginate": false,
                "bInfo": false,
            } );
        } );
</script>

<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>