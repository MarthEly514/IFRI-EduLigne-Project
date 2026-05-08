<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Espace Formateur</title>
    <link rel="stylesheet" href="Edu.css">
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
            <span class="nom-utilisateur" style="font-weight:600;">Audrey </span>
        </div>
    </nav>

    <div class="contenu-espace">
        <h2 class="titre-espace">Espace formateur</h2>

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
            <label for="cours-dispenser">Cours</label>
            <select id="cours-dispenser" required>
                <option value="" disabled selected>-- Choisir un cours --</option>
            </select>
            <div class="modal-actions">
                <button type="button" id="btn-annuler-dispenser">Annuler</button>
                <button type="button" class="btn-confirmer">Confirmer</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast-dispenser">Vous dispensez maintenant ce cours.</div>

    <script>
        const modalDispenser = document.getElementById('modal-dispenser');
        const closeDispenser = () => modalDispenser.classList.remove('active');

        document.getElementById('btn-dispenser').addEventListener('click', () => modalDispenser.classList.add('active'));
        document.getElementById('btn-fermer-dispenser').addEventListener('click', closeDispenser);
        document.getElementById('btn-annuler-dispenser').addEventListener('click', closeDispenser);
        modalDispenser.addEventListener('click', e => {
            if (e.target === modalDispenser) closeDispenser();
        });

        document.querySelector('#modal-dispenser .btn-confirmer').addEventListener('click', function() {
            if (document.getElementById('cours-dispenser').value === '') return;
            closeDispenser();
            const toast = document.getElementById('toast-dispenser');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        });
    </script>

</body>

</html>