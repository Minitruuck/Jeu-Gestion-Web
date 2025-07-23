<?php

session_start();

$body = json_decode(file_get_contents("php://input"), true);

$id_contrat = isset($body['id_contrat']) ? $body['id_contrat'] : null;

$bdd = new PDO('mysql:host=localhost;dbname=hainergie', 'root', '');

$req = $bdd -> prepare("SELECT id_utilisateur FROM partie WHERE id_partie = ? LIMIT 1");
$req -> execute(array($_SESSION["id_partie"]));
$data = $req -> fetchColumn();

$update = $bdd->prepare("UPDATE contrat SET id_acceptant = ? WHERE id_contrat = ?");
$update -> execute(array($data, $id_contrat));

