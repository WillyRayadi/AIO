<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
<h1>Purchase Order Manage</h1>
<?= $this->endSection() ?>


<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Barang Return</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<form action="<?= base_url('purchase/order/add/item')?>" method="post"> 
	<div class="modal fade" id="modalBuyItemAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
		<input type="hidden" name="purchase_order_id" value="<?= $good_purchase->id ?>"> 
		<div class="modal-dialog"> 
			<div class="modal-content"> 
				
				<div class="modal-header bg-primary"> 
					<h5 class="modal-title" id="exampleModalLabel">Tambah Barang </h5> 
					<button type="button" class="close btn btn-danger text-white" data-dismiss="modal" aria-label="Close"> 
						<span aria-hidden="true">&times;</span> 
					</button> 
				</div> 

				<div class="modal-body">
					<div class='mb-2'>
						<label class='form-label'>Barang</label>
						<select id="productSelect" class='form-control select2bs4' name="product_id" required>
							<?php
							foreach($products as $product){    
								echo "<option value='".$product->product_id."'>".$product->product_name."</option>";
							}
							?>
						</select>
					</div>

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

                    <!-- <div class='mb-2'>
                        <label class='form-label'>Haraga</label>
                    </div> -->

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
				<a href="<?= base_url('purchase/order/export/'.$good_purchase->id) ?>" class="btn btn-sm btn-success float-right"><i class="fas fa-file-excel"></i> Export Data</a>
			</div>
			<div class="card-body">
				<b>Nomer Purchase Order</b>
				<p><?= $good_purchase->purchase_number ?></p>
				<b>Nama Supplier</b>
				<p><?= $good_purchase->contact_name ?></p>
				<b>Tanggal Purchase Order</b>
				<p><?= $good_purchase->purchase_date ?></p>
			</div>
		</div>		
	</div>

	<div class="col-md-8">
		<div class="card">
			<div class="card-header bg-info">
				<h5 class="card-title">Barang Purchase Order</h5>
				<a data-target="#modalBuyItemAdd" data-toggle="modal" class="float-right btn btn-sm btn-success"><i class="fas fa-plus"></i> Tambah Data</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
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


							<?php foreach ($good_purchase_item as $item): ?>
								<tr>
									<td class="text-center"><?= $item->product_sku ?></td>
									<td class="text-center"><?= $item->product_name ?></td>
									<td class="text-center"><?= $item->product_quantity?></td>
									<td class="text-center"><a href="<?= base_url('purchase/order/'.$good_purchase->id.'/delete/item/'.$item->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus <?= $item->product_name ?>.?')"><i class="fas fa-trash"></i></a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endsection() ?>