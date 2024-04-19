<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Persetujuan Perubahan Status
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Item Penjualan (SO) Perlu Persetujuan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Item Penjualan (SO) Perlu Persetujuan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" width="100%" id="datatables-default">
                    <thead>
                        <tr>
                            <!-- <th class='text-center'>No</th> -->
                            <th class='text-center'>Nomer SO</th>
                            <th class='text-center'>Sales</th>
                            <th class='text-center'>Pelanggan</th>
                            <th class='text-center'>Alasan</th>
                            <!-- <th class='text-center'>Opsi</th>  -->
                        </tr> 
                    </thead> 
                    <tbody> 
                        <?php $itemNo = 0; ?> 
                        <?php foreach($alasan as $alas) : ?> 
                            <?php $itemNo++; ?> 
                            <tr> 
                                <td class='text-center'>
                                    <a href="<?= base_url('owner/perubahan/status/manage/'.$alas->id) ?>"><?= $alas->sale_number ?></a>
                                </td>

                                <td class="text-center"><?= $alas->admin_name ?></td>
                                <td class="text-center"><?= $alas->contact_name ?></td>
                                <td class="text-center"><?= $alas->alasan ?></td>
                                
                                <!--<?php
                                // $sale = $db->table('sales');
                                // $sale->where('sales.id',$alas->sale_id);
                                // $sale->orderBy('sales.id','desc');
                                // $sale = $sale->get();
                                // $sale = $sale->getFirstRow();
                                ?> -->
                            <!--     <td class="text-center">
                                   
                                    <a href="" onclick="return confirm('Yakin Kamu mau menyetujui.?')" class='btn btn-success btn-sm' title="Setujui">
                                        <i class='fa fa-check'></i>
                                    </a>
                                    
                                    <a href="" onclick="return confirm('Yakin kamu mau tidak menyetujui ini.?')" class='btn btn-danger btn-sm' title="Tidak Disetujui">
                                        <i class='fa fa-times'></i>
                                    </a>

                                </td> -->
                            </tr>
    
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer"></div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>