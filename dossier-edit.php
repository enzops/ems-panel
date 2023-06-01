<?php

/**
 * List all users with a link to edit
 */


require "config/config.php";
require "config/common.php";
require "config/limited.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
        
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
        "id"        => $_POST['id'],
        "name" => $_POST['name'],
        "job"  => $_POST['job'],
        "resus"     => $_POST['resus'],
        "situation"       => $_POST['situation'],
        "location"  => $_POST['location'],
        "phone"  => $_POST['phone'],
        "alcool"  => $_POST['alcool'],
        "tabac"  => $_POST['tabac'],
        "drogue"  => $_POST['drogue'],
        "allergies"  => $_POST['allergies'],
        "traitements"  => $_POST['traitements'],
        "antecedents"  => $_POST['antecedents'],
        "maladies"  => $_POST['maladies'],
        "notes"  => $_POST['notes']
    ];

     $sql = "UPDATE personnes 
             SET id = :id, 
               name = :name, 
               job = :job, 
               resus = :resus, 
               situation = :situation,
               location = :location,
               phone = :phone,
               alcool = :alcool,
               tabac = :tabac,
               drogue = :drogue,
               allergies = :allergies,
               traitements = :traitements,
               antecedents = :antecedents,
               maladies = :maladies,
               notes = :notes
             WHERE id = :id";
  
  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM personnes WHERE id = :id";
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
        <title>Hopital de Viceroy - Modification du dossier médical <?php echo $user['id']; ?></title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xl mb-4">
        <?php if (isset($_POST['submit']) && $statement) : ?>
                          <div class='mb-4'><div class='alert alert-success' role='alert'>Vous avez modifié le dossier médical <?php echo($_POST['id']); ?></div></div>
        <?php endif; ?>
        <div class="d-flex flex-row-reverse" style="margin: 20px;">
                <div class="p-2"><a class="btn btn-primary" href="dossiers.php" role="button"><i class="fas fa-undo-alt"> Retour</i></a></div>
            </div>
          <div class="col-6">
            <form method="post">
              <h4>Informations générales</h4>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-info-circle"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="id" name="id" value="<?php echo $user['id']; ?>" readonly>
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-user-injured"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom et nom du patient" name="name" value="<?php echo $user['name']; ?>">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Job" name="job" value="<?php echo $user['job']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-tint"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Groupe sanguin" name="resus" value="<?php echo $user['resus']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Situation" name="situation" value="<?php echo $user['situation']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-thumbtack"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Localisation" name="location" value="<?php echo $user['location']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Numéro de téléphone" name="phone" value="<?php echo $user['phone']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-wine-bottle"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Alcool" name="alcool" value="<?php echo $user['alcool']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-smoking"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Tabac" name="tabac" value="<?php echo $user['tabac']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-capsules"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Drogue" name="drogue" value="<?php echo $user['drogue']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Allergies" name="allergies" value="<?php echo $user['allergies']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-capsules"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Traitements" name="traitements" value="<?php echo $user['traitements']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-disease"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Antecedents" name="antecedents" value="<?php echo $user['antecedents']; ?>">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-viruses"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Maladies" name="maladies" value="<?php echo $user['maladies']; ?>">
              </div>
              </div>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="notes" placeholder="Notes" value=""><?php echo $user['notes']; ?></textarea>
              <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
              <button type="submit" name="submit" value="submit" class="btn btn-warning">Modifier le dossier médical</button>
            </form>
            </div>
        </div>
        <?php include 'inc/footer.php'; ?>
    </body>
</html>