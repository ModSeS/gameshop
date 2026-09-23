<?php session_start();
include "db_connect.php";
if(empty($_SESSION["user_auth"]) or GetTypeUser($_SESSION["user_auth"])!="User"){
    echo "<script>window.location.href='index.php'</script>";}?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>GameShop - Корзина</title>

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
                        <a class="nav-link" href="games.php">Каталог товаров</a>
                    </li>

                    <?php
                    if(!empty($_SESSION["user_auth"])) {
                        $Type = GetTypeUser($_SESSION["user_auth"]);
                        if ($Type == "Admin"){ echo '<li class="nav-item">
                        <a class="nav-link" href="admin.php">Админ панель</a>
                    </li>';}
                        else if ($Type == "User"){
                            echo '<li class="nav-item">
                        <a class="nav-link active" href="cart.php">Корзина</a>
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
<main style="margin-top: 25px" class="d-flex justify-content-center">

    <div class="container shadow min-vh-100 py-4">
        <div >
            <div >
                <div >
                    <div class="u-form u-form-1 flex-column">
                        <h4 class="text-center" style="margin-top: 10px">Товары в корзине</h4>  <form method="post"><button style="cursor: pointer" type="submit"  name="clear" class="btn-dark">Очистить</button><button style="cursor: pointer; margin-left: 5px" type="submit"  name="BuyAll" class="btn-dark">Купить всё</button><b style="margin-left: 5px" id="summa">Сумма: 0 руб.</b></form>
                        <table style="margin-top: 10px" class="table">
                            <thead>
                            <tr>
                                <th scope="col">Платформа</th>
                                <th scope="col">Название</th>
                                <th scope="col">Тип товара</th>
                                <th scope="col">Продавец</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Подробнее/Закладки/Купить/Удалить</th>

                            </tr>
                            </thead>
                            <tbody>
<?php
$summa=0;
$mas = array();
if(isset($_POST['clear'])){
    $_SESSION['cart']="";
    unset($_POST['clear']);
    echo '<script>location.href="cart.php"</script>';
}
if(!empty($_SESSION['cart'])){

$mas = explode(',',$_SESSION['cart']);
if(empty($mas[0])){
    $mas[0]=$_SESSION['cart'];
}
for($i=0; $i<count($mas); $i++){
    if(!empty($mas[$i])){
                   echo           '<tr>
                                <th scope="row">' . GetInfo($mas[$i])["Platform"] . '</th>
                                <td>' .GetInfo($mas[$i])["GameName"] . '</td>
                                <td>' .GetInfo($mas[$i])["TypeGame"] . '</td>
                                <td>' . GetName(GetInfo($mas[$i])["SellerID"]) . ' ('.AverageRev(GetInfo($mas[$i])["SellerID"]).'⭐)</td>
                                <td>' . GetInfo($mas[$i])["Price"] . ' руб.</td>
                              <td style="display: inline-flex; margin-left: 50px" ><a style="margin-top: 5px" href="product.php?id='.$mas[$i].'"><img width="40" height="40" src="images/info.png"></a><form method="post"><button name="favorite" style="all: unset; cursor: pointer" value="'.$mas[$i].'"><img width="50" height="50" src="images/star.png"></button><button name="BuyNow" value="'.$i.'" style="all: unset; cursor: pointer" ><img width="45" height="45" src="images/buy.png"></button><button name="delCart" value="'.$i.'" style="all: unset; cursor: pointer; margin-left: 5px" ><img width="45" height="45" src="images/delete.png"></button></form></td>
                            </tr>';
  $summa += GetInfo($mas[$i])["Price"]; }}
    echo '<script>document.getElementById("summa").innerHTML="Сумма: '.$summa.' руб.";</script>';
}
if(isset($_POST['delCart'])){
    $_SESSION['cart']="";
    for($i=0; $i<count($mas); $i++){
        if ($i!=$_POST['delCart']){
            if($_SESSION['cart']=="") $_SESSION['cart']=$mas[$i];
            else $_SESSION['cart']=$_SESSION['cart'].','. $mas[$i];
        }
    }
    unset($_POST['delCart']);
    echo '<meta http-equiv="refresh" content="0">';
}
if(isset($_POST['BuyAll'])){
    if(GetBalance($_SESSION['user_auth'])>$summa) {
        for ($i = 0; $i < count($mas); $i++) {
            BuyProduct($mas[$i], $_SESSION['user_auth'], GetInfo($mas[$i])["SellerID"], GetInfo($mas[$i])["Price"]);

        }
        $_SESSION['cart']="";
        echo '<script>window.location.href="profile.php"</script>';
    }

    else  echo '<div class="text-center error" ><h4 style="color: #b21f2d; margin: 5px">Ошибка! На балансе не хватает средств</h4></div>';
unset($_POST['BuyAll']);
}
if(isset($_POST['BuyNow'])){
    if(GetBalance($_SESSION['user_auth'])>GetInfo($mas[$_POST['BuyNow']])['Price']) {
        BuyProduct($mas[$_POST['BuyNow']], $_SESSION['user_auth'], GetInfo($mas[$_POST['BuyNow']])['SellerID'], GetInfo($mas[$_POST['BuyNow']])['Price']);
        $_SESSION['cart']="";
        for($i=0; $i<count($mas); $i++){
            if ($i!=$_POST['BuyNow']){
                if($_SESSION['cart']=="") $_SESSION['cart']=$mas[$i];
                else $_SESSION['cart']=$_SESSION['cart'].','. $mas[$i];
            }
        }

        echo '<script>window.location.href="profile.php"</script>';
    }
    else{
        echo '<div class="text-center error" ><h4 style="color: #b21f2d; margin: 5px">Ошибка! На балансе не хватает средств</h4></div>';
    }
    unset($_POST['BuyNow']);
}
if(isset($_POST['favorite'])){
    if(AddFavorite($_SESSION['user_auth'], $_POST['favorite'])=="err")
        echo '<div class="text-center error" ><h4 style="color: #b21f2d; margin: 5px">Ошибка! Данный товар уже имеется в закладках</h4></div>';
    unset($_POST['favorite']);
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


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