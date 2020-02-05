<?php
define('USER', 'pdo_usr');
define('PASSWD', 'pdo_pwd');
define('HOST', 'localhost');
define('DB', 'hospitalE2N');

// Fuction permettant la connexion dans la Base de données
function connectDb() {
  $dsn = 'mysql:dbname=' . DB . ';host=' . HOST .';charset=utf8';
  try {
    $db = new PDO($dsn, USER, PASSWD, ['PDO::ATTR_ERRMODE'=> 'PDO::ERRMODE_EXCEPTION']);
    return $db;
  } catch (Exception $ex) {
    die('La connexion à la bd a échoué !');
  }
}
