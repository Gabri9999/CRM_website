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
    
    $nome= $_POST["acq"];
    $indirizzo = $_POST["chp"];
    $email = $_POST["che"];
    $id = $_POST["id"];

    $statement3 = $conn->prepare("INSERT INTO azienda (name,address,email,cliente) VALUES (?,?,?,?)");                   
    $statement3->bind_param('sssi',$nome,$indirizzo,$email,$id);
    $statement3->execute();

    $id_azienda = $statement3->insert_id; 
    
    $statement2 = $conn->prepare("SELECT * FROM leads WHERE azienda = ?");
    $statement2->bind_param('i', $id_azienda);
    $statement2->execute();
    $results = $statement2->get_result();
    $cols = $results->fetch_assoc();

    if (!$cols) {
        $state = "email sent";
        $admin_id = $_SESSION["admin_id"];

        $statement1 = $conn->prepare("INSERT INTO leads (state, azienda, admin) VALUES (?, ?, ?)");
        $statement1->bind_param('sii', $state, $id_azienda, $admin_id);
        $statement1->execute();

        
        $statement2->execute(); 
        $results = $statement2->get_result();
        $cols = $results->fetch_assoc();
    } 

  
    header("location: leads.php");
    
  
  } else if(isset($_POST["close-button"])){
   
    header("location: leads.php");
    exit();  

  }


?>