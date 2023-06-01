<?php

/**
 * List all users with a link to edit
 */


require "config/config.php";
require "config/common.php";
require "config/limited.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM interventions";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
if (isset($_POST['submit'])) {
    
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
  
    try  {

      $connection = new PDO($dsn, $username, $password, $options);
  
      $new_user = array(
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
      );
  
      // if (empty($new_user[0]['id2'])) {
      //   unset($new_user['id2']);
      // };
  
      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "personnes",
        implode(", ", array_keys($new_user)),
        ":" . implode(", :", array_keys($new_user))
      );
      
      $statement = $connection->prepare($sql);
      $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Création d'un dossier médical</title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xl mb-4">
        <div class="d-flex flex-row-reverse" style="margin: 20px;">
                <div class="p-2"><a class="btn btn-primary" href="dossiers.php" role="button"><i class="fas fa-undo-alt"> Retour</i></a></div>
            </div>
          <div class="col-6">
            <form method="post">
              <h4><i class="fas fa-star-of-david"></i> Informations générales</h4>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-user-injured"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom et nom du patient" name="name">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Job" name="job">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-tint"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Groupe sanguin" name="resus">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Situation" name="situation">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-thumbtack"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Localisation" name="location">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Numéro de téléphone" name="phone">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-wine-bottle"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Alcool" name="alcool">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-smoking"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Tabac" name="tabac">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-capsules"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Drogue" name="drogue">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Allergies" name="allergies">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-capsules"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Traitements" name="traitements">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-disease"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Antecedents" name="antecedents">
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-viruses"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Maladies" name="maladies">
              </div>

              <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="notes" placeholder="Notes"></textarea>
              <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                </div>
              <br/>
              <button type="submit" name="submit" value="Submit" class="btn btn-success">Créer le dossier</button>
            </form>

        </div>
        <?php include 'inc/footer.php'; ?>
    </body>
</html>