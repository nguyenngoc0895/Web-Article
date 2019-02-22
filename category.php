<?php
session_start();

include('controller/articleController.php');
$articleController = new ArticleController();
$articles = $articleController->category();
$category = $articles['menuArticle'];
$menu = $articles['menu'];
$title = $articles['title'];
$pagination = $articles['pagination'];
$alias = $articles['alias'];

// print_r($alias);
// die;
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Category</title>

    <!-- Bootstrap Core CSS -->
    <link href="public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="public/css/shop-homepage.css" rel="stylesheet">
    <link href="public/css/my.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"> Tin Tức</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Giới thiệu</a>
                    </li>
                    <li>
                        <a href="#">Liên hệ</a>
                    </li>
                </ul>

                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" id="serach" placeholder="Search">
                    </div>
                    <button type="button" id="btnSearch" class="btn btn-default">Search</button>
                </form>

                <ul class="nav navbar-nav pull-right">
                <?php
                if(isset($_SESSION['name'])){
                    // print_r($_SESSION['name']);die;
                ?>
                    <li>
                        <a>
                            <span class ="glyphicon glyphicon-user"></span>
                            <?=$_SESSION['name']?>
                        </a>
                    </li>

                    <li>
                        <a href="logout.php">Đăng xuất</a>
                    </li>
                <?php
                }else{
                    ?>
                    <li>
                        <a href="register.php">Đăng ký</a>
                    </li>
                    <li>
                        <a href="login.php">Đăng nhập</a>
                    </li>
                    <?php
                }
                ?>

                </ul>
            </div>


            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-3 ">
                <ul class="list-group" id="menu">
                    <li href="#" class="list-group-item menu1 active">
                        Menu
                    </li>

                    <?php
                    foreach($menu as $mn){
                        ?>
                        <li href="#" class="list-group-item menu1">
                            <?=$mn->Ten?>
                        </li>
                        <ul>
                            <?php
                            $loaitin = explode(',', $mn->LoaiTin);
                            // print_r($loaitin);
                            foreach($loaitin as $lt){
                                list($id, $ten, $tenkhongdau) = explode(':', $lt);
                                ?>
                                <li class="list-group-item">
                                    <a href="category.php?id=<?=$id?>"><?=$ten?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-9" id="dataSearch">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#337AB7; color:white;">
                        <h4><b><?=$title->Ten?></b></h4>
                    </div>
                    <?php
                    foreach($category as $cat){
                        ?>
                        <div class="row-item row">
                            <div class="col-md-3">

                                <a href="detail.php?id=<?=$cat->id?>&category=<?=$alias->TenKhongDau?>">
                                    <br>
                                    <img width="200px" height="200px" class="img-responsive" src="public/image/tintuc/<?=$cat->Hinh?>" alt="">
                                </a>
                            </div>

                            <div class="col-md-9">
                                <h3><?=$cat->TieuDe?></h3>
                                <p><?=$cat->TomTat?></p>
                                <a class="btn btn-primary" href="detail.php?id=<?=$cat->id?>&category=<?=$alias->TenKhongDau?>">View Project <span class="glyphicon glyphicon-chevron-right"></span></a>
                            </div>
                            <div class="break"></div>
                        </div>
                        <?php
                    }   
                    ?>
                    <!-- Pagination -->
                    <div class="row text-center">
                        <div class="col-lg-12">
                            <ul class="pagination">
                                <?=$pagination?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div> 

        </div>

    </div>
    <!-- end Page Content -->

    <!-- Footer -->
    <hr>
    <footer>
        <div class="row">
            <div class="col-md-12">
                <p>Copyright &copy; Your Website 2014</p>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
    <!-- jQuery -->
    <script src="public/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/my.js"></script>
    <script>
    $(document).ready(function(){
        $("#btnSearch").click(function(){
            // alert('test');
            var keyword = $('#serach').val();
            $.post("search.php", {keyword:keyword}, function(data){
                $('#dataSearch').html(data);
            })
        })
    })
    </script>
</body>

</html>
