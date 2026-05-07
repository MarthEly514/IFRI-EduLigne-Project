<!-- actions réservées à l'admin -->
<?php

require_once __DIR__ . '/../config/db.php';

// Retourne la liste de tous les étudiants
function getEtudiants(): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "SELECT id_etudiant, nom, prenom, email FROM ETUDIANT ORDER BY nom");
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

    $stmt = oci_parse($conn, "SELECT id_formateur, nom, prenom, email FROM FORMATEUR ORDER BY nom");
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

// Insère un nouvel étudiant dans la base
function ajouterEtudiant(string $nom, string $prenom, string $email, string $password): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "INSERT INTO ETUDIANT (nom, prenom, email, password) 
                               VALUES (:p_nom, :p_prenom, :p_email, :p_password)");

    oci_bind_by_name($stmt, ':p_nom',      $nom,      -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_prenom',   $prenom,   -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_email',    $email,    -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_password', $password, -1, SQLT_CHR);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);

        // ORA-00001 = violation de contrainte unique (email déjà existant)
        if ($e['code'] == 1) {
            return ['succes' => false, 'message' => "Cet email est déjà utilisé."];
        }

        error_log("[EduLigne] ajouterEtudiant() : " . $e['message']);
        return ['succes' => false, 'message' => "Une erreur technique est survenue."];
    }

    oci_commit($conn);
    oci_free_statement($stmt);
    oci_close($conn);

    return ['succes' => true, 'message' => "Étudiant ajouté avec succès."];
}

// Insère un nouveau formateur dans la base
function ajouterFormateur(string $nom, string $prenom, string $email, string $password): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "INSERT INTO FORMATEUR (nom, prenom, email, password) 
                               VALUES (:p_nom, :p_prenom, :p_email, :p_password)");

    oci_bind_by_name($stmt, ':p_nom',      $nom,      -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_prenom',   $prenom,   -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_email',    $email,    -1, SQLT_CHR);
    oci_bind_by_name($stmt, ':p_password', $password, -1, SQLT_CHR);

    $ok = oci_execute($stmt, OCI_NO_AUTO_COMMIT);

    if (!$ok) {
        $e = oci_error($stmt);
        oci_free_statement($stmt);
        oci_close($conn);

        if ($e['code'] == 1) {
            return ['succes' => false, 'message' => "Cet email est déjà utilisé."];
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
function supprimerEtudiant(int $id_etudiant): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "DELETE FROM ETUDIANT WHERE id_etudiant = :p_id_etudiant");

    oci_bind_by_name($stmt, ':p_id_etudiant', $id_etudiant, -1, SQLT_INT);

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
function supprimerFormateur(int $id_formateur): array {
    $conn = getOracleConnection();

    $stmt = oci_parse($conn, "DELETE FROM FORMATEUR WHERE id_formateur = :p_id_formateur");

    oci_bind_by_name($stmt, ':p_id_formateur', $id_formateur, -1, SQLT_INT);

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