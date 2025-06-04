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


if(isset($_POST["update-button"])){
    
  $lead_status = $_POST["user_status"];
  $lead_id = $_POST["user_id"]; 

  $statement = $conn->prepare("UPDATE leads SET state=? WHERE id_lead=?");                   
  $statement->bind_param('si',$lead_status,$lead_id);
  
  $statement->execute();

  header("location: leads.php");
  

  } 

  ?>