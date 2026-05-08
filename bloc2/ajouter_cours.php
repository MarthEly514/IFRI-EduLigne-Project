<?php

require_once __DIR__ . '/config/db.php';

// ── 1. Vérifier POST ────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../bloc3/vue_cours_admin.php');
    exit;
}

// ── 2. Récupérer et valider les champs ───────────────────────────────────────
$sujet        = trim($_POST['sujet']        ?? '');
$capacite_max = filter_input(INPUT_POST, 'capacite_max', FILTER_VALIDATE_INT);
$id_formateur = filter_input(INPUT_POST, 'id_formateur', FILTER_VALIDATE_INT);

if ($sujet === '' || !$capacite_max || !$id_formateur) {
    header('Location: ../bloc3/vue_cours_admin.php?erreur=' . urlencode('Veuillez remplir tous les champs.'));
    exit;
}

// ── 3. Appeler PRC_CREER_COURS ───────────────────────────────────────────────
$conn = getOracleConnection();

$stmt = oci_parse($conn, "BEGIN PRC_CREER_COURS(:p_statut, :p_sujet, :p_heure_debut, :p_heure_fin, :p_date_debut, :p_formateur_id, :p_capacite_max); END;");

$statut      = 'Disponible';
$heure_debut = '';
$heure_fin   = '';
$date_debut  = '';

oci_bind_by_name($stmt, ':p_statut',       $statut,       -1, SQLT_CHR);
oci_bind_by_name($stmt, ':p_sujet',        $sujet,        -1, SQLT_CHR);
oci_bind_by_name($stmt, ':p_heure_debut',  $heure_debut,  -1, SQLT_CHR);
oci_bind_by_name($stmt, ':p_heure_fin',    $heure_fin,    -1, SQLT_CHR);
oci_bind_by_name($stmt, ':p_date_debut',   $date_debut,   -1, SQLT_CHR);
oci_bind_by_name($stmt, ':p_formateur_id', $id_formateur, -1, SQLT_INT);
oci_bind_by_name($stmt, ':p_capacite_max', $capacite_max, -1, SQLT_INT);

$ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

if (!$ok) {
    $e = oci_error($stmt);
    error_log("[EduLigne] ajouter_cours : " . $e['message']);
    oci_free_statement($stmt);
    oci_close($conn);
    header('Location: ../bloc3/vue_cours_admin.php?erreur=' . urlencode('Erreur lors de la création du cours.'));
    exit;
}

oci_commit($conn);
oci_free_statement($stmt);
oci_close($conn);

header('Location: ../bloc3/vue_cours_admin.php?succes=' . urlencode('Cours ajouté avec succès.'));
exit;
