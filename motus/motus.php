<?php
session_start();
require_once 'db.php';

// Charger des mots à partir du fichier JSON
$wordsJson = file_get_contents('mots.json');
$wordsArray = json_decode($wordsJson, true);
$words = array_column($wordsArray, 'mot');

// Sélectionner un mot aléatoire s'il n'a pas déjà été défini lors de la session
if (!isset($_SESSION['secret_word'])) {
    $randomIndex = array_rand($words);
    $_SESSION['secret_word'] = strtolower($words[$randomIndex]);
    $_SESSION['attempts'] = 6;
    $_SESSION['guesses'] = [];
    $_SESSION['game_over'] = false;
    $_SESSION['won'] = false;
}

$secretWord = $_SESSION['secret_word'];
$attemptsLeft = $_SESSION['attempts'];
$guesses = $_SESSION['guesses'];
$gameOver = $_SESSION['game_over'];
$won = $_SESSION['won'];

// Processus de devinette
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$gameOver) {
    if (isset($_POST['guess'])) {
        $guess = strtolower(trim($_POST['guess']));
        
        // Valider la longueur de la devinette
        if (strlen($guess) !== strlen($secretWord)) {
            $error = "Votre proposition doit faire " . strlen($secretWord) . " lettres.";
        } elseif ($guess[0] !== $secretWord[0]) {
            $error = "La première lettre doit être '" . strtoupper($secretWord[0]) . "'.";
        } else {
            // Devinettes valables
            $_SESSION['attempts']--;
            $attemptsLeft = $_SESSION['attempts'];
            
            // Ajouter aux devinettes
            $guesses[] = $guess;
            $_SESSION['guesses'] = $guesses;
            
            // Vérifier si l'on a gagné
            if ($guess === $secretWord) {
                $_SESSION['won'] = true;
                $_SESSION['game_over'] = true;
                $won = true;
                $gameOver = true;
            } elseif ($attemptsLeft <= 0) {
                $_SESSION['game_over'] = true;
                $gameOver = true;
            }
        }
    }
}

// Réinitialiser le jeu si demandé
if (isset($_GET['reset'])) {
    session_destroy();
    header("Location: motus.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motus</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container">
        <h1>Motus</h1>
        
        <?php if ($gameOver && $won): ?>
            <div class="result success">
                <h2>Félicitations !</h2>
                <p>Vous avez trouvé le mot "<strong><?= strtoupper($secretWord) ?></strong>" en <?= 6 - $attemptsLeft ?> tentative(s).</p>
                <form action="motus.php" method="post" class="save-score">
                    <input type="text" name="player_name" placeholder="Votre nom" required>
                    <input type="hidden" name="attempts" value="<?= 6 - $attemptsLeft ?>">
                    <button type="submit" class="btn">Enregistrer mon score</button>
                </form>
                <a href="motus.php?reset=1" class="btn">Nouvelle partie</a>
            </div>
        <?php elseif ($gameOver): ?>
            <div class="result error">
                <h2>C'est raté !</h2>
                <p>Le mot était "<strong><?= strtoupper($secretWord) ?></strong>".</p>
                <a href="motus.php?reset=1" class="btn">Nouvelle partie</a>
            </div>
        <?php else: ?>
            <div class="game-info">
                <p>Tentatives restantes: <strong><?= $attemptsLeft ?></strong></p>
                <p>Mot à deviner: <strong><?= strlen($secretWord) ?></strong> lettres</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="post" class="guess-form">
                <input type="text" name="guess" 
                       maxlength="<?= strlen($secretWord) ?>" 
                       minlength="<?= strlen($secretWord) ?>"
                       pattern="[A-Za-z]{<?= strlen($secretWord) ?>}"
                       title="Entrez un mot de <?= strlen($secretWord) ?> lettres"
                       required
                       autofocus>
                <button type="submit">Valider</button>
            </form>
        <?php endif; ?>
        
        <div class="guesses-container">
            <?php foreach ($guesses as $guess): ?>
                <div class="guess-row">
                    <?php
                    $secretLetters = str_split($secretWord);
                    $guessLetters = str_split($guess);
                    
                    for ($i = 0; $i < strlen($secretWord); $i++):
                        $letter = strtoupper($guessLetters[$i]);
                        $class = '';
                        
                        if ($guessLetters[$i] === $secretLetters[$i]) {
                            $class = 'correct';
                        } elseif (in_array($guessLetters[$i], $secretLetters)) {
                            $class = 'present';
                        }
                        ?>
                        <span class="letter <?= $class ?>"><?= $letter ?></span>
                    <?php endfor; ?>
                </div>
            <?php endforeach; ?>
            
            <?php if (!$gameOver): ?>
                <div class="guess-row">
                    <span class="letter correct"><?= strtoupper($secretWord[0]) ?></span>
                    <?php for ($i = 1; $i < strlen($secretWord); $i++): ?>
                        <span class="letter empty">_</span>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <a href="score.php" class="btn">Voir les scores</a>
        <a href="index.php" class="btn">Voir les règles</a>
    </div>
    
    <script src="script.js"></script>
</body>
</html>

<?php
// Sauvegarder le score en cas de victoire et de soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_name']) && $won) {
    $playerName = trim($_POST['player_name']);
    $attemptsUsed = (int)$_POST['attempts'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO word (word, attempts, player_name) VALUES (?, ?, ?)");
        $stmt->execute([$secretWord, $attemptsUsed, $playerName]);
    } catch (PDOException $e) {
        // Traiter l'erreur silencieusement ou l'enregistrer
    }
    
    // Redirection pour éviter la resoumission du formulaire
    header("Location: motus.php");
    exit;
}
?>
