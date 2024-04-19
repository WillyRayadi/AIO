<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Role Akun
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active"> Pengelolaan Role</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<div class="col-lg">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $roles->role_name ?></h3>
        </div>
        <div class="card-body table-responsive">
            <form action="<?= base_url('role/fitur/add/'.$roles->id)?>" method="POST">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Fitur</th>
                            <th class="text-center">Buat</th>
                            <th class="text-center">Lihat</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Purchase Delivery</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_purchase_checkbox" <?php echo ($roles->purchase_order_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_purchase_checkbox" <?php echo ($roles->purchase_order_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_purchase_checkbox" <?php echo ($roles->purchase_order_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_purchase_checkbox" <?php echo ($roles->purchase_order_hapus !== null) ? 'checked' : ''; ?>>
                            </td>

                        </tr>

                        <tr>
                            <td>Sales Order</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_sales_checkbox" <?php echo ($roles->sales_order_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_sales_checkbox" <?php echo ($roles->sales_order_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_sales_checkbox" <?php echo ($roles->sales_order_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_sales_checkbox" <?php echo ($roles->sales_order_hapus !== null) ? 'checked' : ''; ?>>
                            </td>

                        </tr>

                        <tr>
                            <td>Delivery Order</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_delivery_checkbox" <?php echo ($roles->delivery_order_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_delivery_checkbox" <?php echo ($roles->delivery_order_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_delivery_checkbox" <?php echo ($roles->delivery_order_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_delivery_checkbox" <?php echo ($roles->delivery_order_hapus !== null) ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td>Transfer Product</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_transfer_checkbox" <?php echo ($roles->transfer_warehouse_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_transfer_checkbox" <?php echo ($roles->transfer_warehouse_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_transfer_checkbox" <?php echo ($roles->transfer_warehouse_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_transfer_checkbox" <?php echo ($roles->transfer_warehouse_hapus !== null) ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td>Retur Product</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_retur_checkbox" <?php echo ($roles->retur_product_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_retur_checkbox" <?php echo ($roles->retur_product_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_retur_checkbox" <?php echo ($roles->retur_product_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_retur_checkbox" <?php echo ($roles->retur_product_hapus !== null) ? 'checked' : ''; ?>>
                            </td>
                        </tr> 

                        <tr>
                            <td>Stokopname</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_stokopname_checkbox" <?php echo ($roles->stokopname_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_stokopname_checkbox" <?php echo ($roles->stokopname_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_stokopname_checkbox" <?php echo ($roles->stokopname_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_stokopname_checkbox" <?php echo ($roles->stokopname_hapus !== null) ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td>Products</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_products_checkbox" <?php echo ($roles->products_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_products_checkbox" <?php echo ($roles->products_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_products_checkbox" <?php echo ($roles->products_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_products_checkbox" <?php echo ($roles->products_hapus !== null) ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td>Persetujuan</td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="buat_agreement_checkbox" <?php echo ($roles->agreement_buat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="lihat_agreement_checkbox" <?php echo ($roles->agreement_lihat !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="edit_agreement_checkbox" <?php echo ($roles->agreement_edit !== null) ? 'checked' : ''; ?>>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" value="1" name="hapus_agreement_checkbox" <?php echo ($roles->agreement_hapus !== null) ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                    </tbody>
                    <tfoot> 
                        <tr>
                            <td colspan="5" class="text-right">
                                <button type="submit" class="btn btn-sm btn-danger">Batal</button>
                                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div><br>

<?= $this->endSection() ?>