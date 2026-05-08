<?php
$role_requis = 'formateur';
require_once '../bloc2/includes/guard.php';
require_once '../bloc2/includes/formateur.php';

// ── Récupérer les cours dispensés par le formateur connecté ──────────────────
$mesCours = getCoursFormateur((int)$session['id']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Mes cours dispensés</title>
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
        <h2 class="titre-espace">Mes cours dispensés</h2>

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
                    <p class="sous-titre-action"><?= (int)$c['NBR_INSCRITS'] ?> / <?= (int)$c['CAPACITE_MAX'] ?> inscrits</p>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="vide" id="vide" <?= !empty($mesCours) ? 'style="display:none;"' : '' ?>>Vous ne dispensez aucun cours.</p>
    </div>

</body>

</html>