<?php
require_once "config/config.php";
LoadAllRows('users');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Home</title>
        <?php include 'inc/head.php'; ?>
        <style>
.thumb-post img {
  object-fit: none; /* Do not scale the image */
  object-position: center; /* Center the image within the element */
  width: 100%;
  max-height: 250px;
  margin-bottom: 1rem;
}
        </style>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xl mb-4">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" style="margin-top: 50px;">
              <div class="carousel-item active">
                <img src="img/ca0.jpg" class="d-block mw-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/ca1.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="img/ca2.jpg" class="d-block w-100" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <div class="row" align="center">
            <div class="col-lg-12" style="margin: 10px;">
              <h1><?=_OUR_TEAM?></h1>
            </div>
            <?php foreach ($AllRows as $row) : ?>
              <?php 
              $imgname = $row["UserId"];
              $userimg = "data/users/pictures/$imgname.png";
              LoadDataRow('levels', 'level', $row["UserLevel"]);
              ?>
              <div class="col-lg-4">
              <?php if(file_exists($userimg)) : ?>
                <img src="data/users/pictures/<?php echo $row["UserId"]; ?>.png" class="rounded-circle" alt="<?php echo $row["UserName"]; ?>" width="150">
              <?php else : ?>
                <img src="data/website/default_pic.png" class="rounded-circle" alt="<?php echo $row["UserName"]; ?>" width="150">
              <?php endif; ?>
              <h2><?php echo $row["UserName"]; ?></h2>
              <p>
                <?php echo $DataRow[1]; ?><br/>
                <span class="badge bg-primary"><?php echo $row["UserPhone"]; ?></span>
              </p>
            </div><!-- /.col-lg-4 -->
            <?php endforeach; ?>
          </div>
        </div>
        <?php include 'inc/footer.php'; ?>
    </body>
</html>