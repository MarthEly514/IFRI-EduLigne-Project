<?php
$role_requis = 'admin';
require_once '../bloc2/includes/guard.php';
$erreur = htmlspecialchars($_GET['erreur'] ?? '');
$succes = htmlspecialchars($_GET['succes'] ?? '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Inscrire un utilisateur</title>
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
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <span class="nom-utilisateur" style="font-weight:600;">Admin</span>
    </div>
</nav>

<div class="contenu-espace">
    <h2 class="titre-espace">Inscrire un utilisateur</h2>

    <?php if ($succes): ?>
        <p style="color:#38A169; font-weight:600; margin-bottom:1rem;"><?= $succes ?></p>
    <?php endif; ?>
    <?php if ($erreur): ?>
        <p style="color:#E53E3E; font-weight:600; margin-bottom:1rem;"><?= $erreur ?></p>
    <?php endif; ?>

    <form method="POST" action="../bloc2/traitement_inscrire_user.php" id="form-inscription">

        <!-- Rôle -->
        <div class="champ">
            <label>Rôle</label>
            <div class="input-icone">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <select class="champ-select" name="role" id="select-role" required onchange="toggleChamps()">
                    <option value="" disabled selected>-- Choisir un rôle --</option>
                    <option value="etudiant">Étudiant</option>
                    <option value="formateur">Formateur</option>
                </select>
            </div>
        </div>

        <!-- Nom -->
        <div class="champ">
            <label>Identifiant (nom)</label>
            <div class="input-icone">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <input type="text" name="nom" placeholder="Identifiant de connexion" required>
            </div>
        </div>

        <!-- Prénom -->
        <div class="champ">
            <label>Prénom</label>
            <div class="input-icone">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <input type="text" name="prenom" placeholder="Prénom" required>
            </div>
        </div>

        <!-- Mot de passe -->
        <div class="champ">
            <label>Mot de passe</label>
            <div class="input-icone">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>
        </div>

        <!-- Champs spécifiques ÉTUDIANT -->
        <div id="champs-etudiant" style="display:none;">
            <div class="champ">
                <label>Niveau académique</label>
                <div class="input-icone">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                    <input type="text" name="niveau_academique" placeholder="Ex: Licence 2, Master 1...">
                </div>
            </div>
            <div class="champ">
                <label>Spécialité</label>
                <div class="input-icone">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8v4l3 3"/>
                    </svg>
                    <input type="text" name="specialite" placeholder="Ex: Informatique, Gestion...">
                </div>
            </div>
        </div>

        <!-- Champs spécifiques FORMATEUR -->
        <div id="champs-formateur" style="display:none;">
            <div class="champ">
                <label>Domaine d'enseignement</label>
                <div class="input-icone">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                    <input type="text" name="domaine_enseignement" placeholder="Ex: Développement Web, IA...">
                </div>
            </div>
            <div class="champ">
                <label>Distinction</label>
                <div class="input-icone">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="6"/>
                        <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                    <input type="text" name="distinction" placeholder="Ex: Docteur, Expert certifié...">
                </div>
            </div>
        </div>

        <button type="submit" class="bouton-connexion" style="margin-top:1.5rem;">Inscrire</button>

    </form>
</div>

<script>
    function toggleChamps() {
        var role = document.getElementById('select-role').value;
        document.getElementById('champs-etudiant').style.display  = (role === 'etudiant')  ? 'block' : 'none';
        document.getElementById('champs-formateur').style.display = (role === 'formateur') ? 'block' : 'none';
    }
</script>

</body>
</html>