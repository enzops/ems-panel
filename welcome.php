<?php
require "config/limited.php";
require "config/config.php";

$imgname = $_SESSION["id"];
$userimg = "data/users/pictures/$imgname.png";

    $currentDirectory = getcwd();
    $uploadSignDirectory = "/data/users/signatures/";
    $uploadPicDirectory = "/data/users/pictures/";
    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['png']; // These will be the only file extensions allowed 

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));
    $fileName = new SplFileInfo($fileName);
    $fileext = $fileName->getExtension();
    $uploadSignPath = $currentDirectory . $uploadSignDirectory . $_SESSION["id"] . '.' . $fileext; 
    $uploadPicPath = $currentDirectory . $uploadPicDirectory . $_SESSION["id"] . '.' . $fileext; 
    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File exceeds maximum size (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadSignPath);

        if ($didUpload) {
        //   echo "The file " . basename($fileName) . " has been uploaded";
          echo '<div class="alert alert-success" role="alert">Votre signature a bien été uploadée</div>';
        } else {
          echo "An error occurred. Please contact the administrator.";
        }
      } else {
        foreach ($errors as $error) {
          echo $error . "These are the errors" . "\n";
        }
      }

    }
    if (isset($_POST['submitprofilpic'])) {
  
      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File exceeds maximum size (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPicPath);

        if ($didUpload) {
        //   echo "The file " . basename($fileName) . " has been uploaded";
          echo '<div class="alert alert-success" role="alert">Votre photo de profil a bien été uploadée</div>';
        } else {
          echo "An error occurred. Please contact the administrator.";
        }
      } else {
        foreach ($errors as $error) {
          echo $error . "These are the errors" . "\n";
        }
      }

    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Profil</title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xxl mb-8">
            <div class="d-flex flex-row-reverse" style="margin: 20px;">
              <?php if($_SESSION["UserLevel"] == "10") : ?>
              <div class="p-2"><a href="admin.php" class="btn btn-info"><i class="fas fa-crown"></i> Admin</a></div> 
              <?php endif; ?>
              <?php include 'inc/topbar-profile.php'; ?>
            </div>  
        <h1><?=_HELLO?>, <b><?php echo htmlspecialchars($_SESSION["UserName"]); ?> (<?=$_SESSION["UserId"]?>)</b>.</h1>

        <div class="row" style="margin-top: 20px;">
          <div class="col-sm-6">
            <div class="card border-primary mb-3" style="max-width: 80rem;">
              <div class="card-header">Vos informations</div>
              <div class="card-body">
                <div class="d-flex justify-content-center">
                  <img src="<?=$userimg?>" class="rounded-circle" alt="<?php echo htmlspecialchars($_SESSION["UserName"]); ?>" width="150"> 
                </div>
                <div class="d-flex justify-content-center" style="margin: 5px;">
                  <span class="badge bg-primary"><?=$WEBSITE_SETTINGS_NAME?></span>  
                </div>
                <h4 class="card-title"><?php echo htmlspecialchars($_SESSION["UserName"]); ?></h4>
                <h5>
                  <?php 
                    LoadDataRow('levels', 'level', $_SESSION["UserLevel"]);
                    echo $DataRow[1];
                  ?> (<?php echo htmlspecialchars($_SESSION["UserLevel"]); ?>)</h5>
                <span class="badge rounded-pill bg-danger"><i class="fas fa-mobile-alt"></i>  <?php echo htmlspecialchars($_SESSION["UserPhone"]); ?></span>
              </div>
            </div>
          </div>

        <br><br>

        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <strong>Mon profil</strong>
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
              <div class="accordion-body">
                <form action="welcome.php" method="post" enctype="multipart/form-data">
                <p>Uploadez votre photo de profil en <code>*.png</code> :</p>
                <input type="file" class="form-control-file" name="the_file" id="fileToUpload">
                <input class="btn btn-primary btn-sm" type="submit" name="submitprofilpic" value="Upload"/>
                </form>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <strong> Ma signature</strong>
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
              <div class="accordion-body">
                <img src="data/users/signatures/<?php echo htmlspecialchars($_SESSION["id"]); ?>.png" alt="Vous n'avez pas de signature"/><br><br>
                <form action="welcome.php" method="post" enctype="multipart/form-data">
                    <p>Uploadez votre signature en <code>*.png</code> :</p>
                    <input type="file" class="form-control-file" name="the_file" id="fileToUpload">
                    <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Upload"/>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- <h2>Votre signature</h2>
        Votre signature<br>
        <img src="img/signatures/<?php echo htmlspecialchars($_SESSION["username"]); ?>.png" alt="Vous n'avez pas de signature"/><br><br>
        <form action="welcome.php" method="post" enctype="multipart/form-data">
            Uploadez votre nouvelle signature en *.png:<br>
            <input type="file" class="form-control-file" name="the_file" id="fileToUpload">
            <input class="btn btn-primary btn-sm" type="submit" name="submit" value="Upload"/>
        </form> -->
        <br>
        </div>
              </div>
        <?php include 'inc/footer.php'; ?>
    </body>
</html>