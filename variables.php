<?php
include_once("connexion.inc.php");

// Récupération des variables à l'aide du client MySQL
$utilisateur = $cnx->query('SELECT * FROM utilisateur');
$utilisateur->setFetchMode(PDO::FETCH_ASSOC);

$ActeurRealisateur = $cnx->query('SELECT * FROM ActeurRealisateur');
$ActeurRealisateur->setFetchMode(PDO::FETCH_ASSOC);

$OeuvreAppartientGenre = $cnx->query('SELECT * FROM OeuvreAppartientGenre');
$OeuvreAppartientGenre->setFetchMode(PDO::FETCH_ASSOC);

$commente = $cnx->query('SELECT * FROM commente');
$commente->setFetchMode(PDO::FETCH_ASSOC);

$favoris = $cnx->query('SELECT * FROM favoris');
$favoris->setFetchMode(PDO::FETCH_ASSOC);

$filmserie = $cnx->query('SELECT * FROM filmserie');
$filmserie->setFetchMode(PDO::FETCH_ASSOC);

$galerie = $cnx->query('SELECT * FROM galerie');
$galerie->setFetchMode(PDO::FETCH_ASSOC);

$genre = $cnx->query('SELECT * FROM genre');
$genre->setFetchMode(PDO::FETCH_ASSOC);

$jouer = $cnx->query('SELECT * FROM jouer');
$jouer->setFetchMode(PDO::FETCH_ASSOC);

$realiser = $cnx->query('SELECT * FROM realiser');
$realiser->setFetchMode(PDO::FETCH_ASSOC);

$saisonvolet = $cnx->query('SELECT * FROM saisonvolet');
$saisonvolet->setFetchMode(PDO::FETCH_ASSOC);

?>