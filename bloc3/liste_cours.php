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
            <span class="nom-utilisateur" style="font-weight:600;">Audrey </span>
        </div>
    </nav>
    <div class="contenu-espace">
        <h2 class="titre-espace">Mes cours</h2>

        <div class="grid-cours" id="grid">
            <div class="carte-cours">
                <div class="icone-action violet">
                    <img src="img/books.png" alt="Logo EduLigne" width="25" height="25">
                </div>
                <p class="titre-action">Développement Web</p>
                <button class="btn-quitter-cours" type="button">QUITTER</button>
            </div>
        </div>
        <p class="vide" id="vide">Vous n'êtes inscrit à aucun cours.</p>
    </div>

    <div class="toast" id="toast">Vous vous êtes désinscrit de ce cours.</div>

    <script>
        function checkVide() {
            const grid = document.getElementById('grid');
            const vide = document.getElementById('vide');
            if (grid.querySelectorAll('.carte-cours').length === 0) {
                grid.style.display = 'none';
                vide.style.display = 'block';
            }
        }

        document.querySelectorAll('.btn-quitter-cours').forEach(btn => {
            btn.addEventListener('click', function() {
                const carte = this.closest('.carte-cours');
                carte.style.opacity = '0';
                setTimeout(() => {
                    carte.remove();
                    checkVide();
                }, 300);

                const toast = document.getElementById('toast');
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2500);
            });
        });
    </script>

</body>

</html>