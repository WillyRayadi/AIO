<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Voucher
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Voucher</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<style>
    .img-preview {
        width: 15rem;
    }
</style>

<div class="row justify-content-between">
    <div class="col-sm">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <form action="<?= base_url("products/voucher/save") ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $voucher->id ?>">
                    <div class="form-group">
                        <label>Pilih Produk</label>
                        <select name="product_id" id="productSelect" class="form-control select2bs4">
                            <?php foreach ($products as $product) : ?>
                                <option value="<?= $product->id ?>" <?= ($voucher->product_id == $product->id) ? 'selected' : '' ?>>
                                    <?= $product->name ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nilai Voucher</label>
                        <input type="number" name="voucher_value" class="form-control" value="<?= $voucher->voucher_value ?>" placeholder="Nilai Voucher" required>
                    </div>
                    <div class="form-group">
                        <label>Point Yang Dibutuhkan</label>
                        <input type="number" name="required_points" value="<?= $voucher->required_points ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Masa Berlaku Voucher</label>
                        <input type="date" name="validity_period" value="<?= $voucher->validity_period ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" id="" cols="10" rows="10" class="form-control"><?= $voucher->description ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto Produk</label>
                        <div class="custom-file">
                            <input type="file" name="image" onchange="loadFileName()" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile"><?= $voucher->image ? $voucher->image : "Pilih Gambar"; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-info"><i class="fas fa-file-alt"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card card-outline card-primary" style="width: 15rem;">
            <img class="card-img-top img-preview" src="<?= base_url("public/image/$voucher->image") ?>">
            <div class="card-body">
                <h5 class="card-title ">Preview</h5>
            </div>
        </div>
    </div>
</div>


<script>
    function loadFileName() {
        const fileInput = document.querySelector(".custom-file-input");
        const fileLabel = document.querySelector(".custom-file-label");
        const imgPreview = document.querySelector(".img-preview");

        fileLabel.textContent = fileInput.files[0].name;

        const fileImage = new FileReader();
        fileImage.readAsDataURL(fileInput.files[0]);

        fileImage.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>


<?= $this->endSection() ?>