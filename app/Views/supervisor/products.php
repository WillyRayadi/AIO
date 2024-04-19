<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Data Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Data Barang</li>
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
                            <th class='text-center' rowspan='2'>No</th>
                            <th class='text-center' rowspan='2'>Kode Barang</th>
                            <th class='text-center' rowspan='2'>Nama Barang</th>
                            <th class='text-center'rowspan='2'>Kategori</th>
                            <th class='text-center'colspan='2'>Persediaan Berdasar Gudang</th>
                            <th class='text-center'rowspan='2'>Display</th>
                            <th class='text-center'rowspan='2'>Service</th>
                            <th class='text-center'rowspan='2'>Return</th>
                            <th class='text-center'rowspan='2'>Dipesan (SO)</th>
                        </tr>
                        <tr>
                            <?php
                            foreach($warehouses as $warehouse){
                                ?>
                            <th class='text-center'><?= $warehouse->name ?></th>
                                <?php
                            }
                            ?>
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
                                <td class='text-center'>
                                    <?php
                                    $code = $db->table('codes');
                                    $code->where("id",$product->code_id);
                                    $code = $code->get();
                                    $code = $code->getFirstRow();

                                    echo $code->name;
                                    ?>
                                </td>
                                <td><?= $product->name ?></td>
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
                                foreach($warehouses as $warehouse){
                                    ?>
                                <td class='text-right'>
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
                                        echo "0 ".$product->unit;
                                    }else{
                                        echo $location->quantity." ".$product->unit;
                                    }
                                    ?>
                                </td>
                                    <?php
                                }
                                ?>                                
                                <td class='text-right'>
                                    <?php
                                    $display = $db->table("product_displays");
                                    $display->selectSum("quantity");
                                    $display->where("product_id",$product->id);
                                    $display = $display->get();
                                    $display = $display->getFirstRow();

                                    if($display->quantity == NULL){
                                        echo "0 ".$product->unit;
                                    }else{
                                        echo $display->quantity." ".$product->unit;
                                    }
                                    ?>
                                </td>
                                <td class='text-right'>
                                    <?php
                                    $repair = $db->table("product_repairs");
                                    $repair->selectSum("quantity");
                                    $repair->where("product_id",$product->id);
                                    $repair = $repair->get();
                                    $repair = $repair->getFirstRow();

                                    if($repair->quantity == NULL){
                                        echo "0 ".$product->unit;
                                    }else{
                                        echo $repair->quantity." ".$product->unit;
                                    }
                                    ?>
                                </td>
                                <td class='text-right'>
                                    <?php
                                    $return = $db->table("product_returns");
                                    $return->selectSum("quantity");
                                    $return->where("product_id",$product->id);
                                    $return = $return->get();
                                    $return = $return->getFirstRow();

                                    if($return->quantity == NULL){
                                        echo "0 ".$product->unit;
                                    }else{
                                        echo $return->quantity." ".$product->unit;
                                    }
                                    ?>
                                </td>
                                <td class='text-right'>
                                    <?php
                                    $sale = $db->table("sale_items");
                                    $sale->selectSum("quantity");
                                    $sale->where("product_id",$product->id);
                                    $sale = $sale->get();
                                    $sale = $sale->getFirstRow();

                                    if($sale->quantity == NULL){
                                        echo "0 ".$product->unit;
                                    }else{
                                        echo $sale->quantity." ".$product->unit;
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

<?= $this->section("page_script") ?>
<?= $this->endSection() ?>