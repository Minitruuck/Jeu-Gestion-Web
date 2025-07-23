<?php
session_start();

$body =json_decode(file_get_contents("php://input"),true);

error_log(print_r($body, true));

$a = isset($body["batiment"]) ? intval($body["batiment"]) : null;
$v = isset($body["batimentv"]) ? intval($body["batimentv"]) : null;

$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');

$req = $bdd -> prepare('SELECT quantite_metal,quantite_argent FROM caracteristique_partie WHERE id_partie = ?');
$req -> execute([$_SESSION["id_partie"]]);
$ligne = $req -> fetch(PDO::FETCH_ASSOC);
$quantite_metal = $ligne['quantite_metal'];
$quantite_argent = $ligne['quantite_argent'];
$update_centrale = $bdd -> prepare("INSERT INTO centrale_joueur(id_centrale, id_partie, id_ressource, nom_mine) VALUES (?,?,?,?)");
$temp = $bdd -> prepare("UPDATE caracteristique_partie SET quantite_metal = ?, quantite_argent = ? WHERE id_partie = ?");
$update_mine = $bdd -> prepare("INSERT INTO mine_joueur(id_mine, id_partie, id_ressource, nom_mine) VALUES (?,?,?,?)");
$delete_centrale = $bdd -> prepare ("DELETE FROM centrale_joueur WHERE id_partie = ? AND id_centrale = ? LIMIT 1");
$delete_mine = $bdd -> prepare ('DELETE FROM mine_joueur WHERE id_partie = ? AND id_mine = ? LIMIT 1');

