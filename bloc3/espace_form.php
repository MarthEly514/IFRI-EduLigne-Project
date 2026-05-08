<?php
$role_requis = 'formateur';
require_once '../bloc2/includes/guard.php';
require_once '../bloc2/includes/cours.php';
require_once '../bloc2/includes/formateur.php';

// ── Traitement POST : dispenser un cours ────────────────────────────────────
$message = '';
$type_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'dispenser') {
    $id_cours = filter_input(INPUT_POST, 'id_cours', FILTER_VALIDATE_INT);
    if ($id_cours) {
        $resultat = dispenserCours((int)$session['id'], $id_cours);
        $message = $resultat['message'];
        $type_message = $resultat['succes'] ? 'succes' : 'erreur';
    }
}

// ── Récupérer tous les cours pour le select ─────────────────────────────────
$listeCours = getCours();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Espace Formateur</title>
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
        <h2 class="titre-espace">Espace formateur</h2>

        <?php if ($message): ?>
            <p style="color:<?= $type_message === 'succes' ? '#38A169' : '#E53E3E' ?>; font-weight:600; margin-bottom:1rem;">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <div class="liste-actions">

            <button class="carte-action" id="btn-dispenser" type="button">
                <div class="icone-action violet">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 3 19 12 5 21 5 3" />
                    </svg>
                </div>
                <div class="texte-action">
                    <p class="titre-action">Dispenser un cours</p>
                    <p class="sous-titre-action">Choisir un cours à enseigner</p>
                </div>
            </button>

            <a href="cours_dispensés.php" class="carte-action">
                <div class="icone-action violet">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6" />
                        <line x1="8" y1="12" x2="21" y2="12" />
                        <line x1="8" y1="18" x2="21" y2="18" />
                        <line x1="3" y1="6" x2="3.01" y2="6" />
                        <line x1="3" y1="12" x2="3.01" y2="12" />
                        <line x1="3" y1="18" x2="3.01" y2="18" />
                    </svg>
                </div>
                <div class="texte-action">
                    <p class="titre-action">Mes cours dispensés</p>
                    <p class="sous-titre-action">Consulter vos cours dispensés</p>
                </div>
            </a>

        </div>

        <a href="deconnexion.php" class="bouton-deconnexion">DECONNEXION</a>
    </div>

    <!-- Modale : Dispenser un cours -->
    <div class="modal-overlay" id="modal-dispenser">
        <div class="modal-boite">
            <div class="modal-entete">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 3 19 12 5 21 5 3" />
                    </svg>
                    <h3>Dispenser un cours</h3>
                </div>
                <button id="btn-fermer-dispenser" type="button">&times;</button>
            </div>
            <p>Sélectionnez le cours que vous souhaitez dispenser.</p>

            <form method="POST">
                <input type="hidden" name="action" value="dispenser">
                <label for="cours-dispenser">Cours</label>
                <select id="cours-dispenser" name="id_cours" required>
                    <option value="" disabled selected>-- Choisir un cours --</option>
                    <?php foreach ($listeCours as $c): ?>
                        <option value="<?= (int)$c['ID'] ?>"><?= htmlspecialchars($c['SUJET']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="modal-actions">
                    <button type="button" id="btn-annuler-dispenser">Annuler</button>
                    <button type="submit" class="btn-confirmer">Confirmer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modalDispenser = document.getElementById('modal-dispenser');
        const closeDispenser = () => modalDispenser.classList.remove('active');

        document.getElementById('btn-dispenser').addEventListener('click', () => modalDispenser.classList.add('active'));
        document.getElementById('btn-fermer-dispenser').addEventListener('click', closeDispenser);
        document.getElementById('btn-annuler-dispenser').addEventListener('click', closeDispenser);
        modalDispenser.addEventListener('click', e => {
            if (e.target === modalDispenser) closeDispenser();
        });
    </script>

</body>

</html>