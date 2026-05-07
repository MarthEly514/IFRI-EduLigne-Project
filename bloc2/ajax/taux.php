<!-- endpoint JSON pour le taux en temps réel -->
 <?php

require_once __DIR__ . '/../../includes/inscription.php';

header('Content-Type: application/json');

$id_cours = filter_input(INPUT_GET, 'id_cours', FILTER_VALIDATE_INT);

if (!$id_cours) {
    echo json_encode(['erreur' => 'Paramètre id_cours invalide.']);
    exit;
}

$taux = getTauxRemplissage($id_cours);

if ($taux === null) {
    echo json_encode(['erreur' => 'Impossible de calculer le taux.']);
} else {
    echo json_encode(['taux' => $taux]);
}