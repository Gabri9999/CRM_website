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

$stmt1 = $conn->query("SELECT * FROM cliente"); 

$id = $_SESSION["admin_id"];
$stmt = $conn->prepare("SELECT * FROM admin WHERE id_admin = ?"); 
$stmt->bind_param("i", $id); 
$stmt->execute();
$result = $stmt->get_result();

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
    
<?php
include("navbar.php");
?>


<div class="container-fluid mt-4">
  <div class="row">
    
    <div class="col-md-2"></div>

    
    <div class="col-md-8">
      <div class="card p-3 shadow-sm" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Profilo Amministratore</h4>
        </div>
        <div class="card-body">
          <table class="table table-sm">
            <tbody>
              <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                  <th style="width: 150px;">Nome</th>
                  <td><?php echo ($row["username"]); ?></td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td><?php echo ($row["email"]); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-4" style="max-width: 600px;">
        <h4 class="mb-3">Tasks Giornalieri</h4>
        <ul class="list-group">
          <li class="list-group-item d-flex align-items-center">
            <i class="fa fa-check-circle text-success me-2"></i> Modificare stato lead
          </li>
          <li class="list-group-item d-flex align-items-center">
            <i class="fa fa-envelope text-primary me-2"></i> Inviare un'email al cliente
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Aggiungi Cliente</h1>
      </div>
      <div class="modal-body">
        <div class="mx-auto container mt-5">
         

     <form method="POST" action="aggiungiAdmin.php">

      <div class="opp-form">
          <label>Nome</label>
          <input type="text" class="form-control" id="admin-acq" name="acq" placeholder="Nome">
        </div>
        <div class="opp-form">
          <label>Cognome</label>
          <input type="text" class="form-control" id="admin-chp" name="chp" placeholder="Cognome">
        </div> 
        <div class="opp-form">
          <label>Telefono</label>
          <input type="integer" class="form-control" id="admin-che" name="che" placeholder="Telefono">
        </div> 
        <div class="opp-form">
          <label>Email</label>
          <input type="text" class="form-control" id="admin-che" name="coh" placeholder="Email">
        </div>
      <div class="modal-footer">  
        <div class="opp-form">
          <input type="submit" class="btn" id="close-btn" name="close-button" value="Close" style="background-color: blue; color: white;">
          <input type="submit" class="btn" id="add-btn" name="add-button"  value="Add" style="background-color: blue; color: white;"> 
        </div>
      </div>
      
     </form>
    </div>
   </div> 
  </div>
 </div>
</div>

<div class="row">
    
    <div class="col-md-2"></div>
        <div class="cont col-md-8 mt-5">
    <h4 class="mb-3">Clienti</h4>
  <table class="table mx-auto">
    <thead>
    <tr>
         <th>ID_Cliente</th>
         <th>Nome</th>
         <th>Cognome</th>
         <th>Telefono</th>
         <th>Email</th>
    </tr>   
  </thead>
  <tbody>


  <?php while($row1 = $stmt1->fetch_assoc()){ ?>
    <tr>
       <td><?php echo $row1["id_cliente"]; ?></td>
       <td><?php echo $row1["name"]; ?></td>
       <td><?php echo $row1["surname"]; ?></td>
       <td><?php echo $row1["phone"]; ?></td>
       <td><?php echo $row1["email"]; ?></td>
    </tr>
  
  <?php } ?>

  </tbody>
     </table>
    </div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>
</html>