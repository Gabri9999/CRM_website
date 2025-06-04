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

$stmt = $conn->query("SELECT * FROM azienda"); 
$stmt1 = $conn->query("SELECT * FROM cliente"); 




  if (isset($_GET['id_azienda'])) {
    $id = $_GET['id_azienda'];

    
    $statement = $conn->prepare("SELECT * FROM azienda WHERE id_azienda = ?");
    $statement->bind_param('i', $id);
    $statement->execute();
    $result = $statement->get_result();
    $col = $result->fetch_assoc();

    
    $statement1 = $conn->prepare("SELECT * FROM leads WHERE azienda = ?");
    $statement1->bind_param('i', $id);
    $statement1->execute();
    $results = $statement1->get_result();
    $cols = $results->fetch_assoc();

}  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="impostazioni/css/style.css">
</head>
<body>
    
<?php
include("navbar.php");
?>

<div class="cont col-lg-9">
  <table class="table">
    <thead>
    <tr>
         <th>Nome</th>
         <th>Indirizzo</th>
         <th>Email</th>
         <th>Cliente</th>
    </tr>   
  </thead>
  <tbody>
 
  <?php while($row = $stmt->fetch_assoc()){ ?>
    <tr>
       <td><?php echo $row["name"]; ?></td>
       <td><?php echo $row["address"]; ?></td>
       <td><?php echo $row["email"]; ?></td>
       <td><?php echo $row["cliente"]; ?></td>
       <td><button class="btn btn-primary" type="button" onclick="location.href='leads.php?id_azienda=<?php echo $row['id_azienda']; ?>'">Lead</button></td>
    </tr>
  
<?php } ?>  
</tbody>
     </table>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Aggiungi Azienda</h1>
      </div>
      <div class="modal-body">
        <div class="mx-auto container mt-5">       
     
  <form method="POST" action="aggiungiLead.php">
    <label>Cliente</label>
<select name="id">
  <?php while ($row1 = $stmt1->fetch_assoc()): ?> 
     <option value="<?php echo $row1["id_cliente"]; ?>"> 
      <?php echo $row1["name"]; ?>
      <?php echo $row1["surname"]; ?>
    </option>
  <?php endwhile; ?>
</select>
      <div class="opp-form mt-2">
          <label>Nome</label>
          <input type="text" class="form-control" id="lead-acq" name="acq" placeholder="Nome">
        </div>
        <div class="opp-form">
          <label>Indirizzo</label>
          <input type="text" class="form-control" id="lead-chp" name="chp" placeholder="Indirizzo">
        </div> 
        <div class="opp-form">
          <label>Email</label>
          <input type="text" class="form-control" id="lead-che" name="che" placeholder="Email">
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


<div class="offcanvas offcanvas-end" style="width: 800px;" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Profilo Azienda</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    <?php if ($cols): ?>
        <div class="cont1 container mt-5">
                  <table>
                      <tr>
                          <th>Nome</th>
                          <th>Indirizzo</th>
                          <th>Email</th>
                      </tr>
                      <tr>
                        <td><?php echo $col["name"]; ?></td>
                        <td><?php echo $col["address"]; ?></td>
                        <td><?php echo $col["email"]; ?></td>
          <form action="aggiornaStatoLead.php" method="POST">
                      <input type="hidden" name="user_id" value="<?php echo $cols["id_lead"] ?>">
                        <td>            
                          <select class="form-select" style="width: 100px; margin-left: 200px;" name="user_status" aria-label="Default select example">
                            <option value="email sent" <?php if(isset($cols) && $cols["state"]=="email sent") echo "selected"; ?> >Email Inviata</option>
                            <option value="not contacted" <?php if(isset($cols) && $cols["state"]=="not contacted") echo "selected"; ?> >Non Contattato</option>
                            <option value="contacted" <?php if(isset($cols) && $cols["state"]=="contacted") echo "selected"; ?> >Contattato</option>
                            <option value="converted" <?php if(isset($cols) && $cols["state"]=="converted") echo "selected"; ?> >Convertito</option>
                          </select>
                        </td>
                        <td><input type="submit" class="btn" id="edit-btn" name="update-button"  value="Update" style="background-color: blue; color: white;"></td>
                       </form>
                      </tr>
                  </table>   
              </div>
        <div class="container text-center">
          <div class="row">
                  <div class="col border">Email sent</div>
                  <div class="col border">Not Contacted</div>
                  <div class="col border">Contacted</div>
                  <div class="col border">Converted</div>
          </div>      
        </div> 
      <div class="dropdown mt-2">
        <a class="nav-link dropdown-toggle" style="background-color: lightgrey;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu p-4 text-body-secondary" style="width: 100%;">
          <table>
            <tr>
              <th>ID Lead</th>
              <td><?php echo $cols["id_lead"]; ?></td>
            </tr>
              <th>Lead Status</th>
              <td style="background-color: yellow;" ><?php echo $cols["state"];?></td>
            </tr>   
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php else: ?>
    <p>Nessun profilo selezionato.</p>
  <?php endif; ?>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    
    <?php if ($cols): ?>
  <script>
    const offcanvas = new bootstrap.Offcanvas('#offcanvasRight');
    offcanvas.show();
  </script>
<?php endif; ?>

</body>
</html>