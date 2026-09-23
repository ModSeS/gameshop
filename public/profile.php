<?php session_start();
if(empty($_SESSION["user_auth"]))
    echo "<script>window.location.href='index.php'</script>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GameShop - Профиль</title>

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
<h1 style="margin-top: 20px" class="text-center">Данные профиля</h1>
<?php
$Name =GetName($_SESSION["user_auth"]);
$Reg =GetReg($_SESSION["user_auth"]);
$Type = GetTypeUser($_SESSION["user_auth"]);
echo '<h4 class="text-center">'.$Name.'['.$Type.']</h4> <h6 class="text-center">Дата регистрации: <b>'.$Reg.'</b></h6>';
echo '<form class="text-center"  method="post">  <button style="cursor: pointer" type="submit"  name="change_pass" class="btn-dark text-center" >Сменить пароль</button></form>';
if(isset($_POST['change_pass'])){
    echo '<form  method="post" class="d-flex justify-content-center">
<div >
            <div  >
                <label for="inputPassword4">Пароль</label>
                <input name="password" type="password" class="form-control" id="inputPassword4" placeholder="*********">
            </div>
            <div >
                <label for="inputPassword4">Повторите пароль</label>
                <input name="password2" type="password" class="form-control" id="inputPassword4" placeholder="*********">
            </div>
            <button type="submit" style="margin-top: 10px; margin-left: 60px" name="change" class="btn-dark">Сменить</button>
           
        </form></div>';
}
if(isset($_POST['change']) and !empty($_POST['password']) and ($_POST['password']==$_POST['password2'])){
ChangePass($_SESSION['user_auth'], $_POST['password']);
echo "<H5 class='text-center'>Пароль изменён</H5>";
unset($_POST['change']);
unset($_POST['change_pass']);
}
if($Type=="User") {
    echo '<form method="post"> <h6 class="text-center">Баланс: <b>'.GetBalance($_SESSION['user_auth']).' руб.</b><button name="AddMoney" type="submit" style="cursor: pointer; margin: 5px;  height: 25px" class="btn-dark">Пополнить</button></form></h6>
<main class="d-flex justify-content-center">

    <div class="container shadow min-vh-100 py-4">
        <div >
            <div >
                <div >
                    <div class="u-form u-form-1 flex-column">
                        <h5 class="text-center">Купленные товары</h5>
                        <table style="margin-top: 10px" class="table">
                            <thead>
                            <tr>
                                <th scope="col">Платформа</th>
                                <th scope="col">Название</th>
                                <th scope="col">Тип товара</th>
                                <th scope="col">Продавец</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Код</th>
                                <th scope="col">Дата заказа</th>
                                <th scope="col">Дата подтверждения</th>
                                <th id="options" scope="col">Страница</th>
                            </tr>
                            </thead>
                            <tbody>';
    $mas = GetOrders($_SESSION["user_auth"], false);
    for($i=0; $i<count($mas); $i++) {
        echo '     <tr>
                                <th scope="row">' . $mas[$i]["Platform"] . '</th>
                                <td>' .$mas[$i]["GameName"] . '</td>
                                <td>' .$mas[$i]["TypeGame"] . '</td>
                                <td>' . GetName($mas[$i]["SellerID"]) . ' ('.AverageRev($mas[$i]["SellerID"]).'⭐)</td>
                                <td>' . $mas[$i]["Price"] . ' руб.</td>
                                <td>' . $mas[$i]["Result"] . '</td>
                                <td>' . $mas[$i]["DataOrd"] . '</td>
                                <td>'; if (GetOrders($_SESSION["user_auth"], true)[$i]["Status"]=="unchecked") echo "Нет"; else echo  $mas[$i]["DataAcc"]; echo '</td>
                                <td style="margin-left: 20px; display: inline-flex"><a style="margin-top: 5px; " href="product.php?id='.$mas[$i]["idGames"].'"><img width="40" height="40" src="images/info.png"></a>'; if (GetOrders($_SESSION["user_auth"], true)[$i]["Status"]=="unchecked"){ echo '<form method="post">  <button name="OkayOrd" value="'.GetOrders($_SESSION["user_auth"], true)[$i]["OrderID"].'" style="all: unset; cursor: pointer" ><img  width="45" height="45" src="images/okay.png"></button></form>'; echo '<script>document.getElementById("options").innerHTML = "Страница/Подтвердить заказ";</script>';} echo '</td>
                            </tr>
                       ';
    }
}
else if($Type=="Seller"){ echo '<h6 style="margin-top: 10px" class="text-center">Средний рейтинг продавца: <b>'.AverageRev($_SESSION["user_auth"]).' из 10 ⭐</b></h6>';
    echo '<form method="post"> <h6 class="text-center">Баланс: <b>'.GetBalance($_SESSION['user_auth']).' руб.</b><button name="moneyOut" style="cursor: pointer; margin: 5px;  height: 25px" class="btn-dark">Вывести</button></form></h6>';
    echo '<form method="post" id="edit" class="container shadow col-md-5 py-2"></form>';
    echo '
<main class="d-flex justify-content-center">

    <div class="container shadow min-vh-100 py-4">
        <div >
            <div >
                <div >
                    <div class="u-form u-form-1 flex-column">
                        <h5 class="text-center">Ваши товары на продаже</h5>
                        <table style="margin-top: 10px" class="table">
                            <thead>
                            <tr>
                                <th scope="col">Платформа</th>
                                <th scope="col">Название</th>
                                <th scope="col">Тип товара</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Описание</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Количество</th>
                                <th scope="col">Обновить продукцию/Удалить</th>
                                
                            </tr>
                            </thead>
                            <tbody>';
    $mas = SellerGames($_SESSION["user_auth"]);
    for($i=0; $i<count($mas); $i++) {
        echo '     <tr>
                                <th scope="row">' . $mas[$i]["Platform"] . '</th>
                                <td>' .$mas[$i]["GameName"] . '</td>
                                <td>' .$mas[$i]["TypeGame"] . '</td>
                                <td>' . $mas[$i]["Price"] . ' руб.</td>
                                <td>' . $mas[$i]["Description"] . '</td>
                                <td>' . $mas[$i]["Status"] . '</td>
                                <td>' . getCount($mas[$i]["idGames"]) . ' шт.</td>
                                <td style="display: inline-flex; margin-left: 20px;"><form  method="post"><button name="addData" value="'.$mas[$i]["idGames"].'" style="all: unset; cursor: pointer" ><img width="50" height="50" src="images/data.png"> </button> <button name="delGame" value="'.$mas[$i]["idGames"].'" style="all: unset; cursor: pointer" ><img width="40" height="40" src="images/delete.png"></button></form></td>
                            </tr>
                       ';
    }
}

