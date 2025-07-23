<?php

$email = $_POST["email"];
$mdp = $_POST["mdp"];
$nvmdp = $_POST["nvmdp"];

if ($email == NULL || $mdp == NULL || $nvmdp == NULL) {

    header('Location:ChangePassword.php?erreur=champ');
    return;
}
$hash = password_hash($nvmdp, PASSWORD_DEFAULT);


$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');

$requete = $bdd->prepare("SELECT email, mdp FROM utilisateur WHERE email = ?");
$requete->execute([$email]);
$user = $requete->fetch();

if (!$user){
    header('Location:ChangePassword.php?erreur=emailcorrespondant');
    return;
}
else if (!password_verify($mdp, $user['mdp'])) {
    header('location: ChangePassword.php?erreur=password');
    return;
}
else {
     $requete2 = $bdd->prepare("UPDATE utilisateur SET mdp = ? WHERE email = ? ");
     $requete2->execute([$hash, $email]);
     header('Location:login.php?valeur=mdpchanged');
     return;
 }

