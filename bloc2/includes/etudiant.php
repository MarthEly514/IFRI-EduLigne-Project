<!-- actions de l'espace étudiant -->
<?php

require_once __DIR__ . '/../config/db.php';

// Retourne la liste des cours disponibles pour l'étudiant connecté
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

// Inscrit l'étudiant connecté à un cours via PRC_INSCRIPTION_SECURISEE
function inscrireEtudiant(int $id_etudiant, int $id_cours): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "BEGIN PRC_INSCRIPTION_SECURISEE(:p_id_etudiant, :p_id_cours); END;");

    oci_bind_by_name($stmt, ':p_id_etudiant', $id_etudiant, -1, SQLT_INT);
    oci_bind_by_name($stmt, ':p_id_cours',    $id_cours,    -1, SQLT_INT);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);

        if ($e['code'] == 20001) {
            return ['succes' => false, 'message' => "Ce cours est complet."];
        }
        if ($e['code'] == 20002) {
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

// Retire l'étudiant connecté d'un cours
function quitterCours(int $id_etudiant, int $id_cours): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "DELETE FROM INSCRIPTION 
                               WHERE id_etudiant = :p_id_etudiant 
                               AND id_cours = :p_id_cours");

    oci_bind_by_name($stmt, ':p_id_etudiant', $id_etudiant, -1, SQLT_INT);
    oci_bind_by_name($stmt, ':p_id_cours',    $id_cours,    -1, SQLT_INT);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] quitterCours() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    // oci_num_rows() vérifie qu'une ligne a bien été supprimée
    if (oci_num_rows($stmt) === 0) {
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Vous n'êtes pas inscrit à ce cours."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Vous avez quitté le cours avec succès."];
}