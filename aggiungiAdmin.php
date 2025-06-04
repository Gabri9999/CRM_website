<?php

include('server/connection.php'); 

session_start();

if(!isset($_SESSION["loggato"])){
  header("location: login.php");
}

if(isset($_GET["logout"])){
  if(isset($_SESSION["loggato"])){
    unset($_SESSION["admin_id"]);
    unset($_SESSION["admin_username"]);
    unset($_SESSION["admin_email"]);
    unset($_SESSION["loggato"]);

    header("location: login.php");
  }
}

if(isset($_POST["add-button"])){
  $nome = $_POST["acq"];
  $cognome = $_POST["chp"];
  $telefono = $_POST["che"];
  $email = $_POST["coh"]; 
  $admin_id = $_SESSION["admin_id"];
  
  
    $statement = $conn->prepare("INSERT INTO cliente (name,surname,phone,email,admin) VALUES (?,?,?,?,?)");                   
    $statement->bind_param('ssisi',$nome,$cognome,$telefono, $email, $admin_id);
    
    $statement->execute();
  
    header("Location: index.php");
    //exit();
} else if(isset($_POST["close-button"])){
   
    header("location: index.php");
    exit();  
    
  }

?>