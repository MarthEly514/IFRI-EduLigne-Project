<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Inscrire un utilisateur</title>
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

    <div class="champ">
        <label>Login</label>
        <div class="input-icone">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <input type="text" placeholder="Nom d'utilisateur">
        </div>
    </div>

    <div class="champ">
        <label>Mot de passe</label>
        <div class="input-icone">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input type="password" placeholder="Mot de passe">
        </div>
    </div>

    <div class="champ">
        <label>Rôle</label>
        <div class="input-icone">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--violet)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <select class="champ-select">
                <option value="" disabled selected>-- Choisir un rôle --</option>
                <option value="etudiant">Étudiant</option>
                <option value="formateur">Formateur</option>
            </select>
        </div>
    </div>

    <button class="bouton-connexion" style="margin-top:1.5rem;">Inscrire</button>
</div>

</body>
</html>