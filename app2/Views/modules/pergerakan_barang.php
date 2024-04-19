0<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pergerakan Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports_'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Data Pergerakan Barang</li>

<?= $this->endSection(); ?>
<?= $this->section("page_content") ?>

<!--<div class='text-center'>
    <b>
        <h2>
            Pergerakan Barang
            <br>
            <small>Per Tanggal : <?= date("d-m-Y", strtotime($tanggalawal)) ?> s/d <?= date("d-m-Y", strtotime($tanggalakhir)) ?></small>
        </h2>
    </b>
    </div><br> -->
    
<form action="<?= base_url('report/export/pergerakan_barang') ?>" method="POST" id="myForm" style="display: none;">
    <input type="hidden" name="data" id="data">
</form>

<div class="card">
<div class="card-header bg-primary">
    <h5 class="card-title">Data Pergerakan Barang</h5>
    <!--<div class="float-right">-->
    <!--    <a href="<?= base_url('export_data?tanggalawal='.$tanggalawal.'&tanggalakhir='.$tanggalakhir) ?>" class="btn btn-success"><i class="fas fa-print"></i> Export Data</a>-->
    <!--</div>-->
    <div class="float-right">
        <button class="btn btn-sm btn-success" id="exportBtn"><i class="fas fa-print"></i> Export</button>
    </div>
</div>
<div class="card-body">
<table class="table table-md table-striped" id="stok">
    
        <tbody id="tableBody">
            <?php 
                $currentProductName = "";
                $totalQuantity = 0;
            ?>

        
            <?php foreach ($products as $product): ?>
                <?php if ($currentProductName != $product->product_name): ?>
                    <?php $currentProductName = $product->product_name; ?>
                    <tr>
                        <td colspan="5"><strong><?php echo $currentProductName; ?></strong></td>
                        <?php
                            $query = $db->table('product_stocks');
                            $query->selectSum("quantity");
                            $query->where('product_id', $product->products_id);
                            $query = $query->get();
                            $query = $query->getFirstRow();
                            $totalQuantity = $query->quantity;
                        ?>
                        <td>Jumlah : <?= $query->quantity ?></td>
                        <?php $Stok = $totalQuantity; ?>
                    </tr>
 
                <?php endif; ?>
                <tr>
                    <td>
                        <?php if (!empty($product->purchase_delivery_number)): ?>
                            <?= $product->purchase_date ?>
                        <?php elseif (!empty($product->sales_order_number)): ?>
                            <?= $product->sales_date ?>
                        <?php elseif (!empty($product->tf_number)) : ?>
                            <?= $product->tf_date ?>
                        <?php elseif (!empty($product->product_return_id)) : ?>
                            <?= $product->retur_date ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($product->purchase_delivery_number)): ?>
                            Pembelian
                        <?php elseif (!empty($product->sales_order_number)): ?>
                            Penjualan
                        <?php elseif (!empty($product->tf_number)): ?>
                            Transfer Barang
                        <?php elseif (!empty($product->return_number)) : ?>
                            Retur Barang
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($product->purchase_delivery_number)): ?>
                        <a href="<?= base_url('products/buys/manage'). '/'.$product->buys_id; ?>"><?php echo $product->purchase_delivery_number; ?></a>
                        <?php elseif (!empty($product->sales_order_number)): ?>
                            <a href="<?= base_url('sales/'.$product->sales_id.'/manage') ?>"><?php echo $product->sales_order_number;?></a>
                        <?php elseif (!empty($product->tf_number)): ?>
                           <?php echo $product->tf_number; ?>
                        <?php elseif (!empty($product->return_number)): ?>
                            <?php echo $product->return_number; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($product->purchase_delivery_number)): ?>
                             <?php echo $product->warehouse_name ?>
                        <?php elseif (!empty($product->sales_order_number)): ?>
                            <?php echo $product->warehouse_name ?>
                        <?php elseif (!empty($product->tf_number)): ?>
                            <?php echo $product->warehouse_name ?>
                        <?php elseif (!empty($product->return_number)) : ?>
                            <?php echo $product->warehouse_name ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($product->purchase_quantity)): ?>
                            +<?php echo $product->quantity; ?>
                        <?php elseif (!empty($product->sales_quantity)): ?>
                            <?php echo $product->quantity; ?>
                        <?php elseif (!empty($product->tf_quantity)): ?>
                            <?php echo $product->quantity; ?>
                        <?php elseif (!empty($product->return_number)) : ?>
                            <?php echo $product->quantity; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($product->purchase_quantity)): ?>
                            <?php $quantity = $product->purchase_quantity; ?>
                        <?php elseif (!empty($product->sales_quantity)): ?>
                            <?php $quantity = -$product->sales_quantity; ?>
                        <?php elseif (!empty($product->tf_quantity)): ?>
                            <?php $quantity = -$product->tf_quantity; ?>
                        <?php elseif (!empty($product->return_number)) : ?>
                            <?php $quantity = -$product->retur_qty; ?>
                        <?php else: ?>
                            <?php $quantity = 0; ?>
                        <?php endif; ?>
                        
                        <?= $totalQuantity += $quantity; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<br>

<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>
<script src="<?= base_url('/public/adminlte')?>/plugins/datatables/jquery.dataTables.min.js"> </script>
<script src="<?= base_url('/public/adminlte')?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

&nbsp;
&nbsp;
  
<script>
    $(document).ready(function() {
        // $('#stok').DataTable( {
        //     dom: 'Bfrtip',
        //     "bPaginate": false,
        //     "bInfo": false,
          
        //     buttons: [
        //         'csv', 'excel', 'print'
        //     ]
        // });
        
        $('#exportBtn').on("click", function() {
            const rows = Array.from(document.querySelectorAll("#tableBody tr"));
            const data = rows.map(row => Array.from(row.querySelectorAll("td")).map(cell => cell.innerText));
            
            $('#data').val(JSON.stringify(data));
            $('#myForm').submit();
        });
        
    });
</script>
<?= $this->endSection() ?>
