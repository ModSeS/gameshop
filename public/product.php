<?php session_start(); include "db_connect.php"; if (empty($_GET['id']) or (GetInfo($_GET['id'])['Status'] != 'checked' and GetTypeUser($_SESSION['user_auth'])!='Admin')) echo "<script>window.location.href='games.php'</script>"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>GameShop</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




    <link rel="shortcut icon" href="logo.png" type="image/png">
    <style>


        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .rectangle {
            margin-top: 5px;
            margin-left: 2px;

            background-color: rgba(180, 232, 247, 1);
            height: 60px;
            border: 1px solid gray;
        }
        .product {
            background-color:rgba(0, 200, 225, 0.5);
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .product h1 {
            font-size: 2em;
            margin-top: 0;
        }

        .product p {
            margin: 10px 0;
        }

        .product .platform {
            font-weight: bold;
        }

        .product .type {
            font-style: italic;
        }

        .product .price {
            font-weight: bold;
        }

        .product .description {
            line-height: 1.5;
        }

        .add-to-cart {
            background-color: #00a8e1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .add-to-cart:hover {
            background-color: #0c5460;
        }
        </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<body background="images/fon.jpg">
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

                        <a class="nav-link" href="index.php">Главная страница</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="games.php">Каталог товаров</a>
                    </li>

                    <?php
                   if (GetInfo($_GET['id'])==null) echo "<script>window.location.href='games.php'</script>";
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
<div style="height: 50px"></div>
<main>
    <?php
    if (!empty($_SESSION['user_auth']))
    $ord = GetOrders($_SESSION['user_auth'], false);
    else $ord=null;
    $info=GetInfo($_GET['id']);
    $mas = GetReviews($_GET['id']);
    $b = false;
    echo '<div style="margin-top: 20px; position: relative" id="error"></div>';
    echo '<div class="product">
        <h1>'.$info['GameName'].'</h1>
        <p class="platform">Платформа: '.$info['Platform'].'</p>
        <p class="type">Тип товара: '.$info['TypeGame'].'</p>
        <p class="price">Цена: '.$info['Price'].' рублей</p>
        <p class="description">Описание: '.$info['Description'].'</p>';
      echo  '<p style="font-size: 14px; color: darkgreen" class="description"><b>В наличии: '.getCount($_GET['id']).' шт.</b></p>';

echo  '<form class="d-inline" method="post">';
    if (!empty($_SESSION['user_auth']))
        if (GetTypeUser($_SESSION['user_auth']) == "User") {
            echo '<button style="text-decoration: none; height: 50px" name="cart" value="' . $_GET['id'] . '" class="add-to-cart">Добавить в корзину</button></form>
       <form class="d-inline" method="post"> <button style="height: 48px; " name="addFav" class="add-to-cart">Добавить в закладки</button><button style="height: 48px; margin-left: 5px " name="BuyNow" class="add-to-cart">Купить</button></form>';
        }

        echo '</div>

    <div class="product">
        <p class="price">Продавец: ' . GetName($info['SellerID']) . '</p>
        <p class="type">Рейтинг: ' . AverageRev($info['SellerID']) . '⭐</p>';
    if (!empty($_SESSION['user_auth']) and GetTypeUser($_SESSION['user_auth'])=='User') echo '<form method="post" class="d-inline"><button name="send_toSeller" class="add-to-cart">Написать продавцу</button></form>';
        if($ord!=null)
        for ($i = 0; $i < count($ord); $i++)
            if ($ord[$i]['idGames'] == $_GET['id']) $b=true; if($b==true) echo '<form style="display: inline" class="col" method="post"><button name="Write_review" style="margin-left: 5px" class="add-to-cart">Написать отзыв</button></form>';

        echo '</div>';

  echo ' <div class="float-left product" style="display: block; width: 100%">
      <h3 >Отзывы</h3>';
    if(isset($_POST['Write_review'])){
        echo '<form style=" display: inline" class="col-md-6" method="post"><div class="form-row">
            <div class="col">
                <input name="text" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Текст отзыва">
                
            </div>
 <div class="col">
 <label for="inputPassword4">Ваша оценка</label>
        <select  style="margin-bottom: 10px"  name="rating" id="inputState" class="col-md-5">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            
        </select>
        </div>

        </div>
           
        <button  name="send_review" type="submit" class="btn btn-primary">Отправить</button> </form>
        ';
    }
    echo '</form>';
for($i=0; $i<count($mas); $i++){
   echo  '<div style="padding-left: 3px; margin-top: 10px" class="rectangle"><b>'.GetName($mas[$i]['idUser']).'</b> ('.$mas[$i]['rating'].'/10) '; if(!empty($_SESSION['user_auth']) and GetTypeUser($_SESSION['user_auth'])=="Admin") echo '<form method="post" style="all: unset"><button  name="delRev" value="'.$mas[$i]['reviewID'].'" style="all: unset; cursor: pointer; float: right; margin-right: 5px" href="#"><img width="20" height="20" src="images/delete.png"></button></form>'; echo ' <br> '.$mas[$i]['reviewText'].' <p style="float: right; margin-right: 5px ">Дата: '.$mas[$i]['dataRev'].'</p> </div>';
}
if(isset($_POST['send_review']) and !empty($_POST['text'])){
AddReview($_SESSION['user_auth'], $_POST['text'], $_GET['id'], $_POST['rating']);
echo '<script>window.location.href="product.php?id='.$_GET['id'].'"</script>';
}
    if(isset($_POST['cart'])){
        if(empty($_SESSION['user_auth'])) echo '<script>location.href="reg.php"</script>';
        else{
            if($_SESSION['cart']=="") $_SESSION['cart']=$_POST['cart'];
            else $_SESSION['cart']=$_SESSION['cart'].','. $_POST['cart'];
        }
        unset($_GET['cart']);
    }
    if(isset($_POST['BuyNow'])){
        if(GetBalance($_SESSION['user_auth'])>$info['Price']) {
            BuyProduct($_GET['id'], $_SESSION['user_auth'], $info['SellerID'], $info['Price']);
            echo '<script>window.location.href="profile.php"</script>';
        }
        else{

            $code = "<div style=' margin-left: 160px; margin-bottom: 10px; display: flex; position: relative;' class='fixed-top '><img  style='width: 50px; height: 50px; ' src='images/error.png'><h4 style='margin-top: 10px; margin-left: 5px' >На балансе не хватает средств</h4></div>";
            echo '<script>document.getElementById("error").innerHTML = "'.$code.'"; </script>';
        }
    }

    if(isset($_POST['addFav'])){
       if(AddFavorite($_SESSION['user_auth'], $_GET['id'])=='err'){
           $code = "<div style=' margin-left: 100px; margin-bottom: 10px; display: flex; position: relative;' class='fixed-top '><img  style='width: 50px; height: 50px; ' src='images/error.png'><h4 style='margin-top: 10px; margin-left: 5px' >Данный товар уже имеется в закладках</h4></div>";
           echo '<script>document.getElementById("error").innerHTML = "'.$code.'"; </script>';
       }
       unset($_POST['addFav']);
    }

    if(isset($_POST['send_toSeller'])){
        echo '<script>location.href="messages.php?mess='.$info['SellerID'].'"</script>';
    }
    if(isset($_POST['delRev'])){
DelReview($_POST['delRev']);
unset($_POST['delRev']);
        echo '<meta http-equiv="refresh" content="0">';
    }
?>

    </div>
</main>


</body>
</html>