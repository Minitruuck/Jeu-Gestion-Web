<?php


$email = $_POST["email"];
$password = $_POST["mdp"];
$hasher = password_hash($password, PASSWORD_DEFAULT);
$ddn = $_POST["ddn"];

if($email == NULL){
    header('Location:signup.php?erreur=champ');
    return;
}
if($password == NULL){
    header('Location:signup.php?erreur=champ');
    return;
}
if($ddn == NULL){
    header('Location:signup.php?erreur=champ');
    return;
}
$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');
$req1 = $bdd->prepare("INSERT INTO utilisateur(email, mdp, date_naissance) VALUES(?, ?, ?)");
$req2 = $bdd->prepare("SELECT * FROM utilisateur WHERE Email = ?");
$req2->execute([$email]);



if ($req2->rowcount() ===0) {
    $req1->execute([$email, $hasher, $ddn]);
    $id_utilisateur = $bdd->lastInsertId();
    $req3 = $bdd->prepare("INSERT INTO partie(id_utilisateur) VALUES(?)");
    $req3->execute([$id_utilisateur]);
    $req4 = $bdd->prepare("SELECT id_partie FROM partie WHERE id_utilisateur = ?");
    $req4->execute([$id_utilisateur]);
    $ligne = $req4-> fetch(PDO::FETCH_ASSOC);
    $id_partie = $ligne['id_partie'];
    $req5 = $bdd->prepare("INSERT INTO caracteristique_partie(id_partie) VALUES(?)");
    $req5 -> execute([$id_partie]);
    header('Location:login.php?value=comptecreer');
}
else{
    header('Location:signup.php?erreur=compteexistant');
    return;
}


?>