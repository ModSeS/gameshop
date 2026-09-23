<?php
$con = new mysqli("localhost", "root", "", "gameshop", '3306');
//else{
//    echo  "Успешное подключение";
//    $sql ="SELECT * FROM users";
//    $result = mysqli_query($con, $sql);
//    if(!$result){
//        echo "<br>Ошибка при выполнении запроса";
//    }
//    else{
//        foreach ($result as $item)
//        print_r($item);
//        while ($row = mysqli_fetch_array($result)){
//            echo "Имя ". $row['name'];
//        }
//    }
//
//}
function moneyOut($userID){
    $sql= "UPDATE accounts SET balance = '0' WHERE userID = '$userID'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function newDATA($GameID, $Result){
    $sql = "UPDATE games SET Result = '$Result' WHERE idGames= '$GameID'";
    $sql2 = "UPDATE games SET Status = 'unchecked' WHERE idGames= '$GameID'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $quer2 = mysqli_query($GLOBALS['con'], $sql2);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function getCount($GameID){
    if(GetInfo($GameID)["Result"]=="null"){
        return 0;
    }
    else
    return count(explode("\n", GetInfo($GameID)["Result"]));
}
function DelOrd($orderID){
    $sql0 = "SELECT * FROM orders where OrderID = '$orderID'";
    $result0 = mysqli_query($GLOBALS['con'], $sql0);
    $GameID = "";
    $UserID = "";
    while ($row = mysqli_fetch_array($result0)) {
        $GameID = ($row['GameID']);
        $UserID = ($row['userID']);
    }
    $userBal = GetBalance($UserID) + GetInfo($GameID)["Price"];

    $sql = "DELETE FROM orders WHERE OrderID = '$orderID'";
    $sql2 = "UPDATE accounts SET balance = '$userBal' WHERE userID = '$UserID'";

    $quer = mysqli_query($GLOBALS['con'], $sql);
    $quer2 = mysqli_query($GLOBALS['con'], $sql2);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}

