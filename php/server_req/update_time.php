
<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');
$req = $bdd->prepare('SELECT date_partie FROM caracteristique_partie WHERE id_partie = ?');
$req->execute(array($_SESSION['id_partie']));
$datarow = $req->fetch(PDO::FETCH_ASSOC);
$ancienne_date = $datarow['date_partie'];

$req2 = $bdd->prepare('DELETE * FROM caracteristique_partie WHERE id_partie = ?');
$req3 = $bdd->prepare('DELETE * FROM centrale_joueur WHERE id_partie = ?');
$req4 = $bdd->prepare('DELETE * FROM mine_joueur WHERE id_partie = ?');
$req5 = $bdd->prepare('DELETE * FROM partie WHERE id_partie = ?');
$req6 = $bdd->prepare('SELECT id_utilisateur FROM partie WHERE id_partie = ?');
$req7 = $bdd->prepare('DELETE * FROM utilisateur WHERE id_utilisateur = ?');

if ($_SESSION['energie_par_tour'] > $_SESSION['production_energie']) {
    //gameover
    $affichage = [ "nouvelle_date" => 'gameover' ];
    $req6->execute(array($_SESSION['id_partie']));
    $data = $req6->fetch(PDO::FETCH_ASSOC);
    $req2->execute(array($_SESSION['id_partie']));
    $req3->execute(array($_SESSION['id_partie']));
    $req4->execute(array($_SESSION['id_partie']));
    $req5->execute(array($_SESSION['id_partie']));
    $req7->execute(array($data["id_utilisateur"]));
    header('Location:../php/logout.php?value=1');
}

if ($_SESSION['nb_tour'] === 5) {
    $_SESSION['energie_par_tour'] = 500000;
    $_SESSION['nb_tour'] += 1;
}

if ($_SESSION['nb_tour'] > 5) {
    $_SESSION['energie_par_tour'] = $_SESSION['energie_par_tour'] * 1.3;
    $_SESSION['nb_tour'] += 1;
}

if ($_SESSION['conso_argent'] > $_SESSION['quantite_argent']) {
    //gameover
    $affichage = [ "nouvelle_date" => 'gameover' ];
    $req6->execute(array($_SESSION['id_partie']));
    $data = $req6->fetch(PDO::FETCH_ASSOC);
    $req2->execute(array($_SESSION['id_partie']));
    $req3->execute(array($_SESSION['id_partie']));
    $req4->execute(array($_SESSION['id_partie']));
    $req5->execute(array($_SESSION['id_partie']));
    $req7->execute(array($data["id_utilisateur"]));
    header('Location:../php/logout.php?value=1');
}

if ($_SESSION['conso_metal'] > $_SESSION['quantite_metal']) {
    //gameover
    $affichage = [ "nouvelle_date" => 'gameover' ];
    $req6->execute(array($_SESSION['id_partie']));
    $data = $req6->fetch(PDO::FETCH_ASSOC);
    $req2->execute(array($_SESSION['id_partie']));
    $req3->execute(array($_SESSION['id_partie']));
    $req4->execute(array($_SESSION['id_partie']));
    $req5->execute(array($_SESSION['id_partie']));
    $req7->execute(array($data["id_utilisateur"]));
    header('Location:../php/logout.php?value=1');
}




$nouvelle_date = date("Y-m-d", strtotime($ancienne_date . "+ 1 month"));
$_SESSION['quantite_argent'] = (int)($_SESSION['quantite_argent'] + $_SESSION['argent_par_tour'] - $_SESSION['conso_argent']);
$_SESSION['argent_par_tour'] = $_SESSION['argent_par_tour']*1.5;
$_SESSION["quantite_metal"] = $_SESSION["quantite_metal"] - $_SESSION["conso_metal"] + $_SESSION["production_metal"];
$_SESSION["quantite_petrole"] = $_SESSION["quantite_petrole"] - $_SESSION["conso_petrole"] + $_SESSION["production_petrole"];
$_SESSION["quantite_uranium"] = $_SESSION["quantite_uranium"] - $_SESSION["conso_uranium"] + $_SESSION["production_uranium"];

