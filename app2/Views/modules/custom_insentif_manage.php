<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Insentif
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kelola Insentif</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<form method="post" action="<?= base_url("set/custom/insentif") ?>">
<input type="hidden" class="form-control" id="item_id" name="item_id" value="<?= $dataItem->item_id ?>">
<div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title" id="staticBackdropLabel">Custom Insentif</h5>
                <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="label-form">Insentif</label>
                    <select name="insentif" id="insentif" class="form-control select2bs4" required>
                        
                    </select>
                </div> 
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
    </div>
</form>

<div class="row">
    <div class='col-md-3'>
        <div class='card'>
            <div class="card-header bg-info">
                <h5>Data Insentif</h5>
            </div>
            <div class="card-body">  
                <b>Nomer SO</b>
                <br>
                <?= $sales->sale_number ?>
                <br>
                <br>

                <b>Nama Sales</b>
                <br>
                <?= $sales->admin_name ?>
                <br>
                <br>

                <b>Nama Pelanggan</b>
                <br>
                <?= $sales->admin_name ?>
                <br>
                <br>

                <b>Tanggal Transaksi</b>
                <br>
                <?= $sales->transaction_date ?>
                <br>
                <br>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-info">   
                <h5>
                    Data Barang Terjual
                </h5>    
            </div>  
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class='text-center'>Nama Barang</th>
                            <th class='text-center'>Harga Barang</th>
                            <th class='text-center'>Bonus Sales</th>
                            <th class='text-center'>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><?= $value->product_name ?></td>
                            <td class="text-center">
                                Rp. <?= number_format($value->price,0,",",".") ?>
                            </td>
                            <td class="text-center">
                                Rp. <?= number_format($value->bonus_sales,0,",",".") ?>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" data-items="<?= $value->item_id ?>" data-product="<?= $value->product_id ?>" data-productpriceid="<?= $value->product_price ?>" data-productprice="<?= $value->prices ?>" class="btn btn-sm btn-success editBtn">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<script>
    function getInsentif(string) {
        var parts = string.split(' - ');
        var rpPart = parts[1];
        return rpPart;
    }
    $(document).ready(function() {
        $('.editBtn').on("click", function() {
            
          $.ajax({
              url: "<?= base_url('ajax/get/insentif') ?>",
              type: "POST",
              dataType: 'json',
              data: {
                  user: <?= $sales->user_id ?>,
                  price_id: $(this).data('productpriceid'),
                  price: $(this).data('productprice')
              },
              success: function(response) {
                  console.log(response);
                  $('#insentif').html("");
                  
                  response.forEach(function(item) {
                     var option = $('<option>');
                     var insentif = getInsentif(item).replace('Rp.', '');
                         
                     option.val(insentif.replace('.', '')).text(item);
                     $('#insentif').append(option);
                  });
              }
          });
          
          $('#item_id').val("");
          $('#item_id').val($(this).data('items'));
          $('#modalAdd').modal('show');
        });
    })
</script>
<?= $this->endSection() ?>