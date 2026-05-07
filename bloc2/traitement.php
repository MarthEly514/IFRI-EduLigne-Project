<!-- POST du formulaire Bloc 3 -->
 <?php

require_once __DIR__ . '/includes/inscription.php';

$message      = '';
$type_message = '';
$etudiants    = getEtudiants();
$cours        = getCours();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
    $id_cours    = filter_input(INPUT_POST, 'id_cours',    FILTER_VALIDATE_INT);

    if (!$id_etudiant || !$id_cours) {
        $message      = "Veuillez sélectionner un étudiant et un cours.";
        $type_message = 'erreur';
    } else {
        $resultat     = inscrireEtudiant($id_etudiant, $id_cours);
        $message      = $resultat['message'];
        $type_message = $resultat['succes'] ? 'succes' : 'erreur';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>EduLigne – Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container" style="max-width:600px;">

    <h2 class="mb-4">Inscription à un cours</h2>

    <?php if ($message !== '') : ?>
        <div class="alert <?= $type_message === 'succes' ? 'alert-success' : 'alert-danger' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <div class="mb-3">
            <label for="id_etudiant" class="form-label">Étudiant</label>
            <select name="id_etudiant" id="id_etudiant" class="form-select" required>
                <option value="">-- Sélectionnez un étudiant --</option>
                <?php foreach ($etudiants as $etu) : ?>
                    <option value="<?= $etu['ID_ETUDIANT'] ?>">
                        <?= htmlspecialchars($etu['NOM'] . ' ' . $etu['PRENOM']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_cours" class="form-label">Cours</label>
            <select name="id_cours" id="id_cours" class="form-select" required
                    onchange="afficherTaux(this.value)">
                <option value="">-- Sélectionnez un cours --</option>
                <?php foreach ($cours as $c) : ?>
                    <option value="<?= $c['ID_COURS'] ?>">
                        <?= htmlspecialchars($c['TITRE']) ?> (<?= $c['CAPACITE_MAX'] ?> places)
                    </option>
                <?php endforeach; ?>
            </select>
            <div id="taux-affichage" class="form-text mt-1"></div>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>

    </form>
</div>

<script>
function afficherTaux(idCours) {
    const zone = document.getElementById('taux-affichage');
    if (!idCours) { zone.innerHTML = ''; return; }

    fetch('ajax/taux.php?id_cours=' + idCours)
        .then(r => r.json())
        .then(data => {
            if (data.erreur) { zone.innerHTML = ''; return; }
            const t = data.taux;
            if (t >= 100)     zone.innerHTML = '<span class="text-danger">🔴 Cours complet (100%)</span>';
            else if (t >= 75) zone.innerHTML = '<span class="text-warning">🟡 Presque complet (' + t + '%)</span>';
            else              zone.innerHTML = '<span class="text-success">🟢 Places disponibles (' + t + '%)</span>';
        });
}
</script>

</body>
</html>