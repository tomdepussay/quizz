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
    <title>Quizz - <?= $_COOKIE['LOGGED_USER'] ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/highscore.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <div class="container">
        <div class="flex-center flex-column">
            <h1 class="finalScores">Vos scores :</h1>
            <ul class="highScoresList">
                <?php
                for ($i = 10; $i > -1; $i = $i - 1):
                    foreach ($user_scores as $user_score):
                        if ($user_score['user_id'] == $_COOKIE['LOGGED_USER_ID'] && $user_score['score'] == $i):?>
                <li class="high-score"><?php echo $categories[$user_score['categorie_id']-1]['name']; ?> - <?php echo $user_score['score']; ?></li>
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