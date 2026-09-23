<?php
session_start();
if(empty($_SESSION['user_auth'])){
    echo  "<script>document.location.href='index.php' </script>";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>GameShop - Мессенджер</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




    <link rel="shortcut icon" href="logo.png" type="image/png">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            height: 100vh;
        }
        #Sender{
            border: 1px solid #ccc;
        }
        .sidebar {
            flex: 1;
            padding: 20px;
            /*background-color: #ffffff;*/
            /*background-color:rgba(100,220, 255, 0.5);*/
            background: url("images/chat2.jpg");
            border-right: 1px solid #d1d1d1;
            overflow: auto;
        }

        .sidebar h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        ul li {
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        ul li.active {
            background-color: #d1d1d1;
        }

        .main {
            flex: 4;
            padding: 20px;
            background: url("images/chat.jpg") ;

            overflow: auto;
        }

        .messages {
            margin-bottom: 20px;
        }

        .message {
            display: flex;
            margin-bottom: 20px;
        }

        .received {
            justify-content: flex-start;
        }

        .sent {
            justify-content: flex-end;
        }

        .bubble {
            background-color: #d1d1d1;
            padding: 10px;
            border-radius: 10px;
            max-width: 80%;
        }

        .time {
            font-size: 12px;
            color: rgb(100,100,100);
            margin-left: 10px;
        }

        .send-message-form {
            display: flex;
        }

        .send-message-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: none;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .send-message-form button[type="submit"] {
            padding: 10px;
            border: none;
            /*background-color: #4CAF50;*/
            background-color: #17a2b8;
            color: #ffffff;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            cursor: pointer;
        }
        .rectangle {

            border: 1px solid black;
        }
    </style>
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
<div class="container">
    <div class="sidebar">
        <a style="text-decoration: none;  color: black;" href="messages.php"> <h1>Диалоги</h1></a>

        <ul>
            <?php

            if(GetTypeUser($_SESSION['user_auth'])=='Admin') {
                $users = GetUsers();
                for ($i = 0; $i < count($users); $i++) {
                    echo '<li class="mes"><form method="get"><a id="sob"  href="messages.php?mess=' . $users[$i]['userID'] . '"   style="all: unset" >' . $users[$i]['NickName'] .  UnreadMess($users[$i]['userID'], $_SESSION['user_auth']).'</a></form></li>';
                }
                echo '</ul>
    </div>';

            }

            else  {
                echo '<li class="mes" ><form method="get"><a  href="messages.php?mess=3"  style="all: unset" ><b>Администратор</b>' . UnreadMess(3, $_SESSION["user_auth"]) . '</a></form></li>';

                $mas = GetMess($_SESSION["user_auth"]);
                $SenderName = array();
                $RecipientName = array();
                $Names = array();
                if ($mas != 0) {

                    for ($i = 0; $i < count($mas); $i++) {

                        $SenderName[$i] =  $mas[$i]['idSender'];
                        $RecipientName[$i] = $mas[$i]['idRecipient'];
                    }

                    $Names = array_unique(array_merge($SenderName, $RecipientName));

                    for ($i = 0; $i < count($Names); $i++) {

                        if (pos($Names) != $_SESSION["user_auth"] and pos($Names) != 3) {

                            echo '
            <li class="mes"><form method="get"><a id="sob"  href="messages.php?mess=' . pos($Names) . '"   style="all: unset" >' . GetName(pos($Names)) . UnreadMess(pos($Names), $_SESSION['user_auth']). '</a></form></li>';
                        }
                        next($Names);
                    }
                    echo '</ul>
    </div>';
                } else echo ' </ul>
    </div>';
            }
            if(isset($_GET['mess'])) {
            ReadMsg($_GET['mess'], $_SESSION['user_auth']);

                echo '
    <div class="main">
    <b>'.GetName($_GET['mess']).'</b>
        <div class="messages">
           ';

                $messages =  GetMess2($_SESSION['user_auth'],$_GET['mess']);

                if($messages!=0)
                    for ($i = 0; $i < count($messages); $i++) {
if($_SESSION['user_auth'] == $messages[$i]['idRecipient'])
                        echo '
            <div class="message received">
                <div class="bubble text js">'.
                            $messages[$i]['TextMess'].'
                </div>
                <div class="time">'.$messages[$i]['Data'] .'</div>
            </div>';
else   echo '<div class="message sent">
                <div class="bubble js">'.
                       $messages[$i]['TextMess'].
                        '   </div>
                <div class="time">'. $messages[$i]['Data'].'</div>
            </div>';
                    }
            }
            if(!empty($_GET['mess'])){
                if(isset($_POST['sendBtn'])){
                    if(!empty($_POST['TextBlock']))

                        SendMess($_SESSION['user_auth'], $_GET['mess'], $_POST['TextBlock']);
                    echo '<script>location.href="messages.php?mess='.$_GET['mess'].'"</script>';
                    unset($_POST['sendBtn']);

                }
            }
         if(!empty($_GET['mess']))   echo    ' </div>
        <form id="myForm" method="post" class="send-message-form">
            <input id="Sender" name="TextBlock" type="text"  placeholder="Type a message">
            <button id="otprav" type="submit" value="" name="sendBtn" >Send</button>
        </form>
    </div>
</div>';


            ?>

</body>
</html>