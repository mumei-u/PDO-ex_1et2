<?php
// connexion a la DATABASE
require 'login-hospitalE2N.php';
if (empty($_GET['idPatient']) || !filter_input(INPUT_GET, 'idPatient', FILTER_VALIDATE_INT)) {
  header ('location: liste-patients.php');
  exit();
}
$idPatient = filter_input(INPUT_GET, 'idPatient', FILTER_SANITIZE_NUMBER_INT);
// fonction permettant de continuer si la connexion est réussi
$db = connectDb();
// variable pour afficher les données souhaité d'un client
$sql  = 'SELECT `lastname`, `firstname`, DATE_FORMAT(`birthDate`, "%d/%m/%Y") `birthdate`, `phone`, `mail` FROM `patients` WHERE `id` = :idPatient';
// Envoie de la requête vers la base de données
$usersQueryStat = $db->prepare($sql);
$usersQueryStat->bindValue(':idPatient', $idPatient, PDO::PARAM_INT);
try {
  $usersQueryStat->execute();
  $userInfos = $usersQueryStat->fetch(PDO::FETCH_ASSOC);
  if (!$userInfos) {
      throw new Exception('Une erreur s\'est produite veuillez contacter l\'admin du site');
  }
} catch (\Exception $e) {
  $sleep = 5;
  header('Refresh:'. $sleep .';http://pdo-partie2/liste-patients.php');
  exit($e->getMessage());
}

// éxecution de la requête
// $userInfos = [];
// if ($usersQueryStat->execute()) {
//   if ($usersQueryStat instanceOf PDOStatement) {
//     // Collection des données dans un tableau associatif (FETCH_ASSOC)
//     $usersList = $usersQueryStat->fetch(PDO::FETCH_ASSOC);
//   }
// }
// if (count($userInfos) == 0) {?>
  <!-- <p>Aucun utilisateur n'a été trouvé</p> -->
 <?php
// $sleep = 5;
// header('Refresh:'. $sleep .';http://pdo-partie2/liste-patients.php');
// exit();
// }
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="profilStyle.css">
  <title>Profil | Patient</title>
</head>
<body>
    <div class="container text-center">
      <img src="pdp.PNG" alt="photo de profil">
      <p><?= $userInfos['lastname']. ' ' .$userInfos['firstname']?></p>
      <table class="table table-bordered text-white">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date d'anniversaire</th>
            <th>Télephone</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php foreach ($userInfos AS $userInfo): ?>
             <td><?= $userInfo ?></td>
            <?php endforeach; ?>
          </tr>
      </tbody>
    </table>
    <a class="btn btn-success" href="index.php">Accueil</a>
    <a class="btn btn-light" href="liste-patients.php">Liste des patients</a>
  </div>
</body>
</html>
