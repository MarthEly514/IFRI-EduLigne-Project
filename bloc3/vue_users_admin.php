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
            <span class="nom-utilisateur" style="font-weight:600;">Admin</span>
        </div>
    </nav>

    <div class="contenu-espace">
        <h2 class="titre-espace">Utilisateurs</h2>

        <!-- Étudiants -->
        <p class="section-label">Étudiants</p>
        <div class="liste-utilisateurs">
            <div class="carte-utilisateur">
                <div class="avatar-utilisateur">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <span class="nom-utilisateur-carte">Audrey</span>
                <button class="btn-supprimer" type="button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14H6L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4h6v2" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Formateurs -->
        <p class="section-label" style="margin-top:1.5rem;">Formateurs</p>
        <div class="liste-utilisateurs">
            <div class="carte-utilisateur">
                <div class="avatar-utilisateur">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <span class="nom-utilisateur-carte">Jean</span>
                <button class="btn-supprimer" type="button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14H6L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4h6v2" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-supprimer').forEach(btn => {
            btn.addEventListener('click', function() {
                const carte = this.closest('.carte-utilisateur');
                carte.style.opacity = '0';
                setTimeout(() => carte.remove(), 300);
            });
        });
    </script>

</body>

</html>