function GetOrd(){
    $sql = "SELECT * FROM orders where Status = 'checked' or Status = 'unchecked'";
    $i=0;
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row;
        $i++;
    }
    return $mas;
}
function DelReview($idRev){
    $sql = "DELETE FROM reviews WHERE reviewID = '$idRev'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}

function DelFavorite($userID, $idGames){
    $sql='';
    if($idGames==null)
        $sql = "DELETE FROM favorites WHERE idUser = '$userID'";
    else
    $sql = "DELETE FROM favorites WHERE idGame = '$idGames' and idUser = '$userID'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;

}
function GetFavorites($userID){
    $sql="SELECT * FROM favorites where idUser = '$userID'";
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $i=0;
    while ($row = mysqli_fetch_array($result)) {
        $sql2 = 'SELECT * FROM games where idGames ="'.$row['idGame'].'" and Status = "checked"';
        $result2 = mysqli_query($GLOBALS['con'], $sql2);

            $mas[$i] = mysqli_fetch_array($result2);
            $i++;

    }
if($mas==null or $mas[0]==null){
    return 0;
}
else
    return $mas;
}
function AddFavorite($userID, $idGame){
    $sql = "INSERT INTO favorites (favID, idUser, idGame) VALUE (null, '$userID', '$idGame')";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    if(!$result){
      return "err";
  }
    else {
        return $result;
    }
}
function SendMess($sender, $recipientID, $TextMess){
    date_default_timezone_set('Asia/Yekaterinburg');
    $data = date('H:i');
    $sql = "INSERT INTO messages (idMess, idRecipient, idSender, Data, TextMess, StatusMsg) VALUE (null, '$recipientID', '$sender', '$data', '$TextMess', 'unread')";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function GetTextMess($idMess){
    $sql = "SELECT * FROM messages where idMess = '$idMess'";

    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $mas = mysqli_fetch_array($result);

    return $mas;
}
function BuyProduct($GameID, $userID, $sellerID, $price){
    $data = date('d.m.Y');
    $userBal=GetBalance($userID)-$price;
    $sql2 ="";
    $quer3 = "";
    $sqlStat="";
    $quer5 ="";
   $res = explode("\n",GetInfo($GameID)["Result"])[0];
   if ($res != 'null') {
       $fullRes = str_replace($res . "\n", "", GetInfo($GameID)["Result"]);
       $sql = "UPDATE accounts SET balance = '$userBal' WHERE userID = '$userID'";
       if (count(explode("\n", GetInfo($GameID)["Result"])) > 1) {
           $sql2 = "UPDATE games SET Result = '$fullRes' WHERE idGames = '$GameID'";
           $quer3 = mysqli_query($GLOBALS['con'], $sql2);
       } else if (count(explode("\n", GetInfo($GameID)["Result"])) == 1) {
           $sql2 = "UPDATE games SET Result = 'null' WHERE idGames = '$GameID'";
           $quer3 = mysqli_query($GLOBALS['con'], $sql2);
           $sqlStat = "UPDATE games SET Status = 'null' WHERE idGames = '$GameID'";
           $quer5 = mysqli_query($GLOBALS['con'], $sqlStat);
       }
       $sql3 = "INSERT INTO orders (OrderID, GameID, userID, Status, Result, DataOrd, DataAcc) VALUE (null,'$GameID', '$userID', 'unchecked', '$res', '$data', null)";
       $quer2 = mysqli_query($GLOBALS['con'], $sql);
       $quer4 = mysqli_query($GLOBALS['con'], $sql3);
       $result3 = mysqli_insert_id($GLOBALS['con']);

       return $result3;
   }
   else return null;
}
function AddMoney($userID){
    $userBal=GetBalance($userID)+500;
    $sql = "UPDATE accounts SET balance = '$userBal' WHERE userID = '$userID'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function ChangePass($userID,$pass){
   $sql ="UPDATE accounts SET pass = '$pass' WHERE userID = '$userID'";
    $quer = mysqli_query($GLOBALS['con'], $sql);

    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function AverageRev($sellerID){
    $sql = "SELECT * FROM games where SellerID = '$sellerID'";
    $i=0;
    $count=0;
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $mas2 = 0;
    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row['idGames'];
        $i++;
    }
    for($j=0;$j<count($mas);$j++) {
        $sql2 = "SELECT * FROM reviews where idGame = '$mas[$j]'";
        $result2 = mysqli_query($GLOBALS['con'], $sql2);

        while ($row = mysqli_fetch_array($result2)) {
            $mas2 += intval($row['rating']);
            $count++;
        }
    }
    if($count==0) $count++;
    return round($mas2/$count, 1);
}
function GetInfo($idGames){
    $sql = "SELECT * FROM games where idGames = '$idGames'";

    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $mas = mysqli_fetch_array($result);
    return $mas;
}

function GetReviews($idGames){
    $sql = "SELECT * FROM reviews where idGame = '$idGames'";
    $i=0;
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row;
        $i++;
    }
    return $mas;
}

function GetUsers(){
    $sql = "SELECT * FROM accounts where Type = 'User' or Type = 'Seller'";
    $i=0;
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row;
        $i++;
    }
    return $mas;
}
function ReadMsg($idSender, $idRecipient){
    $sql= "UPDATE messages SET StatusMsg = 'read' WHERE idRecipient = '$idRecipient' and idSender = '$idSender' and StatusMsg = 'unread'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}

function GetMess($userID){
    $sql="SELECT * FROM messages WHERE idRecipient = '$userID'  or idSender = '$userID'";
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $i=0;
    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row;
        $i++;
    }
    if($mas != null){
    return $mas;
    }
    else{return 0;}

}
function GetMess2($recipientID, $SenderID){
    $sql="SELECT * FROM messages where (idRecipient ='$recipientID' and idSender ='$SenderID') or (idRecipient ='$SenderID' and idSender ='$recipientID')";
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $i=0;

    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row;
        $i++;
    }
    if($mas != null){
        return $mas;
    }
    else{return 0;}

}
function SellerGames($idSeller){
    $sql="SELECT * FROM games where SellerID = '$idSeller'";
    $i=0;
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row;
        $i++;
    }
    return $mas;
}
function GetGames($search, $filter, $filter2, $sort, $sort2, $status){

    $sql="SELECT * FROM games where Status = '$status'";
    $i=0;
if(!empty($search)){
    $sql = $sql." and GameName like '%$search%'";
}
    if(!empty($filter)){
        $sql = $sql." and Platform='$filter'";
    }
     if(!empty($filter2)){
        $sql = $sql." and TypeGame='$filter2'";
    }
    if(!empty($sort)){
        $sql = $sql." order by Price $sort";
    }
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $AvRev=array();
    $sortMas=array();
    $tempEl =0;
    $tempElId =0;
    while ($row = mysqli_fetch_array($result)) {
        $mas[$i] = $row;
        $i++;
    }
    if(!empty($sort2)){
        for($i=0; $i<count($mas); $i++){
            $AvRev[$i] =  $mas[$i];
        $sortMas[$i] = AverageRev($mas[$i]['SellerID']);
        }
        if ($sort2 == 'desc'){
            for($i=0; $i<count($mas); $i++){
                for($j = $i+1; $j<count($mas); $j++) {

                    if ($sortMas[$j] > $sortMas[$i]) {
                        $tempEl = $sortMas[$i];
                        $tempElId =  $AvRev[$i];
                        $AvRev[$i] = $AvRev[$j];
                        $AvRev[$j] = $tempElId;
                        $sortMas[$i] =  $sortMas[$j];
                        $sortMas[$j]=$tempEl;
               }

                }
            }
            return $AvRev;
        }
        else if($sort2 == 'asc'){
            for($i=0; $i<count($mas); $i++) {
                for ($j = $i + 1; $j < count($mas); $j++) {
                    if ($sortMas[$j] < $sortMas[$i]) {
                        $tempEl = $sortMas[$i];
                        $tempElId = $AvRev[$i];
                        $AvRev[$i] = $AvRev[$j];
                        $AvRev[$j] = $tempElId;
                        $sortMas[$i] = $sortMas[$j];
                        $sortMas[$j] = $tempEl;
                    }
                }
            }
            return $AvRev;
        }


    }
    else
        return $mas;

}
function GetOrders($userID, $onlyOrder){
    $sql = 'SELECT * FROM orders where userID ="'.$userID.'"';
    $result = mysqli_query($GLOBALS['con'], $sql);
    $mas=array();
    $ordMas=array();
    $i=0;
    while ($row = mysqli_fetch_array($result)) {
        $sql2 = 'SELECT * FROM games where idGames ="'.$row['GameID'].'"';
        $result2 = mysqli_query($GLOBALS['con'], $sql2);
        $mas[$i] = mysqli_fetch_array($result2);
        $mas[$i]["Result"] = $row['Result'];
        $mas[$i]["DataOrd"] = $row['DataOrd'];
        $mas[$i]["DataAcc"] = $row['DataAcc'];
        $ordMas[$i] = $row;
        $i++;

    }
    if ($onlyOrder == false) {
    return $mas;
}
    else {
        return $ordMas;
    }
}
function GetTypeUser($userID){

    $sql = 'SELECT Type from accounts where UserID ="' . $userID . '"';
    $result = mysqli_query($GLOBALS['con'], $sql);
    $Type = "";
    while ($row = mysqli_fetch_array($result)) {
        $Type = ($row['Type']);
    }
    return $Type;
}
function UnreadMess($idUser, $idRecipient){
    $sql = "SELECT StatusMsg from messages where idSender = '$idUser' and idRecipient ='$idRecipient'";
    $result = mysqli_query($GLOBALS['con'], $sql);
    $Status = "";
    while ($row = mysqli_fetch_array($result)) {
        $Status = ($row['StatusMsg']);
    }
    if($Status == "unread")
        return "<b style='font-size: 13px'><i> [Новое сообщение]</i></b>";
   else  return "";

}

