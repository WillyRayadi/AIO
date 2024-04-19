<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Persediaan Tersedia
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Persediaan Tersedia</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Barang</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id='datatables-default'>
                        <thead>
                            <tr>
                                <th class='text-center'>No</th>
                                <!-- <th class='text-center'>Kode Barang</th> -->
                                <th class='text-center'>Nama Barang</th>
                                <th class='text-center'>Kategori</th>
                                <th class='text-center'>Stok Tersedia</th>
                                <!-- <th class='text-center'>Dipesan (SO)</th> -->
                                <th class='text-center'>Service</th>
                            </tr>                            
                        </thead>
                        <tbody>
                            <?php
                            $productNo = 0;
                            foreach($products as $product){
                                $productNo++;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $productNo ?></td>
                                  
                                    <td><a style="color: bg-primary;" href="<?= base_url('products/'.$product->id.'/manage') ?>"> <?= $product->name ?></a></td>
                                    <td>
                                        <?php
                                        $category = $db->table('categories');
                                        $category->where("id",$product->category_id);
                                        $category = $category->get();
                                        $category = $category->getFirstRow();

                                        echo $category->name;
                                        ?>
                                    </td>
                                    <?php
                                    $thisSumStocksAvailable = 0;
                                    foreach($warehouses as $warehouse){
                                        ?>
                                    <!-- <td class='text-right'> -->
                                        <?php
                                        $location = $db->table("product_stocks");
                                        $location->selectSum("quantity");
                                        $location->where("warehouse_id",$warehouse->id);
                                        $location->where("product_id",$product->id);
                                        // $location->where("sale_item_id",NULL);
                                        // $location->where("buy_item_id",NULL);
                                        $location = $location->get();
                                        $location = $location->getFirstRow();

                                        if($location->quantity == NULL){
                                            // echo "0 ".$product->unit;
                                            $thisSumStocksAvailable += 0;
                                        }else{
                                            $thisSumStocksAvailable += $location->quantity;
                                            // echo $location->quantity." ".$product->unit;
                                        }
                                        ?>
                                    <!-- </td> -->
                                        <?php
                                    }
                                    ?>
                                    <td class='text-right'><?= $thisSumStocksAvailable." ".$product->unit ?></td>
                                    <?php
                                    $thisSumStocksUnavailable = 0;
                                    ?>
                                    <!-- <td class='text-right'>
                                        <?php
                                        $sale = $db->table("sale_items");
                              			$sale->join("sales","sale_items.sale_id=sales.id","left");
                                        $sale->selectSum("sale_items.quantity");
                                        $sale->where("sale_items.product_id",$product->id);
                              			$sale->where("sales.status < 5");
                                        $sale = $sale->get();
                                        $sale = $sale->getFirstRow();

                                        if($sale->quantity == NULL){
                                            echo "0 ".$product->unit;
                                            $thisSumStocksUnavailable += 0;
                                        }else{
                                            echo $sale->quantity." ".$product->unit;
                                            $thisSumStocksUnavailable += $sale->quantity;
                                        }
                                        ?>
                                    </td> -->
                                   
                                    <td class='text-right'>
                                        <?php
                                        $repair = $db->table("product_repairs");
                                        $repair->selectSum("quantity");
                                        $repair->where("product_id",$product->id);
                                        $repair = $repair->get();
                                        $repair = $repair->getFirstRow();

                                        if($repair->quantity == NULL){
                                            echo "0 ".$product->unit;
                                            $thisSumStocksUnavailable += 0;
                                        }else{
                                            $thisSumStocksUnavailable += $repair->quantity;
                                            echo $repair->quantity." ".$product->unit;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div><!-- /.container-fluid -->


<?= $this->endSection() ?>