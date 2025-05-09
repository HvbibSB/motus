<?php
require_once 'db.php';

// Obtenir tous les scores classés par tentatives (ordre croissant) et par date (ordre décroissant)
$stmt = $pdo->query("SELECT * FROM word ORDER BY attempts ASC, created_at DESC");
$scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des Scores - Motus</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <h1>Tableau des Scores</h1>
        
        <a href="motus.php" class="btn">Retour au jeu</a>
        
        <a href="regles.php" class="btn">Voir les règles</a>

        <?php if (empty($scores)): ?>
            <p>Aucun score enregistré pour le moment.</p>
        <?php else: ?>
            <table class="scores-table">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Joueur</th>
                        <th>Mot</th>
                        <th>Tentatives</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($scores as $index => $score): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($score['player_name']) ?></td>
                            <td><?= strtoupper(htmlspecialchars($score['word'])) ?></td>
                            <td><?= $score['attempts'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($score['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>