<?php

include('server/connection.php'); 

session_start();


if (!isset($_SESSION["loggato"])){
   header("location: index.php");
   exit; 
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

$stmt1 = $conn->query("SELECT * FROM cliente"); 

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


<div class="mx-auto container mt-5" style="width: 300px">
    <form method="POST" action="send.php"> 
      
          <label>Email</label>
        <select name="email">
  <?php while ($row1 = $stmt1->fetch_assoc()): ?> 
     <option value="<?php echo $row1["email"]; ?>"> 
      <?php echo $row1["email"]; ?>
    </option>
  <?php endwhile; ?>
</select>
      
      <div class="opp-form mt-2">
          <label>Titolo</label>
          <input type="text" class="form-control" id="email-titolo" name="title" placeholder="Titolo" required>
      </div> 
      <div class="opp-form">
          <label>Testo</label>
          <textarea class="form-control" id="email-testo" name="textArea" placeholder="Inserisci Testo" required></textarea> 
        
      <div class="opp-form mt-2">
          <input type="submit" class="btn" id="email-btn" name="email-button"  value="Invia" style="background-color: blue; color: white;"> 
        </div>
    </form>
</div>

</body>