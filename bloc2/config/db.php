<?php

// Paramètres de connexion à Oracle
define('DB_USER',     'votre_user');
define('DB_PASSWORD', 'votre_password');
define('DB_DSN',      'localhost/XEPDB1');

// Ouvre et retourne une connexion Oracle, arrête tout si échec
function getOracleConnection() {
    $conn = oci_connect(DB_USER, DB_PASSWORD, DB_DSN, 'AL32UTF8');

    if (!$conn) {
        $e = oci_error();
        error_log("[EduLigne] Connexion Oracle échouée : " . $e['message']);
        die("Erreur : impossible de se connecter à la base de données.");
    }

    return $conn;
}