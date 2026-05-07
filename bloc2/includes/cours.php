<!-- actions partagées -->
<?php

require_once __DIR__ . '/../config/db.php';

// Retourne la liste de tous les cours disponibles
function getCours(): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "SELECT id_cours, titre, capacite_max FROM COURS ORDER BY titre");
    $ok   = oci_execute($stmt, OCI_DEFAULT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] getCours() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return [];
    }

    $cours = [];
    oci_fetch_all($stmt, $cours, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

    oci_free_statement($stmt);
    oci_close($conn);

    return $cours;
}

// Retourne le pourcentage d'occupation d'un cours via FNC_TAUX_REMPLISSAGE
function getTauxRemplissage(int $id_cours): ?float {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "BEGIN :p_taux := FNC_TAUX_REMPLISSAGE(:p_id_cours); END;");

    $taux = null;
    oci_bind_by_name($stmt, ':p_taux',     $taux,     -1, SQLT_FLT);
    oci_bind_by_name($stmt, ':p_id_cours', $id_cours, -1, SQLT_INT);

    $ok = oci_execute($stmt);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] getTauxRemplissage() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return null;
    }

    oci_free_statement($stmt);
    oci_close($conn);

    return round((float)$taux, 2);
}