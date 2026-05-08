<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Liste des cours Admin</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="popup.css">
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
            <span class="nom-utilisateur" style="font-weight:600;">Admin</span>
        </div>
    </nav>

    <div class="contenu-espace">

        <div class="entete-liste">
            <h2 class="titre-espace">Liste des cours</h2>
            <button class="bouton-ajouter">
                + Ajouter un cours
            </button>
        </div>

        <div class="liste-actions">
            
                <div class="carte-cours" style="display:flex; align-items:center; gap:1rem; flex-direction:row;">
                    <div class="icone-action violet">
                        <!-- ICONE LIVRE -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                    </div>
                    <div class="texte-action">
                        <p class="titre-action">Python pour débutants</p>
                        <p class="sous-titre-action">Capacité : 2 places</p>
                    </div>
                    <div class="cercle-taux">
                        <svg viewBox="0 0 44 44" class="svg-taux">
                            <circle cx="22" cy="22" r="18" fill="none" stroke="#E9D8FD" stroke-width="4" />
                            <circle cx="22" cy="22" r="18" fill="none" stroke="#6B46C1" stroke-width="4"
                                stroke-dasharray="113" stroke-dashoffset="0"
                                stroke-linecap="round" />
                        </svg>
                        <span class="texte-taux">50%</span>
                    </div>
                </div>
            <?php  ?>
        </div>

    </div>

    <!-- Modale : Ajouter un cours -->
    <div class="modal-overlay" id="modal-ajouter">
        <div class="modal-boite">
            <div class="modal-entete">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                    </svg>
                    <h3>Ajouter un cours</h3>
                </div>
                <button id="btn-fermer-ajouter" type="button">&times;</button>
            </div>
            <p>Remplissez les informations du nouveau cours.</p>

            <form method="POST" action="ajouter_cours.php">
                <label for="titre-cours">Titre du cours</label>
                <input type="text" id="titre-cours" name="titre" placeholder="Ex: React pour débutants" class="champ-texte" required>

                <label for="capacite-cours">Capacité maximale</label>
                <input type="number" id="capacite-cours" name="capacite_max" placeholder="Ex: 10" class="champ-texte" required>

                <label for="formateur-cours">Formateur</label>
                <select id="formateur-cours" name="id_formateur" required>
                    <option value="" disabled selected>-- Choisir un formateur --</option>
                </select>

                <div class="modal-actions">
                    <button type="button" id="btn-annuler-ajouter">Annuler</button>
                    <button type="submit" class="btn-confirmer">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Ouvrir
        document.querySelector('.bouton-ajouter').addEventListener('click', () => {
            document.getElementById('modal-ajouter').classList.add('active');
        });

        // Fermer
        document.getElementById('btn-fermer-ajouter').addEventListener('click', () => {
            document.getElementById('modal-ajouter').classList.remove('active');
        });

        document.getElementById('btn-annuler-ajouter').addEventListener('click', () => {
            document.getElementById('modal-ajouter').classList.remove('active');
        });

        // Fermer en cliquant dehors
        document.getElementById('modal-ajouter').addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });
    </script>

    <script>
        document.querySelectorAll('.fond-sombre').forEach(el => {
            el.addEventListener('click', function(e) {
                if (e.target === this) this.style.display = 'none';
            });
        });
    </script>

</body>

</html>