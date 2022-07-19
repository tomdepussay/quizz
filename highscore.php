<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
} catch (Exception $e) {
    die('Erreur : ' . $e -> getMessage());
};

$categoriesStatement = $db -> prepare('SELECT * FROM categories');
$usersStatement = $db -> prepare('SELECT * FROM users');
$user_scoresStatement = $db -> prepare('SELECT * FROM user_scores');
$categoriesStatement->execute();
$usersStatement->execute();
$user_scoresStatement->execute();
$categories = $categoriesStatement->fetchAll();
$users = $usersStatement->fetchAll();
$user_scores = $user_scoresStatement->fetchAll(); 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $categories[$_GET['categorie']-1]['name'] ?> - Meilleur Score</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/highscore.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <div class="container">
        <div class="flex-column flex-center highscores">
            <h1 class="finalScores">Tous les scores :</h1>
            <ul class="highScoresList">
                <?php
                for ($i = 10; $i > -1; $i = $i - 1):
                    foreach ($user_scores as $user_score):
                        if ($user_score['categorie_id'] == $_GET['categorie'] && $user_score['score'] == $i):?>
                <li class="high-score"><?php echo $users[$user_score['user_id']-1]['pseudo']; ?> - <?php echo $user_score['score']; ?></li>
                <?php
                endif; 
                endforeach; 
                endfor;?>
            </ul>
            <a href="index.php" class="btn">Retour au menu !</a>
        </div>
    </div>
</body>
</html>