if (isset($_POST['delGame'])){
    DelGame($_POST['delGame']);
    echo '<meta http-equiv="refresh" content="0">';
}
if(isset($_POST['AddMoney'])){
    AddMoney($_SESSION['user_auth']);
    unset($_POST['AddMoney']);
echo '<script>location.href="profile.php"</script>';
}
if(isset($_POST["moneyOut"])){
    moneyOut($_SESSION['user_auth']);
    unset($_POST["moneyOut"]);
    echo '<meta http-equiv="refresh" content="0">';
}
if(isset($_POST['OkayOrd'])){
OkayOrd($_POST['OkayOrd'], "checked");
echo '<meta http-equiv="refresh" content="0">';
unset($_POST['OkayOrd']);
}
if (isset($_POST["addData"])){
    $edit1 = "<label>Ключ или данные аккаунта (каждый ключ/аккаунт на новой строке)</label><textarea name='keyGame' style='margin-bottom: 10px' type='text' class='form-control' placeholder='QWE-RTY-UIO-PPL'></textarea><button  type='submit' name='Data_btn' value='" ;
    $edit2 = "' class='btn btn-dark justify-content-center'>Сохранить</button>";
    echo '<script>document.getElementById("edit").innerHTML = "'.$edit1.$_POST["addData"].$edit2.'";</script>';
}
if (isset($_POST['Data_btn'])){
    if(!empty($_POST['keyGame'])) {
        newDATA($_POST['Data_btn'], $_POST['keyGame']);
        echo '<meta http-equiv="refresh" content="0">';
    }
    else echo "<text style='color: #b21f2d'>Ошибка обновления данных!</text>";
    unset($_POST['Data_btn']);
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