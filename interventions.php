<?php

/**
 * List all users with a link to edit
 */


require "config/config.php";
require "config/limited.php";

try {
    LoadAllRows('interventions');
  
} catch(PDOException $error) {
  echo $DB_INTER . "<br>" . $error->getMessage();
}
// Initialize the session
session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Home</title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-fluid mb-8">
            <div class="d-flex flex-row-reverse" style="margin: 20px;">
                <div class="p-2"><a class="btn btn-danger" href="" role="button"><i class="fas fa-minus"></i> Supprimer intervention</a></div>
                <div class="p-2"><a class="btn btn-success" href="interventions-add.php" role="button"><i class="fas fa-plus"></i> Ajouter intervention</a></div>
            </div>
        <table id="example" class="table" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Patient</th>
                <th>Médecin</th>
                <th>Metier</th>
                <th>Cause</th>
                <th>Date</th>
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
                <th>Total</th>
                <th>Commentaires</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($AllRows as $row) : ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["patient"]; ?></td>
                    <td><?php echo $row["doctor"]; ?></td>
                    <td><?php echo $row["job"]; ?></td>
                    <td><?php echo $row["cause"]; ?></td>
                    <td><?php echo $row["date"]; ?></td>
                    <td><?=($row["reaville"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["reanord"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["imagerie"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["helico"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["petitsoin"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["grandsoin"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["petiteope"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["grosseope"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["prisesang"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?=($row["seancepsy"] == '1') ? '✔️' : '❌'; ?></td>
                    <td><?php echo $row["total"]; ?></td>
                    <td><?php echo $row["commentaire"]; ?></td>
                    <td><a href="interventions-edit.php?id=<?php echo ($row["id"]); ?>" class="badge badge-primary"><i class="fas fa-pen"></i> Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Nom du patient</th>
                <th>Médecin</th>
                <th>Metier</th>
                <th>Cause</th>
                <th>Date</th>
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
                <th>Total</th>
                <th>Commentaires</th>
                <th>Action</th>
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