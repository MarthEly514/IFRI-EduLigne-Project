<?php

require_once __DIR__ . '/includes/auth.php';

// ── 1. Vérifier que la requête vient bien d'un formulaire POST ──────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../bloc3/accueil.php');
    exit;
}

// ── 2. Récupérer et valider les champs ──────────────────────────────────────
$identifiant = trim($_POST['identifiant']  ?? '');
$password    = trim($_POST['mot_de_passe'] ?? '');
$role        = trim($_POST['role']         ?? '');

if ($identifiant === '' || $password === '') {
    header('Location: ../bloc3/accueil.php?erreur=' . urlencode('Veuillez remplir tous les champs.'));
    exit;
}

if (!in_array($role, ['etudiant', 'formateur', 'admin'])) {
    header('Location: ../bloc3/accueil.php?erreur=' . urlencode('Rôle invalide.'));
    exit;
}

// ── 3. Tenter la connexion via auth.php (avec le rôle) ──────────────────────
$resultat = login($identifiant, $password, $role);

// ── 4. Échec : identifiants incorrects ──────────────────────────────────────
if (!$resultat['succes']) {
    header('Location: ../bloc3/accueil.php?erreur=' . urlencode($resultat['message']));
    exit;
}

// ── 5. Succès : rediriger selon le rôle ─────────────────────────────────────
switch ($role) {
    case 'etudiant':
        header('Location: ../bloc3/espace_etu.php');
        break;
    case 'formateur':
        header('Location: ../bloc3/espace_form.php');
        break;
    case 'admin':
        header('Location: ../bloc3/espace_admin.php');
        break;
}
exit;
