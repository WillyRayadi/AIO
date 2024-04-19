<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kode Referral
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Kode Referral</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
  <i class="fas fa-plus-square"></i>
</button>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class='table table-striped table-bordered'>
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Sales</th>
                            <th>Kode Referal</th>
                            <th>Member Terdaftar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php $no = 0; foreach($users as $user): $no++; ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $user["sales"] ?></td>
                                <td><?= $user["refCode"] ?></td>
                                <td><?= $user["member"] ?></td>
                                <td><a class="btn btn-success btn-sm"><i class="fas fa-cog"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kode Referral</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="<?= base_url('sales/referral-code/add') ?>" method="POST">
           <div class="form-group">
               <label>Pilih Sales</label>
               <select class="form-control" name="sales_id" id="sales" required>
                 <option selected value="">Pilih</option>
               </select>
           </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
     </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: '<?= base_url("ajax/get/all/sales") ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var data = response;
                
                data.sales.forEach(function(item) {
                     var option = "<option value="+ item.id +">" + item.name + "</option>";
                     $('#sales').append(option);
                });
            }
        })
    });
</script>

<?= $this->endSection() ?>