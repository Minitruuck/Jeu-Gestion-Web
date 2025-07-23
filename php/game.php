<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');
$req1 = $bdd -> prepare('SELECT date_partie, nb_tour, argent_par_tour, energie_par_tour, quantite_argent, quantite_uranium, quantite_metal, quantite_petrole FROM caracteristique_partie WHERE id_partie = ?');
$req2 = $bdd -> prepare('SELECT COUNT(id_mine) FROM mine_joueur WHERE id_partie = ? AND id_ressource = ?');
$req3 = $bdd -> prepare('SELECT COUNT(id_mine) FROM mine_joueur WHERE id_partie = ? AND id_ressource = ?');
$req4 = $bdd -> prepare('SELECT COUNT(id_mine) FROM mine_joueur WHERE id_partie = ? AND id_ressource = ?');
$req5 = $bdd -> prepare('SELECT COUNT(id_centrale) FROM centrale_joueur WHERE id_partie = ? AND id_ressource = ?');
$req6 = $bdd -> prepare('SELECT COUNT(id_centrale) FROM centrale_joueur WHERE id_partie = ? AND id_ressource = ?');
$req7 = $bdd -> prepare('SELECT COUNT(id_centrale) FROM centrale_joueur WHERE id_partie = ? AND id_ressource = ?');
$req8 = $bdd -> prepare('SELECT SUM(taux_production) FROM centrale_joueur WHERE id_partie = ? AND id_ressource = ?');
$req9 = $bdd -> prepare('SELECT SUM(taux_production) FROM centrale_joueur WHERE id_partie = ? AND id_ressource = ?');
$id_user = $bdd -> prepare("SELECT id_utilisateur FROM partie WHERE id_partie = ? LIMIT 1");


$req1 -> execute([$_SESSION["id_partie"]]);
$req2 -> execute([$_SESSION["id_partie"], 1]);
$req3 -> execute([$_SESSION["id_partie"], 0]);
$req4 -> execute([$_SESSION["id_partie"], 4]);
$req5 -> execute([$_SESSION["id_partie"], 3]); //energie verte
$req6 -> execute([$_SESSION["id_partie"], 0]);
$req7 -> execute([$_SESSION["id_partie"], 4]);
$req8 -> execute([$_SESSION["id_partie"], 0]);
$req9 -> execute([$_SESSION["id_partie"], 4]);
$somme_mine_metal = $req2 -> fetchColumn();
$somme_mine_uranium = $req3 -> fetchColumn();
$somme_mine_petrole = $req4 -> fetchColumn();
$somme_centrale_verte = $req5 -> fetchColumn();
$somme_centrale_uranium = $req6 -> fetchColumn();
$somme_centrale_petrole = $req7 -> fetchColumn();
$tp_centrales_uranium = $req8 -> fetchColumn();
$tp_centrales_uranium = $tp_centrales_uranium/100;
$tp_centrales_petrole = $req9 -> fetchColumn();
$tp_centrales_petrole = $tp_centrales_petrole/100;
$ligne = $req1 -> fetch(PDO::FETCH_ASSOC);

$date_partie = $ligne['date_partie'];
$nb_tour = $ligne['nb_tour'];
$argent_par_tour = $ligne['argent_par_tour'];
$energie_par_tour = $ligne['energie_par_tour'];
$quantite_argent = $ligne['quantite_argent'];
$quantite_uranium = $ligne['quantite_uranium'];
$quantite_metal = $ligne['quantite_metal'];
$quantite_petrole = $ligne['quantite_petrole'];
$production_energie = ($somme_centrale_verte*2000000)+($tp_centrales_petrole*20000000)+($tp_centrales_uranium*500000000);
$production_petrole = $somme_mine_petrole*15000;
$production_uranium = $somme_mine_uranium*1;
$production_metal = $somme_mine_metal*50;
$conso_uranium = ($somme_centrale_uranium*2.5)*$tp_centrales_uranium;
$conso_petrole = ($somme_mine_petrole*35000)*$tp_centrales_petrole;
$conso_argent = ($somme_mine_metal*300000)+($somme_mine_uranium*7000000)+($somme_mine_petrole*5000000)+($somme_centrale_uranium*30000000)+($somme_centrale_verte*1500000)+($somme_centrale_petrole*10000000);
$conso_metal = ($somme_mine_uranium*7)+($somme_mine_petrole*10)+($somme_centrale_uranium*65)+($somme_centrale_verte*4)+($somme_centrale_petrole*20);

