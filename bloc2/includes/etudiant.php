<?php

require_once __DIR__ . '/../config/db.php';

// Retourne les cours auxquels un étudiant est inscrit
function getCoursEtudiant(int $id_etudiant): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "SELECT c.id, c.sujet FROM COURS c
                               INNER JOIN INSCRIPTION i ON c.id = i.id_cours
                               WHERE i.id_etudiant = :p_id_etudiant
                               ORDER BY c.sujet");

    oci_bind_by_name($stmt, ':p_id_etudiant', $id_etudiant, -1, SQLT_INT);

    $ok = oci_execute($stmt, OCI_DEFAULT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] getCoursEtudiant() : " . $e['message']);
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

// Inscrit un étudiant à un cours via PRC_INSCRIPTION_SECURISEE
// Codes d'erreur Oracle :
//   -20002 : cours complet
//   -20003 : cours introuvable
//   ORA-00001 : déjà inscrit (violation PK INSCRIPTION)
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

        // ORA-20002 = cours complet
        if ($e['code'] == 20002) {
            return ['succes' => false, 'message' => "Ce cours est complet."];
        }
        // ORA-20003 = cours introuvable
        if ($e['code'] == 20003) {
            return ['succes' => false, 'message' => "Cours introuvable."];
        }
        // ORA-00001 = violation de clé primaire (déjà inscrit)
        if ($e['code'] == 1) {
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

// Retire l'étudiant d'un cours (désinscription)
function quitterCours(int $id_etudiant, int $id_cours): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "DELETE FROM INSCRIPTION
                               WHERE id_etudiant = :p_id_etudiant
                               AND   id_cours    = :p_id_cours");

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

    if (oci_num_rows($stmt) === 0) {
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Vous n'êtes pas inscrit à ce cours."];
    }

    // Décrémenter le nombre d'inscrits du cours
    $stmt2 = oci_parse($conn, "UPDATE COURS SET nbr_inscrits = nbr_inscrits - 1 WHERE id = :p_id_cours");
    oci_bind_by_name($stmt2, ':p_id_cours', $id_cours, -1, SQLT_INT);
    oci_execute($stmt2, OCI_NO_AUTO_COMMIT);
    oci_free_statement($stmt2);

    oci_commit($conn);
    oci_close($conn);

    return ['succes' => true, 'message' => "Vous avez quitté le cours avec succès."];
}