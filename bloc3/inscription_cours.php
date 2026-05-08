<?php
$role_requis = 'etudiant';
require_once '../bloc2/includes/guard.php';
require_once '../bloc2/includes/admin.php';
require_once '../bloc2/includes/cours.php';

$etudiants = getEtudiants();
$listeCours = getCours();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLigne - Inscription à un cours</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="popup.css">
</head>

<!-- POPUP SUCCÈS -->
<div id="felicitations" class="fond-sombre">
    <div class="boite" style="overflow:hidden;">

        <!-- Confettis CSS -->
        <div class="pluie-confettis">
            <span style="--x:10%; --delai:0s;   --couleur:#6B46C1;"></span>
            <span style="--x:20%; --delai:0.3s; --couleur:#F6AD55;"></span>
            <span style="--x:35%; --delai:0.6s; --couleur:#FC8181;"></span>
            <span style="--x:50%; --delai:0.1s; --couleur:#68D391;"></span>
            <span style="--x:65%; --delai:0.4s; --couleur:#6B46C1;"></span>
            <span style="--x:75%; --delai:0.2s; --couleur:#F6AD55;"></span>
            <span style="--x:88%; --delai:0.5s; --couleur:#FC8181;"></span>
            <span style="--x:5%;  --delai:0.7s; --couleur:#68D391;"></span>
            <span style="--x:93%; --delai:0.8s; --couleur:#6B46C1;"></span>
            <span style="--x:42%; --delai:0.9s; --couleur:#F6AD55;"></span>
        </div>

        <div style="padding:2rem;">
            <div class="gros-emoji">🎉</div>
            <h2 class="titre-popup" style="color:#6B46C1;">Félicitations !</h2>
            <div class="barre" style="background:#6B46C1;"></div>
            <p class="message">Votre inscription a été confirmée avec succès. Bonne formation !</p>
            <button class="bouton-fermer" onclick="fermer('felicitations')">Continuer</button>
        </div>

    </div>
</div>

<!-- POPUP COURS REMPLI -->
<div id="cours-plein" class="fond-sombre">
    <div class="boite" style="border-top: 5px solid #E53E3E;">
        <div class="gros-emoji">🙃</div>
        <h2 class="titre-popup" style="color:#E53E3E;">Cours complet</h2>
        <div class="barre" style="background:#E53E3E;"></div>
        <p class="message">Désolé, ce cours est déjà rempli. Choisissez-en un autre pour continuer.</p>
        <button class="bouton-fermer" style="background:#553c9a;" onclick="fermer('cours-plein')">Choisir un autre cours</button>
    </div>
</div>

<!-- POPUP DÉJÀ INSCRIT -->
<div id="deja-inscrit" class="fond-sombre">
    <div class="boite" style="border-top: 5px solid #F6AD55;">
        <div class="gros-emoji">🤔</div>
        <h2 class="titre-popup" style="color:#F6AD55;">Déjà inscrit !</h2>
        <div class="barre" style="background:#F6AD55;"></div>
        <p class="message">Vous êtes déjà inscrit à ce cours. Choisissez-en un autre !</p>
        <button class="bouton-fermer" style="background:#F6AD55;" onclick="fermer('deja-inscrit')">OK</button>
    </div>
</div>



<body>

    <!-- ==================== BARRE DE NAVIGATION ==================== -->
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

    <!-- ==================== SECTION PRINCIPALE ==================== -->
    <section class="section-principale">
        <div class="conteneur">
            <div class="carte-principale">
                <div class="grille-principale">



                    <!-- Colonne droite - Formulaire -->
                    <div class="colonne-droite">
                        <div class="conteneur-formulaire">
                            <h2 class="titre-formulaire">Inscription à un cours</h2>
                            <div class="ligne-formulaire"></div>
                            <p class="texte-formulaire">
                                Rejoignez nos cours spécialisés et développez vos compétences avec les meilleurs formateurs.
                            </p>

                            <form class="formulaire-cours" action="../bloc2/traitement.php" method="POST">
                                <!-- Étudiant -->
                                <div class="groupe-champ">
                                    <label class="etiquette">Étudiant</label>
                                    <div class="enveloppe-select">
                                        <div class="icone-champ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>
                                        </div>
                                        <select class="champ-select" name="etudiant_id" id="select-etudiant">
                                            <option value="0">----</option>
                                            <?php foreach ($etudiants as $etu): ?>
                                                <option value="<?= (int)$etu['ID'] ?>"><?= htmlspecialchars($etu['NOM'] . ' ' . $etu['PRENOM']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="fleche-select">
                                            <img src="img/drop.png" alt="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Cours -->
                                <div class="groupe-champ">
                                    <label class="etiquette">Cours</label>
                                    <div class="enveloppe-select">
                                        <div class="icone-champ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="#6B46C1" stroke-width="2.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                            </svg>
                                        </div>
                                        <select class="champ-select" name="cours_id">
                                            <option value="0">----</option>
                                            <?php foreach ($listeCours as $c): ?>
                                                <option value="<?= (int)$c['ID'] ?>"><?= htmlspecialchars($c['SUJET']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="fleche-select">
                                            <img src="img/drop.png" alt="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Bouton -->
                                <button type="submit" class="bouton-inscription">
                                    <span>S'INSCRIRE MAINTENANT</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        function ouvrir(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function fermer(id) {
            document.getElementById(id).style.display = 'none';
        }

        document.querySelectorAll('.fond-sombre').forEach(el => {
            el.addEventListener('click', function(e) {
                if (e.target === this) fermer(this.id);
            });
        });
    </script>

    <script>
        // Lecture des paramètres GET transmis par traitement.php
        window.onload = function() {
            var popup   = <?= json_encode($_GET['popup']    ?? '') ?>;
            var etudiant = <?= json_encode($_GET['etudiant'] ?? '') ?>;

            if (popup) ouvrir(popup);

            if (etudiant) {
                var sel = document.getElementById('select-etudiant');
                if (sel) sel.value = etudiant;
            }
        }
    </script>
</body>

</html>