$_SESSION["quantite_uranium"] = $quantite_uranium;
$_SESSION["quantite_petrole"] = $quantite_petrole;
$_SESSION["quantite_argent"] = $quantite_argent;
$_SESSION["quantite_metal"] = $quantite_metal;
$_SESSION["quantite_centrale_uranium"] = $somme_centrale_uranium;
$_SESSION["quantite_centrale_petrole"] = $somme_centrale_petrole;
$_SESSION["quantite_centrale_verte"] = $somme_centrale_verte;
$_SESSION["quantite_mine_uranium"] = $somme_mine_uranium;
$_SESSION["quantite_mine_metal"] = $somme_mine_metal;
$_SESSION["quantite_mine_petrole"] = $somme_mine_petrole;
$_SESSION["production_energie"] = $production_energie;
$_SESSION["production_petrole"] = $production_petrole;
$_SESSION["production_uranium"] = $production_uranium;
$_SESSION["production_metal"] = $production_metal;
$_SESSION["conso_uranium"] = $conso_uranium;
$_SESSION["conso_petrole"] = $conso_petrole;
$_SESSION["conso_metal"] = $conso_metal;
$_SESSION["conso_argent"] = $conso_argent;
$_SESSION["nb_tour"] = $nb_tour;
$_SESSION["date_partie"] = $date_partie;
$_SESSION["argent_par_tour"] = $argent_par_tour;
$_SESSION["energie_par_tour"] = $energie_par_tour;
$_SESSION["tp_centrales_uranium"] = $tp_centrales_uranium;
$_SESSION["tp_centrales_petrole"] = $tp_centrales_petrole;

$id_user->execute([$_SESSION["id_partie"]]);
$_SESSION["id_user"] = $id_user->fetchColumn();

?>

<html lang="fr" class="html">
<head>
    <title> RTS Energie </title>
    <link rel="stylesheet" href="../css/game.css">
