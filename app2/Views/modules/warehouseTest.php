<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Penjualan (SO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Penjualan (SO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>


<form method="post" action="<?= base_url('sales/manifest/print') ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pilih Data Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class='table table-striped table-bordered' id="penjualan">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tgl. Transaksi</th>
                            <th>Sales</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th>Tags</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<?= $this->endSection() ?>