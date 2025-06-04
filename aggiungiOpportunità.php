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
  $id_lead = $_POST["id"]; 
  
  
    $statement2 = $conn->prepare("SELECT * FROM opportunity WHERE leads = ?");
    $statement2->bind_param('i', $id_lead);
    $statement2->execute();
    $results = $statement2->get_result();
    $cols = $results->fetch_assoc();
    
   if (!$cols) {
    $probability = $_POST["acq"];
    $closedDate = $_POST["chp"];
    $effectiveclosedDate = $_POST["che"];
    $gain = $_POST["coh"]; 
    $admin_id = $_SESSION["admin_id"];
    
    $statement2 = $conn->prepare("INSERT INTO opportunity (acquisition_probability,closed_data,effective_closed_data,gain,admin,leads) VALUES (?,?,?,?,?,?)");                   
    $statement2->bind_param('issiii',$probability,$closedDate,$effectiveclosedDate, $gain, $admin_id,$id_lead);
    $statement2->execute();
  }
    header("Location: opportunities.php");
    
} else if(isset($_POST["close-button"])){
   
    header("location: opportunities.php");
    exit();  
    
  }

?>