</head>
<body class="body">
<div class="main">
    <div class="top_block">
        <a href="../php/logout.php" class="deconnect">Se déconnecter</a>
        <p class="player_name"><?php echo $_SESSION["email"] ?></p>
        <p class="date" id="date"><?php echo $date_partie ?></p>
    </div>
    <div class="middle_block">
        <img class="image_jeu" src="../images/unnamed.png" alt="image du jeu">
    </div>
    <div class="bottom_block">
        <div class="overflow_stats">
            <h2 class="stats_title">Statistiques de jeu</h2>
            <dl class="liste_stats">
                <dt id="prod_petrole">Production de pétrole par mois : <?php echo $production_petrole ?></dt>
                <dt id="prod_uranium">Production d'Uranium par mois : <?php echo $production_uranium ?></dt>
                <dt id="prod_metal">Production de métal par mois : <?php echo $production_metal ?></dt>
                <dt id="prod_energie">Production d'énergie par mois : <?php echo $production_energie ?></dt>
                <dt id="demande_energie">Demande en énergie par mois : <?php echo $energie_par_tour ?></dt>
                <dt id="conso_argent">Demande en argent par mois : <?php echo $_SESSION["conso_argent"] ?></dt>
                <dt id="revenu">Revenu en argent par mois : <?php echo $_SESSION["argent_par_tour"] ?></dt>
                <dt id="quantite_petrole">Quantité pétrole : <?php echo $quantite_petrole?></dt>
                <dt id="quantite_uranium">Quantité uranium : <?php echo $quantite_uranium?></dt>
                <dt id="quantite_metal">Quantité métal : <?php echo $quantite_metal ?></dt>
                <dt id="quantite_argent">Quantité argent : <?php echo $quantite_argent ?></dt>
                <dt id="nombre_tour">Nombre de tour : <?php echo $nb_tour ?></dt>
                <dt id="mine_metal">Quantité mine de métal : <?php echo $somme_mine_metal ?></dt>
                <dt id="mine_uranium">Quantité mine d'uranium : <?php echo $somme_mine_uranium ?></dt>
                <dt id="mine_petrole">Quantité mine de pétrole : <?php echo $somme_mine_petrole ?></dt>
                <dt id="centrale_petrole">Quantité centrale à pétrole : <?php echo $somme_centrale_petrole ?></dt>
                <dt id="centrale_uranium">Quantité centrale à l'uranium : <?php echo $somme_centrale_uranium ?></dt>
                <dt id="centrale_verte">Quantité centrale à l'énergie verte : <?php echo $somme_centrale_verte ?></dt>
            </dl>
        </div>
        <div class="overflow_builds">
            <h2 class="builds_title">Gestionnaire de production</h2>
            <form class="form_tp" id="form_tp">
                <input type="number" class="form_tp_input" name="nombre_batiment" id="nombre_batiment" placeholder="Nombre de centrales" min="0">
                <select name="ressource" class="form_tp_input">
                    <option value="">Type de centrale(s)</option>
                    <option value="Uranium">Uranium</option>
                    <option value="Petrole">Pétrole</option>
                </select>
                <input type="number" class="form_tp_input" name="taux_prod" id="taux_prod" placeholder="Insérer le taux de production souhaité (en %)" min="0" max="100">
                <input type="number" class="form_tp_input" name="taux_prod_max" id="taux_prod_max" placeholder="Taux de production actuel maximum des centrales visé" min="0" max="100">
                <input type="number" class="form_tp_input" name="taux_prod_min" id="taux_prod_min" placeholder="Taux de production actuel minimum des centrales visé" min="0" max="100">
                <input type="submit" value="Valider l'opération" class="form_tp_input">
            </form>
            <p id="message"></p>
            <script>
                document.getElementById("form_tp").addEventListener("submit", function(event) {
                    event.preventDefault();

                    const form = event.target;
                    const formData = {
                        nombre_batiment: parseInt(form.nombre_batiment.value),
                        ressource: form.ressource.value,
                        taux_prod: parseInt(form.taux_prod.value),
                        taux_prod_max: parseInt(form.taux_prod_max.value),
                        taux_prod_min: parseInt(form.taux_prod_min.value)
                    };
                    fetch('../php/server_req/gestionnaire_tp.php', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(formData)
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            document.getElementById("message").textContent = data.message_c;
                            document.getElementById("prod_energie").textContent = data.tp;
                        });
                });
            </script>
            <button class="reset_button" onclick="reset()">Remettre toutes les valeurs par défauts (100%)</button>
            <script>
                function reset() {
                    fetch('../php/server_req/gestionnaire_tp.php', {
                        method: 'POST',
                        headers: {
                            "Content-type": "application/json"
                        },
                        body: JSON.stringify({taux_prod: 100})
                    })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById("message").textContent = data.message_c;
                            document.getElementById("prod_energie").textContent = data.tp;
                        })
                }
            </script>
        </div>
    </div>
    <div class="side_block1">
        <h1 class="shop_title">
            Magasin
        </h1>
        <dl class="liste_batiment_shop">
            <dt class="ligne"><p class="inline_text">Centrale à l'uranium :</p>
                <button class="achat" onclick="a(1)">Acheter</button>
                <button class="vente" onclick="v(1)">Vendre</button>
            </dt>
                <dd>Coût de construction : 1.5B$, 2000T de métal </dd>
                <dd>Coût d'entretien par mois : 30M$, 65T de métal </dd>
                <dd>Rendement (100%) : 500M de kWh par mois pour
                    <br/>2,5T d'uranium</dd>
            <dt class="ligne"><p class="inline_text">Centrale à pétrole :</p>
                <button class="achat" onclick=" a(2)">Acheter</button>
                <button class="vente" onclick=" v(2)">Vendre</button>
            </dt>
                <dd>Coût de construction : 300M$, 600T de métal</dd>
                <dd>Coût d'entretien par mois : 10M$, 20T de métal </dd>
                <dd>Rendement (100%) : 20M de kWh par mois pour
                    <br/>35K barils</dd>
            <dt class="ligne"><p class="inline_text">Centrale à l'énergie verte :</p>
                <button class="achat" onclick="a(3)">Acheter</button>
                <button class="vente" onclick="v(3)">Vendre</button>
            </dt>
                <dd>Coût de construction : 50M$, 100T de métal</dd>
                <dd>Coût d'entretien par mois : 1.5M$, 4T de métal </dd>
                <dd>Rendement (100%) : 2M de kWh par mois</dd>
            <dt class="ligne"><p class="inline_text">Mine de métal :</p>
                <button class="achat" onclick="a(4)">Acheter</button>
                <button class="vente" onclick="v(4)">Vendre</button>
            </dt>
                <dd>Coût de construction : 10M$</dd>
                <dd>Coût d'entretien par mois : 300K$</dd>
                <dd>Rendement : 50T par mois</dd>
            <dt class="ligne"><p class="inline_text">Mine d'uranium :</p>
                <button class="achat" onclick="a(5)">Acheter</button>
                <button class="vente" onclick="v(5)">Vendre</button>
            </dt>
                <dd>Coût de construction : 200M$, 200T de métal</dd>
                <dd>Coût d'entretien par mois : 7M$, 7T de métal </dd>
                <dd>Rendement : 1T par mois</dd>
            <dt class="ligne"><p class="inline_text">Mine de pétrole :</p>
                <button class="achat" onclick="a(6)">Acheter</button>
                <button class="vente" onclick="v(6)">Vendre</button>
            </dt>
                <dd>Coût de construction : 150M$, 300T de métal</dd>
                <dd>Coût d'entretien par mois : 5M$, 10T de métal </dd>
                <dd>Rendement : 15K par mois</dd>
            <dt class="ligne"><p class="inline_text">Uranium (Tonne) :</p>
                <button class="achat" onclick="a(7)">Acheter</button>
                <button class="vente" onclick="v(7)">Vendre</button>
            </dt>
                <dd>Prix : 30M$ la tonne à l'achat, 15M$ à la vente</dd>
            <dt class="ligne"><p class="inline_text">Pétrole (Baril) :</p>
                <button class="achat" onclick="a(8)">Acheter</button>
                <button class="vente" onclick="v(8)">Vendre</button>
            </dt>
                <dd>Prix : 1.5M$ les 1000 barils à l'achat, 750K$ à la vente</dd>
            <dt class="ligne"><p class="inline_text">Métal (Tonne) :</p>
                <button class="achat" onclick="a(9)">Acheter</button>
                <button class="vente" onclick="v(9)">Vendre</button>
            </dt>
                <dd>Prix : 300K$ les 100 tonnes à l'achat, 150K$ à la vente</dd>
        </dl>
    </div>
    <div class="side_block2">
        <h1 class="pshop_title">Marché de particuliers</h1>
        <div class="overflow_contracts">
            <form class="form_contrat" id="form_contrat">
                <select name="ressource" class="form_contrat_input">
                    <option value="Uranium">Uranium</option>
                    <option value="Petrole">Pétrole</option>
                    <option value="Métal">Métal</option>
                </select>
                <input type="number" class="form_contrat_input" name="temps_contrat" id="temps_contrat" placeholder="Insérer la durée du contrat" min="1">
                <input type="number" class="form_contrat_input" name="quantite_ressource" id="quantite_ressource" placeholder="Quantité de ressources vendues" min="1">
                <input type="number" class="form_contrat_input" name="prix" id="prix" placeholder="Prix du contrat" min="1">
                <input type="submit" value="Créer un contrat" class="form_contrat_input">
                </form>
                <script>
                    document.getElementById("form_contrat").addEventListener("submit", function(event) {
                        event.preventDefault();

                        const form = event.target;
                        const formData = {
                            ressource: form.ressource.value,
                            temps_contrat: parseInt(form.temps_contrat.value),
                            quantite_ressource: parseInt(form.quantite_ressource.value),
                            prix: parseInt(form.prix.value)
                        };
                        fetch('../php/server_req/creer_contrat.php', {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify(formData)
                        })
                            .then(response=>{location.reload()})
                    });
                </script>
            <?php
            // Connexion à la base de données (à adapter selon tes identifiants)
            $bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');

            // Requête pour récupérer tous les contrats avec info utilisateur
            $req = $bdd->prepare("SELECT id_contrat, id_ressource,id_acceptant, id_emeteur, temps_contrat, quantite_ressource, prix FROM contrat");
            $req->execute();

            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                $id_contrat = $row["id_contrat"];
                $id_emeteur = $row['id_emeteur'];
                $id_acceptant = $row['id_acceptant'];
                $temps_contrat = $row['temps_contrat'];
                $ressource = $row['id_ressource']; // si texte avec retours à la ligne
                $quantite = $row['quantite_ressource'];
                $prix = $row['prix'];
                switch ($ressource) {
                    case 1:
                        $ressource = 'Métal';
                        break;

                    case 4:
                        $ressource = 'Petrole';
                        break;

                    case 0:
                        $ressource = 'Uranium';
                        break;
                }
                if ($id_emeteur == $_SESSION['id_partie']) {
                    echo <<<HTML
                <p class="ligne" id="$id_emeteur">Votre contrat</p>
                <p>
                Ressource : $ressource<br>
                Quantité : $quantite<br>
                Durée : $temps_contrat mois<br>
                Prix : $prix $                
                </p>
                <hr>
HTML;
                } elseif($id_acceptant == $_SESSION["id_user"]) {
                    echo <<<HTML
                <p class="ligne" id="$id_emeteur">Contrat accepté</p>
                <p>
                Ressource : $ressource<br>
                Quantité : $quantite<br>
                Durée : $temps_contrat mois<br>
                Prix : $prix $                
                </p>
                <hr> 
HTML;
                } elseif ($id_acceptant == NULL) {
                    echo <<<HTML
                <p class="ligne" id="$id_emeteur">Contrat de l'utilisateur #$id_emeteur</p>
                <p>
                Ressource : $ressource<br>
                Quantité : $quantite<br>
                Durée : $temps_contrat mois<br>
                Prix : $prix $
                </p>
                <button class="accept" onclick="accept_contrat($id_contrat)">Accepter</button>
                <hr>
HTML;

                }
            }
            ?>
        </div>
        <script>
            function accept_contrat(id_contrat) {
                fetch("../php/server_req/accepter_contrat.php", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json"
                    },
                    body: JSON.stringify({id_contrat: id_contrat})
                })
                    .then(response => {location.reload()})
            }
        </script>
    </div>
