<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item active">Dashboard</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>


<?php  
$thisMonth = date("n");
$lastMonth = $thisMonth - 1;

if($thisMonth > 1){
    $lastYear = date("Y");
    $lastMonth = $lastMonth;
}else{
    $lastYear = date("Y") - 1;
    $lastMonth = 12;
}

$saleMe = $db->table("sales");
$saleMe->where("admin_id",$_SESSION['login_id']);
if(date("j") > 20){
    $saleMe->where("transaction_date >=",date("Y-".$thisMonth."-01"));
    $saleMe->where("transaction_date <=",date("Y-".$thisMonth."-31"));
}else{
    $saleMe->where("transaction_date >=",date("Y-".$thisMonth."-01"));
    $saleMe->where("transaction_date <=",date("Y-".$thisMonth."-31"));
}
$saleMe->where("status >=",5);
$saleMe->orderBy("id","desc");
$saleMe = $saleMe->get();
$saleMe = $saleMe->getResultObject();

$myAchievement = 0;
foreach($saleMe as $sale){
    $items = $db->table("sale_items");
    $items->where("sale_id",$sale->id);
    $items = $items->get();
    $items = $items->getResultObject();

    foreach($items as $item){
        $myAchievement += ($item->quantity * $item->price);
    }
}
?>

<?php
$admins = $db->table("administrators");
$admins->where("role",config("Login")->loginRole);
$admins->where("active !=",0);
$admins = $admins->get();
$admins = $admins->getResultObject();

foreach($admins as $admin){
    $saleThey = $db->table("sales");
    $saleThey->where("admin_id",$admin->id);
    if(date("j") > 20){
        $saleThey->where("transaction_date >=",date("Y-".$thisMonth."-01"));
        $saleThey->where("transaction_date <=",date("Y-".$thisMonth."-31"));
    }else{
        $saleThey->where("transaction_date >=",date("Y-".$thisMonth."-01"));
        $saleThey->where("transaction_date <=",date("Y-".$thisMonth."-31"));
    }
    $saleThey->where("status >=",6);
    $saleThey->orderBy("id","desc");
    $saleThey = $saleThey->get();
    $saleThey = $saleThey->getResultObject();
    
    $theirAchievement = 0;
    $bons = 0;

    foreach($saleThey as $sale){
        $items = $db->table("sale_items as a");
        $items->where("sale_id",$sale->id);
        $items = $items->get();
        $items = $items->getResultObject();
    
        foreach($items as $item){
            $theirAchievement += ($item->quantity * $item->price);
            $bons += ($item->quantity * $item->bonus_sales);
        }
    }

    $scores[] = array("name"=>$admin->name,"score"=>$theirAchievement,"bonus"=>$bons);
}

$scoreColumns = array_column($scores, 'score');
array_multisort($scoreColumns, SORT_DESC, $scores);
?>

<div class="row">        
    <div class="col-md-5">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Rp. <?= number_format($myAchievement,0,",",".") ?></h3>
                <p>
                    Penjualan (SO) Bulan Ini (<?= config("App")->months[date("n")] ?> <?= date("Y") ?>)
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-money-bill-wave"></i>
            </div>
            <a href="javascript:void(0)" class="small-box-footer">
                &nbsp; <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Leaderboard Bulan Ini (<?= config("App")->months[date("n")] ?> <?= date("Y") ?>)</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Nama</th>
                            <th class='text-center'>Omset</th>
                            <th class='text-center'>Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $scoreNo = 0;
                        foreach($scores as $score){
                            $scoreNo++;
                            ?>
                            <tr>
                                <td class='text-center'><?= $scoreNo ?></td>
                                <td><?= $score['name'] ?></td>
                                <td class='text-right'>Rp. <?= number_format($score['score'],0,",",".") ?></td>
                                <td>Rp. <?= number_format($score['bonus'],0,",",".") ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
 
<?= $this->endSection() ?>