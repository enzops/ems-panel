<?php 
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[2];
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary" aria-label="Ninth navbar example">
    <div class="container-xl">
      <a class="navbar-brand" href="index.php"><i class="fas fa-hospital-alt fa-lg"></i> <?=$WEBSITE_SETTINGS_NAME?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample07XL">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?php if ($first_part=="index.php") {echo "active"; } else  {echo "noactive";}?>" aria-current="page" href="index.php"><i class="fas fa-home"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($first_part=="interventions.php") {echo "active"; } else  {echo "noactive";}?>" aria-current="page" href="interventions.php"><i class="fas fa-calendar-plus"></i> Interventions</a>
          </li>
          <?php if($_SESSION["grade"] >= "5") : ?>
          <li class="nav-item">
            <a class="nav-link <?php if ($first_part=="certificate.php") {echo "active"; } else  {echo "noactive";}?>" aria-current="page" href="certificate.php"><i class="fa-solid fa-certificate"></i> <?=_CERTIFICATE?></a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a class="nav-link <?php if ($first_part=="dossiers.php") {echo "active"; } else  {echo "noactive";}?>" aria-current="page" href="dossiers.php"><i class="fas fa-folder-open"></i> <?=_MEDICAL_REC?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($first_part=="guide.php") {echo "active"; } else  {echo "noactive";}?>" aria-current="page" href="guide.php"><i class="fas fa-book-medical"></i> Guide</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($first_part=="list_files.php") {echo "active"; } else  {echo "noactive";}?>" href="list_files.php"><i class="fas fa-archive"></i> Archives</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0"
          <li class="nav-item">
            <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) : ?>
              <a class="nav-link <?php if ($first_part=="connexion.php") {echo "active"; } else  {echo "noactive";}?>" aria-current="page" href="connexion.php"><i class="fas fa-sign-in-alt"></i> <?=_LOG_IN?></a>
            <?php else : ?>
              <a class="nav-link <?php if ($first_part=="connexion.php") {echo "active"; } else  {echo "noactive";}?>" aria-current="page" href="connexion.php"><i class="fas fa-user"></i> <?=_MY_ACCOUNT?></a>
            <?php endif; ?>
          </li>
          </ul>
        <!-- <form>
          <input class="form-control" type="text" placeholder="Search" aria-label="Search">
        </form> -->
      </div>
    </div>
  </nav>