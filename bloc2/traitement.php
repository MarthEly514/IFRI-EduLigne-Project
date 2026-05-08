<?php

require_once __DIR__ . '/includes/etudiant.php';

// ── 1. Vérifier que la requête vient bien d'un formulaire POST ──────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../bloc3/inscription_cours.php');
    exit;
}

// ── 2. Récupérer et valider les champs ──────────────────────────────────────
$id_etudiant = filter_input(INPUT_POST, 'etudiant_id', FILTER_VALIDATE_INT);
$id_cours    = filter_input(INPUT_POST, 'cours_id',    FILTER_VALIDATE_INT);

if (!$id_etudiant || !$id_cours) {
    $params = http_build_query([
        'popup'    => 'erreur',
        'etudiant' => (int)($_POST['etudiant_id'] ?? 0),
    ]);
    header('Location: ../bloc3/inscription_cours.php?' . $params);
    exit;
}

// ── 3. Tenter l'inscription via etudiant.php ─────────────────────────────────
$resultat = inscrireEtudiant($id_etudiant, $id_cours);

// ── 4. Rediriger avec le bon popup selon le résultat ─────────────────────────
if ($resultat['succes']) {
    // Popup succès : félicitations
    $popup = 'felicitations';
} else {
    // Distinguer "cours complet" de "déjà inscrit"
    if (strpos($resultat['message'], 'complet') !== false) {
        $popup = 'cours-plein';
    } elseif (strpos($resultat['message'], 'déjà') !== false) {
        $popup = 'deja-inscrit';
    } else {
        $popup = 'erreur';
    }
}

$params = http_build_query([
    'popup'    => $popup,
    'etudiant' => $id_etudiant,   // pour pré-sélectionner l'étudiant au retour
]);

header('Location: ../bloc3/inscription_cours.php?' . $params);
exit;
