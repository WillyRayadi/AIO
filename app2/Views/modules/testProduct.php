<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Data Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Data Barang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<style>
    .contacts {
        text-align: left !important;
    }
</style>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<?= $this->endSection() ?>