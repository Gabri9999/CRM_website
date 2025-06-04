  <nav class="navbar navbar-expand navbar-light nvb1" style="background-color: #708090">
    <div class="container-fluid">
      <img src="impostazioni/images/logodb4.png" class="img-fluid logo-img" style="margin-left: 10px;">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>  
      <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
  <div class="me-auto" style="margin-left: -200px;">
          <button type="button" class="btn btn-primary btn-lg btn1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Aggiungi +</button>
  </div>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
           <a class="button" href="index.php?logout=<?php echo $_SESSION['admin_id']; ?>">Logout</a>
         </li>  
           <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="index.php"><i class="fa fa-user-circle"></i></a>
          </li> 
          <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="#"><i class="fa fa-history"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="email.php"><i class="fa fa-envelope"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="row">
    <div class="col-lg-1">
  <nav class="navbar navbar-expand navbar-vertical nvb2">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php"><i class="fa fa-home"></i>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="leads.php"><i class="fa fa-users"></i>Leads</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link active" aria-current="page" href="opportunities.php"><i class="fa fa-handshake-o"></i>Opportunities</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true"><i class="fa fa-remove"></i>Disabled</a>
          </li>
        </ul>
      </div>
    </div> 
  </nav>
  <p style="color: red; mt-5;"> <?php if(isset($_GET["register"])) {  echo $_GET["register"]; } ?> </p>
</div>  