$update = $bdd->prepare('UPDATE caracteristique_partie SET date_partie = ?, quantite_argent = ?, nb_tour = ?, energie_par_tour = ?, argent_par_tour = ?, quantite_metal = ?, quantite_petrole = ?, quantite_uranium = ? WHERE id_partie = ?');
$update->execute(array($nouvelle_date, $_SESSION['quantite_argent'], $_SESSION['nb_tour'], $_SESSION['energie_par_tour'], $_SESSION['argent_par_tour'], $_SESSION["quantite_metal"], $_SESSION["quantite_petrole"], $_SESSION["quantite_uranium"], $_SESSION['id_partie']));

if ($_SESSION['conso_uranium'] > $_SESSION['quantite_uranium']) {
    $centrale_petrole_approvisionne = (int)($_SESSION["quantite_centrale_petrole"] / $_SESSION["conso_petrole"]);
    $centrale_petrole_inactive = $_SESSION["quantite_centrale_petrole"] - $centrale_petrole_approvisionne;
    $centrale_uranium_approvisionne = (int)($_SESSION["quantite_centrale_uranium"] / $_SESSION["conso_uranium"]);
    $centrale_uranium_inactive = $_SESSION["quantite_centrale_uranium"] - $centrale_uranium_approvisionne;
    if ($_SESSION['conso_petrole'] > $_SESSION['quantite_petrole']) {
        $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"] * 2000000) + (($_SESSION["quantite_centrale_petrole"] - $centrale_petrole_inactive) * 20000000) + (($_SESSION["quantite_centrale_uranium"] - $centrale_uranium_inactive) * 500000000);
    }
    $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"] * 2000000) + ($_SESSION["quantite_centrale_petrole"] * 20000000) + (($_SESSION["quantite_centrale_uranium"] - $centrale_uranium_inactive) * 500000000);
}

if ($_SESSION['conso_petrole'] > $_SESSION['quantite_petrole']) {
    $centrale_petrole_approvisionne = (int)($_SESSION["quantite_centrale_petrole"] / $_SESSION["conso_petrole"]);
    $centrale_petrole_inactive = $_SESSION["quantite_centrale_petrole"] - $centrale_petrole_approvisionne;
    $centrale_uranium_approvisionne = (int)($_SESSION["quantite_centrale_uranium"] / $_SESSION["conso_uranium"]);
    $centrale_uranium_inactive = $_SESSION["quantite_centrale_uranium"] - $centrale_uranium_approvisionne;
    if ($_SESSION['conso_uranium'] > $_SESSION['quantite_uranium']) {
        $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"] * 2000000) + (($_SESSION["quantite_centrale_petrole"] - $centrale_petrole_inactive) * 20000000) + (($_SESSION["quantite_centrale_uranium"] - $centrale_uranium_inactive) * 500000000);
    }
    $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"] * 2000000) + (($_SESSION["quantite_centrale_petrole"] - $centrale_petrole_inactive) * 20000000) + ($_SESSION["quantite_centrale_uranium"] * 500000000);
}

$_SESSION['date_partie'] = $nouvelle_date;
$affichage = [ "nouvelle_date" => $nouvelle_date,
    "quantite_metal" => "Quantité métal : " . $_SESSION['quantite_metal'],
    "quantite_petrole" => "Quantité pétrole : " . $_SESSION['quantite_petrole'],
    "quantite_argent" => "Quantité argent : " . $_SESSION['quantite_argent'],
    "quantite_uranium" => "Quantité uranium : " . $_SESSION['quantite_uranium'],
    "argent_par_tour" => "Revenu en argent par mois : " . $_SESSION['argent_par_tour'],
    "demande_energie" => "Demande en énergie par mois : " . (int)$_SESSION['energie_par_tour'],
    "nb_tour" => "Nombre de tour : " . $_SESSION['nb_tour']
];

echo json_encode($affichage);
