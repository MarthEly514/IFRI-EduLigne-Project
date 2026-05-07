<?php

require_once __DIR__ . '/../config/db.php';

function getEtudiants(): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "SELECT id_etudiant, nom, prenom FROM ETUDIANT ORDER BY nom");
    $ok   = oci_execute($stmt, OCI_DEFAULT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] getEtudiants() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return [];
    }

    $etudiants = [];
    oci_fetch_all($stmt, $etudiants, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

    oci_free_statement($stmt);
    oci_close($conn);

    return $etudiants;
}

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

function inscrireEtudiant(int $id_etudiant, int $id_cours): array {
    $conn = getOracleConnection();

    $sql  = "BEGIN PRC_INSCRIPTION_SECURISEE(:p_id_etudiant, :p_id_cours); END;";
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':p_id_etudiant', $id_etudiant, -1, SQLT_INT);
    oci_bind_by_name($stmt, ':p_id_cours',    $id_cours,    -1, SQLT_INT);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);

        if (isset($e['code']) && $e['code'] == 20001) {
            return ['succes' => false, 'message' => "Désolé, ce cours est complet."];
        }

        if (isset($e['code']) && $e['code'] == 20002) {
            return ['succes' => false, 'message' => "Vous êtes déjà inscrit à ce cours."];
        }

        error_log("[EduLigne] inscrireEtudiant() : " . $e['message']);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Inscription enregistrée avec succès !"];
}

function getTauxRemplissage(int $id_cours): ?float {
    $conn = getOracleConnection();

    $sql  = "BEGIN :p_taux := FNC_TAUX_REMPLISSAGE(:p_id_cours); END;";
    $stmt = oci_parse($conn, $sql);

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