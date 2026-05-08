<?php

require_once __DIR__ . '/includes/admin.php';

// ── 1. Vérifier que la requête vient bien d'un formulaire POST ──────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../bloc3/inscrire_user.php');
    exit;
}

// ── 2. Récupérer et valider les champs communs ───────────────────────────────
$nom        = trim($_POST['nom']        ?? '');
$prenom     = trim($_POST['prenom']     ?? '');
$password   = trim($_POST['mot_de_passe'] ?? '');
$role       = trim($_POST['role']       ?? '');

if ($nom === '' || $prenom === '' || $password === '' || $role === '') {
    header('Location: ../bloc3/inscrire_user.php?erreur=' . urlencode('Veuillez remplir tous les champs obligatoires.'));
    exit;
}

if (!in_array($role, ['etudiant', 'formateur'])) {
    header('Location: ../bloc3/inscrire_user.php?erreur=' . urlencode('Rôle invalide.'));
    exit;
}

// ── 3. Appeler la bonne fonction selon le rôle ──────────────────────────────
if ($role === 'etudiant') {
    $niveau    = trim($_POST['niveau_academique'] ?? '');
    $specialite = trim($_POST['specialite']       ?? '');
    $resultat  = ajouterEtudiant($nom, $prenom, $niveau, $password, $specialite);
} else {
    $domaine    = trim($_POST['domaine_enseignement'] ?? '');
    $distinction = trim($_POST['distinction']         ?? '');
    $resultat   = ajouterFormateur($nom, $prenom, $domaine, $password, $distinction);
}

// ── 4. Rediriger avec message de succès ou d'erreur ─────────────────────────
if (!$resultat['succes']) {
    header('Location: ../bloc3/inscrire_user.php?erreur=' . urlencode($resultat['message']));
    exit;
}

header('Location: ../bloc3/inscrire_user.php?succes=' . urlencode($resultat['message']));
exit;
