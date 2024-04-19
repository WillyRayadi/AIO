<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Retur
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kelola Data</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<form action="<?= base_url('return/pemasok/add/items')?>" method="post"> 
	<input type="hidden" name="retur_id" value="<?= $good_retur->pemasok_id ?>"> 
	<div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-col-md-7">
			<div class="modal-content">
				<div class="modal-header bg-blue">
					<h5 class="modal-title" id="staticBackdropLabel">Tambah</h5>
					<button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<label>Item / Barang</label>

						<select name='product_id' class='form-control select2bs4-modalAdd' required id="productSelect">
							<option>-- Pilih Data Barang --</option>
							<?php
							foreach($goods as $item){
								echo"<option value='".$item->product_id."'>".$item->product_name."</option>";
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label>Tanggal</label>
						<input type="date" name="dates" class="form-control" value="<?= $good_retur->date ?>">
					</div>

					<div class="form-group">
						<label>Lokasi</label>
						<select class="form-control" name="warehouse_id" id="warehouseSelect">
							<option value="7">Servis Center Cirebon</option>
							<option value="10">Servis Center Tasik</option>
						</select>
					</div>

					<div class="mb-1">
						<label>Stok Tersedia</label>
						<label class="float-right" style="margin-right: 115px;">Jumlah Diretur</label>
						<div class="row">
							<div class="form-group col-md-6">
								<input type="number" readonly id="recordedQty" value="0" class="form-control" required placeholder="Jumlah Di Dalam Gudang">
							</div>
							<div class="form-group col-md-6">
								<input type="number" name="quantity" class="form-control" placeholder="Kuantitas Barang" required>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">
						<i class='fa fa-plus'></i>
						Tambah
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- END MODAL ADD TRANSFERS ITEMS --> 

<div class="row">
	<div class='col-md-4'>
		<div class='card'>
			<div class="card-body"> 
				<h4>
					Data Retur Pemasok
					<a href="<?= base_url('return/pemasok/print/'.$good_retur->pemasok_id) ?>" class="btn btn-sm btn-success float-right"><i class="fas fa-print"></i></a> 
				</h4>  

				<hr>

				<b>Nomer Retur</b>
				<br>
				<?= $good_retur->retur_number ?>
				<br>

				<b>Nama Admin</b>
				<br>
				<?= $good_retur->admin_name ?>
				<br>

				<b>Nama Pelanggan</b>
				<br>
				<p>
					<?= $good_retur->contact_name ?>
				</p> 

				<b>Lokasi</b>
				<br>
				<p><?= $good_retur->warehouse_name ?></p>

				<b>Keterangan</b> 
				<p>
					<?= $good_retur->keterangan ?>
				</p>
				<br>  

			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">                                                           
			<div class="card-body">
				<h4> 
					Daftar Barang
					<button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalAdd"> 
						<i class='fa fa-plus'></i> 
					</button> 

				</h4> 
				<hr> 
				<div class="table-responsive"> 
					<table class="table table-striped table-bordered table-hover"> 
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Nama Barang</th>
								<th class="text-center">Kuantitas</th>
								<th class="text-center">Opsi</th>
							</tr> 
						</thead> 
						<tbody>
							<?php 
							$no = 0;
							foreach ($retur_item as $value) 
							{
							$no++; 
							?>
								<tr>
									<td class="text-center"><?= $no ?></td>
									<td class="text-center"><?= $value->product_name ?></td>
									<td class="text-center"><?= $value->quantity ?></td>
									<td class="text-center">
										<a href="<?= base_url('return/pemasok/delete/'.$good_retur->pemasok_id.'/items/'.$value->return_item_id) ?>" onclick="return confirm('Kamu yakin ingin menghapus data <?= $value->product_name ?>?')" class="btn btn-danger text-white btn-sm">
											<i class='fa fa-trash'></i>
										</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table> 
					<!-- End table data -->
					
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header bg-info">
				<h5 class="card-title">Berkas Retur Pemasok</h5>
			</div>
			<div class="card-header p-0 pt-1 border-bottom-1">
				<ul class="nav nav-tabs" id="deliver-tabs" role="tablist">
					<?php $f = 0; ?>
					<?php foreach($retur_item as $item) : ?>
						<?php $f++; ?>
						<li class="nav-item">
							<a class="nav-link <?= ($f == 1) ? "active" : "" ?>" id="retur-tabs-<?= $f ?>" data-toggle="pill" href="#retur-tabs-<?= $f ?>-content" role="tab">
								Ke-<?= $f ?>
							</a>
						</li>
					<?php endforeach ?> 
			</div>

			<div class="card-body">
				<div class="tab-content" id="retur-tabs-content">
					<?php $f = 0; ?>
					<?php foreach ($retur_item as $item): ?>
						<?php $f++; ?>
						<div class="tab-pane fade <?= ($f == 1) ? "show active" : "" ?>" id="retur-tabs-<?= $f ?>-content" role="tabpanel">
							<?php if ($item->retur_files != NULL): ?>
								<a href="<?= base_url('public/return_pemasok/' . $item->retur_files) ?>" target="_blank" class='btn btn-success'>
									<i class='fa fa-file'></i> Lihat Berkas
								</a>
								<?php else: ?>
									<!-- Tindakan yang akan diambil jika $item->retur_files adalah NULL -->
									<form action="<?= base_url('return/pemasok/insert_file') ?>" method="POST" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?= $item->return_item_id ?>">
										<div class="form-group">
											<label for="file">
												Silahkan upload gambar
											</label>
											<div class="form-group">
												<input type="file" name="file" id="file" class="form-control" accept=".png, .jpg, .jpeg, .gif, .pdf">
											</div>

											<button type="submit" class="btn btn-sm btn-success">
												<i class="fas fa-upload"></i> Upload Berkas
											</button>
										</div>

									</form>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<script type="text/javascript">
$("#productSelect").change(function(){
    $.ajax({
        url: "<?= base_url('products/stocks/add/ajax/qty_recorded') ?>",
        type: "post",
        data: {
            product     : $("#productSelect").val(),
            warehouse   : $("#warehouseSelect").val(),
        },

        success: function(html) {
            // console.log(html);
            html = parseInt(html)
            $("#recordedQty").val(html)
            $("#realQty").val("0")
        }

    })
})

$("#warehouseSelect").change(function(){
    $.ajax({
        url: "<?= base_url('products/stocks/add/ajax/qty_recorded') ?>",
        type: "post",
        data: {
            product     : $("#productSelect").val(),
            warehouse   : $("#warehouseSelect").val(),
        },
        success: function(html) {
            // console.log(html);
            html = parseInt(html)
            $("#recordedQty").val(html)
            $("#realQty").val("0")
        }
    })
})

</script>

<?= $this->endSection() ?>