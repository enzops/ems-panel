<?php

/**
 * List all users with a link to edit
 */


require "config/config.php";
require "config/limited.php";

try {
  $sql = "SELECT * FROM personnes";

  $statement = $DB_DSN->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
// Initialize the session
session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hopital de Viceroy - Dossiers médicaux</title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xxl mb-8">
        <div class="container-fluid mb-8">
            <div class="d-flex flex-row-reverse" style="margin: 20px;">
                <div class="p-2"><a class="btn btn-success btn-sm" href="dossier-add.php" role="button"><i class="fas fa-plus"> Ajouter une personne</i></a></div>
            </div>
        <table id="example" class="table" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>Nom</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) : ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><a href="dossier-consult.php?id=<?php echo ($row["id"]); ?>" class="badge badge-primary"><i class="fas fa-folder-open"></i> Consulter</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>Nom</th>
                <th></th>
            </tr>
        </tfoot>
    </table> 
        </div>
            </div>
        <?php include 'inc/footer.php'; ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable();
            } );
      </script>
    </body>
</html>