if ($a === 1) {
    if ($quantite_argent >= 1500000000 && $quantite_metal >= 2000) {
        $update_centrale -> execute([1 ,$_SESSION["id_partie"], 0, "centrale uranium"]);
        $_SESSION["quantite_centrale_uranium"] += 1;
        $_SESSION["quantite_metal"] -= 2000;
        $_SESSION["quantite_argent"] -= 1500000000;
        $_SESSION["conso_argent"] += 30000000;
        $_SESSION["conso_uranium"] += 2.5;
        $_SESSION["conso_metal"] += 65;
        $_SESSION["production_energie"] += 500000000;
        $temp -> execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        if ($_SESSION['conso_uranium'] > $_SESSION['quantite_uranium']) {
            $centrale_approvisionne = (int)($_SESSION["quantite_centrale_uranium"] / $_SESSION["conso_uranium"]);
            $centrale_inactive = $_SESSION["quantite_centrale_uranium"] - $centrale_approvisionne;
            $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"]*2000000)+($_SESSION["quantite_centrale_petrole"]*20000000)+(($_SESSION["quantite_centrale_uranium"]-$centrale_inactive)*500000000);
        }
        $affichage = [
            "centrale_uranium" => "Quantité centrale à l'uranium : " . $_SESSION["quantite_centrale_uranium"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_energie" => "Production d'énergie par mois : " . $_SESSION["production_energie"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}
if ($a === 2) {
    if ($quantite_argent >= 300000000 && $quantite_metal >= 600) {
        $update_centrale -> execute([2 ,$_SESSION["id_partie"], 4, "centrale petrole"]);
        $_SESSION["quantite_centrale_petrole"] += 1;
        $_SESSION["quantite_metal"] -= 600;
        $_SESSION["quantite_argent"] -= 300000000;
        $_SESSION["conso_argent"] += 10000000;
        $_SESSION["conso_petrole"] += 35000;
        $_SESSION["conso_metal"] += 20;
        $_SESSION["production_energie"] += 20000000;
        $temp -> execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        if ($_SESSION['conso_petrole'] > $_SESSION['quantite_petrole']) {
            $centrale_approvisionne = (int)($_SESSION["quantite_centrale_petrole"] / $_SESSION["conso_petrole"]);
            $centrale_inactive = $_SESSION["quantite_centrale_petrole"] - $centrale_approvisionne;
            $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"]*2000000)+(($_SESSION["quantite_centrale_petrole"] - $centrale_inactive)*20000000)+($_SESSION["quantite_centrale_uranium"]*500000000);
        }
        $affichage = [
            "centrale_petrole" => "Quantité centrale au pétrole : " . $_SESSION["quantite_centrale_petrole"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_energie" => "Production d'énergie par mois : " . $_SESSION["production_energie"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}
if ($a === 3) {
    if ($quantite_argent >= 50000000 && $quantite_metal >= 100) {
        $update_centrale -> execute([3 ,$_SESSION["id_partie"], 3, "centrale verte"]);
        $_SESSION["quantite_centrale_verte"] += 1;
        $_SESSION["quantite_metal"] -= 100;
        $_SESSION["quantite_argent"] -= 50000000;
        $_SESSION["conso_argent"] += 1500000;
        $_SESSION["conso_metal"] += 4;
        $_SESSION["production_energie"] += 2000000;
        $temp -> execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "centrale_verte" => "Quantité centrale à l'énergie verte : " . $_SESSION["quantite_centrale_verte"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_energie" => "Production d'énergie par mois : " . $_SESSION["production_energie"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}
if ($a === 4) {
    if ($quantite_argent >= 10000000) {
        $update_mine -> execute([3 ,$_SESSION["id_partie"], 1, "mine metal"]);
        $_SESSION["quantite_mine_metal"] += 1;
        $_SESSION["quantite_argent"] -= 10000000;
        $_SESSION["conso_argent"] += 300000;
        $_SESSION["production_metal"] += 50;
        $temp -> execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "mine_metal" => "Quantité mine de métal : " . $_SESSION["quantite_mine_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_metal" => "Production de métal par mois : " . $_SESSION["production_metal"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}
if ($a === 5) {
    if ($quantite_argent >= 200000000 && $quantite_metal >= 200) {
        $update_mine -> execute([1 ,$_SESSION["id_partie"], 0, "mine uranium"]);
        $_SESSION["quantite_mine_uranium"] += 1;
        $_SESSION["quantite_metal"] -= 200;
        $_SESSION["quantite_argent"] -= 200000000;
        $_SESSION["conso_argent"] += 7000000;
        $_SESSION["conso_metal"] += 7;
        $_SESSION["production_uranium"] += 1;
        $temp -> execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "mine_uranium" => "Quantité mine d'uranium : " . $_SESSION["quantite_mine_uranium"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_uranium" => "Production d'Uranium par mois : " . $_SESSION["production_uranium"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}
if ($a === 6) {
    if ($quantite_argent >= 150000000 && $quantite_metal >= 300) {
        $update_mine -> execute([2 ,$_SESSION["id_partie"], 4, "mine petrole"]);
        $_SESSION["quantite_mine_petrole"] += 1;
        $_SESSION["quantite_metal"] -= 300;
        $_SESSION["quantite_argent"] -= 150000000;
        $_SESSION["conso_argent"] += 5000000;
        $_SESSION["conso_metal"] += 10;
        $_SESSION["production_petrole"] += 15000;
        $temp -> execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "mine_petrole" => "Quantité mine de pétrole : " . $_SESSION["quantite_mine_petrole"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_petrole" => "Production de pétrole par mois : " . $_SESSION["production_petrole"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}
if ($a === 7) {
    if ($quantite_argent >= 30000000) {
        $_SESSION["quantite_uranium"] += 1;
        $_SESSION["quantite_argent"] -= 30000000;
        $temp -> execute([$_SESSION["quantite_uranium"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "quantite_uranium" => "Quantité uranium : " . $_SESSION["quantite_uranium"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
        ];
        echo json_encode($affichage);
    }
}
if ($a === 8) {
    if ($quantite_argent >= 1500000) {
        $_SESSION["quantite_petrole"] += 1000;
        $_SESSION["quantite_argent"] -= 1500000;
        $temp -> execute([$_SESSION["quantite_petrole"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "quantite_petrole" => "Quantité pétrole : " . $_SESSION["quantite_petrole"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"]
        ];
        echo json_encode($affichage);
    }
}
if ($a === 9) {
    if ($quantite_argent >= 300000) {
        $_SESSION["quantite_metal"] += 100;
        $_SESSION["quantite_argent"] -= 300000;
        $temp -> execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "quantite_metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"]
        ];
        echo json_encode($affichage);
    }
}

if ($v === 1) {
    $nb_centrale = $bdd -> prepare ('SELECT COUNT(*) FROM centrale_joueur WHERE id_partie = ? AND id_centrale = 1');
    $nb_centrale -> execute([$_SESSION["id_partie"]]);
    $nb = $nb_centrale -> fetchColumn();
    if ($nb > 0) {
        $delete_centrale->execute([$_SESSION["id_partie"], 1]);
        $_SESSION["quantite_centrale_uranium"] -= 1;
        $_SESSION["quantite_metal"] += 2000;
        $_SESSION["quantite_argent"] += 1500000000;
        $_SESSION["conso_argent"] -= 30000000;
        $_SESSION["conso_uranium"] -= 2.5;
        $_SESSION["conso_metal"] -= 65;
        $_SESSION["production_energie"] -= 500000000;
        $temp->execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        if ($_SESSION['conso_uranium'] > $_SESSION['quantite_uranium']) {
            $centrale_approvisionne = (int)($_SESSION["quantite_centrale_uranium"] / $_SESSION["conso_uranium"]);
            $centrale_inactive = $_SESSION["quantite_centrale_uranium"] - $centrale_approvisionne;
            $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"]*2000000)+($_SESSION["quantite_centrale_petrole"]*20000000)+(($_SESSION["quantite_centrale_uranium"]-$centrale_inactive)*500000000);
        }
        $affichage = [
            "centrale_uranium" => "Quantité centrale à l'uranium : " . $_SESSION["quantite_centrale_uranium"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_energie" => "Production d'énergie par mois : " . $_SESSION["production_energie"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}

if ($v === 2) {
    $nb_centrale = $bdd -> prepare ('SELECT COUNT(*) FROM centrale_joueur WHERE id_partie = ? AND id_centrale = 2');
    $nb_centrale -> execute([$_SESSION["id_partie"]]);
    $nb = $nb_centrale -> fetchColumn();
    if ($nb > 0) {
        $delete_centrale->execute([$_SESSION["id_partie"], 2]);
        $_SESSION["quantite_centrale_petrole"] -= 1;
        $_SESSION["quantite_metal"] += 600;
        $_SESSION["quantite_argent"] += 300000000;
        $_SESSION["conso_argent"] -= 10000000;
        $_SESSION["conso_petrole"] -= 35000;
        $_SESSION["conso_metal"] -= 20;
        $_SESSION["production_energie"] -= 20000000;
        $temp->execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        if ($_SESSION['conso_petrole'] > $_SESSION['quantite_petrole']) {
            $centrale_approvisionne = (int)($_SESSION["quantite_centrale_petrole"] / $_SESSION["conso_petrole"]);
            $centrale_inactive = $_SESSION["quantite_centrale_petrole"] - $centrale_approvisionne;
            $_SESSION["production_energie"] = ($_SESSION["quantite_centrale_verte"]*2000000)+(($_SESSION["quantite_centrale_petrole"] - $centrale_inactive)*20000000)+($_SESSION["quantite_centrale_uranium"]*500000000);
        }
        $affichage = [
            "centrale_petrole" => "Quantité centrale au pétrole : " . $_SESSION["quantite_centrale_petrole"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_energie" => "Production d'énergie par mois : " . $_SESSION["production_energie"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}

if ($v === 3) {
    $nb_centrale = $bdd -> prepare ('SELECT COUNT(*) FROM centrale_joueur WHERE id_partie = ? AND id_centrale = 3');
    $nb_centrale -> execute([$_SESSION["id_partie"]]);
    $nb = $nb_centrale -> fetchColumn();
    if ($nb > 0) {
        $delete_centrale->execute([$_SESSION["id_partie"], 3]);
        $_SESSION["quantite_centrale_verte"] -= 1;
        $_SESSION["quantite_metal"] += 100;
        $_SESSION["quantite_argent"] += 50000000;
        $_SESSION["conso_argent"] -= 1500000;
        $_SESSION["conso_metal"] -= 4;
        $_SESSION["production_energie"] -= 2000000;
        $temp->execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "centrale_verte" => "Quantité centrale à l'énergie verte : " . $_SESSION["quantite_centrale_verte"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_energie" => "Production d'énergie par mois : " . $_SESSION["production_energie"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}

if ($v === 4) {
    $nb_mine = $bdd -> prepare ('SELECT COUNT(*) FROM mine_joueur WHERE id_partie = ? AND id_mine = 3');
    $nb_mine -> execute([$_SESSION["id_partie"]]);
    $nb = $nb_mine -> fetchColumn();
    if ($nb > 0) {
        $delete_mine->execute([$_SESSION["id_partie"], 3]);
        $_SESSION["quantite_mine_metal"] -= 1;
        $_SESSION["quantite_argent"] += 10000000;
        $_SESSION["conso_argent"] -= 300000;
        $_SESSION["production_metal"] -= 50;
        $temp->execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "mine_metal" => "Quantité mine de métal : " . $_SESSION["quantite_mine_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_metal" => "Production de métal par mois : " . $_SESSION["production_metal"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}

if ($v === 5) {
    $nb_mine = $bdd -> prepare ('SELECT COUNT(*) FROM mine_joueur WHERE id_partie = ? AND id_mine = 1');
    $nb_mine -> execute([$_SESSION["id_partie"]]);
    $nb = $nb_mine -> fetchColumn();
    if ($nb > 0) {
        $delete_mine->execute([$_SESSION["id_partie"], 1]);
        $_SESSION["quantite_mine_uranium"] -= 1;
        $_SESSION["quantite_metal"] += 200;
        $_SESSION["quantite_argent"] += 200000000;
        $_SESSION["conso_argent"] -= 7000000;
        $_SESSION["conso_metal"] -= 7;
        $_SESSION["production_uranium"] -= 1;
        $temp->execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "mine_uranium" => "Quantité mine d'uranium : " . $_SESSION["quantite_mine_uranium"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_uranium" => "Production d'Uranium par mois : " . $_SESSION["production_uranium"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}

if ($v === 6) {
    $nb_mine = $bdd -> prepare ('SELECT COUNT(*) FROM mine_joueur WHERE id_partie = ? AND id_mine = 2');
    $nb_mine -> execute([$_SESSION["id_partie"]]);
    $nb = $nb_mine -> fetchColumn();
    if ($nb > 0) {
        $delete_mine->execute([$_SESSION["id_partie"], 2]);
        $_SESSION["quantite_mine_petrole"] -= 1;
        $_SESSION["quantite_metal"] += 300;
        $_SESSION["quantite_argent"] += 150000000;
        $_SESSION["conso_argent"] -= 5000000;
        $_SESSION["conso_metal"] -= 10;
        $_SESSION["production_petrole"] -= 15000;
        $temp->execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "mine_petrole" => "Quantité mine de pétrole : " . $_SESSION["quantite_mine_petrole"],
            "metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
            "production_petrole" => "Production de pétrole par mois : " . $_SESSION["production_petrole"],
            "conso_argent" => "Demande en argent par mois : " . $_SESSION["conso_argent"]
        ];
        echo json_encode($affichage);
    }
}

if ($v === 7) {
    if ($_SESSION["quantite_uranium"] >= 1) {
        $_SESSION["quantite_uranium"] -= 1;
        $_SESSION["quantite_argent"] += 15000000;
        $temp->execute([$_SESSION["quantite_uranium"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "quantite_uranium" => "Quantité uranium : " . $_SESSION["quantite_uranium"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
        ];
        echo json_encode($affichage);
    }
}

if ($v === 8) {
    if ($_SESSION["quantite_petrole"] >= 1) {
        $_SESSION["quantite_petrole"] -= 1000;
        $_SESSION["quantite_argent"] += 750000;
        $temp->execute([$_SESSION["quantite_petrole"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "quantite_petrole" => "Quantité pétrole : " . $_SESSION["quantite_petrole"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
        ];
        echo json_encode($affichage);
    }
}

if ($v === 9) {
    if ($_SESSION["quantite_metal"] >= 1) {
        $_SESSION["quantite_metal"] -= 100;
        $_SESSION["quantite_argent"] += 150000;
        $temp->execute([$_SESSION["quantite_metal"], $_SESSION["quantite_argent"], $_SESSION["id_partie"]]);
        $affichage = [
            "quantite_metal" => "Quantité métal : " . $_SESSION["quantite_metal"],
            "argent" => "Quantité d'argent : " . $_SESSION["quantite_argent"],
        ];
        echo json_encode($affichage);
    }
}