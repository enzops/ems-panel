<?php
require "config/limited.php";
require "config/config.php";

$num = rand(1000, 5000);
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
        <h1 class="mt-4"><?=_CERTIFICATE?></h1>
        <p><?=_CERTIFICATE_DESC?></p>
        <form action="certificate-pdf.php" method="post">
        <h4><?=_GENERAL_INF?></h4>
        <div class="col-6">
          <div class='input-group' id='datetimepicker1' data-td-target-input='nearest' data-td-target-toggle='nearest' >
            <span class='input-group-text' data-td-target='#datetimepicker1' data-td-toggle='datetimepicker' >
              <span class='fas fa-calendar'></span>
            </span>
            <input id='datetimepicker1' type='text' class='form-control' data-td-target='#datetimepicker1' data-td-toggle='datetimepicker' name="cert-date" placeholder="<?=_TODAY_DAT?>"/>
          </div>
          <div class="input-group">
            <div class="input-group-text"><i class="fa-solid fa-certificate"></i></div>
            <select class="form-select" aria-label=".form-select-sm example" name="cert-type">
              <option disabled selected><?=_CERTIFICATE_TYP?></option>
              <option value="<?=_CERT_GUN?>"><?=_CERT_GUN?></option>
              <option value="<?=_CERT_DEATH?>"><?=_CERT_DEATH?></option>
              <option value="<?=_CERT_WORK?>"><?=_CERT_WORK?></option>
              <option value="<?=_CERT_WORKSTOP?>"><?=_CERT_WORKSTOP?></option>
            </select>
          </div>
          <h4><?=_DOCTOR?></h4>
          <div class="input-group">
            <div class="input-group-text"><i class="fas fa-stethoscope"></i></div>
            <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom et nom du medecin" name="cert-doctor" value="<?php echo htmlspecialchars($_SESSION["username"]); ?>">
          </div>
          <h4><?=_PATIENT?></h4>
          <div class="input-group">
              <div class="input-group-text"><i class="fas fa-user-injured"></i></div>
              <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Prénom" name="patientfirstname">
              <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Nom" name="patientlastname">
              <div class='input-group' id='datetimepicker2' data-td-target-input='nearest' data-td-target-toggle='nearest' >
                <span class='input-group-text' data-td-target='#datetimepicker2' data-td-toggle='datetimepicker' >
                  <span class='fas fa-calendar'></span>
                </span>
                <input id='datetimepicker1Input' type='text' class='form-control' data-td-target='#datetimepicker2' name="patientdate" placeholder="Date de naissance"/>
              </div>
          </div>
          <h5>Entreprise</h5>
          <div class="input-group">
              <div class="input-group-text"><i class="fas fa-building"></i></div>
              <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Nom de l'entreprise" name="entreprise">
          </div>
          <div class="input-group">
              <div class="input-group-text"><i class="fas fa-hourglass-half"></i></div>
              <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="duration">
                <option selected>Nombre de jours d'arrêt</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
              </select>
          </div>
          Numéro de l'arrêt : <span class="badge rounded-pill bg-dark"><?php echo $num; ?></span>
          <input type="hidden" name="numr" value="<?php echo $num; ?>" />
        </div>
        <br><br>
        
        <button type="submit" name="see" formtarget="_blank" class="btn btn-primary">
          <i class="fa-solid fa-eye"></i> <?=_SEE?>
        </button>
        <button type="submit" name="publish" formtarget="_blank" class="btn btn-danger">
          <i class="fa-solid fa-stamp"></i> <?=_PUBLISH?>
        </button>
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
      }),
      new tempusDominus.TempusDominus(document.getElementById('datetimepicker2'), {
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
