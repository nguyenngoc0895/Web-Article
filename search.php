<?php
include "controller/articleController.php";

$articleController = new articleController();

if(isset($_POST['keyword'])){
    $key = $_POST['keyword'];
    $results = $articleController->searching($key);
    // print_r($results);die;

    ?>
    <div class="panel panel-default">
        <b>Tìm được: <?=count($results)?> kết quả</b>
        <?php
        foreach($results as $result){
            ?>
            <div class="row-item row">
                <div class="col-md-3">

                    <a href="detail.php?id=<?=$result->id?>&category=<?=$result->TenKhongDau?>">
                        <br>
                        <img width="200px" height="200px" class="img-responsive" src="public/image/tintuc/<?=$result->Hinh?>" alt="">
                    </a>
                </div>

                <div class="col-md-9">
                    <h3><?=$result->TieuDe?></h3>
                    <p><?=$result->TomTat?></p>
                    <a class="btn btn-primary" href="detail.php?id=<?=$result->id?>&category=<?=$result->TenKhongDau?>">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
                <div class="break"></div>
            </div>
            <?php
        }   
        ?>
        
    </div>
    <?php
    
}
?>