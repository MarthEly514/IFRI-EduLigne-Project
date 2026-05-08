<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Accueil</title>
    <link rel="stylesheet" href="all.css">
</head>

<body>

    <div class="page-connexion">
        <div class="carte-connexion">

            <div class="entete">
                <div class="logo-rond">
                    <img src="img/logo.png" alt="logo">
                </div>
                <h1 class="logo-texte">EduLigne</h1>
                <p>Connectez-vous à votre espace</p>
            </div>

            <div class="choix-role">
                <button onclick="setRole('etudiant')" id="btn-etudiant" class="actif">
                    ETUDIANT
                </button>
                <button onclick="setRole('formateur')" id="btn-formateur">
                    FORMATEUR
                </button>
                <button onclick="setRole('admin')" id="btn-admin">
                    ADMIN
                </button>
            </div>

            <form method="POST" action="traitement_connexion.php">
                <input type="hidden" name="role" id="role" value="etudiant">

                <div class="champ">
                    <label>Identifiant</label>
                    <div class="input-icone">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <input type="text" name="identifiant" placeholder="Votre identifiant">
                    </div>
                </div>

                <div class="champ">
                    <label>Mot de passe</label>
                    <div class="input-icone">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <input type="password" name="mot_de_passe" placeholder="Votre mot de passe">
                    </div>
                </div>

                <button type="submit" class="bouton-connexion">SE CONNECTER</button>
            </form>

        </div>
    </div>

    <script>
        function setRole(role) {
            ['etudiant', 'formateur', 'admin'].forEach(r => {
                document.getElementById('btn-' + r).classList.toggle('actif', r === role);
            });
            document.getElementById('role').value = role;
        }
    </script>

</body>

</html>