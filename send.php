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

   $titolo = $_POST["title"];
   $text = $_POST["textArea"];
   $email = $_POST["email"];

   require "vendor/autoload.php"; 

   use PHPMailer\PHPMailer\PHPMailer; 
   use PHPMailer\PHPMailer\SMTP;

   $phpmailer = new PHPMailer(true);

   $phpmailer->STMPDebug = SMTP::DEBUG_SERVER;

   $phpmailer->isSMTP();
   $phpmailer->SMTPAuth = false;
   $phpmailer->SMTPSecure = false;
   $phpmailer->Host = "smtp.freesmtpservers.com";
   $phpmailer->Port = 25;

   $phpmailer->Subject = $titolo;
   $phpmailer->Body = $text;

   $phpmailer->setFrom($_SESSION["admin_email"]);
   $phpmailer->addAddress($email); 
   $phpmailer->send();
    
   header("location: sent.php");

?>