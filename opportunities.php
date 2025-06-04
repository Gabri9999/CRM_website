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

$stmts = $conn->query("SELECT * FROM azienda");
$stmt1 = $conn->query("SELECT * FROM cliente");  

$opportunities = [];
$convertedLeads = [];

$stmt = $conn->query("SELECT * FROM leads WHERE state = 'converted'");
$hasConvertedLead = false;
$convertedLeadId = null;

if($stmt->num_rows > 0){

  $hasConvertedLead = true;

  while($st = $stmt->fetch_assoc()){ 

  $convertedLeads[] = $st;   
  $convertedLeadId = $st["id_lead"];
  
  $stmt2 = $conn->prepare("SELECT * FROM opportunity WHERE leads = ?");
  $stmt2->bind_param('i', $convertedLeadId);
  $stmt2->execute();
  $result = $stmt2->get_result();

    while($opportunity = $result->fetch_assoc()) {
      $opportunities[] = $opportunity;
    }
  }
}



if(isset($_GET['id_opportunità'])){
    
  $id = $_GET['id_opportunità'];
  
  $statement = $conn->prepare("SELECT * FROM leads WHERE id_lead = ?");                   
  $statement->bind_param('i',$id);
  $statement->execute();
  $result1 = $statement->get_result();
  $col1 = $result1->fetch_assoc();

   

  $statement1 = $conn->prepare("SELECT * FROM azienda WHERE id_azienda = ?");                   
  $statement1->bind_param('i',$col1["azienda"]);
  $statement1->execute();
  $result = $statement1->get_result();
  $col = $result->fetch_assoc();


  
  $statement2 = $conn->prepare("SELECT * FROM cliente WHERE id_cliente = ?");                   
  $statement2->bind_param('i',$col["cliente"]);
  $statement2->execute();
  $results = $statement2->get_result();
  $cols = $results->fetch_assoc(); 
  

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
    
<?php
include("navbar.php");
?>


<div class="cont col-lg-9">
  <table class="table">
    <thead>
    <tr>
         <th>Probabilità di acquisto</th>
         <th>Data di chiusura</th>
         <th>Data di chiusura effettiva</th>
         <th>Guadagno</th>
         <th>Lead</th>
    </tr>   
  </thead>
  <tbody>

  <?php foreach($opportunities as $row){ ?>
    <tr>
       <td><?php echo $row["acquisition_probability"] . "%"; ?></td>
       <td><?php echo $row["closed_data"]; ?></td>
       <td><?php echo $row["effective_closed_data"]; ?></td>
       <td><?php echo $row["gain"] . "$"; ?></td>
       <td><?php echo $row["leads"]; ?></td>
       <td><button class="btn btn-primary" type="button" onclick="location.href='opportunities.php?id_opportunità=<?php echo $row['leads']; ?>'">Profilo</button></td>
    </tr>
  <?php } ?>
  </tbody>
   </table>
 </div>

</div>

<?php if ($hasConvertedLead): ?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Aggiungi Opportunità</h1>
      </div>
      <div class="modal-body">
        <div class="mx-auto container mt-5">

    <form method="POST" action="aggiungiOpportunità.php">
      <label>Lead</label>
  <select name="id">
  <?php foreach($convertedLeads as $st): ?> 
     <option value="<?php echo $st["id_lead"]; ?>"> 
        <?php echo $st["id_lead"]; ?>
     </option>
  <?php endforeach; ?>
</select>

      <input type="hidden" name="user_id" value="<?php echo $convertedLeadId ?>">
      <div class="opp-form mt-2">
          <label>Probabilità di acquisizione</label>
          <input type="number" class="form-control" id="opp-acq" name="acq" placeholder="%" >
        </div>
        <div class="opp-form">
          <label>Data di chiusura prevista</label>
          <input type="date" class="form-control" id="opp-chp" name="chp"  >
        </div> 
        <div class="opp-form">
          <label>Data di chiusura effettiva</label>
          <input type="date" class="form-control" id="opp-che" name="che"  >
        </div> 
        <div class="opp-form">
          <label>Guadagno dall'opportunità</label>
          <input type="number" class="form-control" id="opp-val" name="coh" placeholder="$">
        </div>
      <div class="modal-footer">  
        <div class="opp-form">
          <input type="submit" class="btn" id="close-btn" name="close-button" value="Close" style="background-color: blue; color: white;">
          <input type="submit" class="btn" id="edit-btn" name="add-button"  value="Add" style="background-color: blue; color: white;">
            </div>
          </div>
        </form>
      </div>
<?php else: ?>
  <p style="color: red; text-align: center;"> Nessun lead convertito disponibile. Non è possibile creare un'opportunità.</p>
<?php endif; ?>

   </div> 
  </div>
 </div>
</div>

<div class="modal fade" id="secondaryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="secondaryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="secondaryModalLabel">Profili Opportunità e Cliente</h1>
      </div>
      
      <div class="modal-body">
        <div class="mx-auto container mt-5">

       <?php if($cols) : ?>  

      <form method="POST" action="aggiornaOpportunità.php"> 

          <input type="hidden" name="id" value="<?php echo $row["id_opportunity"] ?>">     
            <div class="opp-form">
              <label>Probabilità di acquisizione</label>
              <input type="number" class="form-control" id="opp-acq-2" name="acq" placeholder="%" value="<?php echo $row["acquisition_probability"] ?>" >
            </div>
            
            <div class="opp-form">
              <label>Data di chiusura prevista</label>
              <input type="date" class="form-control" id="opp-chp-2" name="chp" value="<?php echo $row["closed_data"] ?>" >
            </div> 
            
            <div class="opp-form">
              <label>Data di chiusura effettiva</label>
              <input type="date" class="form-control" id="opp-che-2" name="che" value="<?php echo $row["effective_closed_data"] ?>" >
            </div> 
            
            <div class="opp-form">
              <label>Guadagno dall'opportunità</label>
              <input type="number" class="form-control" id="opp-val-2" name="val" placeholder="$" value="<?php echo $row["gain"]?>" >
            </div>

            <div class="modal-footer">  
              <div class="opp-form">
                <input type="submit" class="btn" id="close-btn" name="close-button" value="Close" style="background-color: blue; color: white;">
                <input type="submit" class="btn" id="edit-btn-2" name="edit-button" value="Edit" style="background-color: blue; color: white;"> 
              </div>
            </div>
          </form>
        </div>

        <div class="dropdown mt-2">
          <a class="nav-link dropdown-toggle" style="background-color: lightgrey;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu p-4 text-body-secondary" style="width: 100%;">
            <table>
              <tr><th>Nome</th><td><?php echo $cols["name"]; ?></td></tr>
              <tr><th>Cognome</th><td><?php echo $cols["surname"]; ?></td></tr>
              <tr><th>Telefono</th><td><?php echo $cols["phone"]; ?></td></tr>
              <tr><th>Email</th><td><?php echo $cols["email"]; ?></td></tr>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>



<?php else: ?>
    <p>Edit fallito.</p>
<?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    
    <?php if ($cols): ?>
      <script>
    var myModal = new bootstrap.Modal('#secondaryModal');
    myModal.show();
      </script>
    <?php endif; ?>  

  </body>
</html>