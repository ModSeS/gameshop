<?php session_start(); if(empty($_GET['platform'])) $_GET['platform']=null;  if(empty($_GET['typegame'])) $_GET['typegame']=null;  if(empty($_GET['sort'])) $_GET['sort']=null; if(empty($_GET['sortRat'])) $_GET['sortRat']=null; ?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

    <title>GameShop - Каталог товаров</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="logo.png" type="image/png">
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
                        <a class="nav-link active" href="games.php">Каталог товаров</a>
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
<div style="height: 50px"></div>
<main style="margin-top: 10px" class="d-flex justify-content-center">
    <div class="container shadow min-vh-100 py-4">
        <div >
            <div >
                <div >
                    <div class="u-form u-form-1 flex-column">

                        <?php if (!empty($_SESSION["user_auth"])){ $Type = GetTypeUser($_SESSION["user_auth"]);
                        if($Type=="Seller") echo '
                      <form  method="post">  <button  style="cursor: pointer; margin: 5px; margin-top: 25px" type="submit"  name="addGame" class="btn-dark" >Добавить товар</button></form>';}
                        if(isset($_POST['addGame'])){
echo '<form  method="POST" class="w-50 m-auto d-flex flex-column justify-content-center">
        <h3 class="text-center">Подача заявки</h3>

        <div class="form-row">
            <div class="col">
                <label>Название товара</label>
                <input name="nameGame" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Название">
            </div>
        <div class="col">
                <label>Стоимость</label>
                <input name="price" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Цена">
            </div>
        </div>

        <label>Ключ или данные аккаунта (каждый ключ/аккаунт на новой строке)</label>
                <textarea name="keyGame" style="margin-bottom: 10px" type="text" class="form-control" placeholder="login: user; pass: 1234
ABC-DEF-GHI-JKL"></textarea>
                <label>Описание товара</label>
                <textarea value="" name="descriptionGame" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Описание"></textarea>
      

        <div class="form-row">
        <div class="col">
            <label for="inputPassword4">Тип продукта</label>
        <select   name="typeGame" id="inputState">
            <option value="Ключ">Ключ</option>
            <option value="Аккаунт">Аккаунт</option>
        </select>
        </div>
        <div class="col">
        <label for="inputPassword4">Платформа</label>
        <select  style="margin-bottom: 10px"  name="platformGame" id="inputState" >
            <option value="PC">PC</option>
            <option value="PS">PS</option>
            <option value="XBOX">XBOX</option>
            <option value="IOS">IOS</option>
            <option value="Android">Android</option>
        </select>
        
        </div>
        
        </div>
       
       
        <button type="submit" name="send_req" class="btn btn-primary">Отправить заявку</button>
    </form>';
                        }
                        if(isset($_POST['send_req'])){
                            if(!empty($_POST['nameGame']) and !empty($_POST['price']) and !empty($_POST['platformGame']) and !empty($_POST['typeGame']) and !empty($_POST['keyGame'])){
                                if(is_numeric($_POST['price'])){
                                AddGame($_POST['nameGame'],$_POST['price'], $_SESSION['user_auth'], $_POST['platformGame'], $_POST['descriptionGame'], $_POST['typeGame'], $_POST['keyGame']);
                                   echo '<h4>Заявка отправлена!</h4>';
                                    echo "<script>window.location.href = 'profile.php';</script>";
                                }
                                else echo '<div class="text-center error" ><img style="width: 50px; height: 50px" src="images/error.png"><h4>Введите числовое значение цены!</h4></div>';
                            }
                            else echo '<div class="text-center error" ><img style="width: 50px; height: 50px" src="images/error.png"><h4>Введите все поля!</h4></div>';
//                            echo '<meta http-equiv="refresh" content="0">';
                        }
                        ?>
                        <?php
                        echo ' 
                        <div id="formcheck" style="margin-top: 30px" class="flex-column" xmlns="http://www.w3.org/1999/html">

                                <div class="row">

                                    <div class="col">
                                     <form method="get">   <input name="search" type="text" class="form-control" placeholder="Название игры"></form>
                                    </div>
                                    
                                    <div class="dropdown show">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink platform" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                           Платформа
                                        </a>
   <div  class="dropdown-menu" aria-labelledby="dropdownMenuLink">
   <a  href="?platform=&typegame=' .$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer" ><input type="hidden"     name="platform"  >Платформа</a>
                                            <a  href="?platform=PC&typegame=' .$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer" ><input type="hidden"   value="PC"  name="platform"  >PC</a>
                                            <a href="?platform=PS&typegame'.$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="PS"  name="platform"  >PS</a>
                                            <a href="?platform=XBOX&typegame'.$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="XBOX"  name="platform"  >XBOX</a>
                                            <a href="?platform=IOS&typegame'.$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="IOS"  name="platform"  >IOS</a>
                                            <a href="?platform=Android&typegame'.$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="Android"  name="platform"  >Android</a>
                                        </div>

                                    </div>
                                    <div style="margin-left: 5px" class="dropdown show">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink typegame" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Тип товара
                                        </a>

                                      <div  class="dropdown-menu" aria-labelledby="dropdownMenuLink">
<a href="?platform='.$_GET["platform"].'&typegame=&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"    name="typegame"  >Тип товара</a>
                                            <a href="?platform='.$_GET["platform"].'&typegame=Аккаунт&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="Аккаунт"  name="typegame"  >Аккаунт</a>
                                            <a href="?platform='.$_GET["platform"].'&typegame=Ключ&sort='.$_GET["sort"].'&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="Ключ"  name="typegame"  >Ключ</a>

                                        </div>
                                    </div>
                                    <div style="margin-left: 5px" class="dropdown show">
                                        <a  class="btn btn-secondary dropdown-toggle"  href="#" role="button" id="dropdownMenuLink sortRat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Рейтинг продавца
                                        </a>

                                        <div  class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a href="?platform='.$_GET["platform"].'&typegame='.$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat=" class="dropdown-item" style=" cursor: pointer"><input type="hidden"     name="sortRat"  >Рейтинг продавца</a>
                                            <a href="?platform='.$_GET["platform"].'&typegame='.$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat=desc" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="desc"  name="sortRat"  >Сначала высокий</a>
                                            <a href="?platform='.$_GET["platform"].'&typegame='.$_GET["typegame"].'&sort='.$_GET["sort"].'&sortRat=asc" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="asc"  name="sortRat"  >Сначала низкий</a>
                                        </div>
                                    </div>
                                    <div style="margin-left: 5px" class="dropdown show">
                                        <a class="btn btn-secondary dropdown-toggle"  href="#" role="button" id="dropdownMenuLink sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Цена
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                         <a href="?platform='.$_GET["platform"].'&typegame='.$_GET["typegame"].'&sort=&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"    name="sort"  >Цена</a>
                                            <a href="?platform='.$_GET["platform"].'&typegame='.$_GET["typegame"].'&sort=asc&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="asc"  name="sort"  >Сначала дешевле</a>
                                            <a  href="?platform='.$_GET["platform"].'&typegame='.$_GET["typegame"].'&sort=desc&sortRat='.$_GET["sortRat"].'" class="dropdown-item" style=" cursor: pointer"><input type="hidden"   value="desc"  name="sort"  >Сначала дороже</a>
                                        </div>
                                    </div>
                                    <form method="get">
                                    <button href="?platform=&typegame=&sort=asc&sortRat=" style="cursor: pointer; margin-left: 5px; height: 38px" type="submit" value="" class="btn-dark" >Сбросить фильтры</button></form>

                                </div>
                            </div>
                            ';
?>
                    </div>
                </div>
            </div>
        </div>
        <table style="margin-top: 10px" class="table">
            <thead>
            <tr>
                <th scope="col">Платформа</th>
                <th scope="col">Название</th>
                <th scope="col">Тип товара</th>
                <th scope="col">Продавец</th>
                <th scope="col">Цена</th>
                <th id="options" scope="col">Корзина/Закладки/Подробнее</th>
            </tr>
            </thead>
            <tbody>
            <?php


                $filter = null;
                $filter2 = null;
                $search = null;
                $sort = null;
$sort2 = null;
                if (!empty($_GET['platform'])){
                    $filter = $_GET['platform'];
                    echo '<script>document.getElementById("dropdownMenuLink platform").innerHTML="'.$filter.'";</script>';
                }
                else echo '<script>document.getElementById("dropdownMenuLink platform").innerHTML="Платформа";</script>';
                if (!empty($_GET['search']))
                    $search = $_GET['search'];
                if (!empty($_GET['sort'])){
                    $sort = $_GET['sort'];
                    switch ($sort){ case "desc": echo '<script>document.getElementById("dropdownMenuLink sort").innerHTML="Сначала дороже";</script>'; break; case "asc": echo '<script>document.getElementById("dropdownMenuLink sort").innerHTML="Сначала дешевле";</script>'; break;}

                }
                else echo '<script>document.getElementById("dropdownMenuLink sort").innerHTML="Цена";</script>';
                if (!empty($_GET['typegame'])){
                    $filter2 = $_GET['typegame'];
                    echo '<script>document.getElementById("dropdownMenuLink typegame").innerHTML="'.$filter2.'";</script>';
                }
                else echo '<script>document.getElementById("dropdownMenuLink typegame").innerHTML="Тип товара";</script>';
if (!empty($_GET['sortRat'])){
    $sort2 = $_GET['sortRat'];
   switch ($sort2){ case "desc": echo '<script>document.getElementById("dropdownMenuLink sortRat").innerHTML="Сначала высокий";</script>'; break; case "asc": echo '<script>document.getElementById("dropdownMenuLink sortRat").innerHTML="Сначала низкий";</script>'; break;}


}
else echo '<script>document.getElementById("dropdownMenuLink sortRat").innerHTML="Рейтинг продавца";</script>';

                $mas = GetGames($search, $filter, $filter2, $sort, $sort2, 'checked');
                for ($i = 0; $i < count($mas); $i++) {
                    echo '
            <tr>
                <th scope="row">' . $mas[$i]["Platform"] . '</th>
                <td>' . $mas[$i]["GameName"] . '</td>
                <td>' . $mas[$i]["TypeGame"] . '</td>
                <td>' . GetName($mas[$i]["SellerID"]) . ' ('.AverageRev($mas[$i]["SellerID"]).'⭐)</td>
                <td>' . $mas[$i]["Price"] . ' руб.</td>
                <td style="display: inline-flex; margin-left: 20px" >';
                    if (!empty($_SESSION['user_auth']) and GetTypeUser($_SESSION['user_auth']) == 'User') echo '<form method="post"><button name="cart" style="all: unset; cursor: pointer"  value=" ' . $mas[$i]["idGames"] . '"><img width="50" height="50" src="images/basket.png"></button></form><form method="post"><button name="favorite" style="all: unset; cursor: pointer" value="' . $mas[$i]["idGames"] . '"><img width="50" height="50" src="images/star.png"></button></form>'; else echo '<script>document.getElementById("options").innerHTML="Подробнее";</script>';
                    echo '<a style="margin-top: 5px" href="product.php?id=' . $mas[$i]["idGames"] . '"><img width="40" height="40" src="images/info.png"></a></td>
            </tr>';
                }
if(isset($_POST['cart'])){
    if(empty($_SESSION['user_auth'])) echo '<script>location.href="reg.php"</script>';
    else{
        if($_SESSION['cart']=="") $_SESSION['cart']=$_POST['cart'];
        else $_SESSION['cart']=$_SESSION['cart'].','. $_POST['cart'];
    }
    unset($_GET['cart']);
}
if(isset($_POST['favorite'])){
if(AddFavorite($_SESSION['user_auth'], $_POST['favorite'])=="err")
  echo '<div class="text-center error" ><h4 style="color: #b21f2d; margin: 5px">Ошибка! Данный товар уже имеется в закладках</h4></div>';
    unset($_POST['favorite']);
}

            ?>
            </tbody>
        </table>
</main>

<div style="height: 200px"></div>
<footer id="footer" class="footer fixed-bottom card-footer" style=" display: flex; flex: 0 0 auto;  height: 150px; margin-top: 1%;  width: 100%; background-color: #e9ecef">
    <div class="float-right align-top" style="margin: 1%; display: flex; flex: 1 0 auto; flex-direction: row">
        <img src="images/vk.png" style=" margin: 5px; width: 50px; height: 50px; ">
        <img src="images/inst.png" style="margin: 5px; width: 50px; height: 50px; ">
        <img src="images/telegram.png" style=" margin: 5px; width: 50px; height: 50px; ">
    </div>
    <p class="float-left fixed-bottom" style="position: absolute; margin-left: 45px">Copyright &copy; <?php echo date("Y"); ?>. All rights reserved.</p>
    <div class="left_foot float-left" style="display:block;" >
        <label  class="navbar-brand" >GameShop</label>
        <img class="rounded-circle" style=" width: 80px; height: 80px;" src="logo.png">
        <p style="margin-left: 1%"><a href="">Политика конфиденциальности</a></p>
    </div>
</footer>
</body>
</html>