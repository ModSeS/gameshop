<?php session_start(); include "db_connect.php";
if(empty($_SESSION["user_auth"]) or GetTypeUser($_SESSION["user_auth"])!="Admin"){
    echo "<script>window.location.href='index.php'</script>";}?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>GameShop - Админ панель</title>

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
<header>

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

                        if (GetTypeUser($_SESSION["user_auth"]) == "Admin") echo '<li class="nav-item">
                        <a class="nav-link active" href="admin.php">Админ панель</a>
                    </li>';}
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
            echo "<script>window.location.href='index.php'</script>";
        }
        ?>
    </nav>

</header>

<main class="d-flex justify-content-center">

    <div class="container shadow min-vh-100 py-4">
        <div >
            <div >
                <div >
                    <div class="u-form u-form-1 flex-column">
                        <form method="post" class="flex-column" >




                            <div class="row">

                                <div class="dropdown show">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Разделы
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <form name="filter" method="get">
                                            <a href="?request" style="cursor: pointer" type="submit"  class="dropdown-item" >Заявки</a>
                                            <a href="?games" style="cursor: pointer" type="submit"  class="dropdown-item" >Товары</a>
                                            <a href="?users" style="cursor: pointer" type="submit"  class="dropdown-item" >Пользователи</a>
                                            <a href="?orders" style="cursor: pointer" type="submit"  class="dropdown-item" >Заказы</a>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <?php
        $request = GetGames(null,null, null, null, null, 'unchecked' );
        $games = GetGames(null,null, null, null, null, 'checked' );
        $users = GetUsers();
        $orders = GetOrd();
        if(isset($_GET['games'])){
                        echo '<h4 class="text-center" style="margin-top: 10px">Товары на продажу</h4><table style="margin-top: 10px" class="table">
            <thead>
            <tr>
                <th scope="col">Платформа</th>
                <th scope="col">Название</th>
                <th scope="col">Тип товара</th>
                <th scope="col">Продавец</th>
                <th scope="col">Цена</th>
                <th scope="col">Статус</th>
                <th scope="col">Подробнее/Удалить</th>
            </tr>
            </thead>
            <tbody>';
            for ($i = 0; $i < count($games); $i++) {
                echo '
            <tr>
                <th scope="row">'.$games[$i]["Platform"].'</th>
                <td>'.$games[$i]["GameName"].'</td>
                <td>'.$games[$i]["TypeGame"].'</td>
                <td>'.GetName($games[$i]["SellerID"]).'</td>
                <td>'.$games[$i]["Price"].' руб.</td>
                <td>'.$games[$i]["Status"].'</td>
                <td style="display: inline-flex;"><a style="margin: 5px" href="product.php?id='.$games[$i]["idGames"].'"><img width="40" height="40" src="images/info.png"></a> <form method="post"><button name="delGame" value="'.$games[$i]["idGames"].'" style="all: unset; cursor: pointer" ><img width="45" height="45" src="images/delete.png"></button></form></td>
            </tr>';
            }

        }
        elseif(isset($_GET['users'])){
            echo '<h4 class="text-center" style="margin-top: 10px">Пользователи</h4><table style="margin-top: 10px" class="table">
            <thead>
            <tr>
                <th scope="col">ID Пользователя</th>
                <th scope="col">Имя</th>
                <th scope="col">Категория</th>
                <th scope="col">Дата регистрации</th>
                    <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>';
            for ($i = 0; $i < count($users); $i++) {
                echo '
            <tr>
                <th scope="row">'.$users[$i]["userID"].'</th>
                <td>'.$users[$i]["NickName"].'</td>
                <td>'.$users[$i]["Type"].'</td>
                <td>'.$users[$i]["RegistrationData"].'</td>
                <td style="display: inline-flex"><form method="post"><button name="delUser" value="'.$users[$i]["userID"].'" style="all: unset; cursor: pointer" href="#"><img width="45" height="45" src="images/delete.png"></button></form></td>
            </tr>';
            }

        }

      elseif (isset($_GET['request'])) {
          echo '<h4 class="text-center" style="margin-top: 10px">Заявки от продавцов</h4><table style="margin-top: 10px" class="table">
            <thead>
            <tr>
                <th scope="col">Платформа</th>
                <th scope="col">Название</th>
                <th scope="col">Тип товара</th>
                <th scope="col">Продавец</th>
                <th scope="col">Цена</th>
                <th scope="col">Статус</th>
                <th scope="col">Подробнее/Принять/Отлонить</th>
            </tr>
            </thead>
            <tbody>';
        for ($i = 0; $i < count($request); $i++) {
            echo '
            <tr>
                <th scope="row">' . $request[$i]["Platform"] . '</th>
                <td>' . $request[$i]["GameName"] . '</td>
                <td>' . $request[$i]["TypeGame"] . '</td>
                <td>' . GetName($request[$i]["SellerID"]) . '</td>
                <td>' . $request[$i]["Price"] . ' руб.</td>
                <td>' . $request[$i]["Status"] . '</td>
                <td style="margin-left: 35px; display: inline-flex"><a style="margin: 5px" href="product.php?id='.$request[$i]["idGames"].'"><img  width="40" height="40" src="images/info.png"></a><form method="post">  <button name="OkayReq" value="'.$request[$i]["idGames"].'" style="all: unset; cursor: pointer" ><img  width="45" height="45" src="images/okay.png"></button><button name="delGame" value="'.$request[$i]["idGames"].'" style="all: unset; cursor: pointer" ><img width="45" height="45" src="images/delete.png"></button></form></td>
            </tr>';
        }
      }
        elseif (isset($_GET['orders'])){
            echo '<h4 class="text-center" style="margin-top: 10px">Произведённые сделки</h4><table style="margin-top: 10px" class="table">
            <thead>
            <tr style="font-size: 15px">
                <th scope="col">ID Заказа</th>
                <th scope="col">Название товара</th>
                <th scope="col">Стоимость</th>
                <th scope="col">Продавец</th>
                <th scope="col">Покупатель</th>
                <th scope="col">Статус заказа</th>
                <th scope="col">Дата заказа</th>
                <th scope="col">Дата подтверждения</th>
                <th  scope="col">Отменить сделку/Принять сделку</th>
            </tr>
            </thead>
            <tbody>';
            for ($i = 0; $i < count($orders); $i++) {
                echo '
            <tr>
                <th scope="row">' . $orders[$i]["OrderID"] . '</th>
                <td>' . GetInfo($orders[$i]["GameID"])["GameName"] . '</td>
                <td>' . GetInfo($orders[$i]["GameID"])["Price"] . ' руб.</td>
                <td>' . GetName(GetInfo($orders[$i]["GameID"])["SellerID"]) . '</td>
                <td>' . GetName($orders[$i]["userID"]) . '</td>
                <td>';  if ($orders[$i]["Status"]== "checked") echo "Подтверждено"; else echo "Неподтверждено"; echo '</td>
                <td>' .  $orders[$i]["DataOrd"]. '</td>
                <td>';  if ($orders[$i]["Status"]== "checked") echo $orders[$i]['DataAcc']; else echo "Нет"; echo '</td>
                <td><form method="post"> <button name="delOrd" value="'.$orders[$i]["OrderID"].'" style="all: unset; cursor: pointer" ><img width="40" height="40" src="images/delete.png"></button><button name="OkayOrd" value="'.$orders[$i]["OrderID"].'" style="all: unset; cursor: pointer" ><img  width="45" height="45" src="images/okay.png"></button></form></td>
            </tr>';
            }
        }



if (isset($_POST['delUser'])){
    DelUser($_POST['delUser']);
    echo '<meta http-equiv="refresh" content="0">';

}
        if (isset($_POST['delGame'])){
            DelGame($_POST['delGame']);
            echo '<meta http-equiv="refresh" content="0">';
        }
        if (isset($_POST['OkayReq'])){
            OkayReq($_POST['OkayReq'], "checked");
            echo '<meta http-equiv="refresh" content="0">';
        }
if(isset($_POST["delOrd"])){
    DelOrd($_POST["delOrd"]);
    echo '<meta http-equiv="refresh" content="0">';
}
        if(isset($_POST['OkayOrd'])){
            OkayOrd($_POST['OkayOrd'], "done");
            echo '<meta http-equiv="refresh" content="0">';
        }

            ?>
            </tbody>
        </table>
    </div>

</main>
</body>
</html>