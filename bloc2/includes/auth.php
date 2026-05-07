<!-- authentification et sessions -->
<?php

require_once __DIR__ . '/../config/db.php';

// Vérifie les identifiants dans Oracle, démarre la session et stocke le rôle
function login(string $email, string $password): array {
    $conn = getOracleConnection();

    $sql  = "SELECT id_utilisateur, nom, prenom, role FROM UTILISATEUR 
             WHERE email = :p_email AND password = :p_password";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':p_email',    $email,    -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_password', $password, -1, SQLT_CHR);

    oci_execute($stmt, OCI_DEFAULT);

    // Récupère la ligne retournée par Oracle
    $row = oci_fetch_assoc($stmt);

    oci_free_statement($stmt);
    oci_close($conn);

    if (!$row) {
        return ['succes' => false, 'message' => "Email ou mot de passe incorrect."];
    }

    // Démarre la session et stocke les infos de l'utilisateur connecté
    session_start();
    $_SESSION['id']   = $row['ID_UTILISATEUR'];
    $_SESSION['nom']  = $row['NOM'];
    $_SESSION['role'] = $row['ROLE'];

    return ['succes' => true, 'role' => $row['ROLE']];
}

// Détruit la session et déconnecte l'utilisateur
function logout(): void {
    session_start();
    session_destroy();
}

// Retourne les infos de l'utilisateur connecté depuis la session
function getSession(): ?array {
    session_start();

    if (!isset($_SESSION['id'])) {
        return null;
    }

    return [
        'id'   => $_SESSION['id'],
        'nom'  => $_SESSION['nom'],
        'role' => $_SESSION['role']
    ];
}