<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Mes cours dispensés</title>
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
        <h2 class="titre-espace">Mes cours dispensés</h2>

        <div class="grid-cours" id="grid">
             <div class="carte-cours">
                <div class="icone-action violet"><img src="img/books.png" alt="Logo EduLigne" width="25" height="25"></div>
                <p class="titre-action">Développement Web</p>
            </div>
            <div class="carte-cours">
                <div class="icone-action violet"><img src="img/books.png" alt="Logo EduLigne" width="25" height="25"></div>
                <p class="titre-action">Base de données Oracle</p>
            </div>
            <div class="carte-cours">
                <div class="icone-action violet">
                    <img src="img/books.png" alt="Logo EduLigne" width="25" height="25">
                </div>
                <p class="titre-action">Algorithmique</p>
            </div>
        </div>

        <p class="vide" id="vide">Vous ne dispensez aucun cours.</p>
    </div>

</body>

</html>