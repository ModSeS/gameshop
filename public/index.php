<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <title>GameShop</title>
    <script src="jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <link rel="stylesheet" href="adaptive.css">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .sign {
            border-radius: 10px;
            float: right;
            border: 1px solid #333;
            padding: 7px;
            margin: 10px 0 5px 5px;
            background: #f0f0f0;
        }
        .d24 {
            margin-top: 50px;
            margin-bottom: 40px;
            background: black;
            height: 3px;
            width: 30%;
            position: relative;
            left: 35%;
        }
        .sign figcaption {
            margin: 0 auto 5px;
        }
        .textop{
            text-shadow: 2px 2px black;
            opacity: 0;
        }
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .container {
            position: relative;
            text-align: center;
            color: white;
        }
        .superimg{
            height: 288px;
            width: 512px;
            cursor: pointer;
        }
        .superimg:hover .textop {
            transition: opacity .4s linear;
            opacity: 100;
        }
        .superimg:hover img{
            transition: border .2s linear;
            border: 4px solid #00a8e1 ;
        }
    </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<body id="ind" background="images/fon.jpg">
<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"> <label style="cursor: pointer" >GameShop</label><img style="margin-left: 5px" class="rounded-circle" src="logo.png" width="40" height="40"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Главная страница</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="games.php">Каталог товаров</a>
                    </li>
                    <?php include "db_connect.php";
                    if(!empty($_SESSION["user_auth"])) {
                        $Type = GetTypeUser($_SESSION["user_auth"]);
                        if ($Type == "Admin"){ echo '<li class="nav-item">
                        <a class="nav-link" href="admin.php">Админ панель</a>
                    </li>';}
                        else if ($Type == "User"){
                            echo '<li class="nav-item">
                        <a class="nav-link" href="cart.php">Корзина</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favorites.php">Закладки</a>
                    </li>';
                        }}
                    ?>
                </ul>
            </div>
        </div>
        <?php
        if (empty($_SESSION["user_auth"])) {
            echo '<div  class="align-content-center" >
            <form action="reg.php"><button type = "submit" class="btn btn-info">Войти</button> </form></div>';
        } else{
            echo '<div style="margin-right: 80px" class="align-content-center" >
            <div class="dropdown">
  <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo GetName($_SESSION["user_auth"]);
            echo ' </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   <form  action="profile.php">  <button style="cursor: pointer" type="submit"  class="dropdown-item" >Профиль</button></form>
    <form  action="messages.php">  <button style="cursor: pointer" type="submit"  class="dropdown-item" >Сообщения</button></form>
     <form  method="post">  <button style="cursor: pointer" type="submit"  name="exit" class="dropdown-item" >Выйти</button></form>
  </div>
</div></div>';}
        if(isset($_POST["exit"])){
            unset($_SESSION["user_auth"]);
            unset($_SESSION["cart"]);
            echo "<script>window.location.href='index.php'</script>";
        }
        ?>
    </nav>
</header>
<main id="main" class="d-flex justify-content-center">
    <div id="carouselExampleIndicators"  class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block" width="1390" height="600" src="images/item1.jpg" alt="Первый слайд">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Лучшие игры по скидкам</h3>
                </div>
            </div>
            <div class="carousel-item ">
                <img class="d-block" width="1390" height="600"  src="images/item2.png" alt="Второй слайд">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Крупнейшая база игр</h3>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block" width="1390" height="600"  src="images/item3.png" alt="Третий слайд">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Поддержка всех основных платформ</h3>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</main>
<div class="d24 text-center"></div>
<h3 class="text-center" style="margin-top: 5px; " >Достоинства нашего магазина</h3>
<div class="d-flex justify-content-center">
    <div  class="text-center sign">
        <img class="rounded" style="" width="50" height="50" src="images/safe.png" alt="..." >
        <p class="text-center"><i>Безопасные сделки</i></p>
    </div>
    <div class="text-center sign">
        <img class="rounded" style="" width="50" height="50" src="images/gold.png" alt="..." >
        <p class="text-center"><i>Низкие цены</i></p>
    </div>
    <div class="text-center sign">
        <img class="rounded" style="" width="50" height="50" src="images/admin.png" alt="..." >
        <p class="text-center"><i>Отзывчивая модерация</i></p>
    </div>
</div>
<div class="d24 text-center"></div>
<h3 class="text-center" style="margin-top: 5px; " >Популярные товары</h3>
<div id="picts" class="text-center" style="display: flex">
    <div class="container superimg">
        <img class="rounded" width="512" height="288" src="images/atomic.jpg" alt="..." >
        <div class="textop centered" ><h3>Atomic Heart</h3></div>
    </div>
    <div class="container superimg">
        <img class="rounded"  width="512" height="288" src="images/dead.jpg" alt="..." >
        <div class="textop centered" ><h3>Dead Space Remake</h3></div>
    </div>
    <div class="container superimg">
        <img class="rounded" width="512" height="288" src="images/resident.jpg" alt="..." >
        <div class="textop centered" ><h3>Resident Evil 4</h3></div>
    </div>
</div>
<button id="catalogBtn" type="button" onclick="window.location.href='games.php'" style="margin: 10px; margin-top: 30px; margin-bottom: 50px; left: 33%; position: absolute; width: 35%" class="btn btn-outline-dark text-center">Открыть каталог товаров</button>
<div style=" margin-top: 100px" class="d24 text-center"></div>
<div id="bord" style="height: 1px"></div>
<footer id="footer" class="footer card-footer" style=" display: flex; flex: 0 0 auto;  height: 150px; margin-top: 1%;  width: 100%; background-color: #e9ecef">
    <div class="float-right align-top" style="margin: 1%; display: flex; flex: 1 0 auto; flex-direction: row">
        <img src="images/vk.png" style=" margin: 5px; width: 50px; height: 50px; ">
        <img src="images/inst.png" style="margin: 5px; width: 50px; height: 50px; ">
        <img src="images/telegram.png" style=" margin: 5px; width: 50px; height: 50px; ">

    </div>
    <text class="float-left" style="position: absolute; margin-left: 30px; margin-top: 100px">Copyright &copy; <?php echo date("Y"); ?>. All rights reserved.</text>
    <div class="left_foot float-left" style="display:block;" >
        <label  class="navbar-brand" >GameShop</label>
        <img class="rounded-circle" style=" width: 80px; height: 80px;" src="logo.png">

        <p style="margin-left: 1%"><a href="">Политика конфиденциальности</a></p>
    </div>
</footer>
</body>
</html>