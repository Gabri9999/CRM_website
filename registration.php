<?php

include('server/connection.php'); 

session_start();


if (isset($_SESSION["loggato"])){
   header("location: login.php");
   exit; 
}

if(isset($_POST["register-button"])){

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $confirmpassword = $_POST["confpass"];

    if($password!==$confirmpassword){
       header("location: registration.php?error=passwords dont match");
    }  else {
    $statement2 = $conn->prepare("INSERT INTO admin (username,email,password) VALUES (?,?,?)");
    $statement2->bind_param("sss",$name,$email,md5($password));
   
    if($statement2->execute()){

        header("location: login.php?success=registrazione avvenuta con successo!");
    } else {
        header("location: registration.php?error=session error");
    }
  }    
 } 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="impostazioni/css/style.css">
</head>
<body>



<div class="mx-auto container mt-10" style="width: 300px">
    <form id="registration-form" method="POST" action="registration.php">
      <p style="color: red"> <?php if(isset($_GET["error"])) { echo $_GET["error"]; } ?> </p>
      <div class="opp-form">
          <label>Nome</label>
          <input type="text" class="form-control" id="opp-acq" name="name" placeholder="Nome" required>
        </div>
        <div class="opp-form">
          <label>Email</label>
          <input type="text" class="form-control" id="opp-chp" name="email" placeholder="Email" required>
        </div> 
        <div class="opp-form">
          <label>Password</label>
          <input type="password" class="form-control" id="opp-che" name="pass" placeholder="Password" required>
        </div> 
        <div class="opp-form">
          <label>Conferma Password</label>
          <input type="password" class="form-control" id="opp-res" name="confpass" placeholder="Conferma Password" required>
        </div>
        <div class="opp-form mt-2">
          <input type="submit" class="btn" id="reg-btn" name="register-button"  value="Registrati" style="background-color: blue; color: white;"> 
        </div>
    </form>
</div>

</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>