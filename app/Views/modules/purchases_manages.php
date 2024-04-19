<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
<h1>Purchases Order Manages</h1>
<?= $this->endSection() ?>


<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Purchase Order</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<form action="<?= base_url('purchase/order/add/item')?>" method="post"> 
	<div class="modal fade" id="modalBuyItemAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
		<input type="hidden" name="purchase_order_id" value=''> 
		<div class="modal-dialog"> 
			<div class="modal-content"> 
				<div class="modal-header bg-primary"> 
					<h5 class="modal-title" id="exampleModalLabel">Tambah Barang </h5> 
					<button type="button" class="close btn btn-danger text-white" data-dismiss="modal" aria-label="Close"> 
						<span aria-hidden="true">&times;</span> 
					</button> 
				</div> 

				<div class="modal-body">
					<!-- <div class="mb-1">
                        <label>Stok Tersedia</label>
                        <label class="float-right" style="margin-right: 190px;">Stok PO</label>
                        <div class='row'>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type='number' readonly id="recordedQty" value='0' name='qty_recorded' class='form-control' required placeholder="Jumlah Di Dalam Gudang">
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-md-12">
                                   <input type='number' name='quantity' class='form-control' placeholder="Kuantitas Barang" required>
                                </div>
                            </div> 
                        </div>                            
                    </div> -->

                    <div class="mb-1">
                    	<label class="form-label">Jumlah PO</label>
                    	<input type="number" name="quantity" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                	<button type='submit' class='btn btn-primary'>
                		<i class='fa fa-plus'></i> Tambah
                	</button>
                </div>
            </div>
        </div>
    </div>
</form> 

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header bg-info">
				<h1 class="card-title">Data PO</h1>
			</div>
			<div class="card-body">
				<label><b>Nomer PO</b></label>
				<p><?= $headers->purchase_number ?></p>

				<label><b>Nama Admin</b></label>
				<p><?= $headers->admin_name ?></p>

				<label><b>Nama Supplier</b></label>
				<p><?= $headers->contact_name ?></p>

				<label><b>Tanggal Pemesanan</b></label>
				<p><?= $headers->purchase_date ?></p>
			</div>
		</div>		
	</div>

	<div class="col-md-8">
		<div class="card">
			<div class="card-header bg-info">
				<h5 class="card-title">Barang Purchase Order</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
						<input type="hidden" name="id" value="<?= $headers->id ?>">
						<table class="table table-md table-bordered">
							<thead>
								<tr>
									<th class="text-center">SKU Produk</th>
									<th class="text-center">Nama Produk</th>
									<th class="text-center">Jumlah PO</th>
									<th class="text-center">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($purchases as $item): ?>
									<form action="<?= base_url('approve/purchases/product/'.$item->item_id)?>" method="POST">
									<tr>
										<td class="text-center"><?= $item->product_sku ?></td>
										<td class="text-center"><?= $item->product_name ?></td>
										<td class="text-center"><?= $item->purchase_quantity ?></td>
										<td class="text-center">
											<input type="hidden" name="date" value="<?= $headers->purchase_date ?>">
											<input type="hidden" name="product_id" value="<?= $item->product_id ?>">
											<input type="hidden" name="quantity" value="<?= $item->purchase_quantity ?>">
											<button type="submit" class="btn btn-success btn-sm" name="approve_button">
												<i class="fas fa-check"></i>
											</button>
										</td>
									</tr>
									</form>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endsection() ?>