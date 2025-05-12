<?php
// Démarrage de la session pour maintenir la cohérence avec les autres pages
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Règles du Motus</title>
    <link rel="stylesheet" href="regles.css">
</head>
<body>
    <div class="container">
        <h1>Règles du Motus</h1>
        
        <div class="rules-content">
            <h2>Comment jouer ?</h2>
            <p>Le but du jeu est de trouver le mot secret en un minimum de tentatives.</p>
            
            <div class="rule-section">
                <h3>Déroulement du jeu</h3>
                <ul>
                    <li>Le mot à deviner est choisi aléatoirement parmi une liste prédéfinie</li>
                    <li>La première lettre du mot vous est donnée</li>
                    <li>Vous disposez de <strong>6 tentatives</strong> pour trouver le mot</li>
                    <li>Chaque proposition doit être un mot de la même longueur que le mot secret</li>
                    <li>La première lettre de votre proposition doit correspondre à celle du mot secret</li>
                </ul>
            </div>
            
            <div class="rule-section">
                <h3>Indications visuelles</h3>
                <ul>
                    <li>
                        <span class="letter-example correct">A</span> - La lettre est correcte et bien placée
                    </li>
                    <li>
                        <span class="letter-example present">B</span> - La lettre est correcte mais mal placée
                    </li>
                    <li>
                        <span class="letter-example">C</span> - La lettre n'est pas dans le mot
                    </li>
                </ul>
                <p>Les lettres ne sont marquées qu'une seule fois. Si un mot contient deux 'A' mais que vous n'en proposez qu'un, seul le premier sera pris en compte.</p>
            </div>
            
            <div class="rule-section">
                <h3>Score</h3>
                <p>Votre score est calculé en fonction du nombre de tentatives utilisées :</p>
                <ul>
                    <li>1 tentative : 6 points</li>
                    <li>2 tentatives : 5 points</li>
                    <li>...</li>
                    <li>6 tentatives : 1 point</li>
                </ul>
                <p>Vous pouvez enregistrer votre score avec votre nom après une partie gagnée.</p>
            </div>
        </div>
        
        <div class="actions">
            <a href="motus.php" class="btn">Compris !</a>
            <!-- <a href="score.php" class="btn">Voir les scores</a> -->
        </div>
    </div>
</body>
</html>
