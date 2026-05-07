<!-- actions de l'espace formateur -->
<?php

require_once __DIR__ . '/../config/db.php';

// Associe le formateur connecté à un cours qu'il va dispenser
function dispenserCours(int $id_formateur, int $id_cours): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "UPDATE COURS SET id_formateur = :p_id_formateur 
                               WHERE id_cours = :p_id_cours");

    oci_bind_by_name($stmt, ':p_id_formateur', $id_formateur, -1, SQLT_INT);
    oci_bind_by_name($stmt, ':p_id_cours',     $id_cours,     -1, SQLT_INT);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] dispenserCours() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    if (oci_num_rows($stmt) === 0) {
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Cours introuvable."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Vous dispensez ce cours désormais."];
}