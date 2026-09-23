<?php session_start();
if(!empty($_SESSION["user_auth"]))
    echo "<script>window.location.href='index.php'</script>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GameShop</title>
    <link href="bootstrap.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <script src="jquery-3.6.0.min.js" type="application/javascript"></script>
    <link rel="stylesheet" href="adaptive.css">
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
                        <a class="nav-link" href="games.php">Каталог игр</a>
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
                    </li>';
                        }}
                    ?>
                </ul>


                <!--                <form class="d-flex">-->
                <!--                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
                <!---->
                <!--                    <button class="btn btn-outline-success" type="submit">Search</button>-->
                <!--                </form>-->
            </div>

        </div>


    </nav>

</header>

<main style="position: relative; margin-top: 150px" class="d-flex justify-content-center">



<?php
if(!empty($_POST["create"]) or (isset($_POST['reg_btn']))) {
    echo '<form id="reg" method="POST" class="w-25 m-3 d-flex flex-column justify-content-center">
        <h3 class="text-center">Регистрация</h3>

        <div class="form-row">
            <div class="col">
                <label>Логин</label>
                <input name="name" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Имя">
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputPassword4">Пароль</label>
                <input name="password" type="password" class="form-control" id="inputPassword4" placeholder="*********">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Повторите пароль</label>
                <input name="password2" type="password" class="form-control" id="inputPassword4" placeholder="*********">
            </div>
        </div>
        <label for="inputPassword4">Категория аккаунта</label>
        <select  style="margin-bottom: 10px"  name="category" id="inputState" class="col-md-5">
            <option value="User">Покупатель</option>
            <option value="Seller">Продавец</option>
        </select>
       
        <button style="margin-bottom: 40px" type="submit" name="reg_btn" class="btn btn-primary">Зарегистрироваться</button>
        <form  method="post">
          <label CLASS="text-center" for="inputPassword4">ИЛИ</label>
        <button  value="rand" name="auth" type="submit" class="btn btn-primary">Уже есть аккаунт</button>
    </form>
    </form>
    ';


}
else {
    echo ' <form id="auth" method="POST" class="w-25 m-3 d-flex flex-column justify-content-center">
        <h3 class="text-center">Авторизация</h3>

        <div class="form-row">
            <div class="col">
                <label>Логин</label>
                <input name="name" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Имя">
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="inputPassword4">Пароль</label>
                <input name="password" type="password" class="form-control" id="inputPassword4" placeholder="*********">
            </div>
        </div>
        <button style="margin-bottom: 40px" name="enter" type="submit" class="btn btn-primary">Войти</button>
        <form   method="post">
         <label CLASS="text-center" for="inputPassword4">ИЛИ</label>
        <button value="rand" name="create" type="submit" class="btn btn-primary">Зарегистрировать аккаунт</button>
    </form>
    </form>
    ';}
    if (isset($_POST["enter"])) {
        if (Login($_POST["name"], $_POST["password"]) == false) {
            echo "<div class='text-center error' style='display: inline'><img style='width: 50px; height: 50px' src='images/error.png'><h4 >Данные неверны</h4></div>";
        }

    }
    if (isset($_POST['reg_btn'])) {
        $_POST['create']='lol';
        if (!empty($_POST["name"]) and !empty($_POST["category"]) and !empty($_POST["password"])and !empty($_POST["password2"])) {
            $data = date('d.m.Y');
            $name = $_POST["name"];
            $category = $_POST["category"];
            $password = $_POST["password"];
            $password2 = $_POST["password2"];

            if (strlen($name) <= 15 & strlen($password) <= 15) {
              //  if(strlen($name)>=6 & strlen($password)>=6) {
                    if ($password == $password2) {
                        if (AddUser($category, $data, $name, $password) != "err") {
                            echo "<h4 class='text-center error'>Аккаунт успешно создан!</h4>";
                            Login($name, $password);
                        } else echo "<div class='text-center error' style='display: inline'><img style='width: 50px; height: 50px' src='images/error.png'><h4 >Нельзя зарегистрировать данного пользователя</h4></div>";
                    } else {
                        echo "<div class='text-center error' style='display: inline'><img style='width: 50px; height: 50px' src='images/error.png'><h4 >Пароли не совпадают</h4></div>";
                    }
              //  }
               // else  echo  "<div class='text-center' style='display: inline'><img style='width: 50px; height: 50px' src='images/error.png'><h4 >Запрещены строки меньше 6-ти символов</h4></div>";
            } else {
                echo  "<div class='text-center error' style='display: inline'><img style='width: 50px; height: 50px' src='images/error.png'><h4 >Запрещены строки больше 15-ти символов</h4></div>";
            }
        } else {
            echo " <div class='text-center error' style='display: inline'><img style='width: 50px; height: 50px' src='images/error.png'><h4 >Заполните пустые поля</h4></div>";
        }
    }

?>

</main>


</body>
</html>