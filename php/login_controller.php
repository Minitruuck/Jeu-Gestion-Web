<?php


$email = $_POST["email"];
$mdp = $_POST["mdp"];


if ($email == NULL || $mdp == NULL) {
    header('Location:login.php?erreur=champ');
    return;
}
$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');

$req = $bdd->prepare("SELECT id_utilisateur, email, mdp FROM utilisateur WHERE email = ?");
$req->execute([$email]);
$data = $req->fetch();

if ($data != NULL &&  password_verify($mdp, $data['mdp'])) {
    session_start();
    $req3= $bdd->prepare("SELECT id_partie FROM partie WHERE id_utilisateur = ?");
    $req3->execute([$data['id_utilisateur']]);
    $data3 = $req3->fetch();

    $_SESSION["email"] = $email;
    $_SESSION["id_utilisateur"] = $data['id_utilisateur'];
    $_SESSION["id_partie"] = $data3['id_partie'];

    header("location:game.php");
    return;
}
else {
    if ($data["email"] == NULL) {
        header("location:login.php?erreur=email");
        return;
    }
    else {
        header("location:login.php?erreur=mdp");
        return;
    }
}