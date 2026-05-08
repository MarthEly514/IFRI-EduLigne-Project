<?php
$role_requis = 'etudiant';
require_once '../bloc2/includes/guard.php';
require_once '../bloc2/includes/etudiant.php';

// ── Traitement POST : quitter un cours ──────────────────────────────────────
$message = '';
$type_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'quitter') {
    $id_cours = filter_input(INPUT_POST, 'id_cours', FILTER_VALIDATE_INT);
    if ($id_cours) {
        $resultat = quitterCours((int)$session['id'], $id_cours);
        $message = $resultat['message'];
        $type_message = $resultat['succes'] ? 'succes' : 'erreur';
    }
}

// ── Récupérer les cours de l'étudiant connecté ──────────────────────────────
$mesCours = getCoursEtudiant((int)$session['id']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Mes cours</title>
    <link rel="stylesheet" href="all.css">
</head>

<body>

    <nav class="barre-nav">
        <div class="logo">
            <div class="logo-image">
                <img src="img/logo.png" alt="Logo EduLigne">
            </div>
            <span class="logo-texte">EduLigne</span>
        </div>
        <div class="nav-profil">
            <div class="avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                    viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <span class="nom-utilisateur" style="font-weight:600;"><?= htmlspecialchars($session['nom']) ?></span>
        </div>
    </nav>
    <div class="contenu-espace">
        <h2 class="titre-espace">Mes cours</h2>

        <?php if ($message): ?>
            <p style="color:<?= $type_message === 'succes' ? '#38A169' : '#E53E3E' ?>; font-weight:600; margin-bottom:1rem;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <div class="grid-cours" id="grid" <?= empty($mesCours) ? 'style="display:none;"' : '' ?>>
            <?php foreach ($mesCours as $c): ?>
                <div class="carte-cours">
                    <div class="icone-action violet">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                    </div>
                    <p class="titre-action"><?= htmlspecialchars($c['SUJET']) ?></p>
                    <form method="POST" style="margin:0;">
                        <input type="hidden" name="action" value="quitter">
                        <input type="hidden" name="id_cours" value="<?= (int)$c['ID'] ?>">
                        <button class="btn-quitter-cours" type="submit" onclick="return confirm('Quitter ce cours ?');">QUITTER</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="vide" id="vide" <?= !empty($mesCours) ? 'style="display:none;"' : '' ?>>Vous n'êtes inscrit à aucun cours.</p>
    </div>

</body>

</html>