<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'].'/EZCUT/conessione/DBHandler.php');
require($_SERVER['DOCUMENT_ROOT'].'/EZCUT/conessione/DBHandlerObject.php');
$stmt = $dbh->getInstance()->prepare("SELECT Password, AdministratorID, Username FROM Administrators
         WHERE Username =:Username");
 $stmt->bindParam(':Username', $Username);
 $Username = $_POST['Username'];
 $stmt->execute();
 $row = $stmt->fetch();
 if($row){//if isset on administrator
     if(password_verify($_POST['Password'], $row['Password'])){//if the password corispond
         $_SESSION['AdministratorUsername'] = $_POST['Username'];
         header('Location: /EZCUT/Salon/HomePageSalon.php');
         exit;
     }
     else{//if the password does not corrispond
         header('Location: /EZCUT/index.php?id=falsepw');
         exit;
     }
 }else{//if is not set on administrator table
   $stmt = $dbh->getInstance()->prepare("SELECT Password, UserID, Username FROM Users
            WHERE Username =:Username");
    $stmt->bindParam(':Username', $Username);
    $Username = $_POST['Username'];
    $stmt->execute();
    $row = $stmt->fetch();
    // $row is false if the user does not exist
    if($row){
        if(password_verify($_POST['Password'], $row['Password'])){
            $_SESSION['Username'] = $_POST['Username'];
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Name']=$row['Username'];
            header('Location: /EZCUT/User/HomePage.php');
            exit;
        }
        else{
          header('Location: /EZCUT/index.php?id=falsepw');
            exit;
        }
   }
 }
   header('Location: /EZCUT/index.php');
     exit;
  ?>
