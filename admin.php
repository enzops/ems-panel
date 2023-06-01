<?php
require "config/config.php";
require "config/limited.php";
require "config/limited-admin.php";


// EDIT USER
if (isset($_GET['edituser']) and isset($_GET['id'])) {
  LoadDataRow('users', 'UserId', $_GET['id']);

  if (isset($_POST['submitedit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    if (!isset($_POST['user_status'])){
        $_POST['user_status'] = "0";
    };

    if (!isset($_POST['user_admin'])){
        $_POST['user_admin'] = "0";
    };

    $User =[
      "user_id"         => $_POST['user_id'],
      "user_name"       => $_POST['user_name'],
      "user_phone"      => $_POST['user_phone'],
      "user_admin"      => $_POST['user_admin'],
      "user_created"    => $_POST['user_created'],
      "user_level"      => $_POST['user_level'],
      "user_status"     => $_POST['user_status']
    ];

    $sql = "UPDATE users 
            SET  UserName = :user_name, 
            UserPhone = :user_phone, 
            UserAdmin = :user_admin,
            UserCreated = :user_created,
            UserLevel = :user_level,
            UserStatus = :user_status
            WHERE UserId = :user_id";

    // Check if username is empty
    if(empty(trim($_POST["user_name"]))){
      $message = "Please enter username.";
      $messagetype = "danger";
    } else{
      $statement = $DB_DSN->prepare($sql);
      $statement->execute($User);
    }
        
    if ($statement) {
      LoadDataRow('users', 'UserId', $_GET['id']);
      $message = "User informations edited.";
      $messagetype = "success";
    }
  }
}



// EDIT USER PW
if (isset($_GET['edituserpw']) and isset($_GET['id'])) {
  LoadDataRow('users', 'UserId', $_GET['id']);
  
  if (isset($_POST['submiteditpw'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    $user =[
      "user_id"           => $_POST['user_id'],
      "user_name"         => $_POST['user_name'],
      "user_password"     => password_hash($_POST['user_password'], PASSWORD_BCRYPT)
    ];
        
    $sql = "UPDATE users 
            SET UserPassword = :user_password,
            UserName = :user_name
            WHERE UserId = :user_id";

    // Check if password is empty
    if(empty(trim($_POST["user_password"]))){
      $message = "Please enter password.";
      $messagetype = "danger";
    } else{
      $statement = $DB_DSN->prepare($sql);
      $statement->execute($user);
    }

    if ($statement) {
      LoadDataRow('users', 'UserId', $_GET['id']);
      $message = "User password edited.";
      $messagetype = "success";
    }
  }
}




// ADD USER
if (isset($_POST['submitadd'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  // date_default_timezone_set('Europe/Paris');
  // $date = date('Y-m-d h:i:s a', time());

    if (!isset($_POST['user_status'])){
        $_POST['user_status'] = "0";
    };

    if (!isset($_POST['user_admin'])){
        $_POST['user_admin'] = "0";
    };

    $new_user =[
        "UserName"          => $_POST['user_name'],
        "UserPassword"      => password_hash($_POST['user_password'], PASSWORD_BCRYPT),
        "UserPhone"         => $_POST['user_phone'],
        "UserLevel"         => $_POST['user_level'],
        "UserAdmin"         => $_POST['user_admin'],
        "UserStatus"        => $_POST['user_status']
    ];

    $NewUserSQL = "INSERT INTO users (UserName, UserPassword, UserPhone, UserLevel, UserAdmin, UserStatus) VALUES (:UserName, :UserPassword, :UserPhone, :UserLevel, :UserAdmin, :UserStatus)";
      
    $statement = $DB_DSN->prepare($NewUserSQL);
    $statement->execute($new_user);

    header('Location: '.$_SERVER['PHP_SELF']);
    if ($statement) {
      LoadDataRow('users', 'UserId', $_GET['id']);
      $message = "User created.";
      $messagetype = "success";
    }      
}




// DELETE USER
if (isset($_GET['deluser']) and isset($_GET['id'])) {

  $id = $_GET['id'];

  $sql = "DELETE FROM users WHERE UserId = :id";

  $statement = $DB_DSN->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();

  if ($statement) {
    LoadDataRow('users', 'UserId', $_GET['id']);
    $message = "User deleted.";
    $messagetype = "success";
  }
}


// EDIT LEVEL
if (isset($_GET['editlevel']) and isset($_GET['id'])) {
  LoadDataRow('levels', 'LevelId', $_GET['id']);

  if (isset($_POST['submiteditlevel'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    $Level =[
      "level_id"         => $_POST['level_id'],
      "level_name"       => $_POST['level_name'],
      "level"            => $_POST['level']
    ];

    $EditLevelSQL = "UPDATE levels 
            SET  LevelName = :level_name, 
            Level = :level
            WHERE LevelId = :level_id";

    // Check if username is empty
    if(empty(trim($_POST["level_name"]))){
      $message = "Please enter level name.";
      $messagetype = "danger";
    } else{
      $statement = $DB_DSN->prepare($EditLevelSQL);
      $statement->execute($Level);
    }
        
    if ($statement) {
      LoadDataRow('levels', 'LevelId', $_GET['id']);
      $message = "level edited.";
      $messagetype = "success";
    }
  }
}




// DELETE LEVEL
if (isset($_GET['dellevel']) and isset($_GET['id'])) {

  $id = $_GET['id'];

  $sql = "DELETE FROM levels WHERE LevelId = :id";

  $statement = $DB_DSN->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();

  if ($statement) {
    LoadDataRow('levels', 'LevelId', $_GET['id']);
    $message = "Level deleted.";
    $messagetype = "success";
  }
}



// ADD Level
if (isset($_POST['submitaddlevel'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    $new_level =[
        "LevelName"          => $_POST['level_name'],
        "Level"         => $_POST['level']
    ];

    $NewLevelSQL = "INSERT INTO levels (LevelName, Level) VALUES (:LevelName, :Level)";
      
    $statement = $DB_DSN->prepare($NewLevelSQL);
    $statement->execute($new_level);

    header('Location: '.$_SERVER['PHP_SELF']);
    if ($statement) {
      LoadDataRow('levels', 'LevelId', $_GET['id']);
      $message = "Level created.";
      $messagetype = "success";
    }      
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Hopital de Viceroy - Admin</title>
  <?php include 'inc/head.php'; ?>
  </head>
    <body>
      <?php include 'inc/navbar.php'; ?>
      <div class="container-xxl mb-8">
        <div class="d-flex flex-row-reverse" style="margin: 20px;">
        <?php if(isset($_GET['edituser']) or isset($_GET['edituserpw']) or isset($_GET['adduser']) or isset($_GET['editlevel'])) : ?>
          <div class="p-2"><a href="admin.php" class="btn btn-info"><i class="fas fa-chevron-left"></i> Retour au panel admin</a></div> 
        <?php else : ?>
          <div class="p-2"><a href="welcome.php" class="btn btn-info"><i class="fas fa-chevron-left"></i> Retour au profil</a></div> 
        <?php endif; ?>
          <?php include 'inc/topbar-profile.php'; ?>
        </div>
        

        <?php if(isset($message)) : ?>

        <div class="alert alert-<?=$messagetype?> alert-dismissible fade show" role="alert">
          <strong><?php echo $DataRow['UserName']; ?> (<?php echo $DataRow['UserId']; ?>) -</strong> <?=$message?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <?php endif;?>


        
        <!-- EDIT USER -->
        <?php if(isset($_GET['edituser'])) : ?>
          <div class="col-6">
            <form method="post">
            <h4><?php echo $DataRow['UserName']; ?> - Edit user</h4>

              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fa fa-info-circle fa-fw"></i></span>
                <input class="form-control" type="text" name="user_id" placeholder="id" value="<?php echo $DataRow['UserId']; ?>" readonly>
                <input name="csrf" type="hidden" value="<?=$_SESSION['csrf']?>">
              </div>

              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                <input type="text" class="form-control" placeholder="Prénom et nom de l'employé" name="user_name" value="<?php echo $DataRow['UserName']; ?>">
              </div>

              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                <input type="text" class="form-control" placeholder="Date de création" name="user_created" value="<?php echo $DataRow['UserCreated']; ?>">
              </div>

              <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                <select class="form-select" id="user_level" name="user_level" type="text" placeholder="LEVEL" value="">
                  <?php LoadAllRows('levels'); ?>
                  <?php foreach ($AllRows as $row) : ?>
                      <option value="<?=$row["Level"]?>" <?php if($DataRow["UserLevel"] == $row["Level"]) echo"selected"; ?>><?=$row["LevelName"]?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Numéro de téléphone" name="user_phone" value="<?php echo $DataRow['UserPhone']; ?>">
              </div>

              <div class="mb-0">
                <div class="form-check mb-2">
                    <input class="form-check-input" name="user_admin" value="1" id="user_admin" type="checkbox" <?=($DataRow["UserAdmin"] == '1') ? 'checked=""' : '' ; ?>>
                    <label class="form-check-label" for="user_admin">Admin</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" name="user_status" value="1" id="user_status" type="checkbox" <?=($DataRow["UserStatus"] == '1') ? 'checked=""' : '' ; ?>>
                    <label class="form-check-label" for="user_status">Status</label>
                </div>
              </div>
            </div>

              <button type="submit" name="submitedit" value="submitedit" class="btn btn-primary"><i class="fas fa-pen"></i> Editer</button>
            </form>
          </div>


        <!-- EDIT USER PASSWORD -->
        <?php elseif(isset($_GET['edituserpw'])) : ?>
          <div class="col-4">
            <form method="post">
              <h4><?php echo $DataRow['UserName']; ?> - Edit password</h4>
              
              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fa fa-info-circle fa-fw"></i></span>
                <input class="form-control" type="text" name="user_id" placeholder="id" value="<?php echo $DataRow['UserId']; ?>" readonly>
                <input name="csrf" type="hidden" value="<?=$_SESSION['csrf']?>">
              </div>
              
              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fa fa-user fa-fw"></i></span>
                <input class="form-control" type="text" name="user_name" placeholder="user_name" value="<?php echo $DataRow['UserName']; ?>" readonly>
              </div>

              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                <input class="form-control" type="password" name="user_password" placeholder="New password" value="">
              </div>

              <br/>
              <button type="submit" name="submiteditpw" value="submiteditpw" class="btn btn-primary"><i class="fas fa-pen"></i> Editer</button>
            </form>
          </div>
        


        <!-- ADD USER -->
        <?php elseif(isset($_GET['adduser'])) : ?>
          <div class="col-6">
            <form method="post">
            <h4>Add user</h4>

              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                <input type="text" class="form-control" placeholder="Prénom et nom de l'employé" name="user_name" value="">
                <input name="csrf" type="hidden" value="<?=$_SESSION['csrf']?>">
              </div>

              <div class="input-group">
                <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                <input class="form-control" type="password" name="user_password" placeholder="New password" value="">
              </div>

              <div class="input-group">
              <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                <select class="form-select" id="user_level" name="user_level" type="text" placeholder="LEVEL" value="">
                  <?php LoadAllRows('levels'); ?>
                  <?php foreach ($AllRows as $row) : ?>
                      <option value="<?=$row["Level"]?>" <?php if($DataRow["UserLevel"] == $row["Level"]) echo"selected"; ?>><?=$row["LevelName"]?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="input-group">
                <div class="input-group-text"><i class="fas fa-mobile-alt"></i></div>
                <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Numéro de téléphone" name="user_phone" value="">
              </div>

              <div class="mb-0">
                <div class="form-check mb-2">
                    <input class="form-check-input" name="user_admin" value="1" id="user_admin" type="checkbox">
                    <label class="form-check-label" for="user_admin">Admin</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" name="user_status" value="1" id="user_status" type="checkbox">
                    <label class="form-check-label" for="user_status">Status</label>
                </div>
              </div>
            </div>

              <button type="submit" name="submitadd" value="submitadd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
            </form>
          </div>




        <!-- EDIT LEVEL -->
        <?php elseif(isset($_GET['editlevel'])) : ?>
          <div class="col-6">
            <form method="post">
            <h4><?php echo $DataRow['LevelName']; ?> - Edit level</h4>

              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fa fa-info-circle fa-fw"></i></span>
                <input class="form-control" type="text" name="level_id" placeholder="id" value="<?php echo $DataRow['LevelId']; ?>" readonly>
                <input name="csrf" type="hidden" value="<?=$_SESSION['csrf']?>">
              </div>

              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                <input type="text" class="form-control" placeholder="Prénom et nom de l'employé" name="level_name" value="<?php echo $DataRow['LevelName']; ?>">
              </div>

              <div class="input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fa-solid fa-arrow-down-1-9"></i></span>
                <input type="text" class="form-control" placeholder="Date de création" name="level" value="<?php echo $DataRow['Level']; ?>">
              </div>
            </div>

              <button type="submit" name="submiteditlevel" value="submiteditlevel" class="btn btn-primary"><i class="fas fa-pen"></i> Editer</button>
            </form>
          </div>



        <!-- ADD Level -->
        <?php elseif(isset($_GET['addlevel'])) : ?>
          <div class="col-6">
            <form method="post">
            <h4>Add level</h4>

              <div class="input-group margin-bottom-sm">
                  <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                  <input type="text" class="form-control" placeholder="Level Name" name="level_name" value="">
                  <input name="csrf" type="hidden" value="<?=$_SESSION['csrf']?>">
                </div>

                <div class="input-group margin-bottom-sm">
                  <span class="input-group-text"><i class="fa-solid fa-arrow-down-1-9"></i></span>
                  <input type="text" class="form-control" placeholder="Level" name="level" value="">
                </div>
              </div>

              <button type="submit" name="submitaddlevel" value="submitaddlevel" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
            </form>
          </div>




        <!-- DEFAULT PAGE -->
        <?php else : ?>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#users"><i class="fas fa-user"></i> <?=_USERS?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#levels"><i class="fas fa-users"></i> <?=_LEVELS?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#settings"><i class="fa-solid fa-sliders"></i> Paramètres </a>
          </li>
        </ul>
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane fade active show" id="users">
            <div class="d-flex flex-row-reverse">
                <div class="p-2"><a href="admin.php?adduser" class="btn btn-success ml-3 btn-sm"><i class="fas fa-user-plus"></i> Ajouter un employé</a></div>
            </div>
            <table id="userstable" class="table" style="width:100%;">
              <thead>
                  <tr>
                      <th>id</th>
                      <th><?=_NAME?></th>
                      <th><?=_LEVEL?></th>
                      <th><?=_ACTIONS?></th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    LoadAllRows('users');
                    foreach ($AllRows as $row) : 
                  ?>
                      <tr>
                          <td><?php echo $row["UserId"]; ?></td>
                          <td><?php echo $row["UserName"]; ?></td>
                          <td><?php echo $row["UserLevel"]; ?></td>
                          <td>
                            <a href="admin.php?edituser&id=<?php echo ($row["UserId"]); ?>" class="btn btn-outline-warning btn-sm"><i class="fas fa-pen"></i> Edit user</a> 
                            <a href="admin.php?edituserpw&id=<?php echo ($row["UserId"]); ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-key"></i> Edit password</a>
                            <a href="admin.php?deluser&id=<?php echo ($row["UserId"]); ?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-user-xmark"></i> Delete</a> 
                          </td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
              <tfoot>
                  <tr>
                      <th>id</th>
                      <th><?=_NAME?></th>
                      <th><?=_LEVEL?></th>
                      <th><?=_ACTIONS?></th>
                  </tr>
              </tfoot>
            </table>
          </div>

          <div class="tab-pane fade" id="levels">
            <div class="d-flex flex-row-reverse">
                <div class="p-2"><a href="admin.php?addlevel" class="btn btn-success ml-3 btn-sm"><i class="fa-solid fa-id-card-clip"></i> Add level</a></div>
            </div>
            <table id="levelstable" class="table" style="width:100%;">
              <thead>
                  <tr>
                      <th>id</th>
                      <th><?=_NAME?></th>
                      <th><?=_LEVEL?></th>
                      <th><?=_ACTIONS?></th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                    LoadAllRows('levels'); 
                    foreach ($AllRows as $row) : 
                  ?>
                      <tr>
                          <td><?php echo $row["LevelId"]; ?></td>
                          <td><?php echo $row["LevelName"]; ?></td>
                          <td><?php echo $row["Level"]; ?></td>
                          <td>
                          <a href="admin.php?editlevel&id=<?php echo ($row["LevelId"]); ?>" class="btn btn-outline-warning btn-sm"><i class="fas fa-pen"></i> Edit level</a>
                          <a href="admin.php?dellevel&id=<?php echo ($row["LevelId"]); ?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-user-xmark"></i> Delete level</a>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
              <tfoot>
                  <tr>
                      <th>id</th>
                      <th><?=_NAME?></th>
                      <th><?=_LEVEL?></th>
                      <th><?=_ACTIONS?></th>
                  </tr>
              </tfoot>
            </table>
          </div>
                

          <div class="tab-pane fade" id="settings">
            <form class="needs-validation" novalidate>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01"><?=_WEBSITE_NAME?></label>
                  <input type="text" class="form-control" id="validationCustom01" value="<?=$WEBSITE_SETTINGS_NAME?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-3 mb-3">
                  <label for="validationCustom04">Langs</label>
                  <select class="custom-select" id="validationCustom04" required>
                  <?php ScanLangs(); ?>
                  <?php foreach ($LANGS as $row) : ?>
                      <option value="<?=$row?>"><?=$row?></option>
                  <?php endforeach; ?>
                  </select>

                </div>
              </div>
              <button class="btn btn-primary" type="submit">Submit form</button>
            </form>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php include 'inc/footer.php'; ?>
      <script type="text/javascript">
        $(document).ready(function() {
            $('#levelstable').DataTable();
        } ),
        $(document).ready(function() {
            $('#userstable').DataTable();
        } );
      </script>
    </body>
</html>