<?php

session_start();

$bdd= new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');

$body = json_decode(file_get_contents("php://input"), true);

// lire les données dans $body, PAS dans $_POST
$ressource = isset($body['ressource']) ? $body['ressource'] : null;
$temps_contrat = isset($body['temps_contrat']) ? intval($body['temps_contrat']) : null;
$quantite_ressource = isset($body['quantite_ressource']) ? intval($body['quantite_ressource']) : null;
$prix = isset($body['prix']) ? intval($body['prix']) : null;

$req=$bdd->prepare("INSERT INTO contrat (id_ressource, id_emeteur, temps_contrat, quantite_ressource, prix) VALUES(?, ?, ?, ?, ?)");
$req_id_emeteur= $bdd->prepare("SELECT id_utilisateur FROM partie WHERE id_partie= ? LIMIT 1");
$req_id_emeteur->execute(array($_SESSION['id_partie']));
$id_emeteur=$req_id_emeteur->fetchColumn();
$req->execute([$ressource, $id_emeteur, $temps_contrat, $quantite_ressource, $prix ]);
