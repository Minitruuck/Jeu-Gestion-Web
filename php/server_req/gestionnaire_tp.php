<?php

session_start();

$body = json_decode(file_get_contents("php://input"), true);

// lire les données dans $body, PAS dans $_POST
$nombre_batiment = isset($body['nombre_batiment']) ? intval($body['nombre_batiment']) : null;
$ressource = isset($body['ressource']) ? $body['ressource'] : null;
$taux_prod = isset($body['taux_prod']) ? intval($body['taux_prod']) : null;
$taux_prod_max = isset($body['taux_prod_max']) ? intval($body['taux_prod_max']) : null;
$taux_prod_min = isset($body['taux_prod_min']) ? intval($body['taux_prod_min']) : null;

$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');
$req = $bdd->prepare("UPDATE centrale_joueur SET taux_production = ? WHERE id_partie = ? AND id_centrale = ? AND taux_production >= ? AND taux_production <= ? LIMIT $nombre_batiment");
$reset = $bdd->prepare('UPDATE centrale_joueur SET taux_production = ? WHERE id_partie = ? AND id_centrale = ?');
$nb_centrale = $bdd->prepare('SELECT COUNT(*) FROM centrale_joueur WHERE id_partie = ? AND id_centrale = ? AND taux_production >= ? AND taux_production <= ?');
$req8 = $bdd -> prepare('SELECT SUM(taux_production) FROM centrale_joueur WHERE id_partie = ? AND id_ressource = ?');
$req9 = $bdd -> prepare('SELECT SUM(taux_production) FROM centrale_joueur WHERE id_partie = ? AND id_ressource = ?');

if ($taux_prod_min > $taux_prod_max) {
    $prod_energie = $_SESSION["tp_centrales_uranium"]*500000000 + $_SESSION["tp_centrales_petrole"]*20000000 + $_SESSION["quantite_centrale_verte"]*2000000;
    echo json_encode(["message_c" => "Le minimum est plus grand que le maximum", "tp" => "Production d'énergie par mois : " . $prod_energie]);
}

if ($ressource === "Uranium") {
    $nb_centrale->execute([$_SESSION['id_partie'], 1, $taux_prod_min, $taux_prod_max]);
    $nb = $nb_centrale->fetchColumn();
    if ($nb < $nombre_batiment) {
        $prod_energie = $_SESSION["tp_centrales_uranium"]*500000000 + $_SESSION["tp_centrales_petrole"]*20000000 + $_SESSION["quantite_centrale_verte"]*2000000;
        echo json_encode(["message_c" => "Vous n'avez pas assez de centrale à l'uranium", "tp" => "Production d'énergie par mois : " . $prod_energie]);
        exit;
    } else {
        $req->execute([$taux_prod, $_SESSION["id_partie"], 1, $taux_prod_min, $taux_prod_max]);
        $req9 -> execute([$_SESSION["id_partie"], 0]);
        $tp_centrales_uranium = $req9 -> fetchColumn();
        $_SESSION["tp_centrales_uranium"] = $tp_centrales_uranium/100;
        $_SESSION["conso_uranium"] = ($_SESSION["quantite_centrale_uranium"]*2.5)*$_SESSION["tp_centrales_uranium"];
        $prod_energie = $_SESSION["tp_centrales_uranium"]*500000000 + $_SESSION["tp_centrales_petrole"]*20000000 + $_SESSION["quantite_centrale_verte"]*2000000;
        echo json_encode(["message_c" => "Opération effectuée", "tp" => "Production d'énergie par mois : " . $prod_energie]);
    exit;
    }
}

if ($ressource === "Petrole") {
    $nb_centrale->execute([$_SESSION['id_partie'], 2, $taux_prod_min, $taux_prod_max]);
    $nb = $nb_centrale->fetchColumn();
    if ($nb < $nombre_batiment) {
        $tp = $_SESSION["tp_centrales_uranium"]*500000000 + $_SESSION["tp_centrales_petrole"]*20000000 + $_SESSION["quantite_centrale_verte"]*2000000;
        echo json_encode(["message_c" => "Vous n'avez pas assez de centrale au pétrole", "tp" => "Production d'énergie par mois : " . $tp]);
        exit;
    } else {
        $req->execute([$taux_prod, $_SESSION["id_partie"], 2, $taux_prod_min, $taux_prod_max]);
        $req8 -> execute([$_SESSION["id_partie"], 4]);
        $tp_centrales_petrole = $req8 -> fetchColumn();
        $_SESSION["tp_centrales_petrole"] = $tp_centrales_petrole/100;
        $_SESSION["conso_petrole"] = ($_SESSION["quantite_centrale_petrole"]*35000)*$_SESSION["tp_centrales_petrole"];
        $prod_energie = $_SESSION["tp_centrales_uranium"]*500000000 + $_SESSION["tp_centrales_petrole"]*20000000 + $_SESSION["quantite_centrale_verte"]*2000000;
        echo json_encode(["message_c" => "Opération effectuée", "tp" => "Production d'énergie par mois : " . $prod_energie]);
    exit;
    }
}

// Si on veut tout remettre à 100%
if ($nombre_batiment === null && $ressource === null && $taux_prod !== null) {
    $reset->execute([$taux_prod, $_SESSION["id_partie"], 1]);
    $reset->execute([$taux_prod, $_SESSION["id_partie"], 2]);
    $prod_energie = $_SESSION["quantite_centrale_uranium"]*500000000 + $_SESSION["quantite_centrale_petrole"]*20000000 + $_SESSION["quantite_centrale_verte"]*2000000;
    $_SESSION["conso_uranium"] = ($_SESSION["quantite_centrale_uranium"]*2.5)*$_SESSION["tp_centrales_uranium"];
    $_SESSION["conso_petrole"] = ($_SESSION["quantite_centrale_petrole"]*35000)*$_SESSION["tp_centrales_petrole"];
    echo json_encode(["message_c" => "Toutes les valeurs ont été remises à 100%", "tp" => "Production d'énergie par mois : " . $prod_energie]);
    exit;
}

// Par défaut
$prod_energie = $_SESSION["tp_centrales_uranium"]*500000000 + $_SESSION["tp_centrales_petrole"]*20000000 + $_SESSION["quantite_centrale_verte"]*2000000;
echo json_encode(["message_c" => "Aucune action effectuée", "tp" => "Production d'énergie par mois : " . $prod_energie]);

?>