</div>
<script>

    let targettime;
    let timer;

    function startTimer() {
        targettime = new Date();
        targettime.setMinutes(targettime.getMinutes() + 1);


        timer = setInterval(updatetime, 1000);
    }

    function updatetime() {
        const currenttime = new Date();
        const timedifference = targettime - currenttime;

        if (timedifference <= 0) {
            clearInterval(timer);
            fetch("../php/server_req/update_time.php")
                .then(response => response.json())
                .then(data => {
                    document.getElementById("date").textContent = data.nouvelle_date;
                    document.getElementById("quantite_uranium").textContent = data.quantite_uranium;
                    document.getElementById("quantite_metal").textContent = data.quantite_metal;
                    document.getElementById("quantite_petrole").textContent = data.quantite_petrole;
                    document.getElementById("quantite_argent").textContent = data.quantite_argent;
                    document.getElementById("nombre_tour").textContent = data.nb_tour;
                    document.getElementById("demande_energie").textContent = data.demande_energie;
                    startTimer();
                });
        }
    }

    startTimer();

    function a(id_option) {
        if (id_option === 1) {
            fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 1})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("centrale_uranium").textContent = data.centrale_uranium;
                    document.getElementById("prod_energie").textContent = data.production_energie;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 2) {
            fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 2})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("centrale_petrole").textContent = data.centrale_petrole;
                    document.getElementById("prod_energie").textContent = data.production_energie;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 3) {
            fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 3})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("centrale_verte").textContent = data.centrale_verte;
                    document.getElementById("prod_energie").textContent = data.production_energie;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 4) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 4})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mine_metal").textContent = data.mine_metal;
                    document.getElementById("prod_metal").textContent = data.production_metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 5) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 5})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mine_uranium").textContent = data.mine_uranium;
                    document.getElementById("prod_uranium").textContent = data.production_uranium;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 6) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 6})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mine_petrole").textContent = data.mine_petrole;
                    document.getElementById("prod_petrole").textContent = data.production_petrole;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 7) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 7})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("quantite_uranium").textContent = data.quantite_uranium;
                    document.getElementById("quantite_argent").textContent = data.argent;
                });
        }
        if (id_option === 8) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 8})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("quantite_petrole").textContent = data.quantite_petrole;
                    document.getElementById("quantite_argent").textContent = data.argent;
                });
        }
        if (id_option === 9) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batiment: 9})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("quantite_metal").textContent = data.quantite_metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                });
        }
    }

    function v(id_option) {
        if (id_option === 1) {
            fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 1})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("centrale_uranium").textContent = data.centrale_uranium;
                    document.getElementById("prod_energie").textContent = data.production_energie;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 2) {
            fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 2})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("centrale_petrole").textContent = data.centrale_petrole;
                    document.getElementById("prod_energie").textContent = data.production_energie;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 3) {
            fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 3})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("centrale_verte").textContent = data.centrale_verte;
                    document.getElementById("prod_energie").textContent = data.production_energie;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 4) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 4})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mine_metal").textContent = data.mine_metal;
                    document.getElementById("prod_metal").textContent = data.production_metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 5) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 5})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mine_uranium").textContent = data.mine_uranium;
                    document.getElementById("prod_uranium").textContent = data.production_uranium;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 6) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 6})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("mine_petrole").textContent = data.mine_petrole;
                    document.getElementById("prod_petrole").textContent = data.production_petrole;
                    document.getElementById("quantite_metal").textContent = data.metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                    document.getElementById("conso_argent").textContent = data.conso_argent;
                });
        }
        if (id_option === 7) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 7})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("quantite_uranium").textContent = data.quantite_uranium;
                    document.getElementById("quantite_argent").textContent = data.argent;
                });
        }
        if (id_option === 8) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 8})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("quantite_petrole").textContent = data.quantite_petrole;
                    document.getElementById("quantite_argent").textContent = data.argent;
                });
        }
        if (id_option === 9) {
            return fetch("../php/server_req/update_ressource.php", {
                method: "POST",
                headers: {
                    "Content-type": "application/json"
                },
                body: JSON.stringify({batimentv: 9})
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("quantite_metal").textContent = data.quantite_metal;
                    document.getElementById("quantite_argent").textContent = data.argent;
                });
        }
    }

</script>
</body>
</html>