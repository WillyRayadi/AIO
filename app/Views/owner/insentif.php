<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Insentif Karyawan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Insentif Karyawan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>



<div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i> Tambah</button>
        <div class="card mt-3">
            <div class="card-header bg-info">
                <h5 class="card-title">Insentif Karyawan</h5>
            </div>
            <div class="card-body table-responsive">
               <table class="table table-striped table-bordered" id="datatables-default7">
                   <thead>
                       <tr>
                           <th>No</th>
                           <th>Insentif</th>
                           <th>Keterangan</th>
                           <th>Aksi</th>
                       </tr>
                   </thead>
                   <tbody>
                    <?php  $no = 0;  foreach ($insentif as $key => $value):   $no++; ?>
                       <tr>
                         <td><?= $no; ?></td>
                         <td><?= $value->nama ?> (<?= $value->code ?>)</td>
                         <td><?= $value->keterangan ?></td>
                         <td><a href="<?= base_url('owner/insentif/'.$value->id.'/manage') ?>" class="btn btn-info col-sm-auto"><i class="fas fa-edit"></i></a>
                            <button type="submit" class="btn btn-danger col-sm-auto" data-toggle="modal" data-target="#delete-<?= $value->id ?>"><i class="fas fa-trash"></i></button>
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

<form action="<?= base_url("owner/insentif/add") ?>" method="POST">
  <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
  <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama</label>
            <select name="role" class="form-control">
              <?php 
                for ($i=2; $i <= 5 ; $i++) { 
                  echo"<option value='".$i."'>".config("App")->roles[$i]."</option>";
                }
               ?>
            </select>
          </div>
          <div class="form-group">
            <label for="name">Rumus Harga</label>
            <select name="price_id" class="form-control">
              <?php foreach ($rumus as $key => $value): ?>
                <option value="<?= $value->id ?>|<?= $value->code ?>"><?= $value->code ?></option>
              <?php endforeach ?>
              <!--<option value="custom">Custom Incentive</option>-->
            </select>

            <!--<div id="customIncentiveContainer" style="display: none; padding-top: 20px;">-->
            <!--  <label for="customIncentive">Custom Incentive</label>-->
            <!--  <input type="text" name="custom_incentive" class="form-control">-->
            <!--</div>-->
          </div>
          <div class="form-group">
            <label for="address">Keterangan</label>
            <textarea class="form-control <?= $validation->getError('keterangan') ? 'is-invalid' : '' ?>" name="keterangan" id="address" rows="3" placeholder="Keterangan" required><?= old('keterangan') ?></textarea>
            <div class="invalid-feedback">
              <?= $validation->getError('keterangan') ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Konfirmasi</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
        </div>
      </div>
    </div>
  </div>
</form>

<?php foreach ($insentif as $key => $value): ?>
  <div class="modal fade" id="delete-<?= $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Data?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer">
          <form action="<?= base_url("owner/insentif/".$value->id."/delete") ?>">
            <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> Konfirmasi</button>
            <button type="button" class="btn btn-info" data-dismiss="modal">Batalkan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>

<?php if (session()->getFlashdata('Welcome')) : ?>
<div class='alert alert-success alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>&times;</button>
    <?= session()->getFlashdata("Welcome"); ?>
</div>
<?php endif ?>


<?php if (session()->getFlashdata('delete')): ?>
<script>
    $(document).ready(function() {
    $('#deleteModal').modal('show');
  });
</script>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle"><?= session()->getFlashdata('delete') ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif ?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var selectElement = document.querySelector("select[name='price_id']");
    var customIncentiveContainer = document.getElementById("customIncentiveContainer");

    selectElement.addEventListener("change", function() {
      if (selectElement.value === "custom") {
        customIncentiveContainer.style.display = "block";
      } else {
        customIncentiveContainer.style.display = "none";
      }
    });
  });
</script>


<?= $this->endSection() ?>