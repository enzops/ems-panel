<?php
// SQL CONNECTION
$DB_SERVER    = "192.168.99.3";
$DB_USERNAME  = "rp-panel";
$DB_PASSWORD  = "test";
$DB_NAME      = "rp-panel";
$DB_DSN       = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME;charset=utf8", $DB_USERNAME, $DB_PASSWORD);
$DB_LINK = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// CHECK CONNECTION TO DB
if($DB_LINK === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// FUNCTIONS EXEC
LoadWebsiteSettings();


// FUNCTIONS
/**
 * LoadDataRow function - loads a single data row from specified table based on given where clause and id value
 *
 * @param string $table - the name of the table to load data from
 * @param string $where - the WHERE clause to use in SQL statement
 * @param int|string $id - value to bind to :id placeholder in SQL statement
 * @return void
 */
function LoadDataRow($table, $where, $id){
  global $DataRow;
  global $DB_SERVER;
  global $DB_USERNAME;
  global $DB_PASSWORD;
  global $DB_NAME;
  global $DB_DSN;
  
  $LoadDataRow = $DB_DSN->prepare("SELECT * FROM $table WHERE $where = :id");
  $LoadDataRow->bindValue('id', $id);
  $LoadDataRow->execute();
  $DataRow = $LoadDataRow->fetch();
}

function UpdateUserData($id, $token){
  global $DB_SERVER;
  global $DB_USERNAME;
  global $DB_PASSWORD;
  global $DB_NAME;
  global $DB_DSN;
  
  $UpdateUserData = $DB_DSN->prepare("UPDATE users SET UserToken=:token WHERE UserId=:id");
  $UpdateUserData->bindValue('id', $id);
  $UpdateUserData->bindValue('token', $token);
  $UpdateUserData->execute();
}

function ScanLangs(){
  global $LANGS;
  global $LANGDIR;

  $LANGDIR  = 'inc/langs/';
  $LANGS    = array_diff(scandir($LANGDIR), array('..', '.'));
  $LANGS    = preg_replace("/\.php/", "", $LANGS );
}

session_start();


function interventiondossier(){
  global $numticket;
  $bdd = new PDO('mysql:host=192.168.99.3;dbname=rp-panel;charset=utf8', "rp-panel", "test");
  $name = "Jake Smith";
  $numticket = $bdd->prepare('SELECT * FROM personnes WHERE name = :name');
  $numticket->bindValue('name', $name);
  $numticket->execute();

}

function LoadWebsiteSettings()
  {
    global $DB_DSN;
    global $WebsiteSettings;
    global $WEBSITE_SETTINGS_LANG;
    global $WEBSITE_SETTINGS_NAME;

    $LoadWebsiteSettings = $DB_DSN->prepare("SELECT * FROM settings");
    $LoadWebsiteSettings->execute();
    $WebsiteSettings = $LoadWebsiteSettings->fetchAll();

    $WEBSITE_SETTINGS_LANG = $WebsiteSettings[0]['SettingsLang'];
    $WEBSITE_SETTINGS_NAME = $WebsiteSettings[0]['SettingsHospitalName'];

    require("inc/langs/$WEBSITE_SETTINGS_LANG.php");
  }

function LoadAllRows($table){
    global $AllRows;
    global $DB_SERVER;
    global $DB_USERNAME;
    global $DB_PASSWORD;
    global $DB_NAME;
    global $DB_DSN;
  
    $LoadAllRows = $DB_DSN->prepare("SELECT * FROM $table");
    $LoadAllRows->execute();
    $AllRows = $LoadAllRows->fetchAll();
}