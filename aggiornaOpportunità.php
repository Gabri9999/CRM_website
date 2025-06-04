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

if(isset($_POST["edit-button"])){
  
  $oppid = $_POST["id"];
  $probability = $_POST["acq"];
  $closedDate = $_POST["chp"];
  $effectiveclosedDate = $_POST["che"];
  $gain = $_POST["val"]; 


  $statement = $conn->prepare("UPDATE opportunity SET acquisition_probability=?, closed_data=?, effective_closed_data=?, gain=? WHERE id_opportunity = ?");                   
  $statement->bind_param('issii',$probability,$closedDate,$effectiveclosedDate,$gain,$oppid);
  
  $statement->execute();

  header("Location: opportunities.php");

} else if(isset($_POST["close-button"])){
   
    header("location: opportunities.php");
    exit();  

  }

?>