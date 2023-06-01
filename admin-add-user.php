<?php

/**
 * List all users with a link to edit
 */


require "config/config.php";
require "config/common.php";
require "config/limited.php";
require "config/limited-admin.php";

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
        "username" => $_POST['username'],
        "password"  => password_hash($_POST['password'], PASSWORD_BCRYPT),
        "grade"     => $_POST['grade'],
        "phone"       => $_POST['phone']
      );
  
      // if (empty($new_user[0]['id2'])) {
      //   unset($new_user['id2']);
      // };
  
      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "users",
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
        <title>Hopital de Viceroy - Home</title>
        <?php include 'inc/head.php'; ?>
    </head>
    <body>
        <?php include 'inc/navbar.php'; ?>
        <div class="container-xl mb-4">
        <div class="d-flex flex-row-reverse" style="margin: 20px;">
                <div class="p-2"><a class="btn btn-primary" href="admin.php" role="button"><i class="fas fa-undo-alt"> Retour</i></a></div>
            </div>
          <div class="col-6">
            <form method="post">
              <h4>Informations générales</h4>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-stethoscope"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom et nom de l'employé" name="username" value="">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-key"></i></div>
                <input type="password" class="form-control" id="autoSizingInputGroup" placeholder="Mot de passe" name="password">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-id-card-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Grade" name="grade">
              </div>
              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Numéro de téléphone" name="phone">
              </div>
              
              <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                </div>
              <br/>
              <button type="submit" name="submit" value="Submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
        <?php include 'inc/footer.php'; ?>
        <script type="text/javascript">
            $(function(){
  calPrice();
  $("input").on("change", function(){
    calPrice();
  });

  function calPrice(){
    var totalPrice = 0;
    $(".price_sum").each(function(){
      if ($(this).find("input").prop("checked")) {
        totalPrice += Number($(this).find("span").data("price"));
      }
    $(".price_display").text(totalPrice);
    });
  }
});
      </script>
    </body>
</html>