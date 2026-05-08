<?php

/**
 * Guard de session — à inclure en TÊTE de chaque page protégée.
 *
 * Usage :
 *   $role_requis = 'admin';          // ou 'etudiant' / 'formateur'
 *   require_once '../bloc2/includes/guard.php';
 *
 * Après inclusion, $session contient ['id', 'nom', 'role'] de l'utilisateur connecté.
 */

require_once __DIR__ . '/auth.php';

$session = getSession();

// ── 1. Non connecté → retour à l'accueil ────────────────────────────────────
if ($session === null) {
    header('Location: ../bloc3/accueil.php?erreur=' . urlencode('Veuillez vous connecter.'));
    exit;
}

// ── 2. Rôle non autorisé → retour à l'accueil ───────────────────────────────
if (isset($role_requis) && $session['role'] !== $role_requis) {
    header('Location: ../bloc3/accueil.php?erreur=' . urlencode('Accès non autorisé.'));
    exit;
}
