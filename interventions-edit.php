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
    if ($_POST['reaville'] == "1") {
      $total+=200;
    }
    if ($_POST['reanord'] == "1") {
      $total+=200;
    }
    if ($_POST['imagerie'] == "1") {
      $total+=200;
    }
    if ($_POST['helico'] == "1") {
      $total+=200;
    }
    if ($_POST['petitsoin'] == "1") {
      $total+=200;
    }
    if ($_POST['grandsoin'] == "1") {
      $total+=200;
    }
    if ($_POST['petiteope'] == "1") {
      $total+=200;
    }
    if ($_POST['grosseope'] == "1") {
      $total+=200;
    }
    if ($_POST['prisesang'] == "1") {
      $total+=200;
    }
    if ($_POST['seancepsy'] == "1") {
      $total+=200;
    }
    
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "id"        => $_POST['id'],
      "patient" => $_POST['patient'],
      "doctor"  => $_POST['doctor'],
      "job"     => $_POST['job'],
      "cause"       => $_POST['cause'],
      "date"       => $_POST['date'],
      "reaville"  => $_POST['reaville'],
      "reanord"  => $_POST['reanord'],
      "imagerie"  => $_POST['imagerie'],
      "helico"  => $_POST['helico'],
      "petitsoin"  => $_POST['petitsoin'],
      "grandsoin"  => $_POST['grandsoin'],
      "petiteope"  => $_POST['petiteope'],
      "grosseope"  => $_POST['grosseope'],
      "prisesang"  => $_POST['prisesang'],
      "seancepsy"  => $_POST['seancepsy'],
      "total"  => $total,
      "commentaire"  => $_POST['commentaire'],
      "week"  =>  $curweek
    ];
    $curweek = date('W');
    $week = date('W');
     $sql = "UPDATE interventions 
             SET id = :id, 
               patient = :patient, 
               doctor = :doctor, 
               job = :job, 
               cause = :cause,
               date = :date,
               reaville = :reaville,
               reanord = :reanord,
               imagerie = :imagerie,
               helico = :helico,
               petitsoin = :petitsoin,
               grandsoin = :grandsoin,
               petiteope = :petiteope,
               grosseope = :grosseope,
               prisesang = :prisesang,
               seancepsy = :seancepsy,
               total = :total,
               commentaire = :commentaire,
               week = :week
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

    $sql = "SELECT * FROM interventions WHERE id = :id";
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
                          <div class='mb-4'><div class='alert alert-success' role='alert'>Vous avez modifié l'intervention <?php echo($_POST['id']); ?></div></div>
        <?php endif; ?>
        <div class="d-flex flex-row-reverse" style="margin: 20px;">
                <div class="p-2"><a class="btn btn-primary" href="interventions.php" role="button"><i class="fas fa-undo-alt"> Retour</i></a></div>
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
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom et nom du docteur" name="doctor" value="<?php echo $user['doctor']; ?>">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-user-injured"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom et nom du patient" name="patient" value="<?php echo $user['patient']; ?>">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="far fa-question-circle"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Cause" name="cause" value="<?php echo $user['cause']; ?>">
              </div>
              <div class='input-group' id='datetimepicker1' data-td-target-input='nearest' data-td-target-toggle='nearest' >
                <span class='input-group-text' data-td-target='#datetimepicker1' data-td-toggle='datetimepicker' >
                  <span class='fas fa-calendar'></span>
                </span>
                 <input id='datetimepicker1Input' type='text' class='form-control' data-td-target='#datetimepicker1' name="date" placeholder="Date d'aujourd'hui" value="<?php echo $user['job']; ?>"/>
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-briefcase"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Job" name="job" value="<?php echo $user['job']; ?>">
              </div>
              <h4 style="margin-top: 15px;">Services</h4>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="reaville" value="1" id="reaville" <?=($user["reaville"] == '1') ? 'checked' : '' ; ?>>
                <label class="form-check-label" for="reaville">
                  Réanimation ville
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="reanord" value="1" id="reanord" <?=($user["reanord"] == '1') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="reanord">
                Réanimation nord
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="imagerie" value="1" id="imagerie" <?=($user["imagerie"] == '1') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="imagerie">
                Imagerie
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="helico" value="1" id="helico" <?=($user["helico"] == '1') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="helico">
                Transport hélico
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="petitsoin" value="1" id="petitsoin" <?php echo ($user["petitsoin"] == '1') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="petitsoin">
                Petit soin
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="grandsoin" value="1" id="grandsoin" <?=($user["grandsoin"] == '1') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="grandsoin">
                Grand soin
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="petiteope" value="1" id="petiteope" <?=($user["petiteope"] == '1') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="petiteope">
                Petite opération
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="grosseope" value="1" id="grosseope" <?=($user["grosseope"] == '1') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="grosseope">
                Grosse opération
                </label>
              </div>
              <div class="form-check">
                <div class="price_sum">
                  <input class="form-check-input" type="checkbox" name="prisesang" value="1" id="prisesang" <?=($user["prisesang"] == '1') ? 'checked' : ''; ?>>
                  <span data-price="200"></span>
                  <label class="form-check-label" for="prisesang">
                  Prise de sang
                  </label>
                </div>
              </div>
              <div class="form-check">
                <div class="price_sum">
                  <input class="form-check-input" type="checkbox" name="seancepsy" value="1" id="seancepsy" <?=($user["seancepsy"] == '1') ? 'checked' : ''; ?>>
                  <span data-price="200"></span>
                  <label class="form-check-label" for="seancepsy">
                  Séance psy
                  </label>
                </div>
              </div>
              <br/>
              <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="commentaire" placeholder="Commentaire" value=""><?php echo $user['commentaire']; ?></textarea>
              <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                </div>
              <br/>
              <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <?php include 'inc/footer.php'; ?>
        <script type="text/javascript">
            new tempusDominus.TempusDominus(document.getElementById('datetimepicker1'), {
        display: {
          components: {
            useTwentyfourHour: true,
            decades: true,
            year: true,
            month: true,
            date: true,
            hours: false,
            minutes: false,
            seconds: false,
          }
        }
      });
      </script>
    </body>
</html>