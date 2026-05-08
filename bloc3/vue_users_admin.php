<?php
$role_requis = 'admin';
require_once '../bloc2/includes/guard.php';
require_once '../bloc2/includes/admin.php';

// ── Traitement POST : suppression d'un utilisateur ──────────────────────────
$message = '';
$type_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        if ($action === 'supprimer_etudiant') {
            $resultat = supprimerEtudiant($id);
        } elseif ($action === 'supprimer_formateur') {
            $resultat = supprimerFormateur($id);
        }

        if (isset($resultat)) {
            $message = $resultat['message'];
            $type_message = $resultat['succes'] ? 'succes' : 'erreur';
        }
    }
}

// ── Récupération des données depuis Oracle ──────────────────────────────────
$etudiants  = getEtudiants();
$formateurs = getFormateurs();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Utilisateurs</title>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <span class="nom-utilisateur" style="font-weight:600;"><?= htmlspecialchars($session['nom']) ?></span>
        </div>
    </nav>

    <div class="contenu-espace">
        <h2 class="titre-espace">Utilisateurs</h2>

        <?php if ($message): ?>
            <p style="color:<?= $type_message === 'succes' ? '#38A169' : '#E53E3E' ?>; font-weight:600; margin-bottom:1rem;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <!-- Étudiants -->
        <p class="section-label">Étudiants</p>
        <div class="liste-utilisateurs">
            <?php if (empty($etudiants)): ?>
                <p style="color:#999; font-style:italic;">Aucun étudiant inscrit.</p>
            <?php else: ?>
                <?php foreach ($etudiants as $etu): ?>
                    <div class="carte-utilisateur">
                        <div class="avatar-utilisateur">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <span class="nom-utilisateur-carte"><?= htmlspecialchars($etu['NOM'] . ' ' . $etu['PRENOM']) ?></span>
                        <form method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="supprimer_etudiant">
                            <input type="hidden" name="id" value="<?= (int)$etu['ID'] ?>">
                            <button class="btn-supprimer" type="submit" onclick="return confirm('Supprimer cet étudiant ?');">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14H6L5 6" />
                                    <path d="M10 11v6M14 11v6" />
                                    <path d="M9 6V4h6v2" />
                                </svg>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Formateurs -->
        <p class="section-label" style="margin-top:1.5rem;">Formateurs</p>
        <div class="liste-utilisateurs">
            <?php if (empty($formateurs)): ?>
                <p style="color:#999; font-style:italic;">Aucun formateur inscrit.</p>
            <?php else: ?>
                <?php foreach ($formateurs as $form): ?>
                    <div class="carte-utilisateur">
                        <div class="avatar-utilisateur">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <span class="nom-utilisateur-carte"><?= htmlspecialchars($form['NOM'] . ' ' . $form['PRENOM']) ?></span>
                        <form method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="supprimer_formateur">
                            <input type="hidden" name="id" value="<?= (int)$form['ID'] ?>">
                            <button class="btn-supprimer" type="submit" onclick="return confirm('Supprimer ce formateur ?');">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14H6L5 6" />
                                    <path d="M10 11v6M14 11v6" />
                                    <path d="M9 6V4h6v2" />
                                </svg>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>