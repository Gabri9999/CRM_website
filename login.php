<?php

include('server/connection.php'); 

session_start();


if (isset($_SESSION["loggato"])){
   header("location: index.php");
   exit; 
}

if(isset($_POST["login-button"])){

    $email = $_POST["email"];
    $password = $_POST["pass"];
    $hashed_password = md5($password);
    
    $statement = $conn->prepare("SELECT id_admin, username, password, email FROM admin WHERE email = ? AND password =?");
    $statement->bind_param("ss",$email,$hashed_password);
   
    if($statement->execute()){
        $statement->bind_result($admin_id,$admin_username,$admin_password,$admin_email);
        $statement->store_result();
         
         if($statement->num_rows()==1){
           $statement->fetch();
        $_SESSION["admin_id"] = $admin_id;   
        $_SESSION["admin_username"] = $admin_username;
        $_SESSION["admin_email"] = $admin_email;
        $_SESSION["loggato"] = true;
        header("location: index.php");
         }
    } else {
        header("location: login.php?error=session error");
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
    
    <form id="login-form" method="POST" action="login.php">
      <p style="color: red"> <?php if(isset($_GET["error"])) { echo $_GET["error"]; } ?> </p>
      <p style="color: green"> <?php if(isset($_GET["success"])) { echo $_GET["success"]; } ?> </p>
        <div class="opp-form">
          <label>Email</label>
          <input type="text" class="form-control" id="opp-chp" name="email" placeholder="Email" >
        </div> 
        <div class="opp-form">
          <label>Password</label>
          <input type="password" class="form-control" id="opp-che" name="pass" placeholder="Password" >
        </div> 
        
        <div class="opp-form mt-2">
          <input type="submit" class="btn" id="log-btn" name="login-button"  value="Login" style="background-color: blue; color: white;"> 
        </div>
    </form>
    <div class="mt-2">
    <label>Non ti sei registrato?</label>
    </div>
        <div class="mt-2">
          <a href="registration.php"><input type="submit" class="btn" id="register-btn" name="register-button"  value="Registrati" style="background-color: blue; color: white;"></a> 
        </div>
</div>

</body>