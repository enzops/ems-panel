<?php
uploadprofilpic(){
    $currentDirectory = getcwd();
    $ProfilPicDir = "/img/signatures/";

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['png']; // These will be the only file extensions allowed 

    $ProfilPicName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$ProfilPicName)));
    $ProfilPicName = new SplFileInfo($fileName);
    $fileext = $ProfilPicName->getExtension();
    $uploadPath = $currentDirectory . $ProfilPicDir . $_SESSION["username"] . '.' . $fileext; 

    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File exceeds maximum size (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

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

}
?>