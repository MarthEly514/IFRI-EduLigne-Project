<?php

require_once __DIR__ . '/../config/db.php';

/**
 * Tente la connexion d'un utilisateur selon son rôle.
 * - Admin   : vérification sur les constantes ADMIN_NOM / ADMIN_PASSWORD (pas de table ADMIN)
 * - Etudiant / Formateur : requête dans la table correspondante avec nom + mot_de_passe
 */
function login(string $identifiant, string $password, string $role): array {

    // ── Admin hardcodé ──────────────────────────────────────────────────────
    if ($role === 'admin') {
        if ($identifiant === ADMIN_NOM && $password === ADMIN_PASSWORD) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['id']   = 0;
            $_SESSION['nom']  = 'Admin';
            $_SESSION['role'] = 'admin';
            return ['succes' => true, 'role' => 'admin'];
        }
        return ['succes' => false, 'message' => 'Identifiant ou mot de passe incorrect.'];
    }

    // ── Etudiant ou Formateur : requête Oracle ───────────────────────────────
    $table = ($role === 'etudiant') ? 'ETUDIANT' : 'FORMATEUR';

    $conn = getOracleConnection();

    $sql  = "SELECT id, nom, prenom FROM $table
             WHERE nom = :p_identifiant AND mot_de_passe = :p_password";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':p_identifiant', $identifiant, -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_password',    $password,    -1, SQLT_CHR);

    oci_execute($stmt, OCI_DEFAULT);

    $row = oci_fetch_assoc($stmt);

    oci_free_statement($stmt);
    oci_close($conn);

    if (!$row) {
        return ['succes' => false, 'message' => 'Identifiant ou mot de passe incorrect.'];
    }

    // Démarrer la session et stocker les infos
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['id']   = $row['ID'];
    $_SESSION['nom']  = $row['NOM'];
    $_SESSION['role'] = $role;

    return ['succes' => true, 'role' => $role];
}

// Détruit la session et déconnecte l'utilisateur
function logout(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_destroy();
}

// Retourne les infos de l'utilisateur connecté depuis la session
function getSession(): ?array {
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['id'])) {
        return null;
    }

    return [
        'id'   => $_SESSION['id'],
        'nom'  => $_SESSION['nom'],
        'role' => $_SESSION['role']
    ];
}