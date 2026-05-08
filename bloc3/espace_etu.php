<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Espace Étudiant</title>
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
        <h2 class="titre-espace">Espace étudiant</h2>

        <div class="liste-actions">

            <a href="Edu.php" class="carte-action">
                <div class="icone-action violet">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </div>
                <div class="texte-action">
                    <p class="titre-action">S'inscrire à un cours</p>
                    <p class="sous-titre-action">Rejoindre un nouveau cours</p>
                </div>
            </a>

            <a href="liste_cours.php" class="carte-action">
                <div class="icone-action violet">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                        viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                    </svg>
                </div>
                <div class="texte-action">
                    <p class="titre-action">Voir les cours</p>
                    <p class="sous-titre-action">Consulter les cours que vous avez rejoint</p>
                </div>
            </a>
        </div>

        <a href="deconnexion.php" class="bouton-deconnexion">
            <!-- ICONE LOGOUT -->
            DECONNEXION
        </a>
    </div>

</body>

</html>