function GetName($userID){

    $sql = 'SELECT NickName from accounts where UserID ="' . $userID . '"';
    $result = mysqli_query($GLOBALS['con'], $sql);
    $NickName = "";
    while ($row = mysqli_fetch_array($result)) {
        $NickName = ($row['NickName']);
    }
    return $NickName;
}
function GetBalance($userID){
    $sql = 'SELECT balance from accounts where UserID ="' . $userID . '"';
    $result = mysqli_query($GLOBALS['con'], $sql);
    $balance = "";
    while ($row = mysqli_fetch_array($result)) {
        $balance = ($row['balance']);
    }
    return $balance;
}
function GetReg($userID){

    $sql = 'SELECT RegistrationData from accounts where UserID ="' . $userID . '"';
    $result = mysqli_query($GLOBALS['con'], $sql);
    $RegData = "";
    while ($row = mysqli_fetch_array($result)) {
        $RegData = ($row['RegistrationData']);
    }
    return $RegData;
}
function OkayReq($idGames, $Status){
    $sql = "UPDATE games SET Status = 'checked' WHERE idGames = '$idGames'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function OkayOrd($OrderID, $Status){
    $data = date('d.m.Y');
    $sql = "UPDATE orders SET Status = '$Status' WHERE OrderID = '$OrderID'";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    if($Status == "checked") {
        $sqlData = "UPDATE orders SET DataAcc = '$data' WHERE OrderID = '$OrderID'";
        $querData = mysqli_query($GLOBALS['con'], $sqlData);
    }

    if($Status = "done"){
        $sql0 = "SELECT * from orders where OrderID ='$OrderID'";
        $result0 = mysqli_query($GLOBALS['con'], $sql0);
        $sellerID="";
        $price = "";
        while ($row = mysqli_fetch_array($result0)) {
            $sellerID=(GetInfo($row['GameID'])["SellerID"]);
            $price = (GetInfo($row['GameID'])["Price"]);
        }
        $sellerBal =GetBalance($sellerID)+$price;
        $sql2 = "UPDATE accounts SET balance = '$sellerBal' WHERE userID = '$sellerID'";
        $quer2 = mysqli_query($GLOBALS['con'], $sql2);
    }
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function DelUser($idUser){
    $sql0 = "DELETE FROM favorites WHERE idUser = '$idUser'";
    $sql = "DELETE FROM messages WHERE idRecipient = '$idUser'";
    $sql2 = "DELETE FROM messages WHERE idSender = '$idUser'";
    $sql3 = "DELETE FROM reviews WHERE idUser = '$idUser'";
    $sql4 = "DELETE FROM orders WHERE userID = '$idUser'";
    $sql5 = "DELETE FROM games WHERE SellerID = '$idUser'";
    $sql6 = "DELETE FROM accounts WHERE userID = '$idUser'";

    $quer0 = mysqli_query($GLOBALS['con'], $sql0);
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $quer2 = mysqli_query($GLOBALS['con'], $sql2);
    $quer3 = mysqli_query($GLOBALS['con'], $sql3);
    $quer4 = mysqli_query($GLOBALS['con'], $sql4);
    $quer5 = mysqli_query($GLOBALS['con'], $sql5);
    $quer6 = mysqli_query($GLOBALS['con'], $sql6);
    $result=mysqli_insert_id($GLOBALS['con']);

    return $result;
}
function DelGame($idGames){
    $sql0 = "DELETE FROM favorites WHERE idGame = '$idGames'";
    $sql = "DELETE FROM reviews WHERE idGame = '$idGames'";
    $sql2 = "DELETE FROM orders WHERE GameID = '$idGames'";
    $sql3 = "DELETE FROM games WHERE idGames = '$idGames'";
    $quer0 = mysqli_query($GLOBALS['con'], $sql0);
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $quer2 = mysqli_query($GLOBALS['con'], $sql2);
    $quer3 = mysqli_query($GLOBALS['con'], $sql3);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function AddGame($gameName, $price, $sellerID, $platform, $description, $typeGame, $Result){
    $sql = "INSERT INTO games (idGames, GameName, Price, SellerID, Platform, Description, TypeGame, Result, Status) VALUE (null,'$gameName', '$price', '$sellerID', '$platform', '$description','$typeGame','$Result','unchecked')";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function AddReview($idUser, $reviewText, $idGame, $rating){
    $data = date('d.m.Y');
    $sql = "INSERT INTO reviews (reviewID, idUser, reviewText, idGame, rating, dataRev) VALUE (null,'$idUser', '$reviewText', '$idGame', '$rating', '$data')";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    return $result;
}
function AddUser($type, $registrationData, $nickname, $pass){
    $sql = "INSERT INTO accounts (userID, Type, RegistrationData, NickName, pass, balance) VALUE (null,'$type', '$registrationData', '$nickname', '$pass',0)";
    $quer = mysqli_query($GLOBALS['con'], $sql);
    $result=mysqli_insert_id($GLOBALS['con']);
    if(!$result){
       return "err";
    }
    else return $result;
}
function Login($name, $pass){
    $b=false;
    $sql = "SELECT * FROM accounts";
    if(isset($_POST["name"]) and $_POST["password"])
            if($result = $GLOBALS['con']->query($sql)){

                foreach($result as $row){
                    if($name==$row["NickName"] and $pass==$row["pass"]){
                        $_SESSION["user_auth"]=$row["userID"];
                        $_SESSION["cart"]="";
                        $b=true;
                        echo "<script>window.location.href = 'index.php';</script>";
                    }

                }

                $result->free();

            } else{
                echo "Ошибка: " . $GLOBALS['con']->error;
            }

    return $b;
}