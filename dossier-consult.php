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

     $sql = "UPDATE interventions 
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

/// TEST ///
$name = $user['name'];
$numticket = $DB_DSN->prepare('SELECT * FROM interventions WHERE patient = :name');
$numticket->bindValue(':name', $name);
$numticket->execute();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Consultation du dossier <?php echo $user['id']; ?></title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xl mb-4">
        <div class="d-flex flex-row-reverse" style="margin: 20px;">
            <div class="p-2"><a class="btn btn-warning" href="dossier-edit.php?id=<?php echo $user['id']; ?>" role="button"><i class="fas fa-pen"> Editer</i></a></div>
            <div class="p-2"><a class="btn btn-primary" href="dossiers.php" role="button"><i class="fas fa-undo-alt"> Retour</i></a></div>
        </div>
        <div class="card border-primary mb-3" style="max-width: 500rem;">
            <div class="card-header">Consultation du dossier n° <?php echo $user['id']; ?></div>
            <div class="card-body">
                <h4 class="card-title"><?php echo $user['name']; ?></h4>
                <p class="card-text"></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Job :</b> <?php echo $user['job']; ?></li>
                <li class="list-group-item"><b>Groupe sanguin :</b> <?php echo $user['resus']; ?></li>
                <li class="list-group-item"><b>Situation :</b> <?php echo $user['situation']; ?></li>
                <li class="list-group-item"><b>Localisation :</b> <?php echo $user['location']; ?></li>
                <li class="list-group-item"><b>Numéro de téléphone :</b> <?php echo $user['phone']; ?></li>
                <li class="list-group-item"><b>Alcool :</b> <?php echo $user['alcool']; ?></li>
                <li class="list-group-item"><b>Tabac :</b> <?php echo $user['tabac']; ?></li>
                <li class="list-group-item"><b>Drogue :</b> <?php echo $user['drogue']; ?></li>
                <li class="list-group-item"><b>Allergies :</b> <?php echo $user['allergies']; ?></li>
                <li class="list-group-item"><b>Traitements :</b> <?php echo $user['traitements']; ?></li>
                <li class="list-group-item"><b>Antecedents :</b> <?php echo $user['antecedents']; ?></li>
                <li class="list-group-item"><b>Maladies :</b> <?php echo $user['maladies']; ?></li>
                <li class="list-group-item"><b>Notes :</b> <?php echo $user['notes']; ?></li>
            </ul>
        </div>
        <table id="example" class="table" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Médecin</th>
                <th>Metier</th>
                <th>Cause</th>
                <th>Réa ville</th>
                <th>Réa nord</th>
                <th>Imagerie</th>
                <th>Hélico</th>
                <th>Petit soin</th>
                <th>Grand soin</th>
                <th>Petite opération</th>
                <th>Grosse opération</th>
                <th>Prise de sang</th>
                <th>Séance psy</th>
                <th>Commentaires</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($numticket as $inters) : ?>
                <tr>
                    <td><?php echo $inters["id"]; ?></td>
                    <td><?php echo $inters["doctor"]; ?></td>
                    <td><?php echo $inters["job"]; ?></td>
                    <td><?php echo $inters["cause"]; ?></td>
                    <td><?=($inters["reaville"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["reanord"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["imagerie"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["helico"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["petitsoin"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["grandsoin"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["petiteope"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["grosseope"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["prisesang"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($inters["seancepsy"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?php echo $inters["commentaire"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Médecin</th>
                <th>Metier</th>
                <th>Cause</th>
                <th>Réa ville</th>
                <th>Réa nord</th>
                <th>Imagerie</th>
                <th>Hélico</th>
                <th>Petit soin</th>
                <th>Grand soin</th>
                <th>Petite opération</th>
                <th>Grosse opération</th>
                <th>Prise de sang</th>
                <th>Séance psy</th>
                <th>Commentaires</th>
            </tr>
        </tfoot>
    </table> 
        </div>
        <?php include 'inc/footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable( {
                    "order": [[ 0, "desc" ]],
                    "pageLength": 50
                } );
            } );
      </script>
    </body>
</html>