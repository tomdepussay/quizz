<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
} catch (Exception $e) {
    die('Erreur : ' . $e -> getMessage());
};


$categoriesStatement = $db -> prepare('SELECT * FROM categories');
$categoriesStatement->execute();
$categories = $categoriesStatement->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz v2</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include_once('header.php') ?>
    <!-- NOT LOGIN -->

    <?php if(!isset($_COOKIE['LOGGED_USER'])): ?>
    <div class="container">
        <div class="flex-center flex-column">
            <h1>Bienvenue, veuillez-vous connecté avant de commencer.</h1>
            <a href="login.php" class="btn">Cliquer ici pour vous connecter</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- LOGIN -->
    <?php if(isset($_COOKIE['LOGGED_USER'])): ?>
    <div class="container">
        <div id='welcome_message' class="flex-center flex-column">
            <h1>Bienvenue <?=$_COOKIE["LOGGED_USER"]?></h1>
        </div>

        <div id="gameboard" class="flex-center">
            <?php foreach ($categories as $categorie): ?>
            <div class="flex-center flex-column">
                <h1><?= $categorie['name']; ?></h1>
                <a href="game.php?categorie=<?= $categorie['categorie_id'];?>" class="btn">Jouer !</a>
                <a href="highscore.php?categorie=<?= $categorie['categorie_id']; ?>" class="btn highlight">Meilleur Score</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif;?>


</body>
</html>