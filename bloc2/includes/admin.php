<?php

require_once __DIR__ . '/../config/db.php';

// Retourne la liste de tous les étudiants
function getEtudiants(): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "SELECT id, nom, prenom FROM ETUDIANT ORDER BY nom");
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

// Retourne la liste de tous les formateurs
function getFormateurs(): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "SELECT id, nom, prenom FROM FORMATEUR ORDER BY nom");
    $ok   = oci_execute($stmt, OCI_DEFAULT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] getFormateurs() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return [];
    }

    $formateurs = [];
    oci_fetch_all($stmt, $formateurs, 0, -1, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);

    oci_free_statement($stmt);
    oci_close($conn);

    return $formateurs;
}

// Insère un nouvel étudiant via la procédure Oracle PRC_CREER_ETUDIANT
function ajouterEtudiant(string $nom, string $prenom, string $niveau, string $password, string $specialite): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "BEGIN PRC_CREER_ETUDIANT(:p_nom, :p_prenom, :p_niveau, :p_password, :p_specialite); END;");

    oci_bind_by_name($stmt, ':p_nom',       $nom,       -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_prenom',    $prenom,    -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_niveau',    $niveau,    -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_password',  $password,  -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_specialite',$specialite,-1, SQLT_CHR);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);

        // ORA-00001 = violation de contrainte unique (nom déjà existant)
        if ($e['code'] == 1) {
            return ['succes' => false, 'message' => "Cet identifiant est déjà utilisé."];
        }

        error_log("[EduLigne] ajouterEtudiant() : " . $e['message']);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Étudiant ajouté avec succès."];
}

// Insère un nouveau formateur via la procédure Oracle PRC_CREER_FORMATEUR
function ajouterFormateur(string $nom, string $prenom, string $domaine, string $password, string $distinction): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "BEGIN PRC_CREER_FORMATEUR(:p_nom, :p_prenom, :p_domaine, :p_password, :p_distinction); END;");

    oci_bind_by_name($stmt, ':p_nom',        $nom,        -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_prenom',     $prenom,     -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_domaine',    $domaine,    -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_password',   $password,   -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_distinction',$distinction,-1, SQLT_CHR);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);

        if ($e['code'] == 1) {
            return ['succes' => false, 'message' => "Cet identifiant est déjà utilisé."];
        }

        error_log("[EduLigne] ajouterFormateur() : " . $e['message']);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Formateur ajouté avec succès."];
}

// Supprime un étudiant de la base
function supprimerEtudiant(int $id): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "DELETE FROM ETUDIANT WHERE id = :p_id");

    oci_bind_by_name($stmt, ':p_id', $id, -1, SQLT_INT);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] supprimerEtudiant() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    if (oci_num_rows($stmt) === 0) {
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Étudiant introuvable."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Étudiant supprimé avec succès."];
}

// Supprime un formateur de la base
function supprimerFormateur(int $id): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "DELETE FROM FORMATEUR WHERE id = :p_id");

    oci_bind_by_name($stmt, ':p_id', $id, -1, SQLT_INT);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        error_log("[EduLigne] supprimerFormateur() : " . $e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    if (oci_num_rows($stmt) === 0) {
        oci_free_statement($stmt);
        oci_close($conn);
        return ['succes' => false, 'message' => "Formateur introuvable."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Formateur supprimé avec succès."];
}