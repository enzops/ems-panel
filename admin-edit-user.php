<?php

/**
 * List all users with a link to edit
 */


require "config/config.php";
require "config/common.php";
require "config/limited.php";
require "config/limited-admin.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "id"        => $_POST['id'],
      "username" => $_POST['username'],
      "created_at"     => $_POST['created_at'],
      "grade"       => $_POST['grade'],
      "phone"  => $_POST['phone']
    ];

     $sql = "UPDATE users 
             SET id = :id, 
               username = :username, 
               created_at = :created_at, 
               grade = :grade, 
               phone = :phone
             WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_POST['delete'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    
    $connection = new PDO($dsn, $username, $password, $options);

    $id = $_POST["id"];

    $sql = "DELETE FROM users WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "<div class='mb-4'><div class='alert alert-success' role='alert'> Row deleted !</div></div>";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Home</title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xl mb-4">
        <?php if (isset($_POST['submit']) && $statement) : ?>
                          <div class='mb-4'><div class='alert alert-success' role='alert'>Vous avez modifié le compte <?php echo($_POST['id']); ?></div></div>
        <?php endif; ?>
        <div class="d-flex flex-row-reverse" style="margin: 20px;">
                <div class="p-2"><a class="btn btn-primary" href="admin.php" role="button"><i class="fas fa-undo-alt"> Retour</i></a></div>
            </div>
          <div class="col-6">
            <form method="post">
              <h4>Informations générales</h4>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-info-circle"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="id" name="id" value="<?php echo $user['id']; ?>" readonly>
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-stethoscope"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom et nom de l'employé" name="username" value="<?php echo $user['username']; ?>">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Date de création" name="created_at" value="<?php echo $user['created_at']; ?>">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-id-card-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Grade" name="grade" value="<?php echo $user['grade']; ?>">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Numéro de téléphone" name="phone" value="<?php echo $user['phone']; ?>">
              </div>

              <br/>
              <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                </div>
              <br/>
              <button type="submit" name="submit" value="submit" class="btn btn-primary"><i class="fas fa-pen"></i> Editer</button>
              <button type="submit" name="delete" value="submit" class="btn btn-danger"><i class="fas fa-user-times"></i> Supprimer</button>
            </form>
          </div>
        <?php include 'inc/footer.php'; ?>
    </body>
</html>